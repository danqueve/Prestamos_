<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<html>
<head>
<title>::MODIFICAR CLAVE DE SISTEMA::</title>
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
   					   else   if(recomienda.anterior.value=="")   {
              alert("Clave anterior no ingresada.");   
	           return(false);}
			   else   if(recomienda.clave.value!=recomienda.clave2.value)   {
              alert("clave nueva no coincide, reingrese");   
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
h1{ color:#666666; text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
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
   <BR><b class="titulo7"><h1 >MODIFICAR CLAVE DE SISTEMA</h1></b>


<b>ESTABLECER CLAVE :</b><br>
<form method="post" onSubmit="return chequear();"  action="cambiarclave.php" name="recomienda">
INGRESE NOMBRE DE USUARIO :<input type="text"  height="30" size="80" name="usuario"><br>
INGRESE CLAVE ANTERIOR :<input type="password"  height="30" size="80" name="anterior"><br>
    INGRESE NUEVA CLAVE :<input type="password" height="30" size="80" name="clave">
 REINGRESE NUEVA CLAVE :<input type="password" height="30" size="80" name="clave2">
  <br>
  
      
      
   <input type="Submit" id="boton"  name="enviar" value="GUARDAR"><br>
  </form> 
  

  
<?php if(isset($_POST['enviar'])) {
   // process form
if ($_POST["clave"]=="" or   $_POST["anterior"]=="" or   $_POST["usuario"]==""){
echo "<b> <font color=red size='+2'>CAMPO VACIO</font></b> ";}
else{
require('conexionsql2.php');
   
   
$c_clave = $_POST["clave"]; 
$c_anterior = $_POST["anterior"]; 
$c_usuario = $_POST["usuario"]; 

$result55 = mysqli_query($link,"SELECT * FROM claves where usuario='$c_usuario' order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result55)){ 
    
   do { 
      $anterior=$row["clave"];
   } while ($row = mysqli_fetch_array($result55)); 
   echo "</table> \n"; 
} 

  if($anterior==$c_anterior){
 
$sql = "UPDATE claves SET clave='$c_clave' where usuario='$c_usuario'";   
   $result = mysqli_query($link,$sql);
     echo "<script>";
   echo "alert('MODIFICACION EXITOSA')";
      echo "</script>"; }
  else{ 
echo "<script>";
   echo "alert('CLAVE ANTERIOR INCORRECTA')";
      echo "</script>"; }
} 



}
 
?> 
  
</div>

</body>
</html>

