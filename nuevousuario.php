<?php include("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<html>
<head>
<title>::NUEVO USUARIO DE SISTEMA::</title>
<LINK REL=StyleSheet TYPE="text/css" HREF="estilo.css" media="screen">
<LINK rel=stylesheet 
type=text/css 
href="newsscroll.css"><LINK 
rel=stylesheet type=text/css 
href="style.css">
<LINK rel=stylesheet type=text/css 
href="template.css"><LINK 
rel=stylesheet type=text/css 
href="menu_superior.css">

<script language="JavaScript"> 
function chequear(){   

    if(recomienda.clave.value=="")   {
      alert("clave no ingresado.");   
	  return(false);} 
   					   else   if(recomienda.usuario.value=="")   {
              alert("Nombre de Usuario no ingresado.");   
	           return(false);}
			   else   if(recomienda.rol.value=="")   {
              alert("Rol no ingresado.");   
	           return(false);}
			      else   if(recomienda.sede.value=="")   {
              alert("sede no ingresado.");   
	           return(false);}
			   
					  else {
               alert("Los datos son correctos");   
               return(true);   }
  }

</script>
<SCRIPT type=text/javascript 
src="mootools.js"></SCRIPT>

<SCRIPT type=text/javascript 
src="jquery.js"></SCRIPT>

<SCRIPT type=text/javascript 
src="easySlider.js"></SCRIPT>



<SCRIPT language=javascript type=text/javascript 
src="lp.cssmenu.js"></SCRIPT>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

<style type="text/css">
.Estilo1 {font-size: 14pt}

body{ font-family:monospace;}
form{width:450px; margin:auto; background: #CCCCCC;
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{color: #666666; text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea,select{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#666666; color:rgb(255,255,255); padding:20px;}
#boton:hover{cursor:pointer;}
#tabla2{
	background: rgb(255,255,255); text-align:left; width:800px; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#999999; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;}

</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body > 
<?php require('menu.php');
?>

<br>

<div align="center">
   <BR><b class="titulo7"><h1 >NUEVO USUARIO DE SISTEMA</h1></b>

<b>NUEVO USUARIO:</b><br>
<form method="post" onSubmit="return chequear();"  action="nuevousuario.php" name="recomienda">
INGRESE NOMBRE DE USUARIO :<input type="text"  height="30" size="80" name="usuario"><br>
INGRESE CLAVE  :<input type="password"  height="30" size="80" name="clave"><br>
    ROL:   <SELECT  NAME="rol"  >
<option value="" selected disabled>Selecciona una opcion...</option>
<OPTION>ADMINISTRADOR
</SELECT>
  
   <br>
  
      
      
   <input type="Submit" id="boton"  name="enviar" value="GUARDAR"><br>
  </form> 
  

  
<?php if(isset($_POST['enviar'])) {
   // process form
if ($_POST["clave"]=="" or   $_POST["usuario"]=="" or   $_POST["rol"]==""){
echo "<b> <font color=red size='+2'>CAMPO VACIO</font></b> ";}
else{
require('conexionsql2.php');
   
   
$c_clave = trim($_POST["clave"]); 
$c_rol = $_POST["rol"]; 
$c_usuario = trim($_POST["usuario"]); 

$result55 = mysqli_query($link,"SELECT * FROM claves where usuario='$c_usuario' order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result55)){ 
    
  
      echo "<script>";
   echo "alert('NOMBRE DE USUARIO YA EXISTE')";
      echo "</script>";
    
    
} else {
  $sql = "INSERT INTO claves (usuario,clave, rol) VALUES ('$c_usuario',   '$c_clave' , '$c_rol')";
    $result = mysqli_query($link,$sql);
 echo "<script>";
   echo "alert('ALTA EXITOSA')";
      echo "</script>";
} 



}
 }
?> 
   
</div>

</body>
</html>

