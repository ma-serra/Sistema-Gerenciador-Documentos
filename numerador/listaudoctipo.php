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

// Ação do formulário com proteção XSS
$editFormAction = htmlspecialchars($_SERVER['PHP_SELF']);

// --- LÓGICA DE INSERÇÃO (ABERTURA DE NOVO NUMERADOR) ---
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["MM_insert"]) && $_GET["MM_insert"] == "form1") {
  
  // CORRIGIDO: Adicionado $conexao como primeiro parâmetro em todas as chamadas GetSQLValueString
  $insertSQL = sprintf("INSERT INTO num_doc (cod_org, obs_doc, tipo_doc, num_doc, cod_sec, ano_doc, assunto, destino, `data`, elaborador, ELABORADO, ASSINADO, ENCAMINHADO) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($conexao, $_GET['cod_org'], "int"),
                       GetSQLValueString($conexao, $_GET['obeservacao'], "text"),
                       GetSQLValueString($conexao, $_GET['tipo_doc'], "int"),
                       GetSQLValueString($conexao, $_GET['num_doc'], "text"),
                       GetSQLValueString($conexao, $_GET['cod_sec'], "text"),
                       GetSQLValueString($conexao, $_GET['ano_doc'], "text"),
                       GetSQLValueString($conexao, $_GET['assunto'], "text"),
                       GetSQLValueString($conexao, $_GET['destino'], "text"),
                       GetSQLValueString($conexao, $_GET['data'], "date"),
                       GetSQLValueString($conexao, $_GET['elaborador'], "text"),
                       GetSQLValueString($conexao, $_GET['ELABORADO'], "int"),
                       GetSQLValueString($conexao, $_GET['ASSINADO'], "int"),
                       GetSQLValueString($conexao, $_GET['ENCAMINHADO'], "int"));

  $Result1 = mysqli_query($conexao, $insertSQL);

  if ($Result1) {
    $insertGoTo = "acaooknovotipodoc.php";
    if (isset($_SERVER['QUERY_STRING'])) {
      $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
      $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
    exit();
  } else {
    die("Erro ao abrir novo numerador: " . mysqli_error($conexao));
  }
}

// --- CONSULTAS PARA EXIBIÇÃO DA PÁGINA ---

$cod_org_get = "0";
if (isset($_GET['cod_org']) && is_numeric($_GET['cod_org'])) {
  $cod_org_get = $_GET['cod_org'];
}

// CORRIGIDO: Query para listar os tipos de documento já existentes, sem causar erro de GROUP BY.
$query_listadoc = sprintf("SELECT DISTINCT t.desc_tipo_doc 
                           FROM num_doc d 
                           INNER JOIN num_tipodoc t ON (d.tipo_doc = t.tipo_doc) 
                           WHERE d.cod_org = %s 
                           ORDER BY t.desc_tipo_doc ASC", 
                           GetSQLValueString($conexao, $cod_org_get, "int"));
$listadoc_result = mysqli_query($conexao, $query_listadoc);
if(!$listadoc_result) { die("Erro na consulta de listagem de documentos: " . mysqli_error($conexao)); }
$totalRows_listadoc = mysqli_num_rows($listadoc_result);

// Query para popular o <select> de todos os tipos de documento disponíveis.
$query_documento = "SELECT * FROM num_tipodoc ORDER BY desc_tipo_doc ASC";
$documento_result = mysqli_query($conexao, $query_documento);
if(!$documento_result) { die("Erro na consulta de tipos de documento: " . mysqli_error($conexao)); }
$row_documento_loop = mysqli_fetch_assoc($documento_result); // Para o loop

// Query para buscar os detalhes da organização (seção) atual.
$query_Recordset1 = sprintf("SELECT * FROM num_org WHERE org_id = %s", GetSQLValueString($conexao, $cod_org_get, "int"));
$Recordset1 = mysqli_query($conexao, $query_Recordset1);
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);

