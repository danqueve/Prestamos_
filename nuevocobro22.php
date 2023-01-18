<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require('conexionsql2.php');
    ?>
<html>
<head>
<title>::NUEVO COBRO LIBRE::</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<LINK REL=StyleSheet TYPE="text/css" HREF="estilo.css" media="screen">
<LINK rel=stylesheet type=text/css href="newsscroll.css">
<LINK rel=stylesheet type=text/css href="style.css">
<LINK rel=stylesheet type=text/css href="template.css">
<LINK rel=stylesheet type=text/css  href="menu_superior.css">

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<link href="css/jqueryui.css" type="text/css" rel="stylesheet"/>
<script>
  $(document).ready(function(){
   	 $("#dni").focusout(function(){
      $.ajax({
            url:'codej2.php',
          type:'POST',
          dataType:'json',
          data:{ code:$('#dni').val()}
      }).done(function(respuesta){
          $("#apellido").val(respuesta.apellido);
          $("#nombre").val(respuesta.nombre);
		   $("#direccion").val(respuesta.direccion);
		    $("#idcliente").val(respuesta.idc);
			
      });
    });
});
</script>





<script>

function agregarcliente(){
window.open('paginacliente.php','','width=1020,height=600');}
</script>

<script>


function finalizar(){



var fecha = document.recomienda.fecha.value;
var idcliente = document.recomienda.idcliente.value;
var apellido = document.recomienda.apellido.value;
var nombre = document.recomienda.nombre.value;
var direccion = document.recomienda.direccion.value;
var dni = document.recomienda.dni.value;
var comprobante = document.recomienda.comprobante.value;
var detalle = document.recomienda.detalle.value;
var importe = document.recomienda.importe.value;
var tipo = document.recomienda.tipo.value;
var periodo = document.recomienda.periodo.value;
var cadenadni = document.recomienda.dni.value; 
	
	
	
var cadena = "cargarventacontado22.php?comprobante="+comprobante+"&detalle="+detalle+"&fecha="+fecha+"&idcliente="+idcliente+"&importe="+importe+"&tipo="+tipo+"&periodo="+periodo+"&apellido="+apellido+"&nombre="+nombre+"&direccion="+direccion+"&dni="+dni;


var sibandera = 1;

if(document.recomienda.fecha.value == ""){
sibandera= 2;
}
if(document.recomienda.importe.value == ""){
sibandera= 0;
}
if(document.recomienda.dni.value == "" || document.recomienda.apellido.value == "" || document.recomienda.nombre.value == "" ){
sibandera= 3;
}
if(cadenadni.indexOf('.') ==-1){
sibandera= 4;
}
			    
			                         			   					  
					 

if (sibandera==1){



pagina=cadena;
window.open(pagina,'','width=1020,height=600');
setTimeout("location.href='nuevocobro22.php'", 5000);

}else
{
if(sibandera==0){
alert("MES/IMPORTE no ingresado ");}
if(sibandera==2){
alert("FECHA no ingresada");}
if(sibandera==3){
alert("Cliente no ingresado");}
if(sibandera==4){
alert("ingresar DNI con puntos");}

}
}




</script>

<script>




function mostrar(){
document.recomienda2.Submit3.style.display = '';

}
</script>
<script language="JavaScript"> 
function chequear(){   
cadena = recomienda.dni.value; 
     if(recomienda.dni.value=="")   {
              alert("CONTRIBUYENTE NO INGRESADO");
	           return(false);}   
			   else   if(recomienda.comprobante.value=="" || recomienda.comprobante.value=="0"){
alert("debe ingresar un comprobante");
return(false);
}
			 
			   else   if(cadena.indexOf('.') ==-1){
alert("ingresar el dni con puntos");
return(false);
}
			    
			                         			   					  
					  else {
                           return(true);   }
  }

</script>




<SCRIPT language=javascript type=text/javascript 
src="lp.cssmenu.js"></SCRIPT>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

<style type="text/css">
<!--
.Estilo1 {font-size: 14pt}
-->
</style>
<style type="text/css">
<!--
.Estilo1 {font-size: 14pt}
.claseinput { width:140px;}
.claseinput22 { width:180px;}
.claseinput2 { width:100px;}
body{ font-family:monospace;}
form{width:600px; margin:auto; background: rgb(153,153,153);
padding:8px 18px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{ color:#FFFFFF; text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea, select{ width:50px; margin-bottom:20px; padding:6px; box-sizing:border-box; font-size:14px; border:none; height:30px;}
#boton{ width:100px;background:#666666; color:rgb(255,255,255); padding:20px;}
#boton2{ width:250px;background:#666666; color:rgb(255,255,255); padding:20px;}
#entrada{width:120px;}
#entrada1{width:60px;}
#entrada2{width:160px;}
#entrada3{width:260px;}
#boton:hover{cursor:pointer;}
#boton2:hover{cursor:pointer;}
#tabla2{
	background: rgb(255,255,255); text-align:left; width:600px; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#246355; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;
		
		}
#apDiv1 {
	position: absolute;
	width: 45%;
	height: 332px;
	
	left: 2px;
	top: 60px;
}
#apDiv2 {
	position: absolute;
	width: 55%;
	height: 485px;
	z-index: 1001;
	left: 670px;
	top: 135px;
}

-->
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

</head>

<body  bgcolor="#666666"> 

<?php require('menu.php');
?>


<?php require('conexionsql2.php');
$result14 = mysqli_query($link,"SELECT comprobante  FROM cobros2 order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result14)){ 
 do { 
   $compro=   $row["comprobante"] + 1;
   } while ($row = mysqli_fetch_array($result14)); 

}else{
$compro=1;
}



?>

<form method="post"   action="" name="recomienda" id="recomienda">
       
        DNI:<input  class="claseinput2"    name="dni" size="15" type="text" id="dni" >APELLIDO: <input class="claseinput"   name="apellido"  size="45" type="text" id="apellido"  >
       NOMBRE: <input  class="claseinput" name="nombre"   size="15" type="text" id="nombre" >
     <br>    DIRECCION:   <input   class="claseinput" name="direccion"  size="15" type="text" id="direccion" ><input   readonly="readonly" style="display: none;"  name="idcliente"  size="5" type="text" id="idcliente" readonly> FECHA:<input class="claseinput2" <?php echo "value=". date("d-m-Y"); ?> size="10"  id="fecha" type="text"  name="fecha" title="DD-MM-YYYY"  >
  IMPORTE: <input    class="claseinput2" name="importe"  size="15" type="text" id="importe"  >
 <BR> DETALLE: <input   class="claseinput" name="detalle"  size="15" type="text" id="detalle"  >
  COMPROBANTE: <input <?php echo "value=". $compro; ?>   class="claseinput2" name="comprobante"  size="15" type="text" id="comprobante"  >
<BR> 
  TIPO: <input   class="claseinput" name="tipo"  size="15" type="text" id="tipo"  >



PERIODO PAGO: <input   class="claseinput2" name="periodo"  size="15" type="text" id="periodo"  >
  <BR>

   <input type="button"  id="boton2" name="Submit2" value="GUARDAR COBRO E IMPRIMIR" onClick="finalizar()"><BR>
    
  </form> 
 

  







</body>

</html>

