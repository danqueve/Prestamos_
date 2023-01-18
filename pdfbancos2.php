<?php require_once('class.ezpdf.php');
$pdf =& new Cezpdf('A4','landscape');
$pdf->selectFont('/fonts/courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
require('conexionsql.php');


$tabla = $_GET["tabla"];


$nombre = (!empty($_GET["nombre"])
    ? " nombre like '%".$_GET["nombre"]."%'"
    : "");
 
$fecha = (!empty($_GET["fecha"])
    ? (!empty($nombre) 
        ? " AND fecha like '%".$_GET["fecha"]."%'"
        : " fecha like '%".$_GET["fecha"]."%'")
    : "");
 
$tipo = (!empty($_GET["tipo"])
    ? (!empty($nombre) || !empty($fecha)
        ? " AND tipo like '%".$_GET["tipo"]."%'"
        : " tipo like '%".$_GET["tipo"]."%'")
    : "");
 
$observacion = (!empty($_GET["observacion"])
    ? (!empty($nombre) || !empty($fecha) || !empty($tipo)
        ? " AND observacion like '%".$_GET["observacion"]."%'"
        : " observacion like '%".$_GET["observacion"]."%'")
    : "");
 


 if(empty($nombre)and empty($fecha)and empty($tipo)and empty($observacion)){
 $criterio = "";
 }else{

 $criterio = " where ".$nombre.$fecha.$tipo.$observacion; }


$consulta="SELECT * FROM bancos ".$criterio. "order by id desc"; 

 
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




  $totalsaldos+=$data[$y]['importe'];
  $totaltransferencia+=$data[$y]['transferencia'];
  $totalcheque+=$data[$y]['importecheque'];
   
 }
$totales=array(
               array(
			   			
                     '<b>TOTAL SALDOS</b>'=>$totalsaldos,
                     '<b>TOTAL TRANSFERENCIAS</b>'=>$totaltransferencia,
					 '<b>TOTAL CHEQUES</b>'=>$totalcheque,
										 
                    )
              );


$titles = array(
				'nombre'=>'<b>NOMBRE</b>',
				'tipo'=>'<b>TIPO</b>',
					'importe'=>'<b>SALDO</b>',				
				'transferencia'=>'<b>TRANSFERENCIA</b>',
				'importecheque'=>'<b>IMPORTE CHEQUE</b>',
				'cheque'=>'<b>CHEQUE N</b>',
				'observacion'=>'<b>OBSERVACION</b>',
				'fecha'=>'<b>FECHA</b>',
					);
$options = array(
				'shadeCol'=>array(0.6,0.6,0.6),
				'xOrientation'=>'center',
				'width'=>700
			);
$txttit = "<b>INFORME</b>\n";
$txttit.= "BANCOS\n";
$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>TOTALES:</b>\n ", 10);
$pdf->ezTable($totales, $totalestitulos, '', $optotal);
$pdf->ezText("\n", 5);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();
?>