$ano_atual = date("Y");
?>
<html>
<head>
<title>Numerador - Abertura de Novo Numerador</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
<link href="/numerador/public/css/Geral.css?v=1753940642" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="Javascript" type="text/javascript">function Completar(campo, Max) { var Caracter = '0'; while(campo.value.length < Max) { campo.value = Caracter + campo.value; } }</script>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="get" name="form1">
  <table width="95%" border="0" align="center">
    <tr> 
      <td width="25%" height="105" valign="top" style="border-right: 1px solid #ccc; padding-right: 10px;"> 
        <div align="center"><font color="#0000CC" size="3"><strong>NUMERADORES ABERTOS</strong></font></div>
        <?php if ($totalRows_listadoc > 0): ?>
            <?php mysqli_data_seek($listadoc_result, 0); // Reinicia o ponteiro ?>
            <?php while ($row_listadoc = mysqli_fetch_assoc($listadoc_result)): ?>
            <table width="95%" border="0" align="center">
              <tr <?php echo " style=\"background-color:$mocolor\" onMouseOver=\"this.style.backgroundColor='$mocolor3'\" onMouseOut=\"this.style.backgroundColor='$mocolor'\""; ?>> 
                <td height="13" colspan="2"><div align="center"><?php echo htmlspecialchars($row_listadoc['desc_tipo_doc']); ?></div></td>
              </tr>
              <?php if ($mocolor == $mocolor1) { $mocolor = $mocolor2; } else { $mocolor = $mocolor1; } ?>
            </table>
            <?php endwhile; ?>
        <?php else: ?>
            <p align="center">Nenhum numerador aberto para esta seção.</p>
        <?php endif; ?>
      </td>
      <td width="75%" height="105" valign="top">
        <table width="450" border="12" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td valign="top">
              <div align="center"> 
                <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#E8E8E8">
                  <tr> 
                    <td bgcolor="#CCCCCC"> 
                      <div align="center"><font color="#000099" size="3"><strong>Abertura de Novo Numerador</strong><br><small>Inicie com a inclusão do 1º Documento</small></font></div>
                    </td>
                  </tr>
                  <tr> 
                    <td height="18"> 
                      <div align="center">
                        Número do Documento (4 dígitos):<br>
                        <input name="num_doc" type="text" id="Num_Doc2" value="0001" onBlur="Completar(this, 4)" size="4" maxlength="4">
                        <br><font color="#FF0000" size="1">Se for o primeiro, use 0001. Se já existir, insira o próximo número da sequência.</font>
                      </div>
                    </td>
                  </tr>
                  <tr> 
                    <td height="13">
                      <div align="center">
                        <font color="#FF0000">Selecione o tipo de documento:</font><br>
                        <select name="tipo_doc" id="select2">
                          <option value="">Selecionar...</option>
                          <?php do { ?>
                          <option value="<?php echo $row_documento_loop['tipo_doc']?>"><?php echo htmlspecialchars($row_documento_loop['desc_tipo_doc']); ?></option>
                          <?php } while ($row_documento_loop = mysqli_fetch_assoc($documento_result)); ?>
                        </select>
                        <br><small>Não encontrou? <a href="cadastrodoctipo.php">Crie um novo</a>.</small>
                      </div>
                    </td>
                  </tr>
                  <tr> 
                    <td height="13"><div align="center">Assunto:<br><textarea name="assunto" cols="60" rows="2"></textarea></div></td>
                  </tr>
                  <tr> 
                    <td height="13"><div align="center">Destino:<br><textarea name="destino" cols="60" rows="2"></textarea></div></td>
                  </tr>
                  <tr> 
                    <td height="13"><div align="center">Observação:<br><textarea name="obeservacao" cols="60" rows="2" id="obeservacao"></textarea></div></td>
                  </tr>
                  <tr> 
                    <td height="13"><div align="center">ELABORADO: N&atilde;o 
                        <input name="ELABORADO" type="radio" value="0" checked>
                        &nbsp;&nbsp;&nbsp;SIM 
                        <input type="radio" name="ELABORADO" value="1">
                      </div>
                    </td>
                  </tr>
                  <tr> 
                    <td height="13" bgcolor="#CCCCCC"> 
                      <div align="center"> 
                        <input type="hidden" name="data" value="<?php echo date("Y-m-d"); ?>">
                        <input type="hidden" name="ano_doc" value="<?php echo $ano_atual; ?>">
                        <input type="hidden" name="cod_sec" value="<?php echo htmlspecialchars($row_Recordset1['org_cod_secao']); ?>">
                        <input type="hidden" name="cod_org" value="<?php echo htmlspecialchars($row_Recordset1['org_id']); ?>">
                        <input type="hidden" name="elaborador" value="<?php echo htmlspecialchars($_GET['re']); ?>">
                        <input name="ASSINADO" type="hidden" value="0">
                        <input name="ENCAMINHADO" type="hidden" value="0">
                        <input name="submit" type="submit" value="Inserir Registro e Abrir Numerador">
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
<?php
mysqli_free_result($listadoc_result);
mysqli_free_result($documento_result);
mysqli_free_result($Recordset1);
// A query $numero não era necessária nesta página, foi removida.
?>