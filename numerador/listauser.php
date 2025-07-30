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
$query_user = sprintf("SELECT     num_user.rerg     , num_user.postfunc     , num_user.guerra     , num_user.Org_id     , num_org.org_descUnid     , num_org.org_desc     , num_user.situacao     , num_nivel.desc_nivel     , num_nivel.visivl FROM num_org     INNER JOIN num_user          ON (num_org.org_id = num_user.Org_id)     INNER JOIN num_nivel          ON (num_user.Nivel = num_nivel.nivel_id) WHERE (num_user.rerg LIKE '%%%s%%'     AND num_nivel.visivl <> 0   AND num_user.Org_id LIKE '%%%s%%') ORDER BY num_user.rerg ASC", $colname_user,$org_user);
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

