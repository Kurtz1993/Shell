<?php 
	session_start();
	require('mysql.php');
	$mysql = new mysql();
	$mysql->conect();
	$action = $_POST['action'];
	switch($action){
		case 'loadMap':
			$getDevicesLocation = 
			"SELECT * FROM dispositivos; -- ";
			echo json_encode($mysql->query_assoc($getDevicesLocation));
			break;

		case 'loadDeviceData':
			$getDeviceData =
			"SELECT lectura, diaLectura FROM data WHERE idDispositivo = $_POST[id] ORDER BY diaLectura; -- ";
			echo json_encode($mysql->query_assoc($getDeviceData));
			break;

		case 'loadDeviceTable':
			$getAllRegistries =
			"SELECT Da.ID, Di.nombre Nombre, Da.lectura, Da.horaLectura Hora, Da.diaLectura Dia 
			FROM data Da 
			INNER JOIN dispositivos Di
			ON Di.idDispositivo = Da.idDispositivo
			WHERE Da.idDispositivo = $_POST[id]
			ORDER BY Da.diaLectura AND Da.horaLectura; -- ";
			echo json_encode($mysql->query_assoc($getAllRegistries));
			break;

		case 'loadTablePage':
			$getPage=
			"SELECT Da.ID, Di.nombre Nombre, Da.lectura, Da.horaLectura Hora, Da.diaLectura Dia 
			FROM data Da 
			INNER JOIN dispositivos Di
			ON Di.idDispositivo = Da.idDispositivo
			WHERE Da.idDispositivo = $_POST[id]
			ORDER BY Da.diaLectura AND Da.horaLectura
			LIMIT $_POST[page], 100; -- ";
			echo json_encode($mysql->query_assoc($getPage));
			break;

		case 'totalDeviceData':
			$getData =
			"SELECT COUNT(*) total FROM data WHERE idDispositivo = $_POST[id]; -- ";
			echo json_encode($mysql->query_assoc($getData));
			break;

		case 'loadUserInfo':
			$getUserData = "SELECT corporation, tel, correo
							FROM usuarios
							WHERE idUsuario = $_POST[id]; -- ";
			
			echo json_encode($mysql->query_assoc($getUserData));
			break;

		case 'deleteNode':
			$ret = array('msg'=>'','res'=>'');
			$rightInfo = "SELECT password FROM usuarios
						  WHERE idUsuario = $_POST[id]; -- ";
			$res = $mysql->query_assoc($rightInfo);
			if($res[0]['password'] == sha1($_POST['pass'])){
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
			"SELECT idDispositivo ID, nombre Name, SN SN, latitud Lat, longitud Longi, sensor Sens, 
			(SELECT U.nickname FROM Usuarios U
			WHERE U.idUsuario = D.idUsuario) AS Owner
			FROM dispositivos D
			INNER JOIN usuarios U
			ON U.idUsuario = D.idUsuario; -- ";
			echo json_encode($mysql->query_assoc($getAllNodes));
			break;

		case 'editUserInfo':
			$updateUserInfo =
			"UPDATE Usuarios
			 SET corporation = '$_POST[corp]', tel = '$_POST[phone]', correo='$_POST[email]'
			 WHERE idUsuario = $_POST[id]; -- ";
			 $res = $mysql->query($updateUserInfo);
			break;

		case 'editUserPassword':
			$password = sha1($_POST['pass']);
			$updatePassword = 
			"UPDATE Usuarios
			 SET password = '$password'
			 WHERE idUsuario = $_POST[id]; -- ";
			 $res = $mysql->query($updatePassword);
			 break;

		case 'newNode':
			$aux = array('response'=>'');
			$lookForSN = "SELECT idDispositivo, sensor 
						  FROM dispositivos
						  WHERE SN = '$_POST[sn]'; -- ";
			$res = $mysql->query_assoc($lookForSN);
			if(sizeof($res)>0){
				$sensor = $res[0]['sensor'];
				$DeviceID = $res[0]['idDispositivo'];
				$addNewDevice=
				"UPDATE dispositivos 
				SET nombre ='$_POST[name]', latitud = $_POST[lat], longitud = $_POST[lon], sensor = $sensor, idUsuario = $_POST[uid]
				WHERE idDispositivo = $DeviceID; -- ";
				$mysql->query($addNewDevice);	
				$aux['response']=true;
				echo json_encode($aux);
			}
			else{
				$aux['response']=false;
				echo json_encode($aux);
			}
			break;

		case 'loadNodeData':
			$getDeviceData =
			"SELECT Da.ID, Da.lectura valor, Da.horaLectura, Da.diaLectura day, Di.sensor
			 FROM data Da
			 RIGHT JOIN dispositivos Di
			 ON Di.idDispositivo = Da.idDispositivo
			 WHERE Da.idDispositivo = $_POST[id]; -- ";
			 echo json_encode($mysql->query_assoc($getDeviceData));
			break;

		case 'loadGraph':
				$getProm =
				"SELECT ROUND(AVG(lectura),2) Promedio, DAY(diaLectura) Dia
				FROM data
				WHERE idDispositivo = $_POST[id]
				GROUP BY DAY(diaLectura); -- ";
				echo json_encode($mysql->query_assoc($getProm));
				break;
	}
 ?>