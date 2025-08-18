<?php
// ===============================================
// FRAMEWORK DE SCRAPING JURÍDICO
// ===============================================

require_once('../Connections/conexao.php');

class CourtScraper {
    private $conexao;
    private $source_id;
    private $log_id;
    
    public function __construct($conexao, $source_id = null) {
        $this->conexao = $conexao;
        $this->source_id = $source_id;
    }
    
    /**
     * Inicia o log de execução
     */
    private function startLog($source_id, $trigger_id = null) {
        $sql = sprintf("INSERT INTO scraping_logs (source_id, trigger_id, execution_date, status) VALUES (%s, %s, NOW(), 'SUCCESS')",
                      GetSQLValueString($this->conexao, $source_id, "int"),
                      GetSQLValueString($this->conexao, $trigger_id, "int"));
        
        mysqli_query($this->conexao, $sql);
        $this->log_id = mysqli_insert_id($this->conexao);
        return $this->log_id;
    }
    
    /**
     * Finaliza o log com resultados
     */
    private function endLog($status, $message, $processes_found = 0, $movements_found = 0) {
        if (!$this->log_id) return;
        
        $sql = sprintf("UPDATE scraping_logs SET status = %s, message = %s, processes_found = %s, movements_found = %s WHERE log_id = %s",
                      GetSQLValueString($this->conexao, $status, "text"),
                      GetSQLValueString($this->conexao, $message, "text"),
                      GetSQLValueString($this->conexao, $processes_found, "int"),
                      GetSQLValueString($this->conexao, $movements_found, "int"),
                      GetSQLValueString($this->conexao, $this->log_id, "int"));
        
        mysqli_query($this->conexao, $sql);
    }
    
    /**
     * Busca processo por número no TJSP (simulação)
     */
    public function scrapeTJSP($process_number) {
        $this->startLog(1); // Source ID para TJSP
        
        try {
            // Simulação de consulta - em produção seria uma requisição real
            $process_data = $this->simulateTJSPQuery($process_number);
            
            if ($process_data) {
                $this->saveProcessData($process_data);
                $this->endLog('SUCCESS', "Processo {$process_number} consultado com sucesso", 1, count($process_data['movements']));
                return $process_data;
            } else {
                $this->endLog('WARNING', "Processo {$process_number} não encontrado", 0, 0);
                return null;
            }
            
        } catch (Exception $e) {
            $this->endLog('ERROR', "Erro ao consultar processo: " . $e->getMessage(), 0, 0);
            throw $e;
        }
    }
    
    /**
     * Simulação de consulta ao TJSP - em produção seria uma requisição real com cURL
     */
    private function simulateTJSPQuery($process_number) {
        // Simular diferentes cenários baseados no número do processo
        if (strpos($process_number, '2024') !== false) {
            return [
                'process_number' => $process_number,
                'court_name' => 'TJSP - Tribunal de Justiça de São Paulo',
                'case_subject' => 'Ação de Cobrança - Simulação',
                'process_status' => 'Em Andamento',
                'case_value' => 25000.00,
                'start_date' => '2024-03-15',
                'lawyer_name' => 'Dr. João Advocacia',
                'opposing_party' => 'Empresa Devedora Ltda',
                'process_type' => 'Cível',
                'movements' => [
                    [
                        'movement_date' => date('Y-m-d H:i:s', strtotime('-2 days')),
                        'movement_description' => 'Juntada de petição pela parte autora',
                        'movement_type' => 'JUNTADA',
                        'responsible_party' => 'Dr. João Advocacia'
                    ],
                    [
                        'movement_date' => date('Y-m-d H:i:s', strtotime('-5 days')),
                        'movement_description' => 'Despacho: Cite-se a parte requerida',
                        'movement_type' => 'DESPACHO',
                        'responsible_party' => 'Juiz Responsável'
                    ],
                    [
                        'movement_date' => date('Y-m-d H:i:s', strtotime('-10 days')),
                        'movement_description' => 'Distribuição por sorteio',
                        'movement_type' => 'DISTRIBUICAO',
                        'responsible_party' => 'Sistema'
                    ]
                ]
            ];
        }
        
        return null; // Processo não encontrado
    }
    
    /**
     * Salva dados do processo no banco
     */
    private function saveProcessData($data) {
        // Verificar se já existe cliente com base em algum critério
        // Para simplificar, vamos usar um cliente padrão ou criar um novo
        $client_id = $this->findOrCreateClient($data);
        
        // Inserir ou atualizar processo
        $existing_process = $this->findProcessByNumber($data['process_number']);
        
        if ($existing_process) {
            // Atualizar processo existente
            $process_id = $existing_process['process_id'];
            $this->updateProcess($process_id, $data);
        } else {
            // Criar novo processo
            $process_id = $this->createProcess($client_id, $data);
        }
        
        // Salvar movimentações
        foreach ($data['movements'] as $movement) {
            $this->saveMovement($process_id, $movement);
        }
        
        return $process_id;
    }
    
