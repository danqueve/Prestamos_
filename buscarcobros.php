<? include ("seguridad.php");?>
<? 
require('conexionsql.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>CONSULTA DE COBROS REALIZADOS</title> 
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
form{width:450px; margin:auto; background:rgba(0,0,0,0.4);
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{color:rgb(255,255,255); text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#31384A; color:rgb(255,255,255); padding:20px;}
#boton:hover{cursor:pointer;}
#tabla2{
	background: rgb(255,255,255); text-align:left; width:800px; border-collapse:collapse}
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

<H1>CONSULTAR COBROS</H1>

<form action="buscarcobros.php" method="get"> 
DATO A BUSCAR: 
<input  type="text" name="criterio" size="22" maxlength="150" placeholder="Ingrese dato a buscar"> 
<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />

<? 

 $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql.php');
   $c_id = $_GET["borrarid"]; 
    $c_idprestamo = $_GET["idprestamo"]; 
    $sql2 = "DELETE FROM cobros WHERE id=$c_id";  	   $result = mysql_query($sql2);
	    $sql3 = "UPDATE cuotas SET estado='ADEUDADA',idcobro=0, interes=0 WHERE idcobro=$c_id";
    $result = mysql_query($sql3);
	 $sql32 = "UPDATE prestamos SET estado='PENDIENTE' WHERE id=$c_idprestamo";
    $result = mysql_query($sql32);
  
  
   
      ?>
<script type="text/javascript">
window.alert("ELIMINACIÓN EXITOSA");
</script>

<?php
  }


//inicializo el criterio y recibo cualquier cadena que se desee buscar 
$criterio = ""; 
$txt_criterio = ""; 
$criterio = " where (clientes.apellido like '%" . $txt_criterio . "%' or clientes.nombre like '%" . $txt_criterio . "%'or clientes.dni like '%" . $txt_criterio . "%'or cobros.fecha like '%" . $txt_criterio . "%') and (clientes.id=cobros.idcliente)"; 
if ($_GET["criterio"]!=""){ 
   $txt_criterio = $txt_criterio = mb_strtolower(trim($_GET["criterio"]),'UTF-8'); 
  $criterio = " where (clientes.apellido like '%" . $txt_criterio . "%' or clientes.nombre like '%" . $txt_criterio . "%'or clientes.dni like '%" . $txt_criterio . "%'or cobros.fecha like '%" . $txt_criterio . "%') and (clientes.id=cobros.idcliente)"; 
} 


$sql="SELECT cobros.fechasql,cobros.id, cobros.idprestamo, clientes.apellido, clientes.nombre, clientes.dni, cobros.importe, cobros.cuota, cobros.fecha FROM clientes, cobros ".$criterio; 
$tabla="clientes";
$res=mysql_query($sql); 
$numeroRegistros=mysql_num_rows($res); 
if($numeroRegistros<=0) 
{ 
    
    echo "<h1>No se encontraron resultados</h1>"; 

}else{ 
    //////////elementos para el orden 
    if(!isset($orden)) 
    { 
       $orden="cobros.fechasql"; 
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
$sql="SELECT  cobros.fechasql,cobros.id, cobros.idprestamo, clientes.apellido, clientes.nombre, clientes.dni, cobros.importe, cobros.cuota, cobros.fecha FROM clientes, cobros ".$criterio." ORDER BY ".$orden." DESC LIMIT ".$limitInf.",".$tamPag; 
$res=mysql_query($sql); 

//////////fin consulta con limites 

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>APELLIDO</th>"; 
echo "<th>NOMBRE</th>"; 
echo "<th>DNI</th>";
echo "<th>CUOTAS</th>"; 
echo "<th>IMPORTE</th>";
echo "<th>PRESTAMO N°</th>";
echo "<th>FECHA</th>";
echo "<th>REIMPRIMIR</th>";
echo "<th>ELIMINAR</th>"; 
echo "</TR></thead>";
$totalcaja=0;
while($registro=mysql_fetch_array($res)) 
{ 
?> 
   <!-- tabla de resultados --> 
    <tr  bgcolor="#DDD" onMouseOver="this.style.backgroundColor='#FFCC99';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#DDD'"o"];" > 
        <td><? echo mb_strtoupper(trim($registro["apellido"]),'UTF-8'); ?></td> 
         <td><? echo mb_strtoupper(trim($registro["nombre"]),'UTF-8');  ?></td> 
         <td><? echo $registro["dni"]; ?></td>
         <td><? echo mb_strtoupper(trim($registro["cuota"]),'UTF-8');  ?></td>
          <td><? echo $registro["importe"]; ?></td>
            <td><? echo $registro["idprestamo"]; ?></td>
                <td><? echo $registro["fecha"]; ?></td>       <?  $totalcaja=$totalcaja+$registro["importe"]; ?>  <td><? echo "<a target='_blank' class='ord' href='"."reimpresioncobro.php?idcobro=".$registro["id"]."'>REIMPRIMIR </a>"; ?></td>
          
                <td><? echo "<a onclick='return confirmar()' class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=borrar&borrarid=".$registro["id"]."&idprestamo=".$registro["idprestamo"]."'>"."ELIMINAR <img src='delete.jpg'></a>"; ?></td>
      
        
    
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

<?php echo "<H1><FONT color='#31384A'>CANTIDAD DE COBROS:".$numeroRegistros."<BR></FONT></H1>";?>
<? echo "<H1><a target='_blank' class='ord' href='"."pdfcobros2.php?criterio=".$txt_criterio."&numerocobros=".$numeroRegistros."'>IMPRIMIR LISTADO</a></H1>"; 
echo "<h1><font color='#FF0000'>TOTAL: ".$totalcaja."</font>"; 

?>


















</table></td></tr>

<? 
    mysql_close(); 
?>



</div>
</td></tr></table>
</body>
</html>