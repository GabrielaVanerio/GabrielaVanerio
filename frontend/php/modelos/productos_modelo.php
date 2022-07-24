<?PHP
  //id` int(11) NOT NULL AUTO_INCREMENT,
  //`nombre` varchar(100) NOT NULL,
  //`descripcion` varchar(100) NOT NULL,
  //`precio` float DEFAULT '0',
  //`cod_categoria` varchar(20) DEFAULT NULL,
  //`imagen` varchar(100) DEFAULT NULL,
  //`estado` tinyint(4) DEFAULT '1'


require_once("generico_modelo.php");

class productos_modelo extends generico_modelo{


    protected $id;

    protected $nombre;

    protected $descripcion;

	protected $precio;

	protected $cod_categoria;

	protected $imagen;
	
	protected $estado;

    public function constructor(){

		$this->id               = $this->validarPost('id');
		$this->nombre 		    = $this->validarPost('nombre');
		$this->descripcion 	    = $this->validarPost('descripcion');
		$this->precio 	        = $this->validarPost('precio');
		$this->cod_categoria 	= $this->validarPost('cod_categoria', 'Estetica');
		$this->estado        	= $this->validarPost('estado');

	}




	public function obtenerId(){
        return $this->idTipoCurso;
    }
    public function obtenerNombre(){
        return $this->nombre;
    }
    public function obtenerDescripcion(){
        return $this->descripcion;
    }
	public function obtenerprecio (){
        return $this->precio;
    }
	public function obtenerCodCategoria (){
        return $this->cod_categoria ;
    }
	public function obtenerimagen(){
        return $this->imagen;
	}
	public function obtenerEstado(){
        return $this->estado;
	}
	public function cargarImagen($ruta){
		$this->imagen = $ruta;
	}


    public function cargar($id){

		if($id == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El id no puede ser vacio" );
			return $retorno;
		}
		$sql = "SELECT * FROM productos WHERE id= :id";
		$arraySQL = array("id" => $id);
		$lista 	= $this->ejecutarConsulta($sql, $arraySQL);
		//print_r($lista);
		$this->id       	    = $lista[0]['id'];
		$this->nombre 		    = $lista[0]['nombre'];
		$this->descripcion 	    = $lista[0]['descripcion'];
		$this->precio    	    = $lista[0]['precio'];
		$this->cod_categoria   	= $lista[0]['cod_categoria'];
		$this->imagen   	    = $lista[0]['imagen'];
		$this->estado	        = $lista[0]['estado'];
	
	


	}

    public function borrar(){


		$sql = "UPDATE productos SET estado = 0 WHERE id = :id";
		$arraySQL = array("id"=>$this->id);
		$this->persistirConsulta($sql, $arraySQL);
		$retorno = array("estado"=>"Ok", "mensaje"=>"Se borro el tipo de curso" );
		return $retorno;

	}






	public function ingresar(){

		if($this->nombre == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El nombre no puede ser vacio" );
			return $retorno;
		}
		if($this->descripcion == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"La descripcion no puede ser vacia" );
			return $retorno;
		}
		
		$fechaHoy   = new DateTime(date("Y-m-d")); 
		

		$arrayCodCategoria = $this->listaCodCategoria();
		if(!in_array($this->cod_categoria,  $arrayCodCategoria)){
		$retorno = array("estado"=>"Error", "mensaje"=>"La categoria no es valida" );
		return $retorno;
		}
		$sqlInsert = "INSERT productos SET
						
						nombre			= :nombre,
						descripcion		= :descripcion,
						cod_categoria 	= :cod_categoria,
						precio          = :precio,
						imagen           = :imagen,
						estado			= 1 ;";

		$arrayInsert = array(
			
				"nombre" 			=> $this->nombre,
				"descripcion" 	    => $this->descripcion,
				"cod_categoria"   	=> $this->cod_categoria,
				"precio" 	        => $this->precio,
				"imagen" 	        => $this->imagen
				
			);

