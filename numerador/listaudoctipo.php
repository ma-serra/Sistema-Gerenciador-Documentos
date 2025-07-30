<?php
// technocurve arc 3 php mv block1/3 start
$mocolor1 = "#CCCCCC";
$mocolor2 = "#FFFFFF";
$mocolor3 = "#FFFFCC";
$mocolor = $mocolor1;
// technocurve arc 3 php mv block1/3 end

// technocurve arc 3 php mv block1/3 start
$mocolor1 = "#CCCCCC";
$mocolor2 = "#CCCCCC";
$mocolor3 = "#FFFFCC";
$mocolor = $mocolor1;
// technocurve arc 3 php mv block1/3 end
?>
<?php require_once('../Connections/conexao.php'); ?>
<?php

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

if ((isset($_GET["MM_insert"])) && ($_GET["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO num_doc (cod_org, obs_doc, tipo_doc, num_doc, cod_sec, ano_doc, assunto, destino, `data`, elaborador, ELABORADO, ASSINADO, ENCAMINHADO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_GET['cod_org'], "text"),
                       GetSQLValueString($_GET['obeservacao'], "text"),
                       GetSQLValueString($_GET['tipo_doc'], "text"),
                       GetSQLValueString($_GET['num_doc'], "text"),
                       GetSQLValueString($_GET['cod_sec'], "text"),
                       GetSQLValueString($_GET['ano_doc'], "text"),
                       GetSQLValueString($_GET['assunto'], "text"),
                       GetSQLValueString($_GET['destino'], "text"),
                       GetSQLValueString($_GET['data'], "date"),
                       GetSQLValueString($_GET['elaborador'], "text"),
                       GetSQLValueString($_GET['ELABORADO'], "int"),
                       GetSQLValueString($_GET['ASSINADO'], "int"),
                       GetSQLValueString($_GET['ENCAMINHADO'], "int"));

  mysqli_select_db($conexao, $database_conexao);
  $Result1 = mysqli_query($conexao, $insertSQL);

  $insertGoTo = "acaooknovotipodoc.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_listadoc = "0";
if (isset($_GET['cod_org'])) {
  $colname_listadoc = $_GET['cod_org'];
}
mysqli_select_db($conexao, $database_conexao);
$query_listadoc = sprintf("SELECT num_doc.cod_org     , num_doc.tipo_doc     , num_tipodoc.desc_tipo_doc     , num_doc.ano_doc     , num_doc.num_doc     , num_org.org_cod_secao FROM num_doc     INNER JOIN num_tipodoc          ON (num_doc.tipo_doc = num_tipodoc.tipo_doc)     INNER JOIN num_org          ON (num_doc.cod_org = num_org.org_id) WHERE (num_doc.cod_org = '%s') GROUP BY num_doc.tipo_doc", $colname_listadoc);
$listadoc = mysqli_query($conexao, $query_listadoc);
$row_listadoc = mysqli_fetch_assoc($listadoc);
$totalRows_listadoc = mysqli_num_rows($listadoc);

mysqli_select_db($conexao, $database_conexao);
$query_documento = "SELECT * FROM num_tipodoc ORDER BY desc_tipo_doc ASC";
$documento = mysqli_query($conexao, $query_documento);
$row_documento = mysqli_fetch_assoc($documento);
$totalRows_documento = mysqli_num_rows($documento);

$colname_Recordset1 = "0";
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
<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php 
/*
$ano = $row_connbi['ano_nbi'];
$ano1 = date ("Y");
if ($ano == $ano1){
$nbi = $row_connbi['numero_nbi']+1;
}
*/
$ano = !isset($row_numero['ano_doc']);
$ano1 = date ("Y");
if ($ano == $ano1){
$numdoc = !isset($row_numero['num_doc']);
}
else
{$numdoc = 1;}
$numdoc = str_pad($numdoc, 4, "0", STR_PAD_LEFT);
 ?>
<script language="Javascript" type="text/javascript">function Completar(Max, Qtd, Caracter) {if (Qtd > Max) {alert("Preenchimento incorrto! O m�ximo desse campo � de " + Max + " caracteres!");} else {Restante = parseInt(Max) - parseInt(Qtd);for(i=0;i<Restante;i++) {NovoValor = Caracter + document.forms[0].elements[0].value;document.forms[0].elements[0].value = NovoValor;}}}</script>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="get" name="form1">
  <table width="90%" border="0" align="center">
    <tr> 
      <td height="105" colspan="3" valign="top"> 
        <div align="center"><font color="#0000CC" size="3">LISTA DE NUMERADORES 
          DA SE&Ccedil;&Atilde;O ABERTOS</font> </div>
        <?php do { ?>
        <table width="90%" border="0" align="center">
          <tr <?php 
// technocurve arc 3 php mv block2/3 start
echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
// technocurve arc 3 php mv block2/3 end
?>> 
            <td height="13" colspan="2"><div align="center"><?php echo $row_listadoc['desc_tipo_doc']; ?> </div></td>
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
      </td>
      <td width="79%" height="105"><table width="420" border="12" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td height="105" valign="top"><div align="center"> 
                <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#E8E8E8">
                  <tr> 
                    <td height="5" bgcolor="#CCCCCC"> <div align="center"><font color="#000099" size="3">Cadastro 
                        de abertura de novo numerador da se&ccedil;&atilde;o<br>
                        Inicie com inclus&atilde;o do 1&ordm; Documento</font> 
                      </div></td>
                  </tr>
                  <tr> 
                    <td width="43%" height="18"> <div align="center">N&uacute;mero 
                        do Documento, se for o primeiro inicie com 0001 ou se 
                        possui uma sequ&ecirc;ncia inicie com o pr&oacute;ximo 
                        n&uacute;mero utilizando 4 caracteres:<br>
                        <input name="num_doc" type="text" id="Num_Doc2" onBlur="Completar(4,this.value.length,'0')" size="4">
                        <font color="#FF0000"><br>
                        Obs: obrigat&oacute;rio o uso de 4 caracteres,favor completar 
                        com o valor '0' &agrave; esquerda.</font></div></td>
                  </tr>
                  <tr> 
                    <td height="13"><div align="center"><font color="#FF0000">Selecione 
                        o tipo de documento: se n&atilde;o consta <br>
                        <select name="tipo_doc" id="select2">
                          <option value="">Selecionar</option>
                          <?php
do {  
?>
                          <option value="<?php echo $row_documento['tipo_doc']?>"><?php echo $row_documento['desc_tipo_doc']?></option>
                          <?php
} while ($row_documento = mysqli_fetch_assoc($documento));
  $rows = mysqli_num_rows($documento);
  if($rows > 0) {
      mysqli_data_seek($documento, 0);
	  $row_documento = mysqli_fetch_assoc($documento);
  }
?>
                        </select>
                        &nbsp; <a href="cadastrodoctipo.php">crie um 
                        novo</a> </font></div></td>
                  </tr>
                  <tr> 
                    <td height="13"><div align="center">assunto:<br>
                        <textarea name="assunto" cols="60" rows="2"></textarea>
                      </div></td>
                  </tr>
                  <tr> 
                    <td height="13"><div align="center">destino:<br>
                        <textarea name="destino" cols="60" rows="2"></textarea>
                      </div></td>
                  </tr>
                  <tr> 
                    <td height="13"><div align="center">OBSERVA��O:<br>
                        <textarea name="obeservacao" cols="60" rows="2" id="obeservacao"></textarea>
                      </div></td>
                  </tr>
                  <tr> 
                    <td height="13"><div align="center">ELABORADO:&nbsp;&nbsp;&nbsp;&nbsp;N&atilde;o 
                        <input name="ELABORADO" type="radio" value="0" checked>
                        &nbsp;&nbsp;&nbsp;SIM 
                        <input type="radio" name="ELABORADO" value="1">
                      </div></td>
                  </tr>
                  <tr> 
                    <td height="13" bgcolor="#CCCCCC"> <div align="center"> 
                        <input type="hidden" name="data" value="<?php echo date("Y-m-d");  ?>" size="32">
                        <input type="hidden" name="ano_doc" value="<?php echo $ano1 ?>" size="32">
                        <input type="hidden" name="cod_sec" value="<?php echo $row_Recordset1['org_cod_secao']; ?>" size="32">
                        <input type="hidden" name="cod_org" value="<?php echo $row_Recordset1['org_id']; ?>" size="32">
                        <input name="submit" type="submit" value="Inserir registro">
                        <input type="hidden" name="elaborador" value="<?php echo $_GET['re']; ?>" size="32">
                        <input name="ASSINADO" type="hidden" id="ASSINADO3" value="1">
                        <input name="ENCAMINHADO" type="hidden" id="ENCAMINHADO3" value="1">
                      </div></td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </table></td>
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
?>

