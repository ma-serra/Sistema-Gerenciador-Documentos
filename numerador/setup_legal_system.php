<?php
// ===============================================
// SCRIPT DE SETUP DO SISTEMA JURÍDICO
// ===============================================

require_once('../Connections/conexao.php');

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Sistema Jurídico</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #2c5530, #4a7c59); color: white; padding: 20px; margin: -30px -30px 30px -30px; border-radius: 10px 10px 0 0; text-align: center; }
        .step { margin: 20px 0; padding: 15px; border-left: 4px solid #007bff; background: #f8f9fa; }
        .success { border-left-color: #28a745; background: #d4edda; }
        .error { border-left-color: #dc3545; background: #f8d7da; }
        .btn { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚖️ Setup do Sistema de Automação Jurídica</h1>
            <p>Instalação e configuração inicial</p>
        </div>

        <?php
        $setup_complete = false;
        $errors = [];
        $success_messages = [];

        if (isset($_POST['run_setup'])) {
            try {
                // Ler e executar o SQL das tabelas
                $sql_content = file_get_contents('../db/legal_system_tables.sql');
                
                if ($sql_content === false) {
                    throw new Exception("Não foi possível ler o arquivo SQL");
                }
                
                // Dividir o SQL em statements individuais
                $statements = array_filter(explode(';', $sql_content), 'trim');
                $executed = 0;
                $skipped = 0;
                
                foreach ($statements as $statement) {
                    $statement = trim($statement);
                    if (empty($statement) || strpos($statement, '--') === 0) {
                        continue;
                    }
                    
                    $result = mysqli_query($conexao, $statement);
                    if ($result) {
                        $executed++;
                    } else {
                        $error = mysqli_error($conexao);
                        if (strpos($error, 'already exists') !== false || strpos($error, 'Duplicate') !== false) {
                            $skipped++;
                        } else {
                            throw new Exception("Erro ao executar SQL: " . $error);
                        }
                    }
                }
                
                $success_messages[] = "✅ Setup concluído com sucesso!";
                $success_messages[] = "📊 Statements executados: {$executed}";
                $success_messages[] = "⏭️ Statements ignorados (já existiam): {$skipped}";
                $success_messages[] = "🗄️ Tabelas do sistema jurídico criadas";
                $success_messages[] = "📝 Dados de exemplo inseridos";
                
                $setup_complete = true;
                
            } catch (Exception $e) {
                $errors[] = "❌ Erro durante o setup: " . $e->getMessage();
            }
        }

        // Verificar se as tabelas já existem
        $tables_exist = false;
        $existing_tables = [];
        
        $check_tables = ['legal_clients', 'legal_processes', 'process_movements', 'court_sources', 'automation_triggers', 'scraping_logs'];
        
        foreach ($check_tables as $table) {
            $result = mysqli_query($conexao, "SHOW TABLES LIKE '{$table}'");
            if (mysqli_num_rows($result) > 0) {
                $existing_tables[] = $table;
            }
        }
        
        if (count($existing_tables) > 0) {
            $tables_exist = true;
        }

        ?>

        <!-- Mensagens de sucesso -->
        <?php foreach ($success_messages as $message): ?>
            <div class="step success">
                <?php echo $message; ?>
            </div>
        <?php endforeach; ?>

        <!-- Mensagens de erro -->
        <?php foreach ($errors as $error): ?>
            <div class="step error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <?php if (!$setup_complete): ?>
            <!-- Status atual -->
            <div class="step">
                <h3>📋 Status do Sistema</h3>
                <?php if ($tables_exist): ?>
                    <p>⚠️ Algumas tabelas do sistema jurídico já existem:</p>
                    <ul>
                        <?php foreach ($existing_tables as $table): ?>
                            <li><code><?php echo $table; ?></code></li>
                        <?php endforeach; ?>
                    </ul>
                    <p>O setup irá tentar criar apenas as tabelas que não existem.</p>
                <?php else: ?>
                    <p>🆕 Sistema jurídico não foi configurado ainda. Clique no botão abaixo para iniciar a instalação.</p>
                <?php endif; ?>
            </div>

            <!-- Formulário de setup -->
            <div class="step">
                <h3>🚀 Executar Setup</h3>
                <p>Este processo irá:</p>
                <ul>
                    <li>✨ Criar as tabelas necessárias para o sistema jurídico</li>
                    <li>📊 Inserir dados de exemplo (tribunais, triggers)</li>
                    <li>👤 Criar cliente e processo de demonstração</li>
                    <li>⚙️ Configurar triggers de automação básicos</li>
                </ul>
                
                <form method="POST">
                    <button type="submit" name="run_setup" class="btn" onclick="this.innerHTML='⏳ Executando...'; this.disabled=true;">
                        🔧 Executar Setup do Sistema Jurídico
                    </button>
                </form>
            </div>
        <?php else: ?>
            <!-- Setup completo - próximos passos -->
            <div class="step success">
                <h3>🎉 Sistema Instalado com Sucesso!</h3>
                <p><strong>Próximos passos:</strong></p>
                <ol>
                    <li>🏠 <a href="../logar/principal.php">Voltar ao menu principal</a></li>
                    <li>👥 <a href="manage_clients.php">Gerenciar clientes</a></li>
                    <li>⚖️ <a href="legal_automation.php">Acessar painel de automação</a></li>
                    <li>📊 <a href="export_interface.php">Exportar dados</a></li>
                </ol>
            </div>

            <div class="step">
                <h3>📚 Dados de Exemplo Criados</h3>
                <ul>
                    <li><strong>Cliente:</strong> João da Silva (CPF: 12345678901)</li>
                    <li><strong>Processo:</strong> 1000123-45.2024.8.26.0001</li>
                    <li><strong>Tribunais:</strong> TJSP, TRT2, TRF3</li>
                    <li><strong>Triggers:</strong> Automação diária TJSP, semanal TRT2</li>
                </ul>
            </div>

            <div class="step">
                <h3>🛠️ Configuração de Automação</h3>
                <p>Para automatizar completamente o sistema, configure:</p>
                <ul>
                    <li><strong>Cron Job:</strong></li>
                    <pre>0 8 * * * /usr/bin/php <?php echo __DIR__; ?>/automation_cron.php</pre>
                    <li><strong>Email IMAP:</strong> Configure em <code>court_scraper.php</code></li>
                    <li><strong>APIs de Tribunais:</strong> Adicione credenciais reais</li>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Informações técnicas -->
        <div class="step">
            <h3>ℹ️ Informações Técnicas</h3>
            <p><strong>Arquivos criados:</strong></p>
            <ul>
                <li><code>db/legal_system_tables.sql</code> - Estrutura do banco</li>
                <li><code>numerador/manage_clients.php</code> - Gestão de clientes</li>
                <li><code>numerador/client_profile.php</code> - Perfil do cliente</li>
                <li><code>numerador/court_scraper.php</code> - Framework de scraping</li>
                <li><code>numerador/legal_automation.php</code> - Painel de controle</li>
                <li><code>numerador/export_data.php</code> - Exportação de planilhas</li>
                <li><code>numerador/automation_cron.php</code> - Script para cron</li>
            </ul>
        </div>
    </div>
</body>
</html>