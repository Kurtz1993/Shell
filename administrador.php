<?php
include('backend/mysql.php');
session_start();


$mysql = new mysql();

//comprobar correcto login ------------------------------------------------------------------------------------

if ((!isset($_SESSION["usuario"])) or (!isset($_SESSION["password"])) or ($_SESSION['id'] != 1))
{
	echo "No has iniciado secion aun o esta no es tu cuenta";
	header("location:backend/perdido.php");
	exit;
}

//cerrar sesion -----------------------------------------------------------------------------------------------
include('backend/switch.php');


//manupular clave ----------------------------------------------------------------------------------------------
$mysql->conect();

$msg = array('msg' => "");

if(isset($_POST['textbox'])){

	$valor = $_POST['textbox'];
	$msg = $mysql->insert_clave($valor);
	
}

 $mysql->exit_conect()   //cierro la coneccion
?>



<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Shell-System</title>
	<style type="text/css">
		body { padding-top: 60px; padding-bottom: 40px; }
	</style>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="stylesheet" href="Resources/css/bootstrap.css">
	<script type="text/javascript" src="Resources/js/bootstrap.js"></script>
	<script src="Resources/js/jquery.js"></script>
	<script type="text/javascript" src="backend/script.js"></script>
<!-- placeholder="Codigo Generado" -->
</head>

<body>

	<nav class="navbar navbar-fixed-top">
		<nav class="navbar">
			<nav class="navbar-inner">
				<nav class="container" style="width: auto;">
					<a class="brand" href="#">SHELL</a>
					<nav class="nav-collapse">
						<ul class="nav">
							<li><a href="index.php">Inicio</a></li>
						</ul>
					</nav>
					<a href="administrador.php?action=destroy">Cerrar Sesion</a>
					<!-- <form class="navbar-form pull-right" action="">
						<input type="text" class="span2" placeholder="Usuario" autofocus required>
						<input type="password" class="span2" placeholder="Contraseña" required>
						<button type="submit" class="btn btn-primary">Log In</button>
					</form> -->
				</nav>
			</nav>
		</nav>
	</nav>
	
	<br><br><br><br><br><br><br>

	<section>
		<nav class="container">
			<nav class="navbar-inner">
				<nav class="container" style="width: auto;">
					<form class="navbar-form" action="administrador.php" name="form1">
						<center><h1>Generar Codigo</h1><br>
						<input type="text" name="textbox" class="span5" placeholder="Codigo Generado" autofocus/>
						<input type="button" class="btn btn-primary" onclick"clave();" value="Generar clave" />
						<!-- <button class="btn btn-primary" onclick="clave();">Generar Clave</button></center> --><br>
						<input type="submit" value="Guardar Clave" />
						<br />
						<br />
						<?php
						echo $msg['msg'];
						?>
					</form>
				</nav>
			</nav>
		</nav>
	</section>

	<footer class="navbar navbar-fixed-bottom">
		<center>
			<ul class="breadcrumb">
				<li>
					<a href="#">Terminos & Condiciones</a> <span class="divider">|</span>
				</li>
				<li>
					<a href="#">Ayuda</a> <span class="divider">|</span>
				</li>
				<li>
					<a href="#">Porno</a>
				</li>
			</ul>
		</center>
	</footer>

</body>
</html>