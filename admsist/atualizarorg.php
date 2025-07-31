<?php 
require_once('../Connections/conexao.php');

// Ação do formulário com proteção XSS
$editFormAction = htmlspecialchars($_SERVER['PHP_SELF']);

// Processamento do formulário de atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["MM_update"]) && $_POST["MM_update"] == "form1") {
    // Query de atualização com nomes de coluna corrigidos
    $updateSQL = sprintf("UPDATE num_org SET org_unidade=%s, org_desc_unid=%s, org_cod_secao=%s, org_desc=%s, org_cidade=%s, org_uf=%s, org_bairro=%s, org_via=%s, org_num=%s, org_ref=%s, org_tel=%s, org_fax=%s, org_email=%s, org_tp=%s, org_obs=%s WHERE org_id=%s",
                       GetSQLValueString($conexao, $_POST['org_unidade'], "int"),
                       GetSQLValueString($conexao, $_POST['org_desc_unid'], "text"),
                       GetSQLValueString($conexao, $_POST['org_cod_secao'], "text"),
                       GetSQLValueString($conexao, $_POST['org_desc'], "text"),
                       GetSQLValueString($conexao, $_POST['org_cidade'], "text"),
                       GetSQLValueString($conexao, $_POST['org_uf'], "text"),
                       GetSQLValueString($conexao, $_POST['org_bairro'], "text"),
                       GetSQLValueString($conexao, $_POST['org_via'], "text"),
                       GetSQLValueString($conexao, $_POST['org_num'], "text"),
                       GetSQLValueString($conexao, $_POST['org_ref'], "text"),
                       GetSQLValueString($conexao, $_POST['org_tel'], "text"),
                       GetSQLValueString($conexao, $_POST['org_fax'], "text"),
                       GetSQLValueString($conexao, $_POST['org_email'], "text"),
                       GetSQLValueString($conexao, $_POST['org_tp'], "text"),
                       GetSQLValueString($conexao, $_POST['org_obs'], "text"),
                       GetSQLValueString($conexao, $_POST['org_id'], "int"));

    $Result1 = mysqli_query($conexao, $updateSQL);

    if ($Result1) {
        $updateGoTo = "acaook.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
            $updateGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $updateGoTo));
        exit();
    } else {
        die("Erro ao atualizar o registro: " . mysqli_error($conexao));
    }
}

// Busca dos dados da seção para exibição no formulário
$colname_secao = "1";
if (isset($_GET['org_id']) && is_numeric($_GET['org_id'])) {
    $colname_secao = $_GET['org_id'];
}

$query_secao = sprintf("SELECT * FROM num_org WHERE org_id = %s", GetSQLValueString($conexao, $colname_secao, "int"));
$secao_result = mysqli_query($conexao, $query_secao);
$row_secao = mysqli_fetch_assoc($secao_result);
$totalRows_secao = mysqli_num_rows($secao_result);

?>
<html>
<head>
<title>Numerador - Atualizar Seção</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
<link href="/numerador/public/css/Geral.css?v=1753940642" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<?php if ($totalRows_secao > 0): ?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table width="655" align="center" bgcolor="#E2E2E2">
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="4" align="center" nowrap><font color="#000099" size="3"><strong>Atualizar Cadastro da Seção</strong></font></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="4" nowrap>
        <table width="100%" align="center">
          <tr valign="baseline"> 
            <td width="20%" align="right" nowrap>Cod da OPM:</td>
            <td width="30%"><input type="text" name="org_unidade" value="<?php echo htmlspecialchars($row_secao['org_unidade']); ?>" size="12"></td>
            <td width="20%" align="right">Descrição da OPM:</td>
            <td width="30%"><input type="text" name="org_desc_unid" value="<?php echo htmlspecialchars($row_secao['org_desc_unid']); ?>" size="45"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Cod. doc da seção:</td>
            <td><input type="text" name="org_cod_secao" value="<?php echo htmlspecialchars($row_secao['org_cod_secao']); ?>" size="12"></td>
            <td align="right">Descrição da Seção:</td>
            <td><input type="text" name="org_desc" value="<?php echo htmlspecialchars($row_secao['org_desc']); ?>" size="45"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="4" align="center" nowrap><font color="#000099" size="3"><strong>Endereço da Seção</strong></font></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="4" nowrap>
        <table width="100%" align="center">
          <tr valign="baseline"> 
            <td align="right" nowrap>Cidade:</td>
            <td><input type="text" name="org_cidade" value="<?php echo htmlspecialchars($row_secao['org_cidade']); ?>" size="30"></td>
            <td align="right">Bairro:</td>
            <td><input type="text" name="org_bairro" value="<?php echo htmlspecialchars($row_secao['org_bairro']); ?>" size="45"></td>
            <td align="right">UF:</td>
            <td><input type="text" name="org_uf" value="<?php echo htmlspecialchars($row_secao['org_uf']); ?>" size="4"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Via:</td>
            <td colspan="5"><input type="text" name="org_via" value="<?php echo htmlspecialchars($row_secao['org_via']); ?>" size="60">
              Nº: 
              <input type="text" name="org_num" value="<?php echo htmlspecialchars($row_secao['org_num']); ?>" size="9">
            </td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Referência:</td>
            <td colspan="5"><input type="text" name="org_ref" value="<?php echo htmlspecialchars($row_secao['org_ref']); ?>" size="32"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="4" align="center" nowrap><font color="#000099" size="3"><strong>Meios de Contato</strong></font></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="4" nowrap>
        <table width="100%" align="center">
          <tr valign="baseline"> 
            <td width="20%" align="right" nowrap>Telefone:</td>
            <td width="30%"><input type="text" name="org_tel" value="<?php echo htmlspecialchars($row_secao['org_tel']); ?>" size="32"></td>
            <td width="20%" align="right" nowrap>Fax:</td>
            <td width="30%"><input type="text" name="org_fax" value="<?php echo htmlspecialchars($row_secao['org_fax']); ?>" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">e-mail:</td>
            <td colspan="3"><input type="text" name="org_email" value="<?php echo htmlspecialchars($row_secao['org_email']); ?>" size="50"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="baseline"> 
      <td align="right" nowrap>Observação:</td>
      <td colspan="3"><input type="text" name="org_obs" value="<?php echo htmlspecialchars($row_secao['org_obs']); ?>" size="80"></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="4" align="center" nowrap bgcolor="#CCCCCC">
        <input type="hidden" name="org_tp" value="<?php echo htmlspecialchars($row_secao['org_tp']); ?>">
        <input name="submit" type="submit" value="Atualizar Registro">
      </td>
    </tr>
  </table>
  <input type="hidden" name="org_id" value="<?php echo $row_secao['org_id']; ?>">
  <input type="hidden" name="MM_update" value="form1">
</form>
<?php else: ?>
  <p align="center">Seção não encontrada. Verifique o ID fornecido.</p>
<?php endif; ?>
</body>
</html>
<?php
mysqli_free_result($secao_result);
?>