    /**
     * Encontra ou cria cliente baseado nos dados do processo
     */
    private function findOrCreateClient($data) {
        // Para simplificar, vamos usar o cliente padrão (ID 1) se existir
        $query = "SELECT client_id FROM legal_clients WHERE client_id = 1 LIMIT 1";
        $result = mysqli_query($this->conexao, $query);
        
        if (mysqli_num_rows($result) > 0) {
            return 1;
        }
        
        // Criar cliente padrão se não existir
        $sql = sprintf("INSERT INTO legal_clients (client_name, client_type, document_number, notes) VALUES (%s, %s, %s, %s)",
                      GetSQLValueString($this->conexao, "Cliente Automatico", "text"),
                      GetSQLValueString($this->conexao, "PESSOA_FISICA", "text"),
                      GetSQLValueString($this->conexao, "00000000000", "text"),
                      GetSQLValueString($this->conexao, "Cliente criado automaticamente pelo sistema de scraping", "text"));
        
        mysqli_query($this->conexao, $sql);
        return mysqli_insert_id($this->conexao);
    }
    
    /**
     * Busca processo pelo número
     */
    private function findProcessByNumber($process_number) {
        $query = sprintf("SELECT * FROM legal_processes WHERE process_number = %s LIMIT 1",
                        GetSQLValueString($this->conexao, $process_number, "text"));
        
        $result = mysqli_query($this->conexao, $query);
        return mysqli_fetch_assoc($result);
    }
    
    /**
     * Atualiza processo existente
     */
    private function updateProcess($process_id, $data) {
        $sql = sprintf("UPDATE legal_processes SET 
                          court_name = %s, 
                          case_subject = %s, 
                          process_status = %s, 
                          case_value = %s, 
                          lawyer_name = %s, 
                          opposing_party = %s, 
                          process_type = %s,
                          last_update = NOW()
                       WHERE process_id = %s",
                      GetSQLValueString($this->conexao, $data['court_name'], "text"),
                      GetSQLValueString($this->conexao, $data['case_subject'], "text"),
                      GetSQLValueString($this->conexao, $data['process_status'], "text"),
                      GetSQLValueString($this->conexao, $data['case_value'], "double"),
                      GetSQLValueString($this->conexao, $data['lawyer_name'], "text"),
                      GetSQLValueString($this->conexao, $data['opposing_party'], "text"),
                      GetSQLValueString($this->conexao, $data['process_type'], "text"),
                      GetSQLValueString($this->conexao, $process_id, "int"));
        
        return mysqli_query($this->conexao, $sql);
    }
    
    /**
     * Cria novo processo
     */
    private function createProcess($client_id, $data) {
        $sql = sprintf("INSERT INTO legal_processes 
                          (process_number, client_id, court_name, case_subject, process_status, case_value, start_date, lawyer_name, opposing_party, process_type, notes) 
                       VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                      GetSQLValueString($this->conexao, $data['process_number'], "text"),
                      GetSQLValueString($this->conexao, $client_id, "int"),
                      GetSQLValueString($this->conexao, $data['court_name'], "text"),
                      GetSQLValueString($this->conexao, $data['case_subject'], "text"),
                      GetSQLValueString($this->conexao, $data['process_status'], "text"),
                      GetSQLValueString($this->conexao, $data['case_value'], "double"),
                      GetSQLValueString($this->conexao, $data['start_date'], "date"),
                      GetSQLValueString($this->conexao, $data['lawyer_name'], "text"),
                      GetSQLValueString($this->conexao, $data['opposing_party'], "text"),
                      GetSQLValueString($this->conexao, $data['process_type'], "text"),
                      GetSQLValueString($this->conexao, "Processo criado automaticamente via scraping", "text"));
        
        mysqli_query($this->conexao, $sql);
        return mysqli_insert_id($this->conexao);
    }
    
