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
$colname_faltaelab = "1";
if (isset($_GET['org_id'])) {
  $colname_faltaelab = $_GET['org_id'];
}
mysqli_select_db($conexao, $database_conexao);
$query_faltaelab = sprintf("SELECT num_org.org_id     , num_doc.id_num     , num_doc.tipo_doc     , num_tipodoc.desc_tipo_doc     , num_doc.num_doc     , num_doc.cod_sec     , num_doc.ano_doc     , num_doc.assunto     , num_doc.ELABORADO     , num_doc.ASSINADO     , num_doc.ENCAMINHADO     , num_org.org_descUnid     , num_org.org_desc FROM num_doc     INNER JOIN num_org          ON (num_doc.cod_org = num_org.org_id)     INNER JOIN num_tipodoc          ON (num_tipodoc.tipo_doc = num_doc.tipo_doc) WHERE (num_org.org_id = '%s'     AND num_doc.ELABORADO = '0'  )", $colname_faltaelab);
$faltaelab = mysqli_query($conexao, $query_faltaelab);
$row_faltaelab = mysqli_fetch_assoc($faltaelab);
$totalRows_faltaelab = mysqli_num_rows($faltaelab);

$colname_faltaassinar = "0";
if (isset($_GET['org_id'])) {
  $colname_faltaassinar = $_GET['org_id'];
}
mysqli_select_db($conexao, $database_conexao);
$query_faltaassinar = sprintf("SELECT num_org.org_id     , num_doc.id_num     , num_doc.tipo_doc     , num_tipodoc.desc_tipo_doc     , num_doc.num_doc     , num_doc.cod_sec     , num_doc.ano_doc     , num_doc.assunto     , num_doc.ELABORADO     , num_doc.ASSINADO     , num_doc.ENCAMINHADO     , num_org.org_descUnid     , num_org.org_desc FROM num_doc     INNER JOIN num_org          ON (num_doc.cod_org = num_org.org_id)     INNER JOIN num_tipodoc          ON (num_tipodoc.tipo_doc = num_doc.tipo_doc) WHERE (num_org.org_id = '%s'    AND num_doc.ELABORADO = '1'  AND num_doc.ASSINADO= '0')", $colname_faltaassinar);
$faltaassinar = mysqli_query($conexao, $query_faltaassinar);
$row_faltaassinar = mysqli_fetch_assoc($faltaassinar);
$totalRows_faltaassinar = mysqli_num_rows($faltaassinar);

$colname_faltaEnviar = "1";
if (isset($_GET['org_id'])) {
  $colname_faltaEnviar = $_GET['org_id'];
}
mysqli_select_db($conexao, $database_conexao);
$query_faltaEnviar = sprintf("SELECT num_org.org_id     , num_doc.id_num     , num_doc.tipo_doc     , num_tipodoc.desc_tipo_doc     , num_doc.num_doc     , num_doc.cod_sec     , num_doc.ano_doc     , num_doc.assunto     , num_doc.ELABORADO     , num_doc.ASSINADO     , num_doc.ENCAMINHADO     , num_org.org_descUnid     , num_org.org_desc FROM num_doc     INNER JOIN num_org          ON (num_doc.cod_org = num_org.org_id)     INNER JOIN num_tipodoc          ON (num_tipodoc.tipo_doc = num_doc.tipo_doc) WHERE (num_org.org_id = '%s'    AND num_doc.ELABORADO = '1'  AND num_doc.ASSINADO= '1'  AND num_doc.ENCAMINHADO = '0')", $colname_faltaEnviar);
$faltaEnviar = mysqli_query($conexao, $query_faltaEnviar);
$row_faltaEnviar = mysqli_fetch_assoc($faltaEnviar);
$totalRows_faltaEnviar = mysqli_num_rows($faltaEnviar);
?>
<html>
<head>
<title>WEb CPI-2</title>
<link  href="../logar/css/Geral.css" rel="stylesheet" type="text/css">

<link  href="../css/Geral.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">

body,td,th {
	color: #900;
}

</style></head>

<body>
<?php if ($totalRows_faltaelab > 0) { // Show if recordset not empty ?>
<div align="center"><br>
  FALTA CONFIRMAR A ELABORA&Ccedil;&Atilde;O</div>
<?php do { ?>
<table width="98%" border="0" align="center">
  <tr <?php 
// technocurve arc 3 php mv block2/3 start
echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
// technocurve arc 3 php mv block2/3 end
?>> 
    <td height="13" colspan="2"><font size="2"><strong><?php echo $row_faltaelab['desc_tipo_doc']; ?> N&ordm; <?php echo $row_faltaelab['num_doc']; ?> / <?php echo $row_faltaelab['cod_sec']; ?> / <?php echo $row_faltaelab['ano_doc']; ?> - <?php echo $row_faltaelab['assunto']; ?> </strong></font></td>
    <td width="10%" height="13"><div align="center"><a href="atualiassi.php?id_num=<?php echo $row_faltaelab['id_num']; ?>">ATUALIZAR</a></div></td>
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
<?php } while ($row_faltaelab = mysqli_fetch_assoc($faltaelab)); ?>
<?php } // Show if recordset not empty ?>
<?php if ($totalRows_faltaassinar > 0) { // Show if recordset not empty ?>
<div align="center"><br>
  FALTA ASSINAR</div>
<?php do { ?>
<table width="98%" border="0" align="center">
  <tr <?php 
// technocurve arc 3 php mv block2/3 start
echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
// technocurve arc 3 php mv block2/3 end
?>> 
    <td height="13" colspan="2"><?php echo $row_faltaassinar['desc_tipo_doc']; ?> 
      N&ordm; <?php echo $row_faltaassinar['num_doc']; ?> / <?php echo $row_faltaassinar['cod_sec']; ?> / <?php echo $row_faltaassinar['ano_doc']; ?> - <?php echo $row_faltaassinar['assunto']; ?> </td>
    <td width="13%" height="13"><div align="center"><a href="atualiassi.php?id_num=<?php echo $row_faltaassinar['id_num']; ?>">Confirmar 
        assinatura</a></div></td>
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
<?php } while ($row_faltaassinar = mysqli_fetch_assoc($faltaassinar)); ?>
<?php } // Show if recordset not empty ?>
<?php if ($totalRows_faltaEnviar > 0) { // Show if recordset not empty ?>
<div align="center"><br>
  FALTA ENVIAR</div>
<?php do { ?>
<table width="98%" border="0" align="center">
  <tr <?php 
// technocurve arc 3 php mv block2/3 start
echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
// technocurve arc 3 php mv block2/3 end
?>> 
    <td height="13" colspan="2"><?php echo $row_faltaEnviar['desc_tipo_doc']; ?> 
      N&ordm; <?php echo $row_faltaEnviar['num_doc']; ?> / <?php echo $row_faltaEnviar['cod_sec']; ?> / <?php echo $row_faltaEnviar['ano_doc']; ?> - <?php echo $row_faltaEnviar['assunto']; ?> </td>
    <td width="10%" height="13"><div align="center"><a href="atualiassi.php?id_num=<?php echo $row_faltaEnviar['id_num']; ?>">Confirmar 
        envio</a></div></td>
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
<?php } while ($row_faltaEnviar = mysqli_fetch_assoc($faltaEnviar)); ?>
<?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($faltaelab);

mysqli_free_result($faltaassinar);

mysqli_free_result($faltaEnviar);
?>
