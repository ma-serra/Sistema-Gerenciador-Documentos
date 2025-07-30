<?php require_once('../Connections/conexao.php'); ?>
<?php
$colname_tipodoc = "1";
if (isset($_GET['Tipo_Doc'])) {
  $colname_tipodoc = (get_magic_quotes_gpc()) ? $_GET['Tipo_Doc'] : addslashes($_GET['Tipo_Doc']);
}
mysqli_select_db($conexao, $database_conexao);
$query_tipodoc = sprintf("SELECT * FROM num_tipodoc WHERE Tipo_Doc = %s", $colname_tipodoc);
$tipodoc = mysqli_query($conexao, $query_tipodoc);
$row_tipodoc = mysqli_fetch_assoc($tipodoc);
$totalRows_tipodoc = mysqli_num_rows($tipodoc);
?>
<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<div align="center">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p> 
  <h2><?php echo $row_tipodoc['desc_tipo_doc']; ?> n&ordm; <?php echo $_GET['Num_Doc']; ?> / <?php echo $_GET['Cod_Sec']; ?> 
    / <?php echo $_GET['Ano_Doc']; ?> com &Ecirc;xito</h2>
  </p>
  <font color="#000099" size="4"><strong><font color="#FFFFFF" size="1"> 
  <script language="JavaScript" type="text/javascript">
function click() {
if (event.button==2||event.button==3) {
oncontextmenu='return false';
}
}
document.onmousedown=click
document.oncontextmenu = new Function("return false;")
  </script>
  </font></strong></font></div>
</body>
</html>
<?php
mysqli_free_result($tipodoc);
?>

