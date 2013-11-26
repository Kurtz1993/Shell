<?php
	include('resources/mysql.php');

	session_start();
	
	$mysql = new mysql();
	
	$mysql->conect();
  	
  	$usuario = $_POST['usuario'];
  	$password = $_POST['password'];
  	
  	$mysql->validar($usuario, $password);
  	$mysql->exit_conect();   //Cierre de conexión.
?>