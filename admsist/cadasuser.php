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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO num_user (rerg, postfunc, guerra, senha, Org_id, Nivel, situacao) VALUES (%s, %s, %s, %s, %s, %s, %s)",
    GetSQLValueString($_POST['rerg'], "text"),
    GetSQLValueString($_POST['postfunc'], "text"),
    GetSQLValueString($_POST['guerra'], "text"),
    GetSQLValueString(md5($_POST['senha']), "text"),
    GetSQLValueString($_POST['org_id'], "int"),
    GetSQLValueString($_POST['Nivel'], "int"),
    GetSQLValueString($_POST['situacao'], "text"));

  mysqli_select_db($conexao, $database_conexao);
  $Result1 = mysqli_query($conexao, $insertSQL);

  $insertGoTo = "acaook.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php
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
?>
<html>
<head>
<title>Numerador</title>
<link  href="file:///C|/xampp/htdocs/webcpi2/css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  
  
  
  
  <table align="center" bgcolor="#E6E6E6">
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="2" align="right" nowrap> <div align="center"><font color="#000099" size="3">Cadastro 
          de Usu&aacute;rio</font></div></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">RE:</td>
      <td><input type="text" name="rerg" value="" size="9">
        Obs: sem d&iacute;gito</td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Posto:</td>
      <td> <select name="postfunc" id="postfunc">
          <option value="">Selecionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_posto['Posto']?>"><?php echo $row_posto['Posto']?></option>
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
      <td nowrap align="right">Guerra:</td>
      <td><input type="text" name="guerra" value="" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Se&ccedil;&atilde;o:</td>
      <td> <select name="org_id" id="org_id">
          <option value="">Selecionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['org_id']?>"><?php echo $row_Recordset1['org_desc']?> 
          do <?php echo $row_Recordset1['org_descUnid']; ?></option>
          <?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
  $rows = mysqli_num_rows($Recordset1);
  if($rows > 0) {
      mysqli_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
  }
?>
        </select> </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">N&iacute;vel:</td>
      <td> <select name="Nivel" id="Nivel">
          <option value="">Selecione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_nivel['nivel_id']?>"><?php echo $row_nivel['desc_nivel']?></option>
          <?php
} while ($row_nivel = mysqli_fetch_assoc($nivel));
  $rows = mysqli_num_rows($nivel);
  if($rows > 0) {
      mysqli_data_seek($nivel, 0);
	  $row_nivel = mysqli_fetch_assoc($nivel);
  }
?>
        </select> </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Fun&ccedil;&atilde;o:</td>
      <td><input type="text" name="situacao" value="" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="2" align="right" nowrap bgcolor="#CCCCCC"> <div align="center"> 
          <input type="submit" value="Inserir registro">
          <input type="hidden" name="senha" value="senhas" size="32">
        </div></td>
    </tr>
  </table>
  
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
  

</body>
</html>
<?php
mysqli_free_result($posto);

mysqli_free_result($Recordset1);

mysqli_free_result($nivel);
?>

