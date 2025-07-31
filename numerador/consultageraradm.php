<?php
$mocolor1 = "#E6E6E6";
$mocolor2 = "#E6E6E6";
$mocolor3 = "#FFFFCC";
$mocolor = $mocolor1;
?>

<?php require_once('../Connections/conexao.php'); ?>
<?php
$colname_listadoc = "1";
if (isset($_GET['cod_org']) && is_numeric($_GET['cod_org'])) {
  $colname_listadoc = $_GET['cod_org'];
}

// --- CONSULTA CORRIGIDA ---
$query_listadoc = sprintf("SELECT DISTINCT 
                               d.cod_org, 
                               d.tipo_doc, 
                               t.desc_tipo_doc 
                           FROM 
                               num_doc AS d
                               INNER JOIN num_tipodoc AS t ON (d.tipo_doc = t.tipo_doc) 
                           WHERE 
                               d.cod_org = %s 
                           ORDER BY 
                               t.desc_tipo_doc ASC", 
                           GetSQLValueString($conexao, $colname_listadoc, "int"));
$listadoc_result = mysqli_query($conexao, $query_listadoc);

if (!$listadoc_result) {
    die("Erro na consulta SQL: " . mysqli_error($conexao));
}

$row_listadoc = mysqli_fetch_assoc($listadoc_result);
$totalRows_listadoc = mysqli_num_rows($listadoc_result);
?>
<style> 
body { overflow:hidden } 
</style>
<html>
<head>
<title>Numerador</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
<link href="/numerador/public/css/Geralsemimagem.css?v=1753940646" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="144" colspan="3" valign="top"> 
      <div align="center"><font color="#0000CC" size="4"><strong>TIPO DE DOCUMENTO</strong></font></div>
      <?php if ($totalRows_listadoc > 0): ?>
          <?php do { ?>
          <table width="90%" border="0" align="center">
            <tr <?php echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\""; ?>> 
              <td height="13"> 
                <div align="left">
                    <a href="geralconsadm.php?cod_org=<?php echo $row_listadoc['cod_org']; ?>&tipo_doc=<?php echo $row_listadoc['tipo_doc']; ?>&ano=<?php echo date("Y"); ?>&re=<?php echo htmlspecialchars($_GET['re']); ?>&num_doc=%&ass=%&des=%" target="congeral">
                        <?php echo htmlspecialchars($row_listadoc['desc_tipo_doc']); ?>
                    </a>
                </div>
              </td>
            </tr>
            <?php if ($mocolor == $mocolor1) { $mocolor = $mocolor2; } else { $mocolor = $mocolor1; } ?>
          </table>
          <?php } while ($row_listadoc = mysqli_fetch_assoc($listadoc_result)); ?>
      <?php endif; ?>
    </td>
    <td width="75%" height="144"> 
      <iframe src="../public/paginalimpa.php" name="congeral" width="100%" height="400" scrolling="auto" frameborder="no" allowtransparency="true"></iframe>
    </td>
  </tr>
</table>
</body>
</html>
<?php mysqli_free_result($listadoc_result); ?>
