<?php require_once('class.ezpdf.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$pdf =new Cezpdf('legal','landscape');
$pdf->selectFont('/fonts/courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
require('conexionsql2.php');



$tabla = $_GET["tabla"];
$cantidadc = $_GET["cantidadc"];

$fechae1=$_GET["fecha1"];
$fechae2=$_GET["fecha2"];
$prestamoe=$_GET["prestamo"];
$apellidoe=$_GET["apellido"];
$fechan1 =date('Ymd', strtotime($_GET['fecha1']));
$fechan2 =date('Ymd', strtotime($_GET['fecha2']));

$dni = (!empty($_GET["dni"])
    ? " clientes.dni like '%".$_GET["dni"]."%'"
    : "");
 
$fecha = (!empty($_GET["fecha1"]) && !empty($_GET["fecha2"])
    ? (!empty($dni) 
        ? " AND cuotas.fechasql BETWEEN ".$fechan1." AND ".$fechan2." "
        : " cuotas.fechasql BETWEEN ".$fechan1." AND ".$fechan2." ")
    : "");
 
$prestamo = (!empty($_GET["prestamo"])
    ? (!empty($dni) || !empty($fecha)
        ? " AND cuotas.idprestamo like '".$_GET["prestamo"]."'"
        : " cuotas.idprestamo like '".$_GET["prestamo"]."'")
    : "");
	
	$apellido = (!empty($_GET["apellido"])
    ? (!empty($dni) || !empty($fecha) || !empty($prestamo)
        ? " AND clientes.apellido like '%".$_GET["apellido"]."%'"
        : " clientes.apellido like '%".$_GET["apellido"]."%'")
    : "");
	
		
 

 if(empty($dni)and empty($fecha)and empty($prestamo) and empty($apellido)){
 $criterio = " where (clientes.id=cuotas.idcliente) and cuotas.estado='ADEUDADA'";
 }else{

 $criterio = " where ".$dni.$fecha.$prestamo.$apellido."and (clientes.id=cuotas.idcliente) and cuotas.estado='ADEUDADA'"; }
 
 $result257 = mysqli_query($link,"SELECT * FROM datos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result257)){ 
   
   do { 
   $pordia=$row["pordia"];
  
    } while ($row = mysqli_fetch_array($result257));
}

$pordia=$pordia/100;


$consulta="SELECT (DATEDIFF( now(),cuotas.fechasql)) as dias,cuotas.id,cuotas.mora,cuotas.totalconmora,cuotas.totalfinal,cuotas.motivo, cuotas.estado,prestamos.cuota as numeroc, cuotas.idprestamo, clientes.apellido, clientes.nombre, clientes.dni,clientes.telefono, clientes.sueldo, clientes.trabajo, clientes.telefonotrabajo, cuotas.monto, cuotas.cuota, cuotas.fecha, cuotas.idcliente from cuotas INNER JOIN prestamos on cuotas.idprestamo=prestamos.id INNER JOIN clientes on prestamos.idcliente=clientes.id ".$criterio."  order by cuotas.id ASC"; 

 
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
    }
 $cc=count($data);
for($y=0; $y<$cc; $y++)
{
if( $data[$y]['dias']>0) {$data[$y]['mora']= floor(abs(($data[$y]['monto']*$pordia)*$data[$y]['dias'])) ;}else{$data[$y]['mora']= 0;}

if( $data[$y]['dias']>0) {$data[$y]['dias']= "VENCIDA EN ". $data[$y]['dias']. " DIAS";}else{$data[$y]['dias']= abs($data[$y]['dias']). " DIAS PARA VENCER";}

 }
 $cc=count($data);
for($y=0; $y<$cc; $y++)
{
  $data[$y]['totalconmora']=$data[$y]['monto']+$data[$y]['mora'];
  $totalfinal+=$data[$y]['totalconmora'];
    $totalmora+=$data[$y]['mora'];
    }
 
 $cc=count($data);
for($y=0; $y<$cc; $y++)
{
  $data[$y]['cuota']=$data[$y]['cuota']."/".$data[$y]['numeroc'];
    
 }
 
  $cc=count($data);
for($y=0; $y<$cc; $y++)
{
  $data[$y]['apellido']=ucwords($data[$y]['apellido']).",".ucwords($data[$y]['nombre']);
    $data[$y]['nombre']=ucwords($data[$y]['nombre']);
 }
 
 
 $totales=array(
               array(
                     'concepto'=>"TOTAL",
                     'TOTAL CUOTAS '=>$totalvalor,
					  'TOTAL MORA '=>$totalmora,
					  'TOTAL FINAL '=>$totalfinal,
					 
                    )
              );

$titles = array(
				'apellido'=>'<b>cliente</b>',
								'dni'=>'<b>dni</b>',
								'telefono'=>'<b>telefono</b>',
								'sueldo'=>'<b>sueldo</b>',
								'trabajo'=>'<b>trabajo</b>',
								'telefonotrabajo'=>'<b>tel trab</b>',
				'idprestamo'=>'<b>prest.N°</b>',
				'cuota'=>'<b>cuota</b>',
				'monto'=>'<b>monto</b>',
				'mora'=>'<b>mora</b>',
				'totalconmora'=>'<b>total</b>',
						'fecha'=>'<b>fecha</b>',
						'dias'=>'<b>dias vencida</b>',
						'                      '=>'<b>OBSERVACION</b>',					
						
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
$txttit.= "CUOTAS ADEUDADAS\n";
$txttit .= "<b>CANTIDAD DE CUOTAS EN CONSULTA:</b>".$cantidadc." \n";
$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezTable($totales, $totalestitulos, '', $optotal);
$pdf->ezText("\n\n\n", 5);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
ob_end_clean();
$pdf->ezStream();
?>
