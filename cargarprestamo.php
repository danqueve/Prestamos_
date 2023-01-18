<?PHP include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" /> 
<title>::GUARDAR PRESTAMO - IMPRIMIR::</title>
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



require('conexionsql2.php');
$result143 = mysqli_query($link,"SELECT *  FROM datos order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result143)){ 
 do { 
   $csistema=   $row["sistema"];
   } while ($row = mysqli_fetch_array($result143)); 
}
$cuotas = $_GET["cuota"];
$idcliente = $_GET["idcliente"];
$monto = $_GET["monto"];
$producto = $_GET["producto"];
$observ = $_GET["observ"];
$vendedor = $_GET["vendedor"];
$fechainicio = $_GET["fechap"];
$interes = $_GET["interes"];
$final = $_GET["final"];


$fechainiciosql= trim(substr($fechainicio,6,4)."-".substr($fechainicio,3,2)."-".substr($fechainicio,0,2));
$usuarionuevo=$_SESSION['usuario'];

$result25 = mysqli_query($link,"SELECT * FROM clientes WHERE id= '$idcliente' order by id desc limit 1"); 
if ($row = mysqli_fetch_array($result25)){ 
   
   do { 
   $apellido=mb_strtoupper(trim($row["apellido"]),'UTF-8');
   $nombre=mb_strtoupper(trim($row["nombre"]),'UTF-8');
    $direccion=mb_strtoupper(trim($row["direccion"]),'UTF-8');
	$telefono=$row["telefono"];
	$profesion=mb_strtoupper(trim($row["email"]),'UTF-8');
	$domicilio=mb_strtoupper(trim($row["localidad"]),'UTF-8');
	$sueldo=$row["observacion"];
	
	
	$dni=$row["dni"];
	
    } while ($row = mysqli_fetch_array($result25));
}



