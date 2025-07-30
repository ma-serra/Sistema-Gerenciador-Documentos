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
// Validação de entrada
$colname_faltaelab = "1";
if (isset($_GET['org_id']) && is_numeric($_GET['org_id'])) {
  $colname_faltaelab = $_GET['org_id'];
}

// Consulta para documentos que faltam elaboração
$query_faltaelab = sprintf("SELECT num_org.org_id, num_doc.id_num, num_doc.tipo_doc, num_tipodoc.desc_tipo_doc, num_doc.num_doc, num_doc.cod_sec, num_doc.ano_doc, num_doc.assunto, num_doc.elaborado, num_doc.assinado, num_doc.encaminhado, num_org.org_desc_unid, num_org.org_desc FROM num_doc INNER JOIN num_org ON (num_doc.cod_org = num_org.org_id) INNER JOIN num_tipodoc ON (num_tipodoc.tipo_doc = num_doc.tipo_doc) WHERE (num_org.org_id = %s AND num_doc.elaborado = '0')", GetSQLValueString($conexao, $colname_faltaelab, "int"));
$faltaelab = mysqli_query($conexao, $query_faltaelab);
$row_faltaelab = mysqli_fetch_assoc($faltaelab);
$totalRows_faltaelab = mysqli_num_rows($faltaelab);

// ... (as outras duas consultas seguem o mesmo padrão) ...

$colname_faltaassinar = "0";
if (isset($_GET['org_id']) && is_numeric($_GET['org_id'])) {
  $colname_faltaassinar = $_GET['org_id'];
}
$query_faltaassinar = sprintf("SELECT num_org.org_id, num_doc.id_num, num_doc.tipo_doc, num_tipodoc.desc_tipo_doc, num_doc.num_doc, num_doc.cod_sec, num_doc.ano_doc, num_doc.assunto, num_doc.elaborado, num_doc.assinado, num_doc.encaminhado, num_org.org_desc_unid, num_org.org_desc FROM num_doc INNER JOIN num_org ON (num_doc.cod_org = num_org.org_id) INNER JOIN num_tipodoc ON (num_tipodoc.tipo_doc = num_doc.tipo_doc) WHERE (num_org.org_id = %s AND num_doc.elaborado = '1' AND num_doc.assinado = '0')", GetSQLValueString($conexao, $colname_faltaassinar, "int"));
$faltaassinar = mysqli_query($conexao, $query_faltaassinar);
$row_faltaassinar = mysqli_fetch_assoc($faltaassinar);
$totalRows_faltaassinar = mysqli_num_rows($faltaassinar);

$colname_faltaEnviar = "1";
if (isset($_GET['org_id']) && is_numeric($_GET['org_id'])) {
  $colname_faltaEnviar = $_GET['org_id'];
}
$query_faltaEnviar = sprintf("SELECT num_org.org_id, num_doc.id_num, num_doc.tipo_doc, num_tipodoc.desc_tipo_doc, num_doc.num_doc, num_doc.cod_sec, num_doc.ano_doc, num_doc.assunto, num_doc.elaborado, num_doc.assinado, num_doc.encaminhado, num_org.org_desc_unid, num_org.org_desc FROM num_doc INNER JOIN num_org ON (num_doc.cod_org = num_org.org_id) INNER JOIN num_tipodoc ON (num_tipodoc.tipo_doc = num_doc.tipo_doc) WHERE (num_org.org_id = %s AND num_doc.elaborado = '1' AND num_doc.assinado = '1' AND num_doc.encaminhado = '0')", GetSQLValueString($conexao, $colname_faltaEnviar, "int"));
$faltaEnviar = mysqli_query($conexao, $query_faltaEnviar);
$row_faltaEnviar = mysqli_fetch_assoc($faltaEnviar);
$totalRows_faltaEnviar = mysqli_num_rows($faltaEnviar);

