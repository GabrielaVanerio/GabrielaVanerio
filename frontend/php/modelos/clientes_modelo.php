
<?php
//`nombre` varchar(50) NOT NULL,
//`apellido` varchar(100) NOT NULL,
//`fecha_nac` date NOT NULL,
//`tipoDocumento` enum('Pasaporte','CI') NOT NULL,
//`documento` varchar(20) NOT NULL,
//`celular` tinyint(10) NOT NULL,
//`fecha_reg` datetime DEFAULT NULL,
//`fecha_mod` datetime DEFAULT NULL,
//`estado` tinyint(1) DEFAULT '1',
 //	protected $fecha_mod;


// echo("entre modelo cliente");

 require_once("generico_modelo.php");




class clientes_modelo extends generico_modelo{


	protected $documento;

	protected $nombre;

	protected $apellido;

	protected $tipoDocumento;

	protected $fecha_nac;

	protected $celular;

	protected $email;

	protected $tipo_usuario;

	protected $estado;

	protected $clave;
	//protected $fecha_reg;



	
	public function constructor(){

		$this->documento 		= $this->validarPost('documento');
		$this->nombre 			= $this->validarPost('nombre');
		$this->apellido 		= $this->validarPost('apellido');
		$this->tipoDocumento 	= $this->validarPost('tipoDocumento', 'CI');
		$this->fecha_nac    	= $this->validarPost('fecha_nac');
		$this->estado        	= $this->validarPost('estado');
		$this->clave        	= $this->validarPost('clave');


	}

	public function obtenerDocumento(){
		return $this->documento;
	}
	public function obtenerNombre(){
		return $this->nombre;
	}
	public function obtenerApellido(){
		return $this->apellido;
	}
	public function obtenerTipoDocumento(){
		return $this->tipoDocumento;
	}
	public function obtenerFechaNacimiento(){
		return $this->fecha_nac;
	}
	public function obtenerEstado(){
		return $this->estado;
	}
	public function obtenerClave(){
		return $this->clave;
	}

	public function cargarCliente($documento){

		$sql = "SELECT * FROM clientes WHERE documento = :documento; ";
		$arrayDatos = array("documento"=>$documento);
		$lista 		= $this->ejecutarConsulta($sql, $arrayDatos);
		return $lista;

	}

	public function ingresar(){

		if($this->nombre == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El nombre no puede ser vacio" );
			return $retorno;
		}
		if($this->apellido == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El apellido no puede ser vacio" );
			return $retorno;
		}
		if($this->documento == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El documento no puede ser vacio" );
			return $retorno;
		}
	
		$fechaHoy   = new DateTime(date("Y-m-d")); 
		
		$sqlInsert = "INSERT clientes SET
						documento 		= :documento,
						nombre			= :nombre,
						apellido		= :apellido,
						tipoDocumento 	= :tipoDocumento,
						fecha_nac       = :fecha_nac,
						clave			= :clave,
						estado			= 1 ;";

		$arrayInsert = array(
				"documento" 		=> $this->documento,
				"nombre" 			=> $this->nombre,
				"apellido" 		    => $this->apellido,
				"tipoDocumento" 	=> $this->tipoDocumento,
				"fecha_nac" 	    => $this->fecha_nac,
				"clave"     	    => $this->clave
			);
		$this->persistirConsulta($sqlInsert, $arrayInsert);
		$retorno = array("estado"=>"Ok", "mensaje"=>"Se ingreso el Cliente correctamente" );
		return $retorno;

	}

