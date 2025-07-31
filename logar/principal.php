<?php 
require_once('../Connections/conexao.php'); 
require_once('restrito.php'); // O restrito.php já inicia a sessão

$colname_user = $_SESSION['login'];

// Usando a função de segurança e pegando o org_id do usuário logado
$query_user = sprintf("SELECT rerg, org_id FROM num_user WHERE rerg = %s", GetSQLValueString($conexao, $colname_user, "text"));
$user_result = mysqli_query($conexao, $query_user);
$row_user = mysqli_fetch_assoc($user_result);

// Consulta para obter o prefixo da OPM
// Correção: A coluna que liga num_user com num_org é a `org_id`
$query_opm = sprintf("SELECT opm.opm_prefixo 
                      FROM num_org o 
                      INNER JOIN num_opm opm ON o.org_unidade = opm.opm_codigo
                      WHERE o.org_id = %s", GetSQLValueString($conexao, $row_user['org_id'], "int"));
$opm_result = mysqli_query($conexao, $query_opm);
$row_opm = mysqli_fetch_assoc($opm_result);

// Libera memória
mysqli_free_result($user_result);
mysqli_free_result($opm_result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Carregando...</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
</head>
<body>
<div align="center">
  <p><font size="4">CARREGANDO</font><br />
    <img src="/numerador/public/gifs/carregando.gif" width="400" height="125" align="absmiddle" /> 
  </p>
  <p>
    <script language="JavaScript" type="text/javascript">
        // Redireciona para a página que monta o menu do usuário
        location.href="direcionar.php?re=<?php echo $row_user['rerg']; ?>&org_id=<?php echo $row_user['org_id']; ?>&org_unidade=<?php echo isset($row_opm['opm_prefixo']) ? $row_opm['opm_prefixo'] : ''; ?>"
	</script>
  </p>
</div>
</body>
</html>