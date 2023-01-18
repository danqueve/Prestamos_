<?PHP include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" /> 
<title>::CONDICIONES DEL PRESTAMO::</title>
<LINK REL=StyleSheet TYPE="text/css" HREF="estilo.css" media="screen">
<style type="text/css">
<!--
.Estilo1 {font-size: 14pt}
#td2{border-bottom: solid 1px #000000; border-top: solid 1PX #000000}	
-->
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<style type="text/css">
<!--
p.MsoNormal {
margin-top:0cm;
margin-right:0cm;
margin-bottom:10.0pt;
margin-left:0cm;
line-height:115%;
font-size:11.0pt;
font-family:"Calibri","sans-serif";
}
-->
</style>
<style type="text/css">
<!--
table.MsoTableGrid {
border:solid black 1.0pt;
text-autospace:none;
font-size:11.0pt;
font-family:"Calibri","sans-serif";
}
p.MsoBodyText {
margin:0cm;
margin-bottom:.0001pt;
text-autospace:none;
font-size:12.5pt;
font-family:"Arial","sans-serif";
}
-->
</style>
</head>
<body   onLoad="window.print()" >
<?php //------    CONVERTIR NUMEROS A LETRAS         ---------------
//------    Máxima cifra soportada: 18 dígitos con 2 decimales
//------    999,999,999,999,999,999.99
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE BILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE MILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE PESOS 99/100 M.N.
//------    Creada por:                        ---------------
//------             ULTIMINIO RAMOS GALÁN     ---------------
//------            uramos@gmail.com           ---------------
//------    10 de junio de 2009. México, D.F.  ---------------
//------    PHP Version 4.3.1 o mayores (aunque podría funcionar en versiones anteriores, tendrías que probar)
function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }
 
    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }
 
            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                             
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                             
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                             
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO
 
        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";
 
        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";
 
        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO PESOS  ";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN PESO ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " PESOS  "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}
 
// END FUNCTION
 
function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}
 
// END FUNCTION


$idcliente = $_GET["idcliente"];

$fecha = $_GET["fechaprestamo"];
$fechaprestamo = $_GET["fechaprestamo"];
$monto = $_GET["monto"];



require('conexionsql2.php');
$result143 = mysqli_query($link,"SELECT *  FROM datos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result143)){ 
 do { 
   $csistema=   $row["sistema"];
   } while ($row = mysqli_fetch_array($result143)); 
}
$result25 = mysqli_query($link,"SELECT * FROM clientes WHERE id= '$idcliente' order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result25)){ 
   
   do { 
   $apellido=mb_strtoupper(trim($row["apellido"]),'UTF-8');
   $nombre=mb_strtoupper(trim($row["nombre"]),'UTF-8');
    $direccion=mb_strtoupper(trim($row["direccion"]),'UTF-8');
	$direccione=mb_strtoupper(trim($row["direccione"]),'UTF-8');
	 $entrecalles=mb_strtoupper(trim($row["entrecalles"]),'UTF-8');
	$telefono=$row["telefono"];
	$sueldo=mb_strtoupper(trim($row["sueldo"]),'UTF-8');
	$celular=$row["celular"];
	$telefonotrabajo=$row["telefonotrabajo"];
	$telefono2=$row["telefono2"];
	$interno=$row["interno"];
	$ciudad=mb_strtoupper(trim($row["ciudad"]),'UTF-8');
	$ciudade=mb_strtoupper(trim($row["ciudade"]),'UTF-8');
	$cp=mb_strtoupper(trim($row["cp"]),'UTF-8');
	$observacion=mb_strtoupper(trim($row["observacion"]),'UTF-8');
	$estadocivil=mb_strtoupper(trim($row["estadocivil"]),'UTF-8');
	$provincia=mb_strtoupper(trim($row["provincia"]),'UTF-8');
	$trabajo=mb_strtoupper(trim($row["trabajo"]),'UTF-8');
	$email=mb_strtolower(trim($row["email"]),'UTF-8');
	$fechanac=$row["fechanac"];
		$dni=$row["dni"];
		
		
	
    } while ($row = mysqli_fetch_array($result25));
}


if ($tipo=="MENSUAL"){
$c_tipo="mensuales";
$c_tipo2="mensualmente";
}
if ($tipo=="QUINCENAL"){
$c_tipo="quincenales";
$c_tipo2="quincenalmente";
}
if ($tipo=="SEMANAL"){
$c_tipo="semanales";
$c_tipo2="semanalmente";
}
if ($tipo=="DIARIO"){
$c_tipo="diarias";
$c_tipo2="diariamente";
}



