<?php require_once('../Connections/conexao.php'); ?>
<?php

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO num_org (org_unidade, org_desc_unid, org_cod_secao, org_desc, org_cidade, org_uf, org_bairro, org_via, org_num, org_ref, org_tel, org_fax, org_email, org_tp, org_obs) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['org_unidade'], "int"),
                       GetSQLValueString($_POST['org_desc_unid'], "text"),
                       GetSQLValueString($_POST['org_cod_secao'], "text"),
                       GetSQLValueString($_POST['org_desc'], "text"),
                       GetSQLValueString($_POST['org_cidade'], "text"),
                       GetSQLValueString($_POST['org_uf'], "text"),
                       GetSQLValueString($_POST['org_bairro'], "text"),
                       GetSQLValueString($_POST['org_via'], "text"),
                       GetSQLValueString($_POST['org_num'], "text"),
                       GetSQLValueString($_POST['org_ref'], "text"),
                       GetSQLValueString($_POST['org_tel'], "text"),
                       GetSQLValueString($_POST['org_fax'], "text"),
                       GetSQLValueString($_POST['org_email'], "text"),
                       GetSQLValueString($_POST['org_tp'], "text"),
                       GetSQLValueString($_POST['org_obs'], "text"));

  mysqli_select_db($conexao, $database_conexao);
  $Result1 = mysqli_query($conexao, $insertSQL);

  $insertGoTo = "acaook.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<html>
<head>
<title>Numerador</title>
<link  href="file:///C|/xampp/htdocs/webcpi2/css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table width="655" align="center" bgcolor="#E2E2E2">
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="4" align="right" nowrap> <div align="center"><font color="#000099" size="3">Cadastro 
          da Se&ccedil;&atilde;o</font></div></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="4" align="right" nowrap><table width="655" align="center">
          <tr valign="baseline"> 
            <td width="124" align="right" nowrap>Cod da OPM:</td>
            <td width="86"><input type="text" name="org_unidade" value="602350000" size="12"></td>
            <td width="129">Descri&ccedil;&atilde;o da OPM:</td>
            <td width="296"><input type="text" name="org_desc_unid" value="35&ordm; BPM/I" size="45"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Cod. doc da se&ccedil;&atilde;o:</td>
            <td><input type="text" name="org_cod_secao" value="000" size="12"></td>
            <td>Descri&ccedil;&atilde;o da Se&ccedil;&atilde;o:</td>
            <td><input type="text" name="org_desc" size="45"></td>
          </tr>
        </table></td>
    </tr>
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="4" align="right" nowrap> <div align="center"><font color="#000099" size="3">Endere&ccedil;o 
          da Se&ccedil;&atilde;o</font></div></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="4" align="right" nowrap><table width="655" align="center">
          <tr valign="baseline"> 
            <td width="67" align="right" nowrap>Cidade:</td>
            <td width="186"><input type="text" name="org_cidade" value="Campinas" size="30"></td>
            <td width="320">Bairro: 
              <input type="text" name="org_bairro" value="Ponte Preta" size="45"></td>
            <td width="62">UF: 
              <input type="text" name="org_uf" value="SP" size="4"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Via:</td>
            <td colspan="3"><input type="text" name="org_via" size="60">
              N&ordm;: 
              <input type="text" name="org_num" value="60" size="9"></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">Refer&ecirc;ncia:</td>
            <td colspan="3"><input type="text" name="org_ref" size="32"></td>
          </tr>
        </table></td>
    </tr>
    <tr valign="baseline" bgcolor="#CCCCCC"> 
      <td colspan="4" align="right" nowrap> <div align="center"><font color="#000099" size="3">Meios 
          de Contato</font></div></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="4" align="right" nowrap><table width="655" align="center">
          <tr valign="baseline"> 
            <td width="99" align="right" nowrap>Telefone:</td>
            <td width="219" align="right" nowrap><div align="left"> 
                <input type="text" name="org_tel" value="19 - 32365346" size="32">
              </div></td>
            <td width="69" align="right" nowrap>Fax:</td>
            <td width="248" align="right" nowrap><div align="left"> 
                <input type="text" name="org_fax" value="19 - 32365346" size="32">
              </div></td>
          </tr>
          <tr valign="baseline"> 
            <td nowrap align="right">e-mail:</td>
            <td colspan="3"><input type="text" name="org_email" size="50"></td>
          </tr>
        </table></td>
    </tr>
    <tr valign="baseline"> 
      <td width="104" align="right" nowrap>Observa&ccedil;&atilde;o: </td>
      <td width="547" colspan="3"><input type="text" name="org_obs" size="60"></td>
    </tr>
    <tr valign="baseline"> 
      <td colspan="4" align="right" nowrap bgcolor="#CCCCCC"> <div align="center"> 
          <input type="hidden" name="org_tp" value="PM" size="32">
          <input name="submit" type="submit" value="Cadastrar o registro">
        </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
