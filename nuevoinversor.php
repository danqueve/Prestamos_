<?php include ("seguridad.php");?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>::AGREGAR NUEVO INVERSOR::</title>
<LINK REL=StyleSheet TYPE="text/css" HREF="estilo.css" media="screen">
<LINK rel=stylesheet 
type=text/css 
href="newsscroll.css"><LINK 
rel=stylesheet type=text/css 
href="style.css">
<script type="text/javascript" src="funcionesinversor.js"></script>
<script language=javascript type=text/javascript>
function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey;
</script>


<script language="JavaScript"> 
function chequear(){  
cadena = recomienda.dni.value;
    if(recomienda.apellido.value=="")   {
      alert("apellido no ingresado.");   
	  return(false);}
	    else   if(recomienda.nombre.value=="")   {
              alert("nombre no ingresado.");   
	           return(false);}
			    else   if(cadena.indexOf('.') ==-1){
alert("ingresar el dni con puntos");
return(false);
}
			   
								  else {
                              return(true);   }
  }

</script>

<SCRIPT type=text/javascript 
src="mootools.js"></SCRIPT>

<SCRIPT type=text/javascript 
src="jquery.js"></SCRIPT>

<SCRIPT type=text/javascript 
src="easySlider.js"></SCRIPT>


<LINK rel=stylesheet type=text/css 
href="template.css"><LINK 
rel=stylesheet type=text/css 
href="menu_superior.css">
<SCRIPT language=javascript type=text/javascript 
src="lp.cssmenu.js"></SCRIPT>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

<style type="text/css">
<!--
.Estilo1 {font-size: 14pt}
body{ font-family:monospace;}
form{width:500px; margin:auto; background: rgb(153,153,153);
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{color: rgb(0,0,0); text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea, select{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none; height:30px;}
#boton{ width:120px;background:#31384A; color:rgb(255,255,255); padding:20px;}
#boton:hover{cursor:pointer;}
#tabla{
	background: rgb(255,255,255); text-align:left; width:600px; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#246355; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;
		
		}
#apDiv1 {
	position: absolute;
	width: 40%;
	height: 332px;
	
	left: 2px;
	top: 60px;
}
#apDiv2 {
	position: absolute;
	width: 60%;
	height: 485px;
	
	left: 514px;
	top: 135px;
}
-->
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
<body  bgcolor="#999999">


<?
require('menu.php');
?>

<div id="apDiv1"><h1 >AGREGAR INVERSOR</h1>
  
<form method="post" onSubmit="return chequear();"  action="nuevoinversor.php" name="recomienda">
     APELLIDO:<input type="Text"  onKeyUp="buscarDato(); return false"  name="apellido" placeholder="Ingrese apellido">

   NOMBRE   :<input type="Text"  name="nombre" placeholder="Ingrese nombre"> <br />
   DNI   :<input type="Text"  name="dni" placeholder="Ingrese dni">
              DIRECCION   :<input type="Text"  name="direccion" placeholder="Ingrese direccion">  
                       TELEFONO   :<input type="Text"  name="telefono" placeholder="Ingrese telefono">  
                     REFERENCIA   :<input type="Text"  name="referencia" placeholder="Ingrese Nombre Referencia"> 
                     TELEFONO REF.  :<input type="Text"  name="telefonoref" placeholder="Ingrese telefono referencia">     
                               RELACION  :<input type="Text"  name="relacion" placeholder="Ingrese Relacion con referencia">   
                OBSERVACION  :<input type="Text"  name="observacion" placeholder="Ingrese Observacion">
   <input type="Submit"  name="enviar" value="GUARDAR" id="boton"><br>
</form> </div> 

  
<div id="apDiv2"><div id="resultado"></div>
<? 
	 	

if(isset($_POST['enviar'])) {
   // process form
if (strtoupper($_POST["apellido"])==""  or strtoupper($_POST["nombre"])=="" ){
echo " <h1>CAMPOS VACIOS</font></h1> ";}
else{
require('conexionsql.php');
   
   
$c_nombre = mb_strtolower(trim($_POST["nombre"]),'UTF-8'); 
$c_apellido = mb_strtolower(trim($_POST["apellido"]),'UTF-8');
$c_referencia = mb_strtolower(trim($_POST["referencia"]),'UTF-8');
$c_relacion = mb_strtolower(trim($_POST["relacion"]),'UTF-8');
$c_telefonoref = mb_strtolower(trim($_POST["telefonoref"]),'UTF-8');
$c_observacion = mb_strtolower(trim($_POST["observacion"]),'UTF-8');
$c_dni = strtoupper(trim($_POST["dni"]));
$c_direccion = mb_strtolower(trim($_POST["direccion"]),'UTF-8');
$c_telefono = strtoupper(trim($_POST["telefono"]));
  
   $sql = "INSERT INTO inversores (apellido, nombre, dni, direccion, telefono, referencia, telefonoref, relacion,edad) VALUES ('$c_apellido',   '$c_nombre','$c_dni','$c_direccion','$c_telefono','$c_referencia','$c_telefonoref','$c_relacion','$c_observacion' )";
   $result = mysql_query($sql);
   echo "<h1>REGISTRO EXITOSO DE INVERSOR</h1>";
   ?>


<?php
   
    echo "<h1>DATOS DEL INVERSOR</h1>";
  
require('conexionsql.php');
$result = mysql_query("SELECT * FROM inversores order by id desc limit 1", $link); 
if ($row = mysql_fetch_array($result)){ 
   echo "<center><table id='tabla'><thead> \n"; 
   echo "<tr ><th>ID</th><th >APELLIDO</th><th >NOMBRE</th><th >DNI</th><th >DIRECCION</th><th >TELEFONO</th><th >REFERENCIA</th><th >TEL. REF</th><th >RELACION</th><th >OBSERVACION</th></tr></thead> \n"; 
   do { 
      echo "<tr><td>".$row["id"]."</td><td>".mb_strtoupper(trim($row["apellido"]),'UTF-8')."</td><td>".mb_strtoupper(trim($row["nombre"]),'UTF-8')."</td>
	 <td>".$row["dni"]."</td>  <td>".mb_strtoupper(trim($row["direccion"]),'UTF-8')."</td>  <td>".$row["telefono"]."</td>  <td>".mb_strtoupper(trim($row["referencia"]),'UTF-8')."</td><td>".$row["telefonoref"]."</td><td>".mb_strtoupper(trim($row["relacion"]),'UTF-8')."</td><td>".mb_strtoupper(trim($row["edad"]),'UTF-8')."</td></tr> \n"; 
   } while ($row = mysql_fetch_array($result)); 
   echo "</table></center> \n"; 
} else { 
echo "¡ No se ha encontrado ningún registro !"; }


} 



}
 
?> 

</div> 


  


</div>
</td></tr></table>
</body>
</html>

