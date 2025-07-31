<html>
<head>
<title>Documento sem t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?
  session_start();
  session_unset();
  session_destroy();
  header("Location: login.php");
?>
<?
setcookie("login","",time()-3600);
setcookie("senha","",time()-3600);
?>
<script language="JavaScript">
           		location.href="login.php"
	   	 	    </script> 
</body>
</html>
