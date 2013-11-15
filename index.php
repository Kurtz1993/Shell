<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Shell Systems</title>
	<link rel="stylesheet" href="Resources/css/bootstrap.css">
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<script src="Resources/js/jquery.js"></script>
	<script type="text/javascript" src="Resources/js/bootstrap.js"></script>
	<link rel="stylesheet" href="Resources/css/styles.css">
</head>
<body>
	<?php 
		//Aquí va la validación dependiendo de si está loggeado o no el usuario... aquí pondrás tu condición.
		include('login.html');
		//include('logged.php');
	?>
	<center><img src="img/shell.png"></center>
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
		$(document).ready(function(){
			$('#startPage').css({
				color: '#FFFFFF',
				background: '#383838'
			});
		});
	</script>
</body>
</html>