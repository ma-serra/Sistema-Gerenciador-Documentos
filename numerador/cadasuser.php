<?php
// 1. INICIALIZAÇÃO E CONEXÃO
// =============================
// Inclui o arquivo de conexão que agora contém a função GetSQLValueString.
require_once('../Connections/conexao.php');

// Define a ação do formulário para o próprio arquivo.
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

// 2. LÓGICA DE INSERÇÃO DE DADOS
// =============================
// Verifica se o formulário foi submetido via POST.
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  
  // Correção CRÍTICA: As colunas no banco de dados são 'org_id' e 'nivel_id'.
  // O uso de 'Org_id' e 'Nivel' com maiúsculas causaria erro.
  $insertSQL = sprintf("INSERT INTO num_user (rerg, postfunc, guerra, senha, org_id, nivel_id, situacao) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($conexao, $_POST['rerg'], "text"),
                       GetSQLValueString($conexao, $_POST['postfunc'], "text"),
                       GetSQLValueString($conexao, $_POST['guerra'], "text"),
                       GetSQLValueString($conexao, md5($_POST['senha']), "text"),
                       GetSQLValueString($conexao, $_POST['org_id'], "int"),
                       GetSQLValueString($conexao, $_POST['Nivel'], "int"),
                       GetSQLValueString($conexao, $_POST['situacao'], "text"));

  $Result1 = mysqli_query($conexao, $insertSQL);

  if ($Result1) {
    // Redireciona para a página de sucesso.
    $insertGoTo = "acaookuser.php";
    if (isset($_SERVER['QUERY_STRING'])) {
      $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
      $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
    exit();
  } else {
    die("Erro ao inserir o usuário: " . mysqli_error($conexao));
  }
}

// 3. CONSULTAS PARA PREENCHER OS MENUS <select>
// ===============================================
// Busca a lista de Postos/Graduações.
$query_posto = "SELECT * FROM sai_posto ORDER BY cod_posto ASC";
$posto_result = mysqli_query($conexao, $query_posto);
$row_posto = mysqli_fetch_assoc($posto_result);
$totalRows_posto = mysqli_num_rows($posto_result);

// Busca a Organização (Seção) específica passada pela URL.
$colname_org = "-1";
if (isset($_GET['org_id'])) {
  $colname_org = $_GET['org_id'];
}
$query_org = sprintf("SELECT * FROM num_org WHERE org_id = %s", GetSQLValueString($conexao, $colname_org, "int"));
$org_result = mysqli_query($conexao, $query_org);
$row_org = mysqli_fetch_assoc($org_result);
$totalRows_org = mysqli_num_rows($org_result);

// Busca os Níveis de acesso, excluindo Master e CMT.
$query_nivel = "SELECT * FROM num_nivel WHERE cod_nivel NOT IN ('m', 'c') ORDER BY nivel_id ASC";
$nivel_result = mysqli_query($conexao, $query_nivel);
$row_nivel = mysqli_fetch_assoc($nivel_result);
$totalRows_nivel = mysqli_num_rows($nivel_result);
?>
<html>
<head>
<title>Numerador - Cadastro de Usuário</title>
<link href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table align="center" bgcolor="#E6E6E6">
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="2" align="right" nowrap> 
        <div align="center"><font color="#000099" size="3">CADASTRO DE USUÁRIO</font></div>
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">RE:</td>
      <td><input type="text" name="rerg" value="" size="9"> <font color="#990000">Obs: sem dígito</font></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">POSTO / FUNÇÃO:</td>
      <td> 
        <select name="postfunc" id="postfunc">
          <option value="">Selecionar...</option>
          <?php
          if ($totalRows_posto > 0) {
            mysqli_data_seek($posto_result, 0);
            while($row_posto_loop = mysqli_fetch_assoc($posto_result)) {
          ?>
          <option value="<?php echo htmlspecialchars($row_posto_loop['Posto']); ?>"><?php echo htmlspecialchars($row_posto_loop['Posto']); ?></option>
          <?php
            }
          }
          ?>
        </select>
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">NOME DE GUERRA:</td>
      <td><input type="text" name="guerra" value="" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">SEÇÃO:</td>
      <td> 
        <select name="org_id" id="org_id">
          <?php
          if ($totalRows_org > 0) {
            mysqli_data_seek($org_result, 0);
            while($row_org_loop = mysqli_fetch_assoc($org_result)) {
          ?>
          <option value="<?php echo $row_org_loop['org_id']; ?>" selected>
            <?php echo htmlspecialchars($row_org_loop['org_desc']); ?> <?php echo htmlspecialchars($row_org_loop['org_descUnid']); ?>
          </option>
          <?php
            }
          }
          ?>
        </select> 
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">NÍVEL DE ACESSO:</td>
      <td> 
        <select name="Nivel" id="Nivel">
          <option value="">Selecione...</option>
          <?php
          if ($totalRows_nivel > 0) {
            mysqli_data_seek($nivel_result, 0);
            while($row_nivel_loop = mysqli_fetch_assoc($nivel_result)) {
          ?>
            <option value="<?php echo $row_nivel_loop['nivel_id']; ?>"><?php echo htmlspecialchars($row_nivel_loop['desc_nivel']); ?></option>
          <?php
            }
          }
          ?>
        </select> 
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">FUNÇÃO:</td>
      <td><input type="text" name="situacao" value="ATIVO" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="2" align="right" nowrap bgcolor="#CCCCCC"> 
        <div align="center"> 
          <input type="submit" value="INSERIR REGISTRO">
          <input type="hidden" name="senha" value="senhas">
        </div>
      </td>
    </tr>
  </table>
  
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
// 4. LIBERAÇÃO DE MEMÓRIA
// =======================
mysqli_free_result($posto_result);
mysqli_free_result($org_result);
mysqli_free_result($nivel_result);
?>