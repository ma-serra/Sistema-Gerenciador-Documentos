<?php
// 1. INICIALIZAÇÃO E CONEXÃO
// =============================
require_once('../Connections/conexao.php');

// Define a ação do formulário para o próprio arquivo.
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

// 2. LÓGICA DE INSERÇÃO DE DADOS
// =============================
// O formulário agora usa POST, que é o método correto para inserção.
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  
  $insertSQL = sprintf("INSERT INTO num_doc (cod_org, tipo_doc, num_doc, cod_sec, ano_doc, assunto, destino, `data`, elaborador, obs_doc, elaborado, assinado, encaminhado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($conexao, $_POST['cod_org'], "int"),
                       GetSQLValueString($conexao, $_POST['tipo_doc'], "int"),
                       GetSQLValueString($conexao, $_POST['num_doc'], "text"),
                       GetSQLValueString($conexao, $_POST['cod_sec'], "text"),
                       GetSQLValueString($conexao, $_POST['ano_doc'], "text"),
                       GetSQLValueString($conexao, $_POST['assunto'], "text"),
                       GetSQLValueString($conexao, $_POST['destino'], "text"),
                       GetSQLValueString($conexao, $_POST['data'], "date"),
                       GetSQLValueString($conexao, $_POST['elaborador'], "text"),
                       GetSQLValueString($conexao, $_POST['observacao'], "text"),
                       GetSQLValueString($conexao, $_POST['ELABORADO'], "int"),
                       GetSQLValueString($conexao, $_POST['ASSINADO'], "int"),
                       GetSQLValueString($conexao, $_POST['ENCAMINHADO'], "int"));

  $Result1 = mysqli_query($conexao, $insertSQL);

  if ($Result1) {
    // Para a página de sucesso, passamos os parâmetros via GET para exibir a mensagem.
    $insertGoTo = "acaooknumerador.php?num_doc=" . urlencode($_POST['num_doc']) . 
                  "&cod_sec=" . urlencode($_POST['cod_sec']) . 
                  "&ano_doc=" . urlencode($_POST['ano_doc']) . 
                  "&tipo_doc=" . urlencode($_POST['tipo_doc']);
                  
    header(sprintf("Location: %s", $insertGoTo));
    exit();
  } else {
    die("Erro ao inserir o documento: " . mysqli_error($conexao));
  }
}

// 3. CONSULTAS PARA PREENCHER O FORMULÁRIO
// ==========================================
// Pega os parâmetros da URL.
$cod_org_param = isset($_GET['cod_org']) ? $_GET['cod_org'] : '-1';
$tipo_doc_param = isset($_GET['tipo_doc']) ? $_GET['tipo_doc'] : '-1';

// Busca o tipo de documento.
$query_documento = sprintf("SELECT * FROM num_tipodoc WHERE tipo_doc = %s", GetSQLValueString($conexao, $tipo_doc_param, "int"));
$documento_result = mysqli_query($conexao, $query_documento);
$row_documento = mysqli_fetch_assoc($documento_result);

// Busca os dados da seção (organização).
$query_org = sprintf("SELECT * FROM num_org WHERE org_id = %s", GetSQLValueString($conexao, $cod_org_param, "int"));
$org_result = mysqli_query($conexao, $query_org);
$row_org = mysqli_fetch_assoc($org_result);

// Busca o último documento registrado para este tipo e seção.
$current_year = date("Y");
$query_numero = sprintf("SELECT * FROM num_doc WHERE cod_org = %s AND tipo_doc = %s AND ano_doc = %s ORDER BY num_doc DESC LIMIT 1",
                        GetSQLValueString($conexao, $cod_org_param, "int"),
                        GetSQLValueString($conexao, $tipo_doc_param, "int"),
                        GetSQLValueString($conexao, $current_year, "text"));
$numero_result = mysqli_query($conexao, $query_numero);
$row_numero = mysqli_fetch_assoc($numero_result);
$totalRows_numero = mysqli_num_rows($numero_result);

