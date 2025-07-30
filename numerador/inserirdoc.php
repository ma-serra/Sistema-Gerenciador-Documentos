<?php require_once('../Connections/conexao.php'); ?>
<?php

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

if ((isset($_GET["MM_insert"])) && ($_GET["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO num_doc (cod_org, tipo_doc, num_doc, cod_sec, ano_doc, assunto, destino, `data`, elaborador, obs_doc, ELABORADO, ASSINADO, ENCAMINHADO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_GET['cod_org'], "text"),
                       GetSQLValueString($_GET['tipo_doc'], "text"),
                       GetSQLValueString($_GET['num_doc'], "text"),
                       GetSQLValueString($_GET['cod_sec'], "text"),
                       GetSQLValueString($_GET['ano_doc'], "text"),
                       GetSQLValueString($_GET['assunto'], "text"),
                       GetSQLValueString($_GET['destino'], "text"),
                       GetSQLValueString($_GET['data'], "date"),
                       GetSQLValueString($_GET['elaborador'], "text"),
                       GetSQLValueString($_GET['observacao'], "text"),
                       GetSQLValueString($_GET['ELABORADO'], "int"),
                       GetSQLValueString($_GET['ASSINADO'], "int"),
                       GetSQLValueString($_GET['ENCAMINHADO'], "int"));

  mysqli_select_db($conexao, $database_conexao);
  $Result1 = mysqli_query($conexao, $insertSQL);

  $insertGoTo = "atualinvovdoc.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_listadoc = "1";
if (isset($_GET['cod_org'])) {
  $colname_listadoc = $_GET['cod_org'];
}
mysqli_select_db($conexao, $database_conexao);
$query_listadoc = sprintf("SELECT     num_doc.cod_org     , num_doc.tipo_doc     , num_tipodoc.desc_tipo_doc     , num_doc.ano_doc     , num_doc.num_doc     , num_org.org_cod_secao FROM     num_doc     INNER JOIN num_tipodoc          ON (num_doc.tipo_doc = num_tipodoc.tipo_doc)     INNER JOIN num_org          ON (num_doc.cod_org = num_org.org_id) WHERE (num_doc.cod_org = '%s') GROUP BY num_doc.tipo_doc;", $colname_listadoc);
$listadoc = mysqli_query($conexao, $query_listadoc);
$row_listadoc = mysqli_fetch_assoc($listadoc);
$totalRows_listadoc = mysqli_num_rows($listadoc);

$colname_documento = "1";
if (isset($_GET['tipo_doc'])) {
  $colname_documento = $_GET['tipo_doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_documento = sprintf("SELECT * FROM num_tipodoc WHERE tipo_doc = %s ORDER BY desc_tipo_doc ASC", $colname_documento);
$documento = mysqli_query($conexao, $query_documento);
$row_documento = mysqli_fetch_assoc($documento);
$totalRows_documento = mysqli_num_rows($documento);

$colname_Recordset1 = "1";
if (isset($_GET['cod_org'])) {
  $colname_Recordset1 = $_GET['cod_org'];
}
mysqli_select_db($conexao, $database_conexao);
$query_Recordset1 = sprintf("SELECT * FROM num_org WHERE org_id = %s", $colname_Recordset1);
$Recordset1 = mysqli_query($conexao, $query_Recordset1);
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$colname_numero = "1";
if (isset($_GET['cod_org'])) {
  $colname_numero = $_GET['cod_org'];
}
$tipo_numero = "1";
if (isset($_GET['tipo_doc'])) {
  $tipo_numero = $_GET['tipo_doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_numero = sprintf("SELECT* FROM     num_doc WHERE (cod_org = '%s'     AND tipo_doc = '%s') ORDER BY ano_doc DESC, num_doc DESC;", $colname_numero,$tipo_numero);
$numero = mysqli_query($conexao, $query_numero);
$row_numero = mysqli_fetch_assoc($numero);
$totalRows_numero = mysqli_num_rows($numero);
?>
<?php 
$ano = $row_numero['ano_doc'];
$ano1 = date ("y");
if ($ano == $ano1){
$numdoc = $row_numero['num_doc']+1;
}
else
{$numdoc = 1;}
$numdoc = str_pad($numdoc, 4, "0", STR_PAD_LEFT);
 ?>
<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

<form action="<?php echo $editFormAction; ?>" method="get" name="form1">
  <table width="400" border="12" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td height="105" valign="top"><div align="center">
          <table width="100%" border="0" align="center">
            <tr valign="baseline"> 
              <td align="right" nowrap bgcolor="#CCCCCC"> <div align="center"><font color="#000099" size="3">CADASTRO 
                  DE NOVO NUMERADOR DA SE&Ccedil;&Atilde;O<br>
                  <br>
                  </font></div></td>
            </tr>
            <tr align="center" valign="baseline"> 
              <td valign="middle" nowrap bgcolor="#FFFFFF"> <div align="center"><font color="#000099" size="3"><?php echo $row_documento['desc_tipo_doc']; ?></font><font size="4"> <font color="#990000">N&ordm; 
                  &nbsp;<?php echo $numdoc ?></font></font><font color="#990000" size="4"> 
                  / <?php echo $row_Recordset1['org_cod_secao']; ?>&nbsp;/&nbsp;<?php echo $ano1 ?></font><font color="#990000"><br>
                  </font><font color="#FF0000"><br>
                  </font></div></td>
            </tr>
            <tr valign="baseline"> 
              <td align="right" valign="middle" nowrap bgcolor="#FFFFFF"> <div align="center"><font color="#0000CC" size="3">Ap&oacute;s 
                  confirmar a reserva deste n&uacute;mero preencha os demais dados</font></div>
                <div align="center"> </div></td>
            </tr>
            <tr valign="baseline"> 
              <td align="right" nowrap bgcolor="#CCCCCC"> <div align="center"> 
                  <input type="hidden" name="MM_insert" value="form1">
                  <input type="hidden" name="destino" value="Preencher" size="60">
                  <input name="observacao" type="hidden" id="observacao" value="sem obs" size="60">
                  <input type="hidden" name="data" value="<?php echo date("Y-m-d");  ?>" size="32">
                  <input type="hidden" name="ano_doc" value="<?php echo $ano1 ?>" size="32">
                  <input type="hidden" name="cod_sec" value="<?php echo $row_Recordset1['org_cod_secao']; ?>" size="32">
                  <input type="hidden" name="cod_org" value="<?php echo $row_Recordset1['org_id']; ?>" size="32">
                  <input name="submit" type="submit" value="Confirmar a reserva">
                  <input name="tipo_doc" type="hidden" id="tipo_doc" value="<?php echo $row_documento['tipo_doc']; ?>">
                  <input type="hidden" name="elaborador" value="<?php echo $_GET['re']; ?>" size="32">
                  <input name="num_doc" type="hidden" value="<?php echo $numdoc ?>" size="6">
                  <input name="ENCAMINHADO" type="hidden" id="ENCAMINHADO" value="1">
                  <input name="ASSINADO" type="hidden" id="ASSINADO" value="1">
                  <input name="ELABORADO" type="hidden" id="ELABORADO" value="0">
                  <input name="assunto" type="hidden" value="preencher" size="60">
                </div></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysqli_free_result($listadoc);

mysqli_free_result($documento);

mysqli_free_result($Recordset1);

mysqli_free_result($numero);
?>

