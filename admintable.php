<?php 
session_start(); 

if (!isset($_SESSION["usuario"]) && !isset($_SESSION["password"]) && !isset($_SESSION["id"])!=1)
{
  header("Location:lost.php");
  exit;
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link rel="shortcut icon" href="img/favicon.ico">
	<link rel="stylesheet" href="Resources/css/bootstrap.css">
	<link rel="stylesheet" href="resources/css/styles.css">
	<script src="Resources/js/jquery.js"></script>
	<script src="Resources/js/functions.js"></script>
	<script src="resources/js/adminScripts.js"></script>
	<title>Admin Tables</title>
</head>
<body>
	<?php include('logged.php'); ?>
	<div class="title">Users information</div>
	
	<div id="table" class="adminTable"></div>
	<div class="title">Nodes information</div>
	<div id="adminNodesTable" class="adminTable"></div>
	
	<!-- Confirm deletion form -->

	<div class="loginForm" class="panel-success">
    <div id="userInfo">Confirm delete</div>
    <form id="loginForm">
    	<input type="hidden" id="userID">
      	<input type="password" id="pswd" class="form-control" placeholder="Password" required autofocus>
      	<button type="submit" id="confirmBtn" class="btn btn-primary">Confirm</button>
    </form>
    <div id="notifier"></div>
    <a href="" id="dismissNotif">Dismiss</a>
  	</div>

  <!-- Footer -->

  	<footer class="navbar navbar-inverse navbar-bottom">
		<div class="container">
			<div class="navbar-header">
	            <a class="navbar-brand navbar-col">Shell Systems® 2013</a>
			</div>
			<div class="navbar-collapse collapse navbar-right">
  				<a class="navbar-brand navbar-col" id="loggedUser">Welcome, Master!</a>
			</div>
		</div>
	</footer>
	<script> $('#adminTablesPage').css({ color: '#FFFFFF', background: '#383838' }); </script>
</body>
</html>