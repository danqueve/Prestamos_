<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<?php require('conexionsql2.php');

?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>BUSCAR PRESTAMOS</title> 
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" /> 
<script>
function cargar(apellido,nombre,dni,idcliente,prestamo,monto,interes,producto){
opener.document.form1.nombre.value=nombre;
opener.document.form1.apellido.value=apellido;
opener.document.form1.idcliente.value=idcliente;
opener.document.form1.dni.value=dni;
opener.document.form1.monto.value=monto;
opener.document.form1.interes.value=interes;
opener.document.form1.prestamo.value=prestamo;
opener.document.form1.producto.value=producto;
window.close();
}

</script>


</head> 
<body > 

<table width="700" align="center" bgcolor="#FFFFFF" ><tr><td>
<form action="paginaprestamo.php" method="get"> 
DATO A BUSCAR: 
<input type="text" name="criterio" size="22" maxlength="150"> 
<input type="submit" value="Buscar"> 
</form> 
<hr noshade style="color:CC6666;height:1px"> 
<br> 


<?php require('conexionsql2.php');
if($_SESSION['rol']=="ADMINISTRADOR"){
//inicializo el criterio y recibo cualquier cadena que se desee buscar 
$criterio =  "  where (prestamos.idcliente =  clientes.id) and (prestamos.estado='PENDIENTE') and (clientes.apellido like '%" . $txt_criterio . "%' or clientes.nombre like '%" . $txt_criterio . "%' or clientes.dni like '%" . $txt_criterio . "%'or clientes.observacion like '%" . $txt_criterio . "%')"; 
$txt_criterio = ""; 
if ($_GET["criterio"]!=""){ 
   $txt_criterio = mb_strtolower(trim($_GET["criterio"]),'UTF-8'); 
 $criterio =  "  where (prestamos.idcliente =  clientes.id) and (prestamos.estado='PENDIENTE') and (clientes.apellido like '%" . $txt_criterio . "%' or clientes.nombre like '%" . $txt_criterio . "%' or clientes.dni like '%" . $txt_criterio . "%'or clientes.observacion like '%" . $txt_criterio . "%')"; 
} 
}else{

//inicializo el criterio y recibo cualquier cadena que se desee buscar 
$criterio =  "  where (prestamos.idcliente =  clientes.id) and (prestamos.estado='PENDIENTE') and (clientes.apellido like '%" . $txt_criterio . "%' or clientes.nombre like '%" . $txt_criterio . "%' or clientes.dni like '%" . $txt_criterio . "%'or clientes.observacion like '%" . $txt_criterio . "%')"; 
$txt_criterio = ""; 
if ($_GET["criterio"]!=""){ 
   $txt_criterio = mb_strtolower(trim($_GET["criterio"]),'UTF-8'); 
 $criterio =  "  where (prestamos.idcliente =  clientes.id) and (prestamos.estado='PENDIENTE') and (clientes.apellido like '%" . $txt_criterio . "%' or clientes.nombre like '%" . $txt_criterio . "%' or clientes.dni like '%" . $txt_criterio . "%'or clientes.observacion like '%" . $txt_criterio . "%')"; 
} 

}


$sql="SELECT prestamos.observacion,prestamos.estado, prestamos.id as prestamo, clientes.nombre, clientes.apellido, clientes.dni,prestamos.idcliente, prestamos.monto, prestamos.interes, prestamos.fecha FROM prestamos , clientes   ".$criterio; 
$res=mysqli_query($link,$sql); 
$numeroRegistros=mysqli_num_rows($res); 
if($numeroRegistros<=0) 
{ 
    echo "<div align='center'>"; 
    echo "<font face='verdana' size='-2'>No se encontraron resultados</font>"; 
    echo "</div>"; 
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
$sql="SELECT prestamos.observacion,prestamos.estado, prestamos.id as prestamo, clientes.nombre, clientes.apellido, clientes.dni,prestamos.idcliente, prestamos.monto, prestamos.interes, prestamos.fecha FROM clientes,prestamos ".$criterio." ORDER BY ".$orden." ASC LIMIT ".$limitInf.",".$tamPag; 
$res=mysqli_query($link,$sql); 

//////////fin consulta con limites 

     ?>
     <form name="f1" id="f1" action="" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><B>APELLIDO</B></td>
    <td><B>NOMBRE</B></td>
     <td><B>DNI</B></td>
     <td><B>MONTO</B></td>
      <td><B>PREST N°</B></td>
       <td><B>FECHA</B></td>
       <td><B>PRODUCTO</B></td>
    <td>&nbsp;</td>
  </tr>
  <?php while($row=mysqli_fetch_assoc($res)){?>
  <tr><td colspan="8"><hr color="#990000"></td></tr>
  <tr>
  
 
    <td ><font  size="2"><?php echo mb_strtoupper(trim($row["apellido"]),'UTF-8') ?></font></td>
    <td ><font  size="2"><?php echo mb_strtoupper(trim($row["nombre"]),'UTF-8') ?></font></td>
       <td ><?php echo $row['dni'] ?></td>
        <td ><?php echo $row['monto'] ?></td>
        <td ><?php echo $row['prestamo'] ?></td>
        <td ><?php echo $row['fecha'] ?></td>
        <td ><?php echo $row['observacion'] ?></td>
       <td ><input type="button" name="Submit" value="cargar" onClick="cargar('<?php echo mb_strtoupper(trim($row["apellido"]),'UTF-8') ?>','<?php echo mb_strtoupper(trim($row["nombre"]),'UTF-8') ?>','<?php echo $row['dni'] ?>','<?php echo $row['idcliente'] ?>','<?php echo $row['prestamo'] ?>','<?php echo $row['monto'] ?>','<?php echo $row['interes'] ?>','<?php echo $row['observacion'] ?>')"></td>
  </tr><?php } ?>
</table></form>
     
   <!-- fin tabla resultados --> 
<?php }//fin while 








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
<hr noshade style="color:CC6666;height:1px"> 



</table></td></tr>
</body> 
</html> 




</div>
</td></tr></table>
</body>
</html>