<?php $usuario = "root";
	$password = "";
	$servidor = "localhost";
	$basededatos = "u335739870_amigos";	
	// creación de la conexión a la base de datos con mysql_connect()
	$link = mysqli_connect( $servidor, $usuario, "") or die ("No se ha podido conectar al servidor de Base de datos");	
	// Selección del a base de datos a utilizar
	$db = mysqli_select_db( $link, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
 date_default_timezone_set ( "America/Argentina/Buenos_Aires" );
?>

