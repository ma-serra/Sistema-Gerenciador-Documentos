<?php
session_start();

// Verifica se o usuário já está logado
if (isset($_SESSION['login']) && isset($_SESSION['senha'])) {
    // Usuário está logado, redireciona para principal
    header("Location: principal.php");
    exit();
} else {
    // Usuário não está logado, redireciona para login
    header("Location: login.php");
    exit();
}
?>