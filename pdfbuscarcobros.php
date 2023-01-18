<? include ("seguridad.php");?>
<?php require_once('class.ezpdf.php');
$pdf =new Cezpdf('legal','landscape');
$pdf->selectFont('/fonts/courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
require('conexionsql2.php');



$tabla = $_GET["tabla"];
$fechae1=$_GET["fecha1"];
$fechae2=$_GET["fecha2"];
$prestamoe=$_GET["prestamo"];
$usuarioe=$_GET["usuario2"];
$ciudade=$_GET["ciudad"];
$cobradore=$_GET["cobrador"];

$fechan1 =date('Ymd', strtotime($_GET['fecha1']));
$fechan2 =date('Ymd', strtotime($_GET['fecha2']));

$dni = (!empty($_GET["dni"])
    ? " clientes.dni like '%".$_GET["dni"]."%'"
    : "");
 
$fecha = (!empty($_GET["fecha1"]) && !empty($_GET["fecha2"])
    ? (!empty($dni) 
        ? " AND cobros.fechasql BETWEEN ".$fechan1." AND ".$fechan2." "
        : " cobros.fechasql BETWEEN ".$fechan1." AND ".$fechan2." ")
    : "");
 
$prestamo = (!empty($_GET["prestamo"])
    ? (!empty($dni) || !empty($fecha)
        ? " AND cobros.idprestamo like '%".$_GET["prestamo"]."%'"
        : " cobros.idprestamo like '%".$_GET["prestamo"]."%'")
    : "");
	
$usuario2 = (!empty($_GET["usuario2"])
    ? (!empty($dni) || !empty($fecha)|| !empty($prestamo)
        ? " AND cobros.usuario like '%".$_GET["usuario2"]."%'"
        : " cobros.usuario like '%".$_GET["usuario2"]."%'")
    : "");
	$ciudad = (!empty($_GET["ciudad"])
    ? (!empty($dni) || !empty($fecha)|| !empty($prestamo)|| !empty($usuario2)
        ? " AND clientes.ciudad like '%".$_GET["ciudad"]."%'"
        : " clientes.ciudad like '%".$_GET["ciudad"]."%'")
    : "");
	$cobrador = (!empty($_GET["cobrador"])
    ? (!empty($dni) || !empty($fecha)|| !empty($prestamo)|| !empty($usuario2)|| !empty($ciudad)
        ? " AND cobros.cobrador like '%".$_GET["cobrador"]."%'"
        : " cobros.cobrador like '%".$_GET["cobrador"]."%'")
    : "");
 

if($_SESSION['rol']=="ADMINISTRADOR"){
 if(empty($dni)and empty($fecha)and empty($prestamo)and empty($usuario2)and empty($ciudad)and empty($cobrador)){
 $criterio = " where (clientes.id=cobros.idcliente)";
 }else{

 $criterio = " where ".$dni.$fecha.$prestamo.$usuario2.$ciudad.$cobrador."and (clientes.id=cobros.idcliente)"; }
 }else{
 if(empty($dni)and empty($fecha)and empty($prestamo)and empty($usuario2)and empty($ciudad)and empty($cobrador)){
 $criterio = " where (clientes.id=cobros.idcliente) and (cobros.usuario='".$_SESSION['usuarionuevo']."') ";
 }else{

 $criterio = " where ".$dni.$fecha.$prestamo.$usuario2.$ciudad.$cobrador."and (clientes.id=cobros.idcliente) and (cobros.usuario='".$_SESSION['usuarionuevo']."') "; }
 
 }





$consulta="SELECT cobros.id, cobros.usuario, cobros.observacion, cobros.cobrador,  cobros.idprestamo, clientes.apellido, clientes.ciudad, clientes.nombre, clientes.dni, cobros.importe, cobros.cuota, cobros.fecha FROM clientes, cobros ".$criterio."  order by cobros.id ASC"; 



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
  $totalvalor+=$data[$y]['importe'];
 }
 
 if(!empty($cobradore)){
require('conexionsql2.php');
$result257 = mysqli_query($link,"SELECT * FROM datos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result257)){ 
   
   do { 
   $comisionc=$row["comisionc"];
  
    } while ($row = mysqli_fetch_array($result257));
}

$comisionc=$comisionc/100;
$apagarcobrador=$comisionc*$totalvalor;
 
}
 
 $totales=array(
               array(
                     'concepto'=>"TOTAL",
                     'total'=>$totalvalor,
					 'total a pagar a cobrador'=>$apagarcobrador,
                    )
              );



 $cc=count($data);
for($y=0; $y<$cc; $y++)
{
  $data[$y]['apellido']=ucwords($data[$y]['apellido']);
    $data[$y]['nombre']=ucwords($data[$y]['nombre']);
 }

$titles = array(
				'apellido'=>'<b>APELLIDO</b>',
				'nombre'=>'<b>NOMBRE</b>',
				'dni'=>'<b>DNI</b>',
				'ciudad'=>'<b>CIUDAD</b>',
				'cuota'=>'<b>CUOTA</b>',
				'importe'=>'<b>IMPORTE</b>',
				'idprestamo'=>'<b>PRESTAMO N°</b>',
				'fecha'=>'<b>FECHA</b>',
				'usuario'=>'<b>USUARIO</b>',
				'observacion'=>'<b>OBSERVACION</b>',
				'cobrador'=>'<b>COBRADOR</b>',
				);
$options = array(
				'shadeCol'=>array(1.2,0.5,0.5),
				'xOrientation'=>'center',
				'width'=>900,
			);
			$optotal = array(
                'shadeCol'=>array(1.2,0.5,0.5),
                'xOrientation'=>'center',
                'width'=>900,
                'cols'=>array(
                              'concepto'=>array('justification'=>'left','width'=>400),
                              'total'=>array('justification'=>'left','width'=>200)
							  
                             )
            );
$txttit = "<b>INFORME</b> ";
$txttit.= "COBROS ";
$txttit.= "\n";
$pdf->ezText($txttit, 10);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 5);
$pdf->ezText("\n", 1);
$pdf->ezTable($totales, $totalestitulos, '', $optotal);
$pdf->ezText("\n\n\n", 5);
$pdf->ezText("<b>Fecha Emision:</b> ".date("d/m/Y"), 8);
$pdf->ezText("<b>Hora Emision:</b> ".date("H:i:s")."\n\n", 8);
$pdf->ezStream();
?>