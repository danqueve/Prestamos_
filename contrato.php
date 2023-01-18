<?PHP include ("seguridad.php");?>
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
</head>
<body   onLoad="window.print()" >
<?

 
//------    CONVERTIR NUMEROS A LETRAS         ---------------
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


$apellido = $_GET["apellido"];
$nombre = $_GET["nombre"];
$direccion = mb_strtoupper(trim($_GET["direccion"]),'UTF-8');
$dni = $_GET["dni"];
$fecha = $_GET["fecha"];
$fechaprestamo = $_GET["fechaprestamo"];
$monto = $_GET["monto"];
$cuotas = $_GET["cuotas"];
$tipo = $_GET["tipo"];

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
<table width="750px"  cellpadding="16" cellspacing="10" border="0"><TR><TD  align="justify" valign="top">
  <p class="MsoNormal"><strong><u><span style="line-height:115%; font-size:16.0pt; ">CONDICIONES  DEL PRÉSTAMO. CONVENIO DE PAGO</span></u></strong></p>
  <p class="MsoNormal"><strong>&nbsp;</strong></p>
  <p class="MsoNormal" style="line-height:200%;"><span style="line-height:200%; font-size:12.0pt; ">Entre …………………………………………………………………………………………………… DNI N°: ………………………………………… con domicilio en la calle ………………………………………………………………………… de la Ciudad  de ……………………………………………………………………………, en adelante el <strong>ACREEDOR</strong> y <? if(($apellido=="" )){echo "……………………………………………………………………………………………………";}else{echo $apellido.", ".$nombre ;} ?>  DNI N°: <? if(($dni=="" )){echo "………………………………………";}else{echo $dni;} ?> con domicilio en la calle <? if(($direccion=="" )){echo "…………………………………………………………………………… de la Ciudad de  …………………………………………………….";}else{echo $direccion;} ?> , en adelante el <strong>DEUDOR</strong>,  se conviene lo siguiente:</span></p>
  <p class="MsoNormal" style="line-height:200%;"><span style="font-size:12.0pt; ">&nbsp;</span></p>
  <p class="MsoNormal" style="line-height:200%;"><strong><u><span style="font-size:12.0pt; ">PRIMERO</span></u></strong><span style="font-size:12.0pt; ">: el <strong>DEUDOR</strong> acredita ingresos con recibo de sueldo emitido por: ………………………………..………………………………………….,  CUIT N°: ………………………………………., con domicilio en la calle …………………………………………………………………………………..…..  de …………………………………………………………………… que se adjunta al presente.</span></p>
  <p class="MsoNormal" style="line-height:200%;"><strong><u><span style="font-size:12.0pt; ">SEGUNDO</span></u></strong><span style="font-size:12.0pt; ">: el <strong>DEUDOR</strong> se obliga a cancelar las acreencias devengadas por el presente al <strong>ACREEDOR</strong>, a tal fin reconoce lisa y  llanamente y acepta causa y monto emergente de este convenio. Las sumas  adeudadas y reconocidas serán abonadas por el <strong>DEUDOR</strong> en la cantidad de <? if(($cuotas=="" )){echo "………………………………………";}else{echo $cuotas;} ?> cuotas <? echo $c_tipo;?> e  iguales y consecutivas que asciende a la suma de pesos <? echo numtoletras($monto);?> ($<? echo $monto;?>), pagaderas a partir del mes de <?php
   require('conexionsql.php');
   $fechasql= trim(substr($fecha,6,4)."-".substr($fecha,3,2)."-".substr($fecha,0,2));
 
$diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
echo $meses[date('n',strtotime($fechasql))-1] . " del ".date('Y',strtotime($fechasql));
//Salida: Miercoles 05 de Septiembre del 2016
 
