<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</HEAD>
<?php
require('conexion.php');

$busqueda= mb_strtolower(trim($_POST["busqueda"]),'UTF-8'); 
// DEBO PREPARAR LOS TEXTOS QUE VOY A BUSCAR si la cadena existe
if ($busqueda<>''){
	//CUENTA EL NUMERO DE PALABRAS
	$trozos=explode(" ",$busqueda);
	$numero=count($trozos);
	if ($numero==1) {
		//SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
		$cadbusca="SELECT * FROM inversores WHERE apellido LIKE '%$busqueda%'  LIMIT 10;";
	} elseif ($numero>1) {
		//SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
		//busqueda de frases con mas de una palabra y un algoritmo especializado
		$cadbusca="SELECT * FROM inversores WHERE apellido LIKE '%$busqueda%'  LIMIT 10;";
	}
	
	function limitarPalabras($cadena, $longitud, $elipsis = "..."){
		$palabras = explode(' ', $cadena);
		if (count($palabras) > $longitud)
			return implode(' ', array_slice($palabras, 0, $longitud)) . $elipsis;
		else
			return $cadena;
	}
?>
<style type="text/css">
<!--
.Estilo1 {
	color: #990000;
	font-weight: bold;
}
#tabla{
	background: rgb(255,255,255); text-align:left; width:700px; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#246355; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;)
		
		}
-->
</style>

	<table align="center" id="tabla"> 
	<thead>
		<tr>
			<th>APELLIDO</th>
		  <th>NOMBRE</th>
          <th>DNI</th><th>DIRECCION</th>
          <th>TELEFONO</th>
        	  </tr></thead>
<?php
	$result=mysql_query($cadbusca, $con);
	$i=1;
		while ($row = mysql_fetch_array($result)){
		echo "
			<tr>
				<td >".mb_strtoupper(trim($row["apellido"]),'UTF-8')."</td>
				<td >".mb_strtoupper(trim($row["nombre"]),'UTF-8')."</td>
				<td >".$row['dni']."</td>
					<td >".mb_strtoupper(trim($row["direccion"]),'UTF-8')."</td>
				<td >".$row['telefono']."</td>
								
			</tr>";
		$i++;
	}
}
?>
	</tbody>
	</table>