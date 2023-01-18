<? include ("seguridad.php");?>
<? 
require('conexionsql.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>CONSULTA DE PAGOS A INVERSORES POR FILTROS</title> 
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
	if(confirm('¿DESEA ELIMINAR ESTE PAGO?'))
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
form{width:100%; margin:auto; background:rgba(0,0,0,0.4);
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
.claseinput2 { width:100px;}
h1{color:rgb(255,255,255); text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#31384A; color:rgb(255,255,255);  width:120px}
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

<H1>CONSULTAR PAGOS A INVERSORES</H1>

<form action="buscarcobrosfi.php" method="get"> 
DATO A BUSCAR: 
DNI: <input type="text" class="claseinput2" name="dni" > FECHA:<input class="claseinput2" type="text" name="fecha" > 
NUMERO INVERSION:<input class="claseinput2" type="text" name="prestamo" > OBSERVACION:<input class="claseinput2" type="text" name="observ" >TIPO:<input class="claseinput2" type="text" name="tipo" > 
<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />

<? 

 $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql.php');
   $c_id = $_GET["borrarid"]; 
   $c_tipo = $_GET["tipocobro"]; 
   $c_reinvertido =$_GET["reinvertido"];
   $c_reinvertido=(int)$c_reinvertido;
    $c_idprestamo = $_GET["idprestamo"]; 
	if($c_tipo=='TOTAL'){
    $sql2 = "DELETE FROM cobrosi WHERE id=$c_id";  	  
	 $result = mysql_query($sql2);
	  $sql31 = "DELETE FROM caja2 WHERE idfacturai=$c_id";  
	   $result = mysql_query($sql31); 
	    $sql3 = "UPDATE cuotasi SET estado='ADEUDADA',idcobro=0, interes=0,observacion='' WHERE idcobro=$c_id";
    $result = mysql_query($sql3);
	 $sql32 = "UPDATE inversiones SET estado='PENDIENTE' WHERE id=$c_idprestamo";
    $result = mysql_query($sql32);
	}else{
	
	
	$sql32 = "UPDATE inversiones SET estado='PENDIENTE',monto=monto-$c_reinvertido WHERE id=$c_idprestamo";
    $result = mysql_query($sql32);
	
	$result28 = mysql_query("SELECT * FROM inversiones WHERE id= '$c_idprestamo' order by id desc limit 1", $link); 
if ($row = mysql_fetch_array($result28)){ 
   
   do { 
   $montoprestamo=$row["monto"];
    $montofinal=$row["montofinal"];
   $interesprestamo=$row["interes"];
    $cuotasprestamo=$row["cuota"];
	    
    } while ($row = mysql_fetch_array($result28));
}

$c_int22=$interesprestamo*(1/12);
$intarestar=$c_reinvertido*($c_int22/100);
$arestar=0;

 $result2556 = mysql_query("SELECT * FROM cuotasi WHERE idprestamo= '$c_idprestamo' and estado='ADEUDADA' order by id desc", $link); 
if ($row = mysql_fetch_array($result2556)){ 
   
    
   do { 
    $idcuota11=$row["id"];
    $sql351 = "UPDATE cuotasi SET monto= monto-$intarestar WHERE id=$idcuota11";
    $result = mysql_query($sql351);
	$arestar=$arestar+$intarestar;
    } while ($row = mysql_fetch_array($result2556));
	$sql323 = "UPDATE inversiones SET montofinal=montofinal-$arestar WHERE id=$c_idprestamo";
    $result = mysql_query($sql323);
	
}
$sql2 = "DELETE FROM cobrosi WHERE id=$c_id";  	  
	 $result = mysql_query($sql2);
	 
	 $sql31 = "DELETE FROM caja2 WHERE idfacturai=$c_id";  
	   $result = mysql_query($sql31); 
	    $sql27 = "DELETE FROM reinversiones WHERE idcobro=$c_id";  	  
	 $result = mysql_query($sql27);
$sql3517 = "UPDATE cuotasi SET monto= impinicial,estado='ADEUDADA',observacion='',idcobro=0 WHERE idcobro=$c_id";
    $result = mysql_query($sql3517);
	
	
	
	}
  
  
   
      ?>
<script type="text/javascript">
window.alert("ELIMINACIÓN EXITOSA");
</script>

<?php
  }


$dnie=$_GET["dni"];
$fechae=$_GET["fecha"];
$prestamoe=$_GET["prestamo"];
$observe=$_GET["observ"];
$tipoe=$_GET["tipo"];

$dni = (!empty($_GET["dni"])
    ? " inversores.dni like '%".$_GET["dni"]."%'"
    : "");
 
$fecha = (!empty($_GET["fecha"])
    ? (!empty($dni) 
        ? " AND cobrosi.fecha like '%".$_GET["fecha"]."%'"
        : " cobrosi.fecha like '%".$_GET["fecha"]."%'")
    : "");
 
$prestamo = (!empty($_GET["prestamo"])
    ? (!empty($dni) || !empty($fecha)
        ? " AND cobrosi.idprestamo like '%".$_GET["prestamo"]."%'"
        : " cobrosi.idprestamo like '%".$_GET["prestamo"]."%'")
    : "");
	$observ = (!empty($_GET["observ"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo)
        ? " AND cobrosi.observacion like '%".$_GET["observ"]."%'"
        : " cobrosi.observacion like '%".$_GET["observ"]."%'")
    : "");
	$tipo = (!empty($_GET["tipo"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo)|| !empty($observ)
        ? " AND cobrosi.tipo like '%".$_GET["tipo"]."%'"
        : " cobrosi.tipo like '%".$_GET["tipo"]."%'")
    : "");
 

 if(empty($dni)and empty($fecha)and empty($prestamo)and empty($observ)and empty($tipo)){
 $criterio = " where (inversores.id=cobrosi.idcliente)";
 }else{

 $criterio = " where ".$dni.$fecha.$prestamo.$observ.$tipo."and (inversores.id=cobrosi.idcliente)"; }




$sql="SELECT cobrosi.id, cobrosi.idprestamo, cobrosi.tipo, cobrosi.reinvertido,cobrosi.observacion, inversores.apellido, inversores.nombre, inversores.dni, cobrosi.importe, cobrosi.cuota, cobrosi.fecha FROM inversores, cobrosi ".$criterio; 
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
       $orden="cobrosi.fecha"; 
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
$sql="SELECT  cobrosi.id, cobrosi.observacion, cobrosi.tipo, cobrosi.reinvertido, cobrosi.idprestamo, inversores.apellido, inversores.nombre, inversores.dni, cobrosi.importe, cobrosi.cuota, cobrosi.fecha FROM inversores, cobrosi ".$criterio." ORDER BY ".$orden." DESC LIMIT ".$limitInf.",".$tamPag; 
$res=mysql_query($sql); 

//////////fin consulta con limites 

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>APELLIDO</th>"; 
echo "<th>NOMBRE</th>"; 
echo "<th>DNI</th>";
echo "<th>CUOTAS</th>"; 
echo "<th>IMP.PAGADO</th>";
echo "<th>IMP.REINVERTIDO</th>";
echo "<th>INVERSION N°</th>";
echo "<th>FECHA</th>";
echo "<th>OBSERVACION</th>";
echo "<th>TIPO</th>";
echo "<th>REIMPRIMIR</th>";
echo "<th>ELIMINAR</th>"; 
echo "</TR></thead>";
$totalcaja=0;
$totalreinvertido=0;
$totalf=0;
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
          <td><? echo $registro["reinvertido"]; ?></td>
            <td><? echo $registro["idprestamo"]; ?></td>
                <td><? echo $registro["fecha"]; ?></td>  
                 <td><? echo $registro["observacion"]; ?></td>  
                 <td><? echo $registro["tipo"]; ?></td>  
                     <?  $totalcaja=$totalcaja+$registro["importe"]; ?>
                     <?  $totalreinvertido=$totalreinvertido+$registro["reinvertido"]; ?>
                       <td><? echo "<a target='_blank' class='ord' href='"."reimpresioncobroi.php?idcobro=".$registro["id"]."'>REIMPRIMIR </a>"; ?></td>
          
                <td><? echo "<a onclick='return confirmar()' class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=borrar&borrarid=".$registro["id"]."&idprestamo=".$registro["idprestamo"]."&tipocobro=".$registro["tipo"]."&reinvertido=".$registro["reinvertido"]."'>"."ELIMINAR <img src='delete.jpg'></a>"; ?></td>
      
        
    
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

<?php echo "<H1><FONT color='#31384A'>CANTIDAD DE PAGOS:".$numeroRegistros."<BR></FONT></H1>";?>
<? echo "<H1><a target='_blank' class='ord' href='"."pdfbuscarcobrosi.php?tabla=".$tabla."&dni=".$dnie."&fecha=".$fechae."&prestamo=".$prestamoe."&observ=".$observe."&tipo=".$tipoe."'>IMPRIMIR LISTADO</a></H1>"; 

echo "<h1><font color='#FF0000'>TOTAL PAGADO: ".$totalcaja."</font></H1>"; 
echo "<h1><font color='#FF0000'>TOTAL REINVERTIDO: ".$totalreinvertido."</font></H1>"; 
$totalf=$totalreinvertido+$totalcaja;
echo "<h1><font color='#FF0000'>TOTAL FINAL: ".$totalf."</font></H1>"; 
?>


















</table></td></tr>

<? 
    mysql_close(); 
?>



</div>
</td></tr></table>
</body>
</html>