<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrcamentoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;

class OrcamentoController extends Controller
{
    public function store(Request $request, OrcamentoService $service)
    {
        // Validação rigorosa dos dados
        $dados = $request->validate([
            'nome' => 'required|string',
            'cpf_cnpj' => 'nullable|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
            'energiaGeradaMed' => 'required|numeric',
            'energiaGeradaJan' => 'required|numeric',
            'energiaGeradaFev' => 'required|numeric',
            'energiaGeradaMar' => 'required|numeric',
            'energiaGeradaAbr' => 'required|numeric',
            'energiaGeradaMai' => 'required|numeric',
            'energiaGeradaJun' => 'required|numeric',
            'energiaGeradaJul' => 'required|numeric',
            'energiaGeradaAgo' => 'required|numeric',
            'energiaGeradaSet' => 'required|numeric',
            'energiaGeradaOut' => 'required|numeric',
            'energiaGeradaNov' => 'required|numeric',
            'energiaGeradaDez' => 'required|numeric',
            'fabricanteModulo' => 'required|string',
            'modeloModulo' => 'required|string',
            'dimensaoModuloAltura' => 'required|numeric',
            'dimensaoComprimento' => 'required|numeric',
            'dimensaoEspessura' => 'required|numeric',
            'pesoModulo' => 'required|numeric',
            'perdaEficienciaModulo' => 'nullable|numeric',
            'tempoPerdaEficienciaModulo' => 'nullable|integer',
            'garantiaFisicaModulo' => 'required|numeric',
            'garantiaEficienciaModulo' => 'required|numeric',
            'potenciaModulo' => 'required|numeric',
            'numeroModulos' => 'required|integer',
            'fabricanteInversor' => 'required|string',
            'modeloInversor' => 'required|string',
            'dimensaoInversor' => 'required|string',
            'pesoInversor' => 'required|numeric',
            'garantiaInversor' => 'required|numeric',
            'potenciaInversor' => 'required|numeric',
            'numeroInversores' => 'required|integer',
            'tarifa_kwh' => 'required|numeric',
            'tarifaTUSD' => 'required|numeric',
            'tarifaTUSDSemImposto' => 'nullable|numeric',
            'tarifaFioBSemImposto' => 'nullable|numeric',
            'valorLimiteIluminacaoPublica' => 'required|numeric',
            'inflacao' => 'nullable|numeric',
            'precoTotal' => 'required|numeric',
            'precoKitFotovoltaico' => 'required|numeric',
            'percentagemUsoRede' => 'nullable|numeric',
            'orcamentoBNB' => 'nullable|bool',
        ]);

        $resultado = $service->calcular($dados);

        try{
            $pdf = Pdf::loadView('pdf.orcamento', $resultado);
    
            // Para testar no navegador:
            return $pdf->stream('Proposta (' . $resultado["resumo_sistema"]["potencia_total"] . ') - ' . $dados['nome'] . '.pdf');
            // Para baixar direto:
            //return $pdf->download('proposta.pdf');
        }catch(Exception $e){    
            return response()->json($resultado);
        }

    }
}