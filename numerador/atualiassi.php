<?php require_once('../Connections/conexao.php'); ?>
<?php

$editFormAction = htmlspecialchars($_SERVER['PHP_SELF']);
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlspecialchars($_SERVER['QUERY_STRING']);
}

// Lógica de atualização quando o formulário é enviado
if ((isset($_GET["MM_update"])) && ($_GET["MM_update"] == "form1")) {
  
  // *** CORREÇÃO APLICADA EM TODAS AS LINHAS ABAIXO ***
  $updateSQL = sprintf("UPDATE num_doc SET assunto=%s, destino=%s, elaborado=%s, assinado=%s, encaminhado=%s, obs_doc=%s WHERE id_num=%s",
    GetSQLValueString($conexao, $_GET['assunto'], "text"),
    GetSQLValueString($conexao, $_GET['destino'], "text"),
    GetSQLValueString($conexao, $_GET['ELABORADO'], "int"),
    GetSQLValueString($conexao, $_GET['ASSINADO'], "int"),
    GetSQLValueString($conexao, $_GET['ENCAMINHADO'], "int"),
    GetSQLValueString($conexao, $_GET['observacao'], "text"),
    GetSQLValueString($conexao, $_GET['id_num'], "int"));

  $Result1 = mysqli_query($conexao, $updateSQL);

  if ($Result1) {
    $updateGoTo = "acaooknumatual.php";
    if (isset($_SERVER['QUERY_STRING'])) {
      $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
    exit();
  } else {
    die("Erro ao atualizar o documento: " . mysqli_error($conexao));
  }
}

// Busca dos dados para exibir na página
$colname_atualizar = "1";
if (isset($_GET['id_num'])) {
  $colname_atualizar = $_GET['id_num'];
}

// *** CORREÇÃO APLICADA NA LINHA 38 (ORIGEM DO ERRO) ***
$query_atualizar = sprintf("SELECT d.id_num, d.cod_org, t.desc_tipo_doc, d.num_doc, d.cod_sec, d.ano_doc, d.assunto, d.destino, d.data, d.elaborador, d.obs_doc, d.elaborado, d.assinado, d.encaminhado 
                           FROM num_doc d 
                           INNER JOIN num_tipodoc t ON (d.tipo_doc = t.tipo_doc) 
                           WHERE (d.id_num = %s)", GetSQLValueString($conexao, $colname_atualizar, "int"));

$atualizar = mysqli_query($conexao, $query_atualizar);
$row_atualizar = mysqli_fetch_assoc($atualizar);
$totalRows_atualizar = mysqli_num_rows($atualizar);
?>
<html>
<head>
<title>Numerador</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
<link  href="/numerador/public/css/Geral.css?v=1753940642" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="get" name="form1">
  <table width="400" border="12" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
    <tr> 
      <td height="28" colspan="2" bgcolor="#CCCCCC"><div align="center"><font color="#000099" size="3">ATUALIZAR&nbsp;&nbsp;<?php echo htmlspecialchars($row_atualizar['desc_tipo_doc'] ?? ''); ?> 
          n&ordm; <?php echo htmlspecialchars($row_atualizar['num_doc'] ?? ''); ?> / <?php echo htmlspecialchars($row_atualizar['cod_sec'] ?? ''); ?> 
          / <?php echo htmlspecialchars($row_atualizar['ano_doc'] ?? ''); ?></font> </div></td>
    </tr>
    <tr> 
      <td height="193" colspan="2" bgcolor="#FFFFFF"> <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap bgcolor="#CCCCCC"> <div align="center">assunto:</div>
              <div align="center"> </div></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap><textarea name="assunto" cols="70" rows="3"><?php echo htmlspecialchars($row_atualizar['assunto'] ?? ''); ?></textarea></td>
          </tr>
          <tr valign="baseline"> 
            <td height="17" align="right" valign="middle" nowrap bgcolor="#CCCCCC"> 
              <div align="center">destino:</div>
              <div align="center"> </div></td>
          </tr>
          <tr valign="baseline"> 
            <td height="18" align="right" valign="middle" nowrap><textarea name="destino" cols="70" rows="3"><?php echo htmlspecialchars($row_atualizar['destino'] ?? ''); ?></textarea></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap bgcolor="#CCCCCC"> <div align="center">OBSERVAÇÃO:</div>
              <div align="center"> </div></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap><textarea name="observacao" cols="70" rows="5" id="observacao"><?php echo htmlspecialchars($row_atualizar['obs_doc'] ?? ''); ?></textarea></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap bgcolor="#CCCCCC"> <div align="center">ELABORADO:&nbsp;&nbsp;&nbsp;&nbsp;N&atilde;o 
                <input  <?php if (!(strcmp($row_atualizar['elaborado'],"0"))) {echo "CHECKED";} ?> name="ELABORADO" type="radio" value="0" checked>
                &nbsp;&nbsp;&nbsp;SIM 
                <input  <?php if (!(strcmp($row_atualizar['elaborado'],"1"))) {echo "CHECKED";} ?> type="radio" name="ELABORADO" value="1">
              </div></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" nowrap bgcolor="#CCCCCC"> <div align="center"> 
                <input type="hidden" name="MM_update" value="form1">
                <input name="submit" type="submit" value="Atualizar registro">
                <input name="id_num" type="hidden" id="id_num2" value="<?php echo htmlspecialchars($row_atualizar['id_num'] ?? ''); ?>">
                <input name="ASSINADO" type="hidden" id="ASSINADO2" value="<?php echo htmlspecialchars($row_atualizar['assinado'] ?? ''); ?>">
                <input name="ENCAMINHADO" type="hidden" id="ENCAMINHADO2" value="<?php echo htmlspecialchars($row_atualizar['encaminhado'] ?? ''); ?>">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
if ($atualizar) {
    mysqli_free_result($atualizar);
}
?>