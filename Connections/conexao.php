<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexao = "localhost";
$database_conexao = "numerador_db";
$username_conexao = "root";
$password_conexao = "";
$conexao = mysqli_connect($hostname_conexao, $username_conexao, $password_conexao, $database_conexao);
## $conn = mysqli_connect($servername, $username, $password, $database);
?>