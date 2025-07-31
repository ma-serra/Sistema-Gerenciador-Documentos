<?php require_once('../Connections/conexao.php'); ?>
<?php

// **BOA PRÁTICA:** Ações de inserção devem usar POST.
$editFormAction = htmlspecialchars($_SERVER['PHP_SELF']);
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlspecialchars($_SERVER['QUERY_STRING']);
}

// **BOA PRÁTICA:** Lógica de inserção agora responde ao método POST.
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    
  // **CORREÇÃO:** Adicionado $conexao e corrigido os tipos de dados.
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
    // Mantém os parâmetros na URL para a próxima página saber o que exibir.
    $insertGoTo = "atualinvovdoc.php?" . http_build_query([
        'num_doc' => $_POST['num_doc'],
        'cod_org' => $_POST['cod_org'],
        'tipo_doc' => $_POST['tipo_doc'],
        'ano_doc' => $_POST['ano_doc']
    ]);
    header(sprintf("Location: %s", $insertGoTo));
    exit();
  } else {
      die("Erro na inserção do documento: " . mysqli_error($conexao));
  }
}

// --- Busca de dados para exibição ---
$cod_org_get = isset($_GET['cod_org']) ? $_GET['cod_org'] : '-1';
$tipo_doc_get = isset($_GET['tipo_doc']) ? $_GET['tipo_doc'] : '-1';
$re_get = isset($_GET['re']) ? $_GET['re'] : '';
$ano_atual = date("Y"); // **BOA PRÁTICA:** Usar ano com 4 dígitos.

// **CORREÇÃO (SEGURANÇA):** Consulta protegida.
$query_documento = sprintf("SELECT * FROM num_tipodoc WHERE tipo_doc = %s", GetSQLValueString($conexao, $tipo_doc_get, "int"));
$documento_result = mysqli_query($conexao, $query_documento);
$row_documento = mysqli_fetch_assoc($documento_result);

// **CORREÇÃO (SEGURANÇA):** Consulta protegida.
$query_org = sprintf("SELECT * FROM num_org WHERE org_id = %s", GetSQLValueString($conexao, $cod_org_get, "int"));
$org_result = mysqli_query($conexao, $query_org);
$row_org = mysqli_fetch_assoc($org_result);

// **LÓGICA OTIMIZADA:** Uma única query para pegar o próximo número.
$query_numero = sprintf("SELECT MAX(CAST(num_doc AS UNSIGNED)) as ultimo_num FROM num_doc WHERE cod_org = %s AND tipo_doc = %s AND ano_doc = %s",
    GetSQLValueString($conexao, $cod_org_get, "int"),
    GetSQLValueString($conexao, $tipo_doc_get, "int"),
    GetSQLValueString($conexao, $ano_atual, "text")
);
$numero_result = mysqli_query($conexao, $query_numero);
$row_numero = mysqli_fetch_assoc($numero_result);

// Calcula o próximo número de forma segura e o formata com 4 dígitos.
$proximo_num = ($row_numero['ultimo_num'] ?? 0) + 1;
$numdoc_formatado = str_pad($proximo_num, 4, "0", STR_PAD_LEFT);
?>
<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table width="400" border="12" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td height="105" valign="top"><div align="center">
          <table width="100%" border="0" align="center">
            <tr valign="baseline"> 
              <td align="right" nowrap bgcolor="#CCCCCC"> <div align="center"><font color="#000099" size="3">CADASTRO DE NOVO NUMERADOR DA SEÇÃO</font></div></td>
            </tr>
            <tr align="center" valign="baseline"> 
              <td valign="middle" nowrap bgcolor="#FFFFFF"> 
                <div align="center">
                    <font color="#000099" size="3"><?php echo htmlspecialchars($row_documento['desc_tipo_doc'] ?? 'Documento'); ?></font>
                    <font size="4"> <font color="#990000">N&ordm; &nbsp;<?php echo $numdoc_formatado; ?></font></font>
                    <font color="#990000" size="4"> / <?php echo htmlspecialchars($row_org['org_cod_secao'] ?? ''); ?>&nbsp;/&nbsp;<?php echo $ano_atual; ?></font>
                </div>
              </td>
            </tr>
            <tr valign="baseline"> 
              <td align="right" valign="middle" nowrap bgcolor="#FFFFFF"> <div align="center"><font color="#0000CC" size="3">Após confirmar a reserva deste número preencha os demais dados</font></div></td>
            </tr>
            <tr valign="baseline"> 
              <td align="right" nowrap bgcolor="#CCCCCC"> <div align="center"> 
                  <input type="submit" value="Confirmar a reserva">
                  
                  <input type="hidden" name="MM_insert" value="form1">
                  <input type="hidden" name="destino" value="Preencher">
                  <input type="hidden" name="observacao" id="observacao" value="sem obs">
                  <input type="hidden" name="data" value="<?php echo date("Y-m-d"); ?>">
                  <input type="hidden" name="ano_doc" value="<?php echo $ano_atual; ?>">
                  <input type="hidden" name="cod_sec" value="<?php echo htmlspecialchars($row_org['org_cod_secao'] ?? ''); ?>">
                  <input type="hidden" name="cod_org" value="<?php echo htmlspecialchars($row_org['org_id'] ?? ''); ?>">
                  <input type="hidden" name="tipo_doc" id="tipo_doc" value="<?php echo htmlspecialchars($row_documento['tipo_doc'] ?? ''); ?>">
                  <input type="hidden" name="elaborador" value="<?php echo htmlspecialchars($re_get); ?>">
                  <input type="hidden" name="num_doc" value="<?php echo $numdoc_formatado; ?>">
                  <input type="hidden" name="assunto" value="preencher">
                  <input type="hidden" name="ELABORADO" value="0">
                  <input type="hidden" name="ASSINADO" value="1">
                  <input type="hidden" name="ENCAMINHADO" value="1">
                </div></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
// Libera a memória dos resultados
if($documento_result) mysqli_free_result($documento_result);
if($org_result) mysqli_free_result($org_result);
if($numero_result) mysqli_free_result($numero_result);
?>