<?php $claveingresada=$_POST["contrasena"];
$usuarioingresado=$_POST["usuario"];
require('conexionsql2.php');
$consulta = "SELECT * from claves where usuario='$usuarioingresado' limit 1;";
$resultado = mysqli_query( $link, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
while ($columna = mysqli_fetch_array( $resultado ))
{$clave=$columna["clave"];
	  $usuario=$columna["usuario"];
	   $rol=$columna["rol"];}
if($_POST["usuario"]===$usuario && $_POST["contrasena"]===$clave){ 
session_start();
$_SESSION["autentificado"]="SI";
$_SESSION['usuario']=$_REQUEST['usuario'];
$_SESSION['usuario22']=$usuario;
$_SESSION['clave']=$_REQUEST['contrasena'];
$_SESSION['rol']=$rol;
header("Location:inicio.php"); 
return;  
}else{header("Location:claves2.php?errorusuario=si");
return;}
?>