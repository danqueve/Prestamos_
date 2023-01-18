<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<?php require('conexionsql2.php');

?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<head> 
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" /> 
<title>BUSCAR CUOTA DE PRESTAMO</title> 

<script>
function cargar(cuota,importe,fecha,id,interes){
if(opener.document.form1.numcarga.value==""){
valorcar2=1;
opener.document.form1.numcarga.value= valorcar2;
}

var contador = opener.document.form1.numcarga.value - 1;
var repetido = 0;
for(x=0; x <= 7; x++){
if(opener.document.form1.id[x].value ==id){
repetido=1;
}
}

if(contador <=7){
if(repetido ==0){


opener.document.form1.id[contador].value=id; 
opener.document.form1.cuota[contador].value=cuota;
interesvalor=parseInt(interes);
opener.document.form1.interesd[contador].value=interesvalor;
opener.document.form1.fecha[contador].value=fecha;
valor2=parseInt(importe);
opener.document.form1.importe[contador].value=valor2;
opener.document.form1.apagar[contador].value=valor2;


if(opener.document.form1.numcarga.value){
valorcar1=parseInt(opener.document.form1.numcarga.value);}else{valorcar1=0;}
valorcar2=1;
opener.document.form1.numcarga.value=valorcar1 + valorcar2;
alert("carga exitosa...");
}else{alert("esta cuota ya fue ingresada...");}

}else{alert("no se puede ingresar mas cuotas..");}

}

</script>
<?php
$pordia=0;
$result257 = mysqli_query($link,"SELECT * FROM datos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result257)){ 
   
   do { 
   $pordia=$row["pordia"];
  
    } while ($row = mysqli_fetch_array($result257));
}

$pordia=$pordia/100;

$idcliente = $_GET["idcliente"];
$prestamo = $_GET["prestamo"];
$fechacobro = $_GET["fechacobro"];

$result25 = mysqli_query($link,"SELECT * FROM clientes WHERE id= '$idcliente' order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result25)){ 
   
   do { 
   $apellido=$row["apellido"];
   $nombre=$row["nombre"];
    $dni=$row["dni"];
    } while ($row = mysqli_fetch_array($result25));
}

?>
</head> 
<body > 
<h1>CUOTAS ADEUDADAS DE: <?php echo mb_strtoupper(trim($apellido),'UTF-8'). ", ".mb_strtoupper(trim($nombre),'UTF-8') . " - DNI: ".$dni  ?></h1>
<table width="800" align="center" bgcolor="#FFFFFF" ><tr><td>


<?php //inicializo el criterio y recibo cualquier cadena que se desee buscar 
$criterio =  " where idcliente=" . $idcliente . "  and estado like 'ADEUDADA' and idprestamo=" .$prestamo; 
$txt_criterio = ""; 
if ($_GET["idcliente"]!=""){ 
   $txt_criterio = $_GET["idcliente"]; 
  $criterio =  " where idcliente=" . $idcliente . "  and estado like 'ADEUDADA' and idprestamo=" .$prestamo; 
$txt_criterio = ""; 
} 


