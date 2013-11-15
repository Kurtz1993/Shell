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
		<form action="" method="post" id="newUserForm">
			<div id="userData">
				<input type="text" placeholder="Username" class="form-control" required>
				<input type="text" placeholder="Corporation" class="form-control" required>
				<input type="email" placeholder="E-mail" class="form-control" required>
				<input type="text" placeholder="Phone Number" class="form-control" required pattern="[0-9]*$"
					   title="You must enter a valid phone number! (Just numbers)">
				<input type="password" placeholder="Password" class="form-control" required name="password" id="password">
				<input type="password" placeholder="Confirm Password" class="form-control" id="confpass"
					   onchange="validate(this);" required>
				<input type="text" placeholder="Device SN" class="form-control" required pattern="[A-Z0-9]{10}"
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
	$(document).ready(function(){
		$('#registerPage').css({
			color: '#FFFFFF',
			background: '#383838'
		});
	});
	</script>
</body>
</html>