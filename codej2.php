<?php

    $conexion = new mysqli('localhost','root','','u335739870_amigos');
    $code = $_POST['code'];
    $consulta = "select * FROM contribuyentes WHERE dni = '$code'";

    $result = $conexion->query($consulta);

    $respuesta = new stdClass();
    if($result->num_rows > 0){
        $fila = $result->fetch_array();
        $respuesta->apellido = $fila['apellido'];
        $respuesta->nombre = $fila['nombre'];  
		   $respuesta->direccion = $fila['direccion'];  
		    $respuesta->idc = $fila['id'];  
			$respuesta->idfoto = $fila['foto']; 
			$respuesta->grupo = $fila['gruposanguineo'];
			$respuesta->frh = $fila['frh'];
			$respuesta->fechanac = $fila['fechanac'];
			$respuesta->nacionalidad = $fila['nacionalidad'];
				$respuesta->estadocivil = $fila['estadocivil'];
    }
    echo json_encode($respuesta);

?>