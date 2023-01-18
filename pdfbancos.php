<?php require_once('class.ezpdf.php');
$pdf =& new Cezpdf('A4','landscape');
$pdf->selectFont('/fonts/courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
require('conexionsql.php');






$consulta="SELECT * FROM bancos order by id desc"; 

 
$queEmp = $consulta;
$resEmp = mysql_query($queEmp, $link) or die(mysql_error());
$totEmp = mysql_num_rows($resEmp);
$ixx = 0;
while($datatmp = mysql_fetch_assoc($resEmp)) { 
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}

$cc=count($data);
for($y=0; $y<$cc; $y++)
{
  $totalvalor+=$data[$y]['importe'];
 }
 
 $totales=array(
               array(
                     'concepto'=>"SALDO",
                     'total'=>$totalvalor
                    )
              );




$titles = array(
				'nombre'=>'<b>NOMBRE</b>',
				'importe'=>'<b>SALDO</b>',
				'transferencia'=>'<b>TRANSFRERENCIA</b>',
				'fecha'=>'<b>FECHA</b>',
				'observacion'=>'<b>OBSERVACION</b>',
				
					);
$options = array(
				'shadeCol'=>array(0.6,0.6,0.6),
				'xOrientation'=>'center',
				'width'=>750
			);
			$optotal = array(
                'shadeCol'=>array(1.2,0.5,0.5),
                'xOrientation'=>'center',
                'width'=>500,
                'cols'=>array(
                              'concepto'=>array('justification'=>'left','width'=>420),
                              'total'=>array('justification'=>'left','width'=>80)
                             )
            );
$txttit = "<b>INFORME</b>\n";
$txttit.= "BANCOS \n";
$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);

$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();
?>
