<?php 

class mysql{

var $dbCon;

	public function __construct(){
		$this->dbCon = mysql_connect("127.0.0.1","root","");
	}
//$link = mysql_connect("ip de localhost","usuario","password");
//mysql_select_db("nombre de base de datos",$link);

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
	      
	      if(intval($datos[0]['id'])== 1){ 
	        $_SESSION['id'] = 1;
	        header('location:admin.php');  //redirecciono
	        exit;
	      }
	      else{ 
	        $_SESSION['id'] = 2;
	        header('location:usuario.php');  //redirecciono
	        exit;
	      }
	 	}
		else{
	       header('location:index.php');   //redireccionox
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

	public function registro($usuario, $password, $clave, $password2){ 

		 if ($usuario!='' and $password!='' and $clave!='' and $password2!=''){
		 		$consult = "SELECT nickname FROM usuarios WHERE nickname = '$usuario'";
		 		$result = $this->query_assoc($consult);
		 		

				if (count($result) > 0 ){	  
					return array('result' => false,
								 'msg' => 'Ese usuario ya ha sido registrado, 
								  porfavor intente con uno diferente');    
				}
				else{	

					if($password == $password2){
						$consult = "SELECT clave, id FROM usuarios WHERE clave = '$clave'";
						$result = $this->query_assoc($consult);

						if(count($result) > 0){
							$id = intval($result[0]['id']);

							$consult="UPDATE usuarios SET nickname = '$usuario', password = '$password' WHERE id = '$id'";
							$this->query($consult);

							return array('result' => true,
										 'msg' => 'Su registro se ha completado satisfactoriamente'); 
							echo'<meta http-equiv="refresh" content="2;URL=index.php"/> ';  
						}
						else{
							return array('result' => true,
										 'msg' => 'Su clave de registro es incorrecta, verifique que sea la correcta,
										 o pongase en contacto con su administrador'); 
						}
					}
					else{
						return array('result' => false,
									 'msg' => 'Ambas contraseñas deben coincidir');
					}

				}
							
		} 
		else{
			return array('result' => false,
						 'msg' => 'Falta completar alguno de los campos!'); 
		}	
	}
}
?>