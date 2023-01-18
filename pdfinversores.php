<?php require_once('class.ezpdf.php');
$pdf =& new Cezpdf('A4','landscape');
$pdf->selectFont('/fonts/courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
require('conexionsql.php');


$tabla = $_GET["tabla"];
$numeropolizas = $_GET["numeroclientes"];
$txt_criterio = $_GET["criterio"];


$consulta="SELECT *  from ". $tabla. " where apellido like '%" . $txt_criterio . "%' or nombre like '%" . $txt_criterio . "%' or dni like '%" . $txt_criterio . "%'  order by apellido asc"; 

 
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
  $data[$y]['apellido']=ucwords($data[$y]['apellido']);
    $data[$y]['nombre']=ucwords($data[$y]['nombre']);
 }

$titles = array(
				'apellido'=>'<b>APELLIDO</b>',
				'nombre'=>'<b>NOMBRE</b>',
				'dni'=>'<b>DNI</b>',
					'direccion'=>'<b>DIRECCION</b>',				
				'telefono'=>'<b>TELEFONO</b>',
				'referencia'=>'<b>REFERENCIA</b>',
				'telefonoref'=>'<b>TEL. REF.</b>',
				'relacion'=>'<b>RELACION</b>',
				'edad'=>'<b>OBSERVACION</b>',
					);
$options = array(
				'shadeCol'=>array(0.6,0.6,0.6),
				'xOrientation'=>'center',
				'width'=>700
			);
$txttit = "<b>INFORME</b>\n";
$txttit.= "INVERSORES\n";
$txttit .= "<b>CANTIDAD DE INVERSORES EN CONSULTA:</b>".$numeropolizas." \n";
$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();
?>
