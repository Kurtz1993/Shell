<?PHP
include('mysql.php');

session_start();

$mysql = new mysql();

$mysql->conect();


if (trim($_POST['usuario'])=='' or trim($_POST['password'])=='')	//reviso si los espacios de loging y pass estan vacios
{	
	exit('ERROR: Por favor verifique que ambos campos estén llenos<br /> <meta http-equiv="refresh" content="2;URL=index.php"/>');
}
else{

  $usuario = $_POST['usuario'];
  $password = $_POST['password'];

  $mysql->validar($usuario, $password);

}

$mysql->exit_conect();   //cierro la coneccion
?>