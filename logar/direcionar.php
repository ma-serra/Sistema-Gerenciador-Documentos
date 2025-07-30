<?php require_once('../Connections/conexao.php'); ?>
 <?php include("restrito.php"); ?>
<?php
$colname_user = "1";
if (isset($_GET['re'])) {
  $colname_user = $_GET['re'];
}
mysqli_select_db($conexao, $database_conexao);
$query_user = sprintf("SELECT num_user.rerg     , num_user.postfunc     , num_user.guerra     , num_user.senha     , num_user.Org_id     , num_org.org_descUnid     , num_org.org_CodSecao     , num_org.org_desc FROM numerador_db.num_user     INNER JOIN numerador_db.num_org          ON (num_user.Org_id = num_org.org_id) WHERE (num_user.rerg = '%s')", $colname_user);
$user = mysqli_query($conexao, $query_user);
$row_user = mysqli_fetch_assoc($user);
$totalRows_user = mysqli_num_rows($user);

$colname_master = "1";
if (isset($_GET['re'])) {
  $colname_master = $_GET['re'];
}
mysqli_select_db($conexao, $database_conexao);
$query_master = sprintf("SELECT * FROM num_user WHERE rerg = '%s'  AND Nivel = 'm'", $colname_master);
$master = mysqli_query($conexao, $query_master);
$row_master = mysqli_fetch_assoc($master);
$totalRows_master = mysqli_num_rows($master);

$colname_adm = "1";
if (isset($_GET['re'])) {
  $colname_adm = $_GET['re'];
}
mysqli_select_db($conexao, $database_conexao);
$query_adm = sprintf("SELECT * FROM num_user WHERE rerg = '%s'  AND Nivel = '1'", $colname_adm);
$adm = mysqli_query($conexao, $query_adm);
$row_adm = mysqli_fetch_assoc($adm);
$totalRows_adm = mysqli_num_rows($adm);

$colname_userc = "1";
if (isset($_GET['re'])) {
  $colname_userc = $_GET['re'];
}
mysqli_select_db($conexao, $database_conexao);
$query_userc = sprintf("SELECT * FROM num_user WHERE rerg = '%s'  AND Nivel = '2'", $colname_userc);
$userc = mysqli_query($conexao, $query_userc);
$row_userc = mysqli_fetch_assoc($userc);
$totalRows_userc = mysqli_num_rows($userc);

$colname_visita = "1";
if (isset($_GET['re'])) {
  $colname_visita = $_GET['re'];
}
mysqli_select_db($conexao, $database_conexao);
$query_visita = sprintf("SELECT * FROM num_user WHERE rerg = '%s'  AND Nivel = '3'", $colname_visita);
$visita = mysqli_query($conexao, $query_visita);
$row_visita = mysqli_fetch_assoc($visita);
$totalRows_visita = mysqli_num_rows($visita);

$colname_opm = "1";
if (isset($_GET['org_Unidade'])) {
  $colname_opm = $_GET['org_Unidade'];
}
mysqli_select_db($conexao, $database_conexao);
$query_opm = sprintf("SELECT num_org.org_id     , num_org.org_Unidade     , num_opm.opm_prefixo     , num_opm.opm_descricao     , num_org.org_CodSecao     , num_org.org_desc FROM numerador_db.num_org     INNER JOIN numerador_db.num_opm          ON (num_org.org_Unidade = num_opm.opm_codigo) WHERE (num_org.org_Unidade LIKE '%s%%')", $colname_opm);
$opm = mysqli_query($conexao, $query_opm);
$row_opm = mysqli_fetch_assoc($opm);
$totalRows_opm = mysqli_num_rows($opm);

$colname_cmt = "1";
if (isset($_GET['re'])) {
  $colname_cmt = $_GET['re'];
}
mysqli_select_db($conexao, $database_conexao);
$query_cmt = sprintf("SELECT * FROM num_user WHERE rerg = '%s'  AND Nivel = 'c'", $colname_cmt);
$cmt = mysqli_query($conexao, $query_cmt);
$row_cmt = mysqli_fetch_assoc($cmt);
$totalRows_cmt = mysqli_num_rows($cmt);
?>
<html>
<head>
<title>WEb CPI-2</title>
<link  href="css/Geral.css" rel="stylesheet" type="text/css">

<link  href="../css/Geral.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body,td,th {
	color: #900;
}
-->
</style></head>

