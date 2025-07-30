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
$colname_listadoc = "1";
if (isset($_GET['cod_org'])) {
  $colname_listadoc = $_GET['cod_org'];
}
mysqli_select_db($conexao, $database_conexao);
$query_listadoc = sprintf("SELECT     num_doc.cod_org     , num_doc.tipo_doc     , num_tipodoc.desc_tipo_doc     , num_doc.ano_doc     , num_doc.num_doc     , num_org.org_CodSecao FROM     num_doc     INNER JOIN num_tipodoc          ON (num_doc.tipo_doc = num_tipodoc.tipo_doc)     INNER JOIN num_org          ON (num_doc.cod_org = num_org.org_id) WHERE (num_doc.cod_org = '%s') GROUP BY num_doc.tipo_doc;", $colname_listadoc);
$listadoc = mysqli_query($conexao, $query_listadoc);
$row_listadoc = mysqli_fetch_assoc($listadoc);
$totalRows_listadoc = mysqli_num_rows($listadoc);

?>

<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="200" colspan="3" valign="top"> 
      <div align="center"><font color="#0000CC" size="4"><strong>TIPO DE DOCUMENTO</strong></font></div>
      
      <?php do { ?>
      <table width="90%" border="0" align="center">
        <tr <?php 
// technocurve arc 3 php mv block2/3 start
echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
// technocurve arc 3 php mv block2/3 end
?>>
          <td height="13"> 
            <div align="left">
              <a href="geralcons.php?cod_org=<?php echo $row_listadoc['cod_org']; ?>&tipo_doc=<?php echo $row_listadoc['tipo_doc']; ?>&ano=<?php echo date("y");  ?>&re=<?php echo $_GET['re']; ?>&num_doc=%&ass=%&des=%" target="congeral"><?php echo $row_listadoc['desc_tipo_doc']; ?></a></div></td>
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
      <?php } while ($row_listadoc = mysqli_fetch_assoc($listadoc)); ?>
      <br>
      <table width="90%" border="0" align="center">
        <tr <?php 
// technocurve arc 3 php mv block2/3 start
echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
// technocurve arc 3 php mv block2/3 end
?>> 
          <td height="13"> <div align="left">PROCEDIMENTO DISCIPLINAR</a></div></td>
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
    </td>
    <td width="75%" height="200"> 
      <iframe  src="geralconsadm.php?cod_org=<?php echo $row_usersisbai['Org_id']; ?>&tipo_doc=
	  &ano=<?php echo date("y");  ?>&re=<?php echo $_GET['re']; ?>&num_doc=%" name="congeral" width="100%" height="400" scrolling="auto" frameborder="no"  allowtransparency="true" ></iframe>
</td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($listadoc);

?>

