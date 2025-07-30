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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE num_tipodoc SET desc_tipo_doc=%s WHERE Tipo_Doc=%s",
                       GetSQLValueString($_POST['desc_tipo_doc'], "text"),
                       GetSQLValueString($_POST['Tipo_Doc'], "int"));

  mysqli_select_db($conexao, $database_conexao);
  $Result1 = mysqli_query($conexao, $updateSQL);

  $updateGoTo = "acaookdoc.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_listatipodoc = "1";
if (isset($_GET['Tipo_Doc'])) {
  $colname_listatipodoc = $_GET['Tipo_Doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_listatipodoc = sprintf("SELECT * FROM num_tipodoc WHERE Tipo_Doc = %s", $colname_listatipodoc);
$listatipodoc = mysqli_query($conexao, $query_listatipodoc);
$row_listatipodoc = mysqli_fetch_assoc($listatipodoc);
$totalRows_listatipodoc = mysqli_num_rows($listatipodoc);
?>
<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline"> 
      <td nowrap align="right">Atualizar tipo de Documento:</td>
      <td><input type="text" name="desc_tipo_doc" value="<?php echo $row_listatipodoc['desc_tipo_doc']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Atualizar o registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="Tipo_Doc" value="<?php echo $row_listatipodoc['Tipo_Doc']; ?>">
</form>
<p>&nbsp;</p>
  
</body>
</html>
<?php
mysqli_free_result($listatipodoc);
?>

