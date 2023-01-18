<? include ("seguridad.php");?>
<? 
require('conexionsql.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>MODIFICAR PRESTAMOS</title> 
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
<script language="JavaScript"> 
function chequear(){  

    if(recomienda.producto.value=="")   {
      alert("producto no ingresado.");   
	  return(false);}   
			   
								  else {
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
	background: rgb(255,255,255); text-align:left; width:1100px; border-collapse:collapse}
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

<H1>CONSULTAR PRESTAMOS</H1>

<form action="modificarprestamos.php" method="get"> 
DATO A BUSCAR: 
<input  type="text" name="criterio" size="22" maxlength="150" placeholder="Ingrese dato a buscar"> 
<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />


<?
if(isset($_POST['enviar'])) {
if (strtoupper($_POST["producto"])==""){
echo "<h1>Campos Vacios</h1> ";}
else{
require('conexionsql.php');
   $c_id = $_POST["id"]; 
$c_producto = mb_strtolower(trim($_POST["producto"]),'UTF-8');  
   
   $sql = "UPDATE prestamos SET observacion='$c_producto'  WHERE id=$c_id";
      $result = mysql_query($sql);
	  	  
	  
   ?>
<script type="text/javascript">
window.alert("MODIFICACION EXITOSA");
</script>

<?php 


} 

}
   

$bandera = $_GET["bandera"];

if ($bandera=="modificar"){

require('conexionsql.php');
   $c_id=$_GET["modificarid"];
   $sql = $query = "SELECT * from prestamos WHERE id LIKE '%{$c_id}%'" ;
   $result = mysql_query($sql);   
 if ($row = mysql_fetch_array($result)){ 
 
 $c_producto= $row["observacion"]; 


  
 
    ?>
<div align="center"><H1>MODIFICAR DATOS:</H1><br>
<form method="post" onSubmit="return chequear();" action="modificarprestamos.php" name="recomienda">
<input type="Text" style="display: none;" readonly size="10" <? echo "value='$c_id'" ?> name="id">
    PRODUCTO  :<input  type="Text" size="40" <? echo "value='$c_producto'"  ?> name="producto">
       
            
   <input type="Submit"  id="boton" name="enviar" value="GUARDAR CAMBIOS"> 
  </form> </div>

<? }} ?>







<?PHP


//inicializo el criterio y recibo cualquier cadena que se desee buscar 
$criterio = ""; 
$txt_criterio = ""; 
$criterio = " where (clientes.apellido like '%" . $txt_criterio . "%' or clientes.nombre like '%" . $txt_criterio . "%'or clientes.dni like '%" . $txt_criterio . "%'or prestamos.estado like '%" . $txt_criterio . "%'or prestamos.observacion like '%" . $txt_criterio . "%') and (clientes.id=prestamos.idcliente)"; 
if ($_GET["criterio"]!=""){ 
   $txt_criterio = $txt_criterio = mb_strtolower(trim($_GET["criterio"]),'UTF-8'); 
  $criterio = " where (clientes.apellido like '%" . $txt_criterio . "%' or clientes.nombre like '%" . $txt_criterio . "%'or clientes.dni like '%" . $txt_criterio . "%'or prestamos.estado like '%" . $txt_criterio . "%'or prestamos.observacion like '%" . $txt_criterio . "%') and (clientes.id=prestamos.idcliente)"; 
} 


$sql="SELECT prestamos.observacion, prestamos.estado,prestamos.id as idprestamo, clientes.apellido, clientes.nombre, clientes.dni, prestamos.monto, prestamos.interes, prestamos.cuota, prestamos.fecha, prestamos.montofinal FROM clientes, prestamos ".$criterio; 
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
$sql="SELECT prestamos.observacion,prestamos.estado,prestamos.id as idprestamo, clientes.apellido, clientes.nombre, clientes.dni, prestamos.monto, prestamos.interes, prestamos.cuota, prestamos.fecha, prestamos.montofinal FROM clientes, prestamos ".$criterio." ORDER BY ".$orden." ASC LIMIT ".$limitInf.",".$tamPag; 
$res=mysql_query($sql); 

//////////fin consulta con limites 

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>APELLIDO</th>"; 
echo "<th>NOMBRE</th>"; 
echo "<th>DNI</th>";
echo "<th>PRESTAMO N°</th>"; 
echo "<th>MONTO</th>";
echo "<th>INTERES</th>";
echo "<th>MONTO FINAL</th>";
echo "<th>CUOTAS</th>";
echo "<th>FECHA</th>";
echo "<th>PRODUCTO</th>";
echo "<th>ESTADO</th>";
echo "<th>MODIFICAR</th>";
echo "</TR></thead>";
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
            <td><? echo $registro["interes"]; ?></td>
            <td><? echo $registro["montofinal"]; ?></td>
            <td><? echo $registro["cuota"]; ?></td>
     <td><? echo $registro["fecha"]; ?></td> 
      <td><? echo $registro["observacion"]; ?></td> 
            <td><? echo $registro["estado"]; ?></td> 
             <td><? echo "<a class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=modificar&modificarid=".$registro["idprestamo"]."'>"."MODIFICAR </a>"; ?></td> 
               
      
        
    
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

<?php echo "<H1><FONT color='#31384A'>CANTIDAD DE PRESTAMOS:".$numeroRegistros."<BR></FONT></H1>";?>


















</table></td></tr>

<? 
    mysql_close(); 
?>



</div>
</td></tr></table>
</body>
</html>