$result14 = mysqli_query($link,"SELECT `AUTO_INCREMENT`
FROM  INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'u335739870_amigos'
AND   TABLE_NAME   = 'prestamos';"); 
if ($row = mysqli_fetch_array($result14)){ 
 do { 
   $c_prestamo=   $row["AUTO_INCREMENT"];
   } while ($row = mysqli_fetch_array($result14)); 

}



?><table width="700px"  border="0"><TR><TD align="center" valign="top">
<table width="700px" border="0">
  <tr>
    <td colspan="3" align="center" bgcolor="#CCCCCC">
 <?php echo $csistema;?>   
    <h3>RESUMEN DEL CRÉDITO</h3>
   
         <b>PRESTAMO N°:</b> <?php echo $c_prestamo;?>&nbsp;<b>FECHA:</b><?php echo $fechainicio; ?>&nbsp;<b><br> MONTO INICIAL:$ </b> <?php echo $monto;?>&nbsp;<b>
        N° DE CUOTAS:</b>  </span>    </td>
    <td align="center" bgcolor="#CCCCCC"><img src="logo.jpg" width="90px"></td>
  </tr>
  <tr>
    <td colspan="4" ><b class="beto2"><hr>CLIENTE: <?php echo $apellido.", ".$nombre ;?> &nbsp; DNI: <?php echo $dni;?> &nbsp; DIRECCION: <?php echo $direccion;?></b><hr> </td>
  </tr>
     

<?php require('conexionsql2.php');
 $sql34 = "INSERT INTO prestamos (idcliente,  monto, interes, cuota, montofinal, fecha, fechasql, estado, observacion,observ,usuario,vendedor) VALUES ('$idcliente', '$monto', '$interes','$cuotas','$final','$fechainicio','$fechainiciosql','PENDIENTE','$producto','$observ','$usuarionuevo','$vendedor')";
   $result = mysqli_query($link,$sql34); 
   
   $usuarionuevo=$_SESSION['usuario'];
	
	$clientecaja="cliente:".$apellido.",".$nombre;
	$detallecobro="Prestamo N°:".$c_prestamo;
	$importecaja=$monto*-1;
    $sql21 = "INSERT INTO caja2 (detalle,importe,fecha,tipo,fechasql,observacion,usuario,idprestamo) VALUES ('$detallecobro','$importecaja','$fechainicio','EGRESO','$fechainiciosql','$clientecaja','$usuarionuevo','$c_prestamo')";
	$result = mysqli_query($link,$sql21); 
   
   
   
   $sql321 = "UPDATE clientes SET limite=limite-$monto WHERE id=$idcliente";
    $result = mysqli_query($link,$sql321);
   
for ( $i = 0 ; $i < $cuotas ; $i ++) {
$imp= "vimporte". $i;
$fec= "vfecha". $i;
$cuo= "vcuota". $i;

$importe[$i] = $_GET["$imp"];
$fechacuota[$i] = $_GET["$fec"];
$numcuota[$i] = $_GET["$cuo"];
$sqlfecha[$i]= trim(substr($fechacuota[$i],6,4)."-".substr($fechacuota[$i],3,2)."-".substr($fechacuota[$i],0,2));


	 $total=$total + $importe[$i];

 echo "<tr><td colspan='8'><b>CUOTA:</b>".$numcuota[$i]."<b> FECHA VENC:</b>".$fechacuota[$i]."<b> IMPORTE:$ </b>".$importe[$i]."</td></tr>";
 

	
    $impsql=$importe[$i];
	$fesql=$fechacuota[$i];
	$numsql=$numcuota[$i];
	$fssql=$sqlfecha[$i];
	
	  $sql4 = "INSERT INTO cuotas (idprestamo,  idcliente, cuota, monto, fecha, fechasql, estado,original,usuario) VALUES ('$c_prestamo', '$idcliente', '$numsql','$impsql','$fesql','$fssql','ADEUDADA','$impsql','$usuarionuevo')";
   $result = mysqli_query($link,$sql4); 
    
   
  } ?>
   
<tr><td colspan="4"><hr color="#000000"></td></tr>
<TR><td colspan="4" height="5"></td></TR>
     

 
   
   <tr><td colspan="2" bgcolor="#999999"><b class="beto2">TOTAL:</b><?php echo numtoletras($total);?></td>
   <td colspan="2"><b class="beto2">$ <?php echo $total;?> </b></td>  
   <td>     </td>  
   </tr>
   
 <tr><td  ><b class="beto2">PRODUCTO: <b class="beto2"><?php echo $producto;?> </b></b></td><td colspan="2"></td>  <td>    </td>  </tr>
  <tr><td  colspan="4">El atraso en el pago de la cuota implica un interes por mora diaria de:.....%</td>  </tr>
  <tr><td  colspan="4" align="right"><BR>FIRMA:........................<BR>ACLARACIÓN:............................</td>  </tr>
</table>
</TD></TR></TABLE>
<hr style="border:1px dotted black; width:100%;" >
<table width="700px"  border="0"><TR><TD align="center" valign="top">
<table width="700px" border="0">
  <tr>
    <td colspan="3" align="center" bgcolor="#CCCCCC">
    <?php echo $csistema;?>    <H3>RESUMEN DEL CRÉDITO</H3>
  
         <b>PRESTAMO N°:</b> <?php echo $c_prestamo;?>&nbsp;<b>FECHA:</b><?php echo $fechainicio; ?>&nbsp;<b> <br>MONTO INICIAL:$ </b> <?php echo $monto;?>&nbsp;<b>
        N° DE CUOTAS:</b> <?php echo $cuotas;?> </span>    </td>
    <td align="center" bgcolor="#CCCCCC"><img src="logo.jpg" width="90px"></td>
  </tr>
  <tr>
    <td colspan="4" ><b class="beto2"><hr>CLIENTE: <?php echo $apellido.", ".$nombre ;?> &nbsp; DNI: <?php echo $dni;?> &nbsp; DIRECCION: <?php echo $direccion;?></b><hr> </td>
  </tr>
     

<?php require('conexionsql2.php');
 $total=0;
for ( $i = 0 ; $i < $cuotas ; $i ++) {
$imp= "vimporte". $i;
$fec= "vfecha". $i;
$cuo= "vcuota". $i;

$importe[$i] = $_GET["$imp"];
$fechacuota[$i] = $_GET["$fec"];
$numcuota[$i] = $_GET["$cuo"];
$sqlfecha[$i]= trim(substr($fechacuota[$i],6,4)."-".substr($fechacuota[$i],3,2)."-".substr($fechacuota[$i],0,2));


	 $total=$total + $importe[$i];

 echo "<tr><td colspan='8'><b>CUOTA:</b>".$numcuota[$i]."<b> FECHA VENC:</b>".$fechacuota[$i]."<b> IMPORTE:$ </b>".$importe[$i]."</td></tr>";
 

	
    $impsql=$importe[$i];
	$fesql=$fechacuota[$i];
	$numsql=$numcuota[$i];
	$fssql=$sqlfecha[$i];
	
	 
    
   
  } ?>
   
<tr><td colspan="4"><hr color="#000000"></td></tr>
<TR><td colspan="4" height="5"></td></TR>
     

 
   
   <tr><td colspan="2" bgcolor="#999999"><b class="beto2">TOTAL:</b><?php echo numtoletras($total);?></td>
   <td colspan="2"><b class="beto2">$ <?php echo $total;?> </b></td>  
   <td>     </td>  
   </tr>
   
 <tr><td ><b class="beto2">PRODUCTO: <b class="beto2"><?php echo $producto;?> </b></b></td><td colspan="2"></td>  <td>    </td>  </tr>
  <tr><td  colspan="4">El atraso en el pago de la cuota implica un interes por mora diaria de:.....%</td>  </tr>
  <tr><td  colspan="4" align="right"><BR>FIRMA:........................<BR>ACLARACIÓN:............................</td>  </tr>
</table>
</TD></TR></TABLE>

</body>
</html>