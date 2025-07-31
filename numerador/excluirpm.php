<?php
// 1. INICIALIZAÇÃO E CONEXÃO
// =============================
// Usamos require_once para garantir que a conexão e as funções sejam carregadas apenas uma vez.
require_once('../Connections/conexao.php');

// 2. LÓGICA DE EXCLUSÃO (PROCESSAMENTO DO FORMULÁRIO)
// ===================================================
// Esta parte SÓ é executada se o formulário for enviado (método POST).
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rerg'])) {
    
    // Prepara o SQL para deletar o usuário, usando a função de segurança.
    $deleteSQL = sprintf("DELETE FROM num_user WHERE rerg=%s",
                       GetSQLValueString($conexao, $_POST['rerg'], "text"));

    $Result1 = mysqli_query($conexao, $deleteSQL);

    // Verifica se a exclusão deu certo.
    if ($Result1) {
        // Redireciona para a página de sucesso.
        $deleteGoTo = "acaoexcluiruser.php";
        header(sprintf("Location: %s", $deleteGoTo));
        exit(); // Encerra o script após o redirecionamento.
    } else {
        // Se der erro, exibe uma mensagem clara.
        die("Erro ao excluir o usuário: " . mysqli_error($conexao));
    }
}

// 3. LÓGICA DE EXIBIÇÃO (CARREGAMENTO DA PÁGINA)
// =================================================
// Esta parte SÓ é executada quando a página é carregada pela primeira vez (método GET).
// Garante que temos um 'rerg' na URL para saber quem mostrar.
if (!isset($_GET['rerg'])) {
    die("Nenhum usuário especificado para exclusão.");
}

$colname_USER = $_GET['rerg'];

// Busca os dados do usuário para exibir na tela de confirmação.
$query_USER = sprintf("SELECT * FROM num_user WHERE rerg = %s", GetSQLValueString($conexao, $colname_USER, "text"));
$USER_result = mysqli_query($conexao, $query_USER);

if (!$USER_result) {
    die("Erro ao buscar dados do usuário: " . mysqli_error($conexao));
}

$row_USER = mysqli_fetch_assoc($USER_result);
$totalRows_USER = mysqli_num_rows($USER_result);

// Se o usuário não for encontrado, não há o que excluir.
if ($totalRows_USER == 0) {
    echo "Usuário não encontrado.";
    exit();
}
?>
<html>
<head>
<title>Confirmar Exclusão de Usuário</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
<link href="/numerador/public/css/Geral.css?v=1753940642" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?rerg=<?php echo htmlspecialchars($row_USER['rerg']); ?>">
  <table align="center" border="1" cellpadding="10" cellspacing="0" bgcolor="#E6E6E6">
    <tr bgcolor="#CCCCCC">
      <td align="center">
        <font color="#990000" size="4"><strong>CONFIRMAR EXCLUSÃO</strong></font>
      </td>
    </tr>
    <tr>
      <td align="center">
        <p>Você tem certeza que deseja excluir permanentemente o usuário?</p>
        <p>
          <font size="3">
            <strong><?php echo htmlspecialchars($row_USER['postfunc']); ?>&nbsp;&nbsp;<?php echo htmlspecialchars($row_USER['guerra']); ?></strong>
          </font>
        </p>
        <p><strong>RE:</strong> <?php echo htmlspecialchars($row_USER['rerg']); ?></p>
        <p>Esta ação não pode ser desfeita.</p>
      </td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <td align="center">
        <input name="rerg" type="hidden" id="rerg" value="<?php echo htmlspecialchars($row_USER['rerg']); ?>">
        <input type="submit" name="Submit" value="SIM, EXCLUIR USUÁRIO" style="background-color: #d9534f; color: white; padding: 10px; border: none; cursor: pointer;">
        <input type="button" name="Cancel" value="CANCELAR" onclick="window.history.back();" style="padding: 10px; cursor: pointer;">
      </td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
// Libera a memória do resultado da consulta.
mysqli_free_result($USER_result);
?>