$sql="SELECT * FROM cuotas ".$criterio." order by id desc"; 
$res=mysqli_query($link,$sql); 
$numeroRegistros=mysqli_num_rows($res); 
if($numeroRegistros<=0) 
{ 
    echo "<div align='center'>"; 
    echo "<font face='verdana' size='-2'>No se encontraron resultados</font>"; 
    echo "</div>"; 
}else{ 
    //////////elementos para el orden 
    if(!isset($orden)) 
    { 
       $orden="id"; 
    } 
    //////////fin elementos de orden 

    //////////calculo de elementos necesarios para paginacion 
    //tamaño de la pagina 
    $tamPag=1000; 

    //pagina actual si no esta definida y limites 
    if(!isset($_GET["pagina"])) 
    { 
       $pagina=1; 
       $inicio=1; 
       $final=$tamPag; 
    }else{ 
       $pagina = $_GET["pagina"]; 
    } 
    //calculo del limite inferior 
    $limitInf=($pagina-1)*$tamPag; 

    //calculo del numero de paginas 
    $numPags=ceil($numeroRegistros/$tamPag); 
    if(!isset($pagina)) 
    { 
       $pagina=1; 
       $inicio=1; 
       $final=$tamPag; 
    }else{ 
       $seccionActual=intval(($pagina-1)/$tamPag); 
       $inicio=($seccionActual*$tamPag)+1; 

       if($pagina<$numPags) 
       { 
          $final=$inicio+$tamPag-1; 
       }else{ 
          $final=$numPags; 
       } 

       if ($final>$numPags){ 
          $final=$numPags; 
       } 
    } 

//////////fin de dicho calculo 

//////////creacion de la consulta con limites 
$sql="SELECT * FROM cuotas ".$criterio." ORDER BY ".$orden."  asc LIMIT ".$limitInf.",".$tamPag; 
$res=mysqli_query($link,$sql); 

//////////fin consulta con limites 

     ?>
     <form name="f1" id="f1" action="" method="post">
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><font  size="2"><b>CUOTA/SERV</b></font></td>
     <td><font  size="2"><b>IMPORTE</b></font></td>
        <td><font  size="2"><b>FECHA VENC.</b></font></td>        
    <td>&nbsp;</td>
  </tr>
  <?php while($row=mysqli_fetch_assoc($res)){?>
  <tr><td colspan="5"><hr color="#990000"></td></tr>
  <tr>
   <?php $fechavencimiento=$row['fecha'];
	 $importe=$row['monto'];
	 
	 $fecha=explode("-",trim($fechacobro));
$fechados=explode("-",trim($fechavencimiento));


$fecha1=mktime(0,0,0,$fecha[1],$fecha[0],$fecha[2]);
$fecha2=mktime(0,0,0,$fechados[1],$fechados[0],$fechados[2]);


$diferencia=$fecha2-$fecha1;
$dias=$diferencia/(60*60*24);

//obtengo el valor absoulto de los días (quito el posible signo negativo) 
//$dias = abs($dias); 

//quito los decimales a los días de diferencia 
$dias = floor($dias); 




if($dias<0){
$interes=abs(($importe*$pordia)*$dias) ;



}else{
$interes=0;
}



	 
	 
	  ?>
  
  
    <td ><font  size="2"><?php echo $row['cuota'] ?></font></td>
       <td ><font  size="2"><?php echo $row['monto'] ?></font></td><td ><font  size="2"><?php echo $row['fecha'] ?></font></td>
                <td ><input type="button" name="Submit" value="cargar" onClick="cargar('<?php echo $row['cuota'] ?>',<?php echo $row['monto'] ?>,'<?php echo $row['fecha'] ?>',<?php echo $row['id'] ?>, <?php echo $interes ?>)"></td>
  </tr><?php } ?>
</table></form>
     
   <!-- fin tabla resultados --> 
<?php }//fin while 








//////////a partir de aqui viene la paginacion 
?> 
    <br> 
    <table border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr><td align="center" valign="top"> 
<?php if($pagina>1) 
    { 
       echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$txt_criterio."'>"; 
       echo "<font face='verdana' size='-2'>anterior</font>"; 
       echo "</a> "; 
    } 

    for($i=$inicio;$i<=$final;$i++) 
    { 
       if($i==$pagina) 
       { 
          echo "<font face='verdana' size='-2'><b>".$i."</b> </font>"; 
       }else{ 
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&criterio=".$txt_criterio."'>"; 
          echo "<font face='verdana' size='-2'>".$i."</font></a> "; 
       } 
    } 
    if($pagina<$numPags) 
   { 
       echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$txt_criterio."'>"; 
       echo "<font face='verdana' size='-2'>siguiente</font></a>"; 
   } 
//////////fin de la paginacion 
?> 
    </td></tr> 
    </table> 
<hr noshade style="color:CC6666;height:1px"> 



</table></td></tr>
</body> 
</html> 




</div>
</td></tr></table>
</body>
</html>