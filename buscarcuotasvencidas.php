<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<?php require('conexionsql2.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>CONSULTA DE CUOTAS VENCIDAS POR FILTROS</title> 
<LINK REL=StyleSheet TYPE="text/css" HREF="estilo.css" media="screen">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" /> 

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
<script language="JavaScript">
function confirmar()
{
	if(confirm('¿DESEA ELIMINAR ESTA CUOTA?'))
		return true;
	else
		return false;
}
</script>
<script language="JavaScript"> 
function chequear(){   

    if(recomienda.importem.value=="")   {
      alert("Importe no ingresado.");   
	  return(false);}
	   else   if(recomienda.fecham.value=="")   {
              alert("fecha no ingresada.");   
	           return(false);}
			       					  
					  else {
               alert("Los datos son correctos");   
               return(true);   }
  }
</script>


<LINK rel=stylesheet type=text/css 
href="template.css"><LINK 
rel=stylesheet type=text/css 
href="menu_superior.css">
<SCRIPT language=javascript type=text/javascript 
src="lp.cssmenu.js"></SCRIPT>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>


<style type="text/css"> 
<!-- 
body{ font-family:monospace;}
form{width:1050px; margin:auto; background: #888888;
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
.claseinput2 { width:100px;}
h1{color:rgb(255,255,255); text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ width:180px; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#31384A; color:rgb(255,255,255); width:120px;}
#boton:hover{cursor:pointer;}
#tabla2{
	background: #999999; text-align:left; width:100%; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#999999; border-bottom: solid 5px #0f362d; color:#FFFFFF}
	tr:nth-child(even){ background:#ddd;
		
		}
--> 
</style> 
</head> 
<body bgcolor="#999999" > 

<?php require('menu.php');?>

<H1>CONSULTAR CUOTAS VENCIDAS</H1>

<form action="buscarcuotasvencidas.php" method="get"> 
APELLIDO: <input type="text" class="claseinput2" name="apellido" >  DNI: <input type="text" class="claseinput2" name="dni" > FECHA INICIO:<input class="claseinput2" type="text" name="fecha1" > FECHA FIN:<input class="claseinput2" type="text" name="fecha2" > 
NUMERO PRESTAMO:<input class="claseinput2" type="text" name="prestamo" > 

<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />

<?php if(isset($_POST['enviar'])) {
if (strtoupper($_POST["importem"])=="" or strtoupper($_POST["fecham"])=="" or strtoupper($_POST["motivo"])=="" ){
echo "<h1>Campos Vacios</h1> ";}
else{
require('conexionsql2.php');
   $c_id = $_POST["id"]; 
$c_importem = ($_POST["importem"]);
$c_fecham = ($_POST["fecham"]); 
$c_motivo = ($_POST["motivo"]); 
$fechasqlm= trim(substr($c_fecham,6,4)."-".substr($c_fecham,3,2)."-".substr($c_fecham,0,2));

   
   $sql = "UPDATE cuotas SET monto='$c_importem',fecha='$c_fecham',fechasql='$fechasqlm',motivo='$c_motivo' WHERE id=$c_id";
      $result = mysqli_query($link,$sql);
	  	  
	  
   ?>
<script type="text/javascript">
window.alert("MODIFICACION EXITOSA");
</script>

<?php 


} 

}
   

$bandera = $_GET["bandera"];

if ($bandera=="modificar"){

require('conexionsql2.php');
   $c_id=$_GET["modificarid"];
   $sql = $query = "SELECT * from cuotas WHERE id LIKE '%{$c_id}%'" ;
   $result = mysqli_query($link,$sql);   
 if ($row = mysqli_fetch_array($result)){ 
 
 $c_cuota= $row["cuota"]; 
   $c_importe= $row["monto"]; 
     $c_fecha= $row["fecha"]; 
	 $c_motivo= $row["motivo"]; 
   
  
 
    ?>
<div align="center"><H1>MODIFICAR DATOS:</H1>
<form method="post" onSubmit="return chequear();" action="buscarcuotasvencidas.php" name="recomienda">
<input type="Text" style="display: none;" readonly size="10" <?php echo "value='$c_id'" ?> name="id">
           CUOTA  :<input  type="Text" size="40" <?php echo "value='$c_cuota'"  ?> name="cuota" readonly>
      
          IMPORTE  :<input  type="Text" size="40" <?php echo "value='$c_importe'"  ?> name="importem">
              FECHA  :<input  type="Text" size="40" <?php echo "value='$c_fecha'"  ?> name="fecham"> 
               RESPUESTA CLIENTE  :<input  type="Text" size="40" <?php echo "value='$c_motivo'"  ?> name="motivo"> 
           
   <input type="Submit"   name="enviar" value="GUARDAR CAMBIOS"> 
  </form> </div>

<?php }} ?>






<?php $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql2.php');
      
     $c_id = $_GET["borrarid"]; 
  $sql = "DELETE FROM cuotas WHERE id=$c_id"; 
   $result = mysqli_query($link,$sql);
  
  
   
      ?>
<script type="text/javascript">
window.alert("ELIMINACIÓN EXITOSA");
</script>

<?php
  }


$dnie=$_GET["dni"];
$fechae1=$_GET["fecha1"];
$fechae2=$_GET["fecha2"];
$prestamoe=$_GET["prestamo"];
$apellidoe=$_GET["apellido"];
$fechan1 =date('Ymd', strtotime($_GET['fecha1']));
$fechan2 =date('Ymd', strtotime($_GET['fecha2']));

$dni = (!empty($_GET["dni"])
    ? " clientes.dni like '%".$_GET["dni"]."%'"
    : "");
 
$fecha = (!empty($_GET["fecha1"]) && !empty($_GET["fecha2"])
    ? (!empty($dni) 
        ? " AND cuotas.fechasql BETWEEN ".$fechan1." AND ".$fechan2." "
        : " cuotas.fechasql BETWEEN ".$fechan1." AND ".$fechan2." ")
    : "");
 
$prestamo = (!empty($_GET["prestamo"])
    ? (!empty($dni) || !empty($fecha)
        ? " AND cuotas.idprestamo like '".$_GET["prestamo"]."'"
        : " cuotas.idprestamo like '".$_GET["prestamo"]."'")
    : "");
	
	$apellido = (!empty($_GET["apellido"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo)
        ? " AND clientes.apellido like '%".$_GET["apellido"]."%'"
        : " clientes.apellido like '%".$_GET["apellido"]."%'")
    : "");
	
		
 

 if(empty($dni)and empty($fecha)and empty($prestamo) and empty($apellido)){
 $criterio = " where (clientes.id=cuotas.idcliente) and cuotas.estado='ADEUDADA' and  DATEDIFF( now(),cuotas.fechasql)>0";
 }else{

 $criterio = " where ".$dni.$fecha.$prestamo.$apellido."and (clientes.id=cuotas.idcliente) and cuotas.estado='ADEUDADA' and DATEDIFF( now(),cuotas.fechasql)>0"; }

$result257 = mysqli_query($link,"SELECT * FROM datos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result257)){ 
   
   do { 
   $pordia=$row["pordia"];
  
    } while ($row = mysqli_fetch_array($result257));
}

$pordia=$pordia/100;


$sql="SELECT (DATEDIFF( now(),cuotas.fechasql)) as dias,cuotas.id,cuotas.motivo, cuotas.estado,prestamos.cuota as numeroc, cuotas.idprestamo,clientes.telefono, clientes.sueldo, clientes.trabajo, clientes.telefonotrabajo, clientes.apellido, clientes.nombre, clientes.dni,clientes.celular,clientes.telefono2,clientes.interno, cuotas.monto, cuotas.cuota, cuotas.fecha, cuotas.idcliente from cuotas INNER JOIN prestamos on cuotas.idprestamo=prestamos.id INNER JOIN clientes on prestamos.idcliente=clientes.id ".$criterio; 
$tabla="cuotas";
$res=mysqli_query($link,$sql); 
$numeroRegistros=mysqli_num_rows($res); 
if($numeroRegistros<=0) 
{ 
    
    echo "<h1>No se encontraron resultados</h1>"; 

}else{ 
    //////////elementos para el orden 
    if(!isset($orden)) 
    { 
       $orden="cuotas.id"; 
    } 
    //////////fin elementos de orden 

    //////////calculo de elementos necesarios para paginacion 
    //tamaño de la pagina 
    $tamPag=400; 

    //pagina actual si no esta definida y limites 
    if(!isset($_GET["pagina"])) 
    { 
       $pagina=1; 
       $inicio=1; 
       $final=$tamPag; 
    }else{ 
       $pagina = $_GET["pagina"]; 
    } 
    //calculo del limite inferior 
    $limitInf=($pagina-1)*$tamPag; 

    //calculo del numero de paginas 
    $numPags=ceil($numeroRegistros/$tamPag); 
    if(!isset($pagina)) 
    { 
       $pagina=1; 
       $inicio=1; 
       $final=$tamPag; 
    }else{ 
       $seccionActual=intval(($pagina-1)/$tamPag); 
       $inicio=($seccionActual*$tamPag)+1; 

       if($pagina<$numPags) 
       { 
          $final=$inicio+$tamPag-1; 
       }else{ 
          $final=$numPags; 
       } 

       if ($final>$numPags){ 
          $final=$numPags; 
       } 
    } 

//////////fin de dicho calculo 

//////////creacion de la consulta con limites 
$sql="SELECT (DATEDIFF( now(),cuotas.fechasql)) as dias,cuotas.id,cuotas.motivo, prestamos.cuota as numeroc, cuotas.estado, cuotas.idprestamo,clientes.telefono, clientes.sueldo, clientes.trabajo, clientes.telefonotrabajo, clientes.apellido, clientes.nombre, clientes.dni,clientes.celular,clientes.telefono2,clientes.interno, cuotas.monto, cuotas.cuota, cuotas.fecha, cuotas.idcliente from cuotas INNER JOIN prestamos on cuotas.idprestamo=prestamos.id INNER JOIN clientes on prestamos.idcliente=clientes.id".$criterio." ORDER BY ".$orden." ASC LIMIT ".$limitInf.",".$tamPag; 
$res=mysqli_query($link,$sql); 

//////////fin consulta con limites 

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>APELLIDO</th>"; 
echo "<th>NOMBRE</th>"; 
echo "<th>DNI</th>";
echo "<th>TELEFONO</th>";
echo "<th>CELULAR</th>";
echo "<th>SUELDO</th>";
echo "<th>TRABAJO</th>";
echo "<th>TEL TRAB 1</th>";
echo "<th>TEL TRAB 2</th>";
echo "<th>INTERNO</th>";
echo "<th>PREST N°</th>";
 echo "<th>CUOTA</th>";
echo "<th>MONTO</th>";
echo "<th>MORA</th>";
echo "<th>TOTAL</th>";
echo "<th>FECHA</th>";
echo "<th>DIAS VENCIDA</th>";
echo "<th>RESPUESTA CLIENTE</th>";
echo "<th>ESTADO</th>";
if($_SESSION['rol']=="ADMINISTRADOR"){ 
echo "<th>MODIFICAR</th>";
echo "<th>ELIMINAR</th>"; }
echo "</TR></thead>";
$totalcuotas=0;
$totalconmora=0;
$totalmora=0;
$totalmora22=0;

while($registro=mysqli_fetch_array($res)) 
{ 
?> 
   <!-- tabla de resultados --> 
    <tr  bgcolor="#DDD" onMouseOver="this.style.backgroundColor='#FFCC99';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#DDD'"o"];" > 
        <td><?php echo mb_strtoupper(trim($registro["apellido"]),'UTF-8'); ?></td> 
         <td><?php echo mb_strtoupper(trim($registro["nombre"]),'UTF-8');  ?></td> 
         <td><?php echo $registro["dni"]; ?></td>
         <td><?php echo "<a target=_blank href='https://api.whatsapp.com/send?phone=".$registro["telefono"]."'>".$registro["telefono"]; ?></td>
         <td><?php echo "<a target=_blank href='https://api.whatsapp.com/send?phone=".$registro["celular"]."'>".$registro["celular"]; ?></td>
         <td><?php echo $registro["sueldo"]; ?></td>
         <td><?php echo $registro["trabajo"]; ?></td>
          <td><?php echo "<a target=_blank href='https://api.whatsapp.com/send?phone=".$registro["telefono2"]."'>".$registro["telefono2"]; ?></td>
          <td><?php echo "<a target=_blank href='https://api.whatsapp.com/send?phone=".$registro["telefono2"]."'>".$registro["telefono2"]; ?></td>
           <td><?php echo $registro["interno"]; ?></td>
         <td><?php echo mb_strtoupper(trim($registro["idprestamo"]),'UTF-8');  ?></td>
         <td><?php echo $registro["cuota"]."/".$registro["numeroc"]; ?></td>
          <td><?php echo $registro["monto"]; ?></td>
            <?php if($registro["dias"]>0){
$mora=floor(abs(($registro["monto"]*$pordia)*$registro["dias"])) ;



}else{
$mora=0;
}
?>
<?php $totalconmora=$registro["monto"]+$mora; 

$totalmora22=$totalmora22+$mora;
?>
        <td><?php echo $mora; ?></td> 
        <td><?php echo $totalconmora; ?></td> 
         <?php $totalcuotas=$totalcuotas+$registro["monto"]; ?>
          <?php $totalmora=$totalmora+$totalconmora; ?>
     <td><?php echo $registro["fecha"]; ?></td> 
       <td><?php if( $registro["dias"]>0) {echo "<font color=red><b>VENCIDA EN ". $registro["dias"]. " DIAS</b></font>";}else{echo abs($registro["dias"]). " DIAS PARA VENCER";} ?></td> 
   
          <td><?php echo $registro["motivo"]; ?></td> 
                 <td><?php echo $registro["estado"]; ?></td> 
                  <?php if($_SESSION['rol']=="ADMINISTRADOR"){ ?>
                      <td><?php echo "<a class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=modificar&modificarid=".$registro["id"]."'>"."MODIFICAR </a>"; ?></td>
                <td><?php echo "<a onclick='return confirmar()' class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=borrar&borrarid=".$registro["id"]."'>"."ELIMINAR <img src='delete.jpg'></a>"; ?></td>
                <?php } ?>
      
        
    
     </tr> 
   <!-- fin tabla resultados --> 
<?php }//fin while 
echo "</table>"; 
}//fin if 
//////////a partir de aqui viene la paginacion 
?> 
    <br> 
    <table border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr><td align="center" valign="top"> 
<?php if($pagina>1) 
    { 
       echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$txt_criterio."'>"; 
       echo "<font face='verdana' size='-2'>anterior</font>"; 
       echo "</a> "; 
    } 

    for($i=$inicio;$i<=$final;$i++) 
    { 
       if($i==$pagina) 
       { 
          echo "<font face='verdana' size='-2'><b>".$i."</b> </font>"; 
       }else{ 
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&criterio=".$txt_criterio."'>"; 
          echo "<font face='verdana' size='-2'>".$i."</font></a> "; 
       } 
    } 
    if($pagina<$numPags) 
   { 
       echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$txt_criterio."'>"; 
       echo "<font face='verdana' size='-2'>siguiente</font></a>"; 
   } 
//////////fin de la paginacion 
?> 
    </td></tr> 
    </table> 

<?php echo "<H1><FONT color='#999999'>CANTIDAD DE CUOTAS EN BUSQUEDA:".$numeroRegistros."<BR></FONT></H1>";?>
<?php echo "<H1><a target='_blank' class='ord' href='"."pdfbuscarvencidas.php?tabla=".$tabla."&dni=".$dnie."&fecha1=".$fechae1."&fecha2=".$fechae2."&prestamo=".$prestamoe."&apellido=".$apellidoe."&cantidadc=".$numeroRegistros."'>IMPRIMIR LISTADO</a></H1>"; 

echo "<H1><a target='_blank' class='ord' href='"."pdfbuscarvencidas2.php?tabla=".$tabla."&dni=".$dnie."&fecha1=".$fechae1."&fecha2=".$fechae2."&prestamo=".$prestamoe."&apellido=".$apellidoe."&cantidadc=".$numeroRegistros."'>IMPRIMIR LISTADO CON TELEFONOS</a></H1>"; 

echo "<h1><font color='#999999'>TOTAL CUOTAS: ".$totalcuotas."</font>"; 
echo "<h1><font color='#999999'>TOTAL MORA: ".$totalmora22."</font>"; 
$totaltotal=$totalmora22+$totalcuotas;
echo "<h1><font color='#999999'>TOTAL FINAL: ".$totaltotal."</font>"; 

?>












</table></td></tr>





</div>
</td></tr></table>
</body>
</html>