<?php
// Incluindo a conexão e a função de segurança centralizada.
require_once('../Connections/conexao.php'); 
// O 'restrito.php' garante que apenas usuários logados acessem e já inicia a sessão.
require_once('restrito.php'); 

// 1. VALIDAÇÃO DE ENTRADA
// =========================
// Garante que o parâmetro 're' (Registro do Empregado) foi passado na URL.
if (!isset($_GET['re'])) {
    // Interrompe a execução com uma mensagem clara se o parâmetro estiver faltando.
    die("Erro: Parâmetro de usuário 're' não foi encontrado na URL.");
}
$colname_user = $_GET['re'];

// 2. CONSULTA PRINCIPAL DE DADOS DO USUÁRIO
// ===========================================
// A consulta usa os nomes de coluna corretos do banco de dados (snake_case), como 'nivel_id' e 'org_id'.
$query_user = sprintf("SELECT u.rerg, u.postfunc, u.guerra, u.senha, u.org_id, u.nivel_id, o.org_desc_unid, o.org_cod_secao, o.org_desc 
                       FROM num_user u 
                       INNER JOIN num_org o ON u.org_id = o.org_id 
                       WHERE u.rerg = %s", GetSQLValueString($conexao, $colname_user, "text")); // Correção: Passando $conexao para a função.

$user_result = mysqli_query($conexao, $query_user);

// Verificação de erro na consulta.
if (!$user_result) {
    die("Erro fatal na consulta de usuário: " . mysqli_error($conexao));
}

$row_user = mysqli_fetch_assoc($user_result);
$totalRows_user = mysqli_num_rows($user_result);

// Se a consulta não retornar nenhum usuário, o script é interrompido.
if ($totalRows_user == 0) {
    die("Usuário com o RE informado não foi encontrado no sistema.");
}

// Armazena o nível do usuário, que definirá qual menu será exibido.
$user_level = $row_user['nivel_id'];

// 3. CONSULTA PARA O MENU ESPECÍFICO DE CMT (SE APLICÁVEL)
// =========================================================
$totalRows_opm = 0;
$opm_result = null; // Inicializa a variável para evitar erros
if ($user_level == 5) { // Nível 5 = CMT
    $colname_opm = isset($_GET['org_unidade']) ? $_GET['org_unidade'] : '';
    if (!empty($colname_opm)) {
        $query_opm = sprintf("SELECT o.org_id, o.org_unidade, opm.opm_prefixo, opm.opm_descricao, o.org_cod_secao, o.org_desc 
                              FROM num_org o
                              INNER JOIN num_opm opm ON o.org_unidade = opm.opm_codigo 
                              WHERE o.org_unidade LIKE %s", GetSQLValueString($conexao, $colname_opm . '%', "text")); // Correção: Passando $conexao
        $opm_result = mysqli_query($conexao, $query_opm);
        $row_opm = mysqli_fetch_assoc($opm_result);
        $totalRows_opm = mysqli_num_rows($opm_result);
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
    
    <td width="15%"><div align="center"><strong><a href="../numerador/org.php?org_id=<?php echo $row_user['org_id']; ?>" target="numerador">INFORMAÇÃO DA SEÇÃO</a></strong></div></td>

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
    <td width="9%"> <div align="center"><strong><a href="../numerador/atualizarseuuser.php?rerg=<?php echo $row_user['rerg']; ?>&org_id=<?php echo $row_user['org_id']; ?>" target="numerador">MEU USUÁRIO</a></strong></div></td>
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
      <td width="30%"><div align="center"><strong><a href="../numerador/atualizarseuuser.php?rerg=<?php echo $row_user['rerg']; ?>&org_id=<?php echo $row_user['org_id']; ?>" target="numerador">MEU USUÁRIO</a></strong></div></td>
      <td width="51%"> 
        <div align="center"><strong>Selecione a seção 
          <select name="cod_org" id="cod_org">
            <option value="">Selecione</option>
            <?php
            // O loop para popular o select de OPMs.
            mysqli_data_seek($opm_result, 0); // Garante que o ponteiro está no início.
            while($row_opm = mysqli_fetch_assoc($opm_result)) {  
            ?>
            <option value="<?php echo $row_opm['org_id']?>"><?php echo htmlspecialchars($row_opm['org_desc']); ?></option>
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
// 5. LIBERAÇÃO DE MEMÓRIA
// ==========================
// Libera os resultados das consultas da memória.
mysqli_free_result($user_result);
if (isset($opm_result)) { mysqli_free_result($opm_result); }
?>