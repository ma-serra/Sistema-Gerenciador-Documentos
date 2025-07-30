### Sistema de Numerador Documentos

<div align="center">
    <img src="https://github.com/alexandrefreitass/numerador/assets/109884524/617b7155-6a93-490c-a747-509984ca0cdd"/>
</div>
<br/>
Desenvolvido em PHP e integrado ao banco de dados MySQL, o projeto é uma aplicação web completa que atua como um sistema de gerenciamento de documentos, 
conhecido como numerador. Com ele, os usuários podem facilmente organizar, classificar e acessar documentos de forma eficiente. Seja para empresas, 
instituições educacionais ou qualquer outra organização, o numerador oferece uma solução abrangente para o controle de documentos, garantindo uma gestão 
organizada e acessível.

### Consulta de Documentos::

Os usuários podem consultar o numerador para acessar documentos criados por eles próprios, permitindo uma fácil visualização e recuperação de informações relevantes.
    
# Supervisão de Documentos:

Além disso, o sistema possui diferentes níveis de supervisores, que têm permissão para visualizar o numerador de documentos criados por outros usuários. Isso facilita a supervisão e colaboração entre os membros da equipe.

# Autenticação Segura:

O sistema conta com um sistema de autenticação seguro, onde as senhas dos usuários são criptografadas, garantindo a segurança dos dados e protegendo contra acessos não autorizados.

Clone o projeto

```bash
  git clone https://github.com/alexandrefreitass/numerador.git
```

Instale o xampp para usar offline versão do php do projeto é 8.2.9

Cole o projeto dentro do htdocs do Xampp

Edite o arquivo conexao.php dentro da pasta conections
```bash
    $hostname_conexao = "localhost";
    $database_conexao = "numerador_db";
    $username_conexao = "root";
    $password_conexao = "";
```

Apos isto, abra o navegador localhost/phpmyadmin

Digite um nome do banco para criar nome_do_banco de preferencia use numerador_db

Clique em importar, clique em  escolher e selecione o arquivo banco_de_dados.sql que foi enviado junto no anexo.

Execute o xampp e start no apache e mysql:

```bash
  localhost:8080 ou a porta definida por voce
```