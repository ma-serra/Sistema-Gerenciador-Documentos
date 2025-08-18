<?php
// ===============================================
// SISTEMA DE AUTOMAÇÃO JURÍDICA - PAINEL DE CONTROLE
// ===============================================

require_once('../Connections/conexao.php');
require_once('court_scraper.php');

// Verificação de autenticação básica
session_start();
if (!isset($_SESSION['user_logged'])) {
    header("Location: ../logar/index.php");
    exit();
}

$message = '';
$message_type = '';

// ===============================================
// PROCESSAMENTO DE AÇÕES
// ===============================================

// Executar scraping manual
if (isset($_POST['action']) && $_POST['action'] == 'run_scraping') {
    try {
        $scraper = new CourtScraper($conexao);
        $executed = $scraper->executeScheduledScraping();
        $message = "✅ Scraping executado com sucesso! {$executed} fontes processadas.";
        $message_type = 'success';
    } catch (Exception $e) {
        $message = "❌ Erro ao executar scraping: " . $e->getMessage();
        $message_type = 'error';
    }
}

// Processar emails
if (isset($_POST['action']) && $_POST['action'] == 'process_emails') {
    try {
        $email_automation = new EmailAutomation($conexao);
        $processed = $email_automation->processEmailPushes();
        $message = "📧 Processamento de emails concluído! {$processed} emails processados.";
        $message_type = 'success';
    } catch (Exception $e) {
        $message = "❌ Erro ao processar emails: " . $e->getMessage();
        $message_type = 'error';
    }
}

// Consultar processo específico
if (isset($_POST['action']) && $_POST['action'] == 'search_process') {
    $process_number = $_POST['process_number'];
    if (!empty($process_number)) {
        try {
            $scraper = new CourtScraper($conexao);
            $result = $scraper->scrapeTJSP($process_number);
            if ($result) {
                $message = "✅ Processo {$process_number} consultado e atualizado com sucesso!";
                $message_type = 'success';
            } else {
                $message = "⚠️ Processo {$process_number} não encontrado nos tribunais.";
                $message_type = 'warning';
            }
        } catch (Exception $e) {
            $message = "❌ Erro ao consultar processo: " . $e->getMessage();
            $message_type = 'error';
        }
    }
}

// ===============================================
// CONSULTAS PARA DASHBOARD
// ===============================================

// Estatísticas gerais
$stats_query = "SELECT 
                   (SELECT COUNT(*) FROM legal_clients WHERE status = 'ATIVO') as total_clients,
                   (SELECT COUNT(*) FROM legal_processes) as total_processes,
                   (SELECT COUNT(*) FROM process_movements WHERE DATE(movement_date) = CURDATE()) as today_movements,
                   (SELECT COUNT(*) FROM scraping_logs WHERE DATE(execution_date) = CURDATE()) as today_executions";
$stats_result = mysqli_query($conexao, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);

// Últimos logs
$logs_query = "SELECT sl.*, cs.source_name 
               FROM scraping_logs sl 
               LEFT JOIN court_sources cs ON sl.source_id = cs.source_id 
               ORDER BY sl.execution_date DESC 
               LIMIT 10";
$logs_result = mysqli_query($conexao, $logs_query);

// Triggers ativos
$triggers_query = "SELECT at.*, cs.source_name 
                   FROM automation_triggers at 
                   LEFT JOIN court_sources cs ON at.source_id = cs.source_id 
                   WHERE at.status = 'ATIVO' 
                   ORDER BY at.trigger_name";
$triggers_result = mysqli_query($conexao, $triggers_query);

// Processos com movimentações recentes
$recent_processes_query = "SELECT lp.process_number, lp.case_subject, lc.client_name, pm.movement_date, pm.movement_description
                          FROM legal_processes lp
                          JOIN legal_clients lc ON lp.client_id = lc.client_id
                          LEFT JOIN process_movements pm ON lp.process_id = pm.process_id
                          WHERE pm.movement_date >= DATE_SUB(NOW(), INTERVAL 7 DAYS)
                          ORDER BY pm.movement_date DESC
                          LIMIT 5";
