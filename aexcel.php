<style type="text/css">
<!--
.xl65
 {mso-style-parent:style0;
 mso-number-format:"\@";}

-->
</style>
<?php 
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header("Content-Disposition: attachment; filename=clientes.xls" ) ; 
//en la sigte linea colocar entre comillas el nombre del servidor mysqli (generalmente, localhost) 
$servidor="localhost"; 
//en la sigte linea colocar entre comillas el nombre de usuario 
$user="root"; 
//en la sigte linea colocar entre comillas la contraseña 
$pass="root"; 
//en la sigte linea colocar entre comillas e nombre de la base de datos 
$db="prestamos"; 
//en la sigte linea colocar entre comillas e nombre de la tabla
$tabla = $_GET["tabla"];
$numeroalumnos = $_GET["numeroabonados"];
$txt_criterio = $_GET["criterio"]; 
require('conexionsql2.php');
$consulta="SELECT apellido,nombre,dni,estadocivil,fechanac,email,direccion,ciudad,cp,provincia,telefono,celular,observacion,limite,sueldo,trabajo,direccione,ciudade, telefonotrabajo, telefono2, interno from ". $tabla. " where (apellido like '%" . $txt_criterio . "%' or nombre like '%" . $txt_criterio . "%'or dni like '%" . $txt_criterio . "%' or ciudad like '%" . $txt_criterio . "%'or provincia like '%" . $txt_criterio . "%')  order by apellido asc"; 
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
echo "<td class=xl65>". ucwords(utf8_decode($row[$j]))."</td>"; 
} 


echo "</tr>"; 
} 
echo "</table>"; 
?> 