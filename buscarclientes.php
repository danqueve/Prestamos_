<?php include("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<?php require('conexionsql2.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>CONSULTA DE CLIENTES</title> 
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
	if(confirm('¿DESEA ELIMINAR ESTE CLIENTE, SE ELIMINARAN TAMBIEN SUS DATOS DE PRESTAMOS Y PAGOS'))
		return true;
	else
		return false;
}
</script>
<script language="JavaScript"> 
function chequear(){
var mensaje=recomienda.fechanac.value;
mensaje=mensaje.trim();  
cadena = recomienda.dni.value;
    if(recomienda.apellido.value=="")   {
      alert("apellido no ingresado.");   
	  return(false);}
	    else   if(recomienda.nombre.value=="")   {
              alert("nombre no ingresado.");   
	           return(false);}
			     else   if(recomienda.limite.value=="0")   {
              alert("limite no ingresado.");   
	           return(false);}
			   else   if(recomienda.limite.value=="")   {
              alert("limite no ingresado.");   
	           return(false);}
			   
			    else  if(mensaje.indexOf('/') >=0 ) {
              alert("LAS FECHAS DEBEN SER EN FORMATO DIA-MES-AÑO EJEMPLO 10-05-2018");   
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
#boton{ background: #1730b3; color:rgb(255,255,255); padding:20px;}
#boton:hover{cursor:pointer;}
#tabla2{
	background: rgb(255,255,255); text-align:left; width:100%; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background: #black; border-bottom: solid 5px #0f362d; color:black}
	tr:nth-child(even){ background:#ddd;
		
		}
--> 
</style> 
</head> 
<body bgcolor="#99ecf2" > 

<?php
require('menu.php');?>

<H1>CONSULTAR CLIENTES</H1>

<form action="buscarclientes.php" method="get"> 
DATO A BUSCAR: 
<input  type="text" name="criterio" size="22" maxlength="150" placeholder="Ingrese dato a buscar"> 
<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />
<?php
if(isset($_POST['enviar'])) {
if (strtoupper($_POST["apellido"])=="" or strtoupper($_POST["nombre"])==""){
echo "<h1>Campos Vacios</h1> ";}
else{
require('conexionsql2.php');
   $c_id = $_POST["id"]; 
$c_nombre = mb_strtolower(trim($_POST["nombre"]),'UTF-8'); 
$c_apellido = mb_strtolower(trim($_POST["apellido"]),'UTF-8');
$c_ciudad = mb_strtolower(trim($_POST["ciudad"]),'UTF-8');
$c_provincia = mb_strtolower(trim($_POST["provincia"]),'UTF-8'); 
$c_estadocivil = mb_strtolower(trim($_POST["estadocivil"]),'UTF-8');
$c_email = mb_strtolower(trim($_POST["email"]),'UTF-8'); 
$c_fechanac = trim($_POST["fechanac"]);
$c_limite = trim($_POST["limite"]);
$c_fechanacsql= trim(substr($c_fechanac,6,4)."-".substr($c_fechanac,3,2)."-".substr($c_fechanac,0,2));
$c_entrecalles = mb_strtolower(trim($_POST["entrecalles"]),'UTF-8');
$c_cp = mb_strtolower(trim($_POST["cp"]),'UTF-8');
$c_direccione = mb_strtolower(trim($_POST["direccione"]),'UTF-8');

$c_dni = strtoupper(trim($_POST["dni"]));
$c_direccion = mb_strtolower(trim($_POST["direccion"]),'UTF-8');
$c_telefono = strtoupper(trim($_POST["telefono"]));
$c_sueldo = trim($_POST["sueldo"]);

   
   $sql = "UPDATE clientes SET apellido='$c_apellido', nombre='$c_nombre', dni='$c_dni' , direccion='$c_direccion' ,telefono='$c_telefono',entrecalles='$c_entrecalles',cp='$c_cp',direccione='$c_direccione',observacion='$c_observacion',ciudad='$c_ciudad',provincia='$c_provincia',email='$c_email',fechanac='$c_fechanac',fechanacsql='$c_fechanacsql',estadocivil='$c_estadocivil',limite='$c_limite',sueldo='$c_sueldo',trabajo='$c_trabajo',telefonotrabajo='$c_telefonotrabajo',telefono2='$c_telefono2',celular='$c_celular',ciudade='$c_ciudade',interno='$c_interno'  WHERE id=$c_id";
      $result = mysqli_query($link,$sql);
	  	  
	  
   ?>
<script type="text/javascript">
window.alert("MODIFICACION EXITOSA");
</script>

<?php
}}
$bandera="";
$bandera = $_GET["bandera"];
if ($bandera=="modificar"){
require('conexionsql2.php');
   $c_id=$_GET["modificarid"];
   $sql = $query = "SELECT * from clientes WHERE id LIKE '%{$c_id}%'" ;
   $result = mysqli_query($link,$sql);   
 if ($row = mysqli_fetch_array($result)){  
 $c_apellido= $row["apellido"]; 
 $c_nombre= $row["nombre"]; 
  $c_dni= $row["dni"]; 
 $c_direccion= $row["direccion"];
   $c_telefono= $row["telefono"]; 
   $c_entrecalles= $row["entrecalles"]; 
   
   $c_direccione= $row["direccione"]; 

$c_ciudad= $row["ciudad"];


$c_email= $row["email"];
$c_fechanac= $row["fechanac"];
 
 $c_limite= $row["limite"]; 
 $c_sueldo= $row["sueldo"]; 
 
 
    ?>
<div align="center"><H1>MODIFICAR DATOS:</H1><br>
<form method="post" onSubmit="return chequear();" action="buscarclientes.php" name="recomienda">
<input type="Text" style="display: none;" readonly size="10" <?php echo "value='$c_id'" ?> name="id">
    APELLIDO  :<input  type="Text" size="40" <?php echo "value='$c_apellido'"  ?> name="apellido">
       NOMBRE  :<input  type="Text" size="40" <?php echo "value='$c_nombre'"  ?> name="nombre">
          DNI  :<input  type="Text" size="40" <?php echo "value='$c_dni'"  ?> name="dni">
          EMAIL  :<input  type="Text" size="40" <?php echo "value='$c_email'"  ?> name="email">
           
                FECHA NAC.  :<input  type="Text" size="40" <?php echo "value='$c_fechanac'"  ?> name="fechanac">
            DIRECCION  :<input  type="Text" size="40" <?php echo "value='$c_direccion'"  ?> name="direccion"> 
              ENTRE CALLES  :<input  type="Text" size="40" <?php echo "value='$c_entrecalles'"  ?> name="entrecalles"> 
            CIUDAD  :<input  type="Text" size="40" <?php echo "value='$c_ciudad'"  ?> name="ciudad"> 
            PROVINCIA  :<input  type="Text" size="40" <?php echo "value='$c_provincia'"  ?> name="provincia">
             COD POSTAL :<input  type="Text" size="40" <?php echo "value='$c_cp'"  ?> name="cp">  
              TELEFONO  :<input  type="Text" size="40" <?php echo "value='$c_telefono'"  ?> name="telefono"> 
            CELULAR  :<input  type="Text" size="40" <?php echo "value='$c_celular'"  ?> name="celular"> 
            
             LIMITE  :<input  type="Text" size="40" <?php echo "value='$c_limite'"  ?> name="limite">
             SUELDO  :<input  type="Text" size="40" <?php echo "value='$c_sueldo'"  ?> name="sueldo">
             
             
             
             
           
             
   <input type="Submit"  id="boton" name="enviar" value="GUARDAR CAMBIOS"> 
  </form> </div>

<?php }} ?>







<?php $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql2.php');
   $c_id = $_GET["borrarid"]; 
    $sql = "DELETE FROM clientes WHERE id=$c_id";  
   $result = mysqli_query($link,$sql);
    $sql2 = "DELETE FROM prestamos WHERE idcliente=$c_id";  
	   $result = mysqli_query($link,$sql2);
	   $sql3 = "DELETE FROM cuotas WHERE idcliente=$c_id";  
	   $result = mysqli_query($link,$sql3); 
	   $sql4 = "DELETE FROM cobros WHERE idcliente=$c_id";  
	   $result = mysqli_query($link,$sql4); 
   $sql5 = "DELETE FROM reimpresion WHERE idcliente=$c_id";  
	   $result = mysqli_query($link,$sql5); 
  
   
      ?>
<script type="text/javascript">
window.alert("ELIMINACIÓN EXITOSA");
</script>

<?php
  }


//inicializo el criterio y recibo cualquier cadena que se desee buscar 
$criterio = ""; 
$txt_criterio = ""; 
$criterio = " where (apellido like '%" . $txt_criterio . "%' or nombre like '%" . $txt_criterio . "%'or dni like '%" . $txt_criterio . "%'or ciudad like '%" . $txt_criterio . "%'or provincia like '%" . $txt_criterio . "%')"; 
if ($_GET["criterio"]!=""){ 
   $txt_criterio = $txt_criterio = mb_strtolower(trim($_GET["criterio"]),'UTF-8'); 
   $criterio = " where (apellido like '%" . $txt_criterio . "%' or nombre like '%" . $txt_criterio . "%'or dni like '%" . $txt_criterio . "%'or ciudad like '%" . $txt_criterio . "%'or provincia like '%" . $txt_criterio . "%')"; 
} 


$sql="SELECT * FROM clientes ".$criterio; 
$tabla="clientes";
$res=mysqli_query($link,$sql); 
$numeroRegistros=mysqli_num_rows($res); 
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
$sql="SELECT * FROM clientes ".$criterio." ORDER BY ".$orden." ASC LIMIT ".$limitInf.",".$tamPag; 
$res=mysqli_query($link,$sql); 

//////////fin consulta con limites 
function CalculaEdad($fecha)
{
list($Y,$m,$d) = explode("-",$fecha);
return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>APELLIDO</th>"; 
echo "<th>NOMBRE</th>"; 
echo "<th>DNI</th>";

echo "<th>FECHA NAC.</th>";
echo "<th>EDAD</th>";
echo "<th>EMAIL</th>";
echo "<th>DIRECCION</th>"; 
echo "<th>ENTRE CALLES</th>";
echo "<th>CIUDAD</th>";
echo "<th>TELEFONO</th>";
echo "<th>CELULAR</th>";
echo "<th>LIMITE ACT.</th>";
echo "<th>SUELDO</th>";

echo "<th>MODIFICAR</th>"; 
echo "</TR></thead>";
while($registro=mysqli_fetch_array($res)) 
{ 
?> 
   <!-- tabla de resultados --> 
    <tr  bgcolor="#808080" onMouseOver="this.style.backgroundColor='#FFCC99';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#9aecfe'"o"];" > 
        <td><?php echo mb_strtoupper(trim($registro["apellido"]),'UTF-8'); ?></td> 
         <td><?php echo mb_strtoupper(trim($registro["nombre"]),'UTF-8');  ?></td> 
         <td><?php echo $registro["dni"]; ?></td>
         <td><?php echo $registro["fechanac"]; ?></td>
         <?php $c_edad=CalculaEdad($registro["fechanacsql"]);?>
        <td><?php echo $c_edad;  ?></td>
        <td><?php echo mb_strtoupper(trim($registro["email"]),'UTF-8');  ?></td> 
        <td><?php echo mb_strtoupper(trim($registro["direccion"]),'UTF-8');  ?></td>
        <td><?php echo mb_strtoupper(trim($registro["entrecalles"]),'UTF-8');  ?></td>
        <td><?php echo mb_strtoupper(trim($registro["ciudad"]),'UTF-8');  ?></td> 
        <td><?php echo "<a target=_blank href='https://api.whatsapp.com/send?phone=".$registro["telefono"]."'>".$registro["telefono"]; ?></td>
        <td><?php echo "<a target=_blank href='https://api.whatsapp.com/send?phone=".$registro["celular"]."'>".$registro["celular"]; ?></td>
        <td><?php echo $registro["limite"]; ?></td>
        <td><?php echo $registro["sueldo"]; ?></td>
       
       
       <td><?php echo "<a class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=modificar&modificarid=".$registro["id"]."'>"."MODIFICAR </a>"; ?></td> 
      
    
     </tr> 
   <!-- fin tabla resultados --> 
<?php }//fin while 
echo "</table>"; 
}//fin if 
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

<?php echo "<H1><FONT color='#31384A'>CANTIDAD DE CLIENTES:".$numeroRegistros."<BR></FONT></H1>";?>
<?php echo "<H1><a target='_blank' class='ord' href='"."pdfclientes.php?tabla=".$tabla."&criterio=".$txt_criterio."&numeroclientes=".$numeroRegistros."'>IMPRIMIR LISTADO</a></H1>"; ?>
<?php echo "<H1><a target='_blank' class='ord' href='"."aexcel.php?tabla=".$tabla."&criterio=".$txt_criterio."&numeroabonados=".$numeroRegistros."'>ENVIAR A EXCEL</a></H1>"; ?>
















</table></td></tr>





</div>
</td></tr></table>
</body>
</html>