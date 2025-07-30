<?php
// technocurve arc 3 php mv block1/3 start
$mocolor1 = "#CCCCCC";
$mocolor2 = "#E5E5E5";
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
$tipo_geral = "1";
if (isset($_GET['tipo_doc'])) {
  $tipo_geral = $_GET['tipo_doc'];
}
$numdoc_geral = "1";
if (isset($_GET['num_doc'])) {
  $numdoc_geral = $_GET['num_doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_geral = sprintf("SELECT num_doc.id_num, num_doc.cod_org, num_doc.elaborador, num_tipodoc.desc_tipo_doc, num_tipodoc.tipo_doc, num_doc.data, 
num_doc.num_doc, num_doc.cod_sec, num_doc.ano_doc, num_doc.assunto, num_doc.destino FROM num_doc INNER JOIN num_tipodoc ON (num_doc.tipo_doc = num_tipodoc.tipo_doc)
WHERE (num_doc.cod_org = '%s' AND num_tipodoc.tipo_doc = '%s' AND num_doc.num_doc LIKE '%s' AND num_doc.ano_doc LIKE '%s' AND num_doc.assunto LIKE '%%%s%%' AND num_doc.destino LIKE '%%%s%%')
ORDER BY num_doc.num_doc DESC", $cod_geral,$tipo_geral,$numdoc_geral,$ano_geral,$ass_geral,$des_geral);
$geral = mysqli_query($conexao, $query_geral);
$row_geral = mysqli_fetch_assoc($geral);
$totalRows_geral = mysqli_num_rows($geral);

$colname_ano = "1";
if (isset($_GET['cod_org'])) {
  $colname_ano = $_GET['cod_org'];
}
$Tipo_ano = "1";
if (isset($_GET['tipo_doc'])) {
  $Tipo_ano = $_GET['tipo_doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_ano = sprintf("SELECT cod_org     , tipo_doc     , ano_doc FROM num_doc WHERE (cod_org = '%s'     AND tipo_doc = '%s') GROUP BY ano_doc", $colname_ano,$Tipo_ano);
$ano = mysqli_query($conexao, $query_ano);
$row_ano = mysqli_fetch_assoc($ano);
$totalRows_ano = mysqli_num_rows($ano);

$colname_nurdoc = "1";
if (isset($_GET['cod_org'])) {
  $colname_nurdoc = $_GET['cod_org'];
}
$Tipo_nurdoc = "1";
if (isset($_GET['tipo_doc'])) {
  $Tipo_nurdoc = $_GET['tipo_doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_nurdoc = sprintf("SELECT cod_org     , tipo_doc     , ano_doc , num_doc FROM num_doc WHERE (cod_org = '%s'     AND tipo_doc = '%s') GROUP BY num_doc", $colname_nurdoc,$Tipo_nurdoc);
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
<form name="form1" method="get" action="geralcons.php">
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
              <option value="<?php echo $row_nurdoc['num_doc']?>"><?php echo $row_nurdoc['num_doc']?></option>
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
              <option value="<?php echo $row_ano['ano_doc']?>"<?php if (!(strcmp($row_ano['ano_doc'], $_GET['ano']))) {echo "SELECTED";} ?>><?php echo $row_ano['ano_doc']?></option>
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
            <input name="tipo_doc" type="hidden" id="tipo_doc" value="<?php echo $_GET['tipo_doc']; ?>">
            <input name="cod_org" type="hidden" id="cod_org" value="<?php echo $_GET['cod_org']; ?>">
            <br>
            PARTE DO assunto 
            <input name="ass" type="text" id="ass">
            PARTE DO destino 
            <input name="des" type="text" id="des">
          </div></td>
      </tr>
    </table>
  </div>
</form>
<?php do { ?>
<?php if ($totalRows_geral > 0) { // Show if recordset not empty ?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr <?php 
// technocurve arc 3 php mv block2/3 start
echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
// technocurve arc 3 php mv block2/3 end
?>> 
    <td width="24%"> <div align="center"><font color="#FF0000"><strong><font color="#000066"><?php echo $row_geral['desc_tipo_doc']; ?></font></strong>&nbsp;</font></div>
      <div align="center">N&ordm; <?php echo $row_geral['num_doc']; ?> / <?php echo $row_geral['cod_sec']; ?> / <?php echo $row_geral['ano_doc']; ?></div>
      <div align="center"><?php echo Consert_DataBr($row_geral['data']); ?></div></td>
    <td width="76%" align="left" valign="top"><font color="#0000FF"><strong>assunto</strong>:</font>&nbsp;<?php echo $row_geral['assunto']; ?> <br> <div align="left"><font color="#0000FF"><strong>DESTIO</strong>:</font> 
        <?php echo $row_geral['destino']; ?><br>
        <font color="#0000FF"><strong>elaborador:</strong></font> RE <?php echo $row_geral['elaborador']; ?> <br>
      </div></td>
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

