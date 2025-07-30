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
$des_geral = "1";
if (isset($_GET['des'])) {
  $des_geral = $_GET['des'];
}
$ass_geral = "1";
if (isset($_GET['ass'])) {
  $ass_geral = $_GET['ass'];
}
$cod_geral = "1";
if (isset($_GET['cod_org'])) {
  $cod_geral = $_GET['cod_org'];
}
$ano_geral = "1";
if (isset($_GET['ano'])) {
  $ano_geral = $_GET['ano'];
}
$Tipo_geral = "1";
if (isset($_GET['Tipo_Doc'])) {
  $Tipo_geral = $_GET['Tipo_Doc'];
}
$numdoc_geral = "1";
if (isset($_GET['num_doc'])) {
  $numdoc_geral = $_GET['num_doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_geral = sprintf("SELECT num_doc.id_num     , num_doc.cod_org , num_doc.ELABORADOR    , num_tipodoc.desc_tipo_doc     , num_tipodoc.Tipo_Doc     , num_doc.Num_Doc    , num_doc.DATA     , num_doc.Cod_Sec     , num_doc.Ano_Doc     , num_doc.ASSUNTO     , num_doc.DESTINO FROM num_doc     INNER JOIN num_tipodoc          ON (num_doc.Tipo_Doc = num_tipodoc.Tipo_Doc) WHERE (num_doc.cod_org = '%s'     AND num_tipodoc.Tipo_Doc = '%s'     AND num_doc.Num_Doc LIKE '%s'     AND num_doc.Ano_Doc LIKE '%s' AND num_doc.ASSUNTO LIKE '%%%s%%' AND num_doc.DESTINO LIKE '%%%s%%') ORDER BY num_doc.Num_Doc DESC", $cod_geral,$Tipo_geral,$numdoc_geral,$ano_geral,$ass_geral,$des_geral);
$geral = mysqli_query($conexao, $query_geral);
$row_geral = mysqli_fetch_assoc($geral);
$totalRows_geral = mysqli_num_rows($geral);

$colname_ano = "1";
if (isset($_GET['cod_org'])) {
  $colname_ano = $_GET['cod_org'];
}
$Tipo_ano = "1";
if (isset($_GET['Tipo_Doc'])) {
  $Tipo_ano = $_GET['Tipo_Doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_ano = sprintf("SELECT cod_org     , Tipo_Doc     , Ano_Doc FROM num_doc WHERE (cod_org = '%s'     AND Tipo_Doc = '%s') GROUP BY Ano_Doc", $colname_ano,$Tipo_ano);
$ano = mysqli_query($conexao, $query_ano);
$row_ano = mysqli_fetch_assoc($ano);
$totalRows_ano = mysqli_num_rows($ano);

$colname_nurdoc = "1";
if (isset($_GET['cod_org'])) {
  $colname_nurdoc = $_GET['cod_org'];
}
$Tipo_nurdoc = "1";
if (isset($_GET['Tipo_Doc'])) {
  $Tipo_nurdoc = $_GET['Tipo_Doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_nurdoc = sprintf("SELECT cod_org     , Tipo_Doc     , Ano_Doc , Num_Doc FROM num_doc WHERE (cod_org = '%s'     AND Tipo_Doc = '%s') GROUP BY Num_Doc", $colname_nurdoc,$Tipo_nurdoc);
$nurdoc = mysqli_query($conexao, $query_nurdoc);
$row_nurdoc = mysqli_fetch_assoc($nurdoc);
$totalRows_nurdoc = mysqli_num_rows($nurdoc);
?>
<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
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
do {  
?>
              <option value="<?php echo $row_nurdoc['Num_Doc']?>"><?php echo $row_nurdoc['Num_Doc']?></option>
              <?php
} while ($row_nurdoc = mysqli_fetch_assoc($nurdoc));
  $rows = mysqli_num_rows($nurdoc);
  if($rows > 0) {
      mysqli_data_seek($nurdoc, 0);
	  $row_nurdoc = mysqli_fetch_assoc($nurdoc);
  }
?>
            </select>
            SELECIONE OUTRO ANO 
            <select name="ano" id="ano">
              <option value="%" <?php if (!(strcmp("%", $_GET['ano']))) {echo "SELECTED";} ?>>Todos</option>
              <?php
do {  
?>
              <option value="<?php echo $row_ano['Ano_Doc']?>"<?php if (!(strcmp($row_ano['Ano_Doc'], $_GET['ano']))) {echo "SELECTED";} ?>><?php echo $row_ano['Ano_Doc']?></option>
              <?php
} while ($row_ano = mysqli_fetch_assoc($ano));
  $rows = mysqli_num_rows($ano);
  if($rows > 0) {
      mysqli_data_seek($ano, 0);
	  $row_ano = mysqli_fetch_assoc($ano);
  }
?>
            </select>
            &nbsp; 
            <input type="submit" name="Submit" value="Filtragem">
            <input name="Tipo_Doc" type="hidden" id="Tipo_Doc" value="<?php echo $_GET['Tipo_Doc']; ?>">
            <input name="cod_org" type="hidden" id="cod_org" value="<?php echo $_GET['cod_org']; ?>">
            <br>
            PARTE DO ASSUNTO 
            <input name="ass" type="text" id="ass">
            PARTE DO DESTINO 
            <input name="des" type="text" id="des">
          </div></td>
      </tr>
    </table>
  </div>
</form>
<?php do { ?>
<?php if ($totalRows_geral > 0) { // Show if recordset not empty ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr <?php 
// technocurve arc 3 php mv block2/3 start
echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
// technocurve arc 3 php mv block2/3 end
?>> 
    <td width="20%"> <div align="center"><font color="#990000"><strong><font color="#000066"><?php echo $row_geral['desc_tipo_doc']; ?></font><br>
        </strong></font> 
        <div align="center">N&ordm; <?php echo $row_geral['Num_Doc']; ?> / <?php echo $row_geral['Cod_Sec']; ?> / <?php echo $row_geral['Ano_Doc']; ?></div>
        <font color="#990000"><strong> </strong></font></div>
      <div align="center"><?php echo Consert_DataBr($row_geral['DATA']); ?></div></td>
    <td width="72%" align="left" valign="top"><font color="#0000FF"><strong>ASSUNTO</strong>:</font>&nbsp;<?php echo $row_geral['ASSUNTO']; ?> <br> 
      <div align="left"><font color="#0000FF"><strong>DESTIO</strong>:</font> 
        <?php echo $row_geral['DESTINO']; ?><br>
        <font color="#0000FF"><strong>ELABORADOR:</strong></font> RE <?php echo $row_geral['ELABORADOR']; ?><br>
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
<?php } // Show if recordset not empty ?>
<?php } while ($row_geral = mysqli_fetch_assoc($geral)); ?>
<p align="center"><br>
  <font color="#0000CC" size="4"> <strong> </strong> </font> </p>

<p>
  <?php
function converte_data($data)
    {
        // Recebe a data no formato: "dd/mm/aaaa" e a converte para o formato: "aaaa-mm-dd"
        if ( preg_match("#/#",$data) == 1 )
        {
	        $DataCon = "";
	        $DataCon .= implode('-', array_reverse(explode('/',$data)));
	        $DataCon .= "";
         }
         return $DataCon;
    }
function Consert_DataBr($data)
    {
        // Recebe a data no formato: "aaaa-mm-dd" e a converte para o formato: "dd/mm/aaaa"
        if ( preg_match("#-#",$data) == 1 )
        {
	        $DataCon = "";
	        $DataCon = implode('/', array_reverse(explode('-',$data)));
	        $DataCon .= "";
         }
         return $DataCon;
    }
	?>
</p>
<div align="center"><font color="#0000CC" size="4"><strong> 
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

