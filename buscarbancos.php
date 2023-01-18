<? include ("seguridad.php");?>
<? 
require('conexionsql.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>CONSULTA DE BANCOS</title> 
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
	if(confirm('¿DESEA ELIMINAR ESTE BANCO'))
		return true;
	else
		return false;
}
</script>
<script language="JavaScript"> 
function chequear(){   

    if(recomienda.importe.value=="")   {
      alert("Saldo no ingresado.");   
	  return(false);}
	   else   if(recomienda.fecha.value=="")   {
              alert("fecha no ingresada.");   
	           return(false);}
			    else   if(recomienda.nombre.value=="")   {
              alert("Nombre no ingresado.");   
	           return(false);}
   					  
					  else {
               alert("Los datos son correctos");   
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
form{width:1050px; margin:auto; background:rgba(0,0,0,0.4);
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
.claseinput2 { width:100px;}
h1{color:rgb(255,255,255); text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea,select{ width:180px; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#31384A; color:rgb(255,255,255);  width:120px;}
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

<H1>CONSULTAR BANCOS</H1>

<form action="buscarbancos.php" method="get"> 
NOMBRE BANCO: <input type="text" class="claseinput2" name="nombre" > FECHA:<input class="claseinput2" type="text" name="fecha" > 
TIPO:<input class="claseinput2" type="text" name="tipo" > OBSERVACION:<input class="claseinput2" type="text" name="observacion" > 
<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />
<?
if(isset($_POST['enviar'])) {
if (strtoupper($_POST["nombre"])=="" ){
echo "<h1>Campos Vacios</h1> ";}
else{
require('conexionsql.php');
   $c_id = $_POST["id"]; 
$c_observacion = mb_strtolower(trim($_POST["observacion"]),'UTF-8');
$c_nombre = mb_strtolower(trim($_POST["nombre"]),'UTF-8');

$c_transferencia = ($_POST["transferencia"]);  
$c_importe = ($_POST["importe"]);
$c_tipo = ($_POST["tipo"]);
 $c_importecheque = ($_POST["importecheque"]);
 $c_cheque = ($_POST["cheque"]);
 $c_tipo = ($_POST["tipo"]);
$c_fecha = ($_POST["fecha"]); 
$fechasql= trim(substr($c_fecha,6,4)."-".substr($c_fecha,3,2)."-".substr($c_fecha,0,2));

   
   $sql = "UPDATE bancos SET nombre='$c_nombre', transferencia='$c_transferencia' , observacion='$c_observacion' ,importe='$c_importe',cheque='$c_cheque',fecha='$c_fecha',fechasql='$fechasql',importecheque='$c_importecheque',tipo='$c_tipo'  WHERE id=$c_id";
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
   $sql = $query = "SELECT * from bancos WHERE id LIKE '%{$c_id}%'" ;
   $result = mysql_query($sql);   
 if ($row = mysql_fetch_array($result)){ 
 
 $c_observacion= $row["observacion"]; 
 $c_nombre= $row["nombre"]; 
  $c_importe= $row["importe"]; 
  $c_tipo= $row["tipo"]; 
 $c_transferencia= $row["transferencia"];
   $c_cheque= $row["cheque"]; 
   $c_importecheque= $row["importecheque"]; 
   $c_fecha= $row["fecha"]; 
   
  
 
    ?>
<div align="center"><H1>MODIFICAR DATOS:</H1>
<form method="post" onSubmit="return chequear();" action="buscarbancos.php" name="recomienda">
<input type="Text" style="display: none;" readonly size="10" <? echo "value='$c_id'" ?> name="id">
           NOMBRE  :<input  type="Text" size="40" <? echo "value='$c_nombre'"  ?> name="nombre">
       TIPO:    <SELECT  NAME="tipo"  >
  <option value="" selected disabled>Selecciona una opcion...</option>
<OPTION <?  if ($c_tipo=="SALDO")
{echo "selected"; }   ?> >SALDO
<OPTION <?  if ($c_tipo=="TRANSFERENCIA")
{echo "selected"; }   ?> >TRANSFERENCIA
<OPTION <?  if ($c_tipo=="CHEQUE")
{echo "selected"; }   ?> >CHEQUE
<OPTION <?  if ($c_tipo=="TARJETA-CREDITO")
{echo "selected"; }   ?> >TARJETA-CREDITO
</SELECT> 
          SALDO  :<input  type="Text" size="40" <? echo "value='$c_importe'"  ?> name="importe">
            TRANSFERENCIA  :<input  type="Text" size="40" <? echo "value='$c_transferencia'"  ?> name="transferencia"> 
              <BR>CHEQUE N  :<input  type="Text" size="40" <? echo "value='$c_cheque'"  ?> name="cheque"> 
              IMPORTE CHEQUE :<input  type="Text" size="40" <? echo "value='$c_importecheque'"  ?> name="importecheque"> 
              OBSERVACION  :<input  type="Text" size="40" <? echo "value='$c_observacion'"  ?> name="observacion">   FECHA  :<input  type="Text" size="40" <? echo "value='$c_fecha'"  ?> name="fecha"> 
           
   <input type="Submit"   name="enviar" value="GUARDAR CAMBIOS"> 
  </form> </div>

<? }} ?>







<? 

 $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql.php');
   $c_id = $_GET["borrarid"]; 
    $sql = "DELETE FROM bancos WHERE id=$c_id";  
   $result = mysql_query($sql);
     
  
   
      ?>
<script type="text/javascript">
window.alert("ELIMINACIÓN EXITOSA");
</script>

<?php
  }


$nombree=$_GET["nombre"];
$fechae=$_GET["fecha"];
$tipoe=$_GET["tipo"];
$observacione=$_GET["observacion"];


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


$sql="SELECT * FROM bancos ".$criterio; 
$tabla="bancos";
$res=mysql_query($sql); 
$numeroRegistros=mysql_num_rows($res); 
if($numeroRegistros<=0) 
{ 
    
    echo "<h1>No se encontraron resultados</h1>"; 

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
$sql="SELECT * FROM bancos ".$criterio." ORDER BY ".$orden." DESC LIMIT ".$limitInf.",".$tamPag; 
$res=mysql_query($sql); 

//////////fin consulta con limites 

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>NOMBRE</th>"; 
echo "<th>TIPO</th>"; 
echo "<th>SALDO</th>";
echo "<th>TRANSFERENCIA</th>"; 
echo "<th>CHEQUE N</th>";
echo "<th>IMPORTE CHEQUE</th>";
echo "<th>OBSERVACION</th>";
echo "<th>FECHA</th>";
echo "<th>ELIMINAR</th>"; 
echo "<th>MODIFICAR</th>"; 
echo "</TR></thead>";
while($registro=mysql_fetch_array($res)) 
{ 
?> 
   <!-- tabla de resultados --> 
    <tr  bgcolor="#DDD" onMouseOver="this.style.backgroundColor='#FFCC99';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#DDD'"o"];" > 
        <td><? echo mb_strtoupper(trim($registro["nombre"]),'UTF-8'); ?></td> 
         <td><? echo mb_strtoupper(trim($registro["tipo"]),'UTF-8');  ?></td> 
         <td><? echo $registro["importe"]; ?></td>
                  <td><? echo $registro["transferencia"]; ?></td>
          <td><? echo $registro["cheque"]; ?></td>
          <td><? echo $registro["importecheque"]; ?></td>
          <td><? echo $registro["observacion"]; ?></td>
            <td><? echo $registro["fecha"]; ?></td>
          
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

<? echo "<H1><a target='_blank' class='ord' href='"."pdfbancos2.php?tabla=".$tabla."&nombre=".$nombree."&fecha=".$fechae."&tipo=".$tipoe."&observacion=".$observacione."'>IMPRIMIR LISTADO</a></H1>"; ?>
















</table></td></tr>

<? 
    mysql_close(); 
?>



</div>
</td></tr></table>
</body>
</html>