<?PHP include ("seguridad.php");?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" /> 
<style type="text/css">
<!--
.Estilo1 {font-size: 14pt}
body{ font-family:monospace;}
form{width:850px; margin:auto; background:rgba(0,0,0,0.4);
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
function finalizar(){
var fechainicio = document.form1.fecha.value;
var idcliente = document.form1.idcliente.value;
var apellido = document.form1.apellido.value;
var nombre = document.form1.nombre.value;
var direccion = document.form1.direccion.value;
var producto = document.form1.producto.value;
var dni = document.form1.dni.value;
var numcuota = parseInt(document.form1.cuotas.value);
var monto = document.form1.monto.value;
var interes = document.form1.interes.value;
var cadena = "cargarprestamo.php?cuota="+numcuota+"&idcliente="+idcliente+"&monto="+monto+"&interes="+interes+"&fechainicial="+fechainicio+"&producto="+producto;
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
if (sibandera==1){

for(x=0; x < numcuota; x++){

cadena = cadena + cadena2 +  "vimporte" + x  + "=" + document.form1.importe[x].value +  "&vfecha" + x  + "=" + document.form1.fechacuota[x].value +  "&vcuota" + x  + "=" + document.form1.cuotanum[x].value;}
pagina=cadena+ cadena2 +  "final="+final  ;
  
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
<?
require('menu.php');


?>

<div align="center">
   <B class="titulo7"><h1>NUEVO PRESTAMO</h1></B>
<? 

require('conexionsql.php');

$result14 = mysql_query("SELECT *  FROM datos order by id desc limit 1", $link); 
if ($row = mysql_fetch_array($result14)){ 
 do { 
   $c_interes=   $row["interes"];
   } while ($row = mysql_fetch_array($result14)); 

}
$result14 = mysql_query("SELECT `AUTO_INCREMENT`
FROM  INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'prestamos'
AND   TABLE_NAME   = 'prestamos';", $link); 
if ($row = mysql_fetch_array($result14)){ 
 do { 
   $c_prestamo=   $row["AUTO_INCREMENT"];
   } while ($row = mysql_fetch_array($result14)); 

}

 if(!empty($_POST['calcular'])) {
	 $c_nombre = strtoupper(trim($_POST["nombre"])); 
	 	  $c_id = strtoupper(trim($_POST["idcliente"])); 
	  $c_apellido = strtoupper(trim($_POST["apellido"])); 
	  $c_fecha=strtoupper(trim($_POST["fecha"])); 
	  $c_dni = strtoupper(trim($_POST["dni"])); 
	  $c_direccion = strtoupper(trim($_POST["direccion"])); 
	  	  $c_producto = strtoupper(trim($_POST["producto"])); 
	  $c_telefono = strtoupper(trim($_POST["telefono"])); 
	  	    $c_interesnuevo = strtoupper(trim($_POST["interes"]));
			$c_monto = strtoupper(trim($_POST["monto"]));
		 $c_cuotas = strtoupper(trim($_POST["cuotas"]));
	  
	
	 
	 
	 
	 
  }
?>



 <form name="form1" method="post" action="nuevoprestamo.php">    
 
      <table align="center"><tr><td>APELLIDO</td> <td>NOMBRE</td><td>DNI</td><TD>DIRECCION</TD><TD>TELEFONO</TD><TD></TD><TD></TD></TR>
      <TR><TD> <input readonly="readonly"  name="apellido" <? if ($c_apellido!="")
{echo "value='".$c_apellido."'"; } ?>  size="15" type="text" id="apellido" readonly></TD>
       <TD> <input readonly="readonly" name="nombre" <? if ($c_nombre!="")
{echo "value='".$c_nombre."'"; } ?>  size="15" type="text" id="nombre" readonly></TD>
      <TD> <input <? if ($c_dni!="")
{echo "value='".$c_dni."'"; } ?>  readonly="readonly" name="dni" size="15" type="text" id="dni" readonly></TD>
      <TD> <input readonly="readonly" name="direccion" <? if ($c_direccion!="")
{echo "value='".$c_direccion."'"; } ?>  size="15" type="text" id="direccion" readonly></TD>
      <TD> <input readonly="readonly" name="telefono" <? if ($c_telefono!="")
{echo "value='".$c_telefono."'"; } ?>  size="15" type="text" id="telefono" readonly></TD>
          <TD> <input readonly="readonly" style="display: none;" <? if ($c_id!="")
{echo "value='".$c_id."'"; } ?>  name="idcliente"  size="5" type="text" id="idcliente" readonly></TD>
      <TD>  <input type="button" name="Submit3" value="Buscar Cliente" onClick="agregarcliente()"></TD>
    
      </TR></TABLE> 
        FECHA PRIMER PAGO:<input value=<? if ($c_fecha!="") {echo "'".$c_fecha."'";}else{echo date("d-m-Y");}?> size="10"  type="text"  name="fecha" title="DD-MM-YYYY" > 
        
        MONTO PRESTAMO:<input <? if ($c_monto!="") {echo "value='".$c_monto."'";}?> size="10"  type="text"  name="monto"  > 
         NUMERO DE CUOTAS:<input <? if ($c_cuotas!="") {echo "value='".$c_cuotas."'";}?> size="10"  type="text"  name="cuotas"  > 
        <input style="display: none;" <? if ($c_interesnuevo!="") {echo "value='".$c_interesnuevo."'";}else{ echo "value='$c_interes'";}  ?> size="10"  type="text"  name="interes" > 
           
       <br>  PRODUCTO:<input <? if ($c_producto!="") {echo "value='".$c_producto."'";}?> size="20"  type="text"  name="producto"  >  
        <input readonly style="display: none;" <?  echo "value='$c_prestamo'";  ?> size="10"  type="text"  name="prestamo" > 
      
      <input  type="submit"  name="calcular" value="CALCULAR CUOTAS" >
     

   
     <?php   if(!empty($_POST['calcular'])){
			 
			if( $_POST['apellido']=="" or $_POST['nombre']=="" or $_POST['dni']=="" or $_POST['monto']=="" or $_POST['interes']=="" or $_POST['cuotas']=="" or $_POST['cuotas']=="" or strrpos($_POST['fecha'], "/")){
				?>
			<script type="text/javascript">
window.alert("CAMPOS VACIOS O / EN FECHA");
</script><?PHP 

				
				}else{
					
	  	    $c_interesnuevo = strtoupper(trim($_POST["interes"]));
			$c_monto = (int)(trim($_POST["monto"]));
		 $c_cuotas = strtoupper(trim($_POST["cuotas"]));
		$result144 = mysql_query("SELECT *  FROM datos order by id desc limit 1", $link); 
if ($row = mysql_fetch_array($result144)){ 
 do { 
   $interesunpago=   $row["unpago"];
   $interesdospagos=   $row["dospagos"];
   $interestrespagos=   $row["trespagos"];
   } while ($row = mysql_fetch_array($result144)); 

}
 $c_fechainicio = strtoupper(trim($_POST["fecha"]));
$c_interesnuevo=$c_interesnuevo*($c_cuotas/12);
if($c_cuotas==1){
$c_interesnuevo=$interesunpago;
}
if($c_cuotas==2){
$c_interesnuevo=$interesdospagos;
}
if($c_cuotas==3){
$c_interesnuevo=$interestrespagos;
}

$interesfinal=$c_monto*($c_interesnuevo/100);
$montofinal=(int)$c_monto+$interesfinal;
$montocuota=(int)$montofinal/(int)$c_cuotas;
$sqlinicio= trim(substr($c_fechainicio,6,4)."-".substr($c_fechainicio,3,2)."-".substr($c_fechainicio,0,2));

?>
 <table align="center"><tr><td>FECHA</td><td>IMPORTE</td><td>CUOTA</td></TR>
 <?php
 
$c_cuotasfor=(int)$c_cuotas;
echo "<tr><td><input name=fechacuota[]type='text'   id='fechacuota' value='".$c_fechainicio."' ></td><td><input name=importe[]type='text'   id='importe' value='".intval($montocuota)."' ></td> <td><input name=cuotanum[]type='text'   id='cuotanum' value='1' ></td> </tr>"; 
$montof=0;
			for ($e=1; $e<$c_cuotasfor; $e++) {
	$masmes="+ ".$e." month";
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
  
  
  
   ?>
          
   
 
         
         
 
 
</form>
 
 

 

</div>

</body>
</html>

