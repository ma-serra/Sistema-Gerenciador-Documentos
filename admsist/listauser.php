<?php
// technocurve arc 3 php mv block1/3 start
$mocolor1 = "#CCCCCC";
$mocolor2 = "#FFFFFF";
$mocolor3 = "#FFFFCC";
$mocolor = $mocolor1;
// technocurve arc 3 php mv block1/3 end
?>
<?php require_once('../Connections/conexao.php'); ?>
<?php
$colname_user = "1";
if (isset($_GET['rerg'])) {
  $colname_user = $_GET['rerg'];
}
mysqli_select_db($conexao, $database_conexao);
$query_user = sprintf("SELECT     num_user.rerg     , num_user.postfunc     , num_user.guerra     , num_org.org_desc     , num_nivel.desc_nivel     , num_org.org_desc_unid     , num_user.Org_id FROM     num_user     INNER JOIN num_nivel          ON (num_user.Nivel = num_nivel.cod_nivel)     INNER JOIN num_org          ON (num_user.Org_id = num_org.org_id) WHERE (num_user.rerg LIKE '%s') ORDER BY num_user.Org_id ASC;", $colname_user);
$user = mysqli_query($conexao, $query_user);
$row_user = mysqli_fetch_assoc($user);
$totalRows_user = mysqli_num_rows($user);
?>
<html>
<head>
<title>Numerador</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
<link  href="/numerador/public/css/Geral.css?v=1753940642" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="form1" method="get" action="listauser.php">
  <div align="center">Digite o RE sem d&iacute;gito para localizar na lista 
    <input name="rerg" type="text" id="rerg" size="9">
    &nbsp; 
    <input type="submit" name="Submit" value="Buscar">
  </div>
</form>
<?php do { ?>
<table width="80%" border="0" align="center">
  <tr <?php 
// technocurve arc 3 php mv block2/3 start
echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
// technocurve arc 3 php mv block2/3 end
?>> 
    <td width="79%" height="13"><div align="center"><?php echo $row_user['postfunc']; ?>&nbsp;<?php echo $row_user['guerra']; ?> da <?php echo $row_user['org_desc']; ?> do <?php echo $row_user['org_desc_unid']; ?> nivel <?php echo $row_user['desc_nivel']; ?></div></td>
    <td width="9%" height="13"><div align="center"><a href="atualizarseuuser.php?rerg=<?php echo $row_user['rerg']; ?>">Atualizar</a></div></td>
    <td width="12%"><div align="center">Excluir</div></td>
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
<?php } while ($row_user = mysqli_fetch_assoc($user)); ?>
<br>
<a href="cadasuser.php">Cadastro de Novo Usu&aacute;rio</a> 
</body>
</html>
<?php
mysqli_free_result($user);
?>

