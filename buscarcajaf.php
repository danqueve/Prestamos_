<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<?php require('conexionsql2.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>CONSULTA DE CAJAS DIARIAS</title> 
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
form{width:1100px; margin:auto; background: #CCCCCC;
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
.claseinput2 { width:100px;}
h1{color: #666666; text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#666666; color:rgb(255,255,255);  width:120px}
#boton:hover{cursor:pointer;}
#tabla2{
	background: rgb(255,255,255); text-align:left; width:1000px; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#999999; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;
		
		}
--> 
</style> 
</head> 
<body bgcolor="#999999" > 

<?php require('menu.php');?>

<H1>CONSULTAR CAJAS DIARIAS</H1>

<form action="buscarcajaf.php" method="get"> 
DATO A BUSCAR: 
DETALLE: <input type="text" class="claseinput2" name="detalle" > FECHA:<input class="claseinput2" type="text" name="fecha" > 
TIPO:<input class="claseinput2" type="text" name="tipo" > OBSERVACION:<input class="claseinput2" type="text" name="observ" > USUARIO:<input class="claseinput2" type="text" name="usuario" > 
<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />

<?php $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql2.php');
   $c_id = $_GET["borrarid"]; 
    	    $sql24 = "DELETE FROM caja2 WHERE id=$c_id";  	
	   $result = mysqli_query($link,$sql24);
	   
	    
  
   
      ?>
<script type="text/javascript">
window.alert("ELIMINACIÓN EXITOSA");
</script>

<?php
  }


$detallee=$_GET["detalle"];
$fechae=$_GET["fecha"];
$tipoe=$_GET["tipo"];
$observe=$_GET["observ"];
$usuarioe=$_GET["usuario"];


$detalle = (!empty($_GET["detalle"])
    ? " detalle like '%".$_GET["detalle"]."%'"
    : "");
 
$fecha = (!empty($_GET["fecha"])
    ? (!empty($detalle) 
        ? " AND fecha like '%".$_GET["fecha"]."%'"
        : " fecha like '%".$_GET["fecha"]."%'")
    : "");
 
$tipo = (!empty($_GET["tipo"])
    ? (!empty($detalle) || !empty($fecha)
        ? " AND tipo like '%".$_GET["tipo"]."%'"
        : " tipo like '%".$_GET["tipo"]."%'")
    : "");
	$observ = (!empty($_GET["observ"])
    ? (!empty($detalle) || !empty($fecha) || !empty($tipo)
        ? " AND observacion like '%".$_GET["observ"]."%'"
        : " observacion like '%".$_GET["observ"]."%'")
    : "");
	$usuario = (!empty($_GET["usuario"])
    ? (!empty($detalle) || !empty($fecha) || !empty($tipo) || !empty($observ)
        ? " AND usuario like '%".$_GET["usuario"]."%'"
        : " usuario like '%".$_GET["usuario"]."%'")
    : "");
 
if($_SESSION['usuario']=="admin"){
 if(empty($detalle)and empty($fecha)and empty($tipo)and empty($observ) and empty($usuario)){
 $criterio = " ";
 }else{

 $criterio = " where ".$detalle.$fecha.$tipo.$observ.$usuario; }

}else{

 if(empty($detalle)and empty($fecha)and empty($tipo)and empty($observ)and empty($usuario)){
 $criterio = " where usuario='".$_SESSION['usuario']."'";
 }else{

 $criterio = " where ".$detalle.$fecha.$tipo.$observ.$usuario." and  usuario='".$_SESSION['usuario']."'"; }
}


$sql="SELECT * FROM caja2 ".$criterio; 
$tabla="caja2";
$res=mysqli_query($link,$sql); 
$numeroRegistros=mysqli_num_rows($res); 
if($numeroRegistros<=0) 
{ 
    
    echo "<h1>No se encontraron resultados</h1>"; 

}else{ 
    //////////elementos para el orden 
    if(!isset($orden)) 
    { 
       $orden="fecha"; 
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
$sql="SELECT  * FROM caja2 ".$criterio." ORDER BY ".$orden." DESC LIMIT ".$limitInf.",".$tamPag; 
$res=mysqli_query($link,$sql); 

//////////fin consulta con limites 

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>DETALLE</th>"; 
echo "<th>IMPORTE</th>"; 
echo "<th>FECHA</th>";
echo "<th>OBSERVACION</th>"; 
echo "<th>TIPO</th>";
echo "<th>USUARIO</th>";

echo "</TR></thead>";
$totalcaja=0;
while($registro=mysqli_fetch_array($res)) 
{ 
?> 
   <!-- tabla de resultados --> 
    <tr  bgcolor="#DDD" onMouseOver="this.style.backgroundColor='#FFCC99';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#DDD'"o"];" > 
        <td><?php echo mb_strtoupper(trim($registro["detalle"]),'UTF-8'); ?></td> 
                 <td><?php echo $registro["importe"]; ?></td>
                   <td><?php echo $registro["fecha"]; ?></td>
                   <td><?php echo mb_strtoupper(trim($registro["observacion"]),'UTF-8');  ?></td>
            <td><?php echo $registro["tipo"]; ?></td>
            <td><?php echo $registro["usuario"]; ?></td>
              <?php $totalcaja=$totalcaja + $registro["importe"]; ?>
          
                
      
        
    
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

<?php echo "<H1><FONT color='#31384A'>CANTIDAD DE REGISTROS:".$numeroRegistros."<BR></FONT></H1>";?>
<?php echo "<H1><a target='_blank' class='ord' href='"."pdfingresos2.php?tabla=".$tabla."&detalle=".$detallee."&fecha=".$fechae."&tipo=".$tipoe."&observ=".$observe."&usuario=".$usuarioe."'>IMPRIMIR LISTADO</a></H1>"; 
echo "<H1><a target='_blank' class='ord' href='"."aexcelie.php?tabla=".$tabla."&detalle=".$detallee."&fecha=".$fechae."&tipo=".$tipoe."&observ=".$observe."&usuario=".$usuarioe."'>ENVIAR A EXCEL</a></H1>"; 
echo "<h1><font color='#666666'>TOTAL: ".$totalcaja."</font>"; 

?>


















</table></td></tr>





</div>
</td></tr></table>
</body>
</html>