<style> 
body { overflow:hidden } 
</style>
<body>
<table width="100%" border="0" align="center">
  
  
  <tr bgcolor="#E8E8E8"> 
    <td width="100%"> <div align="center"><font color="#CC6600"><strong><font color="#330099" size="3"><?php echo $row_user['postfunc']; ?></font></strong> <font color="#330099" size="3"><strong><?php echo $row_user['guerra']; ?> </strong></font><font size="3"><font color="#000099"><strong>seja 
        bem vindo ao numerador do&nbsp;<?php echo $row_user['org_descUnid']; ?> da se&ccedil;&atilde;o&nbsp;</strong></font></font><font color="#330099" size="3"><strong><?php echo $row_user['org_desc']; ?></strong></font></font><font color="#000099" size="4"><strong><br>
        </strong></font></div></td>
  </tr>
</table>


<?php if ($totalRows_master > 0) { // Show if recordset not empty ?>
<!-- MASTER NÍVEL m -->
<table width="100%" border="0" align="center">
  <tr bgcolor="#FFFFFF"> 
    <td width="14%"><div align="center"><strong><span class="Style6"> <a href="../admsist/listasecao.php" target="numerador">CADASTRO 
        DE SEÇÃO</a> </span></strong></div></td>
    <td> <div align="center"><strong><a href="../admsist/listauser.php?rerg=%"target="numerador">CADASTRO 
        USU&Aacute;RIOS </a></strong></div>
      <div align="center"></div></td>
    <td width="17%"><div align="center"><strong><a href="../admsist/listdoc.php" target="numerador" >CADASTRO 
        TIPO DOC</a></strong></div></td>
    <td width="15%"> <div align="center"></div></td>
    <td width="10%"> <div align="center"></div></td>
    <td width="9%"> <div align="center"></div></td>
    <td width="8%"><div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
  </tr>
</table>
<?php } // Show if recordset not empty ?>
<!-- ADMINISTRADOR NÍVEL 1 -->
<?php if ($totalRows_adm > 0) { // Show if recordset not empty ?>
<table width="100%" border="0" align="center">
  <tr bgcolor="#FFFFFF"> 
    <td width="15%"><div align="center"><strong><span class="Style6"><a href="../numerador/atualizarorg.php?org_id=<?php echo $row_user['Org_id']; ?>" target="numerador">INFORMA&Ccedil;&Atilde;O 
        DA SE&Ccedil;&Atilde;O</a></span></strong></div></td>
    <td width="9%"> <div align="center"><strong><a href="../numerador/listauser.php?rerg=%&org_id=<?php echo $row_user['Org_id']; ?>"target="numerador">USU&Aacute;RIOS</a></strong></div></td>
    <td width="21%"> <div align="center"><strong><a href="../numerador/listaudoctipo.php?Cod_Org=<?php echo $row_user['Org_id']; ?>&re=<?php echo $row_user['rerg']; ?>"target="numerador">ABERTURA 
        DE NOVO NUMERADOR</a></strong></div>
      <div align="center"></div></td>
    <td width="18%"> <div align="center"><strong><a href="../numerador/listaudocgerar.php?Cod_Org=<?php echo $row_user['Org_id']; ?>&re=<?php echo $row_user['rerg']; ?>"target="numerador">GERAR 
        NOVO NUMERO</a></strong></div></td>
    <td width="18%"> <div align="center"><strong><a href="../numerador/consultageraradm.php?Cod_Org=<?php echo $row_user['Org_id']; ?>&re=<?php echo $row_user['rerg']; ?>"target="numerador">CONSULTAR 
        / ATUALIZAR</a></strong></div></td>
    <td width="10%"><div align="center"><strong><a href="../numerador/pagina.php?org_id=<?php echo $row_user['Org_id']; ?>" target="numerador">PEND&Eacute;NCIAS</a></strong></div></td>
    <td width="9%"><div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
  </tr>
</table>
<?php } // Show if recordset not empty ?>
<!-- USUÁRIO COMUM NÍVEL 2 -->
<?php if ($totalRows_userc > 0) { // Show if recordset not empty ?>
<table width="100%" border="0" align="center">
  <tr bgcolor="#FFFFFF"> 
    <td width="14%"><div align="center"><strong><span class="Style6"> <a href="../numerador/org.php?org_id=<?php echo $row_user['Org_id']; ?>" target="numerador">INFORMA&Ccedil;&Atilde;O 
        DA SE&Ccedil;&Atilde;O</a></span></strong></div></td>
    <td width="9%"> <div align="center"><strong><a href="../numerador/atualzarsuserseu.php?rerg=<?php echo $row_user['rerg']; ?>&org_id=<?php echo $row_user['Org_id']; ?>"target="numerador">USU&Aacute;RIOS</a></strong></div>
      <div align="center"></div>
      <div align="center"></div></td>
    <td width="33%"> <div align="center"><strong><a href="../numerador/listaudocgerar.php?Cod_Org=<?php echo $row_user['Org_id']; ?>&re=<?php echo $row_user['rerg']; ?>"target="numerador">GERAR 
        NOVO NUMERO</a></strong></div></td>
    <td width="6%"> <div align="center"><strong><a href="../numerador/consultagerar.php?Cod_Org=<?php echo $row_user['Org_id']; ?>&re=<?php echo $row_user['rerg']; ?>"target="numerador">CONSULTAR</a></strong></div></td>
    <td width="7%"><div align="center"><strong><a href="../numerador/pagina.php?org_id=<?php echo $row_user['Org_id']; ?>" target="numerador">PEND&Eacute;NCIAS</a></strong></div></td>
    <td width="6%"><div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
  </tr>
</table>
<!-- CMT NÍVEL c -->
<?php } // Show if recordset not empty ?>
<form name="form1" method="get" action="../numerador/consultagerar.php" target="numerador">
  <?php if ($totalRows_cmt > 0) { // Show if recordset not empty ?>
  <input type="hidden" name="re" value="<?php echo $_GET['re']; ?>"></input>
  <table width="100%" border="0" align="center">
    <tr bgcolor="#FFFFFF"> 
      <td width="30%"> <div align="center"></div>
        <div align="center"><strong><a href="../numerador/atualzarsuserseu.php?rerg=<?php echo $row_user['rerg']; ?>&org_id=<?php echo $row_user['Org_id']; ?>"target="numerador">USU&Aacute;RIOS</a></strong></div>
        <div align="center"></div>
        <div align="center"></div></td>
      <td width="51%"> <div align="center"><strong>Selecione a se&ccedil;&atilde;o 
          <select name="Cod_Org" id="Cod_Org">
            <option value="">Selecione</option>
            <?php
do {  
?>
            <option value="<?php echo $row_opm['org_id']?>"><?php echo $row_opm['org_desc']; ?></option>
            <?php
} while ($row_opm = mysqli_fetch_assoc($opm));
  $rows = mysqli_num_rows($opm);
  if($rows > 0) {
      mysqli_data_seek($opm, 0);
	  $row_opm = mysqli_fetch_assoc($opm);
  }
?>
          </select>
          &nbsp;&nbsp; 
          <input type="submit" name="Submit" value="CONSULTAR">
          </strong></div></td>
      <td> <div align="center"></div>
        <div align="center"></div>
        <div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
</form>
<!-- VISITANTE NÍVEL 3 -->
<?php if ($totalRows_visita > 0) { // Show if recordset not empty ?>
<table width="100%" border="0" align="center">
  <tr bgcolor="#FFFFFF"> 
    <td width="21%"><div align="center"><strong><span class="Style6"><a href="../numerador/org.php?org_id=<?php echo $row_user['Org_id']; ?>" target="numerador">INFORMA&Ccedil;&Atilde;O 
        DA SE&Ccedil;&Atilde;O</a></span></strong></div></td>
    <td width="39%"> <div align="center"><strong><a href="../numerador/atualzarsuserseu.php?rerg=<?php echo $row_user['rerg']; ?>&org_id=<?php echo $row_user['Org_id']; ?>"target="numerador">USU&Aacute;RIOS</a></strong></div>
      <div align="center"></div>
      <div align="center"></div>
      <div align="center"></div></td>
    <td width="34%"> <div align="center"><strong><a href="../numerador/consultagerar.php?Cod_Org=<?php echo $row_user['Org_id']; ?>&re=<?php echo $row_user['rerg']; ?>"target="numerador">CONSULTAR</a></strong></div></td>
    <td width="6%"><div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
  </tr>
</table>
<?php } // Show if recordset not empty ?>
<iframe  src="../numerador/pagina.php?org_id=<?php echo $row_user['Org_id']; ?>" name="numerador" width="100%" height="480" scrolling="auto" frameborder="no"  allowtransparency="true" ></iframe>
</body>
</html>
<?php
mysqli_free_result($user);

mysqli_free_result($master);

mysqli_free_result($adm);

mysqli_free_result($userc);

mysqli_free_result($visita);

mysqli_free_result($opm);

mysqli_free_result($cmt);
?>
