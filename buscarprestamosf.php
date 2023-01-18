<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<?php require('conexionsql2.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>CONSULTA DE PRESTAMOS POR FILTROS</title> 
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
	if(confirm('¿DESEA ELIMINAR ESTE PRESTAMO? SE ELIMINARA CUOTAS ADEUDADAS Y PAGOS TAMBIEN'))
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
form{width:100%; margin:auto; background: #999999;
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
.claseinput2 { width:100px;}
h1{color:rgb(255,255,255); text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background: #666666; color:rgb(255,255,255); width:120px;}
#boton:hover{cursor:pointer;}
#tabla2{
	background: rgb(255,255,255); text-align:left; width:100%; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background: #666666; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;
		
		}
--> 
</style> 
</head> 
<body bgcolor="#999999" > 

<?php require('menu.php');?>

<H1>CONSULTAR PRESTAMOS</H1>

<form action="buscarprestamosf.php" method="get"> 
APELL: <input type="text" class="claseinput2" name="apellido" > CIUDAD: <input type="text" class="claseinput2" name="ciudad" > DNI: <input type="text" class="claseinput2" name="dni" > F INICIO:<input class="claseinput2" type="text" name="fecha1" > F FIN:<input class="claseinput2" type="text" name="fecha2" > 
N° PREST:<input class="claseinput2" type="text" name="prestamo" >USUARIO:<input class="claseinput2" type="text" name="usuario2" >VEND:<input class="claseinput2" type="text" name="vendedor" > 

<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />

<?php $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql2.php');
   $c_id = $_GET["borrarid"];
    $idcliente = $_GET["idcliente"];
	$monto = $_GET["monto"];
    
    $sql2 = "DELETE FROM prestamos WHERE id=$c_id";  	   $result = mysqli_query($link,$sql2);
	   $sql3 = "DELETE FROM cuotas WHERE idprestamo=$c_id";  
	   $result = mysqli_query($link,$sql3); 
	   $sql31 = "DELETE FROM caja2 WHERE idprestamo=$c_id";  
	   $result = mysqli_query($link,$sql31); 
	   $sql4 = "DELETE FROM cobros WHERE idprestamo=$c_id";  
	   $result = mysqli_query($link,$sql4);
	    $sql43 = "DELETE FROM reimpresion WHERE idprestamo=$c_id";  
	   $result = mysqli_query($link,$sql43);
	   
	   $sql321 = "UPDATE clientes SET limite=limite+$monto WHERE id=$idcliente";
    $result = mysqli_query($link,$sql321); 
  
  
   
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
$ciudade=$_GET["ciudad"];
$usuarioe=$_GET["usuario2"];
$vendedore=$_GET["vendedor"];

$fechan1 =date('Ymd', strtotime($_GET['fecha1']));
$fechan2 =date('Ymd', strtotime($_GET['fecha2']));

$dni = (!empty($_GET["dni"])
    ? " clientes.dni like '%".$_GET["dni"]."%'"
    : "");
 
$fecha = (!empty($_GET["fecha1"]) && !empty($_GET["fecha2"])
    ? (!empty($dni) 
        ? " AND prestamos.fechasql BETWEEN ".$fechan1." AND ".$fechan2." "
        : " prestamos.fechasql BETWEEN ".$fechan1." AND ".$fechan2." ")
    : "");
 
$prestamo = (!empty($_GET["prestamo"])
    ? (!empty($dni) || !empty($fecha)
        ? " AND prestamos.id like '%".$_GET["prestamo"]."%'"
        : " prestamos.id like '%".$_GET["prestamo"]."%'")
    : "");
	
	$apellido = (!empty($_GET["apellido"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo)
        ? " AND clientes.apellido like '%".$_GET["apellido"]."%'"
        : " clientes.apellido like '%".$_GET["apellido"]."%'")
    : "");
	
		$ciudad = (!empty($_GET["ciudad"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo) || !empty($apellido)
        ? " AND clientes.ciudad like '%".$_GET["ciudad"]."%'"
        : " clientes.ciudad like '%".$_GET["ciudad"]."%'")
    : "");
	$usuario2 = (!empty($_GET["usuario2"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo) || !empty($apellido) || !empty($ciudad)
        ? " AND prestamos.usuario like '%".$_GET["usuario2"]."%'"
        : " prestamos.usuario like '%".$_GET["usuario2"]."%'")
    : "");
	$vendedor = (!empty($_GET["vendedor"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo) || !empty($apellido) || !empty($ciudad)|| !empty($usuario2)
        ? " AND prestamos.vendedor like '%".$_GET["vendedor"]."%'"
        : " prestamos.vendedor like '%".$_GET["vendedor"]."%'")
    : "");
	
 
if($_SESSION['rol']=="ADMINISTRADOR"){
 if(empty($dni)and empty($fecha)and empty($prestamo) and empty($apellido) and empty($ciudad)and empty($usuario2)and empty($vendedor)){
 $criterio = " where (clientes.id=prestamos.idcliente)";
 }else{

 $criterio = " where ".$dni.$fecha.$prestamo.$apellido.$ciudad.$usuario2.$vendedor."and (clientes.id=prestamos.idcliente)"; }
}else{

if(empty($dni)and empty($fecha)and empty($prestamo) and empty($apellido) and empty($ciudad)and empty($usuario2)and empty($vendedor)){
 $criterio = " where (clientes.id=prestamos.idcliente)  ";
 }else{

 $criterio = " where ".$dni.$fecha.$prestamo.$apellido.$ciudad.$usuario2.$vendedor."and (clientes.id=prestamos.idcliente) "; }

}



$sql="SELECT prestamos.observacion,prestamos.vendedor,prestamos.usuario, prestamos.estado, prestamos.observ,prestamos.id as idprestamo,clientes.id as idcliente, clientes.apellido, clientes.nombre, clientes.ciudad, clientes.dni, prestamos.monto, prestamos.interes, prestamos.cuota, prestamos.fecha, prestamos.montofinal FROM clientes, prestamos ".$criterio; 
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
       $orden="clientes.apellido"; 
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
$sql="SELECT prestamos.observacion,prestamos.vendedor,prestamos.usuario,prestamos.estado, prestamos.observ, prestamos.id as idprestamo,clientes.id as idcliente, clientes.apellido, clientes.nombre, clientes.ciudad, clientes.dni, prestamos.monto, prestamos.interes, prestamos.cuota, prestamos.fecha, prestamos.montofinal FROM clientes, prestamos ".$criterio." ORDER BY ".$orden." ASC LIMIT ".$limitInf.",".$tamPag; 
$res=mysqli_query($link,$sql); 

//////////fin consulta con limites 

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>APELLIDO</th>"; 
echo "<th>NOMBRE</th>"; 
echo "<th>DNI</th>";
echo "<th>CIUDAD</th>";
echo "<th>PREST N°</th>"; 
echo "<th>MONTO</th>";
 if($_SESSION['rol']=="ADMINISTRADOR"){ 
echo "<th>INTERES</th>";}
echo "<th>MONTO INTERES</th>";
echo "<th>MONTO FINAL</th>";
echo "<th>CUOTAS</th>";
echo "<th>FECHA</th>";
echo "<th>PROD</th>";
echo "<th>ESTADO</th>";
echo "<th>VENDEDOR</th>";
echo "<th>USUARIO</th>";
echo "<th>OBSERV</th>";
echo "<th>SITUACION</th>";
echo "<th>REIMPRIMIR</th>";
echo "<th>IMPRIMIR PAGARE</th>";
 if($_SESSION['rol']=="ADMINISTRADOR"){ 
 
echo "<th>ELIMINAR</th>"; }
echo "</TR></thead>";
$totalprestamos=0;
$totalinteres=0;
$totalcapital=0;
$montointeres=0;
$totalfinal=0;
while($registro=mysqli_fetch_array($res)) 
{ 
?> 
   <!-- tabla de resultados --> 
    <tr  bgcolor="#DDD" onMouseOver="this.style.backgroundColor='#FFCC99';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#DDD'"o"];" > 
        <td><?php echo mb_strtoupper(trim($registro["apellido"]),'UTF-8'); ?></td> 
         <td><?php echo mb_strtoupper(trim($registro["nombre"]),'UTF-8');  ?></td> 
         <td><?php echo $registro["dni"]; ?></td>
           <td><?php echo $registro["ciudad"]; ?></td>
         <td><?php echo mb_strtoupper(trim($registro["idprestamo"]),'UTF-8');  ?></td>
          <td><?php echo $registro["monto"]; ?></td>
          <?php $totalprestamos=$totalprestamos+$registro["monto"]; ?>
          <?php $montointeres=$registro["montofinal"]-$registro["monto"];?>
            <?php if($_SESSION['rol']=="ADMINISTRADOR"){ ?>
            <td><?php echo $registro["interes"]; ?></td>
              <?php } ?>
            <td><?php echo $montointeres; ?></td>
                <?php $totalinteres=$totalinteres+$montointeres; ?>
            
            <td><?php echo $registro["montofinal"]; ?></td>
            <td><?php echo $registro["cuota"]; ?></td>
     <td><?php echo $registro["fecha"]; ?></td> 
      <td><?php echo $registro["observacion"]; ?></td> 
            <td><?php echo $registro["estado"]; ?></td> 
            <td><?php echo $registro["vendedor"]; ?></td> 
            <td><?php echo $registro["usuario"]; ?></td> 
            <td><?php echo $registro["observ"]; ?></td> 
           
             <td><?php echo "<a class='ord' href='"."situacion2.php?apellido=".$registro["apellido"]."&nombre=".$registro["nombre"]."&idprestamo=".$registro["idprestamo"]."&dni=".$registro["dni"]."'>"."VER SITUACION </a>"; ?></td>
             <td><?php echo "<a target='_blank' class='ord' href='"."reimpresion.php?idprestamo=".$registro["idprestamo"]."'>REIMPRIMIR </a>"; ?></td>
             <td><?php echo "<a target='_blank' class='ord' href='"."contrato24.php?idcliente=".$registro["idcliente"]."&fecha=".$registro["fecha"]."&fechaprestamo=".$registro["fecha"]."&monto=".$registro["montofinal"]."'>IMPRIMIR PAGARE </a>"; ?></td>
               <?php if($_SESSION['rol']=="ADMINISTRADOR"){ ?>
                <td><?php echo "<a onclick='return confirmar()' class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=borrar&borrarid=".$registro["idprestamo"]."&idcliente=".$registro["idcliente"]."&monto=".$registro["monto"]."'>"."ELIMINAR <img src='delete.jpg'></a>"; ?></td>
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

<?php echo "<H1><FONT color='#31384A'>CANTIDAD DE PRESTAMOS:".$numeroRegistros."<BR></FONT></H1>";?>
<?php echo "<H1><a target='_blank' class='ord' href='"."pdfbuscarprestamos.php?tabla=".$tabla."&dni=".$dnie."&fecha1=".$fechae1."&fecha2=".$fechae2."&prestamo=".$prestamoe."&apellido=".$apellidoe."&ciudad=".$ciudade."&usuario2=".$usuarioe."&vendedor=".$vendedore."'>IMPRIMIR LISTADO</a></H1>"; 
echo "<h1><font color='#888888'>TOTAL CAPITAL: ".$totalprestamos."</font>"; 
echo "<h1><font color='#888888'>TOTAL INTERESES: ".$totalinteres."</font>"; 
$totalfinal=$totalprestamos+$totalinteres;
echo "<h1><font color='#888888'>TOTAL : ".$totalfinal."</font>"; 
echo "<h1><font color='#888888'>PROMEDIO CAPITAL: ".round($totalprestamos/$numeroRegistros,2)."</font>"; 
echo "<h1><font color='#888888'>PROMEDIO FINAL: ".round($totalfinal/$numeroRegistros,2)."</font>"; 

if(!empty($vendedore)){
require('conexionsql2.php');
$result257 = mysqli_query($link,"SELECT * FROM datos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result257)){ 
   
   do { 
   $comisionv=$row["comisionv"];
  
    } while ($row = mysqli_fetch_array($result257));
}

$comisionv=$comisionv/100;
$apagarvendedor=$comisionv*$totalprestamos;

echo "<h1><font color='#888888'>TOTAL COMISION VENDEDOR ". $vendedore .": ".$apagarvendedor."</font>"; 
}

?>












</table></td></tr>





</div>
</td></tr></table>
</body>
</html>