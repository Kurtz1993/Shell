<?php 
include('resources/mysql.php');

$mysql = new mysql();

$msg = array('msg' => "");

 if(isset($_POST['usr']) and isset($_POST['mail'])){

 	$msg = $mysql->RecuperarPass($_POST['mail'], $_POST['usr']);
	//$msg['msg']=$mysql->NewPass(5);

}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Shell Systems</title>
	<link rel="shortcut icon" href="img/favicon.ico">
	<link rel="stylesheet" href="resources/css/bootstrap.css">
	<link rel="stylesheet" href="resources/css/styles.css">
	<script src="resources/js/jquery.js"></script>
</head>
<body>
	<script>$(document).ready(function() {
		$('div#forgot').show(400);
	});</script>
	<?php include('login.html'); ?>
	<div class="loginForm" id="forgot">
		<div id="userInfo">Recover Password</div>
		<form action="registrado.php" method="post">
		<input type="text" name="usr" class="form-control" placeholder="Username" required>
		<input type="email" name="mail" class="form-control" placeholder="E-mail" required>
		<button type="submit" class="btn btn-primary">Send</button>
		</form>	
	</div>
	<?php echo $msg['msg'];?>
	<footer class="navbar navbar-inverse navbar-bottom">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand navbar-col">Shell Systems® 2013</a>
			</div>
			<div class="navbar-collapse collapse navbar-right">
		    	<a class="navbar-brand navbar-col" id="loggedUser">Welcome, Guest!</a>
			</div>
		</div>
	</footer>
</body>
</html>