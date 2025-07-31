# Sistema Gerenciador de Documentos (Numerador)

<div align="center">
    <img src="https://github.com/alexandrefreitass/numerador/assets/109884524/1f1a55be-8c4e-4a76-82ee-71a6f4e6d531" alt="Logo do Sistema Numerador" width="600"/>
</div>

<br/>

<div align="center">
    <img src="https://img.shields.io/badge/PHP-8.2.9-777BB4?style=for-the-badge&logo=php" alt="PHP 8.2.9"/>
    <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"/>
    <img src="https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge" alt="License: MIT"/>
</div>

## 📋 Sobre o Projeto

Este projeto é uma aplicação web robusta, desenvolvida em PHP puro e integrada com banco de dados MySQL, que atua como um sistema de gerenciamento e numeração de documentos. A solução oferece uma plataforma centralizada para organizar, classificar e rastrear documentos de forma eficiente, garantindo uma gestão organizada e acessível para qualquer tipo de organização.

## ✨ Principais Funcionalidades

- **Consulta Centralizada:** Permite que os usuários acessem rapidamente os documentos criados por eles
- **Controle de Acesso por Nível:** O sistema possui diferentes níveis de permissão (Usuário, Administrador, Comandante), permitindo que supervisores visualizem documentos de suas equipes, facilitando a gestão e colaboração
- **Autenticação Segura:** As senhas dos usuários são criptografadas utilizando MD5, garantindo a segurança dos dados e protegendo contra acessos não autorizados

## 🚀 Primeiros Passos (Setup com Laragon)

Este guia assume que você está utilizando o **Laragon** ou um ambiente de desenvolvimento similar (WAMP, XAMPP).

### Pré-requisitos

- Laragon (ou outro servidor local com PHP 8.2+ e MySQL)
- Um cliente de banco de dados como o HeidiSQL (incluso no Laragon) ou DBeaver
- Git instalado

### 1. Clonar o Repositório

Navegue até o diretório `www` do seu Laragon e clone o projeto:

```bash
# Dentro da pasta C:\laragon\www
git clone https://github.com/alexandrefreitass/numerador.git
```

Após clonar, renomeie a pasta se desejar (ex: numerador).

### 2. Configurar o Banco de Dados

1. Com o Laragon em execução, clique em "Database" para abrir o HeidiSQL
2. Crie um novo banco de dados. O nome recomendado é `numerador_db`:

```sql
CREATE DATABASE numerador_db;
```

3. Selecione o banco `numerador_db` recém-criado
4. Vá em "Arquivo" > "Carregar arquivo SQL..." e selecione o arquivo `db/numerador_db.sql` que está na raiz do projeto
5. Execute o script para importar a estrutura e os dados iniciais

### 3. Configurar a Conexão

O arquivo de conexão já vem pré-configurado para o ambiente padrão do Laragon. Verifique se as credenciais em `Connections/conexao.php` correspondem às do seu ambiente:

```php
$hostname_conexao = "localhost";
$database_conexao = "numerador_db";
$username_conexao = "root";
$password_conexao = ""; // A senha padrão do Laragon é vazia
```

### 4. Acessar a Aplicação

1. Certifique-se de que o Apache e o MySQL estão rodando no seu Laragon
2. Acesse o projeto no seu navegador. O Laragon geralmente cria um "pretty URL". Você poderá acessar por:
   - `http://numerador.test` (ou o nome da pasta que você usou)

Pronto! O sistema está online. Você pode logar com os usuários de teste presentes no banco de dados.

## 📁 Estrutura do Projeto

```
numerador/
├── admsist/          # Módulos administrativos
├── Connections/      # Configurações de conexão com BD
├── db/              # Scripts de banco de dados
├── logar/           # Sistema de autenticação
├── numerador/       # Módulo principal do sistema
├── public/          # Arquivos públicos (CSS, imagens)
└── README.md
```

## 🤝 Contribuição

Contribuições são sempre bem-vindas! Para contribuir:

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Consulte o arquivo [LICENSE](LICENSE) para obter mais detalhes.