			print_r($arrayInsert);
		$this->persistirConsulta($sqlInsert, $arrayInsert);
		$retorno = array("estado"=>"Ok", "mensaje"=>"Se ingreso el producto correctamente" );
		return $retorno;

	}

	public function guardar(){

		if($this->nombre == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El nombre no puede ser vacio" );
			return $retorno;
		}
		if($this->descripcion == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"La descripcion no puede ser vacia" );
			return $retorno;
		}
		
		$fechaHoy   = new DateTime(date("Y-m-d")); 
		
		$Fecha_mod = $fechaHoy;
		// Fecha que traigo 
		
	
		$arrayCodcategoria = $this->listaCodCategoria();
	
		if(!in_array($this->cod_categoria,  $arrayCodcategoria)){
			//print_r($arrayCodCategoria);
			$retorno = array("estado"=>"Error", "mensaje"=>"El tipo categoria  no es valido" );
			return $retorno;
		}
		
		$sqlUpdate = "UPDATE productos SET
						nombre			= :nombre,
						descripcion		= :descripcion,
						cod_categoria 	= :cod_categoria,
						precio          = :precio
						WHERE id        = :id";

		$arrayUpdate = array(
			
				"nombre" 			=> $this->nombre,
				"descripcion" 	    => $this->descripcion,
				"cod_categoria" 	=> $this->cod_categoria,
				"precio"        	=> $this->precio,
				"id"            	=> $this->id
				
			);
			
			
		$this->persistirConsulta($sqlUpdate, $arrayUpdate);
		$retorno = array("estado"=>"Ok", "mensaje"=>"Se guardo el usuario correctamente" );
		return $retorno;

	}

    




    public function listar($filtros = array()){
	
		$sql = "SELECT 
					id,
					nombre,
					descripcion,
					precio,
					cod_categoria,
					imagen
					
					FROM productos WHERE estado = 1";
		$arrayDatos = array();
		//print_r($error); 
		if(isset($filtros['pagina']) && $filtros['pagina'] != ""){

			$pagina = ($filtros['pagina'] - 1) * 10;
			$sql .= " ORDER BY id LIMIT ".$pagina.",10;";		
		
		}else{

			$sql .= " ORDER BY id LIMIT 0,10;";	

		}
		//print_r("$sql");

		$lista 	= $this->ejecutarConsulta($sql, $arrayDatos);
		//print_r("$lista");
		return $lista;

    }


	

    public function totalRegistros(){

		$sql = "SELECT count(*) AS total FROM productos";
		$arrayDatos = array();

		$lista 	= $this->ejecutarConsulta($sql, $arrayDatos);
		$totalRegistros = $lista[0]['total'];		
		return $totalRegistros;
	}
	
	
	public function listarP($filtros = array()){
	
		$sql = "SELECT 
					id,
					nombre,
					descripcion,
					precio,
					cod_categoria,
					imagen
		FROM productos
		WHERE id != 0 ";
		
		$arrayDatos = array();
		
		if(isset($filtros['buscar']) && $filtros['buscar'] != ""){

			$sql .= " AND nombre LIKE ('%".$filtros['buscar']."%') ";
		
		}

		if(isset($filtros['pagina']) && $filtros['pagina'] != ""){

			$pagina = ($filtros['pagina'] - 1) * 10;
			$sql .= " ORDER BY codigo LIMIT ".$pagina.",10;";		
		
		}else{

			$sql .= " ORDER BY codigo LIMIT 0,10;";	

		}

		$lista 	= $this->ejecutarConsulta($sql, $arrayDatos);
		return $lista;

	}
	
	public function listaCodCategoria(){

		$arrayRetorno = array();
		$arrayRetorno['Esetetica'] = "Estetica";
		$arrayRetorno['Cuidado Personal'] = "Cuidado Personal";
		//print_r($arrayRetorno);
		return $arrayRetorno;
	
	}
	
}

?>