$recent_processes_result = mysqli_query($conexao, $recent_processes_query);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automação Jurídica - Painel de Controle</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f5f5f5; }
        .container { max-width: 1400px; margin: 0 auto; }
        .header { background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; text-align: center; }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .card { background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow: hidden; }
        .card-header { padding: 15px 20px; background: #f8f9fa; border-bottom: 1px solid #dee2e6; font-weight: bold; }
        .card-body { padding: 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .stat-item { text-align: center; padding: 20px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 8px; }
        .stat-number { font-size: 2em; font-weight: bold; margin-bottom: 5px; }
        .stat-label { font-size: 0.9em; opacity: 0.9; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; margin: 5px; transition: background-color 0.3s; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-danger { background: #dc3545; color: white; }
        .btn:hover { opacity: 0.9; }
        .alert { padding: 15px; margin: 20px 0; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .alert-error { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
        .alert-warning { background: #fff3cd; color: #856404; border-left: 4px solid #ffc107; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 10px; border-bottom: 1px solid #dee2e6; text-align: left; }
        .table th { background: #f8f9fa; font-weight: bold; }
        .status-badge { padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .status-success { background: #d4edda; color: #155724; }
        .status-error { background: #f8d7da; color: #721c24; }
        .status-warning { background: #fff3cd; color: #856404; }
        .actions-panel { background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
        .form-inline { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .form-control { padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; }
        .progress-bar { width: 100%; height: 20px; background: #e9ecef; border-radius: 10px; overflow: hidden; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #007bff, #0056b3); transition: width 0.3s; }
    </style>
    <script>
        function showLoading(element) {
            element.innerHTML = '⏳ Processando...';
            element.disabled = true;
        }
        
        function autoRefresh() {
            setTimeout(function() {
                location.reload();
            }, 30000); // Refresh a cada 30 segundos
        }
        
        // Inicia auto-refresh
        autoRefresh();
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚖️ Sistema de Automação Jurídica</h1>
            <p>Painel de Controle - Monitoramento e Gestão de Processos</p>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Painel de Ações Rápidas -->
        <div class="actions-panel">
            <h3>🚀 Ações Rápidas</h3>
            <div style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center;">
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="run_scraping">
                    <button type="submit" class="btn btn-primary" onclick="showLoading(this)">
                        🔄 Executar Scraping
                    </button>
                </form>
                
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="process_emails">
                    <button type="submit" class="btn btn-success" onclick="showLoading(this)">
                        📧 Processar Emails
                    </button>
                </form>
                
                <form method="POST" class="form-inline">
                    <input type="hidden" name="action" value="search_process">
                    <input type="text" name="process_number" placeholder="Número do processo" class="form-control" required>
                    <button type="submit" class="btn btn-warning">🔍 Consultar Processo</button>
                </form>
            </div>
        </div>

        <!-- Dashboard Estatísticas -->
        <div class="dashboard-grid">
            <!-- Estatísticas Gerais -->
            <div class="card">
                <div class="card-header">📊 Estatísticas Gerais</div>
                <div class="card-body">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $stats['total_clients']; ?></div>
                            <div class="stat-label">Clientes Ativos</div>
                        </div>
                        <div class="stat-item" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                            <div class="stat-number"><?php echo $stats['total_processes']; ?></div>
                            <div class="stat-label">Total de Processos</div>
                        </div>
                        <div class="stat-item" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                            <div class="stat-number"><?php echo $stats['today_movements']; ?></div>
                            <div class="stat-label">Movimentações Hoje</div>
                        </div>
                        <div class="stat-item" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                            <div class="stat-number"><?php echo $stats['today_executions']; ?></div>
                            <div class="stat-label">Execuções Hoje</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Triggers Ativos -->
            <div class="card">
                <div class="card-header">⚙️ Triggers de Automação</div>
                <div class="card-body">
                    <?php if (mysqli_num_rows($triggers_result) > 0): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                    <th>Fonte</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($trigger = mysqli_fetch_assoc($triggers_result)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($trigger['trigger_name']); ?></td>
                                    <td><?php echo $trigger['trigger_type']; ?></td>
                                    <td><?php echo $trigger['source_name'] ?: 'N/A'; ?></td>
                                    <td><span class="status-badge status-success"><?php echo $trigger['status']; ?></span></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p style="text-align: center; color: #666;">Nenhum trigger ativo configurado.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Processos com Movimentações Recentes -->
        <div class="card">
            <div class="card-header">📈 Movimentações Recentes (Últimos 7 dias)</div>
            <div class="card-body">
                <?php if (mysqli_num_rows($recent_processes_result) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Número do Processo</th>
                                <th>Cliente</th>
                                <th>Assunto</th>
                                <th>Última Movimentação</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($process = mysqli_fetch_assoc($recent_processes_result)): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($process['process_number']); ?></strong></td>
                                <td><?php echo htmlspecialchars($process['client_name']); ?></td>
                                <td><?php echo htmlspecialchars(substr($process['case_subject'], 0, 40)) . '...'; ?></td>
                                <td><?php echo htmlspecialchars(substr($process['movement_description'], 0, 50)) . '...'; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($process['movement_date'])); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; color: #666;">Nenhuma movimentação recente encontrada.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Logs de Execução -->
        <div class="card">
            <div class="card-header">📋 Logs de Execução (Últimos 10)</div>
            <div class="card-body">
                <?php if (mysqli_num_rows($logs_result) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Data/Hora</th>
                                <th>Fonte</th>
                                <th>Status</th>
                                <th>Processos</th>
                                <th>Movimentações</th>
                                <th>Mensagem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($log = mysqli_fetch_assoc($logs_result)): ?>
                            <tr>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($log['execution_date'])); ?></td>
                                <td><?php echo $log['source_name'] ?: 'Sistema'; ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo strtolower($log['status']) == 'success' ? 'success' : (strtolower($log['status']) == 'error' ? 'error' : 'warning'); ?>">
                                        <?php echo $log['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo $log['processes_found']; ?></td>
                                <td><?php echo $log['movements_found']; ?></td>
                                <td><?php echo htmlspecialchars(substr($log['message'], 0, 50)); ?>...</td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; color: #666;">Nenhum log de execução encontrado.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Links de Navegação -->
        <div style="text-align: center; margin-top: 30px;">
            <a href="manage_clients.php" class="btn btn-primary">👥 Gerenciar Clientes</a>
            <a href="export_data.php" class="btn btn-success">📊 Exportar Dados</a>
            <a href="../numerador/pagina.php" class="btn btn-warning">🏠 Menu Principal</a>
        </div>
    </div>
</body>
</html>

<?php
// Limpeza de recursos
mysqli_free_result($stats_result);
mysqli_free_result($logs_result);
mysqli_free_result($triggers_result);
mysqli_free_result($recent_processes_result);
?>