<?php
// 1. INICIALIZAÇÃO E CONEXÃO
// =============================
// Inclui o arquivo de conexão que contém a função de segurança GetSQLValueString.
require_once('../Connections/conexao.php');

// Define a ação do formulário para o próprio arquivo.
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

// 2. LÓGICA DE ATUALIZAÇÃO DE DADOS
// =================================
// --- ATUALIZAÇÃO DOS DADOS PRINCIPAIS ---
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  
  // Correção CRÍTICA: As colunas no banco são `org_id` e `nivel_id`.
  $updateSQL = sprintf("UPDATE num_user SET postfunc=%s, guerra=%s, org_id=%s, nivel_id=%s, situacao=%s WHERE rerg=%s",
                       GetSQLValueString($conexao, $_POST['postfunc'], "text"),
                       GetSQLValueString($conexao, $_POST['guerra'], "text"),
                       GetSQLValueString($conexao, $_POST['org_id'], "int"),
                       GetSQLValueString($conexao, $_POST['Nivel'], "int"), // O campo do formulário é 'Nivel'
                       GetSQLValueString($conexao, $_POST['situacao'], "text"),
                       GetSQLValueString($conexao, $_POST['rerg'], "text"));

  $Result1 = mysqli_query($conexao, $updateSQL);

  if ($Result1) {
    $updateGoTo = "acaookuser.php";
    // Lógica para manter os parâmetros da URL no redirecionamento.
    if (isset($_SERVER['QUERY_STRING'])) {
      $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
    exit();
  } else {
    die("Erro ao atualizar os dados do usuário: " . mysqli_error($conexao));
  }
}

// --- ATUALIZAÇÃO DA SENHA ---
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "senhanova")) {
  
  $updateSQL = sprintf("UPDATE num_user SET senha=%s WHERE rerg=%s",
                       GetSQLValueString($conexao, md5($_POST['senha']), "text"),
                       GetSQLValueString($conexao, $_POST['rerg2'], "text"));

  $Result1 = mysqli_query($conexao, $updateSQL);

  if ($Result1) {
    $updateGoTo = "acaookuser.php";
    if (isset($_SERVER['QUERY_STRING'])) {
      $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
    exit();
  } else {
    die("Erro ao atualizar a senha do usuário: " . mysqli_error($conexao));
  }
}

// 3. CONSULTAS PARA PREENCHER O FORMULÁRIO
// ==========================================
// Busca dados do usuário a ser editado.
$colname_user = "-1";
if (isset($_GET['rerg'])) {
  $colname_user = $_GET['rerg'];
}
$query_user = sprintf("SELECT * FROM num_user WHERE rerg = %s", GetSQLValueString($conexao, $colname_user, "text"));
$user_result = mysqli_query($conexao, $query_user);
$row_user = mysqli_fetch_assoc($user_result);
$totalRows_user = mysqli_num_rows($user_result);

// Busca a lista de Postos/Graduações.
$query_posto = "SELECT * FROM sai_posto ORDER BY cod_posto ASC";
$posto_result = mysqli_query($conexao, $query_posto);

// Busca a lista de Organizações.
$query_org = "SELECT * FROM num_org ORDER BY org_desc ASC";
$org_result = mysqli_query($conexao, $query_org);

// Busca os Níveis de acesso.
$query_nivel = "SELECT * FROM num_nivel ORDER BY nivel_id ASC";
$nivel_result = mysqli_query($conexao, $query_nivel);
?>
<html>
<head>
<title>Numerador - Atualizar Usuário</title>
<link href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table align="center" bgcolor="#E6E6E6">
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="2" align="center" nowrap><font color="#000099" size="3">Atualizar Cadastro de Usuário</font></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">RE:</td>
      <td><?php echo htmlspecialchars($row_user['rerg']); ?><input type="hidden" name="rerg" value="<?php echo htmlspecialchars($row_user['rerg']); ?>"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Posto:</td>
      <td> 
        <select name="postfunc" id="postfunc">
          <option value="" <?php if (empty($row_user['postfunc'])) { echo "SELECTED"; } ?>>Selecionar...</option>
          <?php
          while($row_posto_loop = mysqli_fetch_assoc($posto_result)) {
            $selected = ($row_posto_loop['Posto'] == $row_user['postfunc']) ? "SELECTED" : "";
            echo "<option value=\"" . htmlspecialchars($row_posto_loop['Posto']) . "\" $selected>" . htmlspecialchars($row_posto_loop['Posto']) . "</option>";
          }
          ?>
        </select>
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Guerra:</td>
      <td><input type="text" name="guerra" value="<?php echo htmlspecialchars($row_user['guerra']); ?>" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Seção:</td>
      <td> 
        <select name="org_id" id="org_id">
          <option value="" <?php if (empty($row_user['org_id'])) { echo "SELECTED"; } ?>>Selecionar...</option>
          <?php
          mysqli_data_seek($org_result, 0);
          while($row_org_loop = mysqli_fetch_assoc($org_result)) {
            // Correção: a coluna é 'org_id'
            $selected = ($row_org_loop['org_id'] == $row_user['org_id']) ? "SELECTED" : "";
            echo "<option value=\"" . $row_org_loop['org_id'] . "\" $selected>" . htmlspecialchars($row_org_loop['org_desc']) . "</option>";
          }
          ?>
        </select> 
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Nível:</td>
      <td> 
        <select name="Nivel" id="Nivel">
          <option value="" <?php if (empty($row_user['nivel_id'])) { echo "SELECTED"; } ?>>Selecione...</option>
          <?php
          mysqli_data_seek($nivel_result, 0);
          while($row_nivel_loop = mysqli_fetch_assoc($nivel_result)) {
            // Correção: a coluna é 'nivel_id'
            $selected = ($row_nivel_loop['nivel_id'] == $row_user['nivel_id']) ? "SELECTED" : "";
            echo "<option value=\"" . $row_nivel_loop['nivel_id'] . "\" $selected>" . htmlspecialchars($row_nivel_loop['desc_nivel']) . "</option>";
          }
          ?>
        </select> 
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Função:</td>
      <td><input type="text" name="situacao" value="<?php echo htmlspecialchars($row_user['situacao']); ?>" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="2" align="center" nowrap bgcolor="#CCCCCC"> 
        <input type="submit" value="Atualizar Registro">
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>

<br/>

<form action="<?php echo $editFormAction; ?>" method="POST" name="senhanova" id="senhanova">
  <table align="center" bgcolor="#E6E6E6">
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="2" align="center" nowrap><font color="#000099" size="3">Trocar a Senha</font></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Senha Nova:</td>
      <td><input name="senha" type="password" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="2" align="center" nowrap bgcolor="#CCCCCC"> 
        <input name="rerg2" type="hidden" id="rerg2" value="<?php echo htmlspecialchars($row_user['rerg']); ?>">
        <input name="submit" type="submit" value="Trocar a Senha">
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="senhanova">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
// 4. LIBERAÇÃO DE MEMÓRIA
// =======================
mysqli_free_result($user_result);
mysqli_free_result($posto_result);
mysqli_free_result($org_result);
mysqli_free_result($nivel_result);
?>