<?php
require_once('../Connections/conexao.php');

// Define a ação do formulário para o próprio arquivo, protegendo contra XSS.
$editFormAction = htmlspecialchars($_SERVER['PHP_SELF']);
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlspecialchars($_SERVER['QUERY_STRING']);
}

// --- LÓGICA DE ATUALIZAÇÃO DE DADOS PRINCIPAIS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["MM_update"]) && $_POST["MM_update"] == "form1") {
  
  $updateSQL = sprintf("UPDATE num_user SET postfunc=%s, guerra=%s, org_id=%s, nivel_id=%s, situacao=%s WHERE rerg=%s",
                       GetSQLValueString($conexao, $_POST['postfunc'], "text"),
                       GetSQLValueString($conexao, $_POST['guerra'], "text"),
                       GetSQLValueString($conexao, $_POST['org_id'], "int"),
                       GetSQLValueString($conexao, $_POST['nivel_id'], "int"),
                       GetSQLValueString($conexao, $_POST['situacao'], "text"),
                       GetSQLValueString($conexao, $_POST['rerg'], "text"));

  $Result1 = mysqli_query($conexao, $updateSQL);

  if ($Result1) {
    header("Location: okseu.php");
    exit();
  } else {
    die("Erro ao atualizar os dados do usuário: " . mysqli_error($conexao));
  }
}

// --- LÓGICA DE ATUALIZAÇÃO DA SENHA ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["MM_update"]) && $_POST["MM_update"] == "senhanova") {
  
  $updateSQL = sprintf("UPDATE num_user SET senha=%s WHERE rerg=%s",
                       GetSQLValueString($conexao, md5($_POST['senha']), "text"),
                       GetSQLValueString($conexao, $_POST['rerg2'], "text"));

  $Result1 = mysqli_query($conexao, $updateSQL);

  if ($Result1) {
    header("Location: okseu.php");
    exit();
  } else {
    die("Erro ao atualizar a senha: " . mysqli_error($conexao));
  }
}

// --- CONSULTAS PARA PREENCHER O FORMULÁRIO ---

// Validação de entrada para o usuário
if (!isset($_GET['rerg'])) {
    die("Usuário não especificado.");
}
$colname_useer = $_GET['rerg'];

// Busca dados do usuário a ser editado
$query_useer = sprintf("SELECT * FROM num_user WHERE rerg = %s", GetSQLValueString($conexao, $colname_useer, "text"));
$useer_result = mysqli_query($conexao, $query_useer);
$row_useer = mysqli_fetch_assoc($useer_result);
$totalRows_useer = mysqli_num_rows($useer_result);

if ($totalRows_useer == 0) {
    die("Usuário não encontrado.");
}

// Busca a lista de Postos/Graduações
$query_posto = "SELECT * FROM sai_posto ORDER BY cod_posto ASC";
$posto_result = mysqli_query($conexao, $query_posto);

// Busca a lista de Organizações (Seções)
$query_org = "SELECT * FROM num_org ORDER BY org_desc ASC";
$org_result = mysqli_query($conexao, $query_org);

// Busca os Níveis de acesso
$query_nivel = "SELECT * FROM num_nivel ORDER BY nivel_id ASC";
$nivel_result = mysqli_query($conexao, $query_nivel);
?>
<html>
<head>
<title>Numerador - Atualizar Meu Usuário</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
<link href="/numerador/public/css/Geral.css?v=1753940642" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table align="center" bgcolor="#E6E6E6" border="1" cellpadding="5" cellspacing="0">
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="2" align="center" nowrap>
        <font color="#000099" size="3"><strong>ATUALIZAR MEU USUÁRIO</strong></font>
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right"><strong>RE:</strong></td>
      <td>
        <?php echo htmlspecialchars($row_useer['rerg'] ?? ''); ?>
        <input type="hidden" name="rerg" value="<?php echo htmlspecialchars($row_useer['rerg'] ?? ''); ?>">
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right"><strong>Posto / Função:</strong></td>
      <td>
        <select name="postfunc" id="postfunc">
          <option value="">Selecionar</option>
          <?php
          if($posto_result) {
              while ($row_posto = mysqli_fetch_assoc($posto_result)) {
                // *** AQUI ESTÁ A CORREÇÃO PRINCIPAL ***
                // Usando 'posto' com 'p' minúsculo para corresponder à coluna do banco
                $posto_valor = $row_posto['posto'] ?? '';
                $selected = (strcmp($posto_valor, $row_useer['postfunc'] ?? '') == 0) ? "SELECTED" : "";
                echo "<option value=\"" . htmlspecialchars($posto_valor) . "\" $selected>" . htmlspecialchars($posto_valor) . "</option>";
              }
          }
          ?>
        </select>
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right"><strong>Nome de Guerra:</strong></td>
      <td><input type="text" name="guerra" value="<?php echo htmlspecialchars($row_useer['guerra'] ?? ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right"><strong>Situação:</strong></td>
      <td><input type="text" name="situacao" value="<?php echo htmlspecialchars($row_useer['situacao'] ?? ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="2" align="center" nowrap bgcolor="#CCCCCC"> 
        <input name="nivel_id" type="hidden" id="nivel_id" value="<?php echo htmlspecialchars($row_useer['nivel_id'] ?? ''); ?>">
        <input name="org_id" type="hidden" id="org_id" value="<?php echo htmlspecialchars($row_useer['org_id'] ?? ''); ?>">
        <input type="submit" value="ATUALIZAR MEUS DADOS">
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>

<br>

<form action="<?php echo $editFormAction; ?>" method="POST" name="senhanova" id="senhanova">
  <table align="center" bgcolor="#E6E6E6" border="1" cellpadding="5" cellspacing="0">
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="2" align="center" nowrap>
        <font color="#000099" size="3"><strong>TROCAR A SENHA</strong></font>
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right"><strong>Senha Nova:</strong></td>
      <td><input name="senha" type="password" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="2" align="center" nowrap bgcolor="#CCCCCC"> 
        <input name="rerg2" type="hidden" value="<?php echo htmlspecialchars($row_useer['rerg'] ?? ''); ?>">
        <input type="submit" value="TROCAR SENHA">
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="senhanova">
</form>
<p>&nbsp;</p>
  
</body>
</html>
<?php
// Liberando a memória dos resultados das consultas
if($useer_result) mysqli_free_result($useer_result);
if($posto_result) mysqli_free_result($posto_result);
if($org_result) mysqli_free_result($org_result);
if($nivel_result) mysqli_free_result($nivel_result);
?>