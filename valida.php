<?php
	include('resources/mysql.php');
	session_start();
	$mysql = new mysql();
	$mysql->conect();
	if (trim($_POST['usuario'])=='' or trim($_POST['password'])=='')	//Se revisa si los campos no están vacíos.
	{	
		exit('ERROR: Por favor verifique que ambos campos estén llenos<br /> <meta http-equiv="refresh" content="2;URL=index.php"/>');
	}
	else{
	  $usuario = $_POST['usuario'];
	  $password = $_POST['password'];
	  $mysql->validar($usuario, $password);
	}
	$mysql->exit_conect();   //Cierre de conexión.
?>