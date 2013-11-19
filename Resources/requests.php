<?php 
	session_start();
	require('backend/mysql.php');
	$mysql = new mysql();
	$mysql->conect();
	$action = $_POST['action'];
	switch($action){
		case 'loadChecks':
				$getNodes = "SELECT idDispositivo, nombre FROM dispositivos
				             WHERE idUsuario = $_SESSION[id] -- ";
				echo json_encode($mysql->query_assoc($getNodes));
			break;
		case 'loadMap':
			$getNodeCoord = "SELECT latitud, longitud FROM dispositivos
				             WHERE idDispositivo = $_POST[id] -- ";
				echo json_encode($mysql->query_assoc($getNodeCoord));
			break;
	}
 ?>