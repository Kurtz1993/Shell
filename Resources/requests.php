<?php 
	session_start();
	require('mysql.php');
	$mysql = new mysql();
	$mysql->conect();
	$action = $_POST['action'];
	switch($action){
		case 'loadRadios':
				$getNodes = "SELECT idDispositivo, nombre FROM dispositivos
				             WHERE idUsuario = $_SESSION[id]; -- ";
				$res = $mysql->query_assoc($getNodes);
				echo json_encode($res);
			break;
		case 'loadMap':
			$getNodeCoord = "SELECT * FROM dispositivos
				             WHERE idDispositivo = $_POST[id]; -- ";
				echo json_encode($mysql->query_assoc($getNodeCoord));
			break;
		case 'loadUserInfo':
			$getUserData = "SELECT corporation, tel, correo
							FROM usuarios
							WHERE idUsuario = $_POST[id]; -- ";
			echo json_encode($mysql->query_assoc($getUserData));
			break;
		case 'loadNodes':
			$getNodes = "SELECT nombre Name, idDispositivo ID
						 FROM dispositivos
						 WHERE idUsuario = $_POST[id]; -- ";
			echo json_encode($mysql->query_assoc($getNodes));
			break;
		case 'deleteNode':
			$ret = array('msg'=>'','res'=>'');
			$rightInfo = "SELECT password FROM usuarios
						  WHERE idUsuario = $_POST[id]; -- ";
			$res = $mysql->query_assoc($rightInfo);
			if($res[0]['password'] == $_POST['pass']){
				$delete = "DELETE FROM dispositivos
						   WHERE idDispositivo = $_POST[nodeID]; -- ";
				$mysql->query($delete);
				$ret['msg'] = 'Successfuly deleted!';
				$ret['res'] = true;
				echo json_encode($ret);
			}
			else{
				$ret['msg'] = 'Incorrect password!';
				$ret['res'] = false;
				echo json_encode($ret);
			}
			break;
		case 'loadUsersTable':
			$getUsersInformation = "SELECT * FROM usuarios
									WHERE idUsuario != 1; -- ";
			echo json_encode($mysql->query_assoc($getUsersInformation));
			break;
		case 'deleteUser':
			$ret = array('msg'=>'','res'=>'');
			$rightInfo = "SELECT password FROM usuarios
						  WHERE idUsuario = 1; -- ";
			$res = $mysql->query_assoc($rightInfo);
			if($res[0]['password'] == $_POST['pass']){
				$delete = "DELETE FROM dispositivos
						   WHERE idDispositivo = $_POST[userID]; -- ";
				$mysql->query($delete);
				$ret['msg'] = 'Successfuly deleted!';
				$ret['res'] = true;
				echo json_encode($ret);
			}
			else{
				$ret['msg'] = 'Incorrect password!';
				$ret['res'] = false;
				echo json_encode($ret);
			}
			break;
		case 'loadAllNodes':
			$getAllNodes =
			"SELECT idDispositivo ID, nombre Name, serial SN, latitud Lat, longitud Longi, sensor Sens, 
			(SELECT U.nickname FROM Usuarios U
			WHERE U.idUsuario = D.idUsuario) AS Owner
			FROM dispositivos D
			INNER JOIN usuarios U
			ON U.idUsuario = D.idUsuario; -- ";
			echo json_encode($mysql->query_assoc($getAllNodes));
			break;
	}
 ?>