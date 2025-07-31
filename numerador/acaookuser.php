<html>
<head>
<title>Numerador</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
<link  href="/numerador/public/css/Geral.css?v=1753940642" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<div align="center">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php
    // **BOA PRÁTICA:** Verifica se a org_id foi recebida e a prepara para o link.
    $org_id = isset($_GET['org_id']) ? htmlspecialchars($_GET['org_id']) : '';
  ?>
  <p>
    <a href="listauser.php?rerg=%&org_id=<?php echo $org_id; ?>"> 
      <h2>AÇÃO REALIZADA COM ÊXITO</h2> 
    </a>
  </p> 
  <p>Clique na mensagem acima para voltar à lista.</p>
  
  <font color="#000099" size="4"><strong><font color="#FFFFFF" size="1">
  <script language="JavaScript" type="text/javascript">
    function click() {
      if (event.button==2||event.button==3) {
        oncontextmenu='return false';
      }
    }
    document.onmousedown=click
    document.oncontextmenu = new Function("return false;")
  </script>
  </font></strong></font>
</div>
</body>
</html>