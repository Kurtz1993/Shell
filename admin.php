<?php 
include('resources/mysql.php');
session_start();
$mysql = new mysql();
//comprobar correcto login ------------------------------------------------------------------------------------
if ((!isset($_SESSION["usuario"])) or (!isset($_SESSION["password"])) or ($_SESSION['id'] != 1))
{
	header("Location:perdido.php");
	exit;
}
//cerrar sesion -----------------------------------------------------------------------------------------------
include('resources/switch.php');
//manipular clave ----------------------------------------------------------------------------------------------
$mysql->conect();
$msg = array('msg' => "");
if(isset($_POST['code'])){

	$valor = $_POST['code'];
	$msg = $mysql->insert_clave($valor);
	
}
$mysql->exit_conect();   //cierro la coneccion 
?>

<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Shell-System</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="stylesheet" href="Resources/css/bootstrap.css">
	<link rel="stylesheet" href="Resources/css/styles.css">
	<script src="Resources/js/jquery.js"></script>
	<script src="Resources/js/functions.js"></script>
</head>
<body>
	<?php include('logged.php'); ?>
	<section class="panel-success webForm">
		<h2 class="panel-heading">Administrador</h2>
		<form action="admin.php" method="post" name="codeGen">
			<div id="adminPanel">
				Generar código: <input id="code" type="text" class="form-control-static" name="code"><br><br>
				<input type="button" value="Generar código" onclick="Clave();">
				<input type="submit" value="Guardar clave">
				<div id="resultMsg">
					<?php if(isset($msg)) echo $msg['msg'];	?>
				</div>
			</div>
	</section>
	<section id="usersTable">
		<table>
			<tr>
				<td></td>
			</tr>
		</table>
	</section>
	<footer class="navbar navbar-inverse navbar-bottom">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand navbar-col" href="#">Shell Systems® 2013</a>
			</div>
		</div>
	</footer>
	<script> $('#adminPage').css({ color: '#FFFFFF', background: '#383838' }); </script>
</body>
</html>