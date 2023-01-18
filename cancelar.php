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


function agregarprestamo(){

window.open('paginaprestamo.php','','width=1020,height=600');}


function finalizar(){


var prestamo = document.form1.prestamo.value;
var fecha = document.form1.fecha.value;
var idcliente = document.form1.idcliente.value;
var observacion2 = document.form1.observacion2.value;
var cobrador = document.form1.cobrador.value;
var cadena = "cargarcancelacion.php?prestamo="+prestamo+"&idcliente="+idcliente+"&fecha="+fecha+"&observacion2="+observacion2+"&cobrador="+cobrador;
sibandera= 0;

if(document.form1.fecha.value == ""){
sibandera= 1;
}
if(document.form1.prestamo.value == 0){
sibandera= 2;
}
if(document.form1.idcliente.value == 0){
sibandera= 3;
}
if (sibandera==0){
pagina=cadena;
window.open(pagina,'','width=1020,height=600');
window.location.href = window.location.href;

}else
{
if(sibandera==1){
alert("FECHA no ingresada ");}
if(sibandera==2){
alert("SELECCIONE UN PRESTAMO");}
if(sibandera==3){
alert("SELECCIONES PRESTAMO");}

}
}




</script>
<title>::CANCELAR PRESTAMO COMPLETO::</title>
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
   <B class="titulo7"><h1>CANCELAR PRESTAMO COMPLETO</h1></B>
<?php require('conexionsql2.php');

 if(!empty($_POST['calcular'])) {
	 $c_nombre = strtoupper(trim($_POST["nombre"])); 
	 	  $c_idcliente = strtoupper(trim($_POST["idcliente"])); 
$c_idprestamo = strtoupper(trim($_POST["prestamo"])); 
	  $c_apellido = strtoupper(trim($_POST["apellido"])); 
	  $c_observacion2 = strtoupper(trim($_POST["observacion2"])); 
	  $c_cobrador = strtoupper(trim($_POST["cobrador"])); 
	  $c_fecha=strtoupper(trim($_POST["fecha"])); 
	  $c_dni = strtoupper(trim($_POST["dni"])); 
		  	    $c_interes = strtoupper(trim($_POST["interes"]));
				 $c_producto = strtoupper(trim($_POST["producto"]));
			$c_monto = strtoupper(trim($_POST["monto"]));

		 
	  
	
	 
	 
	 
	 
  }
?>

<form name="form1" method="post" action="cancelar.php">
              FECHA:<input value=<?php if ($c_fecha!="") {echo "'".$c_fecha."'";}else{echo date("d-m-Y");}?> size="10"  type="text"  name="fecha" title="DD-MM-YYYY" > 
 <input readonly="readonly" style="display: none;"  <?php if ($c_idcliente!="")
{echo "value='".$c_idcliente."'"; } ?>  name="idcliente"  size="5" type="text" id="idcliente" readonly>
<input style="display: none;" readonly="readonly" <?php if ($c_idprestamo!="")
{echo "value='".$c_idprestamo."'"; } ?>  name="prestamo"  size="5" type="text" id="prestamo" readonly>  <input <?php if ($c_interes!="")
{echo "value='".$c_interes."'"; } ?>  readonly="readonly" name="interes" size="15" type="text" id="interes" style="display: none;" readonly>
      <table align="center"><tr><td>APELLIDO</td> <td>NOMBRE</td><td>DNI</td><TD>MONTO PRESTAMO</TD><TD>PRODUCTO</TD></TR>
      <TR><TD> <input readonly="readonly"  name="apellido" <?php if ($c_apellido!="")
{echo "value='".$c_apellido."'"; } ?>  size="15" type="text" id="apellido" readonly></TD>
       <TD> <input readonly="readonly" name="nombre" <?php if ($c_nombre!="")
{echo "value='".$c_nombre."'"; } ?>  size="15" type="text" id="nombre" readonly></TD>
      <TD> <input <?php if ($c_dni!="")
{echo "value='".$c_dni."'"; } ?>  readonly="readonly" name="dni" size="15" type="text" id="dni" readonly></TD>
          <TD> <input <?php if ($c_monto!="")
{echo "value='".$c_monto."'"; } ?>  readonly="readonly" name="monto" size="15" type="text" id="monto" readonly></TD>
         
<TD> <input <?php if ($c_producto!="")
{echo "value='".$c_producto."'"; } ?>  readonly="readonly" name="producto" size="15" type="text" id="producto" readonly></TD>

      <TD>   <input type="button" name="Submit3" value="Seleccionar Prestamo" onClick="agregarprestamo()"></TD>
    
      </TR></TABLE>
      OBSERVACION:<input name="observacion2" <?php if ($c_observacion2!="")
{echo "value='".$c_observacion2."'"; } ?>  size="15" type="text" id="observacion2" >COBRADOR:<input name="cobrador"  <?php if ($c_cobrador!="")
{echo "value='".$c_cobrador."'"; } ?> size="15" type="text" id="cobrador" >
    <input  type="submit"  name="calcular" value="CALCULAR CUOTAS" >
     
  
     <?php   if(!empty($_POST['calcular'])){
			 
			if( $_POST['apellido']=="" or $_POST['nombre']=="" or $_POST['dni']=="" or $_POST['monto']=="" or $_POST['interes']==""  or strrpos($_POST['fecha'], "/")){
				?>
			<script type="text/javascript">
window.alert("CAMPOS VACIOS O / EN FECHA");
</script><?PHP 

				
				}else{
					
	  	    
 $c_fecha = strtoupper(trim($_POST["fecha"]));


$fechasql= trim(substr($c_fecha,6,4)."-".substr($c_fecha,3,2)."-".substr($c_fecha,0,2));

?>
 <table align="center"><tr><td></td><td>FECHA VENC</td><td>IMPORTE</td><td>CUOTA</td></TR>
 <?php
 $totaldeuda=0;
 $result28 = mysqli_query($link,"SELECT * FROM cuotas WHERE idprestamo= '$c_idprestamo' and idcliente= '$c_idcliente' and estado='ADEUDADA' order by id asc"); 
if ($row = mysqli_fetch_array($result28)){ 
   
   do { 
   echo "<tr><td><input style='display: none;' readonly name=id[]type='text'   id='id' value='".trim($row["id"])."' ></td><td><input readonly name=fechacuota[]type='text'   id='fechacuota' value='".trim($row["fecha"])."' ></td><td><input readonly name=importe[]type='text'   id='importe' value='".trim($row["monto"])."' ></td> <td><input readonly name=cuotanum[]type='text'   id='cuotanum' value='".trim($row["cuota"])."' ></td> </tr>"; 
    $totaldeuda=$totaldeuda + $row["monto"];
    } while ($row = mysqli_fetch_array($result28));
	
	}
 
 
echo "<h1>TOTAL CUOTAS: ".$totaldeuda."</h1>";
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
