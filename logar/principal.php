<?php 
require_once('../Connections/conexao.php'); 
include("restrito.php");

$colname_user = $_SESSION['login'];

// CORREÇÃO: Atualizar nomes das colunas na query
$query_user = sprintf("SELECT rerg, org_id FROM num_user WHERE rerg = %s", GetSQLValueString($colname_user, "text"));
$user = mysqli_query($conexao, $query_user);
$row_user = mysqli_fetch_assoc($user);

// CORREÇÃO: Atualizar nomes das colunas na query OPM
$query_opm = sprintf("SELECT opm.opm_prefixo 
                      FROM num_org o 
                      INNER JOIN num_opm opm ON o.org_unidade = opm.opm_codigo
                      INNER JOIN num_user u ON u.org_id = o.org_id
                      WHERE u.rerg = %s", GetSQLValueString($colname_user, "text"));
$opm = mysqli_query($conexao, $query_opm);
$row_opm = mysqli_fetch_assoc($opm);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Carregando...</title>
</head>
<body>
<div align="center">
  <p><font size="4">CARREGANDO</font><br />
    <img src="../gifs/carregando.gif" width="400" height="125" align="absmiddle" /> 
  </p>
  <p>
    <script language="JavaScript" type="text/javascript">
           		location.href="direcionar.php?re=<?php echo $row_user['rerg']; ?>&org_id=<?php echo $row_user['org_id']; ?>&org_unidade=<?php echo $row_opm['opm_prefixo']; ?>"
	</script>
  </p>
</div>
</body>
</html>
<?php
mysqli_free_result($user);
mysqli_free_result($opm);
?>