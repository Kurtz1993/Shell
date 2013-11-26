<?php 
require('phpmailer.php');

class mysql{

var $dbCon;
	/* Datos de conexión a la base de datos remota:
	 * Host: 137.135.47.206
	 * User: root
	 * Pass: Lok'tar93
	 * DB: shell
	*/

	public function conect(){
		$this->dbCon = new mysqli('137.135.47.206', 'root', "Lok'tar93", 'shell');
		//$this->dbCon = new mysqli('localhost', 'root', '', 'shell');
		if(!$this->dbCon)
			echo $this->show_error();
	}

	public function query($consult){
		$query = $this->dbCon->query($consult);
		if(!$query){
			$this->show_error();
		}
		else{
			return $query;
		}
	}

	private function show_error(){
		return $this->dbCon->connect_error;
	}

	public function query_assoc($consult){
		$vec = array();
		if($result = $this->query($consult)){
			while($fila = $result->fetch_assoc()){ $vec[] = $fila; }
		}
		return $vec;
	}

	public function exit_conect(){
		mysqli_close($this->dbCon);
	}

	public function destroy(){
		session_destroy();
		header("Location: /shell");
	}


//funciones de manejo de datos

	public function validar($usuario, $password){
		
		$password = sha1($password);

		$consult = "SELECT * FROM usuarios WHERE nickname = '$usuario' and password = '$password'";    //asigno la sintaxis de la consulta a una variable	  
		$datos = $this->query_assoc($consult);
		if(count($datos)>0)   //verifico si el tamaño del vector es 0  (si es que existe un registro, siempre sera 0, ya que los registros no se repiten)
		{
	   	  $_SESSION['usuario'] = $usuario;  //asigno mis variables enviadas por el index, a las variables de sesion
	      $_SESSION['password'] = $password;
	      if(intval($datos[0]['idUsuario']) == 1){ 
	        $_SESSION['id'] = 1;
	        header('Location:index.php');  //redirecciono
	        exit;
	      }
	      else{ 
	        $_SESSION['id'] = $datos[0]['idUsuario'];
	        header('Location:index.php');  //redirecciono
	        exit;
	      }
	 	}
		else{
	       header('Location:index.php');   //redireccionox
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
		return $this->dbCon->insert_id;
	}

	public function registro($usuario, $password, $clave, $password2, $corporation, $email, $phone, $nocrypPass){ 
 		
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

					$res['res'] = $this->mail($email, $usuario, $nocrypPass);
					

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

	public function mail($emaildestino, $destinatario, $pass){

		$phpmailer = new PHPMailer();

		/*AQUI ESTABLECEMOS LAS CONFIGURACIONES DEL SERVIDOR SMTP*/
		$phpmailer->Mailer = 'smtp'; // Este dato establece que el correo será enviado via smtp
		$phpmailer->Host = 'ssl://smtp.gmail.com'; // Dirección del SMTP de GMAIL (Aqui puede ir alguna otra dirección de smtp)
		$phpmailer->Port = 465; //Puerto del SMT especificado anteriormente


		/*AQUI ESTABLECEMOS LOS DATOS DE QUIEN ENVIA EL CORREO*/
		$phpmailer->From = 'contacto.shell@gmail.com'; // Este valor debe ser el mismo que el "Username" que se especifica más adelante
		$phpmailer->FromName = 'Contacto SHELL';


		/*AQUI ESTABLECEMOS LOS DATOS DE ACCESO DEL USUARIO QUE ENVIARÁ EL CORREO*/
		$phpmailer->Username = 'contacto.shell@gmail.com'; //Correo electrónico del cual será enviado el correo (debe ser de gmail ya que el SMTP que se esta utilizando es de GMAIL)
		$phpmailer->Password = 'Torres20'; //Contraseña del correo electrónico anterior


		// Aqui va la dirección de correo al que se enviara el mensaje
		$phpmailer->AddAddress($emaildestino);
				
		$phpmailer->WordWrap = 50; // Largo de las lineas
		$phpmailer->IsHTML(true); // Podemos incluir tags html
		$phpmailer->Subject  =  'Correo registro';//AQUI VA EL ASUNTO;
		$phpmailer->Body ="<h2>Hola </h2>
								 <p>
								 	Le informamos que su registro ha sido completado correctamente.<br />
								 </p>
								 <p>
								 	<h3>Datos de acceso</h3>
								 	<div style=\"margin-top:8px;\">
										<strong>Tu Nickname: </strong>$destinatario
									</div>
									<div>
										<strong>Tu Password: </strong>$pass
									</div>
								 </p>";

		$phpmailer->Body = html_entity_decode(utf8_decode($phpmailer->Body)); //Codificamos el texto al formato html correcto
		$mail = $phpmailer->Send();

		if($mail){
			return array('result' => true,
  					     'msg' => "Se ha enviado un correo a: $emaildestino");
	 	}
	 	else{
			return array('result' => false,
 					     'msg' => 'Ocurrió problema inesperado en el envío del
 					      correo de verificación, por favor contacta al adminstrador.');
	 	}

	}

	public function NewPass($longitud) {
		 $key = '';
		 $pattern = '1234567890';
		 $max = strlen($pattern)-1;
		 for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		 return $key;
	}
 
	public function RecuperarPass($emaildestino, $destinatario){

		$this->conect();
		$consult = "SELECT idUsuario FROM usuarios WHERE nickname = '$destinatario' and correo = '$emaildestino'";
		$res = $this->query_assoc($consult);

		if(count($res) > 0){

			$newpass = $this->NewPass(20);

			$phpmailer = new PHPMailer();

			/*AQUI ESTABLECEMOS LAS CONFIGURACIONES DEL SERVIDOR SMTP*/
			$phpmailer->Mailer = 'smtp'; // Este dato establece que el correo será enviado via smtp
			$phpmailer->Host = 'ssl://smtp.gmail.com'; // Dirección del SMTP de GMAIL (Aqui puede ir alguna otra dirección de smtp)
			$phpmailer->Port = 465; //Puerto del SMT especificado anteriormente


			/*AQUI ESTABLECEMOS LOS DATOS DE QUIEN ENVIA EL CORREO*/
			$phpmailer->From = 'contacto.shell@gmail.com'; // Este valor debe ser el mismo que el "Username" que se especifica más adelante
			$phpmailer->FromName = 'Contacto SHELL';


			/*AQUI ESTABLECEMOS LOS DATOS DE ACCESO DEL USUARIO QUE ENVIARÁ EL CORREO*/
			$phpmailer->Username = 'contacto.shell@gmail.com'; //Correo electrónico del cual será enviado el correo (debe ser de gmail ya que el SMTP que se esta utilizando es de GMAIL)
			$phpmailer->Password = 'Torres20'; //Contraseña del correo electrónico anterior


			// Aqui va la dirección de correo al que se enviara el mensaje
			$phpmailer->AddAddress($emaildestino);
					
			$phpmailer->WordWrap = 50; // Largo de las lineas
			$phpmailer->IsHTML(true); // Podemos incluir tags html
			$phpmailer->Subject  =  'Recúperar password';//AQUI VA EL ASUNTO;
			$phpmailer->Body ="<h2>Hola </h2>
									 <p>
									 	Se ha solicitado la recuperación de contraseña para la cuenta de $destinatario<br />
									 	<br />
									 	Se ha generado una contraseña temporal con la cual puede accesar para reestablecer su contraseña<br />
									 <p>
										<div>
											<strong>Nueva contraseña: </strong>$newpass
										</div>	
									 </p>";

			$phpmailer->Body = html_entity_decode(utf8_decode($phpmailer->Body)); //Codificamos el texto al formato html correcto
			$mail = $phpmailer->Send();

			$id = intval($res[0]['idUsuario']);

			$newpass = sha1($newpass);

			$consult = "UPDATE usuarios SET password = '$newpass' WHERE idUsuario = $id";
			$this->query($consult);

			$this->exit_conect();

			if($mail){
				return array('result' => true,
	  					     'msg' => "Se ha enviado un correo a: $emaildestino");
		 	}
		 	else{
				return array('result' => false,
	 					     'msg' => 'Ocurrió problema inesperado en el envío del
	 					      correo de verificación, por favor contacta al adminstrador.');
		 	}

		 }

	}

}
?>