<?php
session_start();
if ((!isset($_SESSION["usuario"])) or (!isset($_SESSION["password"])) or ($_SESSION['id'] < 2))
{
	header("location:index.php");
}
?>

<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Shell-System</title>
	<link rel="shortcut icon" href="img/favicon.ico">
	<link rel="stylesheet" href="Resources/css/bootstrap.css">
	<link rel="stylesheet" href="Resources/css/styles.css">
	<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBSzrc6U_85i4yf8a41AfHpaCqF4K4kEAU&sensor=false">
    </script>
	<script src="Resources/js/jquery.js"></script>
	<script src="Resources/js/functions.js"></script>
	<script src="Resources/js/userScripts.js"></script>
	<script src="Resources/js/bootstrap.js"></script>
	<script src="resources/js/amcharts.js"></script>
	<script src="resources/js/serial.js"></script>
</head>
<body>
	<?php
	if ((isset($_SESSION["usuario"])) and (isset($_SESSION["password"])) and ($_SESSION['id'] > 1)){
		include('logged.php');
		include('resources/mysql.php');
		$mysql = new mysql();
		include('resources/switch.php');
	}
	else{
		include('login.html');
	}	
	?>

	<div id="nodes"><!-- Fill with all the nodes that the user has --></div>
	<div id="map"><!-- Fill with device location --></div>
	<div id="stadistics"><!-- Fill with stadistic data --></div>
	<div id="tableData"><!-- Fill with the device data --></div>




	<footer class="navbar navbar-inverse navbar-bottom">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand navbar-col">Shell Systems® 2013</a>
			</div>
			<div class="navbar-collapse collapse navbar-right">
				<?php if($_SESSION['id'] == 1): ?>
  				<a class="navbar-brand navbar-col" id="loggedUser">Welcome, Master!</a>
		        <?php else: ?>
		        <a class="navbar-brand navbar-col" id="loggedUser">Welcome, <?php echo $_SESSION['usuario']; ?>!</a>
         		<?php endif; ?>
			</div>
		</div>
	</footer>
	<script> $('#nodesPage').css({color: '#FFFFFF',	background: '#383838'}); </script>
</body>
</html>