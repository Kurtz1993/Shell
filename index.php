

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
	session_start();

	echo var_dump($_SESSION['usuario']);
	//exit;

	if ((!isset($_SESSION["usuario"])) or (!isset($_SESSION["password"])) or ($_SESSION['id'] < 2)){
		include('login.html');
	}
	elseif((isset($_SESSION["usuario"])) and (isset($_SESSION["password"])) and ($_SESSION['id'] == 1)){
		include('loggedAdmin.php');
		include('backend/mysql.php');
		$mysql = new mysql();
		include('backend/switch.php');
	}
	else{
		include('logged.php');
		include('backend/mysql.php');
		$mysql = new mysql();
		include('backend/switch.php');
	}
		
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
		$('#startPage').css({
			color: '#FFFFFF',
			background: '#383838'
		});
	</script>
</body>
</html>