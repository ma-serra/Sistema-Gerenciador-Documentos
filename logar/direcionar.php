<?php
// Incluindo a conexão e a função de segurança centralizada.
require_once('../Connections/conexao.php'); 
// O 'restrito.php' garante que apenas usuários logados acessem e já inicia a sessão.
require_once('restrito.php'); 

// 1. VALIDAÇÃO DE ENTRADA
// =========================
if (!isset($_GET['re'])) {
    die("Erro: Parâmetro de usuário 're' não foi encontrado na URL.");
}
$colname_user = $_GET['re'];

// 2. CONSULTA PRINCIPAL DE DADOS DO USUÁRIO
// ===========================================
$query_user = sprintf("SELECT u.rerg, u.postfunc, u.guerra, u.senha, u.org_id, u.nivel_id, o.org_desc_unid, o.org_cod_secao, o.org_desc 
                       FROM num_user u 
                       INNER JOIN num_org o ON u.org_id = o.org_id 
                       WHERE u.rerg = %s", GetSQLValueString($conexao, $colname_user, "text"));

$user_result = mysqli_query($conexao, $query_user);

if (!$user_result) {
    die("Erro fatal na consulta de usuário: " . mysqli_error($conexao));
}

$row_user = mysqli_fetch_assoc($user_result);
$totalRows_user = mysqli_num_rows($user_result);

if ($totalRows_user == 0) {
    die("Usuário com o RE informado não foi encontrado no sistema.");
}

$user_level = $row_user['nivel_id'];

// 3. CONSULTA PARA O MENU ESPECÍFICO DE CMT (SE APLICÁVEL)
// =========================================================
$totalRows_opm = 0;
$opm_result = null; 
if ($user_level == 5) { // Nível 5 = CMT
    $colname_opm = isset($_GET['org_unidade']) ? $_GET['org_unidade'] : '';
    if (!empty($colname_opm)) {
        // *** AQUI ESTÁ A CORREÇÃO ***
        // A consulta agora busca pelo prefixo da OPM, como deveria ser.
        $query_opm = sprintf("SELECT o.org_id, o.org_unidade, opm.opm_prefixo, opm.opm_descricao, o.org_cod_secao, o.org_desc 
                              FROM num_org o
                              INNER JOIN num_opm opm ON o.org_unidade = opm.opm_codigo 
                              WHERE opm.opm_prefixo = %s", GetSQLValueString($conexao, $colname_opm, "text"));
        $opm_result = mysqli_query($conexao, $query_opm);
        if ($opm_result) {
            $totalRows_opm = mysqli_num_rows($opm_result);
        }
    }
}
?>
<html>
<head>
<title>WEB CPI-2</title>
<link rel="icon" href="../gifs/numerador.png" type="image/png">
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
          <strong><font color="#330099" size="3"><?php echo htmlspecialchars($row_user['postfunc'] ?? ''); ?></font></strong> 
          <font color="#330099" size="3"><strong><?php echo htmlspecialchars($row_user['guerra'] ?? ''); ?></strong></font>
          <font size="3"><font color="#000099"><strong> seja bem vindo ao numerador do&nbsp;<?php echo htmlspecialchars($row_user['org_desc_unid'] ?? ''); ?> da seção&nbsp;</strong></font></font>
          <font color="#330099" size="3"><strong><?php echo htmlspecialchars($row_user['org_desc'] ?? ''); ?></strong></font>
        </font>
        <font color="#000099" size="4"><strong><br></strong></font>
      </div>
    </td>
  </tr>
</table>

<?php // 4. RENDERIZAÇÃO DOS MENUS DE ACORDO COM O NÍVEL DO USUÁRIO ?>
<?php // ========================================================= ?>

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
    <td width="15%"><div align="center"><strong><a href="../numerador/org.php?org_id=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>" target="numerador">INFORMAÇÃO DA SEÇÃO</a></strong></div></td>
    <td width="9%"> <div align="center"><strong><a href="../numerador/listauser.php?rerg=%&org_id=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>" target="numerador">USUÁRIOS</a></strong></div></td>
    <td width="21%"><div align="center"><strong><a href="../numerador/listaudoctipo.php?cod_org=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>&re=<?php echo htmlspecialchars($row_user['rerg'] ?? ''); ?>" target="numerador">ABERTURA DE NOVO NUMERADOR</a></strong></div></td>
    <td width="18%"><div align="center"><strong><a href="../numerador/listaudocgerar.php?cod_org=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>&re=<?php echo htmlspecialchars($row_user['rerg'] ?? ''); ?>" target="numerador">GERAR NOVO NÚMERO</a></strong></div></td>
    <td width="18%"><div align="center"><strong><a href="../numerador/consultageraradm.php?cod_org=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>&re=<?php echo htmlspecialchars($row_user['rerg'] ?? ''); ?>" target="numerador">CONSULTAR / ATUALIZAR</a></strong></div></td>
    <td width="10%"><div align="center"><strong><a href="../numerador/pagina.php?org_id=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>" target="numerador">PENDÊNCIAS</a></strong></div></td>
    <td width="9%"><div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
  </tr>
</table>

<?php // NÍVEL USUÁRIO COMUM (ID 2)
elseif ($user_level == 2): ?>
<table width="100%" border="0" align="center">
  <tr bgcolor="#FFFFFF"> 
    <td width="14%"><div align="center"><strong><a href="../numerador/org.php?org_id=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>" target="numerador">INFORMAÇÃO DA SEÇÃO</a></strong></div></td>
    <td width="9%"> <div align="center"><strong><a href="../numerador/atualizarseuuser.php?rerg=<?php echo htmlspecialchars($row_user['rerg'] ?? ''); ?>&org_id=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>" target="numerador">MEU USUÁRIO</a></strong></div></td>
    <td width="33%"><div align="center"><strong><a href="../numerador/listaudocgerar.php?cod_org=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>&re=<?php echo htmlspecialchars($row_user['rerg'] ?? ''); ?>" target="numerador">GERAR NOVO NÚMERO</a></strong></div></td>
    <td width="6%"> <div align="center"><strong><a href="../numerador/consultagerar.php?cod_org=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>&re=<?php echo htmlspecialchars($row_user['rerg'] ?? ''); ?>" target="numerador">CONSULTAR</a></strong></div></td>
    <td width="7%"><div align="center"><strong><a href="../numerador/pagina.php?org_id=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>" target="numerador">PENDÊNCIAS</a></strong></div></td>
    <td width="6%"><div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
  </tr>
</table>

<?php // NÍVEL CMT (ID 5)
elseif ($user_level == 5 && $totalRows_opm > 0): ?>
<form name="form1" method="get" action="../numerador/consultagerar.php" target="numerador">
  <input type="hidden" name="re" value="<?php echo htmlspecialchars($_GET['re'] ?? ''); ?>">
  <table width="100%" border="0" align="center">
    <tr bgcolor="#FFFFFF"> 
      <td width="30%"><div align="center"><strong><a href="../numerador/atualizarseuuser.php?rerg=<?php echo htmlspecialchars($row_user['rerg'] ?? ''); ?>&org_id=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>" target="numerador">MEU USUÁRIO</a></strong></div></td>
      <td width="51%"> 
        <div align="center"><strong>Selecione a seção 
          <select name="cod_org" id="cod_org">
            <option value="">Selecione</option>
            <?php
            // O loop para popular o select de OPMs.
            mysqli_data_seek($opm_result, 0); // Garante que o ponteiro está no início.
            while($row_opm_loop = mysqli_fetch_assoc($opm_result)) {  
            ?>
            <option value="<?php echo $row_opm_loop['org_id']?>"><?php echo htmlspecialchars($row_opm_loop['org_desc'] ?? ''); ?></option>
            <?php
            }
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
    <td width="21%"><div align="center"><strong><a href="../numerador/org.php?org_id=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>" target="numerador">INFORMAÇÃO DA SEÇÃO</a></strong></div></td>
    <td width="39%"><div align="center"><strong><a href="../numerador/atualzarsuserseu.php?rerg=<?php echo htmlspecialchars($row_user['rerg'] ?? ''); ?>&org_id=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>" target="numerador">MEU USUÁRIO</a></strong></div></td>
    <td width="34%"><div align="center"><strong><a href="../numerador/consultagerar.php?cod_org=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>&re=<?php echo htmlspecialchars($row_user['rerg'] ?? ''); ?>" target="numerador">CONSULTAR</a></strong></div></td>
    <td width="6%"><div align="center"><strong><a href="../Sair.php">SAIR</a></strong></div></td>
  </tr>
</table>
<?php endif; ?>

<iframe src="../numerador/pagina.php?org_id=<?php echo htmlspecialchars($row_user['org_id'] ?? ''); ?>" name="numerador" width="100%" height="480" scrolling="auto" frameborder="no" allowtransparency="true"></iframe>

</body>
</html>
<?php
// 5. LIBERAÇÃO DE MEMÓRIA
// ==========================
if($user_result) mysqli_free_result($user_result);
if (isset($opm_result) && $opm_result) { mysqli_free_result($opm_result); }
?>