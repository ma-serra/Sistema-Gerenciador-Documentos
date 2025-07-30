<?php require_once('../Connections/conexao.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

if ((isset($_GET["MM_update"])) && ($_GET["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE num_doc SET assunto=%s, destino=%s, elaborado=%s, assinado=%s, encaminhado=%s, obs_doc=%s WHERE id_num=%s",
    GetSQLValueString($_GET['ASSUNTO'], "text"),
    GetSQLValueString($_GET['DESTINO'], "text"),
    GetSQLValueString($_GET['ELABORADO'], "int"),
    GetSQLValueString($_GET['ASSINADO'], "int"),
    GetSQLValueString($_GET['ENCAMINHADO'], "int"),
    GetSQLValueString($_GET['observacao'], "text"),
    GetSQLValueString($_GET['id_num'], "int"));

  mysqli_select_db($conexao, $database_conexao);
  $Result1 = mysqli_query($conexao, $updateSQL);

  $updateGoTo = "acaooknumatual.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_atualizar = "1";
if (isset($_GET['Id_Num'])) {
  $colname_atualizar = $_GET['Id_Num'];
}
mysqli_select_db($conexao, $database_conexao);
$query_atualizar = sprintf("SELECT num_doc.Id_Num     , num_doc.Cod_Org     , num_doc.Tipo_Doc     , num_tipodoc.DescTipo_Doc     , num_doc.Num_Doc     , num_doc.Cod_Sec     , num_doc.Ano_Doc     , num_doc.ASSUNTO     , num_doc.DESTINO     , num_doc.DATA     , num_doc.ELABORADOR     , num_doc.obs_doc    , num_doc.ELABORADO     , num_doc.ASSINADO     , num_doc.ENCAMINHADO FROM num_doc     INNER JOIN num_tipodoc          ON (num_doc.Tipo_Doc = num_tipodoc.Tipo_Doc) WHERE (num_doc.Id_Num = '%s')", $colname_atualizar);
$atualizar = mysqli_query($conexao, $query_atualizar);
$row_atualizar = mysqli_fetch_assoc($atualizar);
$totalRows_atualizar = mysqli_num_rows($atualizar);
?>
<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="get" name="form1">
  <table width="400" border="12" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
    <tr> 
      <td height="28" colspan="2" bgcolor="#CCCCCC"><div align="center"><font color="#000099" size="3">ATUALIZAR&nbsp;&nbsp;<?php echo $row_atualizar['DescTipo_Doc']; ?> 
          n&ordm; <?php echo $row_atualizar['Num_Doc']; ?> / <?php echo $row_atualizar['Cod_Sec']; ?> 
          / <?php echo $row_atualizar['Ano_Doc']; ?></font> </div></td>
    </tr>
    <tr> 
      <td height="193" colspan="2" bgcolor="#FFFFFF"> <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap bgcolor="#CCCCCC"> <div align="center">ASSUNTO:</div>
              <div align="center"> </div></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap><textarea name="ASSUNTO" cols="70" rows="3"><?php echo $row_atualizar['ASSUNTO']; ?></textarea></td>
          </tr>
          <tr valign="baseline"> 
            <td height="17" align="right" valign="middle" nowrap bgcolor="#CCCCCC"> 
              <div align="center">DESTINO:</div>
              <div align="center"> </div></td>
          </tr>
          <tr valign="baseline"> 
            <td height="18" align="right" valign="middle" nowrap><textarea name="DESTINO" cols="70" rows="3"><?php echo $row_atualizar['DESTINO']; ?></textarea></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap bgcolor="#CCCCCC"> <div align="center">OBSERVA��O:</div>
              <div align="center"> </div></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap><textarea name="observacao" cols="70" rows="5" id="observacao"><?php echo $row_atualizar['obs_doc']; ?></textarea></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap bgcolor="#CCCCCC"> <div align="center">ELABORADO:&nbsp;&nbsp;&nbsp;&nbsp;N&atilde;o 
                <input  <?php if (!(strcmp($row_atualizar['ELABORADO'],"0"))) {echo "CHECKED";} ?> name="ELABORADO" type="radio" value="0" checked>
                &nbsp;&nbsp;&nbsp;SIM 
                <input  <?php if (!(strcmp($row_atualizar['ELABORADO'],"1"))) {echo "CHECKED";} ?> type="radio" name="ELABORADO" value="1">
              </div></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" nowrap bgcolor="#CCCCCC"> <div align="center"> 
                <input type="hidden" name="MM_update" value="form1">
                <input name="submit" type="submit" value="Atualizar registro">
                <input name="id_num" type="hidden" id="id_num2" value="<?php echo $row_atualizar['Id_Num']; ?>">
                <input name="ASSINADO" type="hidden" id="ASSINADO2" value="<?php echo $row_atualizar['ASSINADO']; ?>">
                <input name="ENCAMINHADO" type="hidden" id="ENCAMINHADO2" value="<?php echo $row_atualizar['ENCAMINHADO']; ?>">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysqli_free_result($atualizar);
?>

