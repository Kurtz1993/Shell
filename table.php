<?php
session_start();
if ((!isset($_SESSION["usuario"])) or (!isset($_SESSION["password"])) or ($_SESSION['id'] < 2))
{
	echo "No has iniciado secion aun o esta no es tu cuenta";
	header("location:index.php");
}
?>

<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Shell-System</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="stylesheet" href="Resources/css/bootstrap.css">
	<script src="Resources/js/jquery.js"></script>
	<script type="text/javascript" src="Resources/js/bootstrap.js"></script>
</head>
<body>
	<?php
	if ((isset($_SESSION["usuario"])) and (isset($_SESSION["password"])) and ($_SESSION['id'] > 1)){
		include('logged.php');
		include('backend/mysql.php');
		$mysql = new mysql();
		include('backend/switch.php');
	}
	elseif((isset($_SESSION["usuario"])) and (isset($_SESSION["password"])) and ($_SESSION['id'] == 1)){
		include('loggedAdmin.php');
		include('backend/mysql.php');
		$mysql = new mysql();
		include('backend/switch.php');
	}
	else{
		include('login.html');
	}	
	?>

	<section>
		<nav class="container">
			<nav class="navbar-inner">
				<nav class="container" style="width: auto;">

					<fieldset class="scheduler-border">
						<br>
						<legend class="scheduler-border">Filtros</legend>
							<center>
								Fecha: <input rel="tooltip" title="Fecha de nacimiento" class="span3" type="date" required>
								<span class="divider">/</span>
								<span class="divider">/</span>
								<input type="checkbox" name="Temperatura"> Temperatura
								<input type="checkbox" name="Humedad"> Humedad
								<span class="divider">/</span>
								<span class="divider">/</span>
						        <input type="radio" name="nodos" value="Nodo1"> Nodo 1 
						        <input type="radio" name="nodos" value="Nodo2"> Nodo 2 
						        <input type="radio" name="nodos" value="Nodo3"> Nodo 3 
								<button class="btn btn-primary">Filtrar</button></center><br>
							</center>
					</fieldset>

					<table border="3" align="center">
						<thead>
							<td class="span3" align="center">Fecha</td>
							<td class="span3" align="center">Temperatura</td>
							<td class="span3" align="center">Humedad</td>
						</thead>

						<tbody>
							<td class="span3" align="center">13/08/13</td>
							<td class="span3" align="center">11</td>
							<td class="span3" align="center">13</td>
						</tbody>
					</table>
					<br>
				</nav>
			</nav>
		</nav>
	</section>
	
	<footer class="navbar navbar-inverse navbar-bottom">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand navbar-col" href="#">Terms and Conditions</a>
				<a class="navbar-brand navbar-col" href="#">Help</a>
				<a class="navbar-brand navbar-col" href="#">Porn</a>
			</div>
		</div>
	</footer>
	<script>
		$('#nodesPage').css({
			color: '#FFFFFF',
			background: '#383838'
		});
	</script>
</body>
</html>