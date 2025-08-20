<?php
// ===============================================
// EXPORTAÇÃO DE DADOS PARA PLANILHAS
// ===============================================

require_once('../Connections/conexao.php');

// Verificação de autenticação básica
session_start();
if (!isset($_SESSION['user_logged'])) {
    header("Location: ../logar/index.php");
    exit();
}

// Parâmetros de exportação
$export_type = isset($_GET['type']) ? $_GET['type'] : 'clients';
$format = isset($_GET['format']) ? $_GET['format'] : 'excel';
$client_id = isset($_GET['client_id']) ? (int)$_GET['client_id'] : 0;

/**
 * Função para converter array em CSV
 */
function arrayToCSV($data, $filename) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    $output = fopen('php://output', 'w');
    
    // BOM para UTF-8
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    if (!empty($data)) {
        // Cabeçalhos
        fputcsv($output, array_keys($data[0]), ';');
        
        // Dados
        foreach ($data as $row) {
            fputcsv($output, array_values($row), ';');
        }
    }
    
    fclose($output);
    exit;
}

/**
 * Função para gerar HTML da planilha (simula Excel)
 */
function arrayToHTML($data, $title, $filename) {
    $html = '<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>' . $title . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #2c5530; text-align: center; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .export-info { background: #e7f3ff; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
    </style>
    <script>
        window.onload = function() {
            if (confirm("Deseja salvar esta planilha como arquivo Excel?")) {
                document.execCommand("SaveAs", false, "' . $filename . '.xls");
            }
        }
    </script>
</head>
<body>
    <h1>' . $title . '</h1>
    <div class="export-info">
        <strong>📊 Relatório gerado em:</strong> ' . date('d/m/Y H:i:s') . '<br>
        <strong>👤 Usuário:</strong> ' . ($_SESSION['user_name'] ?? 'Sistema') . '<br>
        <strong>📋 Total de registros:</strong> ' . count($data) . '
    </div>
    <table>';
    
    if (!empty($data)) {
        // Cabeçalhos
        $html .= '<thead><tr>';
        foreach (array_keys($data[0]) as $header) {
            $html .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        $html .= '</tr></thead><tbody>';
        
        // Dados
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . htmlspecialchars($cell) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';
    }
    
    $html .= '</table>
    <div style="margin-top: 20px; text-align: center; color: #666;">
        <small>Sistema de Gerenciamento Jurídico - Relatório Automatizado</small>
    </div>
</body>
</html>';

    header('Content-Type: text/html; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '.html"');
    echo $html;
    exit;
}

// ===============================================
// EXPORTAÇÕES POR TIPO
// ===============================================

switch ($export_type) {
    case 'clients':
        // Exportar dados de clientes
        $query = "SELECT 
                     client_name as 'Nome do Cliente',
                     CASE 
                         WHEN client_type = 'PESSOA_FISICA' THEN 'Pessoa Física'
                         ELSE 'Pessoa Jurídica'
                     END as 'Tipo',
                     document_number as 'CPF/CNPJ',
                     email as 'E-mail',
                     phone as 'Telefone',
                     address as 'Endereço',
                     DATE_FORMAT(created_date, '%d/%m/%Y') as 'Data Cadastro',
                     status as 'Status',
                     notes as 'Observações'
                  FROM legal_clients 
                  ORDER BY client_name";
        
        $result = mysqli_query($conexao, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        
        $filename = 'clientes_juridicos_' . date('Y-m-d_H-i-s');
        $title = 'Relatório de Clientes Jurídicos';
        break;

    case 'processes':
        // Exportar dados de processos
        $where_clause = $client_id > 0 ? "WHERE lp.client_id = " . $client_id : "";
        
        $query = "SELECT 
                     lp.process_number as 'Número do Processo',
                     lc.client_name as 'Cliente',
                     lp.court_name as 'Tribunal',
                     lp.case_subject as 'Assunto',
                     lp.process_status as 'Status',
                     CONCAT('R$ ', FORMAT(lp.case_value, 2)) as 'Valor da Causa',
                     DATE_FORMAT(lp.start_date, '%d/%m/%Y') as 'Data de Início',
                     lp.lawyer_name as 'Advogado',
                     lp.opposing_party as 'Parte Contrária',
                     lp.process_type as 'Tipo de Processo',
                     DATE_FORMAT(lp.last_update, '%d/%m/%Y %H:%i') as 'Última Atualização'
                  FROM legal_processes lp
                  JOIN legal_clients lc ON lp.client_id = lc.client_id
                  {$where_clause}
                  ORDER BY lp.start_date DESC";
        
        $result = mysqli_query($conexao, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        
        $filename = ($client_id > 0 ? 'processos_cliente_' . $client_id : 'processos_juridicos') . '_' . date('Y-m-d_H-i-s');
        $title = $client_id > 0 ? 'Relatório de Processos do Cliente' : 'Relatório de Processos Jurídicos';
        break;

    case 'movements':
        // Exportar movimentações
        $where_clause = $client_id > 0 ? "WHERE lp.client_id = " . $client_id : "";
        
        $query = "SELECT 
                     lp.process_number as 'Número do Processo',
                     lc.client_name as 'Cliente',
                     DATE_FORMAT(pm.movement_date, '%d/%m/%Y %H:%i') as 'Data/Hora',
                     pm.movement_description as 'Descrição',
                     pm.movement_type as 'Tipo',
                     pm.responsible_party as 'Responsável',
                     DATE_FORMAT(pm.scraped_date, '%d/%m/%Y %H:%i') as 'Coletado em'
                  FROM process_movements pm
                  JOIN legal_processes lp ON pm.process_id = lp.process_id
                  JOIN legal_clients lc ON lp.client_id = lc.client_id
                  {$where_clause}
                  ORDER BY pm.movement_date DESC";
        
        $result = mysqli_query($conexao, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        
        $filename = ($client_id > 0 ? 'movimentacoes_cliente_' . $client_id : 'movimentacoes_processos') . '_' . date('Y-m-d_H-i-s');
        $title = $client_id > 0 ? 'Relatório de Movimentações do Cliente' : 'Relatório de Movimentações dos Processos';
        break;

    case 'logs':
        // Exportar logs do sistema
        $query = "SELECT 
                     DATE_FORMAT(sl.execution_date, '%d/%m/%Y %H:%i:%s') as 'Data/Hora Execução',
                     COALESCE(cs.source_name, 'Sistema') as 'Fonte',
                     COALESCE(at.trigger_name, 'Manual') as 'Trigger',
                     sl.status as 'Status',
                     sl.processes_found as 'Processos Encontrados',
                     sl.movements_found as 'Movimentações Encontradas',
                     sl.execution_time as 'Tempo Execução (s)',
                     sl.message as 'Mensagem'
                  FROM scraping_logs sl
                  LEFT JOIN court_sources cs ON sl.source_id = cs.source_id
                  LEFT JOIN automation_triggers at ON sl.trigger_id = at.trigger_id
                  ORDER BY sl.execution_date DESC
                  LIMIT 1000";
        
        $result = mysqli_query($conexao, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        
        $filename = 'logs_sistema_' . date('Y-m-d_H-i-s');
        $title = 'Relatório de Logs do Sistema';
        break;

    case 'summary':
        // Relatório resumo por cliente
        $query = "SELECT 
                     lc.client_name as 'Nome do Cliente',
                     lc.document_number as 'CPF/CNPJ',
                     COUNT(lp.process_id) as 'Total de Processos',
                     SUM(CASE WHEN lp.process_status = 'Em Andamento' THEN 1 ELSE 0 END) as 'Processos em Andamento',
                     SUM(CASE WHEN lp.process_status = 'Concluído' THEN 1 ELSE 0 END) as 'Processos Concluídos',
                     CONCAT('R$ ', FORMAT(COALESCE(SUM(lp.case_value), 0), 2)) as 'Valor Total das Causas',
                     COUNT(pm.movement_id) as 'Total de Movimentações',
                     DATE_FORMAT(MAX(pm.movement_date), '%d/%m/%Y') as 'Última Movimentação'
                  FROM legal_clients lc
                  LEFT JOIN legal_processes lp ON lc.client_id = lp.client_id
                  LEFT JOIN process_movements pm ON lp.process_id = pm.process_id
                  WHERE lc.status = 'ATIVO'
                  GROUP BY lc.client_id, lc.client_name, lc.document_number
                  ORDER BY lc.client_name";
        
        $result = mysqli_query($conexao, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        
        $filename = 'resumo_clientes_' . date('Y-m-d_H-i-s');
        $title = 'Relatório Resumo por Cliente';
        break;

    default:
        die("Tipo de exportação inválido.");
}

// ===============================================
// GERAR ARQUIVO CONFORME FORMATO
// ===============================================

if (empty($data)) {
    echo "<script>alert('Nenhum dado encontrado para exportação.'); history.back();</script>";
    exit;
}

if ($format === 'csv') {
    arrayToCSV($data, $filename);
} else {
    arrayToHTML($data, $title, $filename);
}

?>