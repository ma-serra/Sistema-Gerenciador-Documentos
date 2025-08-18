# Sistema de Automação Jurídica

Esta extensão adiciona funcionalidades de automação jurídica ao Sistema Gerenciador de Documentos, permitindo o acompanhamento automatizado de processos judiciais através de web scraping e integração com tribunais.

## 🚀 Funcionalidades Implementadas

### 📊 Gestão de Clientes
- Cadastro completo de clientes (pessoa física/jurídica)
- Perfil detalhado com estatísticas de processos
- Busca e filtragem de clientes
- Interface responsiva e intuitiva

### ⚖️ Acompanhamento de Processos
- Cadastro e acompanhamento de processos jurídicos
- Histórico completo de movimentações
- Integração com múltiplos tribunais
- Atualizações automáticas via scraping

### 🤖 Sistema de Automação
- Scraping automatizado de tribunais (TJSP, TRT2, TRF3)
- Triggers configuráveis (agendados, email, push)
- Processamento de notificações por email
- Logs detalhados de execução

### 📈 Relatórios e Exportação
- Planilhas de clientes em Excel/CSV
- Relatórios de processos e movimentações
- Planilha mãe consolidada
- Resumos estatísticos por cliente

## 🛠️ Instalação

1. **Execute o Setup:**
   ```
   Acesse: /numerador/setup_legal_system.php
   ```

2. **Configurar Automação (Opcional):**
   ```bash
   # Adicionar ao crontab para execução diária às 8h
   0 8 * * * /usr/bin/php /caminho/para/automation_cron.php
   ```

3. **Acessar o Sistema:**
   - Menu Principal → ⚖️ JURÍDICO
   - Ou direto: `/numerador/legal_automation.php`

## 📁 Estrutura de Arquivos

```
numerador/
├── legal_automation.php      # Painel principal
├── manage_clients.php        # Gestão de clientes
├── client_profile.php        # Perfil do cliente
├── court_scraper.php         # Framework de scraping
├── export_data.php           # Exportação de dados
├── export_interface.php      # Interface de exportação
├── automation_cron.php       # Script para cron job
└── setup_legal_system.php    # Instalação do sistema

db/
└── legal_system_tables.sql   # Estrutura do banco de dados
```

## 🗄️ Tabelas do Banco de Dados

- `legal_clients` - Dados dos clientes
- `legal_processes` - Processos jurídicos
- `process_movements` - Movimentações/andamentos
- `court_sources` - Fontes de dados (tribunais)
- `automation_triggers` - Configurações de automação
- `scraping_logs` - Logs de execução

## ⚙️ Configuração Avançada

### Web Scraping
O sistema inclui um framework básico para scraping de tribunais. Para produção, configure:

1. **URLs reais dos tribunais**
2. **Tratamento de CAPTCHAs**
3. **Proxy/rate limiting**
4. **Credenciais de APIs quando disponíveis**

### Notificações por Email
Configure o processamento IMAP em `court_scraper.php`:

```php
// Exemplo de configuração IMAP
$imap_config = [
    'host' => 'imap.gmail.com',
    'port' => 993,
    'encryption' => 'ssl',
    'username' => 'seu-email@gmail.com',
    'password' => 'sua-senha'
];
```

### Triggers Personalizados
Adicione novos triggers através da interface ou diretamente no banco:

```sql
INSERT INTO automation_triggers 
(trigger_name, trigger_type, schedule_expression, source_id, status) 
VALUES ('Custom Trigger', 'SCHEDULED', '0 */6 * * *', 1, 'ATIVO');
```

## 🔧 Uso do Sistema

### 1. Cadastro de Clientes
- Acesse "👥 Gerenciar Clientes"
- Preencha os dados do cliente
- O sistema suporta pessoas físicas e jurídicas

### 2. Acompanhamento de Processos
- No perfil do cliente, adicione processos
- O sistema buscará automaticamente atualizações
- Movimentações são registradas automaticamente

### 3. Automação
- Configure triggers no painel principal
- Execute scraping manual ou automático
- Monitore logs de execução

### 4. Relatórios
- Exporte dados em Excel ou CSV
- Gere relatórios consolidados
- Acompanhe estatísticas por cliente

## 🔍 Tribunais Suportados (Simulação)

- **TJSP** - Tribunal de Justiça de São Paulo
- **TRT2** - Tribunal Regional do Trabalho 2ª Região
- **TRF3** - Tribunal Regional Federal 3ª Região

*Nota: A versão atual inclui simulação de scraping. Para produção, implemente a integração real com as APIs/sites dos tribunais.*

## 🚨 Importante

Este sistema foi desenvolvido como uma extensão educacional e demonstrativa. Para uso em produção:

1. ✅ Implemente autenticação robusta
2. ✅ Configure backups automáticos
3. ✅ Adicione logs de auditoria
4. ✅ Teste thoroughly com dados reais
5. ✅ Considere aspectos legais do scraping
6. ✅ Implemente rate limiting
7. ✅ Configure monitoramento

## 🆘 Suporte

Para problemas ou dúvidas:
1. Verifique os logs em `/tmp/legal_automation.log`
2. Acesse o painel de automação para diagnósticos
3. Execute o setup novamente se necessário

---

*Sistema integrado ao Gerenciador de Documentos - Extensão Jurídica v1.0*