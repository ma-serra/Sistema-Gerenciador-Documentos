<?php require_once('../Connections/conexao.php'); ?>
<?php

// **BOA PRÁTICA:** Protegendo a ação do formulário contra XSS.
$editFormAction = htmlspecialchars($_SERVER['PHP_SELF']);
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlspecialchars($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    
  // **CORREÇÃO:** Adicionado o argumento $conexao em ambas as chamadas.
  $updateSQL = sprintf("UPDATE num_tipodoc SET desc_tipo_doc=%s WHERE tipo_doc=%s",
                       GetSQLValueString($conexao, $_POST['desc_tipo_doc'], "text"),
                       GetSQLValueString($conexao, $_POST['tipo_doc'], "int"));

  $Result1 = mysqli_query($conexao, $updateSQL);

  if ($Result1) {
    $updateGoTo = "acaookdoc.php";
    if (isset($_SERVER['QUERY_STRING'])) {
      $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
    exit();
  } else {
    die("Erro ao atualizar o tipo de documento: " . mysqli_error($conexao));
  }
}

// --- Busca de dados para exibir no formulário ---
$colname_listatipodoc = "-1"; // Padrão seguro
if (isset($_GET['tipo_doc'])) {
  $colname_listatipodoc = $_GET['tipo_doc'];
}

// **CORREÇÃO (SEGURANÇA):** Consulta protegida contra SQL Injection.
$query_listatipodoc = sprintf("SELECT * FROM num_tipodoc WHERE tipo_doc = %s", GetSQLValueString($conexao, $colname_listatipodoc, "int"));
$listatipodoc = mysqli_query($conexao, $query_listatipodoc);
$row_listatipodoc = mysqli_fetch_assoc($listatipodoc);
$totalRows_listatipodoc = mysqli_num_rows($listatipodoc);
?>
<html>
<head>
<title>Numerador</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
<link  href="/numerador/public/css/Geral.css?v=1753940642" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline"> 
      <td nowrap align="right">Atualizar tipo de Documento:</td>
      <td><input type="text" name="desc_tipo_doc" value="<?php echo htmlspecialchars($row_listatipodoc['desc_tipo_doc'] ?? ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Atualizar o registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="tipo_doc" value="<?php echo htmlspecialchars($row_listatipodoc['tipo_doc'] ?? ''); ?>">
</form>
<p>&nbsp;</p>
  
</body>
</html>
<?php
if($listatipodoc) mysqli_free_result($listatipodoc);
?>