?>, las que serán abonadas del …….. al ……… de cada mes sin  excepción. </span></p>
  <p class="MsoNormal" style="line-height:200%;"><strong><u><span style="font-size:12.0pt; ">TERCERO</span></u></strong><span style="font-size:12.0pt; ">: el préstamo se considera otorgado por el reembolso  en efectivo que en este acto realiza el <strong>ACREEDOR</strong>,  momento a partir del cual el <strong>DEUDOR</strong> se  obliga a su integra devolución. </span></p>
  <p class="MsoNormal" style="line-height:200%;"><strong><u><span style="font-size:12.0pt; ">CUARTO</span></u></strong><span style="font-size:12.0pt; ">: en el momento del efectivo desembolso autorizo al <strong>ACREEDOR</strong> a que deduzca los conceptos y  porcentajes de arriba descriptos del monto del préstamo en concepto de gastos. </span></p>
  <p class="MsoNormal" style="line-height:200%;"><strong><u><span style="font-size:12.0pt; ">QUINTO</span></u></strong><span style="font-size:12.0pt; ">: la mora se producirá de pleno derecho por el solo  vencimiento de los plazos. La falta de pago de una cuota provocará la  caducidad de todos los plazos pendientes y facultará al <strong>ACREEDOR</strong> para exigir la inmediata e integra devolución del capital  desembolsado y reconocido por la vía ejecutiva. La falta de pago en los plazos  convenidos generará una multa a favor del <strong>ACREEDOR</strong> equivalente al ……… % del saldo que se adeuda, la que se liquidará <? echo $c_tipo2;?>  y en la misma moneda que se ha pactado respecto de la obligación principal.</span></p>
  <p class="MsoNormal" style="line-height:200%;"><strong><u><span style="font-size:12.0pt; ">SEXTO</span></u></strong><span style="font-size:12.0pt; ">: como garantía de cumplimiento, el <strong>DEUDOR</strong> suscribe en favor del <strong>ACREEDOR</strong> un pagaré, a la vista por un  monto igual al total de las sumas adeudadas. El <strong>ACREEDOR</strong> podrá ejecutar la garantía o el contrato, ambos de manera  parcial o total, sin que por ello se entienda que existe renuncia sobre el  remanente no ejecutado.</span></p>
  <p class="MsoNormal" style="line-height:200%;"><strong><u><span style="font-size:12.0pt; ">SEPTIMO</span></u></strong><span style="font-size:12.0pt; ">: se constituye como fiador liso y llano del  cumplimiento de la presente obligación de la que acepta todos y cada uno de sus  términos ……………………………………………………………………….. DNI N° …………………………………………… con domicilio  en la calle …………………………………………………………………………….., de la ciudad de ……………………………………….………………………………………………………………………... </span></p>
  <p class="MsoNormal" style="line-height:200%;"><strong><u><span style="font-size:12.0pt; ">OCTAVO</span></u></strong><span style="font-size:12.0pt; ">: para todos los efectos legales derivados del  presente convenio y reconocimiento, las partes acuerdan que se someterán a los  tribunales ordinarios de la Ciudad de ROSARIO, Provincia de SANTA FE,  y que se renuncia a todo otro fuero o jurisdicción (existente o a crearse) que  pudiera corresponderles. Así mismo los domicilios indicados en el  encabezamiento serán válidos para todas las notificaciones judiciales o  extrajudiciales que se practicaren.</span></p>
  <p class="MsoNormal" style="line-height:200%;"><span style="font-size:12.0pt; ">De conformidad con lo convenido las  partes firman sendos ejemplares de igual tenor y para un mismo efecto en la Ciudad  de ROSARIO PROVINCIA DE SANTA FE, el día <?php
   require('conexionsql.php');
   $fechasql= trim(substr($fechaprestamo,6,4)."-".substr($fechaprestamo,3,2)."-".substr($fechaprestamo,0,2));
 
$diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
echo $diassemana[date('w',strtotime($fechasql))]." ".date('d',strtotime($fechasql))." de ".$meses[date('n',strtotime($fechasql))-1]. " del ".date('Y',strtotime($fechasql)) ;
//Salida: Miercoles 05 de Septiembre del 2016
 
?></span></p>
  <p class="MsoNormal"><span style="line-height:115%; font-size:12.0pt; ">&nbsp;</span></p>
  <p class="MsoNormal"><span style="font-size:12.0pt; ">&nbsp;</span></p>
  <p class="MsoNormal"><span style="font-size:12.0pt; ">……………………………………………………..                         ………..…………………………………………….</span></p>
  <p class="MsoNormal"><span style="font-size:12.0pt; ">FIRMA DEUDOR                                                          FIRMA ACREEDOR</span></p>
  <p class="MsoNormal"><span style="font-size:12.0pt; ">DNI N°: <? echo $dni;?>                                                                       DNI  N°:  </span></p>
</td>  
</tr>
</table>



</body>
</html>