<?php
include("config.php");

$login = $_POST['login'];
$senha = md5($_POST['senha']);

/* Verifica se existe usuario, o segredo ta aqui quando ele procupa uma 
linha q contenha o login e a senha digitada */
$sql_logar = "SELECT * FROM num_user WHERE rerg = '$login' && senha = '$senha'";
$exe_logar = mysqli_query($conexao, $sql_logar);
$fet_logar = mysqli_fetch_assoc($exe_logar);
$num_logar = mysqli_num_rows($exe_logar);

//Verifica se n existe uma linha com o login e a senha digitado
if ($num_logar == 0){
   echo "Login ou senha invalido.";
   echo "<br><a href='javascript:window.history.go(-1)'>Clique aqui para volta.</a>";   
} 
elseif($fet_logar['activo'] == "N"){
   echo "Usuario nao ativado, verifique seu e-mail para ativa a conta.";
   echo "<br><a href='javascript:window.history.go(-1)'>Clique aqui para volta.</a>"; 
}
else{
   //Cria a sessao e manda pra pagina principal.php
   session_start();
   $_SESSION['login'] = $login;
   $_SESSION['senha'] = $senha;
   
   header("Location:principal.php");
}
?>