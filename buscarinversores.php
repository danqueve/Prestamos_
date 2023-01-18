<? include ("seguridad.php");?>
<? 
require('conexionsql.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>CONSULTA DE INVERSORES</title> 
<LINK REL=StyleSheet TYPE="text/css" HREF="estilo.css" media="screen">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Pragma" content="no-cache" /> 

<LINK rel=stylesheet 
type=text/css 
href="newsscroll.css"><LINK 
rel=stylesheet type=text/css 
href="style.css">


<SCRIPT type=text/javascript 
src="mootools.js"></SCRIPT>

<SCRIPT type=text/javascript 
src="jquery.js"></SCRIPT>

<SCRIPT type=text/javascript 
src="easySlider.js"></SCRIPT>
<script language="JavaScript">
function confirmar()
{
	if(confirm('¿DESEA ELIMINAR ESTE INVERSOR, SE ELIMINARAN TAMBIEN SUS DATOS DE INVERSIONES'))
		return true;
	else
		return false;
}
</script>
<script language="JavaScript"> 
function chequear(){  
cadena = recomienda.dni.value;
    if(recomienda.apellido.value=="")   {
      alert("apellido no ingresado.");   
	  return(false);}
	    else   if(recomienda.nombre.value=="")   {
              alert("nombre no ingresado.");   
	           return(false);}
			    else   if(cadena.indexOf('.') ==-1){
alert("ingresar el dni con puntos");
return(false);
}
			   
								  else {
                              return(true);   }
  }

</script>


<LINK rel=stylesheet type=text/css 
href="template.css"><LINK 
rel=stylesheet type=text/css 
href="menu_superior.css">
<SCRIPT language=javascript type=text/javascript 
src="lp.cssmenu.js"></SCRIPT>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>


<style type="text/css"> 
<!-- 
body{ font-family:monospace;}
form{width:450px; margin:auto; background:rgba(0,0,0,0.4);
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{color:rgb(255,255,255); text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#31384A; color:rgb(255,255,255); padding:20px;}
#boton:hover{cursor:pointer;}
#tabla2{
	background: rgb(255,255,255); text-align:left; width:1000px; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#246355; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;
		
		}
--> 
</style> 
</head> 
<body bgcolor="#999999" > 

<?
require('menu.php');?>

<H1>CONSULTAR INVERSORES</H1>

<form action="buscarinversores.php" method="get"> 
DATO A BUSCAR: 
<input  type="text" name="criterio" size="22" maxlength="150" placeholder="Ingrese dato a buscar"> 
<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />
<?
if(isset($_POST['enviar'])) {
if (strtoupper($_POST["apellido"])=="" or strtoupper($_POST["nombre"])==""){
echo "<h1>Campos Vacios</h1> ";}
else{
require('conexionsql.php');
   $c_id = $_POST["id"]; 
$c_apellido = mb_strtolower(trim($_POST["apellido"]),'UTF-8');  
$c_nombre = mb_strtolower(trim($_POST["nombre"]),'UTF-8'); 
$c_referencia = mb_strtolower(trim($_POST["referencia"]),'UTF-8'); 
$c_telefonoref = mb_strtolower(trim($_POST["telefonoref"]),'UTF-8'); 
$c_relacion = mb_strtolower(trim($_POST["relacion"]),'UTF-8'); 
$c_observacion = mb_strtolower(trim($_POST["observacion"]),'UTF-8');

$c_dni = strtoupper(trim($_POST["dni"]));
$c_direccion = mb_strtolower(trim($_POST["direccion"]),'UTF-8'); 
$c_telefono = strtoupper(trim($_POST["telefono"]));

   
   $sql = "UPDATE inversores SET apellido='$c_apellido', nombre='$c_nombre', dni='$c_dni' , direccion='$c_direccion' ,telefono='$c_telefono',referencia='$c_referencia',telefonoref='$c_telefonoref',relacion='$c_relacion',edad='$c_observacion'  WHERE id=$c_id";
      $result = mysql_query($sql);
	  	  
	  
   ?>
<script type="text/javascript">
window.alert("MODIFICACION EXITOSA");
</script>

<?php 


} 

}
   

$bandera = $_GET["bandera"];

if ($bandera=="modificar"){

require('conexionsql.php');
   $c_id=$_GET["modificarid"];
   $sql = $query = "SELECT * from inversores WHERE id LIKE '%{$c_id}%'" ;
   $result = mysql_query($sql);   
 if ($row = mysql_fetch_array($result)){ 
 
 $c_apellido= $row["apellido"]; 
 $c_nombre= $row["nombre"]; 
  $c_dni= $row["dni"]; 
 $c_direccion= $row["direccion"];
   $c_telefono= $row["telefono"]; 
   $c_referencia= $row["referencia"]; 
   $c_telefonoref= $row["telefonoref"]; 
   $c_relacion= $row["relacion"]; 
$c_observacion= $row["edad"]; 
  
 
    ?>
<div align="center"><H1>MODIFICAR DATOS:</H1><br>
<form method="post" onSubmit="return chequear();" action="buscarinversores.php" name="recomienda">
<input type="Text" style="display: none;" readonly size="10" <? echo "value='$c_id'" ?> name="id">
    APELLIDO  :<input  type="Text" size="40" <? echo "value='$c_apellido'"  ?> name="apellido">
       NOMBRE  :<input  type="Text" size="40" <? echo "value='$c_nombre'"  ?> name="nombre">
          DNI  :<input  type="Text" size="40" <? echo "value='$c_dni'"  ?> name="dni">
            DIRECCION  :<input  type="Text" size="40" <? echo "value='$c_direccion'"  ?> name="direccion"> 
              TELEFONO  :<input  type="Text" size="40" <? echo "value='$c_telefono'"  ?> name="telefono"> 
              REFERENCIA  :<input  type="Text" size="40" <? echo "value='$c_referencia'"  ?> name="referencia"> 
              TEL.REF :<input  type="Text" size="40" <? echo "value='$c_telefonoref'"  ?> name="telefonoref">   RELACION  :<input  type="Text" size="40" <? echo "value='$c_relacion'"  ?> name="relacion"> 
            OBSERVACION  :<input  type="Text" size="40" <? echo "value='$c_observacion'"  ?> name="observacion"> 
   <input type="Submit"  id="boton" name="enviar" value="GUARDAR CAMBIOS"> 
  </form> </div>

<? }} ?>







<? 

 $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql.php');
   $c_id = $_GET["borrarid"]; 
    $sql = "DELETE FROM inversores WHERE id=$c_id";  
   $result = mysql_query($sql);
    $sql2 = "DELETE FROM inversiones WHERE idcliente=$c_id";  
	   $result = mysql_query($sql2);
	   
  
  
   
      ?>
<script type="text/javascript">
window.alert("ELIMINACIÓN EXITOSA");
</script>

<?php
  }


//inicializo el criterio y recibo cualquier cadena que se desee buscar 
$criterio = ""; 
$txt_criterio = ""; 
$criterio = " where (apellido like '%" . $txt_criterio . "%' or nombre like '%" . $txt_criterio . "%'or dni like '%" . $txt_criterio . "%')"; 
if ($_GET["criterio"]!=""){ 
   $txt_criterio = $txt_criterio = mb_strtolower(trim($_GET["criterio"]),'UTF-8'); 
   $criterio = " where (apellido like '%" . $txt_criterio . "%' or nombre like '%" . $txt_criterio . "%'or dni like '%" . $txt_criterio . "%')"; 
} 


$sql="SELECT * FROM inversores ".$criterio; 
$tabla="inversores";
$res=mysql_query($sql); 
$numeroRegistros=mysql_num_rows($res); 
if($numeroRegistros<=0) 
{ 
    
    echo "<h1>No se encontraron resultados</h1>"; 

}else{ 
    //////////elementos para el orden 
    if(!isset($orden)) 
    { 
       $orden="apellido"; 
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
$sql="SELECT * FROM inversores ".$criterio." ORDER BY ".$orden." ASC LIMIT ".$limitInf.",".$tamPag; 
$res=mysql_query($sql); 

//////////fin consulta con limites 

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>APELLIDO</th>"; 
echo "<th>NOMBRE</th>"; 
echo "<th>DNI</th>";
echo "<th>DIRECCION</th>"; 
echo "<th>TELEFONO</th>";
echo "<th>REFERENCIA</th>";
echo "<th>TEL. REF</th>";
echo "<th>RELACION</th>";
echo "<th>OBSERVACION</th>";
echo "<th>ELIMINAR</th>"; 
echo "<th>MODIFICAR</th>"; 
echo "</TR></thead>";
while($registro=mysql_fetch_array($res)) 
{ 
?> 
   <!-- tabla de resultados --> 
    <tr  bgcolor="#DDD" onMouseOver="this.style.backgroundColor='#FFCC99';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#DDD'"o"];" > 
        <td><? echo mb_strtoupper(trim($registro["apellido"]),'UTF-8'); ?></td> 
         <td><? echo mb_strtoupper(trim($registro["nombre"]),'UTF-8');  ?></td> 
         <td><? echo $registro["dni"]; ?></td>
         <td><? echo mb_strtoupper(trim($registro["direccion"]),'UTF-8');  ?></td>
          <td><? echo $registro["telefono"]; ?></td>
          <td><? echo $registro["referencia"]; ?></td>
          <td><? echo $registro["telefonoref"]; ?></td>
          <td><? echo $registro["relacion"]; ?></td>
            <td><? echo $registro["edad"]; ?></td>
          
                <td><? echo "<a onclick='return confirmar()' class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=borrar&borrarid=".$registro["id"]."'>"."ELIMINAR <img src='delete.jpg'></a>"; ?></td>
       <td><? echo "<a class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=modificar&modificarid=".$registro["id"]."'>"."MODIFICAR </a>"; ?></td> 
        
    
     </tr> 
   <!-- fin tabla resultados --> 
<? 
}//fin while 
echo "</table>"; 
}//fin if 
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

<?php echo "<H1><FONT color='#31384A'>CANTIDAD DE INVERSORES:".$numeroRegistros."<BR></FONT></H1>";?>
<? echo "<H1><a target='_blank' class='ord' href='"."pdfinversores.php?tabla=".$tabla."&criterio=".$txt_criterio."&numeroclientes=".$numeroRegistros."'>IMPRIMIR LISTADO</a></H1>"; ?>
<? echo "<H1><a target='_blank' class='ord' href='"."aexcelinversores.php?tabla=".$tabla."&criterio=".$txt_criterio."&numeroabonados=".$numeroRegistros."'>ENVIAR A EXCEL</a></H1>"; ?>
















</table></td></tr>

<? 
    mysql_close(); 
?>



</div>
</td></tr></table>
</body>
</html>