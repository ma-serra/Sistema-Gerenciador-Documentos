<?php
// technocurve arc 3 php mv block1/3 start
$mocolor1 = "#FFFFFF";
$mocolor2 = "#CCCCCC";
$mocolor3 = "#FFFFCC";
$mocolor = $mocolor1;
// technocurve arc 3 php mv block1/3 end
?>
<?php require_once('../Connections/conexao.php'); ?>
<?php
mysqli_select_db($conexao, $database_conexao);
$query_con_secao = "SELECT * FROM num_org ORDER BY org_id ASC";
$con_secao = mysqli_query($conexao, $query_con_secao);
$row_con_secao = mysqli_fetch_assoc($con_secao);
$totalRows_con_secao = mysqli_num_rows($con_secao);
?>
<html>
<head>
<title>Numerador</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
<link  href="/numerador/public/css/Geral.css?v=1753940642" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<div align="center"><font color="#000099" size="3"><strong>Lista de se&ccedil;&otilde;es cadastradas 
  do <?php echo $row_con_secao['org_desc_unid']; ?></strong></font></div>
<?php do { ?>
<table width="52%" border="0" align="center">
  <tr <?php 
// technocurve arc 3 php mv block2/3 start
echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
// technocurve arc 3 php mv block2/3 end
?>> 
    <td width="74%" height="13"><div align="center"><?php echo $row_con_secao['org_desc']; ?> </div></td>
    <td width="26%" height="13"><div align="center"><a href="atualizarorg.php?org_id=<?php echo $row_con_secao['org_id']; ?>">Atualizar</a></div></td>
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
<?php } while ($row_con_secao = mysqli_fetch_assoc($con_secao)); ?>
<p><a href="cadastrosecao.php">Cadastrar nova se&ccedil;&atilde;o</a></p>
</body>
</html>
<?php
mysqli_free_result($con_secao);
?>

