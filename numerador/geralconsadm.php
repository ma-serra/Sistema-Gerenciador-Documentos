<?php
// technocurve arc 3 php mv block1/3 start
$mocolor1 = "#CCCCCC";
$mocolor2 = "#E9E9E9";
$mocolor3 = "#FFFFCC";
$mocolor = $mocolor1;
// technocurve arc 3 php mv block1/3 end
?>
<?php require_once('../Connections/conexao.php'); ?>
<?php
// Validação de entrada aprimorada e uso de GetSQLValueString
$des_geral = isset($_GET['des']) ? $_GET['des'] : '%';
$ass_geral = isset($_GET['ass']) ? $_GET['ass'] : '%';
$cod_geral = isset($_GET['cod_org']) ? $_GET['cod_org'] : '0';
$ano_geral = isset($_GET['ano']) ? $_GET['ano'] : '%';
$tipo_geral = isset($_GET['tipo_doc']) ? $_GET['tipo_doc'] : '0';
$numdoc_geral = isset($_GET['num_doc']) ? $_GET['num_doc'] : '%';

$query_geral = sprintf("SELECT num_doc.id_num, num_doc.cod_org, num_doc.elaborador, num_tipodoc.desc_tipo_doc, num_tipodoc.tipo_doc, num_doc.num_doc, num_doc.data, num_doc.cod_sec, num_doc.ano_doc, num_doc.assunto, num_doc.destino 
                        FROM num_doc 
                        INNER JOIN num_tipodoc ON (num_doc.tipo_doc = num_tipodoc.tipo_doc) 
                        WHERE num_doc.cod_org = %s 
                        AND num_tipodoc.tipo_doc = %s 
                        AND num_doc.num_doc LIKE %s 
                        AND num_doc.ano_doc LIKE %s 
                        AND num_doc.assunto LIKE %s 
                        AND num_doc.destino LIKE %s 
                        ORDER BY num_doc.num_doc DESC", 
                       GetSQLValueString($conexao, $cod_geral, "int"),
                       GetSQLValueString($conexao, $tipo_geral, "int"),
                       GetSQLValueString($conexao, $numdoc_geral, "text"),
                       GetSQLValueString($conexao, $ano_geral, "text"),
                       GetSQLValueString($conexao, "%" . $ass_geral . "%", "text"),
                       GetSQLValueString($conexao, "%" . $des_geral . "%", "text"));

$geral = mysqli_query($conexao, $query_geral);
$row_geral = mysqli_fetch_assoc($geral);
$totalRows_geral = mysqli_num_rows($geral);

$colname_ano = isset($_GET['cod_org']) ? $_GET['cod_org'] : '0';
$Tipo_ano = isset($_GET['tipo_doc']) ? $_GET['tipo_doc'] : '0';
$query_ano = sprintf("SELECT ano_doc FROM num_doc WHERE cod_org = %s AND tipo_doc = %s GROUP BY ano_doc ORDER BY ano_doc DESC", 
                    GetSQLValueString($conexao, $colname_ano, "int"),
                    GetSQLValueString($conexao, $Tipo_ano, "int"));
$ano = mysqli_query($conexao, $query_ano);
$row_ano = mysqli_fetch_assoc($ano);
$totalRows_ano = mysqli_num_rows($ano);

$colname_nurdoc = isset($_GET['cod_org']) ? $_GET['cod_org'] : '0';
$Tipo_nurdoc = isset($_GET['tipo_doc']) ? $_GET['tipo_doc'] : '0';
$query_nurdoc = sprintf("SELECT num_doc FROM num_doc WHERE cod_org = %s AND tipo_doc = %s GROUP BY num_doc ORDER BY num_doc ASC", 
                       GetSQLValueString($conexao, $colname_nurdoc, "int"),
                       GetSQLValueString($conexao, $Tipo_nurdoc, "int"));
