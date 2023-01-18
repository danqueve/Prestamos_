<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<?php require('conexionsql2.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>CONSULTA DE COBROS REALIZADOS POR FILTROS</title> 
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
	if(confirm('¿DESEA ELIMINAR ESTE COBRO?'))
		return true;
	else
		return false;
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
form{width:100%; margin:auto; background: #CCCCCC;
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
.claseinput2 { width:100px;}
h1{color: #333333; text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#666666; color:rgb(255,255,255);  width:120px}
#boton:hover{cursor:pointer;}
#tabla2{
	background: #999999; text-align:left; width:800px; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#999999; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;
		
		}
--> 
</style> 
</head> 
<body bgcolor="#999999" > 

<?php require('menu.php');?>

<H1>CONSULTAR COBROS</H1>

<form action="buscarcobrosf.php" method="get"> 
DATO A BUSCAR: 
DNI: <input type="text" class="claseinput2" name="dni" >CIUDAD: <input type="text" class="claseinput2" name="ciudad" > FECHA INICIO:<input class="claseinput2" type="text" name="fecha1" > FECHA FIN:<input class="claseinput2" type="text" name="fecha2" > 
N° PREST:<input class="claseinput2" type="text" name="prestamo" > USUARIO:<input class="claseinput2" type="text" name="usuario2" > COBRADOR:<input class="claseinput2" type="text" name="cobrador" > 
<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />

<?php $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql2.php');
   $c_id = $_GET["borrarid"]; 
    $c_idcliente = $_GET["idcliente"]; 
    $c_idprestamo = $_GET["idprestamo"]; 
	$c_ncuota = $_GET["ncuota"]; 
	
	$result253 = mysqli_query($link,"SELECT * FROM prestamos WHERE id= '$c_idprestamo' order by id desc"); 
if ($row = mysqli_fetch_array($result253)){ 
   
   do { 
       $montoprestamo=$row["monto"];
	   $cuotasprestamo=$row["cuota"];
	   
	     } while ($row = mysqli_fetch_array($result253));
}
	
	$montolimite=$montoprestamo/$cuotasprestamo;
	
	$result25 = mysqli_query($link,"SELECT * FROM reimpresion WHERE idcobro= '$c_id' order by id desc"); 
if ($row = mysqli_fetch_array($result25)){ 
   
   do { 
       $idcuota=$row["idcuota"];
	   $imp=$row["importe"];
	     $sql3 = "UPDATE cuotas SET estado='ADEUDADA',monto=monto+$imp, interes=0 WHERE id=$idcuota";
    $result = mysqli_query($link,$sql3);
	
	
	

if($row["bandera"]==1){

$sql321 = "UPDATE clientes SET limite=limite-$montolimite WHERE id=$c_idcliente";
    $result = mysqli_query($link,$sql321);
	
	
	$sql3213 = "UPDATE reimpresion SET bandera=0 WHERE idcuota=$idcuota and idprestamo=$c_idprestamo";
    $result = mysqli_query($link,$sql3213);
	
	}

 
	
	
	
	   
	     } while ($row = mysqli_fetch_array($result25));
}
	
	
    
	  
	 $sql32 = "UPDATE prestamos SET estado='PENDIENTE' WHERE id=$c_idprestamo";
    $result = mysqli_query($link,$sql32);
	
	
	
  $sql2 = "DELETE FROM cobros WHERE id=$c_id";  	  
	 $result = mysqli_query($link,$sql2);
	  $sql22 = "DELETE FROM caja2 WHERE idfactura=$c_id";
	  	   $result = mysqli_query($link,$sql22);
	  $sql21 = "DELETE FROM reimpresion WHERE idcobro=$c_id";  	  
	 $result = mysqli_query($link,$sql21);
  
  
  	

  
   
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
$usuarioe=$_GET["usuario2"];
$ciudade=$_GET["ciudad"];
$cobradore=$_GET["cobrador"];

$fechan1 =date('Ymd', strtotime($_GET['fecha1']));
$fechan2 =date('Ymd', strtotime($_GET['fecha2']));

$dni = (!empty($_GET["dni"])
    ? " clientes.dni like '%".$_GET["dni"]."%'"
    : "");
 
$fecha = (!empty($_GET["fecha1"]) && !empty($_GET["fecha2"])
    ? (!empty($dni) 
        ? " AND cobros.fechasql BETWEEN ".$fechan1." AND ".$fechan2." "
        : " cobros.fechasql BETWEEN ".$fechan1." AND ".$fechan2." ")
    : "");
 
$prestamo = (!empty($_GET["prestamo"])
    ? (!empty($dni) || !empty($fecha)
        ? " AND cobros.idprestamo like '%".$_GET["prestamo"]."%'"
        : " cobros.idprestamo like '%".$_GET["prestamo"]."%'")
    : "");
	
$usuario2 = (!empty($_GET["usuario2"])
    ? (!empty($dni) || !empty($fecha)|| !empty($prestamo)
        ? " AND cobros.usuario like '%".$_GET["usuario2"]."%'"
        : " cobros.usuario like '%".$_GET["usuario2"]."%'")
    : "");
	$ciudad = (!empty($_GET["ciudad"])
    ? (!empty($dni) || !empty($fecha)|| !empty($prestamo)|| !empty($usuario2)
        ? " AND clientes.ciudad like '%".$_GET["ciudad"]."%'"
        : " clientes.ciudad like '%".$_GET["ciudad"]."%'")
    : "");
	$cobrador = (!empty($_GET["cobrador"])
    ? (!empty($dni) || !empty($fecha)|| !empty($prestamo)|| !empty($usuario2)|| !empty($ciudad)
        ? " AND cobros.cobrador like '%".$_GET["cobrador"]."%'"
        : " cobros.cobrador like '%".$_GET["cobrador"]."%'")
    : "");
 

if($_SESSION['rol']=="ADMINISTRADOR"){
 if(empty($dni)and empty($fecha)and empty($prestamo)and empty($usuario2)and empty($ciudad)and empty($cobrador)){
 $criterio = " where (clientes.id=cobros.idcliente)";
 }else{

 $criterio = " where ".$dni.$fecha.$prestamo.$usuario2.$ciudad.$cobrador."and (clientes.id=cobros.idcliente)"; }
 }else{
 if(empty($dni)and empty($fecha)and empty($prestamo)and empty($usuario2)and empty($ciudad)and empty($cobrador)){
 $criterio = " where (clientes.id=cobros.idcliente) and (cobros.usuario='".$_SESSION['usuarionuevo']."') ";
 }else{

 $criterio = " where ".$dni.$fecha.$prestamo.$usuario2.$ciudad.$cobrador."and (clientes.id=cobros.idcliente) and (cobros.usuario='".$_SESSION['usuarionuevo']."') "; }
 
 }




$sql="SELECT cobros.id, cobros.usuario, cobros.idprestamo,cobros.observacion,cobros.cobrador, clientes.apellido, clientes.ciudad,clientes.id as idcliente, clientes.nombre, clientes.dni, cobros.importe, cobros.cuota, cobros.fecha FROM clientes, cobros ".$criterio; 
$tabla="clientes";
$res=mysqli_query($link,$sql); 
$numeroRegistros=mysqli_num_rows($res); 
if($numeroRegistros<=0) 
{ 
    
    echo "<h1>No se encontraron resultados</h1>"; 

}else{ 
    //////////elementos para el orden 
    if(!isset($orden)) 
    { 
       $orden="cobros.id"; 
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
$sql="SELECT  cobros.id, cobros.usuario, cobros.observacion,cobros.cobrador, cobros.idprestamo, clientes.apellido, clientes.ciudad,clientes.id as idcliente, clientes.nombre, clientes.dni, cobros.importe, cobros.cuota, cobros.fecha FROM clientes, cobros ".$criterio." ORDER BY ".$orden." DESC LIMIT ".$limitInf.",".$tamPag; 
$res=mysqli_query($link,$sql); 

//////////fin consulta con limites 

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>APELLIDO</th>"; 
echo "<th>NOMBRE</th>"; 
echo "<th>DNI</th>";
echo "<th>CIUDAD</th>";
echo "<th>CUOTAS</th>"; 
echo "<th>IMPORTE</th>";
echo "<th>PRESTAMO N°</th>";
echo "<th>FECHA</th>";
echo "<th>USUARIO</th>";
echo "<th>OBSERVACION</th>";
echo "<th>COBRADOR</th>";
echo "<th>REIMPRIMIR</th>";
if($_SESSION['rol']=="ADMINISTRADOR"){ 
echo "<th>ELIMINAR</th>"; }
echo "</TR></thead>";
$totalcaja=0;
while($registro=mysqli_fetch_array($res)) 
{ 
?> 
   <!-- tabla de resultados --> 
    <tr  bgcolor="#DDD" onMouseOver="this.style.backgroundColor='#FFCC99';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#DDD'"o"];" > 
        <td><?php echo mb_strtoupper(trim($registro["apellido"]),'UTF-8'); ?></td> 
         <td><?php echo mb_strtoupper(trim($registro["nombre"]),'UTF-8');  ?></td> 
         <td><?php echo $registro["dni"]; ?></td>
         <td><?php echo $registro["ciudad"]; ?></td>
         <td><?php echo mb_strtoupper(trim($registro["cuota"]),'UTF-8');  ?></td>
          <td><?php echo $registro["importe"]; ?></td>
            <td><?php echo $registro["idprestamo"]; ?></td>
                <td><?php echo $registro["fecha"]; ?></td>  
                  <td><?php echo $registro["usuario"]; ?></td>  
                 <td><?php echo $registro["observacion"]; ?></td>  
                    <td><?php echo $registro["cobrador"]; ?></td>  
                     <?php $totalcaja=$totalcaja+$registro["importe"]; ?>  <td><?php echo "<a target='_blank' class='ord' href='"."reimpresioncobro.php?idcobro=".$registro["id"]."'>REIMPRIMIR </a>"; ?></td>
              <?php if($_SESSION['rol']=="ADMINISTRADOR"){ ?>
                <td><?php echo "<a onclick='return confirmar()' class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=borrar&borrarid=".$registro["id"]."&idprestamo=".$registro["idprestamo"]."&idcliente=".$registro["idcliente"]."&ncuota=".$registro["cuota"]."'>"."ELIMINAR <img src='delete.jpg'></a>"; ?></td>
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

<?php echo "<H1><FONT color='#31384A'>CANTIDAD DE COBROS:".$numeroRegistros."<BR></FONT></H1>";?>
<?php echo "<H1><a target='_blank' class='ord' href='"."pdfbuscarcobros.php?tabla=".$tabla."&dni=".$dnie."&cobrador=".$cobradore."&fecha1=".$fechae1."&fecha2=".$fechae2."&prestamo=".$prestamoe."&ciudad=".$ciudade."&usuario2=".$usuarioe."'>IMPRIMIR LISTADO</a></H1>"; 

echo "<h1><font color='#666666'>TOTAL: ".$totalcaja."</font>"; 

if(!empty($cobradore)){
require('conexionsql2.php');
$result257 = mysqli_query($link,"SELECT * FROM datos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result257)){ 
   
   do { 
   $comisionc=$row["comisionc"];
  
    } while ($row = mysqli_fetch_array($result257));
}

$comisionc=$comisionc/100;
$apagarcobrador=$comisionc*$totalcaja;

echo "<h1><font color='#666666'>TOTAL COMISION COBRADOR ". $cobradore .": ".$apagarcobrador."</font>"; 
}

?>


















</table></td></tr>





</div>
</td></tr></table>
</body>
</html>