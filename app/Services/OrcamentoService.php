<?php

namespace App\Services;

use Carbon\CarbonImmutable;

class OrcamentoService {

    public function calcular(array $dados) {
        $hoje = CarbonImmutable::now();
        $dataAtivacao = $hoje->addDays(50);
        $ultimoDiaDoAno = $dataAtivacao->endOfYear();
        $mesesRestantesPrimeiroAno = $dataAtivacao->diffInMonths($ultimoDiaDoAno) + 1;
        $anoAtualAtivacao = $dataAtivacao->year;

        $dadosProjetar = [
            "preco" => (float) $dados['precoTotal'],
            "usoRedeDecimal" => (float) (float) round((($dados['percentagemUsoRede'] ?? 80) / 100), 2),
            "anoAtualAtivacao" => (int) $anoAtualAtivacao,
            "degradacaoAnual" => (float) $this->calcularDegradacaoModulos($dados),
            "mesesRestantesPrimeiroAno" => (int) $mesesRestantesPrimeiroAno,
            "energiaMediaGerada" => (float) $dados['energiaGeradaMed']
        ];
        $tarifas = $this->calcularTarifas($dados);
        $estimativasProjeto = $this->projetar25Anos($dadosProjetar, $tarifas);

        return [
            'bnb' => ($dados['orcamentoBNB'] ?? false),
            'cliente' => [
                'nome' => $dados['nome'],
                'cpf_cnpj' => $dados['cpf_cnpj'],
                'cidade' => $dados['cidade'],
                'estado' => $dados['estado'],
            ],
            'datas' => [
                'emissao' => $hoje->format('d/m/Y'),
                'previsao_ativacao' => $dataAtivacao->format('d/m/Y'),
            ],
            'resumo_sistema' => [
                'potencia_total' => ($dados['potenciaModulo'] * $dados['numeroModulos']) / 1000 . " kWp",
                'modulos' => [
                    'fabricante' => $dados['fabricanteModulo'],
                    'modelo' => $dados['modeloModulo'],
                    'quantidade' => $dados['numeroModulos'],
                    'potencia' => $dados['potenciaModulo'] . " W",
                    'peso' => $dados['pesoModulo'] . "kg",
                    'dimensoes' => $dados['dimensaoModuloAltura'] . ' x ' . $dados['dimensaoComprimento'] . ' x ' . 
                    $dados['dimensaoEspessura'] . ' m',
                    'taxa_degradacao_anual_modulos' => round($dadosProjetar['degradacaoAnual'] * 100, 4) . "%",
                    'garantia' => $dados['garantiaFisicaModulo'] . ' anos para problemas fisíco. ' . $dados['garantiaEficienciaModulo'] . 
                    ' anos de eficiência energética (' . $dados['perdaEficienciaModulo'] . '%).'
                ],
                'inversor' => [
                    'fabricante' => $dados['fabricanteInversor'],
                    'modelo' => $dados['modeloInversor'],
                    'quantidade' => $dados['numeroInversores'],
                    'potencia' => $dados['potenciaInversor'] . " kW",
                    'peso' => $dados['pesoInversor'] . " kg",
                    'dimensoes' => $dados['dimensaoInversor'],
                    'garantia' => $dados['garantiaInversor'] . ' anos para problemas fisíco.'
                ],                
                "geracao" => [
                    "jan" => $dados['energiaGeradaJan'],
                    "fev" => $dados['energiaGeradaFev'],
                    "mar" => $dados['energiaGeradaMar'],
                    "abr" => $dados['energiaGeradaAbr'],
                    "mai" => $dados['energiaGeradaMai'],
                    "jun" => $dados['energiaGeradaJun'],
                    "jul" => $dados['energiaGeradaJul'],
                    "ago" => $dados['energiaGeradaAgo'],
                    "set" => $dados['energiaGeradaSet'],
                    "out" => $dados['energiaGeradaOut'],
                    "nov" => $dados['energiaGeradaNov'],
                    "dez" => $dados['energiaGeradaDez'],
                    "med" => $dados['energiaGeradaMed'],
                ],
                'area_sistema' => round(($dados['dimensaoModuloAltura'] * $dados['dimensaoComprimento'] * $dados['numeroModulos']), 2),
                'investimento' => [
                    'valor' => $dados['precoTotal'],
                    'kit_fotovoltaico' => $dados['precoKitFotovoltaico'],
                    'servico' => round(($dados['precoTotal'] - $dados['precoKitFotovoltaico']), 2),
                ],
            ],
            'estimativas' => $estimativasProjeto,
        ];
    }