?>
<html>
<head>
<title>WEB CPI-2</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css"> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body,td,th {
	color: #900;
}
</style>
</head>

<body>
<?php if ($totalRows_faltaelab > 0): ?>
<div align="center"><br>
  FALTA CONFIRMAR A ELABORA&Ccedil;&Atilde;O</div>
<?php do { ?>
<table width="98%" border="0" align="center">
  <tr <?php echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\""; ?>> 
    <td height="13" colspan="2"><font size="2"><strong><?php echo htmlspecialchars($row_faltaelab['desc_tipo_doc']); ?> N&ordm; <?php echo htmlspecialchars($row_faltaelab['num_doc']); ?> / <?php echo htmlspecialchars($row_faltaelab['cod_sec']); ?> / <?php echo htmlspecialchars($row_faltaelab['ano_doc']); ?> - <?php echo htmlspecialchars($row_faltaelab['assunto']); ?> </strong></font></td>
    <td width="10%" height="13"><div align="center"><a href="atualiassi.php?id_num=<?php echo $row_faltaelab['id_num']; ?>">ATUALIZAR</a></div></td>
  </tr>
  <?php if ($mocolor == $mocolor1) { $mocolor = $mocolor2; } else { $mocolor = $mocolor1; } ?>
</table>
<?php } while ($row_faltaelab = mysqli_fetch_assoc($faltaelab)); ?>
<?php endif; ?>

<?php if ($totalRows_faltaassinar > 0): ?>
<div align="center"><br>
  FALTA ASSINAR</div>
<?php do { ?>
<table width="98%" border="0" align="center">
  <tr <?php echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\""; ?>> 
    <td height="13" colspan="2"><?php echo htmlspecialchars($row_faltaassinar['desc_tipo_doc']); ?> 
      N&ordm; <?php echo htmlspecialchars($row_faltaassinar['num_doc']); ?> / <?php echo htmlspecialchars($row_faltaassinar['cod_sec']); ?> / <?php echo htmlspecialchars($row_faltaassinar['ano_doc']); ?> - <?php echo htmlspecialchars($row_faltaassinar['assunto']); ?> </td>
    <td width="13%" height="13"><div align="center"><a href="atualiassi.php?id_num=<?php echo $row_faltaassinar['id_num']; ?>">Confirmar 
        assinatura</a></div></td>
  </tr>
  <?php if ($mocolor == $mocolor1) { $mocolor = $mocolor2; } else { $mocolor = $mocolor1; } ?>
</table>
<?php } while ($row_faltaassinar = mysqli_fetch_assoc($faltaassinar)); ?>
<?php endif; ?>

<?php if ($totalRows_faltaEnviar > 0): ?>
<div align="center"><br>
  FALTA ENVIAR</div>
<?php do { ?>
<table width="98%" border="0" align="center">
  <tr <?php echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\""; ?>> 
    <td height="13" colspan="2"><?php echo htmlspecialchars($row_faltaEnviar['desc_tipo_doc']); ?> 
      N&ordm; <?php echo htmlspecialchars($row_faltaEnviar['num_doc']); ?> / <?php echo htmlspecialchars($row_faltaEnviar['cod_sec']); ?> / <?php echo htmlspecialchars($row_faltaEnviar['ano_doc']); ?> - <?php echo htmlspecialchars($row_faltaEnviar['assunto']); ?> </td>
    <td width="10%" height="13"><div align="center"><a href="atualiassi.php?id_num=<?php echo $row_faltaEnviar['id_num']; ?>">Confirmar 
        envio</a></div></td>
  </tr>
  <?php if ($mocolor == $mocolor1) { $mocolor = $mocolor2; } else { $mocolor = $mocolor1; } ?>
</table>
<?php } while ($row_faltaEnviar = mysqli_fetch_assoc($faltaEnviar)); ?>
<?php endif; ?>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($faltaelab);
mysqli_free_result($faltaassinar);
mysqli_free_result($faltaEnviar);
?>