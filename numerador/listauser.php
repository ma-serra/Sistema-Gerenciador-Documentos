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
$org_user = "%"; // Padrão para buscar em todas as orgs
if (isset($_GET['org_id']) && is_numeric($_GET['org_id'])) {
  $org_user = $_GET['org_id'];
}

$colname_user = "%"; // Padrão para buscar todos os usuários
if (isset($_GET['rerg'])) {
  $colname_user = $_GET['rerg'];
}

// A consulta SQL com as chamadas corrigidas para GetSQLValueString
$query_user = sprintf("SELECT u.rerg, u.postfunc, u.guerra, u.org_id, o.org_desc_unid, o.org_desc, u.situacao, n.desc_nivel, n.visivel 
                       FROM num_user u 
                       INNER JOIN num_org o ON (o.org_id = u.org_id) 
                       INNER JOIN num_nivel n ON (u.nivel_id = n.nivel_id) 
                       WHERE (u.rerg LIKE %s AND n.visivel <> 0 AND u.org_id LIKE %s) 
                       ORDER BY u.rerg ASC", 
                       GetSQLValueString($conexao, "%" . $colname_user . "%", "text"), // CORRIGIDO
                       GetSQLValueString($conexao, $org_user, "text")); // CORRIGIDO

$user_result = mysqli_query($conexao, $query_user);
$row_user = mysqli_fetch_assoc($user_result);
$totalRows_user = mysqli_num_rows($user_result);
?>
<html>
<head>
<title>Lista de Usuários</title>
<link href="../css/Geral.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="form1" method="get" action="listauser.php">
  <div align="center">DIGITE O RE SEM DÍGITO PARA LOCALIZAR NA LISTA
    <input name="rerg" type="text" id="rerg" size="9">
    <input name="org_id" type="hidden" id="org_id" value="<?php echo htmlspecialchars($_GET['org_id']); ?>">
    <input type="submit" name="Submit" value="Buscar">
  </div>
</form>

<p align="center"><a href="cadasuser.php?org_id=<?php echo htmlspecialchars($_GET['org_id']); ?>">Cadastro de Novo Usuário</a></p>
<br>

<?php if ($totalRows_user > 0): ?>
    <?php do { ?>
    <table width="80%" border="0" align="center">
      <tr <?php echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\""; ?>> 
        <td width="84%" height="13"> 
            <div align="left">
                <font size="3">
                    <?php echo htmlspecialchars($row_user['postfunc']); ?>&nbsp;<?php echo htmlspecialchars($row_user['guerra']); ?>&nbsp;da <?php echo htmlspecialchars($row_user['org_desc']); ?> do <?php echo htmlspecialchars($row_user['org_desc_unid']); ?> com nivel <?php echo htmlspecialchars($row_user['desc_nivel']); ?>
                </font>
            </div>
        </td>
        <td width="8%"> 
          <div align="center">
            <?php
              $a = $row_user['org_id'];
              $b = $_GET['org_id'];
              if ($a == $b) {
                  echo "<a href='../admsist/atualizarseuuser.php?rerg=" . $row_user['rerg'] . "'>Atualizar</a>";
              } else {
                  echo 'Outra Seção';
              }
            ?>
          </div>
        </td>
        <td width="8%">
            <div align="center">
            <?php
              if ($a == $b) {
                  echo "<a href='excluirpm.php?rerg=" . $row_user['rerg'] . "'>EXCLUIR</a>";
              }
            ?>
          </div>
        </td>
      </tr>
      <?php if ($mocolor == $mocolor1) { $mocolor = $mocolor2; } else { $mocolor = $mocolor1; } ?>
    </table>
    <?php } while ($row_user = mysqli_fetch_assoc($user_result)); ?>
<?php else: ?>
    <p align="center">Nenhum usuário encontrado com os critérios informados.</p>
<?php endif; ?>
<br>
</body>
</html>
<?php
mysqli_free_result($user_result);
?>