<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>WEB CPI-2</title>
<link rel="icon" href="/numerador/public/gifs/favicon.png" type="image/png">
<style type="text/css">

.Style6 {font-size: 13px}

</style>
<style type="text/css">

h1{
	font-size:16px;
	color: #009;
	font-family: Arial, Helvetica, sans-serif;
   }
	   
.style3{font-family: Arial, Helvetica, sans-serif}
.style5 {
	font-size: 12px;
	font-style: italic;
	font-weight: bold;
}
.style6, p, div, td, input, select, textarea {
	font-size: 12px;
	font-style: italic;
}
body {
	margin-top: 0px;
}
.style8 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: italic;
	font-weight: bold;
}

</style>
</head>

<body background="/numerador/public/gifs/fundo01.gif">
<p>&nbsp;</p>
<p>&nbsp;</p>
<form id="form1" name="form1" method="post" action="logar.php" onSubmit="return ValidaSemPreenchimento(this)">
  <table width="52%" border="0" align="center">
    <tr> 
      <td colspan="3"><div align="center"><font color="#000099" size="4"><strong><font color="#FFFFFF" size="1"> 
          <script language="JavaScript" type="text/javascript">
function click() {
if (event.button==2||event.button==3) {
oncontextmenu='return false';
}
}
document.onmousedown=click
document.oncontextmenu = new Function("return false;")
</script>
          </font>Sistema de Numerador de Documentos<br />
          <font color="#FFFFFF" size="1">
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
          </font></strong></font></div></td>
    </tr>
    <tr> 
      <td width="51%" rowspan="5"><div align="center"><img src="/numerador/public/gifs/carimbo.gif" width="114" height="117" /></div></td>
      <td width="10%" height="32"><span class="Style6"> 
        <label> </label>
        </span></td>
      <td width="39%"><span class="Style6"> </span></td>
    </tr>
    <tr> 
      <td><span class="Style6"> <strong>Login:</strong> 
        <label> </label>
        </span></td>
      <td><span class="Style6">
        <input name="login" type="text" id="login2" autocomplete="off" style="text-transform:capitalize" onfocus="this.style.backgroundColor='#CCFF66'" onblur="this.style.backgroundColor='#ffffff'"onkeypress="javascript:retiraAcento(this);" size="15" descricao="RE" obrigatorio="1"/>
        <font color="#FF0000" size="1">( RE sem Digito)</font> </span></td>
    </tr>
    <tr> 
      <td><span class="Style6"> <strong>Senha: </strong> 
        <label><font color="#000099" size="1" face="Arial, Helvetica, sans-serif"><strong> 
        </strong></font> </label>
        </span></td>
      <td><span class="Style6">
        <input name="senha" type="password" id="senha4" size="15" style="text-transform:capitalize" onfocus="this.style.backgroundColor='#CCFF66'" onblur="this.style.backgroundColor='#ffffff'"onkeypress="javascript:retiraAcento(this);" descricao="Senha" obrigatorio="1"/>
        </span></td>
    </tr>
    <tr> 
      <td><span class="Style6"><font color="#000099" size="1" face="Arial, Helvetica, sans-serif"><strong>
        <script language="JavaScript" type="text/javascript">
function ValidaSemPreenchimento(form){
for (i=0;i<form.length;i++){
var obg = form[i].obrigatorio;
if (obg==1){
if (form[i].value == ""){
var nome = form[i].descricao
alert("O campo " + nome + " � obrigat�rio.")
form[i].focus();
return false
}
}
}
return true
}
</script>
        </strong></font></span></td>
      <td><span class="Style6">
        <input type="submit" name="Submit" value="Logar" onMouseOver="window.status='sua mensagem aqui'; return true"/>
        </span></td>
    </tr>
    <tr> 
      <td height="21">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
