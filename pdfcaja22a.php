<?php require_once('class.ezpdf.php');
$pdf =new Cezpdf('legal','landscape');
$pdf->selectFont('/fonts/courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
$pdf->ezText(utf8_decode("\xc3\xb6\n"),0,array('justification'=>'centre'));
require('conexionsql2.php');


$tabla = $_GET["tabla"];

$totalcaja = $_GET["totalcaja"];

$dni = (!empty($_GET["dni"])
    ? " dni like '%".$_GET["dni"]."%'"
    : "");
 
$fecha = (!empty($_GET["fecha"])
    ? (!empty($dni) 
        ? " AND fecha like '%".$_GET["fecha"]."%'"
        : " fecha like '%".$_GET["fecha"]."%'")
    : "");
 
$tipo = (!empty($_GET["tipo"])
    ? (!empty($dni) || !empty($fecha)
        ? " AND tipo like '%".$_GET["tipo"]."%'"
        : " tipo like '%".$_GET["tipo"]."%'")
    : "");
 
 
 $detalle = (!empty($_GET["detalle"])
    ? (!empty($dni) || !empty($fecha) || !empty($tipo)
        ? " AND detalle like '%".$_GET["detalle"]."%'"
        : " detalle like '%".$_GET["detalle"]."%'")
    : "");

 if(empty($dni)and empty($fecha)and empty($tipo) and empty($detalle)){
 $criterio = "where (estado like 'ANULADO')";
 }else{

 $criterio = " where (estado like 'ANULADO') and ".$dni.$fecha.$tipo.$detalle; }

$consulta="SELECT * FROM cobros2 ".$criterio. "order by id asc"; 



 
$queEmp = $consulta;
$resEmp = mysqli_query($link,$queEmp) or die(mysql_error());
$totEmp = mysqli_num_rows($resEmp);
$ixx = 0;
while($datatmp = mysqli_fetch_assoc($resEmp)) { 
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}



$titles = array(
				'apellido'=>'<b>APELLIDO</b>',
				'nombre'=>'<b>NOMBRE</b>',
				'dni'=>'<b>DNI</b>',
				'detalle'=>'<b>DETALLE</b>',
					'fecha'=>'<b>FECHA</b>',
					'mes'=>'<b>PERIODO</b>',				
				'comprobante'=>'<b>COMPR.</b>',
				'importe'=>'<b>IMPORTE</b>',
								'tipo'=>'<b>TIPO</b>',
				
				
				
				
					);
$options = array(
				'shadeCol'=>array(0.9,0.9),
				'xOrientation'=>'center',
				'width'=>950
			);
$txttit = "<b>INFORME COBROS ANULADOS</b>\n";


$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>TOTAL COBROS ANULADOS:</b> ".$totalcaja."\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();
?>