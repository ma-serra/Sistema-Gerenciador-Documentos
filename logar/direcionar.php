<?php
require_once('../Connections/conexao.php');
require_once('restrito.php'); // Unificado o include de restrição

// Função para evitar injeção de SQL
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  // Sua função GetSQLValueString aqui... (Opcional, mas recomendado para segurança)
  // Por simplicidade, usaremos a forma direta com verificação
  if ($theValue === "") {
    return "NULL";
  }
  global $conexao; // Garante que a conexão esteja no escopo
  $theValue = mysqli_real_escape_string($conexao, $theValue);
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    // ... resto dos cases
  }
  return $theValue;
}


// Verificação de segurança: Garante que 're' foi passado na URL
if (!isset($_GET['re'])) {
    die("Erro: Parâmetro 're' não encontrado.");
}
$colname_user = $_GET['re'];

// --- Consulta principal para obter dados do usuário logado (COM NOMES CORRIGIDOS) ---
mysqli_select_db($conexao, $database_conexao);
$query_user = sprintf("SELECT u.rerg, u.postfunc, u.guerra, u.senha, u.org_id, u.nivel_id, o.org_desc_unid, o.org_cod_secao, o.org_desc 
                       FROM num_user u 
                       INNER JOIN num_org o ON u.org_id = o.org_id 
                       WHERE u.rerg = %s", GetSQLValueString($colname_user, "text"));
$user = mysqli_query($conexao, $query_user);

if (!$user) {
    die("Erro na consulta SQL: " . mysqli_error($conexao));
}

$row_user = mysqli_fetch_assoc($user);
$totalRows_user = mysqli_num_rows($user);

// Se o usuário não for encontrado, interrompe a execução
if ($totalRows_user == 0) {
    die("Usuário não encontrado.");
}

// --- Pega o nível do usuário (COM NOME CORRIGIDO) ---
$user_level = $row_user['nivel_id'];

// --- Consulta para o menu de CMT (se aplicável) ---
$totalRows_opm = 0;
if ($user_level == 5) { // Nível CMT
    $colname_opm = isset($_GET['org_unidade']) ? $_GET['org_unidade'] : '';
    if (!empty($colname_opm)) {
        $query_opm = sprintf("SELECT o.org_id, o.org_unidade, opm.opm_prefixo, opm.opm_descricao, o.org_cod_secao, o.org_desc 
                              FROM num_org o
                              INNER JOIN num_opm opm ON o.org_unidade = opm.opm_codigo 
                              WHERE o.org_unidade LIKE %s", GetSQLValueString($colname_opm . '%', "text"));
        $opm = mysqli_query($conexao, $query_opm);
        $row_opm = mysqli_fetch_assoc($opm);
        $totalRows_opm = mysqli_num_rows($opm);
    }
}
?>
<html>
<head>
<title>WEB CPI-2</title>
<link href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body, td, th {
    color: #900;
}
body { 
    overflow: hidden; 
} 
</style>
</head>

<body>
<table width="100%" border="0" align="center">
  <tr bgcolor="#E8E8E8"> 
    <td width="100%"> 
      <div align="center">
        <font color="#CC6600">
          <strong><font color="#330099" size="3"><?php echo htmlspecialchars($row_user['postfunc']); ?></font></strong> 
          <font color="#330099" size="3"><strong><?php echo htmlspecialchars($row_user['guerra']); ?></strong></font>
          <font size="3"><font color="#000099"><strong> seja bem vindo ao numerador do&nbsp;<?php echo htmlspecialchars($row_user['org_desc_unid']); ?> da seção&nbsp;</strong></font></font>
          <font color="#330099" size="3"><strong><?php echo htmlspecialchars($row_user['org_desc']); ?></strong></font>
        </font>
        <font color="#000099" size="4"><strong><br></strong></font>
      </div>
    </td>
  </tr>
</table>

<?php // NÍVEL MASTER (ID 4)
if ($user_level == 4): ?>
<table width="100%" border="0" align="center">
  <tr bgcolor="#FFFFFF"> 
    <td width="14%"><div align="center"><strong><a href="../admsist/listasecao.php" target="numerador">CADASTRO DE SEÇÃO</a></strong></div></td>
    <td><div align="center"><strong><a href="../admsist/listauser.php?rerg=%" target="numerador">CADASTRO USUÁRIOS</a></strong></div></td>
    <td width="17%"><div align="center"><strong><a href="../admsist/listdoc.php" target="numerador">CADASTRO TIPO DOC</a></strong></div></td>
    <td width="8%"><div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
  </tr>
</table>

<?php // NÍVEL ADMINISTRADOR (ID 1)
elseif ($user_level == 1): ?>
<table width="100%" border="0" align="center">
  <tr bgcolor="#FFFFFF"> 
    <td width="15%"><div align="center"><strong><a href="../numerador/atualizarorg.php?org_id=<?php echo $row_user['org_id']; ?>" target="numerador">INFORMAÇÃO DA SEÇÃO</a></strong></div></td>
    <td width="9%"> <div align="center"><strong><a href="../numerador/listauser.php?rerg=%&org_id=<?php echo $row_user['org_id']; ?>" target="numerador">USUÁRIOS</a></strong></div></td>
    <td width="21%"><div align="center"><strong><a href="../numerador/listaudoctipo.php?cod_org=<?php echo $row_user['org_id']; ?>&re=<?php echo $row_user['rerg']; ?>" target="numerador">ABERTURA DE NOVO NUMERADOR</a></strong></div></td>
    <td width="18%"><div align="center"><strong><a href="../numerador/listaudocgerar.php?cod_org=<?php echo $row_user['org_id']; ?>&re=<?php echo $row_user['rerg']; ?>" target="numerador">GERAR NOVO NÚMERO</a></strong></div></td>
    <td width="18%"><div align="center"><strong><a href="../numerador/consultageraradm.php?cod_org=<?php echo $row_user['org_id']; ?>&re=<?php echo $row_user['rerg']; ?>" target="numerador">CONSULTAR / ATUALIZAR</a></strong></div></td>
    <td width="10%"><div align="center"><strong><a href="../numerador/pagina.php?org_id=<?php echo $row_user['org_id']; ?>" target="numerador">PENDÊNCIAS</a></strong></div></td>
    <td width="9%"><div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
  </tr>
</table>

<?php // NÍVEL USUÁRIO COMUM (ID 2)
elseif ($user_level == 2): ?>
<table width="100%" border="0" align="center">
  <tr bgcolor="#FFFFFF"> 
    <td width="14%"><div align="center"><strong><a href="../numerador/org.php?org_id=<?php echo $row_user['org_id']; ?>" target="numerador">INFORMAÇÃO DA SEÇÃO</a></strong></div></td>
    <td width="9%"> <div align="center"><strong><a href="../numerador/atualzarsuserseu.php?rerg=<?php echo $row_user['rerg']; ?>&org_id=<?php echo $row_user['org_id']; ?>" target="numerador">MEU USUÁRIO</a></strong></div></td>
    <td width="33%"><div align="center"><strong><a href="../numerador/listaudocgerar.php?cod_org=<?php echo $row_user['org_id']; ?>&re=<?php echo $row_user['rerg']; ?>" target="numerador">GERAR NOVO NÚMERO</a></strong></div></td>
    <td width="6%"> <div align="center"><strong><a href="../numerador/consultagerar.php?cod_org=<?php echo $row_user['org_id']; ?>&re=<?php echo $row_user['rerg']; ?>" target="numerador">CONSULTAR</a></strong></div></td>
    <td width="7%"><div align="center"><strong><a href="../numerador/pagina.php?org_id=<?php echo $row_user['org_id']; ?>" target="numerador">PENDÊNCIAS</a></strong></div></td>
    <td width="6%"><div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
  </tr>
</table>

<?php // NÍVEL CMT (ID 5)
elseif ($user_level == 5 && $totalRows_opm > 0): ?>
<form name="form1" method="get" action="../numerador/consultagerar.php" target="numerador">
  <input type="hidden" name="re" value="<?php echo htmlspecialchars($_GET['re']); ?>">
  <table width="100%" border="0" align="center">
    <tr bgcolor="#FFFFFF"> 
      <td width="30%"><div align="center"><strong><a href="../numerador/atualzarsuserseu.php?rerg=<?php echo $row_user['rerg']; ?>&org_id=<?php echo $row_user['org_id']; ?>" target="numerador">MEU USUÁRIO</a></strong></div></td>
      <td width="51%"> 
        <div align="center"><strong>Selecione a seção 
          <select name="cod_org" id="cod_org">
            <option value="">Selecione</option>
            <?php
            do {  
            ?>
            <option value="<?php echo $row_opm['org_id']?>"><?php echo htmlspecialchars($row_opm['org_desc']); ?></option>
            <?php
            } while ($row_opm = mysqli_fetch_assoc($opm));
            ?>
          </select>
          &nbsp;&nbsp; 
          <input type="submit" name="Submit" value="CONSULTAR">
        </strong></div>
      </td>
      <td><div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
    </tr>
  </table>
</form>

<?php // NÍVEL VISITANTE (ID 3)
elseif ($user_level == 3): ?>
<table width="100%" border="0" align="center">
  <tr bgcolor="#FFFFFF"> 
    <td width="21%"><div align="center"><strong><a href="../numerador/org.php?org_id=<?php echo $row_user['org_id']; ?>" target="numerador">INFORMAÇÃO DA SEÇÃO</a></strong></div></td>
    <td width="39%"><div align="center"><strong><a href="../numerador/atualzarsuserseu.php?rerg=<?php echo $row_user['rerg']; ?>&org_id=<?php echo $row_user['org_id']; ?>" target="numerador">MEU USUÁRIO</a></strong></div></td>
    <td width="34%"><div align="center"><strong><a href="../numerador/consultagerar.php?cod_org=<?php echo $row_user['org_id']; ?>&re=<?php echo $row_user['rerg']; ?>" target="numerador">CONSULTAR</a></strong></div></td>
    <td width="6%"><div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
  </tr>
</table>
<?php endif; ?>

<iframe src="../numerador/pagina.php?org_id=<?php echo $row_user['org_id']; ?>" name="numerador" width="100%" height="480" scrolling="auto" frameborder="no" allowtransparency="true"></iframe>

</body>
</html>
<?php
// Liberar resultados da memória
mysqli_free_result($user);
if (isset($opm)) { mysqli_free_result($opm); }
?>