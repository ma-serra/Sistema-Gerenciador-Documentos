<?php require_once('../Connections/conexao.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

if ((isset($_GET["MM_insert"])) && ($_GET["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO num_doc (Cod_Org, Tipo_Doc, Num_Doc, Cod_Sec, Ano_Doc, ASSUNTO, DESTINO, `DATA`, ELABORADOR, obs_doc, ELABORADO, ASSINADO, ENCAMINHADO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                      GetSQLValueString($_GET['Cod_Org'], "int"),
                      GetSQLValueString($_GET['Tipo_Doc'], "int"),
                      GetSQLValueString($_GET['Num_Doc'], "text"),
                      GetSQLValueString($_GET['Cod_Sec'], "text"),
                      GetSQLValueString($_GET['Ano_Doc'], "text"),
                      GetSQLValueString($_GET['ASSUNTO'], "text"),
                      GetSQLValueString($_GET['DESTINO'], "text"),
                      GetSQLValueString($_GET['DATA'], "date"),
                      GetSQLValueString($_GET['ELABORADOR'], "text"),
                      GetSQLValueString($_GET['observacao'], "text"),
                      GetSQLValueString($_GET['ELABORADO'], "int"),
                      GetSQLValueString($_GET['ASSINADO'], "int"),
                      GetSQLValueString($_GET['ENCAMINHADO'], "int"));

  mysqli_select_db($conexao, $database_conexao);
  $Result1 = mysqli_query($conexao, $insertSQL);

  $insertGoTo = "acaooknumerador.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_listadoc = "0";
if (isset($_GET['Cod_Org'])) {
  $colname_listadoc = $_GET['Cod_Org'];
}
mysqli_select_db($conexao, $database_conexao);
$query_listadoc = sprintf("SELECT num_doc.Cod_Org     , num_doc.Tipo_Doc     , num_tipodoc.DescTipo_Doc     , num_doc.Ano_Doc     , num_doc.Num_Doc     , num_org.org_CodSecao FROM num_doc     INNER JOIN num_tipodoc          ON (num_doc.Tipo_Doc = num_tipodoc.Tipo_Doc)     INNER JOIN num_org          ON (num_doc.Cod_Org = num_org.org_id) WHERE (num_doc.Cod_Org = '%s') GROUP BY num_doc.Tipo_Doc", $colname_listadoc);
$listadoc = mysqli_query($conexao, $query_listadoc);
$row_listadoc = mysqli_fetch_assoc($listadoc);
$totalRows_listadoc = mysqli_num_rows($listadoc);

$colname_documento = "0";
if (isset($_GET['Tipo_Doc'])) {
  $colname_documento = $_GET['Tipo_Doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_documento = sprintf("SELECT * FROM num_tipodoc WHERE Tipo_Doc = %s ORDER BY DescTipo_Doc ASC", $colname_documento);
$documento = mysqli_query($conexao, $query_documento);
$row_documento = mysqli_fetch_assoc($documento);
$totalRows_documento = mysqli_num_rows($documento);

$colname_Recordset1 = "0";
if (isset($_GET['Cod_Org'])) {
  $colname_Recordset1 = $_GET['Cod_Org'];
}
mysqli_select_db($conexao, $database_conexao);
$query_Recordset1 = sprintf("SELECT * FROM num_org WHERE org_id = %s", $colname_Recordset1);
$Recordset1 = mysqli_query($conexao, $query_Recordset1);
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$colname_numero = "0";
if (isset($_GET['Cod_Org'])) {
  $colname_numero = $_GET['Cod_Org'];
}
$tipo_numero = "0";
if (isset($_GET['Tipo_Doc'])) {
  $tipo_numero = $_GET['Tipo_Doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_numero = sprintf("SELECT * FROM num_doc WHERE Cod_Org = '%s' AND Tipo_Doc = '%s' ORDER BY Id_Num DESC", $colname_numero,$tipo_numero);
$Recordset1 = mysqli_query($conexao, $query_numero);
$row_Recordset1 = mysqli_fetch_assoc($numero);
$totalRows_numero = mysqli_num_rows($numero);
?>
<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php 
$ano = $row_numero['Ano_Doc'];
$ano1 = date ("Y");
if ($ano == $ano1){
$numdoc = $row_numero['Num_Doc']+1;
}
else
{$numdoc = 1;}
$numdoc = str_pad($numdoc, 4, "0", STR_PAD_LEFT);
 ?>
<form action="<?php echo $editFormAction; ?>" method="get" name="form1">
  <table width="420" border="12" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td height="105" valign="top"><div align="center"> 
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
            <tr valign="baseline"> 
              <td colspan="2" align="right" nowrap bgcolor="#CCCCCC"> <div align="center"><font color="#000099" size="3">Cadastro 
                  de novo numerador da se&ccedil;&atilde;o<br>
                  <?php echo $row_documento['DescTipo_Doc']; ?><br>
                  </font></div></td>
            </tr>
            <tr align="center" valign="baseline"> 
              <td colspan="2" valign="middle" nowrap bgcolor="#FFFFFF"> <div align="center">N&uacute;mero 
                  do Documento<font color="#000099" size="6"> <?php echo $numdoc ?></font><font color="#FF0000"> 
                  /&nbsp; <?php echo $row_numero['Cod_Org']; ?>&nbsp;/&nbsp;<?php echo $row_numero['Ano_Doc']; ?><br>
                  </font></div></td>
            </tr>
            <tr valign="baseline"> 
              <td width="239" align="right" valign="middle" nowrap> <div align="center">ASSUNTO:</div></td>
              <td width="784"><div align="center"> 
                  <textarea name="ASSUNTO" cols="60" rows="2"></textarea>
                </div></td>
            </tr>
            <tr valign="baseline"> 
              <td height="35" align="right" valign="middle" nowrap bgcolor="#FFFFFF"> 
                <div align="center">DESTINO:</div></td>
              <td valign="middle" bgcolor="#FFFFFF"> <div align="center"> 
                  <textarea name="DESTINO" cols="60" rows="2"></textarea>
                </div></td>
            </tr>
            <tr valign="baseline"> 
              <td align="right" valign="middle" nowrap> <div align="center">OBSERVA��O:</div></td>
              <td> <div align="center"> 
                  <textarea name="observacao" cols="60" rows="2" id="observacao"></textarea>
                </div></td>
            </tr>
            <tr valign="baseline"> 
              <td colspan="2" align="right" valign="middle" nowrap bgcolor="#FFFFFF"> 
                <div align="center"></div>
                <div align="center">ELABORADO:&nbsp;&nbsp;&nbsp;N&atilde;o 
                  <input name="ELABORADO" type="radio" value="0" checked>
                  &nbsp;&nbsp;&nbsp;SIM 
                  <input type="radio" name="ELABORADO" value="1">
                </div></td>
            </tr>
            <tr valign="baseline"> 
              <td colspan="2" align="right" nowrap bgcolor="#CCCCCC"> <div align="center"> 
                  <input type="hidden" name="DATA" value="<?php echo date("Y-m-d");  ?>" size="32">
                  <input type="hidden" name="Ano_Doc" value="<?php echo $ano1 ?>" size="32">
                  <input type="hidden" name="Cod_Sec" value="<?php echo $row_Recordset1['org_CodSecao']; ?>" size="32">
                  <input type="hidden" name="Cod_Org" value="<?php echo $row_Recordset1['org_id']; ?>" size="32">
                  <input name="submit" type="submit" value="Inserir registro">
                  <input name="Tipo_Doc" type="hidden" id="Tipo_Doc" value="<?php echo $row_documento['Tipo_Doc']; ?>">
                  <input type="hidden" name="ELABORADOR" value="<?php echo $_GET['re']; ?>" size="32">
                  <input name="Num_Doc" type="hidden" value="<?php echo $numdoc ?>" size="6">
                  <input name="ASSINADO" type="hidden" id="ASSINADO2" value="<?php echo $row_numero['ASSINADO']; ?>">
                  <input name="ENCAMINHADO" type="hidden" id="ENCAMINHADO2" value="<?php echo $row_numero['ENCAMINHADO']; ?>">
                </div></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
<?php
mysqli_free_result($listadoc);

mysqli_free_result($documento);

mysqli_free_result($Recordset1);

mysqli_free_result($numero);
?>

