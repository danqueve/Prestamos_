<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<?php require('conexionsql2.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>CONSULTA DE PRESTAMOS CANCELADOS</title> 
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
form{width:450px; margin:auto; background: #CCCCCC;
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{color: #666666; text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#666666; color:rgb(255,255,255); padding:20px;}
#boton:hover{cursor:pointer;}
#tabla2{
	background: rgb(255,255,255); text-align:left; width:1100px; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#999999; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;
		
		}
--> 
</style> 
</head> 
<body bgcolor="#999999" > 

<?php require('menu.php');?>

<H1>CONSULTAR PRESTAMOS</H1>

<form action="cancelados.php" method="get"> 
DATO A BUSCAR: 
<input  type="text" name="criterio" size="22" maxlength="150" placeholder="Ingrese dato a buscar"> 
<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />

<?php $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql2.php');
   $c_id = $_GET["borrarid"]; 
    
    $sql2 = "DELETE FROM prestamos WHERE id=$c_id";  	
	   $result = mysqli_query($link,$sql2);
	   $sql3 = "DELETE FROM cuotas WHERE idprestamo=$c_id";  
	   $result = mysqli_query($link,$sql3); 
	   $sql4 = "DELETE FROM cobros WHERE idprestamo=$c_id";  
	   $result = mysqli_query($link,$sql4); 
  
  
   
      ?>
<script type="text/javascript">
window.alert("ELIMINACIÓN EXITOSA");
</script>

<?php
  }


//inicializo el criterio y recibo cualquier cadena que se desee buscar 
$criterio = ""; 
$txt_criterio = ""; 
if($_SESSION['rol']=="ADMINISTRADOR"){
$criterio = " where (clientes.apellido like '%" . $txt_criterio . "%' or clientes.nombre like '%" . $txt_criterio . "%' or prestamos.fecha like '%" . $txt_criterio . "%'  or clientes.dni like '%" . $txt_criterio . "%') and (clientes.id=prestamos.idcliente) and (prestamos.estado='CANCELADO')"; 
if ($_GET["criterio"]!=""){ 
   $txt_criterio = $txt_criterio = mb_strtolower(trim($_GET["criterio"]),'UTF-8'); 
  $criterio = " where (clientes.apellido like '%" . $txt_criterio . "%' or clientes.nombre like '%" . $txt_criterio . "%'  or prestamos.fecha like '%" . $txt_criterio . "%' or clientes.dni like '%" . $txt_criterio . "%') and (clientes.id=prestamos.idcliente) and (prestamos.estado='CANCELADO')"; 
} 
}else{
$criterio = " where (clientes.apellido like '%" . $txt_criterio . "%' or clientes.nombre like '%" . $txt_criterio . "%' or prestamos.fecha like '%" . $txt_criterio . "%'  or clientes.dni like '%" . $txt_criterio . "%') and (clientes.id=prestamos.idcliente) and (prestamos.estado='CANCELADO') and (prestamos.usuario='".$_SESSION['usuarionuevo']."') "; 
if ($_GET["criterio"]!=""){ 
   $txt_criterio = $txt_criterio = mb_strtolower(trim($_GET["criterio"]),'UTF-8'); 
  $criterio = " where (clientes.apellido like '%" . $txt_criterio . "%' or clientes.nombre like '%" . $txt_criterio . "%'  or prestamos.fecha like '%" . $txt_criterio . "%' or clientes.dni like '%" . $txt_criterio . "%') and (clientes.id=prestamos.idcliente) and (prestamos.estado='CANCELADO') and (prestamos.usuario='".$_SESSION['usuarionuevo']."') "; 
} 

}


$sql="SELECT prestamos.estado,prestamos.usuario,prestamos.id as idprestamo, clientes.apellido, clientes.nombre, clientes.dni, prestamos.monto, prestamos.interes, prestamos.cuota, prestamos.fecha, prestamos.montofinal FROM clientes, prestamos ".$criterio; 
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
$sql="SELECT prestamos.estado,prestamos.usuario,prestamos.id as idprestamo, clientes.apellido, clientes.nombre, clientes.dni, prestamos.monto, prestamos.interes, prestamos.cuota, prestamos.fecha, prestamos.montofinal FROM clientes, prestamos ".$criterio." ORDER BY ".$orden." ASC LIMIT ".$limitInf.",".$tamPag; 
$res=mysqli_query($link,$sql); 

$montototal=0;
$montototalf=0;

//////////fin consulta con limites 

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>APELLIDO</th>"; 
echo "<th>NOMBRE</th>"; 
echo "<th>DNI</th>";
echo "<th>PRESTAMO N°</th>"; 
echo "<th>MONTO</th>";
if($_SESSION['rol']=="ADMINISTRADOR"){ 
echo "<th>INTERES</th>";}
echo "<th>MONTO FINAL</th>";
echo "<th>CUOTAS</th>";
echo "<th>FECHA</th>";
echo "<th>ESTADO</th>";
echo "<th>USUARIO</th>";
echo "<th>REIMPRIMIR</th>";
echo "<th>IMPRIMIR CONSTANCIA</th>";
echo "</TR></thead>";
while($registro=mysqli_fetch_array($res)) 
{ 
?> 
   <!-- tabla de resultados --> 
    <tr  bgcolor="#DDD" onMouseOver="this.style.backgroundColor='#FFCC99';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#DDD'"o"];" > 
        <td><?php echo mb_strtoupper(trim($registro["apellido"]),'UTF-8'); ?></td> 
         <td><?php echo mb_strtoupper(trim($registro["nombre"]),'UTF-8');  ?></td> 
         <td><?php echo $registro["dni"]; ?></td>
         <td><?php echo mb_strtoupper(trim($registro["idprestamo"]),'UTF-8');  ?></td>
          <td><?php echo $registro["monto"]; ?></td>
            <?php if($_SESSION['rol']=="ADMINISTRADOR"){ ?>
            <td><?php echo $registro["interes"]; ?></td>
              <?php } ?>
            <td><?php echo $registro["montofinal"]; ?></td>
            <td><?php echo $registro["cuota"]; ?></td>
            <?php $montototal=$montototal+$registro["monto"];
			 $montototalf=$montototalf+$registro["montofinal"];
			?>

            
     <td><?php echo $registro["fecha"]; ?></td> 
            <td><?php echo $registro["estado"]; ?></td> 
              <td><?php echo $registro["usuario"]; ?></td> 
             <td><?php echo "<a target='_blank' class='ord' href='"."reimpresion.php?idprestamo=".$registro["idprestamo"]."'>REIMPRIMIR </a>"; ?></td>
                <td><?php echo "<a target='_blank' class='ord' href='"."constancia.php?idprestamo=".$registro["idprestamo"]."'>IMPRIMIR CONSTANCIA </a>"; ?></td>
               
        
    
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
    <?php $ganancia=$montototalf-$montototal;
	?>

<?php echo "<H1><FONT color='#999999'>CANTIDAD DE PRESTAMOS:".$numeroRegistros."<BR></FONT></H1>";?>
<?php echo "<H1><FONT color='#999999'>TOTAL MONTO PRESTADO:".$montototal."<BR></FONT></H1>";?>
<?php echo "<H1><FONT color='#999999'>TOTAL MONTO COBRADO:".$montototalf."<BR></FONT></H1>";?>
<?php echo "<H1><FONT color='#999999'>GANANCIA:".$ganancia."<BR></FONT></H1>";?>
<?php echo "<H1><a target='_blank' class='ord' href='"."pdfprestamos2.php?criterio=".$txt_criterio."&numeroprestamos=".$numeroRegistros."'>IMPRIMIR LISTADO</a></H1>"; ?>

















</table></td></tr>





</div>
</td></tr></table>
</body>
</html>