?>
<div align="center"><p class="MsoNormal" align="center" style="margin-bottom:6.0pt;text-align:center;line-height:normal;"><?php echo $csistema;?></p></div>
<table class="MsoTableGrid" border="1" cellspacing="0" cellpadding="0" width="104%" style="width:104.24%;margin-left:-8.8pt;border-collapse:collapse;border:none;">
  <tr style="height:16.1pt;">
    <td width="100%" valign="top" style="width:100.0%;border:solid black 2.25pt;padding:0cm 5.4pt 0cm 5.4pt;height:16.1pt;"><p class="MsoBodyText" align="center" style="text-align:center;"><strong><span style="font-size:14.0pt; ">DATOS PERSONALES DEL SOLICITANTE</span></strong></p></td>
  </tr>
  <tr style="height:16.1pt;">
    <td width="100%" valign="top" style="width:100.0%;border:solid black 2.25pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:16.1pt;"><p class="MsoBodyText"><strong><span style="font-size:10.0pt; ">Nombre:<?php echo $nombre;?>        Apellido:<?php echo $apellido;?>        DNI:<?php echo $dni;?>         F/Nac:<?php echo $fechanac;?></span></strong></p></td>
  </tr>
  <tr style="height:16.1pt;">
    <td width="100%" valign="top" style="width:100.0%;border:solid black 2.25pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:16.1pt;"><p class="MsoBodyText"><strong><span style="font-size:10.0pt; ">Domicilio:<?php echo $direccion;?>                      E/Calles:<?php echo $entrecalles;?></span></strong> <strong><span style="font-size:10.0pt; ">                                             </span></strong></p></td>
  </tr>
  <tr style="height:16.1pt;">
    <td width="100%" valign="top" style="width:100.0%;border:solid black 2.25pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:16.1pt;"><p class="MsoBodyText"><strong><span style="font-size:10.0pt; ">Localidad:<?php echo $ciudad.",".$provincia;?>                        CP.:<?php echo $cp;?>                   Piso:            Dto:</span></strong></p></td>
  </tr>
  <tr style="height:16.1pt;">
    <td width="100%" valign="top" style="width:100.0%;border:solid black 2.25pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:16.1pt;"><p class="MsoBodyText"><strong><span style="font-size:10.0pt; ">Teléfono:<?php echo $telefono;?>              Celular:<?php echo $celular;?>              Mail:<?php echo $email;?></span></strong></p></td>
  </tr>
  <tr style="height:16.1pt;">
    <td width="100%" valign="top" style="width:100.0%;border:solid black 2.25pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:16.1pt;"><p class="MsoBodyText"><strong><span style="font-size:10.0pt; ">Sueldo:<?php echo $sueldo;?>  Empleado:            Resp.Insc:           Monotributista:</span></strong><strong><span style="font-size:10.0pt; "> </span></strong><strong><span style="font-size:10.0pt; ">                </span></strong><strong><span style="font-size:10.0pt; ">Jub.:                  </span></strong><strong><span style="font-size:10.0pt; ">         </span></strong><strong><span style="font-size:10.0pt; ">Otro:</span></strong></p></td>
  </tr>
  <tr style="height:16.1pt;">
    <td width="100%" valign="top" style="width:100.0%;border:solid black 2.25pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:16.1pt;"><p class="MsoBodyText"><strong><span style="font-size:10.0pt; ">Empresa:<?php echo $trabajo;?>            Domicilio:<?php echo $direccione;?>                                        Localidad:<?php echo $ciudade;?></span></strong></p></td>
  </tr>
  <tr style="height:16.1pt;">
    <td width="100%" valign="top" style="width:100.0%;border:solid black 2.25pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:16.1pt;"><p class="MsoBodyText"><strong><span style="font-size:10.0pt; ">Teléfono1:<?php echo $telefonotrabajo;?>                       telefono2:<?php echo $telefono2;?>                                  Int:<?php echo $interno;?>                              Cargo</span></strong></p></td>
  </tr>
  <tr style="height:26.3pt;">
    <td width="100%" valign="top" style="width:100.0%;border:solid black 2.25pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:26.3pt;"><p class="MsoBodyText"><strong><span style="font-size:10.0pt; ">Observación:<?php echo $observacion;?></span></strong></p></td>
  </tr>
</table>
<p class="MsoNormal" style="margin-bottom:6.0pt;line-height:50%;"><strong>&nbsp;</strong></p>
<table class="MsoTableGrid" border="1" cellspacing="0" cellpadding="0" width="520" style="width:389.85pt;margin-left:175.5pt;border-collapse:collapse;border:none;">
  <tr>
    <td width="520" valign="top" style="width:389.85pt;border:solid black 2.25pt;padding:0cm 5.4pt 0cm 5.4pt;"><p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong><em><span style="font-size:10.0pt; "><?php
   require('conexionsql2.php');
   $fechasql= trim(substr($fechaprestamo,6,4)."-".substr($fechaprestamo,3,2)."-".substr($fechaprestamo,0,2));
 
$diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
echo $diassemana[date('w',strtotime($fechasql))]." ".date('d',strtotime($fechasql))." de ".$meses[date('n',strtotime($fechasql))-1]. " del ".date('Y',strtotime($fechasql)) ;
//Salida: Miercoles 05 de Septiembre del 2016
 
?></span></em></strong></p></td>
  </tr>
</table>
<p class="MsoNormal" style="margin-bottom:6.0pt;">&nbsp;</p>
<p class="MsoNormal"><strong><span style="line-height:115%; font-size:9.0pt; ">RECONOCIMIENTO DE LA DEUDA: Reconozco  la adquisición de mercadería de este comercio. Acepto plenamente la operación  de crédito suscripta, en un todo de acuerdo con las condiciones enumeradas  seguidamente. Por ello detallo mis datos personales y referencias, las que  tienen carácter de declaración jurada.</span></strong></p>
<p class="MsoNormal"><strong><span style="font-size:9.0pt; ">COBRO POR VIA JUDICIAL: En caso de  mora, o retiro de mercadería, tanto el importe adeudado como sus intereses  compensatorios y punitorios, podrá ser llevado mediante proceso ejecutivo, a  cuyo efecto convenga en otorgar a la presente, el carácter suficiente de título  ejecutivo, sirviendo de legítima constancia del total de la deuda. Para el  supuesto de incumplimiento las partes pactan un Interés Compensatorio del 10%  mensual y un Interés Punitorio acumulativo al anterior previamente  capitalizado, del 1% diario. El primero regirá desde emisión hasta presentación  al pago, y el segundo sancionará el no pago desde dicha presentación hasta su  efectivo abono, ambos se aplicarán sobre el capital de imposición en reclamo.  Conf. Lo autorizan los arts</span></strong><span style="font-size:9.0pt; "> <strong>art. 5; 13,30; 35 y cctes. Del  Dec. Ley 5965/63, código Civil y  de  comercio. Se pactan Intereses Punitorios del 10% mensual sobre los gastos  causídicos originables en el cobro de éste.</strong></span></p>
<p class="MsoNormal">&nbsp;</p>
<p class="MsoNormal"><strong>…………………………………………………                     ……………………………………………                 …………………………………………..</strong></p>
<p class="MsoNormal"><strong>            Firma de Solicitante                                                 Aclaración                                                 DNI</strong></p>
<table class="MsoTableGrid" border="1" cellspacing="0" cellpadding="0" align="left" width="758" style="width:568.75pt;border-collapse:collapse;border:none;margin-left:4.8pt;margin-right:4.8pt;">
  <tr style="height:267.1pt;">
    <td width="758" valign="top" style="width:568.75pt;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:267.1pt;"><p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>SELLADO:                                        N.:</strong><strong>                                         VTO.                                                  Por$: <?php echo $monto;?> </strong></p>
        <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>&nbsp;</strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>                   Lugar y    Fecha…………………………………………de………………………………………………………….de………………………………..</strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>                  </strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>                 A LA    VISTA <?php echo "  ".$apellido.",".$nombre." ";?> Pagare sin Protesto (Art. 50 Dec. Ley    5965/63)</strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>&nbsp;</strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>                 Al SEÑOR……………………………………………………………………………………………………O  a su Orden la cantidad de $ <?php echo $monto;?></strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>&nbsp;</strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>                 Pesos <?php echo numtoletras($monto);?></strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>&nbsp;</strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong><span style="font-size:10.0pt; ">Para el supuesto de incumplimiento las partes pactan    un <u>interés compensatorio de 10% mensual y un interés Punitorio acumulativo    al anterior previamente capitalizado, del 1% diario</u>. El 1° regirá desde    emisión hasta presentación al pago, el 2° sancionara el no pago desde dicha    presentación hasta su efectivo abono, ambos se aplicaran sobre el capital de    imposición en reclamo. Conf. Lo autorizan los art. 5; 13,30; 35 y cctes. Del    Dec. Ley 5965/63, código Civil y  de    comercio. Se pactan interés Punitorios del 10% mensual sobre los gastos    causídicos originables en el cobro de este.</span></strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>&nbsp;</strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>&nbsp;</strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>&nbsp;</strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>…………………………………………………                             ……………………………………………                         ……………………………………………</strong></p>
      <p class="MsoNormal" style="margin-bottom:.0001pt;line-height:normal;text-autospace:none;"><strong>                      Firma                                                                           Aclaración                                                       DNI</strong></p></td>
  </tr>
</table>


</body>
</html>