    private function calcularTarifas(array $dados) : array {
        $tarifakWh = (float) $dados['tarifa_kwh']; 
        $tarifaTUSD = (float) $dados['tarifaTUSD']; 
        $tarifaFioBSemImposto = (float) ($dados['tarifaFioBSemImposto'] ?? (262.26/1000));
        $tarifaTUSDSemImposto = (float) ($dados['tarifaTUSDSemImposto'] ?? (432.60/1000));
        
        $percentualFioB = ($tarifaFioBSemImposto/$tarifaTUSDSemImposto);
        $tarifaFioB = $tarifaTUSD*$percentualFioB;

        $valorLimiteIluminacaoPublica = (float) $dados['valorLimiteIluminacaoPublica'];

        $inflacaoEnergiaAnual = ((float) ($dados['inflacao'] ?? 4)) / 100;

        return [
            "tarifakWh" => (float) $tarifakWh,
            "tarifaTUSD" => (float) $tarifaTUSD,
            "tarifaFioB" => (float) $tarifaFioB,
            "valorLimiteIluminacaoPublica" => (float) $valorLimiteIluminacaoPublica,
            "inflacaoEnergiaAnual" => (float) $inflacaoEnergiaAnual         
        ];
    }

    private function calcularDegradacaoModulos(array $dados) : float {
        $perdaTotalDecimal = (float) (($dados['perdaEficienciaModulo'] ?? 20) / 100);
        $tempoAnos = (int) ($dados['tempoPerdaEficienciaModulo'] ?? 25);
        $degradacaoAnual = (float) ($perdaTotalDecimal / ($tempoAnos - 1));

        return $degradacaoAnual;
    }

    private function calcularIluminacaoPublica(float $consumoKwh, float $valorTarifa, float $valorLimiteIluminacaoPublica): float {
        $calculado = ($consumoKwh * $valorTarifa) * 0.15;
        $limite = $valorLimiteIluminacaoPublica;

        return ($calculado > $limite) ? $limite : $calculado;
    }

    private function calcularEstimativasAnuaisTarifa($tarifa, $inflacao, $expoente) : float {
        return (float) round(($tarifa * pow((1 + $inflacao), $expoente)), 8);
    }

    private function calcularProjecaoCustoMensalComSFCR(
        $tarifaTusdEstimadaAno, $projecaoGeracaoMensal, $usoRedeDecimal, $fatorTrasicaoFioB, 
        $tarifaFioBEstimadaAno, $iluminacaoPublica) {
        return round(((($tarifaTusdEstimadaAno * ($projecaoGeracaoMensal * $usoRedeDecimal)) - 
        (($tarifaTusdEstimadaAno - ($fatorTrasicaoFioB * $tarifaFioBEstimadaAno)) * ($projecaoGeracaoMensal * 
        $usoRedeDecimal))) + $iluminacaoPublica), 2);
    }

    private function calcularPayback($paybackPorMes) : string {
        $paybackPorAno = round($paybackPorMes/12, 2);
        $paybackQuantidadeAno = (int) $paybackPorAno;
        $paybackQuantidadeMes = (int) ceil(($paybackPorAno - $paybackQuantidadeAno) * 12);
        $paybackDescritivo = $paybackQuantidadeAno . " ano(s) e " . $paybackQuantidadeMes . " mês(es).";

        return $paybackDescritivo;
    }

