<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>WEB CPI-2</title>
<link rel="icon" href="gifs/favicon.png" type="image/png">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script> var repeat=1 // 0 para rolar uma vez, 1 para rolar infinitamente
var title=document.title
var leng=title.length
var start=1
function titlemove() {
titl=title.substring(start, leng) + title.substring(0, start)
document.title=titl
start++
if (start==leng+1) {
start=0
if (repeat==0)
return
}
setTimeout("titlemove()",300)  // aqui vc pode aumentar ou diminuir a velocidade 
}
if (document.title)
titlemove()
          </script>
</head>

<frameset rows="11,*" cols="*" framespacing="0" frameborder="NO" border="0">
  <frame  src="topog.htm"name="topFrame" scrolling="NO" noresize >
  <frame  src="../logar/verificar.php" name="webcpi2">
</frameset>
<noframes><body>

</body></noframes>
</html>
