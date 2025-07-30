<?php 
require_once('../Connections/conexao.php');

// Ação do formulário com proteção XSS
$editFormAction = htmlspecialchars($_SERVER['PHP_SELF']);

// Processamento do formulário de inserção
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["MM_insert"]) && $_POST["MM_insert"] == "form1") {
    // Query de inserção com nomes de coluna corrigidos
    $insertSQL = sprintf("INSERT INTO num_org (org_unidade, org_desc_unid, org_cod_secao, org_desc, org_cidade, org_uf, org_bairro, org_via, org_num, org_ref, org_tel, org_fax, org_email, org_tp, org_obs) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($conexao, $_POST['org_unidade'], "int"),
                       GetSQLValueString($conexao, $_POST['org_desc_unid'], "text"),
                       GetSQLValueString($conexao, $_POST['org_cod_secao'], "text"),
                       GetSQLValueString($conexao, $_POST['org_desc'], "text"),
                       GetSQLValueString($conexao, $_POST['org_cidade'], "text"),
                       GetSQLValueString($conexao, $_POST['org_uf'], "text"),
                       GetSQLValueString($conexao, $_POST['org_bairro'], "text"),
                       GetSQLValueString($conexao, $_POST['org_via'], "text"),
                       GetSQLValueString($conexao, $_POST['org_num'], "text"),
                       GetSQLValueString($conexao, $_POST['org_ref'], "text"),
                       GetSQLValueString($conexao, $_POST['org_tel'], "text"),
                       GetSQLValueString($conexao, $_POST['org_fax'], "text"),
                       GetSQLValueString($conexao, $_POST['org_email'], "text"),
                       GetSQLValueString($conexao, $_POST['org_tp'], "text"),
                       GetSQLValueString($conexao, $_POST['org_obs'], "text"));

    $Result1 = mysqli_query($conexao, $insertSQL);

    if ($Result1) {
        $insertGoTo = "acaook.php"; // Página de sucesso
        header(sprintf("Location: %s", $insertGoTo));
        exit();
    } else {
        die("Erro ao inserir o novo registro: " . mysqli_error($conexao));
    }
}
?>
<html>
<head>
<title>Numerador - Cadastrar Seção</title>
<link href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table width="655" align="center" bgcolor="#E2E2E2">
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="4" align="center" nowrap><font color="#000099" size="3"><strong>Cadastro da Seção</strong></font></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="4" nowrap>
        <table width="100%" align="center">
          <tr valign="baseline"> 
            <td width="20%" align="right" nowrap>Cod da OPM:</td>
            <td width="30%"><input type="text" name="org_unidade" value="602350000" size="12"></td>
            <td width="20%" align="right">Descrição da OPM:</td>
            <td width="30%"><input type="text" name="org_desc_unid" value="35º BPM/I" size="45"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Cod. doc da seção:</td>
            <td><input type="text" name="org_cod_secao" value="000" size="12"></td>
            <td align="right">Descrição da Seção:</td>
            <td><input type="text" name="org_desc" size="45"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="4" align="center" nowrap><font color="#000099" size="3"><strong>Endereço da Seção</strong></font></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="4" nowrap>
        <table width="100%" align="center">
          <tr valign="baseline"> 
            <td align="right" nowrap>Cidade:</td>
            <td><input type="text" name="org_cidade" value="Campinas" size="30"></td>
            <td align="right">Bairro:</td>
            <td><input type="text" name="org_bairro" value="Ponte Preta" size="45"></td>
            <td align="right">UF:</td>
            <td><input type="text" name="org_uf" value="SP" size="4"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Via:</td>
            <td colspan="5"><input type="text" name="org_via" size="60">
              Nº: 
              <input type="text" name="org_num" value="60" size="9">
            </td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Referência:</td>
            <td colspan="5"><input type="text" name="org_ref" size="32"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="4" align="center" nowrap><font color="#000099" size="3"><strong>Meios de Contato</strong></font></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="4" nowrap>
        <table width="100%" align="center">
          <tr valign="baseline"> 
            <td width="20%" align="right" nowrap>Telefone:</td>
            <td width="30%"><input type="text" name="org_tel" value="19 - 32365346" size="32"></td>
            <td width="20%" align="right" nowrap>Fax:</td>
            <td width="30%"><input type="text" name="org_fax" value="19 - 32365346" size="32"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">e-mail:</td>
            <td colspan="3"><input type="text" name="org_email" size="50"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="baseline"> 
      <td align="right" nowrap>Observação:</td>
      <td colspan="3"><input type="text" name="org_obs" size="80"></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="4" align="center" nowrap bgcolor="#CCCCCC">
        <input type="hidden" name="org_tp" value="PM">
        <input name="submit" type="submit" value="Cadastrar Registro">
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>