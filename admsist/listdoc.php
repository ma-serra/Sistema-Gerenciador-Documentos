<?php
// technocurve arc 3 php mv block1/3 start
$mocolor1 = "#CCCCCC";
$mocolor2 = "#FFFFFF";
$mocolor3 = "#FFFF99";
$mocolor = $mocolor1;
// technocurve arc 3 php mv block1/3 end
?>
<?php require_once('../Connections/conexao.php'); ?>
<?php
mysqli_select_db($conexao, $database_conexao);
$query_listatipodoc = "SELECT * FROM num_tipodoc ORDER BY desc_tipo_doc ASC";
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
<div align="center"><font color="#000066" size="3"><strong>Lista de Tipos de Documentos</strong></font></div>
<?php do { ?>
<table width="52%" border="0" align="center">
  <tr <?php 
// technocurve arc 3 php mv block2/3 start
echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
// technocurve arc 3 php mv block2/3 end
?>> 
    <td width="74%" height="13"><div align="center"><?php echo $row_listatipodoc['desc_tipo_doc']; ?> </div></td>
    <td width="26%" height="13"><div align="center"><a href="atualizardoctipo.php?Tipo_Doc=<?php echo $row_listatipodoc['Tipo_Doc']; ?>">Atualizar</a></div></td>
  </tr>
  <?php 
// technocurve arc 3 php mv block3/3 start
if ($mocolor == $mocolor1) {
	$mocolor = $mocolor2;
} else {
	$mocolor = $mocolor1;
}
// technocurve arc 3 php mv block3/3 end
?>
</table>
<?php } while ($row_listatipodoc = mysqli_fetch_assoc($listatipodoc)); ?>
<br>
<a href="cadastrodoctipo.php">Cadastrar novo tipo de Documento </a> 
</body>
</html>
<?php
mysqli_free_result($listatipodoc);
?>

