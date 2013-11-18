<?php
include('mysql.php');
session_start();

$mysql = new mysql();

//comprobar correcto login ------------------------------------------------------------------------------------
if ((!isset($_SESSION["usuario"])) or (!isset($_SESSION["password"])) or ($_SESSION['id'] != 1))
{
	echo "No has iniciado sesión aún o esta no es tu cuenta.";
	header("location:perdido.php");
	exit;
}

//cerrar sesion -----------------------------------------------------------------------------------------------
if (isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'destroy':
			$mysql->destroy();
			header('location:index.php');
			break;
	}
}

//manupular clave ----------------------------------------------------------------------------------------------
$mysql = new mysql();
$mysql->conect();

$msg = array('msg' => "");

if(isset($_POST['textbox'])){

	$valor = $_POST['textbox'];
	$msg = $mysql->insert_clave($valor);
	
}
// $mysql->exit_conect()   //cierro la coneccion
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SESION ADMINISTRADOR</title>
<link rel="stylesheet" 
type="text/css" href="styleproyect.css" />

<!-- <script type="text/javascript" src="jquery.js"></script> -->
<script type="text/javascript" src="script.js"></script>

</head>
	<body>
		<div class="div1">
			<div class="div4">
				<a href="admin.php?action=destroy">Cerrar Sesion</a>
			</div>
			<div class="div2">
				<h1>ADMINISTRADOR</h1>
				<br />
				<br />
				<form action="admin.php" method="post" name="form1">
					Generar codigo<input type="text" class="txt" name="textbox"/>
					<input type="button" value="generar codigo" onclick="clave();"/>
					<input type="submit" value="guardar clave" />
					<br />
					<br />
					<?php
					echo $msg['msg'];
					?>
				</form>
			</div>
			<br />
			<br />
			<div class="div3">
			<table border="1" width="100%" cellpadding="5" class="table">
					<th>Id</th>
					<th>NickName</th>
					<th>Password</th>
					<th>clave</th>
					<?php 
						$tabla = $mysql->get_usuarios();
						foreach ($tabla as $key => $value) {
							echo '<tr class="row">
								<td>'.$value['id'].'</td>
								<td>'.$value['nickname'].'</td>
								<td>'.$value['password'].'</td>
								<td>'.$value['clave'].'</td>
								</tr>';					
						}
						$mysql->exit_conect();
					?>
			</div>
		</div>
	</body>
</html>

