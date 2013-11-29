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
	<script src="Resources/js/nodeScripts.js"></script>
	<script src="resources/js/amcharts/amcharts.js"></script>
	<script src="resources/js/amcharts/serial.js"></script>
	<script src="resources/js/amcharts/xy.js"></script>
	<!-- <script src="resources/js/amcharts/gauge.js"></script>
	<script src="resources/js/amcharts/pie.js"></script>
	<script src="resources/js/amcharts/radar.js"></script>
	<script src="resources/js/amcharts/funnel.js"></script> -->
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
	<input type="hidden" id="deviceID">
	<input type="hidden" id="userID" value="<?php echo $_SESSION['id']; ?>">
	<div class="title">Click a device on the map to display information</div>
	<div id="map"><!-- Fill with map --></div>
	<div id="readChart"><!-- Fill with device's lectures -->
		<center><img src="img/shell.png" id="shellLogo"></center>
	</div>
	<div id="table">
		<div id="pagination"></div>
		<div id="deviceTable"><!-- Fill with all data --></div>
	</div>

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