$nurdoc = mysqli_query($conexao, $query_nurdoc);
$row_nurdoc = mysqli_fetch_assoc($nurdoc);
$totalRows_nurdoc = mysqli_num_rows($nurdoc);
?>
<html>
<head>
<title>Numerador</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
<link  href="/numerador/public/css/Geral.css?v=1753940642" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="form1" method="get" action="geralconsadm.php">
  <div align="center"> 
    <table width="98%" border="0" align="center" bgcolor="#DFDFDF">
      <tr> 
        <td height="13" colspan="2"><div align="center">SELECIONE O N&Uacute;MERO 
            DO DOCUMENTO 
            <select name="num_doc" id="num_doc">
              <option value="%">Todos</option>
              <?php
              if ($totalRows_nurdoc > 0) {
                  mysqli_data_seek($nurdoc, 0);
                  while($row_nurdoc_loop = mysqli_fetch_assoc($nurdoc)) {  
              ?>
              <option value="<?php echo htmlspecialchars($row_nurdoc_loop['num_doc'])?>"><?php echo htmlspecialchars($row_nurdoc_loop['num_doc'])?></option>
              <?php
                  }
              }
              ?>
            </select>
            SELECIONE OUTRO ANO 
            <select name="ano" id="ano">
              <option value="%" <?php if (!(strcmp("%", (isset($_GET['ano']) ? $_GET['ano'] : '')))) {echo "SELECTED";} ?>>Todos</option>
              <?php
              if ($totalRows_ano > 0) {
                  mysqli_data_seek($ano, 0);
                  while($row_ano_loop = mysqli_fetch_assoc($ano)) {
              ?>
              <option value="<?php echo htmlspecialchars($row_ano_loop['ano_doc'])?>"<?php if (isset($_GET['ano']) && !(strcmp($row_ano_loop['ano_doc'], $_GET['ano']))) {echo "SELECTED";} ?>><?php echo htmlspecialchars($row_ano_loop['ano_doc'])?></option>
              <?php
                  }
              }
              ?>
            </select>
            &nbsp; 
            <input type="submit" name="Submit" value="Filtragem">
            <input name="tipo_doc" type="hidden" id="tipo_doc" value="<?php echo htmlspecialchars($_GET['tipo_doc']); ?>">
            <input name="cod_org" type="hidden" id="cod_org" value="<?php echo htmlspecialchars($_GET['cod_org']); ?>">
            <br>
            PARTE DO assunto 
            <input name="ass" type="text" id="ass" value="<?php echo isset($_GET['ass']) ? htmlspecialchars($_GET['ass']) : '' ?>">
            PARTE DO destino 
            <input name="des" type="text" id="des" value="<?php echo isset($_GET['des']) ? htmlspecialchars($_GET['des']) : '' ?>">
          </div></td>
      </tr>
    </table>
  </div>
</form>

<?php if ($totalRows_geral > 0): ?>
    <?php do { ?>
    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr <?php 
    // technocurve arc 3 php mv block2/3 start
    echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
    // technocurve arc 3 php mv block2/3 end
    ?>> 
        <td width="20%"> <div align="center"><font color="#990000"><strong><font color="#000066"><?php echo htmlspecialchars($row_geral['desc_tipo_doc']); ?></font><br>
            </strong></font> 
            <div align="center">N&ordm; <?php echo htmlspecialchars($row_geral['num_doc']); ?> / <?php echo htmlspecialchars($row_geral['cod_sec']); ?> / <?php echo htmlspecialchars($row_geral['ano_doc']); ?></div>
            <font color="#990000"><strong> </strong></font></div>
          <div align="center"><?php echo Consert_DataBr($row_geral['data']); ?></div></td>
        <td width="72%" align="left" valign="top"><font color="#0000FF"><strong>assunto</strong>:</font>&nbsp;<?php echo htmlspecialchars($row_geral['assunto']); ?> <br> 
          <div align="left"><font color="#0000FF"><strong>DESTINO</strong>:</font> 
            <?php echo htmlspecialchars($row_geral['destino']); ?><br>
            <font color="#0000FF"><strong>elaborador:</strong></font> RE <?php echo htmlspecialchars($row_geral['elaborador']); ?><br>
          </div></td>
        <td width="8%"> <div align="center"></div>
          <div align="center"><a href="atualiassi.php?id_num=<?php echo $row_geral['id_num']; ?>">Atualizar</a></div></td>
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
    <?php } while ($row_geral = mysqli_fetch_assoc($geral)); ?>
<?php endif; ?>

<div align="center" style="margin-top: 20px;"><font color="#0000CC" size="4"><strong> 
  <?php if ($totalRows_geral == 0) { // Show if recordset empty ?>
  SELECIONE OUTROS DADOS PARA FILTRAGEM
<?php } // Show if recordset empty ?>
  </strong></font> </div>
</body>
</html>
<?php
mysqli_free_result($geral);
mysqli_free_result($ano);
mysqli_free_result($nurdoc);
?>