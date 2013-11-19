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
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="stylesheet" href="Resources/css/bootstrap.css">
	<link rel="stylesheet" href="Resources/css/styles.css">
	<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBSzrc6U_85i4yf8a41AfHpaCqF4K4kEAU&sensor=false">
    </script>
	<script src="Resources/js/jquery.js"></script>
	<script src="Resources/js/functions.js"></script>
	<script src="Resources/js/scripts.js"></script>
	<script type="text/javascript" src="Resources/js/bootstrap.js"></script>
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

	<div id="nodes">
		<script>
			$.ajax({
				url: 'resources/requests.php',
				type: 'post',
				data: {action: "loadRadios"},
				dataType: 'JSON',
				success: function(radio){
					var template = '<input type="radio" class="rad" name="nodes[]" value="';
					var radiobuttons = "";
					for(i=0; i < radio.length; i++){
						radiobuttons += template + radio[i].idDispositivo+'" id="rad'+radio[i].idDispositivo+'"> ' +
						'<span class="radText">' + radio[i].nombre+ "</span>"+" ";
				}
				$('div#nodes').html(radiobuttons);
			}
			});
		</script>
	</div>
	<div id="map"></div>
	<div id="tableData"><!-- Fill with the device data --></div>
	<footer class="navbar navbar-inverse navbar-bottom">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand navbar-col" href="#">Shell Systems® 2013</a>
			</div>
		</div>
	</footer>
	<script> $('#nodesPage').css({color: '#FFFFFF',	background: '#383838'}); </script>
</body>
</html>