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
                       GetSQLValueString($_GET['Cod_Org'], "text"),
                       GetSQLValueString($_GET['Tipo_Doc'], "text"),
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

  $insertGoTo = "atualinvovdoc.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_listadoc = "1";
if (isset($_GET['Cod_Org'])) {
  $colname_listadoc = $_GET['Cod_Org'];
}
mysqli_select_db($conexao, $database_conexao);
$query_listadoc = sprintf("SELECT     num_doc.Cod_Org     , num_doc.Tipo_Doc     , num_tipodoc.DescTipo_Doc     , num_doc.Ano_Doc     , num_doc.Num_Doc     , num_org.org_CodSecao FROM     num_doc     INNER JOIN num_tipodoc          ON (num_doc.Tipo_Doc = num_tipodoc.Tipo_Doc)     INNER JOIN num_org          ON (num_doc.Cod_Org = num_org.org_id) WHERE (num_doc.Cod_Org = '%s') GROUP BY num_doc.Tipo_Doc;", $colname_listadoc);
$listadoc = mysqli_query($conexao, $query_listadoc);
$row_listadoc = mysqli_fetch_assoc($listadoc);
$totalRows_listadoc = mysqli_num_rows($listadoc);

$colname_documento = "1";
if (isset($_GET['Tipo_Doc'])) {
  $colname_documento = $_GET['Tipo_Doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_documento = sprintf("SELECT * FROM num_tipodoc WHERE Tipo_Doc = %s ORDER BY DescTipo_Doc ASC", $colname_documento);
$documento = mysqli_query($conexao, $query_documento);
$row_documento = mysqli_fetch_assoc($documento);
$totalRows_documento = mysqli_num_rows($documento);

$colname_Recordset1 = "1";
if (isset($_GET['Cod_Org'])) {
  $colname_Recordset1 = $_GET['Cod_Org'];
}
mysqli_select_db($conexao, $database_conexao);
$query_Recordset1 = sprintf("SELECT * FROM num_org WHERE org_id = %s", $colname_Recordset1);
$Recordset1 = mysqli_query($conexao, $query_Recordset1);
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$colname_numero = "1";
if (isset($_GET['Cod_Org'])) {
  $colname_numero = $_GET['Cod_Org'];
}
$tipo_numero = "1";
if (isset($_GET['Tipo_Doc'])) {
  $tipo_numero = $_GET['Tipo_Doc'];
}
mysqli_select_db($conexao, $database_conexao);
$query_numero = sprintf("SELECT* FROM     num_doc WHERE (Cod_Org = '%s'     AND Tipo_Doc = '%s') ORDER BY Ano_Doc DESC, Num_Doc DESC;", $colname_numero,$tipo_numero);
$numero = mysqli_query($conexao, $query_numero);
$row_numero = mysqli_fetch_assoc($numero);
$totalRows_numero = mysqli_num_rows($numero);
?>
<?php 
$ano = $row_numero['Ano_Doc'];
$ano1 = date ("y");
if ($ano == $ano1){
$numdoc = $row_numero['Num_Doc']+1;
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
              <td valign="middle" nowrap bgcolor="#FFFFFF"> <div align="center"><font color="#000099" size="3"><?php echo $row_documento['DescTipo_Doc']; ?></font><font size="4"> <font color="#990000">N&ordm; 
                  &nbsp;<?php echo $numdoc ?></font></font><font color="#990000" size="4"> 
                  / <?php echo $row_Recordset1['org_CodSecao']; ?>&nbsp;/&nbsp;<?php echo $ano1 ?></font><font color="#990000"><br>
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
                  <input type="hidden" name="DESTINO" value="Preencher" size="60">
                  <input name="observacao" type="hidden" id="observacao" value="sem obs" size="60">
                  <input type="hidden" name="DATA" value="<?php echo date("Y-m-d");  ?>" size="32">
                  <input type="hidden" name="Ano_Doc" value="<?php echo $ano1 ?>" size="32">
                  <input type="hidden" name="Cod_Sec" value="<?php echo $row_Recordset1['org_CodSecao']; ?>" size="32">
                  <input type="hidden" name="Cod_Org" value="<?php echo $row_Recordset1['org_id']; ?>" size="32">
                  <input name="submit" type="submit" value="Confirmar a reserva">
                  <input name="Tipo_Doc" type="hidden" id="Tipo_Doc" value="<?php echo $row_documento['Tipo_Doc']; ?>">
                  <input type="hidden" name="ELABORADOR" value="<?php echo $_GET['re']; ?>" size="32">
                  <input name="Num_Doc" type="hidden" value="<?php echo $numdoc ?>" size="6">
                  <input name="ENCAMINHADO" type="hidden" id="ENCAMINHADO" value="1">
                  <input name="ASSINADO" type="hidden" id="ASSINADO" value="1">
                  <input name="ELABORADO" type="hidden" id="ELABORADO" value="0">
                  <input name="ASSUNTO" type="hidden" value="preencher" size="60">
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

