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
form{width:1050px; margin:auto; background: #888888;
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

function agregarcliente(){
window.open('paginacliente.php','','width=1020,height=600');}
</script>

<script>
function contrato(){
var apellido = document.form1.apellido.value;
var nombre = document.form1.nombre.value;
var direccion = document.form1.direccion.value;
var tipo = document.form1.tipo.value;
var numcuota = parseInt(document.form1.cuotas.value);
var salvador=document.form1.salvador.value;
var monto = 0;
var fechainicio = document.form1.fecha.value;
var fechaprestamo = document.form1.fechap.value;
var dni = document.form1.dni.value;
if(numcuota!=1){
for(x=0; x < numcuota; x++){
monto=parseInt(monto) + parseInt(document.form1.importe[x].value);
}
} else{
monto=parseInt(salvador);
}


window.open("contrato.php?apellido="+apellido+"&nombre="+nombre+"&direccion="+direccion+"&tipo="+tipo+"&cuotas="+numcuota+"&dni="+dni+"&fecha="+fechainicio+"&fechaprestamo="+fechaprestamo+"&monto="+monto,'','width=1020,height=600');}
</script>
<script>

function cambiarcuota(){
var numcuota = parseInt(document.form1.cuotas.value);
var importec=parseInt(document.form1.importecambio.value);
document.form1.salvador.value=importec;
document.form1.importe.value=importec;
for(x=0; x < numcuota; x++){
document.form1.importe[x].value=importec;
}
}
</script>

<script>
function pagare(){
var apellido = document.form1.apellido.value;
var nombre = document.form1.nombre.value;
var direccion = document.form1.direccion.value;
var idcliente = document.form1.idcliente.value;
var tipo = document.form1.tipo.value;
var numcuota = parseInt(document.form1.cuotas.value);
var salvador=document.form1.salvador.value;
var monto = 0;
var fechainicio = document.form1.fecha.value;
var fechaprestamo = document.form1.fechap.value;
var dni = document.form1.dni.value;
if(numcuota!=1){
for(x=0; x < numcuota; x++){
monto=parseInt(monto) + parseInt(document.form1.importe[x].value);
}
} else{
monto=parseInt(salvador);
}
window.open("contrato24.php?idcliente="+idcliente+"&fecha="+fechainicio+"&fechaprestamo="+fechaprestamo+"&monto="+monto,'','width=1020,height=600');}
</script>

<script>
function finalizar(){
document.form1.confirmar.disabled = 'true';
var fechainicio = document.form1.fecha.value;
var idcliente = document.form1.idcliente.value;
var apellido = document.form1.apellido.value;
var nombre = document.form1.nombre.value;
var fechap = document.form1.fechap.value;
var direccion = document.form1.direccion.value;
var producto = document.form1.producto.value;
var observ = document.form1.observ.value;
var vendedor = document.form1.vendedor.value;
var dni = document.form1.dni.value;
var numcuota = parseInt(document.form1.cuotas.value);
var monto = document.form1.monto.value;
var interes = document.form1.interes.value;
var salvador = document.form1.salvador.value;
var cadena = "cargarprestamo.php?cuota="+numcuota+"&idcliente="+idcliente+"&monto="+monto+"&interes="+interes+"&fechainicial="+fechainicio+"&fechap="+fechap+"&producto="+producto+"&observ="+observ+"&vendedor="+vendedor;

if(numcuota!=1){
var cadena2 = "&";

var sibandera = 0;
var final = 0;
for(x=0; x < numcuota; x++){
if(document.form1.importe[x].value!="" && document.form1.fechacuota[x].value!=""){
	final=parseInt(final)+parseInt(document.form1.importe[x].value);
sibandera= 1;
}else{
sibandera= 0;
break;
}
}
if(document.form1.fecha.value == ""){
sibandera= 2;
}
if(document.form1.idcliente.value == ""){
sibandera= 3;
}
if(document.form1.monto.value == ""){
sibandera= 5;
}

if(parseInt(document.form1.monto.value) > parseInt(document.form1.limite.value)){
sibandera= 6;
}

if (sibandera==1){

for(x=0; x < numcuota; x++){

cadena = cadena + cadena2 +  "vimporte" + x  + "=" + document.form1.importe[x].value +  "&vfecha" + x  + "=" + document.form1.fechacuota[x].value +  "&vcuota" + x  + "=" + document.form1.cuotanum[x].value;}
pagina=cadena+ cadena2 +  "final="+final;
  
window.open(pagina,'','width=1020,height=600');

 window.location.href = window.location.href;

}else
{
if(sibandera==0){
alert("FECHA DE CUOTA/IMPORTE no ingresado ");}
if(sibandera==2){
alert("FECHA INICIAL no ingresada");}
if(sibandera==3){
alert("CLIENTE NO SELECCIONADO");}
if(sibandera==5){
alert("IMPORTE INICIAL no ingresado");}
if(sibandera==6){
alert("MONTO SUPERA LIMITE DEL CLIENTE");}
}
}else{


var cadena = "cargarprestamo.php?cuota="+numcuota+"&idcliente="+idcliente+"&monto="+monto+"&interes="+interes+"&fechainicial="+fechainicio+"&fechap="+fechap+"&producto="+producto+  "&vimporte0=" + salvador +  "&vfecha0=" + fechainicio +  "&vcuota0=1" +  "&final=" + salvador+"&observ="+observ+"&vendedor="+vendedor;

window.open(cadena,'','width=1020,height=600');
 window.location.href = window.location.href;

}

}




</script>


<title>::NUEVO PRESTAMO::</title>
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
   <B class="titulo7"><h1>NUEVO PRESTAMO</h1></B>
<?php require('conexionsql2.php');

$result14 = mysqli_query($link,"SELECT *  FROM datos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result14)){ 
 do { 
   $c_interes=   $row["interes"];
   } while ($row = mysqli_fetch_array($result14)); 

}
$result14 = mysqli_query($link,"SELECT `AUTO_INCREMENT`
FROM  INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'u335739870_amigos'
AND   TABLE_NAME   = 'prestamos';"); 
if ($row = mysqli_fetch_array($result14)){ 
 do { 
   $c_prestamo=   $row["AUTO_INCREMENT"];
   } while ($row = mysqli_fetch_array($result14)); 

}

 if(!empty($_POST['calcular'])) {
	 $c_nombre = strtoupper(trim($_POST["nombre"])); 
	 	  $c_id = strtoupper(trim($_POST["idcliente"])); 
	  $c_apellido = strtoupper(trim($_POST["apellido"])); 
	  $c_fecha=strtoupper(trim($_POST["fecha"])); 
	    $c_fechap=strtoupper(trim($_POST["fechap"])); 
	  $c_dni = strtoupper(trim($_POST["dni"])); 
	  $c_direccion = strtoupper(trim($_POST["direccion"])); 
	  	  $c_producto = strtoupper(trim($_POST["producto"]));
		   $c_observ = strtoupper(trim($_POST["observ"]));
	  $c_telefono = strtoupper(trim($_POST["telefono"])); 
	  	    $c_interesnuevo = strtoupper(trim($_POST["interes"]));
			$c_monto = strtoupper(trim($_POST["monto"]));
		 $c_cuotas = (int)(trim($_POST["cuotas"]));
		 $c_limite = (int)(trim($_POST["limite"]));
	   $c_tipo = strtoupper(trim($_POST["tipo"]));
	 $c_vendedor = strtoupper(trim($_POST["vendedor"]));
	 
	 require('conexionsql2.php');
	 $vencidas='falso';
$result143 = mysqli_query($link,"SELECT (DATEDIFF( now(),fechasql)) as dias,idcliente, estado from cuotas  where idcliente=".$c_id." and estado='ADEUDADA' order by id asc "); 
if ($row = mysqli_fetch_array($result143)){ 
 do { 
   if( $row["dias"]>0) {
   $vencidas='verdadero';
   
   
  
   
   
   }

   } while ($row = mysqli_fetch_array($result143)); 
   
   if($vencidas=='verdadero'){
   ?>
 <script type="text/javascript">
window.alert("EL CLIENTE ADEUDA CUOTAS. SOLO USUARIO TIPO ADMINISTRADOR PUEDE FINANCIARLO. VERIFICAR");
<?php if($_SESSION['rol']=="INVITADO"){ ?> 

window.location.href = window.location.href;
 <?php } ?>
</script>



  
  <?php }
   

}
	 
	 
	 
	 
  }
?>



 <form name="form1" method="post" action="nuevoprestamo.php">    
 
      <table align="center"><tr><td>APELLIDO</td> <td>NOMBRE</td><td>DNI</td><TD>DIRECCION</TD><TD>TELEFONO</TD><TD></TD><TD></TD></TR>
      <TR><TD> <input readonly="readonly"  name="apellido" <?php if ($c_apellido!="")
{echo "value='".$c_apellido."'"; } ?>  size="15" type="text" id="apellido" readonly><input readonly="readonly" style="display: none;" name="limite" <?php if ($c_limite!="")
{echo "value='".$c_limite."'"; } ?>  size="15" type="text" id="limite" readonly></TD>
       <TD> <input readonly="readonly" name="nombre" <?php if ($c_nombre!="")
{echo "value='".$c_nombre."'"; } ?>  size="15" type="text" id="nombre" readonly></TD>
      <TD> <input <?php if ($c_dni!="")
{echo "value='".$c_dni."'"; } ?>  readonly="readonly" name="dni" size="15" type="text" id="dni" readonly></TD>
      <TD> <input readonly="readonly" name="direccion" <?php if ($c_direccion!="")
{echo "value='".$c_direccion."'"; } ?>  size="15" type="text" id="direccion" readonly></TD>
      <TD> <input readonly="readonly" name="telefono" <?php if ($c_telefono!="")
{echo "value='".$c_telefono."'"; } ?>  size="15" type="text" id="telefono" readonly></TD>
          <TD> <input readonly="readonly" style="display: none;" <?php if ($c_id!="")
{echo "value='".$c_id."'"; } ?>  name="idcliente"  size="5" type="text" id="idcliente" readonly></TD>
      <TD>  <input type="button" name="Submit3" value="Buscar Cliente" onClick="agregarcliente()"></TD>
    
      </TR></TABLE> 
      TIPO: 
  <SELECT NAME="tipo"  >
  <OPTION <?php if ($c_tipo=="MENSUAL")
{echo "selected"; }   ?> >MENSUAL
<OPTION <?php if ($c_tipo=="DIARIO")
{echo "selected"; }   ?> >DIARIO

<OPTION <?php if ($c_tipo=="QUINCENAL")
{echo "selected"; }   ?> >QUINCENAL
<OPTION <?php if ($c_tipo=="SEMANAL")
{echo "selected"; }   ?> >SEMANAL


</SELECT>
<?php $masmes22="+ 1 month";
$fechahoy=(string)date("d-m-Y");
$fechaprimerpago = date ('d-m-Y', strtotime ($masmes22, strtotime($fechahoy)));

?>
FECHA PRESTAMO:<input value=<?php if ($c_fechap!="") {echo "'".$c_fechap."'";}else{echo date("d-m-Y");}?> size="10"  type="text"  name="fechap" title="DD-MM-YYYY" >
        FECHA PRIMER PAGO:<input value=<?php if ($c_fecha!="") {echo "'".$c_fecha."'";}else{echo $fechaprimerpago;}?> size="10"  type="text"  name="fecha" title="DD-MM-YYYY" > 
        
        MONTO PRESTAMO:<input <?php if ($c_monto!="") {echo "value='".$c_monto."'";}?> size="10"  type="text"  name="monto"  > 
         NUMERO DE CUOTAS:<input <?php if ($c_cuotas!="") {echo "value='".$c_cuotas."'";}?> size="10"  type="text"  name="cuotas"  > 
     <br>  <?php if($_SESSION['rol']=="ADMINISTRADOR"){echo "INTERES ANUAL" ;}?> <input <?php if ($c_interesnuevo!="") {echo "value='".$c_interesnuevo."'";}else{ echo "value='$c_interes'";}  ?> size="10" <?php if($_SESSION['rol']=="INVITADO"){echo "style='display: none;'" ;}?>  type="text"  name="interes" > 
           
        PRODUCTO:<input <?php if ($c_producto!="") {echo "value='".$c_producto."'";}?> size="20"  type="text"  name="producto"  >  
        OBSERV:<input <?php if ($c_observ!="") {echo "value='".$c_observ."'";}?> size="20"  type="text"  name="observ"  > VENDEDOR:<input <?php if ($c_vendedor!="") {echo "value='".$c_vendedor."'";}?> size="20"  type="text"  name="vendedor"  > 
        <input readonly style="display: none;" <?php echo "value='$c_prestamo'";  ?> size="10"  type="text"  name="prestamo" > 
      
      <input  type="submit"  name="calcular" value="CALCULAR CUOTAS" >  <br><input  type="button" onClick="contrato()" style="display: none;" name="Submit4" value="IMPRIMIR CONDICIONES" >&nbsp;<input  type="button" onClick="pagare()"  name="Submit5" value="IMPRIMIR PAGARÉ" > CAMBIAR IMPORTE CUOTAS:   <input size="10"  type="text" onChange='cambiarcuota()'   name="importecambio"  > 
     

   
     <?php   if(!empty($_POST['calcular'])){
			 
			if( $_POST['apellido']=="" or $_POST['nombre']=="" or $_POST['dni']=="" or $_POST['monto']=="" or $_POST['interes']=="" or $_POST['cuotas']=="" or $_POST['cuotas']=="" or strrpos($_POST['fecha'], "/") or ($_POST['monto'] > $_POST['limite']) ){
				?>
			<script type="text/javascript">
window.alert("CAMPOS VACIOS O / EN FECHA O MONTO SUPERA EL LIMITE DEL CLIENTE");
</script><?PHP 

				
				}else{
					
	  	  if ($c_tipo=="MENSUAL"){
					
	  	    $c_interesnuevo = strtoupper(trim($_POST["interes"]));
			$c_monto = (int)(trim($_POST["monto"]));
		 $c_cuotas = strtoupper(trim($_POST["cuotas"]));
 $c_fechainicio = strtoupper(trim($_POST["fecha"]));
$c_interesnuevo=$c_interesnuevo*($c_cuotas/12);
$interesfinal=$c_monto*($c_interesnuevo/100);
$montofinal=(int)$c_monto+$interesfinal;
$montocuota=(int)$montofinal/(int)$c_cuotas;
$sqlinicio= trim(substr($c_fechainicio,6,4)."-".substr($c_fechainicio,3,2)."-".substr($c_fechainicio,0,2));

?>
 <table align="center"><tr><td>FECHA</td><td>IMPORTE</td><td>CUOTA</td></TR>
 <input style="display: none;" readonly="readonly"  <?php if ($montocuota!="")
{echo "value='".$montocuota."'"; } ?>  name="salvador"  size="5" type="text" id="salvador" readonly>
 <?php
 
$c_cuotasfor=(int)$c_cuotas;
echo "<tr><td><input name=fechacuota[]type='text'   id='fechacuota' value='".$c_fechainicio."' ></td><td><input name=importe[]type='text' readonly='readonly'  id='importe' value='".intval($montocuota)."' ></td> <td><input name=cuotanum[]type='text'   id='cuotanum' value='1' ></td> </tr>"; 
$montof=0;
			for ($e=1; $e<$c_cuotasfor; $e++) {
	$masmes="+ ".$e." month";
	$ncuota=$e+1;
$listafechasql[$e] = date ('Y-m-d', strtotime ($masmes, strtotime($sqlinicio)));
$listafecha[$e] = date ('d-m-Y', strtotime ($masmes, strtotime($sqlinicio)));
echo "<tr><td><input name=fechacuota[]type='text'   id='fechacuota' value='".$listafecha[$e]."' ></td><td><input name=importe[]type='text' readonly='readonly'   id='importe' value='".intval($montocuota)."' ></td> <td><input name=cuotanum[]type='text'  readonly id='cuotanum' value='".$ncuota."' ></td> </tr>";



}	
 
?>
   </table>
   <input  type="button" onClick="finalizar()"  name="confirmar" value="CONFIRMAR" ><BR>
   <?php	
 					
					
			 
			 } 
		
		if ($c_tipo=="DIARIO"){
					
	  	    $c_interesnuevo = strtoupper(trim($_POST["interes"]));
			$c_monto = (int)(trim($_POST["monto"]));
		 $c_cuotas = strtoupper(trim($_POST["cuotas"]));
 $c_fechainicio = strtoupper(trim($_POST["fecha"]));
$c_interesnuevo=$c_interesnuevo*(($c_cuotas/30)/12);
$interesfinal=$c_monto*($c_interesnuevo/100);
$montofinal=(int)$c_monto+$interesfinal;
$montocuota=(int)$montofinal/(int)$c_cuotas;
$sqlinicio= trim(substr($c_fechainicio,6,4)."-".substr($c_fechainicio,3,2)."-".substr($c_fechainicio,0,2));

?>
 <table align="center"><tr><td>FECHA</td><td>IMPORTE</td><td>CUOTA</td></TR>
 <input style="display: none;" readonly="readonly"  <?php if ($montocuota!="")
{echo "value='".$montocuota."'"; } ?>  name="salvador"  size="5" type="text" id="salvador" readonly>
 <?php
 
$c_cuotasfor=(int)$c_cuotas;
echo "<tr><td><input name=fechacuota[]type='text'   id='fechacuota' value='".$c_fechainicio."' ></td><td><input name=importe[]type='text'   id='importe' value='".intval($montocuota)."' ></td> <td><input name=cuotanum[]type='text'   id='cuotanum' value='1' ></td> </tr>"; 
$montof=0;
$contadorcuota=1;
			for ($e=1; $e<$c_cuotasfor; $e++) {
	$masmes="+ ".$e." day";
	$ncuota=$e+1;
	$diatexto[$e]=date ('l', strtotime ($masmes, strtotime($sqlinicio)));

$listafechasql[$e] = date ('Y-m-d', strtotime ($masmes, strtotime($sqlinicio)));
$listafecha[$e] = date ('d-m-Y', strtotime ($masmes, strtotime($sqlinicio)));
 if ($diatexto[$e]=="Sunday" or $diatexto[$e]=="Saturday"){
$c_cuotasfor=$c_cuotasfor+1;
continue;
 
 }

$contadorcuota=$contadorcuota+1;

echo "<tr><td><input name=fechacuota[]type='text'   id='fechacuota' value='".$listafecha[$e]."' ></td><td><input name=importe[]type='text'   id='importe' value='".intval($montocuota)."' ></td> <td><input name=cuotanum[]type='text'  readonly id='cuotanum' value='".$contadorcuota."' ></td> </tr>";



}	
 
?>
   </table>
   <input  type="button" onClick="finalizar()"  name="confirmar" value="CONFIRMAR" ><BR>
   <?php	
 					
					
			 
			 }	 
			 
			 
			 
			 
			 
			 
			 
			 
			 if ($c_tipo=="QUINCENAL"){
			 
			    $c_interesnuevo = strtoupper(trim($_POST["interes"]));
			$c_monto = (int)(trim($_POST["monto"]));
		 $c_cuotas = strtoupper(trim($_POST["cuotas"]));
 $c_fechainicio = strtoupper(trim($_POST["fecha"]));
$c_interesnuevo=$c_interesnuevo*(($c_cuotas/2)/12);
$interesfinal=$c_monto*($c_interesnuevo/100);
$montofinal=(int)$c_monto+$interesfinal;
$montocuota=(int)$montofinal/(int)$c_cuotas;
$sqlinicio= trim(substr($c_fechainicio,6,4)."-".substr($c_fechainicio,3,2)."-".substr($c_fechainicio,0,2));

?>
 <table align="center"><tr><td>FECHA</td><td>IMPORTE</td><td>CUOTA</td></TR>
 <input style="display: none;" readonly="readonly"  <?php if ($montocuota!="")
{echo "value='".$montocuota."'"; } ?>  name="salvador"  size="5" type="text" id="salvador" readonly>
 <?php
 
$c_cuotasfor=(int)$c_cuotas;
echo "<tr><td><input name=fechacuota[]type='text'   id='fechacuota' value='".$c_fechainicio."' ></td><td><input name=importe[]type='text'   id='importe' value='".intval($montocuota)."' ></td> <td><input name=cuotanum[]type='text'   id='cuotanum' value='1' ></td> </tr>"; 
$montof=0;
$quince=15;
			for ($e=1; $e<$c_cuotasfor; $e++) {
	$masmes="+ ".$quince." days";
	$quince=$quince+15;
	$ncuota=$e+1;
$listafechasql[$e] = date ('Y-m-d', strtotime ($masmes, strtotime($sqlinicio)));
$listafecha[$e] = date ('d-m-Y', strtotime ($masmes, strtotime($sqlinicio)));
echo "<tr><td><input name=fechacuota[]type='text'   id='fechacuota' value='".$listafecha[$e]."' ></td><td><input name=importe[]type='text'   id='importe' value='".intval($montocuota)."' ></td> <td><input name=cuotanum[]type='text'  readonly id='cuotanum' value='".$ncuota."' ></td> </tr>";



}	
 
?>
   </table>
   <input  type="button" onClick="finalizar()"  name="confirmar" value="CONFIRMAR" ><BR>
 
   
   <?php	
 					
					}
					
					
					
					 if ($c_tipo=="SEMANAL"){
			 
			    $c_interesnuevo = strtoupper(trim($_POST["interes"]));
			$c_monto = (int)(trim($_POST["monto"]));
		 $c_cuotas = strtoupper(trim($_POST["cuotas"]));
 $c_fechainicio = strtoupper(trim($_POST["fecha"]));
$c_interesnuevo=$c_interesnuevo*(($c_cuotas/4)/12);
$interesfinal=$c_monto*($c_interesnuevo/100);
$montofinal=(int)$c_monto+$interesfinal;
$montocuota=(int)$montofinal/(int)$c_cuotas;
$sqlinicio= trim(substr($c_fechainicio,6,4)."-".substr($c_fechainicio,3,2)."-".substr($c_fechainicio,0,2));

?>
 <table align="center"><tr><td>FECHA</td><td>IMPORTE</td><td>CUOTA</td></TR>
 <input style="display: none;" readonly="readonly"  <?php if ($montocuota!="")
{echo "value='".$montocuota."'"; } ?>  name="salvador"  size="5" type="text" id="salvador" readonly>
 <?php
 
$c_cuotasfor=(int)$c_cuotas;
echo "<tr><td><input name=fechacuota[]type='text'   id='fechacuota' value='".$c_fechainicio."' ></td><td><input name=importe[]type='text'   id='importe' value='".intval($montocuota)."' ></td> <td><input name=cuotanum[]type='text'   id='cuotanum' value='1' ></td> </tr>"; 
$montof=0;
$quince=7;
			for ($e=1; $e<$c_cuotasfor; $e++) {
	$masmes="+ ".$quince." days";
	$quince=$quince+7;
	$ncuota=$e+1;
$listafechasql[$e] = date ('Y-m-d', strtotime ($masmes, strtotime($sqlinicio)));
$listafecha[$e] = date ('d-m-Y', strtotime ($masmes, strtotime($sqlinicio)));
echo "<tr><td><input name=fechacuota[]type='text'   id='fechacuota' value='".$listafecha[$e]."' ></td><td><input name=importe[]type='text'   id='importe' value='".intval($montocuota)."' ></td> <td><input name=cuotanum[]type='text'  readonly id='cuotanum' value='".$ncuota."' ></td> </tr>";



}	
 
?>
   </table>
   <input  type="button" onClick="finalizar()"  name="confirmar" value="CONFIRMAR" ><BR>
   <?php	
 					
					}
					
					
 					
					}
			 
			 
			 
			 
			 }
  
  
  
   ?>
          
   
 
         
         
 
 
</form>
 
 

 

</div>

</body>
</html>

