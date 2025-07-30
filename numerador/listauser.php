<?php
// technocurve arc 3 php mv block1/3 start
$mocolor1 = "#CCCCCC";
$mocolor2 = "#FFFFFF";
$mocolor3 = "#FFFFCC";
$mocolor = $mocolor1;
// technocurve arc 3 php mv block1/3 end
?>
<?php require_once('../Connections/conexao.php'); ?>
<?php
$org_user = "1";
if (isset($_GET['org_id'])) {
  $org_user = $_GET['org_id'];
}
$colname_user = "1";
if (isset($_GET['rerg'])) {
  $colname_user = $_GET['rerg'];
}
mysqli_select_db($conexao, $database_conexao);
$query_user = sprintf("SELECT u.rerg, u.postfunc, u.guerra, u.org_id, o.org_desc_unid, o.org_desc, u.situacao, n.desc_nivel, n.visivel 
                       FROM num_user u 
                       INNER JOIN num_org o ON (o.org_id = u.org_id) 
                       INNER JOIN num_nivel n ON (u.nivel_id = n.nivel_id) 
                       WHERE (u.rerg LIKE %s AND n.visivel <> 0 AND u.org_id LIKE %s) 
                       ORDER BY u.rerg ASC", 
                       GetSQLValueString("%" . $colname_user . "%", "text"),
                       GetSQLValueString("%" . $org_user . "%", "text"));
$user = mysqli_query($conexao, $query_user);
$row_user = mysqli_fetch_assoc($user);
$totalRows_user = mysqli_num_rows($user);
?>
<html>
<head>
<title>Documento sem t&iacute;tulo</title>
<link  href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="form1" method="get" action="listauser1.php">
  
  <div align="center">DIGITE O RE SEM D&Iacute;GITO PARA LOCALIZAR NA LISTA
<input name="rerg" type="text" id="rerg" size="9">
    &nbsp; 
    <input type="submit" name="Submit" value="Buscar">
    <input name="org_id" type="hidden" id="org_id" value="%">
    <input name="org" type="hidden" id="org" value="<?php echo $_GET['org_id']; ?>">
  </div>
</form>

<a href="cadasuser.php?org_id=<?php echo $_GET['org_id']; ?>">Cadastro 
de Novo Usu&aacute;rio</a> <br>
<br>
<?php do { ?>
<table width="80%" border="0" align="center">
  <tr <?php 
// technocurve arc 3 php mv block2/3 start
echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\"";
// technocurve arc 3 php mv block2/3 end
?>> 
    <td width="84%" height="13"> <div align="left"><font size="3"><?php echo $row_user['postfunc']; ?>&nbsp;<?php echo $row_user['guerra']; ?>&nbsp;da <?php echo $row_user['org_desc']; ?> do <?php echo $row_user['org_descUnid']; ?> com nivel <?php echo $row_user['desc_nivel']; ?></font></div></td>
    <td width="8%"> 
      <div align="center"></div>
      <div align="center">
        <?php
	  $a = $row_user['Org_id'];
      $b = $_GET['org_id'];
      $outra = "Outra Se��o";
      $atualizar = "<a href='atualizarsuser.php?rerg=" . $row_user['rerg'] . "'>Atualizar</a>";
if ($a == $b) {
    echo $atualizar;
} else
{
echo 'Outra Se��o';
}
?>
      </div></td>
    <td width="8%"><div align="center">
        <?php
	  $a = $row_user['Org_id'];
      $b = $_GET['org_id'];
      $outra = "Outra Se��o";
      $atualizar = "<a href='excluirpm.php?rerg=" . $row_user['rerg'] . "'>EXCLUIR</a>";
if ($a == $b) {
    echo $atualizar;
} else
{
echo '';
}
?>
      </div></td>
  </tr>
  <?php 
// technocurve arc 3 php mv block3/3 start
if ($mocolor == $mocolor1) {
	$mocolor = $mocolor2;
} else {
	$mocolor = $mocolor1;
}
// technocurve arc 3 php mv block3/3 end
?>
</table>
<?php } while ($row_user = mysqli_fetch_assoc($user)); ?>
<br>
</body>
</html>
<?php
mysqli_free_result($user);
?>

