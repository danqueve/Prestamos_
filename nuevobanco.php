<?include ("seguridad.php");
require('conexionsql.php');
?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>::AGREGAR NUEVO BANCO::</title>
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

    if(recomienda.importe.value=="")   {
      alert("Saldo no ingresado.");   
	  return(false);}
	   else   if(recomienda.fecha.value=="")   {
              alert("fecha no ingresada.");   
	           return(false);}
			    else   if(recomienda.nombre.value=="")   {
              alert("Nombre no ingresado.");   
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
<!--
.Estilo1 {font-size: 14pt}
-->
</style>
<style type="text/css">
<!--
.Estilo1 {font-size: 14pt}
body{ font-family:monospace;}
form{width:500px; margin:auto; background: rgb(153,153,153);
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{ color:#FFFFFF; text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea, select{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none; height:30px;}
#boton{ width:120px;background:#31384A; color:rgb(255,255,255); padding:20px;}
#entrada{width:120px;}
#entrada2{width:160px;}
#boton:hover{cursor:pointer;}
#tabla{
	background: rgb(255,255,255); text-align:left; width:100%; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#246355; border-bottom: solid 5px #0f362d; color:#FFFFFF}
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
	
	left: 525px;
	top: 135px;
}
-->
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body  bgcolor="#666666"> 
<?
require('menu.php');
?>

<br>

<div align="center">
<div id="apDiv1">
   <BR><b class="titulo7"><h3 >AGREGAR NUEVO BANCO</h3></b>


<form method="post" onSubmit="return chequear();"  action="nuevobanco.php" name="recomienda">
   NOMBRE BANCO:<input type="Text"  height="30" size="40" name="nombre">
    TIPO:<SELECT NAME=tipo>

<OPTION selected>SALDO
<OPTION >TRANSFERENCIA
<OPTION >CHEQUE
<OPTION >TARJETA-CREDITO
</SELECT>
    SALDO:<input type="Text" value="0"  height="30" size="40" name="importe">
     TRANSFERENCIA:<input type="Text" value="0"  height="30" size="40" name="transferencia">
     CHEQUE N°:<input type="Text"   height="30" size="40" name="cheque">
     IMPORTE CHEQUE:<input type="Text" value="0"  height="30" size="40" name="importecheque">
   OBSERVACION:<input type="Text"  height="30" size="40" name="observacion">
          FECHA   :<input  type="text" value=<? echo date("d-m-Y");?> height="30" size="40" name="fecha"><br>
      
   <input type="Submit"  name="enviar" value="GUARDAR"><br>
  </form> 
  </div>
  <div id="apDiv2">
  <?
  
  
  $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql.php');
   $c_id = $_GET["borrarid"]; 
    $sql = "DELETE FROM bancos WHERE id=$c_id";  
   $result = mysql_query($sql);
      
  
   
      ?>
<script type="text/javascript">
window.alert("ELIMINACIÓN EXITOSA");
</script>

<?
  }
  
  if(!isset($_POST['enviar'])) {
  
  
  $result = mysql_query("SELECT * FROM bancos order by id desc ",$link); 
if ($row = mysql_fetch_array($result)){ 
   echo "<table id='tabla'> \n"; 
   echo "<thead><th>NOMBRE</th><th>SALDO</th><th>TRANSFERENCIA</th><th>CHEQUE N</th><th>IMPORTE CHEQUE</th><th>FECHA</th><th>OBSERVACION</th><th>ELIMINAR</th></thead> \n";
   
   
    
   do { 
      echo "<tr><td>".$row["nombre"]."</td><td>".$row["importe"]."</td><td>".$row["transferencia"]."</td><td>".$row["cheque"]."</td><td>".$row["importecheque"]."</td><td>".$row["fecha"]."</td><td>".$row["observacion"]."</td><td><a onclick='return confirmar()' class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=borrar&borrarid=".$row["id"]."'>"."ELIMINAR <img src='delete.jpg'></a></td></tr> \n"; 
	  
   } while ($row = mysql_fetch_array($result)); 
   echo "</table> \n"; 
  
   echo "<H1><a target='_blank' class='ord' href='"."pdfbancos.php'>IMPRIMIR LISTADO</a></H1>"; 
} else { 
echo "<h1>NO SE ENCONTRO REGISTRO</h1>"; }}

?>




  
  
<? 
	 	

if(isset($_POST['enviar'])) {
   // process form
if (strtoupper( ($_POST["nombre"])=="" )){
echo "<b> <font color=red size='+2'>CAMPO VACIO</font></b> ";}
else{
require('conexionsql.php');
   
   
$c_observacion = mb_strtolower(trim($_POST["observacion"]),'UTF-8');
$c_nombre = mb_strtolower(trim($_POST["nombre"]),'UTF-8');

$c_transferencia = ($_POST["transferencia"]);  
$c_importe = ($_POST["importe"]);
 $c_importecheque = ($_POST["importecheque"]);
 $c_cheque = ($_POST["cheque"]);
 $c_tipo = ($_POST["tipo"]);
$c_fecha = ($_POST["fecha"]); 
$fechasql= trim(substr($c_fecha,6,4)."-".substr($c_fecha,3,2)."-".substr($c_fecha,0,2));
  
  
   
   $sql = "INSERT INTO bancos (nombre,importe,fecha,transferencia,observacion,fechasql,cheque,importecheque,tipo) VALUES ('$c_nombre','$c_importe','$c_fecha','$c_transferencia','$c_observacion','$fechasql','$c_cheque','$c_importecheque','$c_tipo')";
   $result = mysql_query($sql,$link);
   echo "<h1>ALTA EXITOSA</h1>";
   
 
  $result = mysql_query("SELECT * FROM bancos order by id desc ",$link); 
if ($row = mysql_fetch_array($result)){ 
   echo "<table id='tabla'> \n"; 
   echo "<thead><th>NOMBRE</th><th>SALDO</th><th>TRANSFERENCIA</th><th>CHEQUE N</th><th>IMPORTE CHEQUE</th><th>FECHA</th><th>OBSERVACION</th><th>ELIMINAR</th></thead> \n"; 
   do { 
       echo "<tr><td>".$row["nombre"]."</td><td>".$row["importe"]."</td><td>".$row["transferencia"]."</td><td>".$row["cheque"]."</td><td>".$row["importecheque"]."</td><td>".$row["fecha"]."</td><td>".$row["observacion"]."</td><td><a onclick='return confirmar()' class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=borrar&borrarid=".$row["id"]."'>"."ELIMINAR <img src='delete.jpg'></a></td></tr> \n";  
	  
   } while ($row = mysql_fetch_array($result)); 
   echo "</table> \n"; 
 
   echo "<H1><a target='_blank' class='ord' href='"."pdfbancos.php'>IMPRIMIR LISTADO</a></H1>"; 
  
} else { 
echo "<h1>NO SE ENCONTRO REGISTRO</h1>"; }

}
 }
?> 
</div>
</div>

</body>
</html>

