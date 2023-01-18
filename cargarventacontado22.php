<?PHP include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require('conexionsql2.php');
?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" /> 
<title>::IMPRESION COBRO LIBRE::</title>
<LINK REL=StyleSheet TYPE="text/css" HREF="estilo.css" media="screen">
<style type="text/css">
<!--
.Estilo1 {font-size: 14pt}
#td2{border-bottom: solid 1px #000000; border-top: solid 1PX #000000}	
-->
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
<body   onLoad="window.print()" >
<?php 


 
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
                        $xcadena = "CERO PESOS con $xdecimales centavos ";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN PESO con $xdecimales centavos ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " PESOS con $xdecimales centavos  "; //
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


$c_apellido = mb_strtolower(trim($_GET["apellido"]),'UTF-8'); 
$c_nombre =mb_strtolower(trim($_GET["nombre"]),'UTF-8'); 
$c_idcliente =trim($_GET["idcliente"]); 
$c_dni = strtoupper($_GET["dni"]); 
$c_direccion = mb_strtolower(trim($_GET["direccion"]),'UTF-8'); 

$result143 = mysqli_query($link,"SELECT *  FROM datos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result143)){ 
 do { 
   $csistema=   $row["sistema"];
       } while ($row = mysqli_fetch_array($result143)); 
}


 $fecha = strtoupper(trim($_GET["fecha"]));
  $fechasql= trim(substr($fecha,6,4)."-".substr($fecha,3,2)."-".substr($fecha,0,2)); 
 
	$c_comprobante =$_GET["comprobante"];
	$c_detalle =$_GET["detalle"];
	$c_importe =$_GET["importe"];
	$c_tipo =$_GET["tipo"];
	
	$c_periodo = mb_strtolower(trim($_GET["periodo"]),'UTF-8'); 	
		  
	   $result1 = mysqli_query($link,"SELECT * FROM cobros2 WHERE comprobante='$c_comprobante'"); 
if (!($row = mysqli_fetch_array($result1))){ 

$result13 = mysqli_query($link,"SELECT * FROM contribuyentes WHERE dni='$c_dni'"); 
if (!($row = mysqli_fetch_array($result13))){ 


$result14 = mysqli_query($link,"SELECT `AUTO_INCREMENT`
FROM  INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'u335739870_amigos'
AND   TABLE_NAME   = 'contribuyentes';"); 
if ($row = mysqli_fetch_array($result14)){ 
 do { 
   $c_idcliente=   $row["AUTO_INCREMENT"];
   } while ($row = mysqli_fetch_array($result14)); 


}

 $sql55 = "INSERT INTO contribuyentes (apellido,   nombre, dni,  direccion) VALUES ('$c_apellido',   '$c_nombre' , '$c_dni',   '$c_direccion')";
   $result = mysqli_query($link,$sql55);

}}


 
$result143 = mysqli_query($link,"SELECT `AUTO_INCREMENT`
FROM  INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'u335739870_amigos'
AND   TABLE_NAME   = 'cobros2';"); 
if ($row = mysqli_fetch_array($result143)){ 
 do { 
   $c_idcobro=   $row["AUTO_INCREMENT"];
   } while ($row = mysqli_fetch_array($result143)); 


}
	
	
	
		  $sql2 = "INSERT INTO cobros2 (idcontribuyente, apellido,nombre,dni,fecha,fechasql,comprobante,importe,tipo,detalle,mes,estado) VALUES ('$c_idcliente','$c_apellido',   '$c_nombre' , '$c_dni','$fecha','$fechasql','$c_comprobante','$c_importe','$c_tipo','$c_detalle','$c_periodo','NORMAL')";
   $result2 = mysqli_query($link,$sql2);
   
   
   
     $usuarionuevo=$_SESSION['usuario'];
	
	$clientecaja="cliente:".$c_apellido.",".$c_nombre;
	$detallecobro=$c_tipo."-".$c_detalle;
    $sql21 = "INSERT INTO caja2 (detalle,importe,fecha,tipo,fechasql,observacion,usuario,idcobro) VALUES ('$detallecobro','$c_importe','$fecha','INGRESO','$fechasql','$clientecaja','$usuarionuevo','$c_idcobro')";
	$result = mysqli_query($link,$sql21);
   
   
      
	  
  
	   
	  
   
   
    
   
       
         
   
   
    
   
?>

	
 
<table width="663"  height="460" border="1"><TR><TD align="center" valign="top">
<table width="769" border="0">
  <tr>
    <td colspan="5" rowspan="3" align="center" bgcolor="#CCCCCC"><B><?php echo $csistema;?></B></td>
    <td colspan="3" align="center" valign="middle">COMPROBANTE N°: <?php echo $c_comprobante;?><BR>COMPROBANTE NO FISCAL</td>
    </tr>
  <tr>
    <td height="30" colspan="3" align="center" valign="middle">FECHA:<?php echo $fecha; ?></td>
    </tr>
  <tr>
    <td height="30" colspan="3" align="center" valign="middle">   </td>
    </tr>
   <tr>
    <td colspan="8" >CLIENTE:<B> <?php echo $c_apellido.", ".$c_nombre.", DNI:".$c_dni;?></B></td>
    </tr>
      <tr>
    <td colspan="8" ></td>
    </tr>
      <tr>
    <td colspan="8" >TIPO:<?php echo $c_tipo; ?></td>
    </tr>
      <tr>
        <td colspan="8" >  </td>
      </tr>
     
    
    

  <tr>
     <td width="131" ><b>CANTIDAD</b></td>
    <td width="330"><b>DETALLE</b></td>
    <td colspan="3"><b>IMP</b></td>
    <td width="100" ></td>    <td width="100"><B>TOTAL</B></td>
  </tr>



   <tr><td colspan="8"><hr color="#000000"></td></tr>
   <tr ><td width="131">1</td><td><?php echo $c_detalle;?></td>
     <td colspan="4" align="center"><?php echo $c_importe;?></td>
     <td></td><td><?php echo $c_importe;?></td></tr>
   
     <tr ><td width="131"></td>
     <td colspan="4" align="center"></td>
     <td></td><td></td></tr>
     
        <tr ><td width="131"></td>
     <td colspan="4" align="center"></td>
     <td></td><td></td></tr> <tr ><td width="131"></td>
     <td colspan="4" align="center"></td>
     <td></td><td></td></tr> <tr ><td width="131"></td>
     <td colspan="4" align="center"></td>
     <td></td><td></td></tr>
   
   
<tr><td colspan="8"><hr color="#000000"></td></tr>
<TR><td colspan="8" height="5"></td></TR>
     

 
   
   

   
 <tr><td  bgcolor="#999999">TOTAL</td><td colspan="6"><?php echo numtoletras($c_importe);?> </td>  <td> <B>  <?php echo $c_importe;?></B>   </td>  </tr>
</table>
</TD></TR></TABLE>
</body>
</html>