<?php
include('mysql.php');

$mysql = new mysql();

$msg = array('msg' => "");

if(isset($_POST['usuario']) && isset($_POST['password']) && isset($_POST['clave'])){
	
	$mysql = new mysql();

	$mysql->conect();

	$usuario=$_POST['usuario'];
	$password=$_POST['password'];
	$clave=$_POST['clave']; 
	$password2=$_POST['password2']; 	

	$msg = $mysql->registro($usuario, $password, $clave, $password2);

	$mysql->exit_conect();
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AGREGAR</title>
<link rel="stylesheet" 
type="text/css" href="styleproyect.css" />
</head>
<body>

<div class="div1">


<div class="div2">

<h1>REGISTRO</h1>


</div>

<br />
<br />

<div class="div3">

<form action="registro.php"method="post">

Ususario: <input type="text" name="usuario"/>
<br/>
<br/>

Password:<input type="password" name="password"/>
<br/>
<br/>

Password:<input type="password" name="password2"/>
<br/>
<br/>

Clave:<input type="text" name="clave"/>
<br/>
<br/>

<input type="submit" value="Aceptar"/>

</form>

</div>
<?php
	if(isset($msg['result'])){
		echo $msg['msg'];
		if($msg['result']==true)
			echo'<meta http-equiv="refresh" content="2;URL=index.php"/> ';
	}
?>
</div>


</body>
</html>