<style type="text/css">
<!--
.xl65
 {mso-style-parent:style0;
 mso-number-format:"\@";}

-->
</style>
<?php 
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header("Content-Disposition: attachment; filename=inversores.xls" ) ; 
//en la sigte linea colocar entre comillas el nombre del servidor mysql (generalmente, localhost) 
$servidor="localhost"; 
//en la sigte linea colocar entre comillas el nombre de usuario 
$user="root"; 
//en la sigte linea colocar entre comillas la contraseña 
$pass="rootroot"; 
//en la sigte linea colocar entre comillas e nombre de la base de datos 
$db="prestamos"; 
//en la sigte linea colocar entre comillas e nombre de la tabla
$tabla = $_GET["tabla"];
$numeroalumnos = $_GET["numeroabonados"];
$txt_criterio = $_GET["criterio"]; 
require('conexionsql.php');
$consulta="SELECT apellido,nombre,dni,direccion,telefono,referencia,telefonoref as telref,relacion from ". $tabla. " where (apellido like '%" . $txt_criterio . "%' or nombre like '%" . $txt_criterio . "%'or dni like '%" . $txt_criterio . "%')  order by apellido asc"; 
mysql_query("SET NAMES 'utf8'");
$qry=mysql_query($consulta) ; 
$campos = mysql_num_fields($qry) ; 
$i=0; 
echo "<table><tr>"; 
while($i<$campos){ 
echo "<td>". strtoupper(mysql_field_name ($qry, $i)) ; 
echo "</td>"; 
$i++; 
} 
echo "</tr>"; 
while($row=mysql_fetch_array($qry)){ 
echo "<tr>"; 
for($j=0; $j<$campos; $j++) { 
echo "<td class=xl65>". ucwords(utf8_decode($row[$j]))."</td>"; 
} 


echo "</tr>"; 
} 
echo "</table>"; 
?> 