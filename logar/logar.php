<?php
require_once('../Connections/conexao.php');

// Validações básicas de entrada
if (empty($_POST['login']) || empty($_POST['senha'])) {
    echo "Login e senha são obrigatórios.";
    echo "<br><a href='javascript:window.history.go(-1)'>Clique aqui para voltar.</a>";
    exit;
}

// Usando a função GetSQLValueString para proteger contra SQL Injection
$login = GetSQLValueString($conexao, $_POST['login'], "text");
$senha = GetSQLValueString($conexao, md5($_POST['senha']), "text");

// A coluna de situação no banco é `situacao`, e não `activo`.
$sql_logar = "SELECT * FROM num_user WHERE rerg = $login AND senha = $senha";
$exe_logar = mysqli_query($conexao, $sql_logar);

if (!$exe_logar) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

$num_logar = mysqli_num_rows($exe_logar);

if ($num_logar == 0) {
    echo "Login ou senha inválido.";
    echo "<br><a href='javascript:window.history.go(-1)'>Clique aqui para voltar.</a>";
} else {
    $fet_logar = mysqli_fetch_assoc($exe_logar);

    // Corrigido para verificar a coluna `situacao` que existe no seu banco de dados.
    if (strtoupper($fet_logar['situacao']) !== 'ATIVO') { 
        echo "Usuário não está ativo. Contate o administrador.";
        echo "<br><a href='javascript:window.history.go(-1)'>Clique aqui para voltar.</a>";
    } else {
        // Inicia a sessão e armazena os dados do usuário
        session_start();
        $_SESSION['login'] = $fet_logar['rerg']; // Armazena o RE/RG do banco
        $_SESSION['senha'] = $fet_logar['senha']; // Armazena a senha do banco (hash)
        
        // Redireciona para a página principal do sistema
        header("Location: principal.php");
        exit(); // Encerra o script após o redirecionamento
    }
}
?>