// 4. LÓGICA PARA CALCULAR O PRÓXIMO NÚMERO
// ==========================================
$numdoc = 1; // Padrão, caso seja o primeiro do ano.
if ($totalRows_numero > 0) {
    // Se já existem documentos, pega o último número e soma 1.
    $numdoc = intval($row_numero['num_doc']) + 1;
}
// Formata o número para ter sempre 4 dígitos (ex: 0001, 0015, 0123).
$numdoc_formatado = str_pad($numdoc, 4, "0", STR_PAD_LEFT);
?>
<html>
<head>
<title>Numerador - Inserir Documento</title>
<link href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table width="600" border="12" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td valign="top">
        <div align="center"> 
          <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
            <tr valign="baseline"> 
              <td colspan="2" align="center" nowrap bgcolor="#CCCCCC">
                <font color="#000099" size="3">
                  Cadastro de Novo Documento<br>
                  <strong><?php echo htmlspecialchars($row_documento['desc_tipo_doc']); ?></strong>
                </font>
              </td>
            </tr>
            <tr align="center" valign="baseline"> 
              <td colspan="2" valign="middle" nowrap bgcolor="#FFFFFF">
                <div align="center">
                  Número do Documento:<br>
                  <font color="#000099" size="6"><strong><?php echo $numdoc_formatado; ?></strong></font>
                  <font color="#990000" size="4"> / <?php echo htmlspecialchars($row_org['org_cod_secao']); ?> / <?php echo $current_year; ?></font>
                </div>
              </td>
            </tr>
            <tr valign="baseline"> 
              <td width="100" align="right" valign="middle" nowrap>Assunto:</td>
              <td><textarea name="assunto" cols="60" rows="2"></textarea></td>
            </tr>
            <tr valign="baseline"> 
              <td align="right" valign="middle" nowrap>Destino:</td>
              <td><textarea name="destino" cols="60" rows="2"></textarea></td>
            </tr>
            <tr valign="baseline"> 
              <td align="right" valign="middle" nowrap>Observação:</td>
              <td><textarea name="observacao" cols="60" rows="2" id="observacao"></textarea></td>
            </tr>
            <tr valign="baseline"> 
              <td colspan="2" align="center" valign="middle" nowrap bgcolor="#FFFFFF"> 
                ELABORADO:&nbsp;&nbsp;&nbsp;
                Não <input name="ELABORADO" type="radio" value="0" checked>
                &nbsp;&nbsp;&nbsp;
                Sim <input type="radio" name="ELABORADO" value="1">
              </td>
            </tr>
            <tr valign="baseline"> 
              <td colspan="2" align="center" nowrap bgcolor="#CCCCCC"> 
                <input type="hidden" name="data" value="<?php echo date("Y-m-d"); ?>">
                <input type="hidden" name="ano_doc" value="<?php echo $current_year; ?>">
                <input type="hidden" name="cod_sec" value="<?php echo htmlspecialchars($row_org['org_cod_secao']); ?>">
                <input type="hidden" name="cod_org" value="<?php echo htmlspecialchars($row_org['org_id']); ?>">
                <input type="hidden" name="tipo_doc" value="<?php echo htmlspecialchars($row_documento['tipo_doc']); ?>">
                <input type="hidden" name="elaborador" value="<?php echo htmlspecialchars($_GET['re']); ?>">
                <input type="hidden" name="num_doc" value="<?php echo $numdoc_formatado; ?>">
                
                <input name="ASSINADO" type="hidden" id="ASSINADO2" value="0">
                <input name="ENCAMINHADO" type="hidden" id="ENCAMINHADO2" value="0">
                
                <input name="submit" type="submit" value="Inserir Registro">
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
<?php
// 5. LIBERAÇÃO DE MEMÓRIA
// =======================
mysqli_free_result($documento_result);
mysqli_free_result($org_result);
mysqli_free_result($numero_result);
?>