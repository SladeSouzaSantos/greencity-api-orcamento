<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <style>
            @include('pdf.style')            
        </style>
    </head>
    <body>
        <header>
            <table>
                <tr style="border: none;">
                    <td class="header-logo">
                        <img class="logo" src="{{ public_path('images/logo.png') }}">                        
                        <div style="display: inline-block; vertical-align: middle; margin-left: 10px; text-align: left;">
                            <div class="brand-name">Greencity</div>
                            <div class="brand-subtext">Sustainable Energy</div>
                        </div>
                    </td>
                    <td style="border: none; width: 40%; text-align: right; vertical-align: middle;">
                        <span style="color: #2d5a27; font-weight: bold; font-size: 11pt;">PROPOSTA COMERCIAL</span><br>
                        <small style="color: #666;">{{ date('d/m/Y') }}</small>
                    </td>
                </tr>
            </table>
            <div style="width: 100%; height: 2px; background-color: #2d5a27; margin-top: 10px;"></div>
        </header>

        <div class="section-title">Informações do Cliente</div>
        <table class="table-data">
            <tr>
                <th style="width: 30%;">Nome</th>
                <td>{{ $cliente['nome'] }}</td>
            </tr>
            <tr>
                <th>Consumo Médio</th>
                <td>{{ $cliente['consumo_medio'] ?? '1500' }} kWh/mês</td>
            </tr>
            <tr>
                <th>Localização</th>
                <td>{{ $cliente['cidade'] }}/{{ $cliente['estado'] }}</td>
            </tr>
        </table>

        <div class="section-title">Descrição da Usina</div>
        <table class="table-data">
            <tr>
                <th>Potência do Sistema</th>
                <td>{{ $resumo_sistema['potencia_total'] }}</td>
                <th>Área Ocupada</th>
                <td>{{ $resumo_sistema['area_estimada'] ?? '46.6' }} m²</td>
            </tr>
            <tr>
                <th>Geração Média Mensal</th>
                <td colspan="3">{{ number_format($estimativas['mensal']['media_geracao'] ?? 1451.8, 1, ',', '.') }} kWh/mês</td>
            </tr>
        </table>

        <div class="section-title">Composição do Sistema</div>
        <table class="columns-container" style="border: none;">
            <tr>
                <td class="column-left" style="border: none;">
                    <table class="table-equipment">
                        <thead>
                            <tr>
                                <th colspan="2">Módulos Fotovoltaicos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="label-cell">Fabricante</td>
                                <td>{{ $resumo_sistema['modulos']['fabricante'] }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Modelo</td>
                                <td>{{ $resumo_sistema['modulos']['modelo'] }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Potência</td>
                                <td>{{ $resumo_sistema['modulos']['potencia'] }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Quantidade</td>
                                <td>{{ $resumo_sistema['modulos']['quantidade'] }} unidades</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Dimensões</td>
                                <td>{{ $resumo_sistema['modulos']['dimensoes'] }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Garantia</td>
                                <td>{{ $resumo_sistema['modulos']['garantia'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td class="column-right" style="border: none;">
                    <table class="table-equipment">
                        <thead>
                            <tr>
                                <th colspan="2">Inversor / Microinversor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="label-cell">Fabricante</td>
                                <td>{{ $resumo_sistema['inversor']['fabricante'] }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Modelo</td>
                                <td>{{ $resumo_sistema['inversor']['modelo'] }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Potência</td>
                                <td>{{ $resumo_sistema['inversor']['potencia'] }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Quantidade</td>
                                <td>{{ $resumo_sistema['inversor']['quantidade'] }} unidade(s)</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Dimensões</td>
                                <td>{{ $resumo_sistema['inversor']['dimensoes'] }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Garantia</td>
                                <td>{{ $resumo_sistema['inversor']['garantia'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

        <div class="section-title">Investimento Turn Key (Chave na Mão)</div>
        <div class="highlight-box" style="padding: 20px; border: 1px solid #2d5a2775; background-color: #fff;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 60%; vertical-align: middle; border: none; text-align: left;">
                        <span style="font-size: 10pt; color: #595959; text-transform: uppercase; letter-spacing: 1pt;">Valor Total do Sistema</span><br>
                        <span style="font-size: 24pt; font-weight: bold; color: #2d5a27;">
                            R$ {{ number_format($resumo_sistema['investimento']['valor'], 2, ',', '.') }}
                        </span>
                    </td>

                    <td style="width: 40%; vertical-align: middle; border: none; text-align: right;">
                        <div style="
                            display: inline-block;
                            width: 160pt;
                            border: 1.5pt solid #2d5a27; 
                            border-radius: 12pt; 
                            padding: 12px; 
                            background-color: #fcfcfc;
                            text-align: center;
                        ">
                            <strong style="color: #2d5a27; font-size: 9pt; text-transform: uppercase;">Retorno Médio</strong><br>
                            <span style="font-size: 13pt; font-weight: bold; color: #333;">
                                {{ $estimativas['payback_descritivo'] }}
                            </span>
                        </div>
                    </td>
                </tr>
            </table>

            <div style="border-top: 1px solid #2d5a2775; margin-top: 15px; padding-top: 10px; text-align: center;">
                <span style="font-size: 8pt; color: #888; font-style: italic;">
                    * Estão inclusos: Projeto, Homologação, Instalação e 1 ano de Garantia de Serviço Greencity.
                </span>
            </div>
        </div>

        <div class="page-break"></div>

        <div class="section-title">Detalhamento dos Custos</div>
        <table class="table-data" style="text-align: center;">
            <thead>
                <tr>
                    <th>Especificação</th>
                    <th>Qtd</th>
                    <th>Preço Unitário</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($bnb) && $bnb == true)
                    {{-- VISÃO PARA FINANCIAMENTO BNB (DETALHADA) --}}
                    <tr>
                        <td style="text-align: left;">Módulos Fotovoltaicos</td>
                        <td>{{ $resumo_sistema['modulos']['quantidade'] }}</td>
                        <td>R$ {{ number_format(($resumo_sistema['investimento']['kit_fotovoltaico'] * 0.6) / $resumo_sistema['modulos']['quantidade'], 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($resumo_sistema['investimento']['kit_fotovoltaico'] * 0.6, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Inversor / Microinversor</td>
                        <td>{{ $resumo_sistema['inversor']['quantidade'] }}</td>
                        <td>R$ {{ number_format(($resumo_sistema['investimento']['kit_fotovoltaico'] * 0.4) / $resumo_sistema['inversor']['quantidade'], 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($resumo_sistema['investimento']['kit_fotovoltaico'] * 0.4, 2, ',', '.') }}</td>
                    </tr>
                @else
                    {{-- VISÃO PADRÃO (SIMPLIFICADA) --}}
                    <tr>
                        <td style="text-align: left;">Kit Fotovoltaico</td>
                        <td>1</td>
                        <td>R$ {{ number_format($resumo_sistema['investimento']['kit_fotovoltaico'], 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($resumo_sistema['investimento']['kit_fotovoltaico'], 2, ',', '.') }}</td>
                    </tr>
                @endif

                {{-- SERVIÇOS APARECE EM AMBOS --}}
                <tr>
                    <td style="text-align: left;">Serviços (Projeto, Instalação e Insumos)</td>
                    <td>1</td>
                    <td>R$ {{ number_format($resumo_sistema['investimento']['servico'], 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($resumo_sistema['investimento']['servico'], 2, ',', '.') }}</td>
                </tr>

                {{-- TOTALIZADOR FINAL --}}
                <tr style="font-weight: bold; background-color: #f4f4f4;">
                    <td style="text-align: center;">VALOR TOTAL DA PROPOSTA</td>
                    <td colspan="3" >R$ {{ number_format($resumo_sistema['investimento']['valor'], 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">Geração Mensal Estimada (kWh)</div>
        <div class="chart-area">
            @php
                // Buscamos o array de geração e removemos a média ('med') para não distorcer o gráfico
                $geracaoMensal = $resumo_sistema['geracao'];
                unset($geracaoMensal['med']); 
                
                // Descobrimos o valor máximo para escalar as barras proporcionalmente
                $valorMaximo = max($geracaoMensal);
                $alturaGrafico = 100; // altura máxima em pixels
            @endphp

            @foreach($geracaoMensal as $mes => $valor)
                @php
                    // Cálculo da altura proporcional
                    $alturaBarra = ($valor / $valorMaximo) * $alturaGrafico;
                @endphp
                
                <div class="bar-wrapper">
                    <span class="bar-value">{{ number_format($valor, 0, '', '') }}</span>
                    <div class="bar-fill" style="height: {{ $alturaBarra }}px;"></div>
                    <span class="bar-label">{{ $mes }}</span>
                </div>
            @endforeach
        </div>
        <p style="font-size: 8pt; text-align: center; margin-top: 20px; color: #666;">
            * Média mensal estimada: <strong>{{ number_format($resumo_sistema['geracao']['med'], 2, ',', '.') }} kWh</strong>
        </p>

        <div class="section-title">Procedimentos & Prazos</div>
        <table class="table-timeline">
            <thead>
                <tr>
                    <th style="width: 45%;">Serviço / Etapa</th>
                    <th style="width: 25%;">Responsável</th>
                    <th style="width: 30%;">Prazo Estimado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Visita Técnica/Comercial</td>
                    <td><span class="tag-responsavel">Empresa/Cliente</span></td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Aprovação da proposta e assinatura do contrato</td>
                    <td><span class="tag-responsavel">Cliente</span></td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Desenvolvimento do projeto</td>
                    <td><span class="tag-responsavel">GREENCITY</span></td>
                    <td>Até 10 dias úteis</td>
                </tr>
                <tr>
                    <td>Aprovação de acesso junto à concessionária</td>
                    <td><span class="tag-responsavel">GREENCITY/Conc.</span></td>
                    <td>Até 20 dias úteis</td>
                </tr>
                <tr>
                    <td>Instalação dos equipamentos</td>
                    <td><span class="tag-responsavel">GREENCITY</span></td>
                    <td>Até 6 dias úteis</td>
                </tr>
                <tr>
                    <td>Vistoria Técnica pela concessionária</td>
                    <td><span class="tag-responsavel">Concessionária</span></td>
                    <td>Até 7 dias úteis</td>
                </tr>
                <tr>
                    <td>Instalação do medidor bidirecional</td>
                    <td><span class="tag-responsavel">Concessionária</span></td>
                    <td>Até 7 dias úteis</td>
                </tr>
            </tbody>
        </table>
        <div class="total-box">
            TOTAL ESTIMADO PARA ENTRADA EM FUNCIONAMENTO: Até 50 dias úteis*
        </div>
        <p style="font-size: 7pt; color: #888; margin-top: 5px; font-style: italic;">
            * Os prazos das etapas que dependem da concessionária podem sofrer variações conforme a demanda do órgão local.
        </p>

        <div class="page-break"></div>

        <div class="section-title">Projeção Financeira Anual (25 Anos)</div>
        <table class="table-data" style="font-size: 8pt;">
            <thead>
                <tr>
                    <th>Ano</th>
                    <th>Tarifa (kWh)</th>
                    <th>Tarifa (Fio B)</th>
                    <th>Produção</th>
                    <th>Custo S/ Solar</th>
                    <th>Custo C/ Solar</th>
                    <th>Balanço Acumulado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estimativas['anual']['geracao_estimada_anual'] as $ano => $geracao)
                @php
                    $valorBalanco = $estimativas['balanco_financeiro_anual'][$ano];
                    // Define a cor: Vermelho para negativo, Verde Greencity para positivo
                    $corBalanco = $valorBalanco < 0 ? '#c0392b' : '#2d5a27';
                    // Formata o valor absoluto para não vir com o sinal nativo do PHP
                    $valorFormatado = number_format(abs($valorBalanco), 2, ',', '.');
                    // Monta a string: Se negativo, o sinal vem antes do R$
                    $textoBalanco = $valorBalanco < 0 ? "- R$ " . $valorFormatado : "R$ " . $valorFormatado;
                @endphp
                <tr>
                    <td>{{ $ano }}</td>
                    <td>R$ {{ number_format($estimativas['tarifas']['tarifa_kwh_anual'][$ano] ?? 0, 4, ',', '.') }}</td>
                    <td>R$ {{ number_format($estimativas['tarifas']['tarifa_fio_b_anual'][$ano] ?? 0, 4, ',', '.') }}</td>
                    <td>{{ number_format($geracao, 0, ',', '.') }} kWh</td>
                    <td>R$ {{ number_format($estimativas['anual']['custo_cosern_sem_sfcr_anual'][$ano], 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($estimativas['anual']['custo_cosern_com_sfcr_anual'][$ano], 2, ',', '.') }}</td>
                    <td style="font-weight: bold; color: {{ $corBalanco }};">
                        {{ $textoBalanco }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 10px;">
            <p style="font-size: 8pt; font-style: italic; margin-bottom: 2px;">
                * Projeção baseada em taxa de inflação energética de {{ $estimativas['tarifas']['inflacao_anual'] ?? '4.0' }}% ao ano.
            </p>
            <p style="font-size: 8pt; font-style: italic;">
                * Considerou-se o uso da rede elétrica da concessionária em {{ $estimativas['tarifas']['uso_rede_concessionaria'] ?? '80.0' }}% do tempo durante o dia.
            </p>
        </div>

        <div class="page-break"></div>

        <div class="section-title">Projeção Financeira Mensal (25 Anos)</div>
        <table class="table-data" style="font-size: 8pt;">
            <thead>
                <tr>
                    <th>Ano</th>
                    <th>Produção</th>
                    <th>Custo S/ Solar</th>
                    <th>Custo C/ Solar</th>
                    <th>Economia</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estimativas['mensal']['geracao_estimada_mensal'] as $ano => $geracao)
                <tr>
                    <td>{{ $ano }}</td>
                    <td>{{ number_format($geracao, 0, ',', '.') }} kWh</td>
                    <td>R$ {{ number_format($estimativas['mensal']['custo_cosern_sem_sfcr_mensal'][$ano], 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($estimativas['mensal']['custo_cosern_com_sfcr_mensal'][$ano], 2, ',', '.') }}</td>
                    <td style="font-weight: bold;">R$ {{ number_format($estimativas['mensal']['economia_com_sfcr_mensal'][$ano], 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p style="font-size: 8pt; font-style: italic;">
            * Projeção baseada em taxa de inflação energética de {{ $estimativas['tarifas']['inflacao_anual'] ?? '4.0' }}% ao ano.
        </p>
        <p style="font-size: 8pt; font-style: italic;">
            * Considerou-se o uso da rede elétrica da concessionária em {{ $estimativas['tarifas']['uso_rede_concessionaria'] ?? '80.0' }}% do tempo durante o dia.
        </p>

        <div class="page-break"></div>

        <div class="section-title">Formas de Pagamento</div>
        <div class="payment-methods">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="width: 50%; vertical-align: top; border: none;">
                        <strong style="font-size: 9pt; color: #666; text-transform: uppercase;">Pagamento Direto</strong>
                        <p style="font-size: 10pt; color: #333; margin-top: 5px;">
                            • Cartões de Débito e Crédito<br>
                            • Cartões de Crédito (Até 21x)<br>
                            • Boleto Bancário<br>
                            • Transferência Bancária (TED | PIX)
                        </p>
                    </td>
                    <td style="width: 50%; vertical-align: top; border: none;">
                        <strong style="font-size: 9pt; color: #666; text-transform: uppercase;">Linhas de Financiamento Sugeridas:</strong>
                        <div style="margin-top: 8px;">
                            <span class="financing-item">
                                Banco do Nordeste - Programa FNE SOL
                            </span>
                            <p style="font-size: 8pt; color: #666; margin-top: 5px;">
                                <em>* Condições sujeitas à análise de crédito e disponibilidade do fundo. Podemos auxiliar em todo o processo de documentação técnica para o banco.</em>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer-contact-box">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="width: 50%; vertical-align: top; border: none;">
                        <div class="section-title" style="margin-top: 0;">Validade da Proposta</div>
                        <p style="font-size: 10pt; color: #333;">
                            Esta proposta é válida por <strong>7 dias úteis</strong> a partir de sua emissão ({{ date('d/m/Y') }}).
                        </p>
                        <p style="font-size: 8pt; color: #666; font-style: italic; margin-top: 10px;">
                            * Após este prazo, os valores e condições técnica podem estar sujeitos a alteração conforme disponibilidade de estoque e variação cambial.
                        </p>
                    </td>

                    <td style="width: 50%; vertical-align: top; border: none; text-align: right;">
                        <div class="section-title" style="margin-top: 0;">Contato</div>
                        
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #2d5a27; font-size: 11pt;">GREENCITY SUSTAINABLE ENERGY</strong><br>
                            <span style="font-size: 9pt; color: #666;">CNPJ: 36.297.546/0001-01</span>
                        </div>

                        <div class="contact-item"><strong>Telefone:</strong> (84) 9 9173-0465</div>
                        <div class="contact-item"><strong>E-mail:</strong> greencity@outlook.com.br</div>
                        <div class="contact-item"><strong>Website:</strong> www.greencity.net.br</div>
                    </td>
                </tr>
            </table>
        </div>
        
        <footer>
            <p style="text-align: center; font-size: 7pt; color: #aaa;">
                Greencity Sustainable Energy © 2020 - Gerado via Greencity API
            </p> 
            <p style="text-align: center; font-size: 7pt; color: #aaa;">
                www.greencity.net.br | greencity@outlook.com.br | (84) 9 9173-0465 | (84) 9 8157-2977
            </p>
        </footer>
    </body>
</html>