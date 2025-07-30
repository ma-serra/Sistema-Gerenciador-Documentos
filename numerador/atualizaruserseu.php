<?php require_once('../Connections/conexao.php');
ob_start(); ?> 
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
  $updateSQL = sprintf("UPDATE num_user SET postfunc=%s, guerra=%s, Org_id=%s, Nivel=%s, situacao=%s WHERE rerg=%s",
                       GetSQLValueString($_POST['postfunc'], "text"),
                       GetSQLValueString($_POST['guerra'], "text"),
                       GetSQLValueString($_POST['org_id'], "int"),
                       GetSQLValueString($_POST['Nivel'], "text"),
                       GetSQLValueString($_POST['situacao'], "text"),
                       GetSQLValueString($_POST['rerg'], "text"));

  mysqli_select_db($conexao, $database_conexao);
  $Result1 = mysqli_query($conexao, $updateSQL);

  $updateGoTo = "okseu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "senhanova")) {
  $updateSQL = sprintf("UPDATE num_user SET senha=%s WHERE rerg=%s",
                       GetSQLValueString(md5($_POST['senha']), "text"),
                       GetSQLValueString($_POST['rerg2'], "text"));

  mysqli_select_db($conexao, $database_conexao);
  $Result1 = mysqli_query($conexao, $updateSQL);

  $updateGoTo = "okseu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysqli_select_db($conexao, $database_conexao);
$query_posto = "SELECT * FROM sai_posto ORDER BY CodPosto ASC";
$posto = mysqli_query($conexao, $query_posto);
$row_posto = mysqli_fetch_assoc($posto);
$totalRows_posto = mysqli_num_rows($posto);

mysqli_select_db($conexao, $database_conexao);
$query_Recordset1 = "SELECT * FROM num_org";
$Recordset1 = mysqli_query($conexao, $query_Recordset1);
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

mysqli_select_db($conexao, $database_conexao);
$query_nivel = "SELECT * FROM num_nivel ORDER BY nivel_id ASC";
$nivel = mysqli_query($conexao, $query_nivel);
$row_nivel = mysqli_fetch_assoc($nivel);
$totalRows_nivel = mysqli_num_rows($nivel);

$colname_useer = "1";
if (isset($_GET['rerg'])) {
  $colname_useer = $_GET['rerg'];
}
mysqli_select_db($conexao, $database_conexao);
$query_useer = sprintf("SELECT * FROM num_user WHERE rerg = '%s'", $colname_useer);
$useer = mysqli_query($conexao, $query_useer);
$row_useer = mysqli_fetch_assoc($useer);
$totalRows_useer = mysqli_num_rows($useer);
?>
<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table align="center" bgcolor="#E6E6E6">
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="2" align="right" nowrap> <div align="center"><font color="#000099" size="3">ATUALIZAR 
          USU&Aacute;RIO</font></div></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">RE:</td>
      <td> <?php echo $row_useer['rerg']; ?>
        <input type="hidden" name="rerg" value="<?php echo $row_useer['rerg']; ?>" size="9"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">POSTO / FUN&Ccedil;&Atilde;O:</td>
      <td> <select name="postfunc" id="postfunc">
          <option value="" <?php if (!(strcmp("", $row_useer['postfunc']))) {echo "SELECTED";} ?>>Selecionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_posto['Posto']?>"<?php if (!(strcmp($row_posto['Posto'], $row_useer['postfunc']))) {echo "SELECTED";} ?>><?php echo $row_posto['Posto']?></option>
          <?php
} while ($row_posto = mysqli_fetch_assoc($posto));
  $rows = mysqli_num_rows($posto);
  if($rows > 0) {
      mysqli_data_seek($posto, 0);
	  $row_posto = mysqli_fetch_assoc($posto);
  }
?>
        </select></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">NOME DE GUERRA:</td>
      <td><input type="text" name="guerra" value="<?php echo $row_useer['guerra']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">FUN&Ccedil;&Atilde;O:</td>
      <td><input type="text" name="situacao" value="<?php echo $row_useer['situacao']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="2" align="right" nowrap bgcolor="#CCCCCC"> <div align="center"> 
          <input name="Nivel" type="hidden" id="Nivel2" value="<?php echo $row_useer['Nivel']; ?>">
          <input type="submit" value="ATUALIZAR">
          <input name="org_id" type="hidden" id="org_id2" value="<?php echo $row_useer['Org_id']; ?>">
        </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
<form action="<?php echo $editFormAction; ?>" method="POST" name="senhanova" id="senhanova">
  <table align="center" bgcolor="#E6E6E6">
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="2" align="right" nowrap> <div align="center"><font color="#000099" size="3">TROCAR 
          A SENHA</font></div></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">SENHA NOVA</td>
      <td><input name="senha" type="password" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="2" align="right" nowrap bgcolor="#CCCCCC"> <div align="center"> 
          <input name="rerg2" type="hidden" id="rerg" value="<?php echo $row_useer['rerg']; ?>" size="9">
          <input name="submit" type="submit" value="TROCAR SENHA">
        </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="senhanova">
</form>
<p>&nbsp;</p>
  

</body>
</html>
<?php
mysqli_free_result($posto);

mysqli_free_result($Recordset1);

mysqli_free_result($nivel);

mysqli_free_result($useer);
?>

