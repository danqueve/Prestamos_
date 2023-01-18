<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require('conexionsql2.php');
    ?>
<html>
<head>
<title>::NUEVO PAGO::</title>
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
function finalizar(){
var apellido = document.recomienda.apellido.value;
var idclase1 = document.recomienda.clase1.value;
var dni = document.recomienda.dni.value;
var cadena = "cargarcarnet.php";
pagina=cadena;

if(apellido=="" || idclase1=="0" || dni=="" ){
alert("CAMPOS VACIOS");}else{
window.open(pagina,'','width=1020,height=600');
setTimeout("location.href='https://muniolta.online/nuevocarnet.php'", 7000);
}




}

</script>




<script>

function agregarcliente(){
window.open('paginacliente.php','','width=1020,height=600');}
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
              alert("PROVEEDOR NO INGRESADO");
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
form{width:600px; margin:auto; background: #999999;
padding:8px 18px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{ color:#333333; text-align:center; margin:0; font-size:30px; margin-bottom:20px}
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
	thead{ background:#999999; border-bottom: solid 5px #0f362d;}
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

<?php if(isset($_POST['enviar'])) {
   // process form
if (strtoupper($_POST["apellido"])==""  or strtoupper($_POST["dni"])=="" or strtoupper($_POST["comprobante"])=="" ){
echo "<b> <font color=red size='+2'>CAMPOS VACIOS </font></b> ";}
else{
require('conexionsql2.php');
   
   
$c_apellido = mb_strtolower(trim($_POST["apellido"]),'UTF-8'); 
$c_nombre =mb_strtolower(trim($_POST["nombre"]),'UTF-8'); 
$c_idcliente =trim($_POST["idcliente"]); 
$c_dni = strtoupper($_POST["dni"]); 
$c_direccion = mb_strtolower(trim($_POST["direccion"]),'UTF-8'); 

 $fecha = strtoupper(trim($_POST["fecha"]));
  $fechasql= trim(substr($fecha,6,4)."-".substr($fecha,3,2)."-".substr($fecha,0,2)); 
 
	$c_comprobante =$_POST["comprobante"];
	$c_detalle =$_POST["detalle"];
	$c_importe =$_POST["importe"];
	$c_tipo =mb_strtolower(trim($_POST["tipo"]),'UTF-8'); 
	
	$c_periodo = mb_strtolower(trim($_POST["periodo"]),'UTF-8'); 	
		  
	   $result1 = mysqli_query($link,"SELECT * FROM pagos WHERE comprobante='$c_comprobante'"); 
if (!($row = mysqli_fetch_array($result1))){ 

$result13 = mysqli_query($link,"SELECT * FROM contribuyentes WHERE dni='$c_dni'"); 
if (!($row = mysqli_fetch_array($result13))){ 


$result14 = mysqli_query($link,"SELECT `AUTO_INCREMENT`
FROM  INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'u335739870_amigos'
AND   TABLE_NAME   = 'contribuyentes';"); 
if ($row = mysqli_fetch_array($result14)){ 
 do { 
   $c_idcliente=   $row["AUTO_INCREMENT"];
   } while ($row = mysqli_fetch_array($result14)); 


}

 $sql55 = "INSERT INTO contribuyentes (apellido,   nombre, dni,  direccion) VALUES ('$c_apellido',   '$c_nombre' , '$c_dni',   '$c_direccion')";
   $result = mysqli_query($link,$sql55);



}


	  
		
		 
?>
	<div id="apDiv1">
	<form method="post" onSubmit="return chequear();"  action="nuevopago.php" name="recomienda" id="recomienda">
        DNI:<input  class="claseinput2" <?php echo "value='$c_dni'"  ?>   name="dni" size="15" type="text" id="dni" >APELLIDO: <input class="claseinput"<?php echo "value='$c_apellido'"  ?>  readonly  name="apellido"  size="45" type="text" id="apellido"  >
       NOMBRE: <input <?php echo "value='$c_nombre'"  ?>  readonly class="claseinput" name="nombre"   size="15" type="text" id="nombre" >
     <br>    DIRECCION:   <input <?php echo "value='$c_direccion'"  ?>  class="claseinput" readonly name="direccion"  size="15" type="text" id="direccion" ><input <?php echo "value='$c_idcliente'"  ?>  readonly="readonly" style="display: none;"  name="idcliente"  size="5" type="text" id="idcliente" readonly> FECHA:<input class="claseinput2" <?php echo "value='$fecha'"  ?> size="10"  id="fecha" type="text"  name="fecha" title="DD-MM-YYYY"  >
  IMPORTE: <input <?php echo "value='$c_importe'"  ?>   class="claseinput2" name="importe"  size="15" type="text" id="importe"  ><br>
  DETALLE: <input <?php echo "value='$c_detalle'"  ?>   class="claseinput" name="detalle"  size="15" type="text" id="detalle"  >
  COMPROBANTE: <input <?php echo "value='$c_comprobante'"  ?>   class="claseinput2" name="comprobante"  size="15" type="text" id="comprobante"  >
<br> TIPO: 
  <input <?php echo "value='$c_tipo'"  ?>   class="claseinput" name="tipo"  size="15" type="text" id="tipo"  >
 


 PERIODO: <input <?php echo "value='$c_periodo'"  ?>   class="claseinput2" name="periodo"  size="15" type="text" id="periodo"  >
  
<br>
   <input type="Submit"  id="boton2" name="enviar" value="GUARDAR COBRO" >
    
  </form> 
	
	</div>
	<?php $result143 = mysqli_query($link,"SELECT `AUTO_INCREMENT`
FROM  INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'u335739870_amigos'
AND   TABLE_NAME   = 'pagos';"); 
if ($row = mysqli_fetch_array($result143)){ 
 do { 
   $c_idcobro=   $row["AUTO_INCREMENT"];
   } while ($row = mysqli_fetch_array($result143)); 


}
	
	
	
		  $sql2 = "INSERT INTO pagos (idcontribuyente, apellido,nombre,dni,fecha,fechasql,comprobante,importe,tipo,detalle,mes,estado) VALUES ('$c_idcliente','$c_apellido',   '$c_nombre' , '$c_dni','$fecha','$fechasql','$c_comprobante','$c_importe','$c_tipo','$c_detalle','$c_periodo','NORMAL')";
   $result2 = mysqli_query($link,$sql2);
   
   
   
    $usuarionuevo=$_SESSION['usuario'];
	
	$clientecaja="cliente:".$c_apellido.",".$c_nombre;
	$detallecobro=$c_tipo."-".$c_detalle;
	$importecaja=$c_importe*-1;
    $sql21 = "INSERT INTO caja2 (detalle,importe,fecha,tipo,fechasql,observacion,usuario,idpago) VALUES ('$detallecobro','$importecaja','$fecha','EGRESO','$fechasql','$clientecaja','$usuarionuevo','$c_idcobro')";
	$result = mysqli_query($link,$sql21);
   
   
      
	  
  
   
   
    
   
?>
<script type="text/javascript">
window.alert("PAGO EXITOSO");
</script>
	
	
    
    <div id="apDiv2">
    
 <?php require('conexionsql2.php');
   $result = mysqli_query($link,"SELECT * FROM pagos WHERE idcontribuyente='$c_idcliente' and estado='NORMAL' order by id desc"); 
if ($row = mysqli_fetch_array($result)){ 
   echo "<h1>PAGOS REALIZADOS</h1>"; 
   echo "<table id='tabla2'><thead><tr><th><b>DETALLE</b></th><th><b>FECHA</b></th><th><b>IMPORTE</b></th><th><b>APELLIDO</b></th><th><b>NOMBRE</b></th></tr> </thead>\n"; 
   do { 
      echo "<tr><td>".$row["detalle"]."</td><td>".$row["fecha"]."</td><td>".$row["importe"]."</td><td>".$row["apellido"]."</td><td>".$row["nombre"]."</td></tr> \n"; 
   } while ($row = mysqli_fetch_array($result)); 
   echo "</table>";
   ?>
   
   <script type="text/javascript">
 setTimeout("location.href='nuevopago.php'", 800);
</script>

  <?php } else { 
echo "<H1> ESTE PROVEEDOR NO TIENE PAGOS</H1>"; }

    
    ?>
    
    
    
    
    </div>
    
    
    
    <?php }else{
	 echo "<H1>EL COMPROBANTE YA EXISTE</H1>";
	
	}}
	
	}else{
	?>

<div id="apDiv1">
<?php require('conexionsql2.php');
$result14 = mysqli_query($link,"SELECT comprobante  FROM pagos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result14)){ 
 do { 
   $compro=   $row["comprobante"] + 1;
   } while ($row = mysqli_fetch_array($result14)); 

}else{
$compro=1;
}
?>

<form method="post" onSubmit="return chequear();"  action="nuevopago.php" name="recomienda" id="recomienda">
        DNI:<input  class="claseinput2"    name="dni" size="15" type="text" id="dni" >APELLIDO: <input class="claseinput"   name="apellido"  size="45" type="text" id="apellido"  >
       NOMBRE: <input  class="claseinput" name="nombre"   size="15" type="text" id="nombre" >
     <br>    DIRECCION:   <input   class="claseinput" name="direccion"  size="15" type="text" id="direccion" ><input   readonly="readonly" style="display: none;"  name="idcliente"  size="5" type="text" id="idcliente" readonly> FECHA:<input class="claseinput2" <?php echo "value=". date("d-m-Y"); ?> size="10"  id="fecha" type="text"  name="fecha" title="DD-MM-YYYY"  >
  IMPORTE: <input    class="claseinput2" name="importe"  size="15" type="text" id="importe"  >
 <BR> DETALLE: <input   class="claseinput" name="detalle"  size="15" type="text" id="detalle"  >
  COMPROBANTE: <input <?php echo "value=". $compro; ?>   class="claseinput2" name="comprobante"  size="15" type="text" id="comprobante"  >
<BR> TIPO: 
 
<input   class="claseinput" name="tipo"  size="15" type="text" id="tipo"  >


PERIODO PAGO: <input   class="claseinput2" name="periodo"  size="15" type="text" id="periodo"  >
  <BR>

   <input type="Submit"  id="boton2" name="enviar" value="GUARDAR PAGO" >
    
  </form> 
 

  
</div>


<?php } ?>



</body>

</html>

