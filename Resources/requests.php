<?php 
	session_start();
	require('mysql.php');
	$mysql = new mysql();
	$mysql->conect();
	$action = $_POST['action'];
	switch($action){
		case 'loadRadios':
				$getNodes = "SELECT idDispositivo, nombre FROM dispositivos
				             WHERE idUsuario = $_SESSION[id] -- ";
				$res = $mysql->query_assoc($getNodes);
				echo json_encode($res);
			break;
		case 'loadMap':
			$getNodeCoord = "SELECT latitud, longitud FROM dispositivos
				             WHERE idDispositivo = $_POST[id] -- ";
				echo json_encode($mysql->query_assoc($getNodeCoord));
			break;
	}
 ?>