	public function guardar(){

		if($this->nombre == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El nombre no puede ser vacio" );
			return $retorno;
		}
		if($this->apellido == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El apellido no puede ser vacio" );
			return $retorno;
		}

		if($this->documento == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El documento no puede ser vacio" );
			return $retorno;
		}
		$edad = 0;
		$fechaHoy   = new DateTime(date("Y-m-d")); 
		$fechaNac   = new DateTime($this->fecha_nac); 
		// Fecha que traigo 
		//$diferencia = $fechaHoy->diff($fechaNac);              
		//if($diferencia->days < 6570){
		//	$retorno = array("estado"=>"Error", "mensaje"=>"El el Cliente es menor de edad" );
		//	return $retorno;
		//}

		$sqlUpdate = "UPDATE clientes SET
		nombre			= :nombre,
		apellido	    = :apellido,
		tipoDocumento 	= :tipoDocumento,
		fecha_nac       = :fecha_nac
		WHERE documento = :documento";

		$arrayUpdate = array(


		"nombre" 	    => $this->nombre,
		"apellido"      => $this->apellido,
		"fecha_nac"     => $this->fecha_nac,
		"tipoDocumento" => $this->tipoDocumento,
		"documento" 	=> $this->documento


		);


		$this->persistirConsulta($sqlUpdate, $arrayUpdate);
		$retorno = array("estado"=>"Ok", "mensaje"=>"Se guardo el Cliente correctamente" );
		return $retorno;

	}

	public function cargar($documento){

		if($documento == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El documento no puede ser vacio" );
			return $retorno;
		}
		$sql = "SELECT * FROM clientes WHERE documento = :documento";
		$arraySQL = array("documento" => $documento);
		$lista 	= $this->ejecutarConsulta($sql, $arraySQL);

		$this->documento 		= $lista[0]['documento'];
		$this->nombre 			= $lista[0]['nombre'];
		$this->apellido 		= $lista[0]['apellido'];
		$this->tipoDocumento 	= $lista[0]['tipoDocumento'];
		$this->fecha_nac	    = $lista[0]['fecha_nac'];


	}

	public function borrar(){

		//$sql = "DELETE FROM alumnos WHERE documento = :documento";
		$sql = "UPDATE clientes SET estado = 0 WHERE documento = :documento";
		$arraySQL = array("documento"=>$this->documento);
		$this->persistirConsulta($sql, $arraySQL);
		$retorno = array("estado"=>"Ok", "mensaje"=>"Se borro el Cliente" );
		return $retorno;

	}


	public function listar($filtros = array()){

		$sql = "SELECT * FROM clientes WHERE estado = 1 ";
		$arrayDatos = array();

		if(isset($filtros['pagina']) && $filtros['pagina'] != ""){

			$pagina = ($filtros['pagina'] - 1) * 10;
			$sql .= " ORDER BY documento LIMIT ".$pagina.",10;";		
		
		}else{

			$sql .= " ORDER BY documento LIMIT 0,10;";	

		}

		$lista 	= $this->ejecutarConsulta($sql, $arrayDatos);
		return $lista;

	}

	public function totalRegistros(){

		$sql = "SELECT count(*) AS total FROM clientes";
		$arrayDatos = array();

		$lista 	= $this->ejecutarConsulta($sql, $arrayDatos);
		$totalRegistros = $lista[0]['total'];		
		return $totalRegistros;

	}

	public function listaTipoDocumuento(){

		$arrayRetorno = array();
		$arrayRetorno['CI'] = "CI";
		$arrayRetorno['Pasaporte'] = "Pasaporte";
	
		return $arrayRetorno;

	}
	/*public function validarLogin($documento, $clave){

		$sql = "SELECT * FROM clientes WHERE documento = :documento AND clave = :clave; ";
		$arrayDatos = array("documento"=>$documento, "clave"=>md5($clave));

		$lista 		= $this->ejecutarConsulta($sql, $arrayDatos);
		return $lista;

	}*/




	public function login($documento, $clave){
		
 	
		$sql = "SELECT count(*) AS total FROM clientes WHERE documento = :documento AND clave = :clave;" ;
		//print_r($sql);
		
		$arrayDatos = array("documento"=>$documento, "clave"=>MD5($clave));
		//print_r($arrayDatos);
		$lista 	= $this->ejecutarConsulta($sql, $arrayDatos);
		$totalRegistros = $lista[0]['total'];	
		//print_r($lista);
	
		if($totalRegistros > 0){
			$retornar = true;
		}else{
			$retornar = false;
		}
		return $retornar;
	}	

	


}


?>