    /**
     * Salva movimentação se não existir
     */
    private function saveMovement($process_id, $movement) {
        // Criar hash para evitar duplicatas
        $hash = md5($process_id . $movement['movement_date'] . $movement['movement_description']);
        
        // Verificar se movimento já existe
        $check_query = sprintf("SELECT movement_id FROM process_movements WHERE hash_content = %s LIMIT 1",
                              GetSQLValueString($this->conexao, $hash, "text"));
        
        $check_result = mysqli_query($this->conexao, $check_query);
        
        if (mysqli_num_rows($check_result) == 0) {
            // Inserir nova movimentação
            $sql = sprintf("INSERT INTO process_movements 
                              (process_id, movement_date, movement_description, movement_type, responsible_party, hash_content) 
                           VALUES (%s, %s, %s, %s, %s, %s)",
                          GetSQLValueString($this->conexao, $process_id, "int"),
                          GetSQLValueString($this->conexao, $movement['movement_date'], "text"),
                          GetSQLValueString($this->conexao, $movement['movement_description'], "text"),
                          GetSQLValueString($this->conexao, $movement['movement_type'], "text"),
                          GetSQLValueString($this->conexao, $movement['responsible_party'], "text"),
                          GetSQLValueString($this->conexao, $hash, "text"));
            
            return mysqli_query($this->conexao, $sql);
        }
        
        return false; // Movimento já existe
    }
    
    /**
     * Executa scraping automático baseado nos triggers configurados
     */
    public function executeScheduledScraping() {
        $query = "SELECT t.*, s.source_name, s.source_url, s.scraping_config 
                  FROM automation_triggers t 
                  JOIN court_sources s ON t.source_id = s.source_id 
                  WHERE t.status = 'ATIVO' 
                  AND t.trigger_type = 'SCHEDULED' 
                  AND (t.next_execution IS NULL OR t.next_execution <= NOW())";
        
        $result = mysqli_query($this->conexao, $query);
        $executed_count = 0;
        
        while ($trigger = mysqli_fetch_assoc($result)) {
            try {
                // Simular execução do scraping para cada tribunal
                $processes_scraped = $this->executeSourceScraping($trigger['source_id']);
                
                // Atualizar última execução
                $this->updateTriggerExecution($trigger['trigger_id']);
                
                $executed_count++;
                
            } catch (Exception $e) {
                error_log("Erro no scraping automático: " . $e->getMessage());
            }
        }
        
        return $executed_count;
    }
    
    /**
     * Executa scraping para uma fonte específica
     */
    private function executeSourceScraping($source_id) {
        $this->startLog($source_id);
        
        // Para demonstração, vamos buscar alguns processos de exemplo
        $example_processes = [
            '1000001-23.2024.8.26.0001',
            '1000002-24.2024.8.26.0001',
            '1000003-25.2024.8.26.0001'
        ];
        
        $scraped_count = 0;
        foreach ($example_processes as $process_number) {
            try {
                $process_data = $this->scrapeTJSP($process_number);
                if ($process_data) {
                    $scraped_count++;
                }
            } catch (Exception $e) {
                error_log("Erro ao processar {$process_number}: " . $e->getMessage());
            }
        }
        
        $this->endLog('SUCCESS', "Scraping executado com sucesso", $scraped_count, 0);
        return $scraped_count;
    }
    
    /**
     * Atualiza última execução do trigger
     */
    private function updateTriggerExecution($trigger_id) {
        $sql = sprintf("UPDATE automation_triggers SET 
                          last_execution = NOW(),
                          next_execution = DATE_ADD(NOW(), INTERVAL 1 DAY)
                       WHERE trigger_id = %s",
                      GetSQLValueString($this->conexao, $trigger_id, "int"));
        
        return mysqli_query($this->conexao, $sql);
    }
}

// Classe para gerenciar automação por email
class EmailAutomation {
    private $conexao;
    
    public function __construct($conexao) {
        $this->conexao = $conexao;
    }
    
    /**
     * Simula processamento de emails com pushes de tribunais
     */
    public function processEmailPushes() {
        // Aqui seria implementado o processamento de emails
        // Por exemplo, conectar via IMAP e buscar emails com padrões específicos
        
        $simulated_emails = [
            [
                'from' => 'noreply@tjsp.jus.br',
                'subject' => 'Movimentação no processo 1000123-45.2024.8.26.0001',
                'body' => 'Nova movimentação registrada: Juntada de documentos pela parte autora',
                'received_date' => date('Y-m-d H:i:s')
            ]
        ];
        
        foreach ($simulated_emails as $email) {
            $this->processEmailContent($email);
        }
        
        return count($simulated_emails);
    }
    
    private function processEmailContent($email) {
        // Extrair número do processo do assunto ou corpo do email
        preg_match('/(\d{7}-\d{2}\.\d{4}\.\d\.\d{2}\.\d{4})/', $email['subject'] . ' ' . $email['body'], $matches);
        
        if (isset($matches[1])) {
            $process_number = $matches[1];
            
            // Criar scraper e buscar dados atualizados
            $scraper = new CourtScraper($this->conexao);
            $scraper->scrapeTJSP($process_number);
        }
    }
}

?>