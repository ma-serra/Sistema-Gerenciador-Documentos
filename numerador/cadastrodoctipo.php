<?php require_once('../Connections/conexao.php'); ?>
<?php

// **BOA PRÁTICA:** Protegendo a ação do formulário contra XSS.
$editFormAction = htmlspecialchars($_SERVER['PHP_SELF']);
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlspecialchars($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  
  // **CORREÇÃO:** Adicionado o argumento $conexao na chamada da função.
  $insertSQL = sprintf("INSERT INTO num_tipodoc (desc_tipo_doc) VALUES (%s)",
                       GetSQLValueString($conexao, $_POST['desc_tipo_doc'], "text"));

  // A linha mysqli_select_db foi removida por ser redundante.
  $Result1 = mysqli_query($conexao, $insertSQL);

  if ($Result1) {
      $insertGoTo = "acaookdoc.php";
      if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
      }
      header(sprintf("Location: %s", $insertGoTo));
      exit();
  } else {
      die("Erro ao inserir o tipo de documento: " . mysqli_error($conexao));
  }
}
?>
<html>
<head>
<title>Numerador</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline"> 
      <td nowrap align="right">Novo tipo de Documento:</td>
      <td><input type="text" name="desc_tipo_doc" value="" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Inserir registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
  
</body>
</html>