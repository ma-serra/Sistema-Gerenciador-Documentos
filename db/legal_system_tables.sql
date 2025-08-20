-- =================================================================
-- LEGAL PROCESS AUTOMATION SYSTEM TABLES
-- =================================================================

-- Tabela de Clientes
CREATE TABLE `legal_clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) NOT NULL,
  `client_type` enum('PESSOA_FISICA','PESSOA_JURIDICA') NOT NULL DEFAULT 'PESSOA_FISICA',
  `document_number` varchar(20) NOT NULL, -- CPF ou CNPJ
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('ATIVO','INATIVO') DEFAULT 'ATIVO',
  `notes` text,
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `idx_document_number` (`document_number`),
  KEY `idx_client_name` (`client_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Processos Jurídicos
CREATE TABLE `legal_processes` (
  `process_id` int(11) NOT NULL AUTO_INCREMENT,
  `process_number` varchar(50) NOT NULL,
  `client_id` int(11) NOT NULL,
  `court_name` varchar(255) DEFAULT NULL,
  `case_subject` text,
  `process_status` varchar(100) DEFAULT NULL,
  `case_value` decimal(15,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `last_update` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `lawyer_name` varchar(255) DEFAULT NULL,
  `opposing_party` text,
  `process_type` varchar(100) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`process_id`),
  UNIQUE KEY `idx_process_number` (`process_number`),
  KEY `idx_client_id` (`client_id`),
  KEY `idx_court_name` (`court_name`),
  KEY `idx_process_status` (`process_status`),
  CONSTRAINT `fk_process_client` FOREIGN KEY (`client_id`) REFERENCES `legal_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Movimentações/Andamentos dos Processos
CREATE TABLE `process_movements` (
  `movement_id` int(11) NOT NULL AUTO_INCREMENT,
  `process_id` int(11) NOT NULL,
  `movement_date` datetime NOT NULL,
  `movement_description` text NOT NULL,
  `movement_type` varchar(100) DEFAULT NULL,
  `responsible_party` varchar(255) DEFAULT NULL,
  `scraped_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `hash_content` varchar(255) DEFAULT NULL, -- Para evitar duplicatas
  PRIMARY KEY (`movement_id`),
  KEY `idx_process_id` (`process_id`),
  KEY `idx_movement_date` (`movement_date`),
  KEY `idx_hash_content` (`hash_content`),
  CONSTRAINT `fk_movement_process` FOREIGN KEY (`process_id`) REFERENCES `legal_processes` (`process_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Tribunais/Fontes de Dados
CREATE TABLE `court_sources` (
  `source_id` int(11) NOT NULL AUTO_INCREMENT,
  `source_name` varchar(255) NOT NULL,
  `source_url` text,
  `source_type` enum('SCRAPING','API','EMAIL','PUSH') NOT NULL DEFAULT 'SCRAPING',
  `scraping_config` json DEFAULT NULL, -- Configurações específicas para scraping
  `api_config` json DEFAULT NULL, -- Configurações para APIs
  `status` enum('ATIVO','INATIVO') DEFAULT 'ATIVO',
  `last_execution` datetime DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`source_id`),
  KEY `idx_source_type` (`source_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Configurações de Automação
CREATE TABLE `automation_triggers` (
  `trigger_id` int(11) NOT NULL AUTO_INCREMENT,
  `trigger_name` varchar(255) NOT NULL,
  `trigger_type` enum('SCHEDULED','EMAIL','PUSH','API_WEBHOOK') NOT NULL,
  `schedule_expression` varchar(100) DEFAULT NULL, -- Cron expression para agendamentos
  `email_config` json DEFAULT NULL, -- Configurações para emails
  `webhook_config` json DEFAULT NULL, -- Configurações para webhooks
  `source_id` int(11) DEFAULT NULL,
  `status` enum('ATIVO','INATIVO') DEFAULT 'ATIVO',
  `last_execution` datetime DEFAULT NULL,
  `next_execution` datetime DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`trigger_id`),
  KEY `idx_trigger_type` (`trigger_type`),
  KEY `idx_source_id` (`source_id`),
  CONSTRAINT `fk_trigger_source` FOREIGN KEY (`source_id`) REFERENCES `court_sources` (`source_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Log de Execuções
CREATE TABLE `scraping_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `source_id` int(11) DEFAULT NULL,
  `trigger_id` int(11) DEFAULT NULL,
  `execution_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('SUCCESS','ERROR','WARNING') NOT NULL,
  `message` text,
  `processes_found` int(11) DEFAULT 0,
  `movements_found` int(11) DEFAULT 0,
  `execution_time` int(11) DEFAULT NULL, -- tempo em segundos
  PRIMARY KEY (`log_id`),
  KEY `idx_execution_date` (`execution_date`),
  KEY `idx_status` (`status`),
  KEY `idx_source_id` (`source_id`),
  KEY `idx_trigger_id` (`trigger_id`),
  CONSTRAINT `fk_log_source` FOREIGN KEY (`source_id`) REFERENCES `court_sources` (`source_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_log_trigger` FOREIGN KEY (`trigger_id`) REFERENCES `automation_triggers` (`trigger_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- INSERÇÃO DE DADOS DE EXEMPLO
-- =================================================================

-- Dados de exemplo para tribunais
INSERT INTO `court_sources` (`source_name`, `source_url`, `source_type`, `status`) VALUES
('TJSP - Tribunal de Justiça de SP', 'https://esaj.tjsp.jus.br/', 'SCRAPING', 'ATIVO'),
('TRT2 - Tribunal Regional do Trabalho 2ª Região', 'https://pje.trt2.jus.br/', 'SCRAPING', 'ATIVO'),
('TRF3 - Tribunal Regional Federal 3ª Região', 'https://web.trf3.jus.br/', 'SCRAPING', 'ATIVO');

-- Dados de exemplo para triggers de automação
INSERT INTO `automation_triggers` (`trigger_name`, `trigger_type`, `schedule_expression`, `source_id`, `status`) VALUES
('Atualização Diária TJSP', 'SCHEDULED', '0 8 * * *', 1, 'ATIVO'),
('Atualização Semanal TRT2', 'SCHEDULED', '0 9 * * 1', 2, 'ATIVO'),
('Verificação Email Push', 'EMAIL', NULL, NULL, 'ATIVO');

-- Cliente de exemplo
INSERT INTO `legal_clients` (`client_name`, `client_type`, `document_number`, `email`, `phone`, `address`) VALUES
('João da Silva', 'PESSOA_FISICA', '12345678901', 'joao.silva@email.com', '(11) 99999-9999', 'Rua das Flores, 123 - São Paulo/SP');

-- Processo de exemplo
INSERT INTO `legal_processes` (`process_number`, `client_id`, `court_name`, `case_subject`, `process_status`, `case_value`, `start_date`, `lawyer_name`, `opposing_party`, `process_type`) VALUES
('1000123-45.2024.8.26.0001', 1, 'TJSP - 1ª Vara Cível Central', 'Ação de Cobrança', 'Em Andamento', 50000.00, '2024-01-15', 'Dr. José Advogado', 'Empresa XYZ Ltda', 'Cível');

-- Movimentação de exemplo
INSERT INTO `process_movements` (`process_id`, `movement_date`, `movement_description`, `movement_type`, `responsible_party`) VALUES
(1, '2024-01-20 14:30:00', 'Petição inicial protocolada', 'PROTOCOLO', 'Dr. José Advogado');