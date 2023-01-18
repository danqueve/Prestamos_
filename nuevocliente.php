<?php include("seguridad.php");?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>::AGREGAR NUEVO CLIENTE::</title>
<LINK REL=StyleSheet TYPE="text/css" HREF="estilo.css" media="screen">
<LINK rel=stylesheet 
type=text/css 
href="newsscroll.css"><LINK 
rel=stylesheet type=text/css 
href="style.css">
<script type="text/javascript" src="funciones.js"></script>
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
var mensaje=recomienda.fechanac.value;
mensaje=mensaje.trim();  
cadena = recomienda.dni.value;
    if(recomienda.apellido.value=="")   {
      alert("apellido no ingresado.");   
	  return(false);}
	    else   if(recomienda.nombre.value=="")   {
              alert("nombre no ingresado.");   
	           return(false);}
			     else   if(recomienda.limite.value=="0")   {
              alert("limite no ingresado.");   
	           return(false);}
			   else   if(recomienda.limite.value=="")   {
              alert("limite no ingresado.");   
	           return(false);}
			   
			    else  if(mensaje.indexOf('/') >=0 ) {
              alert("LAS FECHAS DEBEN SER EN FORMATO DIA-MES-AÑO EJEMPLO 10-05-2018");   
	           return(false);}
			    else   if(cadena.indexOf('.') ==-1){
alert("ingresar el dni con puntos");
return(false);
}else {
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
body{ font-family:monospace; color: #000000}
.claseinputm { width:120px;}
.claseinputg { width:200px;}
.claseinputxg { width:240px;}
.claseinputc { width:110px;}
form{width:700px; margin:auto; background: rgb(153,153,153);
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{ color:#999999; text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea, select{ width:140px; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none; height:30px;}
#boton{ width:220px;background: #666666; color:rgb(255,255,255); padding:20px;}
#boton:hover{cursor:pointer;}
#tabla{
	background: rgb(255,255,255); text-align:left; width:400px; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#246355; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;
		
		}
#apDiv1 {
	position: absolute;
	width: 50%;
	height: 332px;
	
	left: 2px;
	top: 60px;
}
#apDiv2 {
	position: absolute;
	width: 50%;
	height: 485px;
	
	left: 650px;
	top: 135px;
}
-->
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
<body  bgcolor="#999999">


<?php
require('menu.php');
require('conexionsql2.php');
$result14 = mysqli_query($link,"SELECT *  FROM datos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result14)){ 
 do { 
   $c_limite=   $row["trespagos"];
   } while ($row = mysqli_fetch_array($result14)); 

}
?>

<div id="apDiv1"><h1 >AGREGAR CLIENTE</h1>
  
<form method="post" onSubmit="return chequear();"  action="nuevocliente.php" name="recomienda">
     APELLIDO:<input type="Text" class="claseinputg" onKeyUp="buscarDato(); return false"  name="apellido" placeholder="Ingrese apellido">

   NOMBRE:<input type="Text"  class="claseinputg" name="nombre" placeholder="Ingrese nombre"> 
   DNI:<input type="Text" class="claseinputc" name="dni" placeholder="Ingrese dni">
              <br>  ESTADO CIVIL:<input type="Text" class="claseinputc" name="estadocivil" placeholder="Ingrese estado civil">
               FECHA NAC:<input type="Text" class="claseinputc" name="fechanac" placeholder="Ingrese fecha nac.">
                                     TELEFONO:<input type="Text" class="claseinputm"  name="telefono" placeholder="Ingrese telefono"><br>
                                     CELULAR:<input type="Text" class="claseinputm"  name="celular" placeholder="Ingrese celular">
                        EMAIL:<input type="Text"  class="claseinputxg" name="email" placeholder="Ingrese email">              <br>
                       DIRECCION:<input type="Text" class="claseinputg" name="direccion" placeholder="Ingrese direccion">  
                         ENTRE CALLES:<input type="Text" class="claseinputg" name="entrecalles" placeholder="Ingrese entre calles">  <br>
                    <br>CIUDAD:<input type="Text" class="claseinputg"  name="ciudad" placeholder="Ingrese ciudad">
                    CP:<input type="Text" class="claseinputc"  name="cp" placeholder="Ingrese cod. postal">
                    PROVINCIA:<input type="Text" class="claseinputg"  name="provincia" placeholder="Ingrese provincia"><br>
                    <br>                       
                OBSERVACION:<input type="Text" class="claseinputxg"  name="observacion" placeholder="Ingrese Observacion">LIMITE:<input type="Text" class="claseinputxg"  name="limite"    placeholder="Ingrese Limite de dinero" <?php echo "value='$c_limite'";  ?>>
                <br>SUELDO:<input type="Text" class="claseinputm" name="sueldo" placeholder="Ingrese sueldo"> 
                EMPRESA/INSTITUCION:<input type="Text" class="claseinputg" name="trabajo" placeholder="Ingrese empresa o institucion"> 
               <br>  DIRECCION EMP:<input type="Text" class="claseinputg" name="direccione" placeholder="Ingrese direccion empresa"> 
                  CIUDAD EMP:<input type="Text" class="claseinputg" name="ciudade" placeholder="Ingrese ciudad empresa"> 
              <br>  TEL TRABAJO 1:<input type="Text" class="claseinputm" name="telefonotrabajo" placeholder="Ingrese telefono laboral"> 
                TEL TRABAJO 2:<input type="Text" class="claseinputm" name="telefono2" placeholder="Ingrese segundo telefono laboral"> 
                INTERNO:<input type="Text" class="claseinputm" name="interno" placeholder="Ingrese interno"> 
                <br> 
                
                
             
   <input type="Submit"  name="enviar" value="GUARDAR" id="boton" class="button"><br>
</form> </div> 

  
<div id="apDiv2"><div id="resultado"></div>
<?php
	 	

if(isset($_POST['enviar'])) {
   // process form
if (strtoupper($_POST["apellido"])==""  or strtoupper($_POST["nombre"])=="" ){
echo " <h1>CAMPOS VACIOS</font></h1> ";}
else{
require('conexionsql2.php');
   
   
$c_nombre = mb_strtolower(trim($_POST["nombre"]),'UTF-8'); 
$c_apellido = mb_strtolower(trim($_POST["apellido"]),'UTF-8');
$c_ciudad = mb_strtolower(trim($_POST["ciudad"]),'UTF-8');
$c_cp = mb_strtolower(trim($_POST["cp"]),'UTF-8');
$c_provincia = mb_strtolower(trim($_POST["provincia"]),'UTF-8'); 
$c_estadocivil = mb_strtolower(trim($_POST["estadocivil"]),'UTF-8');
$c_email = mb_strtolower(trim($_POST["email"]),'UTF-8'); 
$c_fechanac = trim($_POST["fechanac"]);
$c_limite = trim($_POST["limite"]);
$c_fechanacsql= trim(substr($c_fechanac,6,4)."-".substr($c_fechanac,3,2)."-".substr($c_fechanac,0,2));
$c_celular = mb_strtolower(trim($_POST["celular"]),'UTF-8');
$c_entrecalles = mb_strtolower(trim($_POST["entrecalles"]),'UTF-8');
$c_observacion = mb_strtolower(trim($_POST["observacion"]),'UTF-8');
$c_dni = strtoupper(trim($_POST["dni"]));
$c_direccion = mb_strtolower(trim($_POST["direccion"]),'UTF-8');
$c_telefono = strtoupper(trim($_POST["telefono"]));
$c_sueldo = trim($_POST["sueldo"]);
$c_trabajo = trim($_POST["trabajo"]);
$c_direccione = trim($_POST["direccione"]);
$c_ciudade = trim($_POST["ciudade"]);
$c_telefonotrabajo = trim($_POST["telefonotrabajo"]);
$c_telefono2 = trim($_POST["telefono2"]);
$c_interno = trim($_POST["interno"]);
  
   $sql = "INSERT INTO clientes (apellido, nombre, dni, direccion, telefono, entrecalles, cp, celular,observacion,ciudad,provincia,email,fechanac,fechanacsql,estadocivil,limite,sueldo,trabajo,telefonotrabajo,telefono2,direccione,ciudade,interno) VALUES ('$c_apellido',   '$c_nombre','$c_dni','$c_direccion','$c_telefono','$c_entrecalles','$c_cp','$c_celular','$c_observacion','$c_ciudad','$c_provincia','$c_email','$c_fechanac','$c_fechanacsql','$c_estadocivil','$c_limite','$c_sueldo','$c_trabajo','$c_telefonotrabajo','$c_telefono2','$c_direccione','$c_ciudade','$c_interno' )";
   $result = mysqli_query($link,$sql);
   echo "<h1>REGISTRO EXITOSO DE CLIENTE</h1>";
   ?>


<?php
   
    echo "<h1>DATOS DEL CLIENTE</h1>";
  
require('conexionsql2.php');
$result = mysqli_query($link,"SELECT * FROM clientes order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result)){ 
   echo "<center><table id='tabla'><thead> \n"; 
   echo "<tr ><th >APELLIDO</th><th >NOMBRE</th><th >DNI</th><th >DIRECCION</th><th >TELEFONO</th></tr></thead> \n"; 
   do { 
      echo "<tr><td>".mb_strtoupper(trim($row["apellido"]),'UTF-8')."</td><td>".mb_strtoupper(trim($row["nombre"]),'UTF-8')."</td>
	 <td>".$row["dni"]."</td>  <td>".mb_strtoupper(trim($row["direccion"]),'UTF-8')."</td>  <td>".$row["telefono"]."</td>  </tr> \n"; 
   } while ($row = mysqli_fetch_array($result)); 
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

