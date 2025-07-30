<?php 
require_once('../Connections/conexao.php');

$colname_tipodoc = "1";
if (isset($_GET['tipo_doc'])) {
  // Remoção da função `get_magic_quotes_gpc()`, que está obsoleta.
  $colname_tipodoc = $_GET['tipo_doc'];
}

$query_tipodoc = sprintf("SELECT * FROM num_tipodoc WHERE tipo_doc = %s", GetSQLValueString($conexao, $colname_tipodoc, "int"));
$tipodoc_result = mysqli_query($conexao, $query_tipodoc);
$row_tipodoc = mysqli_fetch_assoc($tipodoc_result);
?>
<html>
</html>
<?php
mysqli_free_result($tipodoc_result);
?>