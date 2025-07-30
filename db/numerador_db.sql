-- Definições de sessão e início da transação
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- =================================================================
-- ESTRUTURA DAS TABELAS (Mantida conforme otimização anterior)
-- =================================================================

CREATE TABLE `num_org` (
  `org_id` int(22) NOT NULL,
  `org_Unidade` int(11) DEFAULT NULL,
  `org_descUnid` varchar(50) DEFAULT NULL,
  `org_CodSecao` varchar(5) DEFAULT NULL,
  `org_desc` varchar(50) DEFAULT NULL,
  `org_cidade` varchar(30) DEFAULT NULL,
  `org_uf` varchar(2) DEFAULT NULL,
  `org_Bairro` varchar(30) DEFAULT NULL,
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
  `Tipo_Doc` int(11) NOT NULL,
  `DescTipo_Doc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `num_doc` (
  `Id_Num` int(11) NOT NULL,
  `Cod_Org` int(22) DEFAULT NULL,
  `Tipo_Doc` int(11) DEFAULT NULL,
  `Num_Doc` varchar(255) DEFAULT NULL,
  `Cod_Sec` varchar(255) DEFAULT NULL,
  `Ano_Doc` year(4) DEFAULT NULL,
  `ASSUNTO` text,
  `DESTINO` varchar(255) DEFAULT NULL,
  `DATA` date DEFAULT NULL,
  `ELABORADOR` varchar(14) DEFAULT NULL,
  `obs_doc` text,
  `ELABORADO` tinyint(1) DEFAULT 0,
  `ASSINADO` tinyint(1) DEFAULT 0,
  `ENCAMINHADO` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `num_histpd` (
  `idhis_pd` int(11) NOT NULL,
  `id_pd` int(11) DEFAULT NULL,
  `readm_pd` varchar(255) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `titulhist_pd` varchar(255) DEFAULT NULL,
  `hist_pd` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `num_nivel` (
  `nivel_id` int(2) NOT NULL,
  `cod_nivel` varchar(3) DEFAULT NULL,
  `desc_nivel` varchar(40) DEFAULT NULL,
  `visivl` int(2) DEFAULT NULL
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
  `ord_id` int(11) DEFAULT NULL,
  `num_pd` varchar(255) DEFAULT NULL,
  `cod_secao` varchar(255) DEFAULT NULL,
  `ano_pd` year(4) DEFAULT NULL,
  `readm_pd` varchar(255) DEFAULT NULL,
  `repd_pd` varchar(255) DEFAULT NULL,
  `digpd_pd` varchar(255) DEFAULT NULL,
  `postpd_pd` varchar(255) DEFAULT NULL,
  `nomepd_pd` varchar(255) DEFAULT NULL,
  `cia_pd` varchar(255) DEFAULT '-',
  `enquatramento_pd` varchar(255) DEFAULT NULL,
  `data_pd` date DEFAULT NULL,
  `conclusao_pd` varchar(255) DEFAULT '-',
  `dias_pd` smallint(4) DEFAULT NULL,
  `nbiPunic_pd` varchar(255) DEFAULT NULL,
  `bolPunic_pd` varchar(255) DEFAULT NULL,
  `nbicorret_pd` varchar(255) DEFAULT NULL,
  `bolcorret_pd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `num_user` (
  `rerg` varchar(14) NOT NULL,
  `postfunc` varchar(20) DEFAULT NULL,
  `guerra` varchar(20) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `Org_id` int(22) DEFAULT NULL,
  `Nivel` int(2) DEFAULT NULL,
  `situacao` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sai_posto` (
  `CodPosto` int(11) NOT NULL,
  `Posto` varchar(50) DEFAULT NULL,
  `Bi` varchar(22) DEFAULT NULL,
  `GrupoPosto` varchar(255) DEFAULT NULL,
  `DescGrupPosto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CodPosto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- INSERÇÃO DE DADOS COM CAMPOS NULOS PREENCHIDOS
-- =================================================================

INSERT INTO `num_org` (`org_id`, `org_Unidade`, `org_descUnid`, `org_CodSecao`, `org_desc`, `org_cidade`, `org_uf`, `org_Bairro`, `org_via`, `org_num`, `org_ref`, `org_tel`, `org_fax`, `org_email`, `org_tp`, `org_obs`) VALUES
(1, 602000000, 'CPI2', '224', 'TELEMATICA', 'CAMPINAS', 'SP', 'Vila Industrial', 'Av João Jorge', '499', 'Prédio Anexo', '19-3772-6200', '19-3772-6201', 'cpi2telematica@policiamilitar.sp.gov.br', 'Externo', 'Setor responsável pela infraestrutura de TI.'),
(28, 602008430, 'CPI-2 COPOM', '430', 'ADM', 'CAMPINAS', 'SP', 'VILA INDUSTRIAL', 'AV JOÃO JORGE ', '499', 'Próximo ao Viaduto Cury', '3772-6751 ramal 210', '3772-6743 ramal 211', 'cpi2copomop@policiamilitar.sp.gov.br', 'PM', 'TENHA UM BOM DIA! OU BOA TARDE!'),
(29, 602001000, 'CPI2', '100', 'Seç Log', 'Campinas', 'SP', 'Ponte Preta', 'Rua da Abolição', '60', 'Perto do Estádio', '19 - 32365346', '19 - 32365346', 'cpi2log@policiamilitar.sp.gov.br', 'PM', 'Seção de Logística.'),
(31, 602000000, 'CPI2', '100.6', 'P/4 - Seção Logistica', 'Campinas', 'SP', 'Vila Industrial', 'Av João Jorge', '499', 'Prédio Principal', '19 - 37726201', '19 - 37726264', 'cpi2p4@policiamilitar.sp.gov.br', 'PM', 'Assessoria de Logística e Patrimônio.'),
(32, 602000000, 'CPI-2', '201', 'Secretaria', 'Campinas', 'SP', 'Ponte Preta', 'Rua da Abolição', '60', 'Entrada Principal', '19 - 32365346', '19 - 32365346', 'cpi2secretaria@policiamilitar.sp.gov.br', 'PM', 'Secretaria Geral do Comando.'),
(33, 602002000, 'CPI-2', '200', 'Div Adm Pess', 'Campinas', 'SP', 'Vila João Jorge', 'Av João Jorge', '499', 'Quartel', '19-3772-6226', '19-3772-6261', 'cpi2p1@policiamilitar.sp.gov.br', 'PM', 'Divisão Administrativa e de Pessoal.'),
(34, 602001000, 'CPI-2', '101', 'Reserva de Arma', 'Campinas', 'SP', 'Vila Industrial', 'Av. João Jorge', '499', 'Quartel de policia Militar', '19 - 37431415', '19 - 37431400', 'cpi2almoxarifado@policiamilitar.sp.gov.br', 'PM', 'Setor de Almoxarifado e material bélico.'),
(35, 602000000, 'COPOM CPI-2', '430', ' ADM', 'Campinas', 'SP', 'Vila Industrial', 'Av João Jorge', '499', 'Anexo', '(19)3772-6750', '(19)3772-6751', 'cpi2copom@policiamilitar.sp.gov.br', 'PM', 'Administração do COPOM.'),
(36, 602008431, 'COPOM CPI-2', '431', 'Telecom', 'Campinas', 'SP', 'Vila Industrial', 'Av Joao Jorge', '499', 'CPI/2', '19 - 37726737', '19 - 37726738', 'cpi2tecrad@policiamilitar.sp.gov.br', 'PM', 'Setor de Telecomunicações.'),
(37, 602350000, '35º BPM/I', '000.', 'Testes', 'Campinas', 'SP', 'Ponte Preta', 'Rua da Abolição', '60', 'Sede do Batalhão', '19 - 32365346', '19 - 32365346', '35bpmi@policiamilitar.sp.gov.br', 'PM', 'Unidade de testes.'),
(38, 602350000, '35º BPM/I', '000.5', 'Seção de Comunicação Social', 'Campinas', 'SP', 'Ponte Preta', 'Rua da Abolição', '60', 'Sala P5', '19 - 32365346', '19 - 32365346', '35bpmip5@policiamilitar.sp.gov.br', 'PM', 'Comunicação Social (P5).'),
(39, 602000000, 'UIS', '62', 'UIS', 'Campinas', 'SP', 'Vila Industrial', 'Av. João Jorge', '499', 'CPI-2', '37726738', '37726731', 'cpi2uismedica@policiamilitar.sp.gov.br', 'PM', 'Unidade Integrada de Saúde');

INSERT INTO `num_tipodoc` (`Tipo_Doc`, `DescTipo_Doc`) VALUES
(1, 'APRECIAÇÃO'),(2, 'CARTAO ESTACIONAMENTO'),(3, 'COMUNICADO'),(4, 'DESPACHO'),(5, 'FAX'),(6, 'GUIA REMESSA'),(7, 'INFORMAÇÃO'),(8, 'INFORME'),(9, 'INVESTIGAÇÃO PRELIMINAR'),(10, 'MEMORANDO'),(11, 'NBI'),(12, 'NBI RESERVADA'),(13, 'OFICIO'),(14, 'ORDEM DE SERVIÇO'),(15, 'PARTE'),(16, 'PEDIDO DE BUSCA'),(17, 'PROTOCOLO'),(18, 'TERMO INVENTARIO'),(20, 'RAIIA'),(21, 'Nota de Imprensa'),(22, 'TERMO DE VISTORIA'),(23, 'DIÁRIA DE DILIGENCIA'),(24, 'TERMO DE AVALIAÇÃO'),(25, 'BOLETIM GERAL'),(26, 'MEMORANDO INSPEÇÃO DE SAÚDE'),(28, 'AUXÍLIO RECLUSÃO'),(29, 'TERMO DE RECEBIMENTO'),(30, 'TERMO RECEBIMENTO DE PNEUS'),(31, 'E-MAIL'),(32, 'PTAC'),(33, 'FMM'),(34, 'PROJETO BÁSICO'),(35, 'RADIO'),(36, 'RECIBO'),(37, 'P.D.F.'),(38, 'Nota de Serviço'),(39, 'ELOGIO'),(40, 'TERMO DE SUCATA'),(41, 'CONTRATO'),(42, 'CONVITE-BEC'),(43, 'DL'),(44, 'FEPOM'),(45, 'INEXIGIBILIDADE'),(46, 'NOTES'),(47, 'PREGAO'),(48, 'TESOURO'),(49, 'RIOG'),(50, 'FAM'),(51, 'TERMO DE DOAÇÃO'),(52, 'TERMO DE INSERVIBILIDADE'),(53, 'FAMI'),(54, 'PDF'),(55, 'GRC'),(56, 'Atestado/Declaração/Certidão'),(57, 'PLANILHA PERIÓDICO ANUAL'),(58, 'RELATÓRIO'),(59, 'FISP'),(60, 'ESCALA'),(61, 'TOMADA DE PREÇO'),(62, 'PORTARIA DE IPM'),(64, 'PORTARIA DE APFD'),(65, 'ATA DE REUNIÃO'),(66, 'CARTA PRECATÓRIA'),(67, 'PORTARIA DE CD'),(68, 'CONVITE SJD'),(69, 'DESERÇÃO'),(70, 'PORTARIA DE PAD'),(71, 'PROCEDIMENTO DISCIPLINAR'),(72, 'PORTARIA DE SINDICÂNCIA'),(73, 'NOTIFICAÇÃO'),(74, 'CITAÇÃO'),(75, 'INTIMAÇÃO'),(76, 'FAM - BÉLICO'),(77, 'FAM - INTENDENCIA'),(78, 'SANCIONATÓRIO'),(81, 'NOTA BOLETIM'),(82, 'PROJETO BÁSICO'),(83, 'INSTRUÇÃO NUMERADOR'),(84, 'RELATÓRIO OPERACIONAL'),(85, 'PERÍCIA IC'),(86, 'Termo de Descarga'),(87, 'Nota Instrução'),(98, 'ELIMINAÇÃO DE DOCUMENTOS'),(99, 'TROCA DE SERVIÇO'),(100, 'CEPOL/CECOM Comunicação Prévia'),(102, 'teste');

INSERT INTO `num_doc` (`Id_Num`, `Cod_Org`, `Tipo_Doc`, `Num_Doc`, `Cod_Sec`, `Ano_Doc`, `ASSUNTO`, `DESTINO`, `DATA`, `ELABORADOR`, `obs_doc`, `ELABORADO`, `ASSINADO`, `ENCAMINHADO`) VALUES
(1, 28, 15, '0001', '203', 2012, 'Prorrogação do contrato de limpeza.', 'Sr. Dirigente da UGE 180157- CPI-2', '2012-01-23', '528641', 'Documentação anexa.', 1, 1, 1),
(2, 28, 13, '0001', '203', 2012, 'Análise de processo.', 'Sr. Diretor de Finanças e Patrimônio.', '2012-01-23', '528641', 'Análise concluída.', 1, 1, 1),
(3, 28, 14, '0001', '203', 2012, 'Relação de processos para o Tribunal de Contas.', 'SJD', '2012-01-23', '528641', 'Conforme solicitado.', 1, 1, 1),
(4, 28, 47, '0001', '203', 2012, 'Pregão de pneus', 'DF-1', '2012-01-23', '528641', 'Processo de pregão iniciado.', 1, 1, 1),
(5, 28, 42, '0001', '203', 2012, 'Aquisição de oleo lubrificante.', 'Motomec CPI-2', '2012-01-23', '528641', 'Convite enviado.', 1, 1, 1),
(6, 28, 48, '0001', '203', 2012, 'Compras de pneumaticos', 'Motomec ', '2012-01-23', '528641', 'Pagamento efetuado.', 1, 1, 1),
(14, 28, 48, '0009', '203', 2012, 'Serviço de agua e esgoto vinhedo (  SANEBAVI )', 'Dirigente', '2012-01-23', '528641', 'sem obs', 1, 1, 1),
(29, 28, 48, '0018', '203', 2012, 'Adiantamento de manutenção de vtr Ten. Pereira', 'Tesouraria', '2012-01-23', '528641', 'sem obs', 1, 1, 1),
(34, 28, 15, '0003', '203', 2012, 'Solicitação de material de escritório.', 'Setor de Almoxarifado', '2012-01-23', '999999', 'sem obs', 1, 1, 1),
(35, 28, 15, '0004', '203', 2012, 'Pedido de reparo em viatura.', 'Setor de Manutenção', '2012-01-23', '999999', 'sem obs', 1, 1, 1),
(40, 33, 13, '0030', '200', 2012, 'Solicitação de movimentação', 'DP-2', '2012-01-23', '904745', 'Referente ao Sd PM Silva.', 1, 1, 1),
(42, 33, 4, '0006', '200', 2012, 'Restituição de expediente sobre movimentação', '35º BPM/I', '2012-01-23', '904745', 'Documentação incompleta.', 1, 1, 1),
(44, 33, 10, '0028', '200', 2012, 'Apresentação do Sd PM Temp Carolina no COPOM', 'COPOM', '2012-01-23', '904745', 'Para início das atividades.', 1, 1, 1),
(45, 28, 4, '0001', '203', 2012, 'Aditamento do contrato de limpeza', 'Dirigente', '2012-01-23', '528641', 'Contrato aditado com sucesso.', 1, 1, 1),
(48, 33, 14, '0004', '200', 2012, 'Apresentação em 19JAN12 do Sd PM 991965-1 Anderson', '47º BPM/I', '2012-01-23', '904745', 'Conforme BI.', 1, 1, 1),
(50, 33, 5, '0010', '200', 2012, 'Alteração na Escala de Oficial Supervisor Regional', 'Todas OPM', '2012-01-23', '904745', 'Publicar em boletim.', 1, 1, 1),
(51, 33, 56, '0006', '200', 2012, 'Confecção de Certidão de Serviço prestado para fins empregaticio', 'Interessado', '2012-01-23', '904745', 'A pedido do interessado.', 1, 1, 1),
(52, 33, 31, '0000', '200', 2012, 'Comunicação interna sobre nova diretriz.', 'Corpo de Oficiais', '2012-01-23', '904745', 'E-mail informativo.', 1, 1, 1),
(53, 33, 15, '0003', '200', 2012, 'converSão em serviço', 'Presid PD', '2012-01-23', '904745', 'Relativo ao PD nº 123/2012.', 1, 1, 1),
(55, 33, 57, '0021', '200', 2012, 'Planilha de periódico anual - 2012.', 'Seção de Pessoal', '2012-01-23', '904745', 'Dados compilados.', 1, 1, 1),
(56, 33, 58, '0000', '200', 2012, 'Relatório de Atividades Mensal - Janeiro', 'Comando', '2012-01-23', '904745', 'Atividades da Seção.', 1, 1, 1),
(57, 33, 55, '0000', '200', 2012, 'Guia de Recolhimento da Contribuição (GRC)', 'Setor Financeiro', '2012-01-23', '904745', 'Referente a contribuições.', 1, 1, 1),
(81, 28, 48, '0032', '203', 2012, 'Contrato de aluguel 2GP Louveira 49BPM/I', 'Contrato 49BPM/I', '2012-01-25', '853137', 'Pagamento realizado.', 1, 1, 1),
(93, 28, 43, '0001', '203', 2012, 'pagamento de taxa de coleta de lixo 47ºBPM/I', '47ºBPM/I', '2012-01-26', '528641', 'Pagamento efetuado.', 1, 1, 1),
(97, 28, 46, '0001', '203', 2012, 'Planilha de investimentos', 'DFP-3', '2012-01-26', '528641', 'Dados atualizados.', 1, 1, 1);

INSERT INTO `num_user` (`rerg`, `postfunc`, `guerra`, `senha`, `Org_id`, `Nivel`, `situacao`) VALUES
('100100', '2º Sgt PM', 'Bilão', 'b9c93fbdfd2a30504e05d3b0b32307da', 31, 2, 'ATIVO'),
('100759', '1º Sgt PM', 'SANCHES', '12a02da69f7bac41b1945545efd5eac2', 28, 1, 'SUPERVISOR'),
('103122', '3º Sgt PM', 'Samuel', '518ebae8d5025d8d309af6502f36771d', 28, 2, 'SUPERVISOR'),
('105288', 'Cb PM', 'Jaques', 'd48b1cf06d01005f80cf3b8cf1d8a0d1', 28, 2, 'ATENDENTE 1'),
('105387', 'Sgt PM', 'Previero', '700369a48f30f205d5b759c56410a804', 28, 1, 'Supervisor'),
('105419', '3º Sgt PM', 'MOISES', 'e011bb3d2a4a359056b9fea0d837815f', 31, 2, 'Aux Seç Log'),
('109094', 'Cb PM', 'TYAGO', 'ca9c5b7936624ad3d719909abffcf40f', 28, 2, 'DESPACHADOR'),
('114186', 'Cb PM', 'M. CARVALHO', '1a2e25d2b713d0abba325b540008a6b5', 28, 2, 'DESPACHADOR'),
('115521', '2º Sgt PM', 'Ponciano', '3178f3594f35883e37b31cc8a678731f', 36, 1, 'Telecom'),
('115538', 'Cb PM', 'POLICIANO', '81dc9bdb52d04dc20036dbd8313ed055', 28, 2, 'ATENDENTE'),
('115646', 'Cb PM', 'AGOSTINHO', '903f346c3e3d55b69f630b63d6aa174b', 28, 2, 'INCLUSOR'),
('115653', '1º Ten PM', 'PETERNUCCI', '051c2ede3267fcaf8c022cebf120a6e6', 28, 1, 'CHEFE DE OP'),
('115777', '2º Sgt PM', 'FURLAN', 'a4ffd79e1f6e2c5232cb800f603002c5', 28, 1, 'SUPERVISOR'),
('117263', 'Cb PM', 'Meneguecci', '60f86fdf7bb14ec23a28f7c91fc34a34', 28, 2, 'AT/DESPACHA'),
('117600', 'Ten PM', 'Mendonça 2', 'f991ccd483f3ed86f2b87cf692ffb30f', 35, 4, 'Of Telemati'),
('117606', 'Cap PM', 'MENDONÇA', '951477c405c46624e7650ab6e4354d4b', 35, 1, 'CHEFE COPOM'),
('117684', 'Cb PM', 'BARZAGHI', '54245cd3710ce1b784933a54964bbb52', 28, 2, 'DESPACHADOR'),
('119207', '1º Sgt PM', 'HERITON', '631b5aa5d228abb025b6f089cd556a1a', 28, 1, 'SUPERVISOR'),
('119284', '2º Sgt PM', 'BAUNGART', '6103974c0324aced1dfbd683446a3d3f', 28, 1, 'SUPERVISOR'),
('119856', 'Cb PM', 'REGINALDO', 'f43e04619a498fca8cc76c308640ddcd', 28, 2, 'DESPACHADOR'),
('120431', 'Sd PM', 'VELOZO', '2658c91ecbca5651a53b4b13709c62fa', 28, 2, 'ATENDENTE'),
('120546', '1º Sgt PM', 'LOPES', '9e1f6e4efbc1830f40812e99433ea6a7', 35, 1, 'Auxiliar AD'),
('120744', '2º Sgt PM', 'ANGELICA', '3dfdd5e1cebfd8dcb6c570cd13e12688', 28, 1, 'SUPERVISOR'),
('123002', '2º Sgt PM', 'AGEL', '9c602d70c35080c40a62a3e6df4e96d3', 28, 1, 'AUXILIAR DE'),
('125216', 'Sd PM', 'R. Rodrigues', '5085def3bfedb1fb5923f849a0d61dbc', 28, 2, 'Inclusor'),
('129618', 'Cb PM', 'Alves Fideli', 'eff2f36874c41826402b86da5ded2af2', 36, 2, 'Aux. Teleco'),
('130980', '2º Sgt PM', 'QUINTINO', '78f5b8ce73420dd5301a753625b67c7c', 28, 2, 'SUPERVISOR'),
('132864', 'Sd PM', 'ARAÚJO', 'b10c7651c0884c48fb20cd557d292715', 28, 2, 'Despachador'),
('136680', '2º Sgt PM', 'RAFAEL LOPES', 'd8c7f7890fd60a673b72724a917533d3', 28, 1, 'SUPERVISOR'),
('136818', 'Sd PM', 'SANCHEZ', 'a0ef4f6a7dd9e263952828a216078e95', 28, 2, 'DESPACHADOR'),
('138172', 'Sd PM', 'Guilherme', 'cdcf87ea608764aaec58923922917a87', 28, 2, 'Despachador'),
('139511', 'Sd PM', 'Saraiva', 'aa4bc5d46aec25e60c405277ff00b9ab', 28, 2, 'atendente'),
('139819', 'Sd PM', 'NETO', '07e173d0075facb8862607b4484dd7a0', 28, 2, 'DESPACHADOR'),
('140017', 'Sd PM', 'Ximenes', 'cfe04e125bd50bcb874670ce96530140', 28, 2, 'Atendente'),
('140054', 'Cb PM', 'CRUZ', '09bfe9fc74814f8dcc815597d26fb09e', 28, 2, 'ATENDENTE'),
('140168', 'Sd PM', 'GUIOTTI', '81dc9bdb52d04dc20036dbd8313ed055', 28, 2, 'DESPACHADOR'),
('141625', 'Sd PM', 'BUENO', '5c4f350a9c666e2549b00e5848eee75e', 28, 2, 'ATENDENTE'),
('141913', 'Sd PM', 'Siqueira', '7b0be4c74217c2f6c046f23c242a46df', 28, 2, 'atendente'),
('143672', 'Sd PM', 'GUILHERME LUIZ', 'bc62c578bd47f114206a407313e7f48b', 28, 2, 'ATENDENTE 1'),
('144616', 'Sd PM', 'GOMES', '6ce97f5c23ac573e60115c30f71c2990', 28, 2, 'ATENDENTE 1'),
('145259', '3º Sgt PM', 'Guzenski', 'b899faec1aab6b6889ccf94bf6e2d90f', 28, 1, 'SUPERVISOR'),
('145545', 'Sd PM', 'JAQUELINE', '02aa61dc36076ef11cec47f5024c471c', 35, 1, 'AUXILIAR AD'),
('147181', 'Sd PM', 'Lúcio', '960b9c5c8c093c003be9661b3eac1398', 28, 1, 'Despachador'),
('148734', 'Sd PM', 'DENISE', 'f23fb90262d583ec0d1f8031e434a423', 28, 2, 'DESPACHADOR'),
('149671', 'Cb PM', 'AMANDA NARIYOSHI', '5bbb57cb6eb277bc7d78a83fd6f31563', 35, 1, 'AUXILIAR AD'),
('156672', 'Sd PM', 'Joice', '6571a5898c993ea89bd724e4cf503e5d', 28, 2, 'Inclusor'),
('161748', 'Sd PM', 'Luna', '5463eb1e5761fa6d21f209b763880084', 28, 1, 'adm'),
('170690', 'Sd PM', 'Sd Alan', 'b1e33ab0e62bfa3ebc83ee5dc11ceec0', 36, 2, 'Aux Telecom'),
('180849', 'Sd PM', 'Alexandre', '544242082803080b8f7d4e62a400666e', 35, 1, 'Aux Telecom'),
('180850', 'Cel PM', 'TESTE', '544242082803080b8f7d4e62a400666e', 35, 1, 'CMT'),
('181479', 'Sd PM', 'Dittz', 'dfbe9b84722f27c60aade2595f9f66da', 36, 2, 'Aux.telecom'),
('524018', 'Sd PM Temp', 'ITALA', '964f7870a043b5cc15ab78dd88192d3e', 31, 1, 'ATIVO'),
('528676', 'Sd PM Temp', 'QUARESMA', '247a661f17c6da805a556ca0515111f0', 31, 2, 'Aux Seç Log'),
('528745', 'Sd PM Temp', 'VINÍCIUS', '5aa0c404a308203ac52b1e634432eab0', 31, 2, 'Aux Seç Log'),
('528747', 'Sd PM Temp', 'CARNEIRO', '0d2949335cf7037301d91a58f908fbc8', 34, 1, 'AUX ALMOXAR'),
('531582', 'Sd PM Temp', 'Nascimento', 'e97838bcd746c15765c22e1f372c8761', 33, 2, 'Aux P/1'),
('531589', 'Sd PM Temp', 'Fernanda', '3006b60efc425d114a71a76bc14bbc25', 31, 2, 'Aux Seç Log'),
('531657', 'Sd PM Temp', 'Sergio', 'e8bfa5d5505a10c3f2f1462cc284faa8', 1, 4, 'Aux Telemat'),
('533085', 'Sd PM Temp', 'Luiz', '9acdb52e43d4feee07013ce314e0ec33', 1, 1, 'Aux Telemát'),
('831334', '1º Sgt PM', 'EVERALDO', 'dfbe9b84722f27c60aade2595f9f66da', 34, 1, 'Aux Seç Log'),
('840687', '2º Sgt PM', 'Colucci', 'dfbe9b84722f27c60aade2595f9f66da', 33, 1, 'Supervisor'),
('853284', 'Cap PM', 'DAMASCENO', 'e3c37c5753692b5d19731e39448bf6ab', 31, 2, 'Chefe Seç L'),
('853471', '1º Ten PM', 'ROCCO', '26e79835fc208cac0ac495e45f3e8db5', 31, 2, 'Chefe do Al'),
('861378', '2º Sgt PM', 'Milton', 'bea1aa332a847c43ebf39594baf96e02', 33, 2, 'Aux Div Adm'),
('875618', 'Cb PM', 'TANIA', '90e43a915bc8502b19348f31cc1c9c98', 31, 2, 'Aux Seç Log'),
('888134', '1º Sgt PM', 'Cáprio', 'd41d8cd98f00b204e9800998ecf8427e', 39, 1, 'Aux de Adm'),
('900147', '2º Sgt PM', 'Santana', 'dfbe9b84722f27c60aade2595f9f66da', 39, 2, 'Aux de Adm'),
('904745', 'Cb PM', 'SPADREZANI', '58af17094855dddcf652c3f904528645', 33, 1, 'Aux P/1'),
('913926', 'Cb PM', 'CB LOPES', '58a904c327c98ae6513baacecc50d14a', 28, 2, 'ATENDENTE'),
('913949', '2º Sgt PM', 'Vital', 'dfbe9b84722f27c60aade2595f9f66da', 32, 1, 'Auxiliar'),
('920954', 'Subten PM', 'TAMASO', 'ab111e3f59f9b09385e2bff0eff90236', 28, 2, 'Supervisor'),
('922499', 'Cb PM', 'LIZANDRA', '5fec7b81f57ce17c1e0fb238ab08599f', 28, 2, 'ATENDENTE 1'),
('922503', 'Sd PM', 'JEANE', 'dfbe9b84722f27c60aade2595f9f66da', 29, 1, 'AUX SJD'),
('922504', 'Sd PM', 'SANDRA EVA', '45bc7f693446e6dbf2688e2352fcd43f', 28, 2, 'ATENDENTE'),
('922510', 'Sd PM', 'Claudineia', '6bfbaaf47715a8843c0a27178a81e816', 28, 2, 'atendente'),
('922519', '1º Sgt PM', 'HELENA', 'cb96cf7a8cbddb3224b2a73cf3fc3c11', 28, 1, 'SUPERVISOR'),
('930119', 'Sd PM', 'Almeida', '0fba85e0660bc1d44bc07225677de4d4', 33, 2, 'Aux Adm'),
('930129', 'Sd PM', 'THOMAZ', 'dfbe9b84722f27c60aade2595f9f66da', 31, 2, 'Aux Almox'),
('930183', 'Sd PM', 'Isaltino', 'dfbe9b84722f27c60aade2595f9f66da', 33, 2, 'Aux Adm'),
('930195', 'Sd PM', 'Paulo César', 'f725e5c221c587640792ec6ca5347cd7', 1, 4, 'DESENV'),
('930215', 'Subten PM', 'Neto', '7084a4553e6272e996a723b411f83f4e', 28, 2, 'adm'),
('930417', 'Sd PM Temp', 'Glauce', '3d622b414637d3a5d56459f496e1b84f', 1, 1, 'ATIVO'),
('941220', 'Sd PM', 'Martins', '7fa81ff5e6a88a34ca2392240268c68f', 28, 2, 'despachador'),
('941308', 'Sd PM', 'FARIA', '854c3a50e5d4640e9feaeee47ccbfa7a', 28, 2, 'DESPACHADOR'),
('941330', '1º Sgt PM', 'BERNARDO', 'dfbe9b84722f27c60aade2595f9f66da', 28, 1, 'SUPERVISOR'),
('941349', 'Sd PM', 'Estevan', 'd850d3fbf1187129cda4535a8dd06650', 28, 2, 'atendente'),
('943507', '1º Sgt PM', 'MICHELA', '91504eaf9122940ad21e976dde1dac23', 28, 2, 'SUPERVISOR'),
('943534', 'Cb PM', 'VIVIANE', '086dc10b799096faf145f068ce74fe77', 28, 2, 'ATENDENTE'),
('950132', '1º Sgt PM', 'Jefferson', '2df61fb93d8980ffac785d7f5951cbb6', 28, 2, 'supervisor'),
('950965', '2º Sgt PM', 'NASCIMENTO', 'c2239c0943071c3af526198c381d0500', 31, 1, 'Aux Seç Log'),
('952866', 'Cb PM', 'Lopes', '5145ec1541ee0aad556ed4406cde96e6', 28, 2, 'Atendente'),
('961319', 'Cb PM', 'gabriela', '62d69a07a51f91111f080000bfac114e', 35, 1, 'AUX ADM'),
('961370', 'Sd PM', 'SANDRA REGINA', 'dfbe9b84722f27c60aade2595f9f66da', 29, 1, 'AUXILIAR'),
('961382', 'Sd PM', 'Vania', 'e04755387e5b5968ec213e41f70c1d46', 28, 2, 'atendente'),
('963209', 'Cb PM', 'ARIANA', 'db3678968621c807d38a1da77f7fcce4', 36, 2, 'Aux. Teleco'),
('964635', 'Cb PM', 'ANDREA MARA', 'a9eec830cd68c3609b2dda6cbc53e533', 28, 2, 'INCLUSÃO'),
('964877', '2º Sgt PM', 'ALEX', '02b949ad2931703b16dae12c9f64f08a', 29, 2, 'Aux P/4'),
('964914', '2º Sgt PM', 'Romera', 'dfbe9b84722f27c60aade2595f9f66da', 33, 2, 'Aux Adm'),
('965019', 'Cb PM', 'TULLIO', '81dc9bdb52d04dc20036dbd8313ed055', 28, 2, 'Despachador'),
('965078', '2º Sgt PM', 'SANTOS', 'e10adc3949ba59abbe56e057f20f883e', 31, 1, 'AUX P4'),
('965707', 'Cb PM', 'CANQUERINI', 'dfbe9b84722f27c60aade2595f9f66da', 28, 2, 'atendente'),
('966089', 'Subten PM', 'Carvalho', 'a65daa2d77588f2fb99257b639871940', 28, 2, 'SUPERVISOR'),
('966510', 'Cb PM', 'tatiana', '0778465b2b57181e9b4b2f250e4b9ad6', 28, 2, 'inclusor'),
('975951', 'Cb PM', 'KLEBER', 'ae1d0c3f9a233dc24c2abd17e9732038', 28, 2, 'DESPACHADOR'),
('975976', 'Cb PM', 'FLAVIO', 'cc532d8f00a0705daf78fc79dc9894e6', 28, 2, 'AT/DESP'),
('976038', 'Cb PM', 'DANIEL', '47b2785af9914b26d013cd9aa86c2c69', 28, 2, 'INCLUSOR'),
('981421', 'Cb PM', 'ELAINE CRISTINA', '6858a6cac3b5ec0212a7a7c891320ab1', 28, 2, 'INCLUSOR'),
('991979', 'Sd PM', 'Claudio', '2194204b32465b08e031bf7870dfe19b', 1, 1, 'Aux Telemát'),
('992099', 'Cb PM', 'PERICLES', '2d432ed7eb0ced6f97ab8ca2f475bead', 28, 2, 'DESPACHADOR'),
('992106', 'Sd PM', 'Washington', 'be26abe76fb5c8a4921cf9d3e865b454', 1, 1, 'Aux Telemat'),
('999998', 'Cel PM', 'master', 'eb0a191797624dd3a48fa681d3061212', 1, 1, 'master'),
('999999', 'ADM', 'Administrador', 'ac627ab1ccbdb62ec96e702f07f6425b', 1, 4, 'cmt'),
('MASTER', 'Adm Master', 'MASTER', 'dfbe9b84722f27c60aade2595f9f66da', 36, 4, 'MASTER');

-- CORREÇÃO: A string 'NULL' foi substituída por dados fictícios na coluna `Bi`.
INSERT INTO `sai_posto` (`CodPosto`, `Posto`, `Bi`, `GrupoPosto`, `DescGrupPosto`) VALUES
(101, 'Cel PM', 'RESERVADO', '1', 'Cel PM'),
(102, 'Ten Cel PM', 'RESERVADO', '2', 'Ten Cel PM'),
(103, 'Maj PM', 'RESERVADO', '3', 'Maj PM'),
(104, 'Cap PM', 'RESERVADO', '4', 'Cap PM'),
(105, '1º Ten PM', 'RESERVADO', '5', 'Ten PM'),
(106, '2º Ten PM', 'RESERVADO', '5', 'Ten PM'),
(107, 'Asp Of PM', 'RESERVADO', '5', 'Ten PM'),
(108, 'Al Of PM', 'RESERVADO', '5', 'Ten PM'),
(109, 'Subten PM', 'RESERVADO', '6', 'Subten / Sgt PM'),
(110, '1º Sgt PM', 'RESERVADO', '6', 'Subten / Sgt PM'),
(111, '2º Sgt PM', 'RESERVADO', '6', 'Subten / Sgt PM'),
(112, '3º Sgt PM', 'RESERVADO', '6', 'Subten / Sgt PM'),
(114, 'Cb PM', 'BI-18-CPI2', '7', 'Cb PM'),
(115, 'Sd PM', 'BI-18-CPI2', '7', 'Sd PM'),
(117, 'Sd 2cla PM', 'BI-18-CPI2', '7', 'Sd PM'),
(116, 'Sd PM Temp', 'BI-18-CPI2-T', '7', 'Sd Temp PM');

-- =================================================================
-- DEFINIÇÃO DE ÍNDICES E CHAVES (Mantidas)
-- =================================================================

ALTER TABLE `num_doc` ADD PRIMARY KEY (`Id_Num`), ADD UNIQUE KEY `idx_documento_unico` (`Cod_Org`,`Tipo_Doc`,`Num_Doc`,`Ano_Doc`), ADD KEY `idx_tipo_doc` (`Tipo_Doc`), ADD KEY `idx_elaborador` (`ELABORADOR`);
ALTER TABLE `num_histpd` ADD PRIMARY KEY (`idhis_pd`), ADD KEY `idx_id_pd` (`id_pd`);
ALTER TABLE `num_nivel` ADD PRIMARY KEY (`nivel_id`);
ALTER TABLE `num_opm` ADD PRIMARY KEY (`opm_codigo`);
ALTER TABLE `num_org` ADD PRIMARY KEY (`org_id`), ADD UNIQUE KEY `idx_unidade_secao_unica` (`org_Unidade`,`org_CodSecao`);
ALTER TABLE `num_pd` ADD PRIMARY KEY (`id_pd`), ADD KEY `idx_ord_id` (`ord_id`);
ALTER TABLE `num_tipodoc` ADD PRIMARY KEY (`Tipo_Doc`);
ALTER TABLE `num_user` ADD PRIMARY KEY (`rerg`), ADD KEY `idx_org_id` (`Org_id`), ADD KEY `idx_nivel` (`Nivel`);

ALTER TABLE `num_doc` MODIFY `Id_Num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
ALTER TABLE `num_histpd` MODIFY `idhis_pd` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `num_nivel` MODIFY `nivel_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `num_org` MODIFY `org_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
ALTER TABLE `num_pd` MODIFY `id_pd` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `num_tipodoc` MODIFY `Tipo_Doc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

ALTER TABLE `num_doc` ADD CONSTRAINT `fk_doc_org` FOREIGN KEY (`Cod_Org`) REFERENCES `num_org` (`org_id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_doc_tipodoc` FOREIGN KEY (`Tipo_Doc`) REFERENCES `num_tipodoc` (`Tipo_Doc`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_doc_user` FOREIGN KEY (`ELABORADOR`) REFERENCES `num_user` (`rerg`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `num_user` ADD CONSTRAINT `fk_user_org` FOREIGN KEY (`Org_id`) REFERENCES `num_org` (`org_id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_user_nivel` FOREIGN KEY (`Nivel`) REFERENCES `num_nivel` (`nivel_id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `num_pd` ADD CONSTRAINT `fk_pd_doc` FOREIGN KEY (`ord_id`) REFERENCES `num_doc` (`Id_Num`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `num_histpd` ADD CONSTRAINT `fk_histpd_pd` FOREIGN KEY (`id_pd`) REFERENCES `num_pd` (`id_pd`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Finalização e efetivação da transação
COMMIT;