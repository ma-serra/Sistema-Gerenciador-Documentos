<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexao = "localhost";
$database_conexao = "numerador_db";
$username_conexao = "root";
$password_conexao = "";
$conexao = mysqli_connect($hostname_conexao, $username_conexao, $password_conexao, $database_conexao);
// ## $conn = mysqli_connect($servername, $username, $password, $database);

/**
 * Prepara uma string para ser usada em uma consulta SQL, prevenindo injeções de SQL.
 * Esta função é um legado de sistemas antigos e, embora funcional,
 * o ideal é migrar para Prepared Statements (declarações preparadas) com mysqli ou PDO.
 */
function GetSQLValueString($conexao, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if ($theValue === "" || $theValue === null) {
    return "NULL";
  }
  
  // A função mysqli_real_escape_string precisa da conexão como primeiro argumento.
  $theValue = mysqli_real_escape_string($conexao, $theValue);

  switch ($theType) {
    case "text":
      $theValue = "'" . $theValue . "'";
      break;    
    case "long":
    case "int":
      $theValue = intval($theValue);
      break;
    case "double":
      $theValue = doubleval($theValue);
      break;
    case "date":
      $theValue = "'" . $theValue . "'";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

/**
 * Converte data do formato aaaa-mm-dd para dd/mm/aaaa
 */
function Consert_DataBr($data)
{
    if (!empty($data) && preg_match("#-#", $data) == 1) {
        return implode('/', array_reverse(explode('-', $data)));
    }
    return $data;
}
?>