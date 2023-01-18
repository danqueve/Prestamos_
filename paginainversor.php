<? include ("seguridad.php");?>
<? 
require('conexionsql.php');

?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>BUSCAR INVERSORES</title> 
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" /> 
<script>
function cargar(apellido,nombre,direccion,idcliente,dni,telefono){
opener.document.form1.nombre.value=nombre;
opener.document.form1.apellido.value=apellido;
opener.document.form1.idcliente.value=idcliente;
opener.document.form1.direccion.value=direccion;
opener.document.form1.dni.value=dni;
opener.document.form1.telefono.value=telefono;
window.close();
}

</script>


</head> 
<body > 

<table width="700" align="center" bgcolor="#FFFFFF" ><tr><td>
<form action="paginainversor.php" method="get"> 
DATO A BUSCAR: 
<input type="text" name="criterio" size="22" maxlength="150"> 
<input type="submit" value="Buscar"> 
</form> 
<hr noshade style="color:CC6666;height:1px"> 
<br> 


<? 

require('conexionsql.php');
//inicializo el criterio y recibo cualquier cadena que se desee buscar 
$criterio =  " where  (apellido like '%" . $txt_criterio . "%' or nombre like '%" . $txt_criterio . "%' or dni like '%" . $txt_criterio . "%')"; 
$txt_criterio = ""; 
if ($_GET["criterio"]!=""){ 
   $txt_criterio = mb_strtolower(trim($_GET["criterio"]),'UTF-8'); 
   $criterio =   " where  (apellido like '%" . $txt_criterio . "%' or nombre like '%" . $txt_criterio . "%' or dni like '%" . $txt_criterio . "%') ";    
} 


$sql="SELECT * FROM inversores ".$criterio; 
$res=mysql_query($sql); 
$numeroRegistros=mysql_num_rows($res); 
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
    $tamPag=200; 

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
$sql="SELECT * FROM inversores ".$criterio." ORDER BY ".$orden.",id ASC LIMIT ".$limitInf.",".$tamPag; 
$res=mysql_query($sql); 

//////////fin consulta con limites 

     ?>
     <form name="f1" id="f1" action="" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><B>APELLIDO</B></td>
    <td><B>NOMBRE</B></td>
     <td><B>DNI</B></td>
     <td><B>DIRECCION</B></td>
    <td>&nbsp;</td>
  </tr>
  <?php while($row=mysql_fetch_assoc($res)){?>
  <tr><td colspan="8"><hr color="#990000"></td></tr>
  <tr>
  
 
    <td ><font  size="2"><?php echo mb_strtoupper(trim($row["apellido"]),'UTF-8') ?></font></td>
    <td ><font  size="2"><?php echo mb_strtoupper(trim($row["nombre"]),'UTF-8') ?></font></td>
       <td ><?php echo $row['dni'] ?></td>
        <td ><?php echo $row['direccion'] ?></td>
       <td ><input type="button" name="Submit" value="cargar" onClick="cargar('<?php echo mb_strtoupper(trim($row["apellido"]),'UTF-8') ?>','<?php echo mb_strtoupper(trim($row["nombre"]),'UTF-8') ?>','<?php echo $row['direccion'] ?>','<?php echo $row['id'] ?>','<?php echo $row['dni'] ?>','<?php echo $row['telefono'] ?>')"></td>
  </tr><?php } ?>
</table></form>
     
   <!-- fin tabla resultados --> 
<? 
}//fin while 








//////////a partir de aqui viene la paginacion 
?> 
    <br> 
    <table border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr><td align="center" valign="top"> 
<? 
    if($pagina>1) 
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
<? 
    mysql_close(); 
?>



</div>
</td></tr></table>
</body>
</html>