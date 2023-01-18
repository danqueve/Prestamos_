<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<?php require('conexionsql2.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>CONSULTA DE USUARIOS DE SISTEMA</title> 
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
	if(confirm('¿DESEA ELIMINAR ESTE USUARIO'))
		return true;
	else
		return false;
}
</script>
<script language="JavaScript"> 
function chequear(){   

    if(recomienda.usuario.value=="")   {
      alert("Usuario no ingresado.");   
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
form{width:450px; margin:auto; background: #CCCCCC;
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{color: #666666; text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea,select{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#666666; color:rgb(255,255,255); padding:20px;}
#boton:hover{cursor:pointer;}
#tabla2{
	background: rgb(255,255,255); text-align:left; width:1000px; border-collapse:collapse}
	th,td{ padding:10px;font-size:16px;}
	thead{ background:#999999; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;
		
		}
--> 
</style> 
</head> 
<body bgcolor="#999999" > 

<?php require('menu.php');?>


<H1>CONSULTAR USUARIOS</H1>

<form action="buscarusuarios.php" method="get"> 
DATO A BUSCAR: 
<input  type="text" name="criterio" size="22" maxlength="150" placeholder="Ingrese dato a buscar"> 
<input  type="submit" value="Buscar" id="boton"> 
</form> 
<br />

<?php if(isset($_POST['enviar'])) {
if (strtoupper($_POST["rol"])==""  or strtoupper($_POST["usuario"])==""){
echo "<h1>Campos Vacios</h1> ";}
else{
require('conexionsql2.php');
   $c_id = $_POST["id"]; 
$c_usuario = trim($_POST["usuario"]);  
$c_rol = trim($_POST["rol"]); 
 

   
   $sql = "UPDATE claves SET rol='$c_rol' WHERE id=$c_id";
      $result = mysqli_query($link,$sql);
	  	  
	  
   ?>
<script type="text/javascript">
window.alert("MODIFICACION EXITOSA");
</script>

<?php 


} 

}
   

$bandera = $_GET["bandera"];

if ($bandera=="modificar"){

require('conexionsql2.php');
   $c_id=$_GET["modificarid"];
   $sql = $query = "SELECT * from claves WHERE id LIKE '%{$c_id}%'" ;
   $result = mysqli_query($link,$sql);   
 if ($row = mysqli_fetch_array($result)){ 
 
 $c_usuario= $row["usuario"]; 
 $c_rol= $row["rol"]; 
  
 
 
    ?>
<div align="center"><H1>MODIFICAR DATOS:</H1><br>
<form method="post" onSubmit="return chequear();" action="buscarusuarios.php" name="recomienda">
<input type="Text" style="display: none;" readonly size="10" <?php echo "value='$c_id'" ?> name="id">
    USUARIO  :<input  type="Text" size="40" <?php echo "value='$c_usuario'"  ?>  readonly name="usuario">
       ROL: 
  <SELECT  NAME="rol"  >
  <option value="" selected disabled>Selecciona una opcion...</option>
<OPTION <?php if ($c_rol=="ADMINISTRADOR")
{echo "selected"; }   ?> >ADMINISTRADOR
<OPTION <?php if ($c_rol=="INVITADO")
{echo "selected"; }   ?> >INVITADO

</SELECT> 
                    
            
   <input type="Submit"  id="boton" name="enviar" value="GUARDAR CAMBIOS"> 
  </form> </div>

<?php }} ?>





<?php require('conexionsql2.php');
?> 



<?php $bandera = $_GET["bandera"];

if ($bandera=="borrar") { 

require('conexionsql2.php');
   $c_id = $_GET["borrarid"]; 
    $sql = "DELETE FROM claves WHERE id=$c_id";  
   $result = mysqli_query($link,$sql);
     
   
      ?>
<script type="text/javascript">
window.alert("ELIMINACIÓN EXITOSA");
</script>

<?php
  }


//inicializo el criterio y recibo cualquier cadena que se desee buscar 
$criterio = ""; 
$txt_criterio = ""; 
$criterio = " where (usuario like '%" . $txt_criterio . "%' )"; 
if ($_GET["criterio"]!=""){ 
   $txt_criterio = $_GET["criterio"]; 
   $criterio = " where (usuario like '%" . $txt_criterio . "%' )"; 
} 


$sql="SELECT * FROM claves ".$criterio; 
$tabla="claves";
$res=mysqli_query($link,$sql); 
$numeroRegistros=mysqli_num_rows($res); 
if($numeroRegistros<=0) 
{ 
    
    echo "<h1>No se encontraron resultados</h1>"; 

}else{ 
    //////////elementos para el orden 
    if(!isset($orden)) 
    { 
       $orden="usuario"; 
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
$sql="SELECT * FROM claves ".$criterio." ORDER BY ".$orden." ASC LIMIT ".$limitInf.",".$tamPag; 
$res=mysqli_query($link,$sql); 

//////////fin consulta con limites 

echo "<table id='tabla2' align='center' >"; 
echo "<thead><tr><th>USUARIO</th><th>ROL</th>"; 
echo "<th>ELIMINAR</th>"; 
echo "<th>MODIFICAR</th>";
echo "</TR></thead>";
while($registro=mysqli_fetch_array($res)) 
{ 
?> 
   <!-- tabla de resultados --> 
    <tr  bgcolor="#DDD" onMouseOver="this.style.backgroundColor='#FFCC99';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#DDD'"o"];" > 
        <td><?php echo $registro["usuario"]; ?></td> 
              <td><?php echo mb_strtoupper(trim($registro["rol"]),'UTF-8'); ?></td> 
          
                
      
         <td><?php echo "<a onclick='return confirmar()' class='ord' href='".$_SERVER["PHP_SELF"]."?bandera=borrar&borrarid=".$registro["id"]."'>"."ELIMINAR <img src='delete.jpg'></a>"; ?></td>
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

<?php echo "<H1><FONT color='#666666'>CANTIDAD DE USUARIOS:".$numeroRegistros."<BR></FONT></H1>";?>


















</table></td></tr>





</div>
</td></tr></table>

</body>
</html>