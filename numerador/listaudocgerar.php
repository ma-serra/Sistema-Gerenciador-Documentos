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
if (isset($_GET['cod_org']) && is_numeric($_GET['cod_org'])) {
  $colname_listadoc = $_GET['cod_org'];
}

// --- CONSULTA CORRIGIDA ---
// A intenção é listar os tipos de documento únicos para uma organização.
// Selecionamos DISTINCT (distintos) e apenas os campos necessários para os links.
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
<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="131" colspan="3" valign="top"> 
      <div align="center"><strong><font color="#0000CC" size="2">NUMERADORES DA SEÇÃO ABERTOS</font></strong></div>
      <?php if ($totalRows_listadoc > 0): ?>
        <?php do { ?>
        <table width="90%" border="0" align="center">
          <tr <?php 
              // technocurve arc 3 php mv block2/3 start
              echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
              // technocurve arc 3 php mv block2/3 end
          ?>> 
            <td height="13"> 
                <div align="left">
                    <a href="inserirdocfinal.php?cod_org=<?php echo $row_listadoc['cod_org']; ?>&tipo_doc=<?php echo $row_listadoc['tipo_doc']; ?>&re=<?php echo htmlspecialchars($_GET['re']); ?>" target="novo">
                        <?php echo htmlspecialchars($row_listadoc['desc_tipo_doc']); ?>
                    </a>
                </div>
            </td>
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
        <?php } while ($row_listadoc = mysqli_fetch_assoc($listadoc_result)); ?>
      <?php else: ?>
        <p align="center">Nenhum tipo de documento encontrado para esta seção.</p>
      <?php endif; ?>
      <br>
    </td>
    <td width="75%" height="131" style="border-left: 1px solid #ccc;"> 
      <iframe src="../paginalimpa.php" name="novo" width="100%" height="450" scrolling="auto" frameborder="no" allowtransparency="true"></iframe>
    </td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($listadoc_result);
?>