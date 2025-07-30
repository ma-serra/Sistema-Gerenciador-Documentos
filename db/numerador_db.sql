SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- =================================================================
-- ESTRUTURA DAS TABELAS (Padronizada em snake_case)
-- =================================================================
CREATE TABLE `num_org` (
  `org_id` int(11) NOT NULL,
  `org_unidade` int(11) DEFAULT NULL,
  `org_desc_unid` varchar(50) DEFAULT NULL,
  `org_cod_secao` varchar(5) DEFAULT NULL,
  `org_desc` varchar(50) DEFAULT NULL,
  `org_cidade` varchar(30) DEFAULT NULL,
  `org_uf` varchar(2) DEFAULT NULL,
  `org_bairro` varchar(30) DEFAULT NULL,
  `org_via` varchar(60) DEFAULT NULL,
  `org_num` varchar(6) DEFAULT NULL,
  `org_ref` varchar(30) DEFAULT NULL,
  `org_tel` varchar(16) DEFAULT NULL,
  `org_fax` varchar(16) DEFAULT NULL,
  `org_email` varchar(50) DEFAULT NULL,
  `org_tp` varchar(30) DEFAULT NULL,
  `org_obs` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `num_tipodoc` (
  `tipo_doc` int(11) NOT NULL,
  `desc_tipo_doc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `num_doc` (
  `id_num` int(11) NOT NULL,
  `cod_org` int(11) DEFAULT NULL,
  `tipo_doc` int(11) DEFAULT NULL,
  `num_doc` varchar(255) DEFAULT NULL,
  `cod_sec` varchar(255) DEFAULT NULL,
  `ano_doc` varchar(4) DEFAULT NULL,
  `assunto` longtext,
  `destino` varchar(255) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `elaborador` varchar(14) DEFAULT NULL,
  `obs_doc` longtext,
  `elaborado` tinyint(1) DEFAULT 0,
  `assinado` tinyint(1) DEFAULT 0,
  `encaminhado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `num_histpd` (
  `idhis_pd` int(11) NOT NULL,
  `id_pd` int(11) DEFAULT NULL,
  `readm_pd` varchar(255) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `tituhist_pd` varchar(255) DEFAULT NULL,
  `hist_pd` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `num_nivel` (
  `nivel_id` int(11) NOT NULL,
  `cod_nivel` varchar(3) DEFAULT NULL,
  `desc_nivel` varchar(40) DEFAULT NULL,
  `visivel` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `num_opm` (
  `opm_codigo` int(11) NOT NULL,
  `opm_prefixo` int(11) DEFAULT NULL,
  `opm_secao` int(11) NOT NULL,
  `opm_descricao` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `num_pd` (
  `id_pd` int(11) NOT NULL,
  `fin_pd` varchar(60) DEFAULT NULL,
  `org_id` int(11) DEFAULT NULL,
  `num_pd` varchar(255) DEFAULT NULL,
  `cod_secao` varchar(255) DEFAULT NULL,
  `ano_pd` varchar(4) DEFAULT NULL,
  `readm_pd` varchar(255) DEFAULT NULL,
  `repd_pd` varchar(255) DEFAULT NULL,
  `digpd_pd` varchar(255) DEFAULT NULL,
  `postpd_pd` varchar(255) DEFAULT NULL,
  `nomepd_pd` varchar(255) DEFAULT NULL,
  `cia_pd` varchar(255) DEFAULT '-' ,
  `enguatram_pd` varchar(255) DEFAULT NULL,
  `data_pd` date DEFAULT NULL,
  `conclusao_pd` varchar(255) DEFAULT '-' ,
  `dias_pd` smallint(4) DEFAULT NULL,
  `nbi_punic_pd` varchar(255) DEFAULT NULL,
  `bol_punic_pd` varchar(255) DEFAULT NULL,
  `nbl_corret_pd` varchar(255) DEFAULT NULL,
  `bol_corret_pd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `num_user` (
  `rerg` varchar(14) NOT NULL,
  `postfunc` varchar(20) DEFAULT NULL,
  `guerra` varchar(20) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `org_id` int(11) DEFAULT NULL,
  `nivel_id` int(11) DEFAULT NULL,
  `situacao` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sai_posto` (
  `cod_posto` int(11) NOT NULL,
  `posto` varchar(50) DEFAULT NULL,
  `bi` varchar(22) DEFAULT NULL,
  `grupo_posto` varchar(255) DEFAULT NULL,
  `desc_grupo_posto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cod_posto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- INSERÇÃO DE DADOS 
-- =================================================================

INSERT INTO `num_org` (`org_id`, `org_unidade`, `org_desc_unid`, `org_cod_secao`, `org_desc`, `org_cidade`, `org_uf`, `org_bairro`, `org_via`, `org_num`, `org_ref`, `org_tel`, `org_fax`, `org_email`, `org_tp`, `org_obs`) VALUES
(1, 602000000, 'CPI2', '224', 'TELEMATICA', 'CAMPINAS', 'SP', 'Vila Industrial', 'Av João Jorge', '499', 'Prédio Anexo', '19-3772-6200', '19-3772-6201', 'cpi2telematica@policiamilitar.sp.gov.br', 'Externo', 'Setor responsável pela infraestrutura de TI.'),
(28, 602008430, 'CPI-2 COPOM', '430', 'ADM', 'CAMPINAS', 'SP', 'VILA INDUSTRIAL', 'AV JOÃO JORGE ', '499', 'Próximo ao Viaduto Cury', '3772-6751 ramal 210', '3772-6743 ramal 211', 'cpi2copomop@policiamilitar.sp.gov.br', 'PM', 'TENHA UM BOM DIA! OU BOA TARDE!'),
(29, 602001000, 'CPI2', '100', 'Seç Log', 'Campinas', 'SP', 'Ponte Preta', 'Rua da Abolição', '60', 'Perto do Estádio', '19 - 32365346', '19 - 32365346', 'cpi2log@policiamilitar.sp.gov.br', 'PM', 'Seção de Logística.'),
(31, 602000000, 'CPI2', '100.6', 'P/4 - Seção Logistica', 'Campinas', 'SP', 'Vila Industrial', 'Av João Jorge', '499', 'Prédio Principal', '19 - 37726201', '19 - 37726264', 'cpi2p4@policiamilitar.sp.gov.br', 'PM', 'Assessoria de Logística e Patrimônio.'),
(32, 602000000, 'CPI-2', '201', 'Secretaria', 'Campinas', 'SP', 'Ponte Preta', 'Rua da Abolição', '60', 'Entrada Principal', '19 - 32365346', '19 - 32365346', 'cpi2secretaria@policiamilitar.sp.gov.br', 'PM', 'Secretaria Geral do Comando.'),
(33, 602002000, 'CPI-2', '200', 'Div Adm Pess', 'Campinas', 'SP', 'Vila João Jorge', 'Av João Jorge', '499', 'Quartel', '19-3772-6226', '19-3772-6261', 'cpi2p1@policiamilitar.sp.gov.br', 'PM', 'Divisão Administrativa e de Pessoal.'),
(34, 602001000, 'CPI-2', '101', 'Reserva de Arma', 'Campinas', 'SP', 'Vila Industrial', 'Av. João Jorge', '499', 'Quartel de policia Militar', '19 - 37431415', '19 - 37431400', 'cpi2almoxarifado@policiamilitar.sp.gov.br', 'PM', 'Setor de Almoxarifado e material bélico.'),
(35, 602000000, 'COPOM CPI-2', '430', 'ADM', 'Campinas', 'SP', 'Vila Industrial', 'Av João Jorge', '499', 'Anexo', '(19)3772-6750', '(19)3772-6751', 'cpi2copom@policiamilitar.sp.gov.br', 'PM', 'Administração do COPOM.'),
(36, 602008431, 'COPOM CPI-2', '431', 'Telecom', 'Campinas', 'SP', 'Vila Industrial', 'Av Joao Jorge', '499', 'CPI/2', '19 - 37726737', '19 - 37726738', 'cpi2tecrad@policiamilitar.sp.gov.br', 'PM', 'Setor de Telecomunicações.'),
(37, 602350000, '35º BPM/I', '000.', 'Testes', 'Campinas', 'SP', 'Ponte Preta', 'Rua da Abolição', '60', 'Sede do Batalhão', '19 - 32365346', '19 - 32365346', '35bpmi@policiamilitar.sp.gov.br', 'PM', 'Unidade de testes.'),
(38, 602350000, '35º BPM/I', '000.5', 'Seção de Comunicação Social', 'Campinas', 'SP', 'Ponte Preta', 'Rua da Abolição', '60', 'Sala P5', '19 - 32365346', '19 - 32365346', '35bpmip5@policiamilitar.sp.gov.br', 'PM', 'Comunicação Social (P5).'),
(39, 602000000, 'UIS', '62', 'UIS', 'Campinas', 'SP', 'Vila Industrial', 'Av. João Jorge', '499', 'CPI-2', '37726738', '37726731', 'cpi2uismedica@policiamilitar.sp.gov.br', 'PM', 'Unidade Integrada de Saúde');

INSERT INTO `num_tipodoc` (`tipo_doc`, `desc_tipo_doc`) VALUES
(1, 'APRECIAÇÃO'),(2, 'CARTAO ESTACIONAMENTO'),(3, 'COMUNICADO'),(4, 'DESPACHO'),(5, 'FAX'),(6, 'GUIA REMESSA'),(7, 'INFORMAÇÃO'),(8, 'INFORME'),(9, 'INVESTIGAÇÃO PRELIMINAR'),(10, 'MEMORANDO'),(11, 'NBI'),(12, 'NBI RESERVADA'),(13, 'OFICIO'),(14, 'ORDEM DE SERVIÇO'),(15, 'PARTE'),(16, 'PEDIDO DE BUSCA'),(17, 'PROTOCOLO'),(18, 'TERMO INVENTARIO'),(20, 'RAIIA'),(21, 'Nota de Imprensa'),(22, 'TERMO DE VISTORIA'),(23, 'DIÁRIA DE DILIGENCIA'),(24, 'TERMO DE AVALIAÇÃO'),(25, 'BOLETIM GERAL'),(26, 'MEMORANDO INSPEÇÃO DE SAÚDE'),(28, 'AUXÍLIO RECLUSÃO'),(29, 'TERMO DE RECEBIMENTO'),(30, 'TERMO RECEBIMENTO DE PNEUS'),(31, 'E-MAIL'),(32, 'PTAC'),(33, 'FMM'),(34, 'PROJETO BÁSICO'),(35, 'RADIO'),(36, 'RECIBO'),(37, 'P.D.F.'),(38, 'Nota de Serviço'),(39, 'ELOGIO'),(40, 'TERMO DE SUCATA'),(41, 'CONTRATO'),(42, 'CONVITE-BEC'),(43, 'DL'),(44, 'FEPOM'),(45, 'INEXIGIBILIDADE'),(46, 'NOTES'),(47, 'PREGAO'),(48, 'TESOURO'),(49, 'RIOG'),(50, 'FAM'),(51, 'TERMO DE DOAÇÃO'),(52, 'TERMO DE INSERVIBILIDADE'),(53, 'FAMI'),(54, 'PDF'),(55, 'GRC'),(56, 'Atestado/Declaração/Certidão'),(57, 'PLANILHA PERIÓDICO ANUAL'),(58, 'RELATÓRIO'),(59, 'FISP'),(60, 'ESCALA'),(61, 'TOMADA DE PREÇO'),(62, 'PORTARIA DE IPM'),(64, 'PORTARIA DE APFD'),(65, 'ATA DE REUNIÃO'),(66, 'CARTA PRECATÓRIA'),(67, 'PORTARIA DE CD'),(68, 'CONVITE SJD'),(69, 'DESERÇÃO'),(70, 'PORTARIA DE PAD'),(71, 'PROCEDIMENTO DISCIPLINAR'),(72, 'PORTARIA DE SINDICÂNCIA'),(73, 'NOTIFICAÇÃO'),(74, 'CITAÇÃO'),(75, 'INTIMAÇÃO'),(76, 'FAM - BÉLICO'),(77, 'FAM - INTENDENCIA'),(78, 'SANCIONATÓRIO'),(81, 'NOTA BOLETIM'),(82, 'PROJETO BÁSICO'),(83, 'INSTRUÇÃO NUMERADOR'),(84, 'RELATÓRIO OPERACIONAL'),(85, 'PERÍCIA IC'),(86, 'Termo de Descarga'),(87, 'Nota Instrução'),(98, 'ELIMINAÇÃO DE DOCUMENTOS'),(99, 'TROCA DE SERVIÇO'),(100, 'CEPOL/CECOM Comunicação Prévia'),(102, 'teste');

INSERT INTO `num_doc` (`id_num`, `cod_org`, `tipo_doc`, `num_doc`, `cod_sec`, `ano_doc`, `assunto`, `destino`, `data`, `elaborador`, `obs_doc`, `elaborado`, `assinado`, `encaminhado`) VALUES
(1, 28, 15, '0001', '203', '2012', 'Prorrogação do contrato de limpeza.', 'Sr. Dirigente da UGE 180157- CPI-2', '2012-01-23', '528641', 'Documentação anexa.', 1, 1, 1),
(2, 28, 13, '0001', '203', '2012', 'Análise de processo.', 'Sr. Diretor de Finanças e Patrimônio.', '2012-01-23', '528641', 'Análise concluída.', 1, 1, 1),
(3, 28, 14, '0001', '203', '2012', 'Relação de processos para o Tribunal de Contas.', 'SJD', '2012-01-23', '528641', 'Conforme solicitado.', 1, 1, 1),
(4, 28, 47, '0001', '203', '2012', 'Pregão de pneus', 'DF-1', '2012-01-23', '528641', 'Processo de pregão iniciado.', 1, 1, 1),
(5, 28, 42, '0001', '203', '2012', 'Aquisição de oleo lubrificante.', 'Motomec CPI-2', '2012-01-23', '528641', 'Convite enviado.', 1, 1, 1),
(6, 28, 48, '0001', '203', '2012', 'Compras de pneumaticos', 'Motomec ', '2012-01-23', '528641', 'Pagamento efetuado.', 1, 1, 1),
(14, 28, 48, '0009', '203', '2012', 'Serviço de agua e esgoto vinhedo (  SANEBAVI )', 'Dirigente', '2012-01-23', '528641', 'sem obs', 1, 1, 1),
(29, 28, 48, '0018', '203', '2012', 'Adiantamento de manutenção de vtr Ten. Pereira', 'Tesouraria', '2012-01-23', '528641', 'sem obs', 1, 1, 1),
(34, 28, 15, '0003', '203', '2012', 'Solicitação de material de escritório.', 'Setor de Almoxarifado', '2012-01-23', '999999', 'sem obs', 1, 1, 1),
(35, 28, 15, '0004', '203', '2012', 'Pedido de reparo em viatura.', 'Setor de Manutenção', '2012-01-23', '999999', 'sem obs', 1, 1, 1),
(40, 33, 13, '0030', '200', '2012', 'Solicitação de movimentação', 'DP-2', '2012-01-23', '904745', 'Referente ao Sd PM Silva.', 1, 1, 1),
(42, 33, 4, '0006', '200', '2012', 'Restituição de expediente sobre movimentação', '35º BPM/I', '2012-01-23', '904745', 'Documentação incompleta.', 1, 1, 1),
(44, 33, 10, '0028', '200', '2012', 'Apresentação do Sd PM Temp Carolina no COPOM', 'COPOM', '2012-01-23', '904745', 'Para início das atividades.', 1, 1, 1),
(45, 28, 4, '0001', '203', '2012', 'Aditamento do contrato de limpeza', 'Dirigente', '2012-01-23', '528641', 'Contrato aditado com sucesso.', 1, 1, 1),
(48, 33, 14, '0004', '200', '2012', 'Apresentação em 19JAN12 do Sd PM 991965-1 Anderson', '47º BPM/I', '2012-01-23', '904745', 'Conforme BI.', 1, 1, 1),
(50, 33, 5, '0010', '200', '2012', 'Alteração na Escala de Oficial Supervisor Regional', 'Todas OPM', '2012-01-23', '904745', 'Publicar em boletim.', 1, 1, 1),
(51, 33, 56, '0006', '200', '2012', 'Confecção de Certidão de Serviço prestado para fins empregaticio', 'Interessado', '2012-01-23', '904745', 'A pedido do interessado.', 1, 1, 1),
(52, 33, 31, '0000', '200', '2012', 'Comunicação interna sobre nova diretriz.', 'Corpo de Oficiais', '2012-01-23', '904745', 'E-mail informativo.', 1, 1, 1),
(53, 33, 15, '0003', '200', '2012', 'converSão em serviço', 'Presid PD', '2012-01-23', '904745', 'Relativo ao PD nº 123/2012.', 1, 1, 1),
(55, 33, 57, '0021', '200', '2012', 'Planilha de periódico anual - 2012.', 'Seção de Pessoal', '2012-01-23', '904745', 'Dados compilados.', 1, 1, 1),
(56, 33, 58, '0000', '200', '2012', 'Relatório de Atividades Mensal - Janeiro', 'Comando', '2012-01-23', '904745', 'Atividades da Seção.', 1, 1, 1),
(57, 33, 55, '0000', '200', '2012', 'Guia de Recolhimento da Contribuição (GRC)', 'Setor Financeiro', '2012-01-23', '904745', 'Referente a contribuições.', 1, 1, 1),
(81, 28, 48, '0032', '203', '2012', 'Contrato de aluguel 2GP Louveira 49BPM/I', 'Contrato 49BPM/I', '2012-01-25', '853137', 'Pagamento realizado.', 1, 1, 1),
(93, 28, 43, '0001', '203', '2012', 'pagamento de taxa de coleta de lixo 47ºBPM/I', '47ºBPM/I', '2012-01-26', '528641', 'Pagamento efetuado.', 1, 1, 1),
(97, 28, 46, '0001', '203', '2012', 'Planilha de investimentos', 'DFP-3', '2012-01-26', '528641', 'Dados atualizados.', 1, 1, 1);

-- Inserção na tabela `num_opm`
INSERT INTO `num_opm` (`opm_codigo`, `opm_prefixo`, `opm_secao`, `opm_descricao`) VALUES
(602000000, 2, 1, 'Comando de Policiamento do Interior 2'),
(602008430, 843, 1, 'COPOM Campinas'),
(602350000, 35, 1, '35º Batalhão de Polícia Militar');

-- Inserção na tabela `num_pd` (Procedimentos Disciplinares)
INSERT INTO `num_pd` (`id_pd`, `fin_pd`, `org_id`, `num_pd`, `cod_secao`, `ano_pd`, `readm_pd`, `repd_pd`, `digpd_pd`, `postpd_pd`, `nomepd_pd`, `cia_pd`, `enguatram_pd`, `data_pd`, `conclusao_pd`, `dias_pd`) VALUES
(101, 'Concluído', 33, '001/1.1/24', '200', '2024', '117606', '105387', '1', 'Sd PM', 'José da Silva', '1ª Cia', 'Cap PM MENDONÇA', '2024-05-10', 'Absolvido', 30),
(102, 'Em Andamento', 33, '002/1.1/24', '200', '2024', '117606', '100759', '5', 'Cb PM', 'João Santos', '2ª Cia', 'Cap PM MENDONÇA', '2024-06-20', '-', 45);

-- Inserção na tabela `num_histpd` (Histórico de Procedimentos)
INSERT INTO `num_histpd` (`idhis_pd`, `id_pd`, `readm_pd`, `data`, `tituhist_pd`, `hist_pd`) VALUES
(1, 101, '105387', '2024-05-15', 'Oitiva de Testemunhas', 'Foram ouvidas as testemunhas de acusação.'),
(2, 101, '105387', '2024-05-25', 'Interrogatório do Acusado', 'Realizado o interrogatório do militar implicado.'),
(3, 101, '105387', '2024-06-05', 'Relatório Final', 'Conclusão do procedimento com proposta de absolvição.'),
(4, 102, '100759', '2024-06-22', 'Instauração', 'Procedimento instaurado para apurar possível transgressão disciplinar.');

INSERT INTO `num_nivel` (`nivel_id`, `cod_nivel`, `desc_nivel`, `visivel`) VALUES
(1, 'a', 'Administrador', 1),
(2, 'u', 'Usuário', 1),
(3, 'v', 'Visitante', 1),
(4, 'm', 'Master', 0),
(5, 'c', 'CMT', 1);

INSERT INTO `num_user` (`rerg`, `postfunc`, `guerra`, `senha`, `org_id`, `nivel_id`, `situacao`) VALUES
('100100', '2º Sgt PM', 'Bilão', 'b9c93fbdfd2a30504e05d3b0b32307da', 31, 2, 'ATIVO'),
('100759', '1º Sgt PM', 'SANCHES', '895e487725e049f5d51a955154695920', 28, 1, 'ATIVO'),
('103122', '3º Sgt PM', 'Samuel', 'ffd6d7a3aa7665b48099dd64ed4031ed', 28, 2, 'ATIVO'),
('105288', 'Cb PM', 'Jaques', 'd48b1cf06d01005f80cf3b8cf1d8a0d1', 28, 2, 'ATIVO'),
('105387', 'Sgt PM', 'Previero', '700369a48f30f205d5b759c56410a804', 28, 1, 'ATIVO'),
('105419', '3º Sgt PM', 'MOISES', 'f1c2d0b863dd06c00fac472fb3515e10', 31, 2, 'ATIVO'),
('109094', 'Cb PM', 'TYAGO', 'ca9c5b7936624ad3d719909abffcf40f', 28, 2, 'ATIVO'),
('114186', 'Cb PM', 'M. CARVALHO', '77da8ad446d00989e2687d6867f307a6', 28, 2, 'ATIVO'),
('115521', '2º Sgt PM', 'Ponciano', '8b9eb2c56745032c4a25a0e8b80a7fe5', 36, 1, 'ATIVO'),
('115538', 'Cb PM', 'POLICIANO', 'ec16df78efccbb5704eef5778e0bc4df', 28, 2, 'ATIVO'),
('115646', 'Cb PM', 'AGOSTINHO', '109bcf8ddba64394d5a909f2482b1cc6', 28, 2, 'ATIVO'),
('115653', '1º Ten PM', 'PETERNUCCI', '6ea992752c5e0704d705b3842909eba3', 28, 1, 'ATIVO'),
('115777', '2º Sgt PM', 'FURLAN', '983d66b7934ebcd240a03639ac0b511c', 28, 1, 'ATIVO'),
('117263', 'Cb PM', 'Meneguecci', 'eda054b4a9390c45dac6163cde47fc90', 28, 2, 'ATIVO'),
('117600', 'Ten PM', 'Mendonça 2', 'f991ccd483f3ed86f2b87cf692ffb30f', 35, 4, 'ATIVO'),
('117606', 'Cap PM', 'MENDONÇA', '951477c405c46624e7650ab6e4354d4b', 35, 5, 'ATIVO');



INSERT INTO `sai_posto` (`cod_posto`, `posto`, `bi`, `grupo_posto`, `desc_grupo_posto`) VALUES
(101, 'Cel PM', 'RESERVADO', '1', 'Cel PM'),
(102, 'Ten Cel PM', 'RESERVADO', '2', 'Ten Cel PM'),
(103, 'Maj PM', 'RESERVADO', '3', 'Maj PM'),
(104, 'Cap PM', 'RESERVADO', '4', 'Cap PM'),
(105, '1º Ten PM', 'RESERVADO', '5', 'Ten PM'),
(106, '2º Ten PM', 'RESERVADO', '5', 'Ten PM'),
(108, 'Asp de Ten PM', 'RESERVADO', '5', 'Ten PM'),
(109, 'Subten PM', 'RESERVADO', '6', 'Subten / Sgt PM'),
(110, '1º Sgt PM', 'RESERVADO', '6', 'Subten / Sgt PM'),
(111, '2º Sgt PM', 'RESERVADO', '6', 'Subten / Sgt PM'),
(112, '3º Sgt PM', 'RESERVADO', '6', 'Subten / Sgt PM'),
(113, 'Cb PM', NULL, '7', 'Cb PM'),
(114, 'Sd PM', NULL, '7', 'Sd PM'),
(115, 'Sd PcIa PM', NULL, '7', 'Sd PM'),
(116, 'Sd PM Tempo', NULL, '7', 'Sd Temp PM');

-- =================================================================
-- DEFINIÇÃO DE ÍNDICES E CHAVES
-- =================================================================
ALTER TABLE `num_doc`
  ADD PRIMARY KEY (`id_num`),
  ADD UNIQUE KEY `idx_documento_unico` (`cod_org`, `tipo_doc`, `num_doc`, `ano_doc`),
  ADD KEY `idx_tipo_doc` (`tipo_doc`),
  ADD KEY `idx_elaborador` (`elaborador`),
  ADD KEY `idx_assinado` (`assinado`),
  ADD KEY `idx_encaminhado` (`encaminhado`);

ALTER TABLE `num_histpd`
  ADD PRIMARY KEY (`idhis_pd`),
  ADD KEY `idx_id_pd` (`id_pd`);

ALTER TABLE `num_nivel`
  ADD PRIMARY KEY (`nivel_id`);

ALTER TABLE `num_opm`
  ADD PRIMARY KEY (`opm_codigo`);

ALTER TABLE `num_org`
  ADD PRIMARY KEY (`org_id`),
  ADD UNIQUE KEY `idx_unidade_secao_unica` (`org_unidade`,`org_cod_secao`);

ALTER TABLE `num_pd`
  ADD PRIMARY KEY (`id_pd`),
  ADD KEY `idx_org` (`org_id`);

ALTER TABLE `num_tipodoc`
  ADD PRIMARY KEY (`tipo_doc`);

ALTER TABLE `num_user`
  ADD PRIMARY KEY (`rerg`),
  ADD KEY `idx_org_id` (`org_id`),
  ADD KEY `idx_nivel_id` (`nivel_id`);

-- Ajuste de auto_increment
ALTER TABLE `num_doc`
  MODIFY `id_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
ALTER TABLE `num_histpd`
  MODIFY `idhis_pd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `num_nivel`
  MODIFY `nivel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `num_org`
  MODIFY `org_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
ALTER TABLE `num_pd`
  MODIFY `id_pd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
ALTER TABLE `num_tipodoc`
  MODIFY `tipo_doc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

-- Chaves estrangeiras
ALTER TABLE `num_doc`
  ADD CONSTRAINT `fk_doc_org` FOREIGN KEY (`cod_org`) REFERENCES `num_org` (`org_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_doc_tipodoc` FOREIGN KEY (`tipo_doc`) REFERENCES `num_tipodoc` (`tipo_doc`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `num_user`
  ADD CONSTRAINT `fk_user_org` FOREIGN KEY (`org_id`) REFERENCES `num_org` (`org_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_nivel` FOREIGN KEY (`nivel_id`) REFERENCES `num_nivel` (`nivel_id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `num_pd`
  ADD CONSTRAINT `fk_pd_org` FOREIGN KEY (`org_id`) REFERENCES `num_org` (`org_id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `num_histpd`
  ADD CONSTRAINT `fk_histpd_pd` FOREIGN KEY (`id_pd`) REFERENCES `num_pd` (`id_pd`) ON DELETE SET NULL ON UPDATE CASCADE;

-- =================================================================
-- Finalização da transação
-- =================================================================
COMMIT;