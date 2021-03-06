<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Shell Systems</title>
	<link rel="stylesheet" href="Resources/css/bootstrap.css">
	<link rel="shortcut icon" href="img/favicon.ico">
	<script src="Resources/js/jquery.js"></script>
	<script type="text/javascript" src="Resources/js/bootstrap.js"></script>
	<link rel="stylesheet" href="Resources/css/styles.css">
</head>
<body>
	<?php
		session_start();
		if (isset($_SESSION["usuario"]) && isset($_SESSION["password"]))
		{
			include('logged.php');
			include('resources/mysql.php');
			$mysql = new mysql();
			include('resources/switch.php');
		}
		else{
			include('login.html');
		}	
	?>
	<section id="content">
		<center><img src="img/shell.png" id="shellLogo"></center>
	</section>
	<footer class="navbar navbar-inverse navbar-bottom">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand navbar-col">Shell Systems® 2013</a>
			</div>
			<div class="navbar-collapse collapse navbar-right">
				<?php if(!$_SESSION): ?>
				<a class="navbar-brand navbar-col" id="loggedUser">Welcome, Guest!</a>
				<?php elseif($_SESSION['id'] == 1): ?>
  				<a class="navbar-brand navbar-col" id="loggedUser">Welcome, Master!</a>
		        <?php else: ?>
		        <a class="navbar-brand navbar-col" id="loggedUser">Welcome, <?php echo $_SESSION['usuario']; ?>!</a>
		        <?php endif; ?>
			</div>
		</div>
	</footer>
	<script> $('#startPage').css({ color: '#FFFFFF', background: '#383838' }); </script>
</body>
</html>