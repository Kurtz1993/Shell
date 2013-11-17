<?php
include('backend/mysql.php');

$mysql = new mysql();

$msg = array('msg' => "");

if(isset($_POST['username']) && isset($_POST['password']) 
	&& isset($_POST['password2']) && isset($_POST['clave'])
	&& isset($_POST['corporation']) && isset($_POST['email'])
	&& isset($_POST['phone'])){
	
	$mysql = new mysql();

	$mysql->conect();	

	$msg = $mysql->registro($_POST['username'], $_POST['password'], 
							$_POST['clave'], $_POST['password2'],
							$_POST['corporation'], $_POST['email'],
							$_POST['phone']);

	$mysql->exit_conect();
}


?>

<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Shell System</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="stylesheet" href="Resources/css/bootstrap.css">
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
	<!-- <center><IMG SRC="img/shell.png" WIDTH="178" HEIGHT="180"></center> -->
	<section id="registerForm" class="panel-success">
		<h2 class="panel-heading">Registration</h2>
		<form action="register.php" method="post" id="newUserForm">
			<div id="userData">
				<input type="text" placeholder="Username" name="username" class="form-control" required>
				<input type="text" placeholder="Corporation" name="corporation" class="form-control" required>
				<input type="email" placeholder="E-mail" name="email" class="form-control" required>
				<input type="text" placeholder="Phone Number" name="phone" class="form-control" required pattern="[0-9]*$"
					   title="You must enter a valid phone number! (Just numbers)">
				<input type="password" placeholder="Password" class="form-control" required name="password" id="password">
				<input type="password" placeholder="Confirm Password" name="password2" class="form-control" id="confpass"
					   onchange="validate(this);" required>
				<input type="text" placeholder="Register code" name="clave" class="form-control" required pattern="[A-Z0-9]{10}"
					   title="Please enter a valid serial number." name="serial">
			</div>
			<button type="submit" class="btn btn-primary" id="register">Register</button>
		</form>
		<script>
			function validate(input){
				if(input.value != $('#password').val()){
					input.setCustomValidity('Passwords do not match!');
					$('#password').css('border', '1px solid red');
					$('#confpass').css('border', '1px solid red');
				} else{
					input.setCustomValidity('');
					$('#password').css('border', '1px solid green');
					$('#confpass').css('border', '1px solid green');
				}
			}
		</script>
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
		$('#registerPage').css({
			color: '#FFFFFF',
			background: '#383838'
		});
	</script>
</body>
</html>