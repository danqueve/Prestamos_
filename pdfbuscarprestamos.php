<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<?php require_once('class.ezpdf.php');
$pdf =new Cezpdf('legal','landscape');
$pdf->selectFont('/fonts/courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
require('conexionsql2.php');



$tabla = $_GET["tabla"];


$dnie=$_GET["dni"];
$fechae1=$_GET["fecha1"];
$fechae2=$_GET["fecha2"];
$prestamoe=$_GET["prestamo"];
$apellidoe=$_GET["apellido"];
$ciudade=$_GET["ciudad"];
$usuarioe=$_GET["usuario2"];
$vendedore=$_GET["vendedor"];

$fechan1 =date('Ymd', strtotime($_GET['fecha1']));
$fechan2 =date('Ymd', strtotime($_GET['fecha2']));

$dni = (!empty($_GET["dni"])
    ? " clientes.dni like '%".$_GET["dni"]."%'"
    : "");
 
$fecha = (!empty($_GET["fecha1"]) && !empty($_GET["fecha2"])
    ? (!empty($dni) 
        ? " AND prestamos.fechasql BETWEEN ".$fechan1." AND ".$fechan2." "
        : " prestamos.fechasql BETWEEN ".$fechan1." AND ".$fechan2." ")
    : "");
 
$prestamo = (!empty($_GET["prestamo"])
    ? (!empty($dni) || !empty($fecha)
        ? " AND prestamos.id like '%".$_GET["prestamo"]."%'"
        : " prestamos.id like '%".$_GET["prestamo"]."%'")
    : "");
	
	$apellido = (!empty($_GET["apellido"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo)
        ? " AND clientes.apellido like '%".$_GET["apellido"]."%'"
        : " clientes.apellido like '%".$_GET["apellido"]."%'")
    : "");
	
		$ciudad = (!empty($_GET["ciudad"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo) || !empty($apellido)
        ? " AND clientes.ciudad like '%".$_GET["ciudad"]."%'"
        : " clientes.ciudad like '%".$_GET["ciudad"]."%'")
    : "");
	$usuario2 = (!empty($_GET["usuario2"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo) || !empty($apellido) || !empty($ciudad)
        ? " AND prestamos.usuario like '%".$_GET["usuario2"]."%'"
        : " prestamos.usuario like '%".$_GET["usuario2"]."%'")
    : "");
	$vendedor = (!empty($_GET["vendedor"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo) || !empty($apellido) || !empty($ciudad)|| !empty($usuario2)
        ? " AND prestamos.vendedor like '%".$_GET["vendedor"]."%'"
        : " prestamos.vendedor like '%".$_GET["vendedor"]."%'")
    : "");
	
 
if($_SESSION['rol']=="ADMINISTRADOR"){
 if(empty($dni)and empty($fecha)and empty($prestamo) and empty($apellido) and empty($ciudad)and empty($usuario2)and empty($vendedor)){
 $criterio = " where (clientes.id=prestamos.idcliente)";
 }else{

 $criterio = " where ".$dni.$fecha.$prestamo.$apellido.$ciudad.$usuario2.$vendedor."and (clientes.id=prestamos.idcliente)"; }
}else{

if(empty($dni)and empty($fecha)and empty($prestamo) and empty($apellido) and empty($ciudad)and empty($usuario2)and empty($vendedor)){
 $criterio = " where (clientes.id=prestamos.idcliente) and (prestamos.usuario='".$_SESSION['usuarionuevo']."') ";
 }else{

 $criterio = " where ".$dni.$fecha.$prestamo.$apellido.$ciudad.$usuario2.$vendedor."and (clientes.id=prestamos.idcliente) and (prestamos.usuario='".$_SESSION['usuarionuevo']."') "; }

}



$consulta="SELECT prestamos.observacion,prestamos.vendedor,prestamos.usuario,prestamos.estado,prestamos.observ, prestamos.id as idprestamo, clientes.apellido, clientes.nombre, clientes.ciudad, clientes.dni, prestamos.monto, prestamos.interes, prestamos.cuota, prestamos.fecha, prestamos.montofinal FROM clientes, prestamos ".$criterio."  order by clientes.apellido ASC"; 

 
$queEmp = $consulta;
$resEmp = mysqli_query($link,$queEmp) or die(mysqli_error());
$totEmp = mysqli_num_rows($resEmp);
$ixx = 0;
while($datatmp = mysqli_fetch_assoc($resEmp)) { 
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}

$cc=count($data);
for($y=0; $y<$cc; $y++)
{
  $totalvalor+=$data[$y]['monto'];
   $totalfinal+=$data[$y]['montofinal'];
     
 }
 
  if(!empty($vendedore)){
require('conexionsql2.php');
$result257 = mysqli_query($link,"SELECT * FROM datos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result257)){ 
   
   do { 
   $comisionv=$row["comisionv"];
  
    } while ($row = mysqli_fetch_array($result257));
}

$comisionv=$comisionv/100;
$apagarvendedor=$comisionv*$totalvalor;
 
}
 
 
 $cc=count($data);
for($y=0; $y<$cc; $y++)
{
  $data[$y]['apellido']=ucwords($data[$y]['apellido']);
    $data[$y]['nombre']=ucwords($data[$y]['nombre']);
 }
 
 
 $totales=array(
               array(
                     'concepto'=>"TOTAL",
                     'TOTAL CAPITAL'=>$totalvalor,
					  'TOTAL INTERESES'=>$totalfinal-$totalvalor,
					  'TOTAL FINAL'=>$totalfinal,
					   'COMISION A VENDEDOR'=>$apagarvendedor,
                    )
              );

$titles = array(
				'apellido'=>'<b>APELL</b>',
				'nombre'=>'<b>NOMB</b>',
				'dni'=>'<b>DNI</b>',
				'ciudad'=>'<b>CIUDAD</b>',
				'idprestamo'=>'<b>PREST N°</b>',
				'monto'=>'<b>MONTO</b>',
									'montofinal'=>'<b>MONTO FINAL</b>',
						'cuota'=>'<b>CUOTAS</b>',
						'fecha'=>'<b>FECHA</b>',
						'observacion'=>'<b>PROD</b>',
						'estado'=>'<b>ESTADO</b>',
						'vendedor'=>'<b>VENDEDOR</b>',
						'usuario'=>'<b>USUARIO</b>',
						'observ'=>'<b>OBSERV</b>',
						
					);
$options = array(
				'shadeCol'=>array(0.6,0.6,0.6),
				'xOrientation'=>'center',
				'width'=>900
			);
			$optotal = array(
                'shadeCol'=>array(0.5,0.5,0.5),
                'xOrientation'=>'center',
                'width'=>900,
                'cols'=>array(
                              'concepto'=>array('justification'=>'left','width'=>80),
                              'total'=>array('justification'=>'left','width'=>80)
                             )
            );
$txttit = "<b>INFORME</b>\n";
$txttit.= "PRESTAMOS\n";
$txttit .= "<b>CANTIDAD DE PRESTAMOS EN CONSULTA:</b>".$numeroprestamos." \n";
$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezTable($totales, $totalestitulos, '', $optotal);
$pdf->ezText("\n\n\n", 5);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();
?>
