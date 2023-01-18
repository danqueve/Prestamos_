<?include ("seguridad.php");
require('conexionsql2.php');
?>
<?php require_once('class.ezpdf.php');
$pdf =new Cezpdf('A4','landscape');
$pdf->selectFont('/fonts/courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
require('conexionsql2.php');



$tabla=$_GET["tabla"];
$detallee=$_GET["detalle"];
$fechae=$_GET["fecha"];
$tipoe=$_GET["tipo"];
$observe=$_GET["observ"];


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
 

 if(empty($detalle)and empty($fecha)and empty($tipo)and empty($observ)){
 $criterio = " ";
 }else{

 $criterio = " where ".$detalle.$fecha.$tipo.$observ; }




$consulta="SELECT * FROM caja2 ".$criterio . "order by fecha desc"; 


 
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
 
 for($y=0; $y<$cc; $y++)
{
  $data[$y]['detalle']=mb_strtoupper(trim(ucwords($data[$y]['detalle'])),'UTF-8');
   $data[$y]['observacion']=mb_strtoupper(trim(ucwords($data[$y]['observacion'])),'UTF-8');
 }
 
 $totales=array(
               array(
                     'concepto'=>"SALDO",
                     'total'=>$totalvalor
                    )
              );




$titles = array(
				'detalle'=>'<b>DETALLE</b>',
				'importe'=>'<b>IMPORTE</b>',
				'fecha'=>'<b>FECHA</b>',
				'observacion'=>'<b>OBSERVACION</b>',
				'tipo'=>'<b>TIPO</b>',
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
$txttit = "<b>INFORME CAJAS DIARIAS</b>\n";
$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezTable($totales, $totalestitulos, '', $optotal);
$pdf->ezText("\n\n\n", 5);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();
?>
