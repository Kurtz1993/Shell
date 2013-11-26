<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Shell Systems</title>
	<link rel="stylesheet" href="Resources/css/bootstrap.css">
	<link rel="shortcut icon" href="img/favicon.ico">
	<script src="Resources/js/jquery.js"></script>
	<script src="Resources/js/bootstrap.js"></script>
	<script src="resources/js/holder.js"></script>
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
	<section id="content" class="carousel slide">        
           <ol class="carousel-indicators">
                <li data-target="#content" data-slide-to="0" class="active"></li>
                <li data-target="#content" data-slide-to="1" ></li>
                <li data-target="#content" data-slide-to="2" ></li>
           </ol>

           <div class="carousel-inner">
                <div class="item active">
                    <img src="img/background.jpg" class="adaptar">
                </div>
                <div class="item">
                    <img src="img/background.jpg" class="adaptar">
                </div>
                <div class="item">
                    <img src="img/background.jpg" class="adaptar">
                </div>
           </div>
           <a href="#content" class="left carousel-control" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
           <a href="#content" class="right carousel-control" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
       </section>
	<footer class="navbar navbar-inverse navbar-bottom">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand navbar-col" href="#">Shell Systems® 2013</a>
			</div>
			<div class="navbar-collapse collapse navbar-right">
				<?php if(!$_SESSION): ?>
				<a class="navbar-brand navbar-col" id="loggedUser">Welcome, Guest!</a>
				<?php elseif($_SESSION['id'] == 1): ?>
  				<a href= "admin.php" class="navbar-brand navbar-col" id="loggedUser">Welcome, Master!</a>
		        <?php else: ?>
		        <a href= "user.php" class="navbar-brand navbar-col" id="loggedUser">Welcome, <?php echo $_SESSION['usuario']; ?>!</a>
		        <?php endif; ?>
			</div>
		</div>
	</footer>
	<script> $('#startPage').css({ color: '#FFFFFF', background: '#383838' }); </script>
</body>
</html>