    private function projetar25Anos($dadosProjetar, $tarifas) : array {
        $projecaoGeracaoMensal = $projecaoCustoMensalSemSistema = $projecaoCustoMensalComSistema = 
        $projecaoEconomiaMensalComSistema = $projecaoEconomiaAnualComSistema = $projecaoBalancoFinanceiro = [];
        $contagemAno = $paybackPorMes = 0;
        $balancoPayback = $balancoFinanceiroAtualizado = round(- $dadosProjetar['preco'], 2);
        $anoAtualAtivacao = $dadosProjetar['anoAtualAtivacao'];

        for ($ano = $anoAtualAtivacao; $ano <= ($anoAtualAtivacao + 24); $ano++) {
            $fatorTrasicaoFioB = match ($ano) {
                2025 => 0.45,
                2026 => 0.6,
                2027 => 0.75,
                2028 => 0.9,
                default => 1.0,
            };

            $mesesRestantesAno = match ($ano) {
                $anoAtualAtivacao => $dadosProjetar['mesesRestantesPrimeiroAno'],                
                default => 12,
            };

            $tarifaKwhEstimadaAno[$ano] = $this->calcularEstimativasAnuaisTarifa(
                $tarifas["tarifakWh"], $tarifas["inflacaoEnergiaAnual"], $contagemAno
            );
            $tarifaTusdEstimadaAno[$ano] = $this->calcularEstimativasAnuaisTarifa(
                $tarifas["tarifaTUSD"], $tarifas["inflacaoEnergiaAnual"], $contagemAno
            );
            $tarifaFioBEstimadaAno[$ano] = $this->calcularEstimativasAnuaisTarifa(
                $tarifas["tarifaFioB"], $tarifas["inflacaoEnergiaAnual"], $contagemAno
            );
            $iluminacaoPublica[$ano] = $this->calcularIluminacaoPublica(
                $dadosProjetar['energiaMediaGerada'], 
                $tarifaKwhEstimadaAno[$ano], 
                $tarifas["valorLimiteIluminacaoPublica"]
            );
            
            $projecaoGeracaoMensal[$ano] = round((($dadosProjetar['energiaMediaGerada']) * (1 - ($dadosProjetar['degradacaoAnual'] * 
            ($contagemAno)))), 2);
            $projecaoCustoMensalSemSistema[$ano] = round((($projecaoGeracaoMensal[$ano] * $tarifaKwhEstimadaAno[$ano]) + 
            ($iluminacaoPublica[$ano])), 2);
            $projecaoCustoMensalComSistema[$ano] = $this->calcularProjecaoCustoMensalComSFCR($tarifaTusdEstimadaAno[$ano], 
            $projecaoGeracaoMensal[$ano], $dadosProjetar['usoRedeDecimal'], $fatorTrasicaoFioB, 
            $tarifaFioBEstimadaAno[$ano], $iluminacaoPublica[$ano]);
            $projecaoEconomiaMensalComSistema[$ano] = round(($projecaoCustoMensalSemSistema[$ano] - 
            $projecaoCustoMensalComSistema[$ano]), 2);

            $projecaoGeracaoAnual[$ano] = round($projecaoGeracaoMensal[$ano] * $mesesRestantesAno, 2); 
            $projecaoCustoAnualSemSistema[$ano] = round($projecaoCustoMensalSemSistema[$ano] * $mesesRestantesAno, 2);
            $projecaoCustoAnualComSistema[$ano] = round($projecaoCustoMensalComSistema[$ano] * $mesesRestantesAno, 2);
            $projecaoEconomiaAnualComSistema[$ano] = round($projecaoEconomiaMensalComSistema[$ano] * $mesesRestantesAno, 2);
            $projecaoBalancoFinanceiro[$ano] = round($projecaoEconomiaAnualComSistema[$ano] + $balancoFinanceiroAtualizado, 2);
            
            for($mes = 1; $mes <= $mesesRestantesAno; $mes++){
                if ($balancoPayback >= 0){
                    break;
                }else{
                    $balancoPayback += $projecaoEconomiaMensalComSistema[$ano];
                    $paybackPorMes++;
                }
            }
            
            $balancoFinanceiroAtualizado = $projecaoBalancoFinanceiro[$ano];
            
            $contagemAno++;
        }

        $paybackDescritivo = $this->calcularPayback(($paybackPorMes));

        return [
            'anual' => [
                'geracao_estimada_anual' => $projecaoGeracaoAnual,
                'custo_cosern_sem_sfcr_anual' => $projecaoCustoAnualSemSistema,
                'custo_cosern_com_sfcr_anual' => $projecaoCustoAnualComSistema,
                'economia_com_sfcr_anual' => $projecaoEconomiaAnualComSistema,
            ],
            'mensal' => [                
                'geracao_estimada_mensal' => $projecaoGeracaoMensal,
                'custo_cosern_sem_sfcr_mensal' => $projecaoCustoMensalSemSistema,
                'custo_cosern_com_sfcr_mensal' => $projecaoCustoMensalComSistema,
                'economia_com_sfcr_mensal' => $projecaoEconomiaMensalComSistema,
            ],
            'tarifas' => [                
                'tarifa_kwh_anual' => $tarifaKwhEstimadaAno,
                'tarifa_tusd_anual' => $tarifaTusdEstimadaAno,
                'tarifa_fio_b_anual' => $tarifaFioBEstimadaAno,
                'tarifa_tusd_anual' => $tarifaTusdEstimadaAno,
                'iluminacao_publica_anual' => $iluminacaoPublica,
                'inflacao_anual' => $tarifas['inflacaoEnergiaAnual']*100,
                'uso_rede_concessionaria' => $dadosProjetar['usoRedeDecimal']*100
            ],
            'payback_descritivo' => $paybackDescritivo,
            'balanco_financeiro_anual' => $projecaoBalancoFinanceiro,
        ];
    }
}