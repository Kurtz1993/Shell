<?php
session_start();

if ((!isset($_SESSION["usuario"])) or (!isset($_SESSION["password"])) or ($_SESSION['id'] < 2))
{
	echo "No has iniciado secion aun o esta no es tu cuenta";
	header("location:index.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SESION USUARIO</title>
<link rel="stylesheet" 
type="text/css" href="styleproyect.css" />
</head>

<body>
	<div class="div1">

		<div class="div4">
			<a href="destruir.php">Cerrar Sesion</a>
		</div>


		<div class="div2">
			<h2>USUARIO</h2>
		</div>


		<div class="div3">
			<form action="usuario.php" method="post">
				<fieldset>
					<legend>Agregar Usuario</legend>
						<p>
							Usuario: 
							<input type="text" name="usuario">
						</p>
						<p>
							Password: 
							<input type="text" name="password">
						</p>
				</fieldset>
			</form>
		</div>
	</div>

</body>
</html>