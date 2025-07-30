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
    GetSQLValueString($_GET['assunto'], "text"),
    GetSQLValueString($_GET['destino'], "text"),
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

$numero_novo = "1";
if (isset($_GET['num_doc'])) {
  $numero_novo = $_GET['num_doc'];
}
$colname_novo = "1";
if (isset($_GET['cod_org'])) {
  $colname_novo = $_GET['cod_org'];
}
$tipo_novo = "1";
if (isset($_GET['tipo_doc'])) {
  $tipo_novo = $_GET['tipo_doc'];
}
$ano_novo = "1";
if (isset($_GET['ano_doc'])) {
  $ano_novo = $_GET['ano_doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_novo = sprintf("SELECT * FROM num_doc WHERE cod_org = '%s'  AND tipo_doc = '%s' AND ano_doc = '%s'  AND num_doc = '%s'", $colname_novo,$tipo_novo,$ano_novo,$numero_novo);
$novo = mysqli_query($conexao, $query_novo);
$row_novo = mysqli_fetch_assoc($novo);
$totalRows_novo = mysqli_num_rows($novo);

$colname_documento = "1";
if (isset($_GET['tipo_doc'])) {
  $colname_documento = $_GET['tipo_doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_documento = sprintf("SELECT * FROM num_tipodoc WHERE tipo_doc = %s ORDER BY desc_tipo_doc ASC", $colname_documento);
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
<form action="<?php echo $editFormAction; ?>" method="get" name="form1">
  <table width="400" border="12" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
    <tr> 
      <td height="28" colspan="2" bgcolor="#CCCCCC"><div align="center"><font color="#000099" size="3">CRIADO&nbsp;&nbsp;<?php echo $row_documento['desc_tipo_doc']; ?> N&ordm; <?php echo $row_novo['num_doc']; ?> / <?php echo $row_novo['cod_sec']; ?> / <?php echo $row_novo['ano_doc']; ?></font> </div></td>
    </tr>
    <tr> 
      <td height="193" colspan="2" bgcolor="#FFFFFF"> <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap bgcolor="#CCCCCC"> <div align="center">assunto:</div>
              <div align="center"> </div></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap><textarea name="assunto" cols="70" rows="3" id="assunto"><?php echo $row_novo['assunto']; ?></textarea></td>
          </tr>
          <tr valign="baseline"> 
            <td height="17" align="right" valign="middle" nowrap bgcolor="#CCCCCC"> 
              <div align="center">destino:</div>
              <div align="center"> </div></td>
          </tr>
          <tr valign="baseline"> 
            <td height="18" align="right" valign="middle" nowrap><textarea name="destino" cols="70" rows="3" id="destino"><?php echo $row_novo['destino']; ?></textarea></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap bgcolor="#CCCCCC"> <div align="center">OBSERVA��O:</div>
              <div align="center"> </div></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap><textarea name="OBS_DOC" cols="70" rows="5" id="OBS_DOC"><?php echo $row_novo['obs_doc']; ?></textarea></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" valign="middle" nowrap bgcolor="#CCCCCC"> <div align="center">ELABORADO:&nbsp;&nbsp;&nbsp;&nbsp;N&atilde;o 
                <input  <?php if (!(strcmp($row_novo['ELABORADO'],"0"))) {echo "CHECKED";} ?> name="ELABORADO" type="radio" value="0" checked>
                &nbsp;&nbsp;&nbsp;SIM 
                <input  <?php if (!(strcmp($row_novo['ELABORADO'],"1"))) {echo "CHECKED";} ?> type="radio" name="ELABORADO" value="1">
              </div></td>
          </tr>
          <tr valign="baseline"> 
            <td align="right" nowrap bgcolor="#CCCCCC"> <div align="center"> 
                <input name="submit2" type="submit" value="novo registro">
                <input name="id_num" type="hidden" id="id_num" value="<?php echo $row_novo['id_num']; ?>">
                <input name="ASSINADO" type="hidden" id="ASSINADO" value="<?php echo $row_novo['ASSINADO']; ?>">
                <input name="ENCAMINHADO" type="hidden" id="ENCAMINHADO" value="<?php echo $row_novo['ENCAMINHADO']; ?>">
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
mysqli_free_result($novo);

mysqli_free_result($documento);
?>

