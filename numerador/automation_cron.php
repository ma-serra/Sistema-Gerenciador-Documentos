#!/usr/bin/env php
<?php
// ===============================================
// SCRIPT DE AUTOMAÇÃO JURÍDICA - CRON JOB
// ===============================================

// Este script pode ser executado via cron para automatizar o scraping
// Exemplo de cron: 0 8 * * * /usr/bin/php /path/to/automation_cron.php

require_once('../Connections/conexao.php');
require_once('court_scraper.php');

// Log de execução
$log_file = '/tmp/legal_automation.log';

function writeLog($message) {
    global $log_file;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
    echo "[$timestamp] $message\n";
}

try {
    writeLog("Iniciando execução da automação jurídica");
    
    // Executar scraping programado
    $scraper = new CourtScraper($conexao);
    $scraped_count = $scraper->executeScheduledScraping();
    writeLog("Scraping executado com sucesso: {$scraped_count} fontes processadas");
    
    // Processar emails se disponível
    $email_automation = new EmailAutomation($conexao);
    $email_count = $email_automation->processEmailPushes();
    writeLog("Processamento de emails concluído: {$email_count} emails processados");
    
    // Estatísticas da execução
    $stats_query = "SELECT 
                       COUNT(*) as total_processes,
                       COUNT(CASE WHEN DATE(last_update) = CURDATE() THEN 1 END) as updated_today
                   FROM legal_processes";
    
    $result = mysqli_query($conexao, $stats_query);
    $stats = mysqli_fetch_assoc($result);
    
    writeLog("Estatísticas: {$stats['total_processes']} processos totais, {$stats['updated_today']} atualizados hoje");
    
    writeLog("Execução da automação concluída com sucesso");
    
} catch (Exception $e) {
    writeLog("ERRO na automação: " . $e->getMessage());
    exit(1);
}

exit(0);
?>