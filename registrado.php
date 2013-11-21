<?php 
include('resources/mysql.php');

$mysql = new mysql();

$msg = array('msg' => "");

if(isset($_POST['mail'])){

$msg = $mysql->RecuperarPass($_POST['mail'], $_POST['usr']);
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>

	<form action="registrado.php" method="post" >
	usuario	<input type="text" name="usr">
	correo	<input type="text" name="mail">
	<input type="submit" value="enviar">
	</form>	

	<?php echo $msg['msg'];?>
</body>
</html>