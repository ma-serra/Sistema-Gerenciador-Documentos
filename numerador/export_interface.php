<?php
// ===============================================
// INTERFACE DE EXPORTAÇÃO DE DADOS
// ===============================================

require_once('../Connections/conexao.php');

// Verificação de autenticação básica
session_start();
if (!isset($_SESSION['user_logged'])) {
    header("Location: ../logar/index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportar Dados - Sistema Jurídico</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #2c5530, #4a7c59); color: white; padding: 20px; margin: -30px -30px 30px -30px; border-radius: 10px 10px 0 0; text-align: center; }
        .export-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .export-card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; background: #f8f9fa; transition: transform 0.2s, box-shadow 0.2s; }
        .export-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .card-icon { font-size: 2em; text-align: center; margin-bottom: 15px; }
        .card-title { font-size: 1.2em; font-weight: bold; margin-bottom: 10px; color: #333; text-align: center; }
        .card-description { color: #666; margin-bottom: 20px; text-align: center; }
        .btn-group { display: flex; gap: 10px; justify-content: center; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 14px; display: inline-block; text-align: center; }
        .btn-excel { background: #28a745; color: white; }
        .btn-csv { background: #17a2b8; color: white; }
        .btn:hover { opacity: 0.9; }
        .info-box { background: #e7f3ff; border-left: 4px solid #007bff; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Exportação de Dados</h1>
            <p>Geração de relatórios e planilhas do sistema jurídico</p>
        </div>

        <div class="info-box">
            <strong>ℹ️ Informação:</strong> As planilhas são geradas em tempo real com os dados mais atualizados do sistema. 
            Escolha o formato desejado: Excel (HTML) para visualização formatada ou CSV para importação em outros sistemas.
        </div>

        <div class="export-grid">
            <!-- Clientes -->
            <div class="export-card">
                <div class="card-icon">👥</div>
                <div class="card-title">Relatório de Clientes</div>
                <div class="card-description">
                    Lista completa de todos os clientes cadastrados com dados pessoais, contato e informações de cadastro.
                </div>
                <div class="btn-group">
                    <a href="export_data.php?type=clients&format=excel" class="btn btn-excel" target="_blank">📊 Excel</a>
                    <a href="export_data.php?type=clients&format=csv" class="btn btn-csv" target="_blank">📋 CSV</a>
                </div>
            </div>

            <!-- Processos -->
            <div class="export-card">
                <div class="card-icon">⚖️</div>
                <div class="card-title">Relatório de Processos</div>
                <div class="card-description">
                    Informações detalhadas de todos os processos jurídicos, incluindo tribunais, valores e status.
                </div>
                <div class="btn-group">
                    <a href="export_data.php?type=processes&format=excel" class="btn btn-excel" target="_blank">📊 Excel</a>
                    <a href="export_data.php?type=processes&format=csv" class="btn btn-csv" target="_blank">📋 CSV</a>
                </div>
            </div>

            <!-- Movimentações -->
            <div class="export-card">
                <div class="card-icon">📈</div>
                <div class="card-title">Movimentações Processuais</div>
                <div class="card-description">
                    Histórico completo de todas as movimentações e andamentos dos processos com datas e responsáveis.
                </div>
                <div class="btn-group">
                    <a href="export_data.php?type=movements&format=excel" class="btn btn-excel" target="_blank">📊 Excel</a>
                    <a href="export_data.php?type=movements&format=csv" class="btn btn-csv" target="_blank">📋 CSV</a>
                </div>
            </div>

            <!-- Resumo por Cliente -->
            <div class="export-card">
                <div class="card-icon">📋</div>
                <div class="card-title">Resumo por Cliente</div>
                <div class="card-description">
                    Estatísticas consolidadas por cliente: total de processos, valores e última movimentação.
                </div>
                <div class="btn-group">
                    <a href="export_data.php?type=summary&format=excel" class="btn btn-excel" target="_blank">📊 Excel</a>
                    <a href="export_data.php?type=summary&format=csv" class="btn btn-csv" target="_blank">📋 CSV</a>
                </div>
            </div>

            <!-- Logs do Sistema -->
            <div class="export-card">
                <div class="card-icon">📜</div>
                <div class="card-title">Logs do Sistema</div>
                <div class="card-description">
                    Histórico de execuções do sistema de automação, scraping e processamento de dados.
                </div>
                <div class="btn-group">
                    <a href="export_data.php?type=logs&format=excel" class="btn btn-excel" target="_blank">📊 Excel</a>
                    <a href="export_data.php?type=logs&format=csv" class="btn btn-csv" target="_blank">📋 CSV</a>
                </div>
            </div>

            <!-- Planilha Mãe (Master) -->
            <div class="export-card" style="border-color: #ffc107; background: linear-gradient(135deg, #fff3cd, #ffeaa7);">
                <div class="card-icon">🗂️</div>
                <div class="card-title">Planilha Mãe Completa</div>
                <div class="card-description">
                    Relatório completo com todos os dados: clientes, processos e movimentações em uma única planilha.
                </div>
                <div class="btn-group">
                    <a href="generate_master_spreadsheet.php?format=excel" class="btn btn-excel" target="_blank">📊 Gerar Planilha Mãe</a>
                </div>
            </div>
        </div>

        <!-- Exportações Personalizadas -->
        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
            <h3>🎯 Exportações Personalizadas</h3>
            <p>Para exportar dados de um cliente específico:</p>
            <div style="margin-top: 15px;">
                <a href="manage_clients.php" class="btn" style="background: #6f42c1; color: white;">
                    👤 Ir para Gestão de Clientes
                </a>
                <span style="margin: 0 10px; color: #666;">•</span>
                <small style="color: #666;">
                    Na página do perfil do cliente você encontrará opções de exportação específicas
                </small>
            </div>
        </div>

        <!-- Navegação -->
        <div style="text-align: center; margin-top: 30px;">
            <a href="legal_automation.php" class="btn" style="background: #007bff; color: white;">⬅️ Voltar ao Painel</a>
            <a href="../numerador/pagina.php" class="btn" style="background: #28a745; color: white;">🏠 Menu Principal</a>
        </div>
    </div>
</body>
</html>