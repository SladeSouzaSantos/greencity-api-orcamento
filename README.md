# ☀️ Greencity API - Sistema Inteligente de Propostas Solares

Esta API é o motor de cálculo e geração de propostas da **Greencity Sustainable Energy**. Ela transforma dados técnicos e variáveis tarifárias complexas em propostas comerciais profissionais em PDF, automatizando o ciclo de vendas de sistemas fotovoltaicos.



## 🚀 Diferenciais Técnicos

### 1. Engine de Projeção Financeira (PHP/Laravel)
O sistema utiliza o `OrcamentoService` para realizar uma **projeção detalhada de 25 anos**, considerando:
* **Regra de Transição (Fio B):** Implementação da Lei 14.300 com fatores de escalonamento anuais aplicados dinamicamente no código.
* **Degradação de Módulos:** Cálculo de perda de eficiência linear ao longo da vida útil (ex: 20% em 25 anos).
* **Payback Dinâmico:** Algoritmo que identifica o mês exato do ROI (Return on Investment) cruzando economia mensal vs. investimento inicial.
* **Layout Dinâmico (Blade/CSS):** Geração de documentos PDF otimizados para impressão através do `DomPDF`, com estilização separada para fácil manutenção.

### 2. Infraestrutura DevOps & Edge Computing
O projeto é hospedado em um ambiente real de alta disponibilidade controlado por código:
* **Hardware:** Rodando em um cluster **Docker Swarm** em um **Raspberry Pi 4**.
* **CI/CD:** Pipeline automatizado no GitHub Actions com **Matrix Build** (validação simultânea em PHP 8.2, 8.3 e 8.4).
* **Segurança de Rede:** Exposição segura via **Cloudflare Tunnels** e gerenciamento de frota via rede privada **Tailscale**.
* **Observabilidade:** Telemetria de hardware em tempo real via **Netdata**.

---

## 📡 Documentação da API

### Endpoint de Geração
`POST /api/gerar-orcamento`

### Exemplo de Payload (JSON)
O endpoint processa a configuração técnica completa do sistema e os dados de faturamento da concessionária:

```json
{
    "nome": "RODRIGO",
    "cpf_cnpj": "000.000.000-00",
    "cidade": "Natal",
    "estado": "RN",
    "energiaGeradaMed": 1469.73,
    "energiaGeradaJan": 1490.39,
    "energiaGeradaFev": 1490.39,
    "energiaGeradaMar": 1516.22,
    "energiaGeradaAbr": 1394.82,
    "energiaGeradaMai": 1286.33,
    "energiaGeradaJun": 1273.26,
    "energiaGeradaJul": 1281.11,
    "energiaGeradaAgo": 1545.17,
    "energiaGeradaSet": 1578.21,
    "energiaGeradaOut": 1699.61,
    "energiaGeradaNov": 1645.37,
    "energiaGeradaDez": 1570.46,
    "fabricanteModulo": "CANADIAN",
    "modeloModulo": "CS6W-565MS",
    "dimensaoModuloAltura": 2.38,
    "dimensaoComprimento": 1.32,
    "dimensaoEspessura": 0.03,
    "pesoModulo": 27.3,
    "perdaEficienciaModulo": 20,
    "garantiaFisicaModulo": 15,
    "garantiaEficienciaModulo": 25,
    "potenciaModulo": 700,
    "numeroModulos": 15,
    "fabricanteInversor": "CANADIAN",
    "modeloInversor": "CSI-5K-MTL",
    "dimensaoInversor": "0.350 x 0.350 x 0.160 m",
    "pesoInversor": 11.5,
    "garantiaInversor": 10,
    "potenciaInversor": 5.0,
    "numeroInversores": 1,
    "tarifa_kwh": 0.99,
    "tarifaTUSD": 0.5828,
    "valorLimiteIluminacaoPublica": 190.40,
    "inflacao": 4.0,
    "percentagemUsoRede": 40,
    "precoTotal": 25150.00,
    "precoKitFotovoltaico": 17958.70
}
```

Resposta
A API retorna um Stream de PDF profissional com tabelas de cronograma financeiro e resumo técnico dos equipamentos.


## 🛠️ Stack Tecnológica
- **Backend: Laravel 12 (PHP 8.4+)**
- **PDF Engine: DomPDF / Blade Templates**
- **Containerização: Docker Swarm**
- **Monitoramento: Netdata**
- **CI/CD: GitHub Actions (Multi-arch build para ARM64)**
- **Conectividade: Cloudflare & Tailscale**

<br>
<br>
<p align="center"> Desenvolvido por <strong>Pedro H. Alves de Souza Santos</strong> </p>
<p align="center"> <em>Engenharia de Software & Energia Sustentável</em> </p>