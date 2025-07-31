<?php require_once('../Connections/conexao.php'); ?>
<?php

$editFormAction = htmlspecialchars($_SERVER['PHP_SELF']);
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlspecialchars($_SERVER['QUERY_STRING']);
}

// **BOA PRÁTICA:** Ações que modificam dados devem usar POST.
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    
  // **CORREÇÃO:** Adicionado $conexao em todas as chamadas GetSQLValueString.
  // **CORREÇÃO:** O campo do formulário para observação foi corrigido para 'observacao'.
  $updateSQL = sprintf("UPDATE num_doc SET assunto=%s, destino=%s, elaborado=%s, assinado=%s, encaminhado=%s, obs_doc=%s WHERE id_num=%s",
                       GetSQLValueString($conexao, $_POST['assunto'], "text"),
                       GetSQLValueString($conexao, $_POST['destino'], "text"),
                       GetSQLValueString($conexao, $_POST['ELABORADO'], "int"),
                       GetSQLValueString($conexao, $_POST['ASSINADO'], "int"),
                       GetSQLValueString($conexao, $_POST['ENCAMINHADO'], "int"),
                       GetSQLValueString($conexao, $_POST['observacao'], "text"), // Nome do campo corrigido
                       GetSQLValueString($conexao, $_POST['id_num'], "int"));

  $Result1 = mysqli_query($conexao, $updateSQL);

  if ($Result1) {
    $updateGoTo = "acaooknumatual.php";
    // Mantendo os parâmetros GET na URL para a página de sucesso
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

// --- Busca de dados para exibir no formulário ---

// **BOA PRÁTICA:** Validar e usar GetSQLValueString em todas as entradas.
$num_doc_get = isset($_GET['num_doc']) ? $_GET['num_doc'] : '';
$cod_org_get = isset($_GET['cod_org']) ? $_GET['cod_org'] : '';
$tipo_doc_get = isset($_GET['tipo_doc']) ? $_GET['tipo_doc'] : '';
$ano_doc_get = isset($_GET['ano_doc']) ? $_GET['ano_doc'] : '';

// **CORREÇÃO (SEGURANÇA):** Consulta protegida contra SQL Injection.
$query_novo = sprintf("SELECT * FROM num_doc WHERE cod_org = %s  AND tipo_doc = %s AND ano_doc = %s  AND num_doc = %s", 
    GetSQLValueString($conexao, $cod_org_get, "int"),
    GetSQLValueString($conexao, $tipo_doc_get, "int"),
    GetSQLValueString($conexao, $ano_doc_get, "text"),
    GetSQLValueString($conexao, $num_doc_get, "text")
);
$novo = mysqli_query($conexao, $query_novo);
$row_novo = mysqli_fetch_assoc($novo);
$totalRows_novo = mysqli_num_rows($novo);

// **CORREÇÃO (SEGURANÇA):** Consulta protegida contra SQL Injection.
$query_documento = sprintf("SELECT * FROM num_tipodoc WHERE tipo_doc = %s", GetSQLValueString($conexao, $tipo_doc_get, "int"));
$documento = mysqli_query($conexao, $query_documento);
$row_documento = mysqli_fetch_assoc($documento);
$totalRows_documento = mysqli_num_rows($documento);
?>
<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table width="400" border="12" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
    <tr> 
      <td height="28" colspan="2" bgcolor="#CCCCCC"><div align="center"><font color="#000099" size="3">CRIADO&nbsp;&nbsp;<?php echo htmlspecialchars($row_documento['desc_tipo_doc'] ?? ''); ?> N&ordm; <?php echo htmlspecialchars($row_novo['num_doc'] ?? ''); ?> / <?php echo htmlspecialchars($row_novo['cod_sec'] ?? ''); ?> / <?php echo htmlspecialchars($row_novo['ano_doc'] ?? ''); ?></font> </div></td>
    </tr>
    <tr> 
      <td height="193" colspan="2" bgcolor="#FFFFFF"> <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap bgcolor="#CCCCCC"> <div align="center">assunto:</div></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap><textarea name="assunto" cols="70" rows="3" id="assunto"><?php echo htmlspecialchars($row_novo['assunto'] ?? ''); ?></textarea></td>
          </tr>
          <tr valign="baseline"> 
            <td height="17" align="right" valign="middle" nowrap bgcolor="#CCCCCC"> 
              <div align="center">destino:</div></td>
          </tr>
          <tr valign="baseline"> 
            <td height="18" align="right" valign="middle" nowrap><textarea name="destino" cols="70" rows="3" id="destino"><?php echo htmlspecialchars($row_novo['destino'] ?? ''); ?></textarea></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap bgcolor="#CCCCCC"> <div align="center">OBSERVAÇÃO:</div></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap><textarea name="observacao" cols="70" rows="5" id="observacao"><?php echo htmlspecialchars($row_novo['obs_doc'] ?? ''); ?></textarea></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap bgcolor="#CCCCCC"> <div align="center">ELABORADO:&nbsp;&nbsp;&nbsp;&nbsp;Não 
                <input  <?php if (!(strcmp($row_novo['elaborado'] ?? '0',"0"))) {echo "CHECKED";} ?> name="ELABORADO" type="radio" value="0" checked>
                &nbsp;&nbsp;&nbsp;SIM 
                <input  <?php if (!(strcmp($row_novo['elaborado'] ?? '0',"1"))) {echo "CHECKED";} ?> type="radio" name="ELABORADO" value="1">
              </div></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" nowrap bgcolor="#CCCCCC"> <div align="center"> 
                <input name="submit" type="submit" value="Atualizar Registro">
                <input name="id_num" type="hidden" id="id_num" value="<?php echo htmlspecialchars($row_novo['id_num'] ?? ''); ?>">
                <input name="ASSINADO" type="hidden" id="ASSINADO" value="<?php echo htmlspecialchars($row_novo['assinado'] ?? '0'); ?>">
                <input name="ENCAMINHADO" type="hidden" id="ENCAMINHADO" value="<?php echo htmlspecialchars($row_novo['encaminhado'] ?? '0'); ?>">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
</body>
</html>
<?php
if ($novo) mysqli_free_result($novo);
if ($documento) mysqli_free_result($documento);
?>