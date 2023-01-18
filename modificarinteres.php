<?php include ("seguridad.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);?>
<?php require('conexionsql2.php');
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>MODIFICAR INTERESES</title> 
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
function chequear(){  
    if(recomienda.interes.value=="")   {
      alert("interes no ingresado.");   
	  return(false);}
	    else   if(isNaN(recomienda.interes.value))   {
              alert("ingrese un numero");   
	           return(false);}
			   			   
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
form{width:450px; margin:auto; background: #CCCCCC;
padding:10px 20px;
box-sizing:border-box;
margin-top:10px;
border-radius:7px}
h1{color: #666666; text-align:center; margin:0; font-size:30px; margin-bottom:20px}
input,textarea{ width:100%; margin-bottom:20px; padding:7px; box-sizing:border-box; font-size:17px; border:none;}
#boton{ background:#666666; color:rgb(255,255,255); padding:20px;}
#boton:hover{cursor:pointer;}
#tabla2{
	background: rgb(255,255,255); text-align:left; width:800px; border-collapse:collapse}
	th,td{ padding:10px;}
	thead{ background:#999999; border-bottom: solid 5px #0f362d;}
	tr:nth-child(even){ background:#ddd;
		
		}
--> 
</style> 
</head> 
<body  > 

<?php require('menu.php');?>


<?php if(isset($_POST['enviar'])) {
if (strtoupper($_POST["interes"])=="" ){
echo "<h1>Campos Vacios</h1> ";}
else{
require('conexionsql2.php');
   $interes = $_POST["interes"]; 
$diario = $_POST["diario"]; 
  $interesi = $_POST["interesi"]; 
    $beneficio = $_POST["beneficio"]; 
	$limite = $_POST["limite"]; 
	$comisionv = $_POST["comisionv"]; 
	$comisionc = $_POST["comisionc"]; 
   
   $sql = "UPDATE datos SET interes='$interes',pordia='$diario',unpago='$interesi',dospagos='$beneficio',trespagos='$limite',comisionv='$comisionv',comisionc='$comisionc' WHERE id=1";
      $result = mysqli_query($link,$sql);
	  	  
	  
   ?>
<script type="text/javascript">
window.alert("MODIFICACION EXITOSA");
</script>

<?php 


} 

}
   


require('conexionsql2.php');
   
   $sql = $query = "SELECT * from datos WHERE id=1" ;
   $result = mysqli_query($link,$sql);   
 if ($row = mysqli_fetch_array($result)){ 
 
 $interes= $row["interes"]; 
  $diario= $row["pordia"]; 
   $interesi= $row["unpago"]; 
   $beneficio= $row["dospagos"]; 
   $limite= $row["trespagos"]; 
    $comisionv= $row["comisionv"]; 
	 $comisionc= $row["comisionc"]; 
  
    ?>
<div align="center"><H1>MODIFICAR INTERESES:</H1><br>
<form method="post" onSubmit="return chequear();" action="modificarinteres.php" name="recomienda">

              INTERES ANUAL PRESTAMOS :<input  type="Text" size="40" <?php echo "value='$interes'"  ?> name="interes"> 
               <input  type="Text" size="40" <?php echo "value='$interesi'"  ?> style="display: none;" name="interesi">   
              INTERES POR DIA DE MORA :<input  type="Text" size="40" <?php echo "value='$diario'"  ?> name="diario">  
             BENEFICIO AUMENTO DE LIMITE :<input  type="Text" size="40" <?php echo "value='$beneficio'"  ?> name="beneficio">
            LIMITE :<input  type="Text" size="40" <?php echo "value='$limite'"  ?> name="limite">
              COMISION VENDEDOR :<input  type="Text" size="40" <?php echo "value='$comisionv'"  ?> name="comisionv">
                COMISION COBRADOR :<input  type="Text" size="40" <?php echo "value='$comisionc'"  ?> name="comisionc">
            
   <input type="Submit"  id="boton" name="enviar" value="GUARDAR CAMBIOS"> 
  </form> </div>

















<?php }
   
?>



</div>
</td></tr></table>
</body>
</html>