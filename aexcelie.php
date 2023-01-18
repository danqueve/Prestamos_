<style type="text/css">
<!--
.xl65
 {mso-style-parent:style0;
 mso-number-format:"\@";}

-->
</style>
<?php 
error_reporting(E_ERROR | E_WARNING | E_PARSE);
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header("Content-Disposition: attachment; filename=informeingresosegresos.xls" ) ; 
//en la sigte linea colocar entre comillas el nombre del servidor mysqli (generalmente, localhost) 
$servidor="localhost"; 
//en la sigte linea colocar entre comillas el nombre de usuario 
$user="root"; 
//en la sigte linea colocar entre comillas la contraseña 
$pass="rootroot"; 
//en la sigte linea colocar entre comillas e nombre de la base de datos 
$db="prestamos"; 
//en la sigte linea colocar entre comillas e nombre de la tabla

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
 $criterio = " ";
 }else{

 $criterio = " where ".$detalle.$fecha.$tipo.$observ.$usuario." "; }
}


$tabla = $_GET["tabla"];
$usuarionuevo = $_SESSION['usuario'];
$txt_criterio = $_GET["criterio"]; 
require('conexionsql2.php');


	$consulta="SELECT fecha,detalle,importe,observacion,tipo from  caja2 ".$criterio." order by fechasql desc";
	
	
mysqli_query($link,"SET NAMES 'utf8'");
$qry=mysqli_query($link,$consulta) ; 
$campos = mysqli_num_fields($qry) ; 
$i=0; 
echo "<table><tr>"; 
while($i<$campos){ 
echo "<td>". mysqli_fetch_field_direct($qry, $i)->name; 
echo "</td>"; 
$i++; 
} 
echo "</tr>"; 
while($row=mysqli_fetch_array($qry)){ 
echo "<tr>"; 
for($j=0; $j<$campos; $j++) { 
echo "<td class=xl65>". utf8_decode($row[$j])."</td>"; 
} 


echo "</tr>"; 
} 
echo "</table>"; 
?> 