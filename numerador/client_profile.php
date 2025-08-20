<?php
// ===============================================
// PERFIL DO CLIENTE - SISTEMA JURÍDICO
// ===============================================

require_once('../Connections/conexao.php');

// Verificação de autenticação básica
session_start();
if (!isset($_SESSION['user_logged'])) {
    header("Location: ../logar/index.php");
    exit();
}

// Verificar se foi passado um ID válido
$client_id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;

if ($client_id == 0) {
    header("Location: manage_clients.php");
    exit();
}

// Buscar dados do cliente
$query_client = sprintf("SELECT * FROM legal_clients WHERE client_id = %s", GetSQLValueString($conexao, $client_id, "int"));
$result_client = mysqli_query($conexao, $query_client);
$row_client = mysqli_fetch_assoc($result_client);

if (!$row_client) {
    header("Location: manage_clients.php");
    exit();
}

// Buscar processos do cliente
$query_processes = sprintf("SELECT * FROM legal_processes WHERE client_id = %s ORDER BY start_date DESC", GetSQLValueString($conexao, $client_id, "int"));
$result_processes = mysqli_query($conexao, $query_processes);
$totalRows_processes = mysqli_num_rows($result_processes);

// Buscar últimas movimentações
$query_movements = "SELECT pm.*, lp.process_number, lp.case_subject 
                   FROM process_movements pm 
                   JOIN legal_processes lp ON pm.process_id = lp.process_id 
                   WHERE lp.client_id = " . $client_id . " 
                   ORDER BY pm.movement_date DESC 
                   LIMIT 10";
