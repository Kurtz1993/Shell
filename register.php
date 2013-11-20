<?php
	include('resources/mysql.php');
	$mysql = new mysql();
	
	$msg = array('msg' => "");
	$res = array('res' => "");

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
		<section class="panel-success webForm">
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
					<input type="text" placeholder="Register code" name="clave" class="form-control" required pattern="[A-Z0-9]{8}"
						   title="Please enter a valid serial number.">
				</div>
				<button type="submit" class="btn btn-primary" id="register">Register</button>
				<div id="resultMsg"><?php echo $msg['msg']; 
										  echo $res['res'];?></div>
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
	</section>
	<footer class="navbar navbar-inverse navbar-bottom">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand navbar-col" href="#">Shell Systems® 2013</a>
			</div>
		</div>
	</footer>
	<script> $('#registerPage').css({color: '#FFFFFF', background: '#383838'});	</script>
</body>
</html>