<?php 
//require("class.phpmailer.php");

class mysql{

var $dbCon;

	public function __construct(){
		$this->dbCon = mysql_connect("137.135.47.206","root","Lok'tar93");

		if(!$this->dbCon)
			$this->show_error();
	}
	/* Datos de conexión a la base de datos remota:
	 * Host: 137.135.47.206
	 * User: root
	 * Pass: Lok'tar93
	 * DB: shell
	*/

	public function conect(){
		mysql_select_db("shell",$this->dbCon);
	}

	public function query($consult){
		$query = mysql_query($consult, $this->dbCon);
		if(!$query){
			$this->show_error();
		}
		else{
			return $query;
		}
	}

	private function show_error(){
		die("ERROR: ".mysql_error());
	}

	public function query_assoc($consult){
		$result = $this->query($consult);
		$vec = array();
		while($fila = mysql_fetch_assoc($result)){
			$vec[] = $fila;
			//echo var_dump($vec);
			//exit;
		}
		return $vec;
	}

	public function exit_conect(){
		mysql_close($this->dbCon);
	}

	public function destroy(){
		session_destroy();
		header("location:index.php");
	}


//funciones de manejo de datos

	public function validar($usuario, $password){
		$consult = "SELECT * FROM usuarios WHERE nickname = '$usuario' and password = '$password'";    //asigno la sintaxis de la consulta a una variable	  
		$datos = $this->query_assoc($consult);
		if(count($datos)>0)   //verifico si el tamaño del vector es 0  (si es que existe un registro, siempre sera 0, ya que los registros no se repiten)
		{
	   	  $_SESSION['usuario'] = $usuario;  //asigno mis variables enviadas por el index, a las variables de sesion
	      $_SESSION['password'] = $password;
	      
	      if(intval($datos[0]['idUsuario'])== 1){ 
	        $_SESSION['id'] = 1;
	        header('location:../admin.php');  //redirecciono
	        exit;
	      }
	      else{ 
	        $_SESSION['id'] = 2;
	        header('location:../table.php');  //redirecciono
	        exit;
	      }
	 	}
		else{
	       header('location:../index.php');   //redireccionox
	       exit;
	 	}
	}

	public function insert_clave($valor){
		$consult = "SELECT clave FROM usuarios WHERE clave = '$valor'";
		$datos = $this->query_assoc($consult); //guardo en un vector los resultados de la consulta

		if($datos != false){
			return array(
				'result' => false,
				'msg' => 'la clave ya existe, intente con otra diferente por favor'
				);
		}
		else{
			$insertar="INSERT INTO usuarios (clave) values ('$valor')";
			$this->query($insertar); 
			return array(
				'result' => true,
				'msg' => 'clave correcta y almacenanda, ya puede utilizarse'
				);
		}
	}

	public function get_usuarios(){
		$consult = "SELECT * FROM usuarios";
		return $this->query_assoc($consult);
	}

	public function obtenerId(){
		return mysql_insert_id();
	}

	public function registro($usuario, $password, $clave, $password2, $corporation, $email, $phone){ 
 		$consult = "SELECT nickname FROM usuarios WHERE nickname = '$usuario'";
 		$result = $this->query_assoc($consult);
 		

		if (count($result) > 0 ){	  
			return array('result' => false,
						 'msg' => 'Ese usuario ya ha sido registrado, 
						  porfavor intente con uno diferente');    
		}
		else{	
			if($password == $password2){		//reviso que las 2 passwords seleccionas por el usuario, sean iguales
				$consult = "SELECT clave, idUsuario FROM usuarios WHERE clave = '$clave'";		//consulta pa saber si existe la clave ingresada por el usuario
				$result = $this->query_assoc($consult);

				if(count($result) > 0){
					$id = intval($result[0]['idUsuario']);
					$consult="UPDATE usuarios SET nickname = '$usuario', 
												  password = '$password',
												  corporation = '$corporation',
												  tel = '$phone',
												  correo = '$email'
												  WHERE idUsuario = $id";
					$this->query($consult);

					return array('result' => true,
								 'msg' => 'Su registro se ha completado satisfactoriamente'); 
					echo'<meta http-equiv="refresh" content="2;URL=index.php"/> ';  
				}
				else{
					return array('result' => true,
								 'msg' => 'Su clave de registro es incorrecta o no existe, verifique que sea la correcta,
								 o pongase en contacto con su administrador'); 
				}
			}
			else{
				return array('result' => false,
							 'msg' => 'Ambas contraseñas deben coincidir');
			}
		}
	}

	// private function mail($Emaildestino, $destinatario){

	// 	$mail = new PHPmailer();

	// 	//Inicio de la validación por SMTP:
	// 	$mail->IsSMTP();
	// 	$mail->SMTPAuth = true;
	// 	$mail->Host = "smtp.gmail.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
	// 	$mail->Username = "contacto.shell@gmail.com"; // Correo completo a utilizar
	// 	$mail->Password = "Torres20"; // Contraseña
	// 	$mail->Port = 465; // Puerto a utilizar

	// 	//Con estas pocas líneas iniciamos una conexión con el SMTP. Lo que ahora deberíamos hacer, es configurar el mensaje a enviar, el //From, etc.
	// 	$mail->From = "contacto.shell@gmail.com"; // Desde donde enviamos (Para mostrar)
	// 	$mail->FromName = "ContactoShell";

	// 	//Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>”) de //correo.
	// 	$mail->AddAddress($Emaildestino); // Esta es la dirección a donde enviamos
	// 	$mail->IsHTML(true); // El correo se envía como HTML
	// 	$mail->Subject = "Correo Activacion"; // Este es el titulo del email.
	// 	$body = "Hola $destinatario<br/> <br/>";
	// 	$body .= "<strong>Para completar tu registro ve al siguiente link</strong> <br/> <br/>";
	// 	$mail->Body = $body; // Mensaje a enviar
	// 	$exito = $mail->Send(); // Envía el correo.

	// 	//También podríamos agregar simples verificaciones para saber si se envió:
	// 	if($exito){
	// 		return array('result' => true,
	// 					 'msg' => 'Se ha enviado un correo de verificcion a $Emaildestino');
	// 	}else{
	// 		return array('result' => false,
	// 					 'msg' => 'Se dio un problema inesperado en el elnvio del
	// 					  correo de verificacion, por favor contacta al adminstrador');
	// 	}
	// }
}
?>