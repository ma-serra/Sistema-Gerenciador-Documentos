<?php 
require_once('../Connections/conexao.php'); 
include("restrito.php");


$colname_user = "1";
if (isset($_SESSION['login'])) {
  $colname_user = $_SESSION['login'];
}

mysqli_select_db($conexao, $database_conexao);
$query_user = sprintf("SELECT * FROM num_user WHERE rerg = '%s'", $colname_user);
$user = mysqli_query($conexao, $query_user);
$row_user = mysqli_fetch_assoc($user);
$totalRows_user = mysqli_num_rows($user);

$colname_opm = "1";
if (isset($_SESSION['login'])) {
    $colname_opm = $_SESSION['login'];
}


mysqli_select_db($conexao, $database_conexao);
$query_opm = sprintf("SELECT     num_org.org_id     , num_org.org_Unidade     , num_opm.opm_prefixo     , num_opm.opm_descricao     , num_org.org_CodSecao     , num_org.org_desc     , num_user.Org_id     , num_user.rerg FROM     numerador_db.num_org     INNER JOIN numerador_db.num_opm          ON (num_org.org_Unidade = num_opm.opm_codigo)     INNER JOIN numerador_db.num_user          ON (num_user.Org_id = num_org.org_id) WHERE (num_user.rerg ='%s');", $colname_opm);
$opm = mysqli_query($conexao, $query_opm);
$row_opm = mysqli_fetch_assoc($opm);
$totalRows_opm = mysqli_num_rows($opm);

$len = !isset($cOTLdata['char_data']) ? 0 : count($cOTLdata['char_data']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Document sans titre</title>
</head>

<body>
<div align="center">
  <p><font size="4">CARREGANDO</font><br />
    <img src="../gifs/carregando.gif" width="400" height="125" align="absmiddle" /> 
    <?php echo $_SESSION['login']; 
    echo $row_user['rerg'];?></p>
  
  <p>
    <script language="JavaScript" type="text/javascript">
           		location.href="direcionar.php?re=<?php echo $row_user['rerg']; ?>&org_id=<?php echo $row_user['Org_id']; ?>&org_Unidade=<?php echo $row_opm['opm_prefixo']; ?>"
	   	 	    </script>
  </p>
</div>
</body>
</html>
<?php
mysqli_free_result($user);

mysqli_free_result($opm);
?>

