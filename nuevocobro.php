<?PHP include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" /> 
<style type="text/css">
<!--
.Estilo1 {font-size: 14pt}
body{ font-family:monospace;}
form{width:1000px; margin:auto; background:rgba(0,0,0,0.4);
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{color:rgb(255,255,255); text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:12px; border:none;}
#inputfecha{ width:180px; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#31384A; color:rgb(255,255,255); padding:20px;}
#boton:hover{cursor:pointer;}

	
-->
</style>
<script language=javascript type=text/javascript>
function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey;
</script>




<script>
function agregar(){
var idcliente = document.form1.idcliente.value;
var apellido = document.form1.apellido.value;
var nombre = document.form1.nombre.value;
var fechacobro = document.form1.fechahoy.value;
var dni = document.form1.dni.value;
var prestamo = document.form1.prestamo.value;
if(apellido==""){
alert("SELECCIONE UN PRESTAMO");}
else{
window.open('paginacuotas.php?idcliente='+idcliente+'&prestamo='+prestamo+'&fechacobro='+fechacobro,'','width=1020,height=600');}
}

function agregarprestamo(){
for(x=0; x < 7; x++){
document.form1.cuota[x].value="";
	document.form1.importe[x].value="";
	document.form1.apagar[x].value="";
	document.form1.interesd[x].value="";
	document.form1.fecha[x].value="";
	document.form1.numcarga.value=""
	}
window.open('paginaprestamo.php','','width=1020,height=600');}


function finalizar2(){


var prestamo = document.form1.prestamo.value;
var fechahoy = document.form1.fechahoy.value;
var idcliente = document.form1.idcliente.value;
var observacion2 = document.form1.observacion2.value;
var numcargamenos = document.form1.numcarga.value - 1;
var cadena = "cargarcobro22.php?prestamo="+prestamo+"&idcliente="+idcliente+"&fecha="+fechahoy+"&numerocarga="+numcargamenos+"&observacion2="+observacion2;
var cadena2 = "&";


var sibandera = 0;
for(x=0; x < numcargamenos; x++){
if(document.form1.importe[x].value!="" && document.form1.cuota[x].value!="" && document.form1.apagar[x].value!=""){
sibandera= 1;
}else{
sibandera= 0;
break;
}
valor1=parseInt(document.form1.importe[x].value);
valor2=parseInt(document.form1.apagar[x].value);
if(valor1 >= valor2){
sibandera= 1;
}else{
sibandera= 6;
break;
}
}
if(document.form1.fechahoy.value == ""){
sibandera= 2;
}
if(document.form1.prestamo.value == 0){
sibandera= 3;
}
if(document.form1.importe[1].value != ""){
sibandera= 7;
}
if(document.form1.idcliente.value == 0){
sibandera= 5;
}
if (sibandera==1){
for(x=0; x < numcargamenos; x++){

cadena = cadena + cadena2 +  "vidcuota" + x  + "=" + document.form1.id[x].value +  "&vcuota" + x  + "=" + document.form1.cuota[x].value +  "&vimporte" + x  + "=" + document.form1.importe[x].value  +  "&vfecha" + x  + "=" + document.form1.fecha[x].value+  "&vinteresd" + x  + "=" + document.form1.interesd[x].value;}
pagina=cadena;
window.open(pagina,'','width=1020,height=600');
window.location.reload();

}else
{
if(sibandera==0){
alert("MES/IMPORTE no ingresado ");}
if(sibandera==2){
alert("FECHA no ingresada");}
if(sibandera==3){
alert("Numero FACTURA no ingresada");}
if(sibandera==5){
alert("Numero TICKET FISCAL no ingresado");}
if(sibandera==7){
alert("COBRO PARCIAL FUNCIONA SOLO CON UNA CUOTA");}
if(sibandera==6){
alert("Importe a pagar no puede ser mayor al valor de la cuota");}
}
}



function finalizar(){

document.form1.Submit2.disabled = 'true';
var prestamo = document.form1.prestamo.value;
var fechahoy = document.form1.fechahoy.value;
var idcliente = document.form1.idcliente.value;
var numcargamenos = document.form1.numcarga.value - 1;
var observacion2 = document.form1.observacion2.value;
var cobrador = document.form1.cobrador.value;
var cadena = "cargarcobro.php?prestamo="+prestamo+"&idcliente="+idcliente+"&fecha="+fechahoy+"&cobrador="+cobrador+"&numerocarga="+numcargamenos+"&observacion2="+observacion2;
var cadena2 = "&";


var sibandera = 0;
for(x=0; x < numcargamenos; x++){
if(document.form1.importe[x].value!="" && document.form1.cuota[x].value!="" && document.form1.apagar[x].value!=""){
sibandera= 1;
}else{
sibandera= 0;
break;
}
valor1=parseInt(document.form1.importe[x].value);
valor2=parseInt(document.form1.apagar[x].value);
if(valor1 >= valor2){
sibandera= 1;
}else{
sibandera= 6;
break;
}

}
if(document.form1.fechahoy.value == ""){
sibandera= 2;
}
if(document.form1.prestamo.value == 0){
sibandera= 3;
}
if(document.form1.idcliente.value == 0){
sibandera= 5;
}
if (sibandera==1){
for(x=0; x < numcargamenos; x++){

cadena = cadena + cadena2 +  "vidcuota" + x  + "=" + document.form1.id[x].value +  "&vcuota" + x  + "=" + document.form1.cuota[x].value +  "&vimporte" + x  + "=" + document.form1.importe[x].value  +  "&vapagar" + x  + "=" + document.form1.apagar[x].value +  "&vfecha" + x  + "=" + document.form1.fecha[x].value+  "&vinteresd" + x  + "=" + document.form1.interesd[x].value;}
pagina=cadena;
window.open(pagina,'','width=1020,height=600');
window.location.reload();

}else
{
if(sibandera==0){
alert("MES/IMPORTE no ingresado ");}
if(sibandera==2){
alert("FECHA no ingresada");}
if(sibandera==3){
alert("Numero FACTURA no ingresada");}
if(sibandera==5){
alert("Numero TICKET FISCAL no ingresado");}
if(sibandera==6){
alert("Importe a pagar no puede ser mayor al valor de la cuota");}
}
}


function imprimir(){


var prestamo = document.form1.prestamo.value;
var fechahoy = document.form1.fechahoy.value;
var idcliente = document.form1.idcliente.value;
var numcargamenos = document.form1.numcarga.value - 1;
var observacion2 = document.form1.observacion2.value;
var cadena = "cargarimpresion.php?prestamo="+prestamo+"&idcliente="+idcliente+"&fecha="+fechahoy+"&numerocarga="+numcargamenos+"&observacion2="+observacion2;
var cadena2 = "&";


var sibandera = 0;
for(x=0; x < numcargamenos; x++){
if(document.form1.importe[x].value!="" && document.form1.cuota[x].value!="" && document.form1.apagar[x].value!=""){
sibandera= 1;
}else{
sibandera= 0;
break;
}
valor1=parseInt(document.form1.importe[x].value);
valor2=parseInt(document.form1.apagar[x].value);
if(valor1 >= valor2){
sibandera= 1;
}else{
sibandera= 6;
break;
}

}
if(document.form1.fechahoy.value == ""){
sibandera= 2;
}
if(document.form1.prestamo.value == 0){
sibandera= 3;
}
if(document.form1.idcliente.value == 0){
sibandera= 5;
}
if (sibandera==1){
for(x=0; x < numcargamenos; x++){

cadena = cadena + cadena2 +  "vidcuota" + x  + "=" + document.form1.id[x].value +  "&vcuota" + x  + "=" + document.form1.cuota[x].value +  "&vimporte" + x  + "=" + document.form1.importe[x].value  +  "&vapagar" + x  + "=" + document.form1.apagar[x].value +  "&vfecha" + x  + "=" + document.form1.fecha[x].value+  "&vinteresd" + x  + "=" + document.form1.interesd[x].value;}
pagina=cadena;
window.open(pagina,'','width=1020,height=600');
window.location.reload();

}else
{
if(sibandera==0){
alert("MES/IMPORTE no ingresado ");}
if(sibandera==2){
alert("FECHA no ingresada");}
if(sibandera==3){
alert("Numero FACTURA no ingresada");}
if(sibandera==5){
alert("Numero TICKET FISCAL no ingresado");}
if(sibandera==6){
alert("Importe a pagar no puede ser mayor al valor de la cuota");}
}
}

</script>
<title>::COBRAR CUOTA DE PRESTAMO::</title>
<LINK REL=StyleSheet TYPE="text/css" HREF="estilo.css" media="screen">

<LINK rel=stylesheet 
type=text/css 
href="newsscroll.css"><LINK 
rel=stylesheet type=text/css 
href="style.css">


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
.Estilo2 {color: #FF0000}
-->
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
<body  >
<?php require('menu.php');
?>

<div align="center">
   <B class="titulo7"><h1>COBRO DE CUOTAS</h1></B>
<?php $bandera = $_GET["bandera"];


require('conexionsql2.php');




?>



 <form name="form1" method="post" action="">
  
 
    
     <input name="prestamo" style="display: none;"  readonly  type="text"  size="10"  id="prestamo" >  <input name="numcarga"  style="display: none;" type="text" id="numcarga"   readonly="readonly" >
            FECHA:<input value=<?php echo date("d-m-Y");?> size="10" id="fc_1324699544" type="text"  name="fechahoy" title="DD-MM-YYYY" >
 <input name="idcliente" style="display: none;" size="5" type="text" id="idcliente" readonly><input name="interes" style="display: none;"  size="15" type="text" id="interes" readonly>
      <table align="center"><tr><td>APELLIDO</td> <td>NOMBRE</td><td>DNI</td><TD>MONTO PRESTAMO</TD><TD>PRODUCTO</TD></TR>
      <TR><TD> <input  name="apellido" size="15" type="text" id="apellido" readonly></TD>
       <TD> <input name="nombre" size="15" type="text" id="nombre" readonly></TD>
      <TD> <input name="dni" size="15" type="text" id="dni" readonly></TD>
          <TD> <input name="monto" size="15" type="text" id="monto" readonly></TD>
          
           <TD> <input name="producto" size="15" type="text" id="producto" readonly></TD>
      <TD>  <input type="button" name="Submit3" value="Seleccionar Prestamo" onClick="agregarprestamo()"></TD>
    
      </TR></TABLE>
   OBSERVACION:<input name="observacion2" size="15" type="text" id="observacion2" >COBRADOR:<input name="cobrador" size="15" type="text" id="cobrador" >
      <input type="button" name="Submit" value="AGREGAR CUOTA A COBRAR" onClick="agregar()">
     
    
    <table align="center"><tr><td></td><td>CUOTA</td><td>IMP CUOTA</td><td>IMP A PAGAR</td><td>INTERES</td><td>FECHA VENCIMIENTO</td></TR>
       <TR>
       <td> <input name="id[]" style="display: none;"  type="text"   id="id" readonly></td>  
              <TD> <input name="cuota[]" size="25" type="text" id="cuota" readonly></TD>
        <TD> <input name="importe[]" size="5" type="text" id="importe" ></TD>
           <TD> <input name="apagar[]" size="15" type="text" id="apagar" ></TD>
          <TD> <input name="interesd[]" size="5" type="text" id="interesd" ></TD>
          <TD> <input name="fecha[]" size="20" type="text" id="fecha" readonly ></TD>
        </TR>
  


        <TR>
     <td> <input name="id[]" type="text" style="display: none;"  id="id" readonly></td>  
              <TD> <input name="cuota[]" size="25" type="text" id="cuota" readonly></TD>
        <TD> <input name="importe[]" size="5" type="text" id="importe" ></TD>
           <TD> <input name="apagar[]" size="15" type="text" id="apagar" ></TD>
         <TD> <input name="interesd[]" size="5" type="text" id="interesd" ></TD>
          <TD> <input name="fecha[]" size="20" type="text" id="fecha" readonly ></TD>
        
        </TR>
           <TR>
     <td> <input name="id[]" type="text"  style="display: none;"  id="id" readonly></td>  
              <TD> <input name="cuota[]" size="25" type="text" id="cuota" readonly></TD>
        <TD> <input name="importe[]" size="5" type="text" id="importe" ></TD>
           <TD> <input name="apagar[]" size="15" type="text" id="apagar" ></TD>
         <TD> <input name="interesd[]" size="5" type="text" id="interesd" ></TD>
          <TD> <input name="fecha[]" size="20" type="text" id="fecha" readonly></TD>
        
        </TR> <TR>
     <td> <input name="id[]" type="text" style="display: none;"   id="id" readonly></td>  
              <TD> <input name="cuota[]" size="25" type="text" id="cuota" readonly></TD>
        <TD> <input name="importe[]" size="5" type="text" id="importe" ></TD>
           <TD> <input name="apagar[]" size="15" type="text" id="apagar" ></TD>
         <TD> <input name="interesd[]" size="5" type="text" id="interesd" ></TD>
          <TD> <input name="fecha[]" size="20" type="text" id="fecha" readonly></TD>
        
        </TR> <TR>
     <td> <input name="id[]" type="text" style="display: none;"  id="id" readonly></td>  
              <TD> <input name="cuota[]" size="25" type="text" id="cuota" readonly></TD>
        <TD> <input name="importe[]" size="5" type="text" id="importe" ></TD>
           <TD> <input name="apagar[]" size="15" type="text" id="apagar" ></TD>
         <TD> <input name="interesd[]" size="5" type="text" id="interesd" ></TD>
          <TD> <input name="fecha[]" size="20" type="text" id="fecha" readonly ></TD>
        
        </TR>
          <TR>
     <td> <input name="id[]" type="text" style="display: none;"   id="id" readonly></td>  
              <TD> <input name="cuota[]" size="25" type="text" id="cuota" readonly></TD>
        <TD> <input name="importe[]" size="5" type="text" id="importe" ></TD>
           <TD> <input name="apagar[]" size="15" type="text" id="apagar" ></TD>
         <TD> <input name="interesd[]" size="5" type="text" id="interesd" ></TD>
          <TD> <input name="fecha[]" size="20" type="text" id="fecha" readonly></TD>
        
        </TR><TR>
     <td> <input name="id[]" type="text" style="display: none;"  id="id" readonly></td>  
              <TD> <input name="cuota[]" size="25" type="text" id="cuota" readonly></TD>
        <TD> <input name="importe[]" size="5" type="text" id="importe" ></TD>
           <TD> <input name="apagar[]" size="15" type="text" id="apagar" ></TD>
         <TD> <input name="interesd[]" size="5" type="text" id="interesd" ></TD>
          <TD> <input name="fecha[]" size="20" type="text" id="fecha" readonly ></TD>
        
        </TR><TR>
     <td> <input name="id[]" type="text"  style="display: none;"  id="id" readonly></td>  
              <TD> <input name="cuota[]" size="25" type="text" id="cuota" readonly></TD>
        <TD> <input name="importe[]" size="5" type="text" id="importe" ></TD>
           <TD> <input name="apagar[]" size="15" type="text" id="apagar" ></TD>
         <TD> <input name="interesd[]" size="5" type="text" id="interesd" ></TD>
          <TD> <input name="fecha[]" size="20" type="text" id="fecha" readonly></TD>
        
        </TR>
   
    </table>
         
        
   <input type="button" name="Submit2" value="GUARDAR PAGO E IMPRIMIR" onClick="finalizar()"> &nbsp; <input type="button" name="Submit22" value="SOLO IMPRESIÓN" onClick="imprimir()"><BR>
 
</form>
 



</div>

</body>
</html>

