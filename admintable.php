<?php 
include('Resources/mysql.php');
session_start();

$mysql = new mysql();

include('resources/switch.php');



?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<script src="Resources/js/jquery.js"></script>
	<script src="Resources/js/functions.js"></script>
	<title>Document</title>
</head>
<body>
	<div id="table">
	</div>

</body>
</html>