$result_movements = mysqli_query($conexao, $query_movements);
$totalRows_movements = mysqli_num_rows($result_movements);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - <?php echo htmlspecialchars($row_client['client_name']); ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .header { background: linear-gradient(135deg, #2c5530, #4a7c59); color: white; padding: 20px; margin: -20px -20px 20px -20px; border-radius: 8px 8px 0 0; }
        .client-info { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 20px; }
        .info-group { background: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #007bff; }
        .info-group h4 { margin: 0 0 10px 0; color: #333; }
        .info-group p { margin: 5px 0; color: #666; }
        .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th, .table td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        .table th { background: #f8f9fa; font-weight: bold; }
        .table tr:nth-child(even) { background: #f9f9f9; }
        .btn { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; text-decoration: none; display: inline-block; }
        .btn:hover { background: #0056b3; }
        .btn-success { background: #28a745; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-danger { background: #dc3545; }
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .status-active { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-completed { background: #cce7ff; color: #004085; }
        .movements-timeline { max-height: 400px; overflow-y: auto; }
        .movement-item { border-left: 3px solid #007bff; padding: 10px 15px; margin-bottom: 10px; background: #f8f9fa; border-radius: 0 5px 5px 0; }
        .movement-date { font-size: 12px; color: #666; font-weight: bold; }
        .movement-desc { margin: 5px 0; }
        .movement-process { font-size: 12px; color: #007bff; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .stat-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; text-align: center; }
        .stat-number { font-size: 2em; font-weight: bold; margin-bottom: 5px; }
        .stat-label { font-size: 14px; opacity: 0.9; }
    </style>
    <script>
        function refreshData() {
            location.reload();
        }
        
        function exportClientData() {
            window.open('export_client_data.php?client_id=<?php echo $client_id; ?>&format=excel', '_blank');
        }
        
        function formatCurrency(value) {
            if (value) {
                return new Intl.NumberFormat('pt-BR', { 
                    style: 'currency', 
                    currency: 'BRL' 
                }).format(value);
            }
            return 'Não informado';
        }
        
        // Auto refresh a cada 5 minutos
        setInterval(refreshData, 300000);
    </script>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>👤 Perfil do Cliente</h1>
                <p>Informações completas e acompanhamento de processos</p>
            </div>

            <!-- Informações do Cliente -->
            <div class="client-info">
                <div class="info-group">
                    <h4>📝 Dados Pessoais</h4>
                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($row_client['client_name']); ?></p>
                    <p><strong>Tipo:</strong> <?php echo $row_client['client_type'] == 'PESSOA_FISICA' ? 'Pessoa Física' : 'Pessoa Jurídica'; ?></p>
                    <p><strong>CPF/CNPJ:</strong> <?php echo htmlspecialchars($row_client['document_number']); ?></p>
                    <p><strong>Status:</strong> 
                        <span class="status-badge status-active">
                            <?php echo $row_client['status']; ?>
                        </span>
                    </p>
                </div>
                
                <div class="info-group">
                    <h4>📞 Contato</h4>
                    <p><strong>E-mail:</strong> <?php echo $row_client['email'] ?: 'Não informado'; ?></p>
                    <p><strong>Telefone:</strong> <?php echo $row_client['phone'] ?: 'Não informado'; ?></p>
                    <p><strong>Endereço:</strong> <?php echo $row_client['address'] ?: 'Não informado'; ?></p>
                </div>
                
                <div class="info-group">
                    <h4>📅 Informações do Sistema</h4>
                    <p><strong>Cadastrado em:</strong> <?php echo Consert_DataBr(substr($row_client['created_date'], 0, 10)); ?></p>
                    <p><strong>Última atualização:</strong> <?php echo Consert_DataBr(substr($row_client['updated_date'], 0, 10)); ?></p>
                    <p><strong>Observações:</strong> <?php echo $row_client['notes'] ?: 'Nenhuma observação'; ?></p>
                </div>
            </div>

            <!-- Estatísticas dos Processos -->
            <?php 
            $stats_query = "SELECT 
                               COUNT(*) as total_processos,
                               SUM(CASE WHEN process_status = 'Em Andamento' THEN 1 ELSE 0 END) as processos_andamento,
                               SUM(CASE WHEN process_status = 'Concluído' THEN 1 ELSE 0 END) as processos_concluidos,
                               COALESCE(SUM(case_value), 0) as valor_total
                           FROM legal_processes 
                           WHERE client_id = " . $client_id;
            $stats_result = mysqli_query($conexao, $stats_query);
            $stats = mysqli_fetch_assoc($stats_result);
            ?>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['total_processos']; ?></div>
                    <div class="stat-label">Total de Processos</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="stat-number"><?php echo $stats['processos_andamento']; ?></div>
                    <div class="stat-label">Em Andamento</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="stat-number"><?php echo $stats['processos_concluidos']; ?></div>
                    <div class="stat-label">Concluídos</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <div class="stat-number">R$ <?php echo number_format($stats['valor_total'], 2, ',', '.'); ?></div>
                    <div class="stat-label">Valor Total</div>
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div style="margin-bottom: 20px; text-align: center;">
                <button onclick="refreshData()" class="btn">🔄 Atualizar</button>
                <button onclick="exportClientData()" class="btn btn-success">📊 Exportar Dados</button>
                <a href="manage_processes.php?client_id=<?php echo $client_id; ?>" class="btn btn-warning">⚖️ Gerenciar Processos</a>
            </div>
        </div>

        <!-- Processos do Cliente -->
        <div class="card">
            <h2>⚖️ Processos Jurídicos</h2>
            
            <?php if ($totalRows_processes > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Número do Processo</th>
                            <th>Assunto</th>
                            <th>Tribunal</th>
                            <th>Status</th>
                            <th>Valor da Causa</th>
                            <th>Início</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row_process = mysqli_fetch_assoc($result_processes)): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row_process['process_number']); ?></strong></td>
                            <td><?php echo htmlspecialchars(substr($row_process['case_subject'], 0, 50)) . (strlen($row_process['case_subject']) > 50 ? '...' : ''); ?></td>
                            <td><?php echo htmlspecialchars($row_process['court_name']); ?></td>
                            <td>
                                <span class="status-badge <?php echo $row_process['process_status'] == 'Em Andamento' ? 'status-pending' : 'status-completed'; ?>">
                                    <?php echo htmlspecialchars($row_process['process_status']); ?>
                                </span>
                            </td>
                            <td>R$ <?php echo number_format($row_process['case_value'], 2, ',', '.'); ?></td>
                            <td><?php echo Consert_DataBr($row_process['start_date']); ?></td>
                            <td>
                                <a href="process_details.php?id=<?php echo $row_process['process_id']; ?>" class="btn" style="background: #6f42c1;">
                                    📋 Detalhes
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: #666;">
                    <p>📋 Nenhum processo cadastrado para este cliente.</p>
                    <a href="add_process.php?client_id=<?php echo $client_id; ?>" class="btn btn-success">➕ Adicionar Processo</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Últimas Movimentações -->
        <div class="card">
            <h2>📈 Últimas Movimentações</h2>
            
            <?php if ($totalRows_movements > 0): ?>
                <div class="movements-timeline">
                    <?php while ($row_movement = mysqli_fetch_assoc($result_movements)): ?>
                    <div class="movement-item">
                        <div class="movement-date">
                            <?php echo date('d/m/Y H:i', strtotime($row_movement['movement_date'])); ?>
                        </div>
                        <div class="movement-desc">
                            <?php echo htmlspecialchars($row_movement['movement_description']); ?>
                        </div>
                        <div class="movement-process">
                            📋 Processo: <?php echo htmlspecialchars($row_movement['process_number']); ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: #666;">
                    📈 Nenhuma movimentação encontrada ainda.
                </div>
            <?php endif; ?>
        </div>

        <!-- Navegação -->
        <div style="text-align: center; margin-top: 20px;">
            <a href="manage_clients.php" class="btn">👥 Voltar aos Clientes</a>
            <a href="../numerador/pagina.php" class="btn">🏠 Menu Principal</a>
        </div>
    </div>
</body>
</html>

<?php
// Limpeza de recursos
mysqli_free_result($result_client);
if (isset($result_processes)) mysqli_free_result($result_processes);
if (isset($result_movements)) mysqli_free_result($result_movements);
?>