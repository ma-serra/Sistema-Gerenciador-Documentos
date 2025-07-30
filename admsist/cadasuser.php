<?php
// 1. INICIALIZAÇÃO E CONEXÃO
// =============================
// Inclui o arquivo de conexão que também contém a função de segurança GetSQLValueString.
require_once('../Connections/conexao.php');

// Define a ação do formulário para o próprio arquivo.
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

// 2. LÓGICA DE INSERÇÃO DE DADOS
// =============================
// Verifica se o formulário foi submetido.
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  
  // Correção CRÍTICA: As colunas no banco de dados são 'org_id' e 'nivel_id' (em minúsculas).
  // A coluna 'Nivel' com 'N' maiúsculo não existe e causaria um erro de SQL.
  $insertSQL = sprintf("INSERT INTO num_user (rerg, postfunc, guerra, senha, org_id, nivel_id, situacao) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($conexao, $_POST['rerg'], "text"),
                       GetSQLValueString($conexao, $_POST['postfunc'], "text"),
                       GetSQLValueString($conexao, $_POST['guerra'], "text"),
                       GetSQLValueString($conexao, md5($_POST['senha']), "text"),
                       GetSQLValueString($conexao, $_POST['org_id'], "int"),
                       GetSQLValueString($conexao, $_POST['Nivel'], "int"), // O campo do formulário é 'Nivel'
                       GetSQLValueString($conexao, $_POST['situacao'], "text"));

  $Result1 = mysqli_query($conexao, $insertSQL);

  // Se a inserção for bem-sucedida, redireciona para a página de confirmação.
  if ($Result1) {
    $insertGoTo = "acaook.php";
    if (isset($_SERVER['QUERY_STRING'])) {
      $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
      $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
    exit(); // Encerra o script após o redirecionamento.
  } else {
    // Caso contrário, exibe um erro claro.
    die("Erro ao inserir o novo usuário no banco de dados: " . mysqli_error($conexao));
  }
}

// 3. CONSULTAS PARA PREENCHER OS MENUS <select>
// ===============================================
// Busca a lista de Postos/Graduações.
$query_posto = "SELECT * FROM sai_posto ORDER BY cod_posto ASC";
$posto_result = mysqli_query($conexao, $query_posto);
$row_posto = mysqli_fetch_assoc($posto_result);
$totalRows_posto = mysqli_num_rows($posto_result);

// Busca a lista de Organizações (Seções).
$query_org = "SELECT * FROM num_org ORDER BY org_desc ASC";
$org_result = mysqli_query($conexao, $query_org);
$row_org = mysqli_fetch_assoc($org_result);
$totalRows_org = mysqli_num_rows($org_result);

// Busca os Níveis de acesso.
$query_nivel = "SELECT * FROM num_nivel ORDER BY nivel_id ASC";
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
        <div align="center"><font color="#000099" size="3">Cadastro de Novo Usuário</font></div>
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">RE:</td>
      <td><input type="text" name="rerg" value="" size="9"> (sem dígito)</td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Posto/Graduação:</td>
      <td> 
        <select name="postfunc" id="postfunc">
          <option value="">Selecione...</option>
          <?php
          if ($totalRows_posto > 0) {
            mysqli_data_seek($posto_result, 0); // Garante que o loop comece do início.
            while($row_posto_loop = mysqli_fetch_assoc($posto_result)) {  
          ?>
          <option value="<?php echo htmlspecialchars($row_posto_loop['posto']); ?>"><?php echo htmlspecialchars($row_posto_loop['posto']); ?></option>
          <?php
            }
          }
          ?>
        </select>
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Nome de Guerra:</td>
      <td><input type="text" name="guerra" value="" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Seção:</td>
      <td> 
        <select name="org_id" id="org_id">
          <option value="">Selecione...</option>
          <?php
          if ($totalRows_org > 0) {
            mysqli_data_seek($org_result, 0);
            while($row_org_loop = mysqli_fetch_assoc($org_result)) {
          ?>
          <option value="<?php echo $row_org_loop['org_id']; ?>">
            <?php echo htmlspecialchars($row_org_loop['org_desc']); ?> do <?php echo htmlspecialchars($row_org_loop['org_desc_unid']); ?>
          </option>
          <?php
            }
          }
          ?>
        </select> 
      </td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Nível de Acesso:</td>
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
      <td nowrap align="right">Função/Situação:</td>
      <td><input type="text" name="situacao" value="ATIVO" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="2" align="right" nowrap bgcolor="#CCCCCC"> 
        <div align="center"> 
          <input type="submit" value="Inserir Registro">
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