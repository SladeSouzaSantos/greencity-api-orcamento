
@page { margin: 100pt 30pt 50pt 30pt; }

@font-face {
    font-family: 'Crafty Girls';
    src: url('{{ storage_path("fonts/CraftyGirls-Regular.ttf") }}') format("truetype");
    font-weight: normal;
    font-style: normal;
}

/* Cores da Identidade Greencity */
:root { --green-primary: #2d5a27; --gray-light: #f4f4f4; }

.page-break { page-break-before: always; }
.no-break { page-break-inside: avoid; }
.destaque { background-color: #e9f5e8; font-weight: bold; color: #2d5a27; }

body { font-size: 9pt; font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; }

.header-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; border-bottom: 2px solid var(--green-primary); }
.section-title { background: var(--green-primary); color: white; padding: 6px 10px; font-weight: bold; text-transform: uppercase; margin: 15px 0 5px 0; }

.table-data { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
.table-data th { background: var(--gray-light); color: var(--green-primary); border: 1px solid #ddd; padding: 5px; text-align: center; }
.table-data td { border: 1px solid #ddd; padding: 5px; }

.highlight-box { border: 2px solid var(--green-primary); padding: 15px; background: #fafafa; }
.price-total { font-size: 16pt; color: var(--green-primary); font-weight: bold; }

/* Configurações de Página */

header { 
    position: fixed; 
    top: -85pt; 
    left: 0; 
    right: 0; 
    height: 75pt;
}

.header-logo { border: none; text-align: left; vertical-align: middle;}

footer { 
    position: fixed; 
    bottom: -30pt; 
    left: 0; 
    right: 0; 
    height: 30pt; 
    text-align: center;
    font-size: 9pt;
    color: #777;
}

.logo {height: 72px; vertical-align: middle; display: inline-block;}

.brand-name {
    display: block;
    font-family: 'Crafty Girls', cursive;
    font-size: 26pt;
    color: #2d5a27;
    display: block;
    line-height: 0.8;
}

.brand-subtext {
    display: block;
    font-family: 'Helvetica', sans-serif;
    font-size: 8pt;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 1pt;
    display: block;
    margin-top: 6pt;
    padding-left: 10pt;
}

.section-title { background-color: #2d5a27; color: white; padding: 5pt 10pt; text-transform: uppercase; font-size: 12pt; margin-top: 20pt; font-weight: bold; }

table { width: 100%; border-collapse: collapse; margin-top: 10pt;}
th { background-color: #f2f2f2; padding: 6pt; text-align: center; font-size: 9pt; border: 1px solid #ddd; }
td { padding: 6pt; border: 1px solid #ddd; font-size: 9pt; vertical-align: top; text-align: center; }

.columns-container {
    width: 100%;
    margin-top: 0px;
}

.column-left {
    width: 48%;
    padding-right: 2%;
    vertical-align: top;
}

.column-right {
    width: 48%;
    padding-left: 2%;
    vertical-align: top;
}

.table-equipment {
    width: 100%;
    border-collapse: collapse;
}

.table-equipment th {
    background-color: #2d5a27;
    color: white;
    text-align: center;
    padding: 5px;
    font-size: 10pt;
}

.table-equipment td {
    padding: 5px;
    border: 1px solid #eee;
    font-size: 9pt;
}

.label-cell {
    background-color: #f9f9f9;
    font-weight: bold;
    width: 35%;
}

.tabela-balanco tfoot td {
    background-color: #e9f5e8;
    font-weight: bold;
    border-top: 2px solid #2d5a27;
}

.chart-area {
    width: 100%;
    height: 150px;
    border-bottom: 2px solid #2d5a27;
    margin-top: 25px;
    position: relative;
    text-align: center;
}

.bar-wrapper {
    display: inline-block;
    width: 5%;    
    margin: 0 0.5%;
    vertical-align: bottom;
    position: relative;
}

.bar-fill {
    background-color: #E1AD01;
    width: 100%;    
    margin: 0 auto;
}

.bar-label {
    font-size: 7pt;
    color: #333;
    text-transform: uppercase;
    display: block;
    margin-top: 5px;
}

.bar-value {
    font-size: 8pt;
    position: absolute;
    top: -20px;
    left: 0;
    right: 0;
    text-align: center;
    font-weight: bold;
}

.table-timeline {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.table-timeline th {
    background-color: #2d5a27;
    color: white;
    padding: 10px;
    font-size: 9pt;
    text-align: center;
    text-transform: uppercase;
}

.table-timeline td {
    padding: 8px 10px;
    border-bottom: 1px solid #eee;
    font-size: 8.5pt;
    color: #444;
}

.table-timeline tr:nth-child(even) {
    background-color: #fcfcfc;
}

.tag-responsavel {
    font-size: 7pt;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 4pt;
    background-color: #e8ece7;
    color: #2d5a27;
    text-transform: uppercase;
}

.payment-methods {
    width: 100%;
    margin-top: 20px;
    background-color: #fcfcfc;    
    padding: 15px;
}

.financing-item {
    color: #2d5a27;
    font-weight: bold;
    font-size: 10pt;
}

.total-box {
    background-color: #2d5a27;
    color: white;
    font-weight: bold;
    text-align: center;
    padding: 12px;
    margin-top: 5px;
    border-radius: 0 0 8pt 8pt;
}
.contact-item {
    font-size: 9pt;
    color: #444;
    margin-bottom: 5px;
}