<?php require_once('../Connections/conexao.php'); ?>
<?php
$colname_secao = "1";
if (isset($_GET['org_id'])) {
  $colname_secao = $_GET['org_id'];
}
mysqli_select_db($conexao, $database_conexao);
$query_secao = sprintf("SELECT * FROM num_org WHERE org_id = %s", $colname_secao);
$secao = mysqli_query($conexao, $query_secao);
$row_secao = mysqli_fetch_assoc($secao);
$totalRows_secao = mysqli_num_rows($secao);
?>
<html>
<head>
<title>Numerador</title>
<link  href="file:///C|/xampp/htdocs/webcpi2/css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="655" align="center" bgcolor="#E2E2E2">
  <tr valign="baseline" bgcolor="#CCCCCC"> 
    <td colspan="4" align="right" nowrap><div align="center"><font color="#000099" size="3">CADASTRO 
        DE SE&Ccedil;&Atilde;O</font></div></td>
  </tr>
  <tr valign="baseline"> 
    <td colspan="4" align="right" nowrap><table width="655" align="center">
        <tr valign="baseline"> 
          <td width="123" align="right" nowrap><font size="3"><strong>Cod da OPM:</strong></font></td>
          <td width="170"> <strong><font color="#990000" size="3"><?php echo $row_secao['org_unidade']; ?></font></strong></td>
          <td width="154"><font size="3"><strong>Descri&ccedil;&atilde;o da OPM:</strong></font></td>
          <td width="188"> <strong><font color="#990000" size="3"><?php echo $row_secao['org_desc_unid']; ?></font></strong></td>
        </tr>
        <tr valign="baseline"> 
          <td nowrap align="right"><font size="3"><strong>Cod. doc da se&ccedil;&atilde;o:</strong></font></td>
          <td> <strong><font color="#990000" size="3"><?php echo $row_secao['org_cod_secao']; ?></font></strong></td>
          <td><font size="3"><strong>Descri&ccedil;&atilde;o da Se&ccedil;&atilde;o:</strong></font></td>
          <td> <strong><font color="#990000" size="3"><?php echo $row_secao['org_desc']; ?></font></strong></td>
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
          <td width="51" align="right" nowrap><font size="3"><strong>Cidade:</strong></font></td>
          <td width="188"> <strong><font color="#990000" size="3"><?php echo $row_secao['org_cidade']; ?></font></strong></td>
          <td width="342"><font size="3"><strong>Bairro: <font color="#990000"><?php echo $row_secao['org_bairro']; ?></font></strong></font></td>
          <td width="54"><font size="3"><strong>UF: <font color="#990000"><?php echo $row_secao['org_uf']; ?></font> </strong></font></td>
        </tr>
        <tr valign="baseline"> 
          <td nowrap align="right"><font size="3"><strong>Via:</strong></font></td>
          <td colspan="3"> <font size="3"><strong><font color="#990000"><?php echo $row_secao['org_via']; ?></font> N&ordm;: <font color="#990000"><?php echo $row_secao['org_num']; ?></font></strong></font></td>
        </tr>
        <tr valign="baseline"> 
          <td nowrap align="right"><font size="3"><strong>Refer&ecirc;ncia:</strong></font></td>
          <td colspan="3"> <strong><font color="#990000" size="3"><?php echo $row_secao['org_ref']; ?></font></strong></td>
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
          <td width="126" align="right" nowrap><font size="3"><strong>Telefone:</strong></font></td>
          <td width="223" align="right" nowrap><div align="left"> <font size="3"><strong><font color="#990000"><?php echo $row_secao['org_tel']; ?></font></strong></font></div></td>
          <td width="38" align="right" nowrap><font size="3"><strong>Fax:</strong></font></td>
          <td width="248" align="right" nowrap><div align="left"> <font size="3"><strong><font color="#990000"><?php echo $row_secao['org_fax']; ?></font></strong></font></div></td>
        </tr>
        <tr valign="baseline"> 
          <td nowrap align="right"><font size="3"><strong>e-mail:</strong></font></td>
          <td colspan="3"> <strong><font color="#990000" size="3"><?php echo $row_secao['org_email']; ?></font></strong></td>
        </tr>
      </table></td>
  </tr>
  <tr valign="baseline"> 
    <td width="71" align="right" nowrap><div align="left">Observa&ccedil;&atilde;o: 
      </div></td>
    <td width="580" colspan="3"> <font color="#990000"><strong><?php echo $row_secao['org_obs']; ?></strong></font></td>
  </tr>
  <tr valign="baseline"> 
    <td colspan="4" align="right" nowrap bgcolor="#CCCCCC"> <div align="center"> 
        <input type="hidden" name="org_tp" value="<?php echo $row_secao['org_tp']; ?>" size="32">
      </div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($secao);
?>

