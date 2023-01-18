<html>
<head>
<title>::INGRESE CLAVE::</title>
<LINK REL=StyleSheet TYPE="text/css" HREF="estilo.css" media="screen">
<style type="text/css">
<!--
.Estilo1 {font-size: 14pt}
body{ font-family:monospace;}
form{width:450px; margin:auto; background: #CCCCCC;
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{color:rgb(255,255,255); text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#999999; color:rgb(255,255,255); padding:20px;}
#boton:hover{cursor:pointer;}

-->
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
<body bgcolor="#999999">

<form action="control22.php" method="POST"> 
<? if ($_GET["errorusuario"]=="si"){ ?> 
<span ><b>Datos incorrectos</b></span><BR> 
<? }else{ ?> 
<H1>INGRESE AL SISTEMA </H1><BR>
<? }?>USUARIO: 
<input  type="Text"  name="usuario"  maxlength="50" placeholder="Introduce Usuario">
<BR>
CLAVE:
<input  type="password" name="contrasena" size="8" maxlength="50" placeholder="Introduce Clave"><BR>
<input type="Submit" value="ENTRAR" id="boton">
</form> 
</body>
</html>

