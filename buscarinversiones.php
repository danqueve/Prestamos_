<? include ("seguridad.php");?>
<? 
require('conexionsql.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>CONSULTA DE INVERSIONES POR FILTROS</title> 
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
	if(confirm('¿DESEA ELIMINAR ESTA INVERSION? SE ELIMINARA CUOTAS  Y PAGOS TAMBIEN'))
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
form{width:1050px; margin:auto; background:rgba(0,0,0,0.4);
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
.claseinput2 { width:100px;}
h1{color:rgb(255,255,255); text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#31384A; color:rgb(255,255,255); width:120px;}
#boton:hover{cursor:pointer;}
#tabla2{
	background: rgb(255,255,255); text-align:left; width:100%; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#246355; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;
		
		}
--> 
</style> 
</head> 
<body bgcolor="#999999" > 

<?
require('menu.php');?>

<H1>CONSULTAR INVERSIONES</H1>

<form action="buscarinversiones.php" method="get"> 
APELLIDO: <input type="text" class="claseinput2" name="apellido" > PRODUCTO: <input type="text" class="claseinput2" name="producto" > DNI: <input type="text" class="claseinput2" name="dni" > FECHA:<input class="claseinput2" type="text" name="fecha" > 
NUMERO INVERSION:<input class="claseinput2" type="text" name="prestamo" > 

<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />

<? 

 $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql.php');
   $c_id = $_GET["borrarid"]; 
    
    $sql2 = "DELETE FROM inversiones WHERE id=$c_id";
	  	   $result = mysql_query($sql2);
	   $sql3 = "DELETE FROM cuotasi WHERE idprestamo=$c_id";  
	   $result = mysql_query($sql3); 
	   $sql4 = "DELETE FROM cobrosi WHERE idprestamo=$c_id";  
	   $result = mysql_query($sql4); 
  
  
   
      ?>
<script type="text/javascript">
window.alert("ELIMINACIÓN EXITOSA");
</script>

<?php
  }


$dnie=$_GET["dni"];
$fechae=$_GET["fecha"];
$prestamoe=$_GET["prestamo"];
$apellidoe=$_GET["apellido"];
$productoe=$_GET["producto"];

$dni = (!empty($_GET["dni"])
    ? " inversores.dni like '%".$_GET["dni"]."%'"
    : "");
 
$fecha = (!empty($_GET["fecha"])
    ? (!empty($dni) 
        ? " AND inversiones.fecha like '%".$_GET["fecha"]."%'"
        : " inversiones.fecha like '%".$_GET["fecha"]."%'")
    : "");
 
$prestamo = (!empty($_GET["prestamo"])
    ? (!empty($dni) || !empty($fecha)
        ? " AND inversiones.id like '%".$_GET["prestamo"]."%'"
        : " inversiones.id like '%".$_GET["prestamo"]."%'")
    : "");
	
	$apellido = (!empty($_GET["apellido"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo)
        ? " AND inversores.apellido like '%".$_GET["apellido"]."%'"
        : " inversores.apellido like '%".$_GET["apellido"]."%'")
    : "");
	
		$producto = (!empty($_GET["producto"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo) || !empty($apellido)
        ? " AND inversiones.observacion like '%".$_GET["producto"]."%'"
        : " inversiones.observacion like '%".$_GET["producto"]."%'")
    : "");
 

 if(empty($dni)and empty($fecha)and empty($prestamo) and empty($apellido) and empty($producto)){
 $criterio = " where (inversores.id=inversiones.idcliente)";
 }else{

 $criterio = " where ".$dni.$fecha.$prestamo.$apellido.$producto."and (inversores.id=inversiones.idcliente)"; }




$sql="SELECT inversiones.observacion, inversiones.estado, inversiones.observ,inversiones.id as idprestamo, inversores.apellido, inversores.nombre, inversores.dni, inversiones.monto, inversiones.interes, inversiones.cuota, inversiones.fecha, inversiones.montofinal FROM inversores, inversiones ".$criterio; 
$tabla="inversores";
$res=mysql_query($sql); 
$numeroRegistros=mysql_num_rows($res); 
if($numeroRegistros<=0) 
{ 
    
    echo "<h1>No se encontraron resultados</h1>"; 

}else{ 
    //////////elementos para el orden 
    if(!isset($orden)) 
    { 
       $orden="inversiones.fecha"; 
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
$sql="SELECT inversiones.observacion,inversiones.estado, inversiones.observ, inversiones.id as idprestamo, inversores.apellido, inversores.nombre, inversores.dni, inversiones.monto, inversiones.interes, inversiones.cuota, inversiones.fecha, inversiones.montofinal FROM inversores, inversiones ".$criterio." ORDER BY ".$orden." DESC LIMIT ".$limitInf.",".$tamPag; 
$res=mysql_query($sql); 

//////////fin consulta con limites 

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>APELLIDO</th>"; 
echo "<th>NOMBRE</th>"; 
echo "<th>DNI</th>";
echo "<th>INVERSION N°</th>"; 
echo "<th>MONTO</th>";
echo "<th>INTERES</th>";
echo "<th>MONTO INTERES</th>";
echo "<th>MONTO FINAL</th>";
echo "<th>CUOTAS</th>";
echo "<th>FECHA</th>";
echo "<th>PRODUCTO</th>";
echo "<th>ESTADO</th>";
echo "<th>OBSERV</th>";
echo "<th>SITUACION</th>";
echo "<th>REIMPRIMIR</th>";
echo "<th>ELIMINAR</th>"; 
echo "</TR></thead>";
$totalprestamos=0;
$totalinteres=0;
$totalcapital=0;
$montointeres=0;
$totalfinal=0;
while($registro=mysql_fetch_array($res)) 
{ 
?> 
   <!-- tabla de resultados --> 
    <tr  bgcolor="#DDD" onMouseOver="this.style.backgroundColor='#FFCC99';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#DDD'"o"];" > 
        <td><? echo mb_strtoupper(trim($registro["apellido"]),'UTF-8'); ?></td> 
         <td><? echo mb_strtoupper(trim($registro["nombre"]),'UTF-8');  ?></td> 
         <td><? echo $registro["dni"]; ?></td>
         <td><? echo mb_strtoupper(trim($registro["idprestamo"]),'UTF-8');  ?></td>
          <td><? echo $registro["monto"]; ?></td>
          <?  $totalprestamos=$totalprestamos+$registro["monto"]; ?>
          <? $montointeres=$registro["montofinal"];?>
            <td><? echo $registro["interes"]; ?></td>
            <td><? echo $montointeres; ?></td>
                <?  $totalinteres=$totalinteres+$montointeres; ?>
            
            <td><? echo $registro["montofinal"]; ?></td>
            <td><? echo $registro["cuota"]; ?></td>
     <td><? echo $registro["fecha"]; ?></td> 
      <td><? echo $registro["observacion"]; ?></td> 
            <td><? echo $registro["estado"]; ?></td> 
            <td><? echo $registro["observ"]; ?></td> 
             <td><? echo "<a class='ord' href='"."situacion2i.php?apellido=".$registro["apellido"]."&nombre=".$registro["nombre"]."&idprestamo=".$registro["idprestamo"]."&dni=".$registro["dni"]."'>"."VER SITUACION </a>"; ?></td>
             <td><? echo "<a target='_blank' class='ord' href='"."reimpresioni.php?idprestamo=".$registro["idprestamo"]."'>REIMPRIMIR </a>"; ?></td>
                <td><? echo "<a onclick='return confirmar()' class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=borrar&borrarid=".$registro["idprestamo"]."'>"."ELIMINAR <img src='delete.jpg'></a>"; ?></td>
      
        
    
     </tr> 
   <!-- fin tabla resultados --> 
<? 
}//fin while 
echo "</table>"; 
}//fin if 
//////////a partir de aqui viene la paginacion 
?> 
    <br> 
    <table border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr><td align="center" valign="top"> 
<? 
    if($pagina>1) 
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

<?php echo "<H1><FONT color='#31384A'>CANTIDAD DE INVERSIONES:".$numeroRegistros."<BR></FONT></H1>";?>
<? echo "<H1><a target='_blank' class='ord' href='"."pdfbuscarprestamos.php?tabla=".$tabla."&dni=".$dnie."&fecha=".$fechae."&prestamo=".$prestamoe."&apellido=".$apellidoe."&producto=".$productoe."'>IMPRIMIR LISTADO</a></H1>"; 
echo "<h1><font color='#FF0000'>TOTAL CAPITAL: ".$totalprestamos."</font>"; 
echo "<h1><font color='#FF0000'>TOTAL INTERESES: ".$totalinteres."</font>"; 
$totalfinal=$totalprestamos+$totalinteres;
echo "<h1><font color='#FF0000'>TOTAL : ".$totalfinal."</font>"; 
echo "<h1><font color='#FF0000'>PROMEDIO CAPITAL: ".round($totalprestamos/$numeroRegistros,2)."</font>"; 
echo "<h1><font color='#FF0000'>PROMEDIO FINAL: ".round($totalfinal/$numeroRegistros,2)."</font>"; 

?>












</table></td></tr>

<? 
    mysql_close(); 
?>



</div>
</td></tr></table>
</body>
</html>