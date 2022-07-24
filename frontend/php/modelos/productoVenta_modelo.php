
<?php

require_once("generico_modelo.php");

class productoVenta_modelo extends generico_modelo {

	protected $idVenta;

	protected $idRenglon;

	protected $cod_Producto;

	protected $estadoRenglon;

	protected $fechaReg;

	protected $fechaMod;

	protected $precio;

	protected $cantidad;

	protected $estado;



	

  
		public function constructor(){

			$this->idRenglon		= $this->validarPost('idRenglon');
			$this->idVenta  		= $this->validarPost('idVenta');
			$this->cod_Producto 	= $this->validarPost('cod_Producto');
			$this->estadoRenglon 	= $this->validarPost('estadoRenglon');
			$this->$fechaMod    	= $this->validarPost('$fechaMod');
			$this->fechaReg 		= $this->validarPost('fechaReg');
			$this->precio        	= $this->validarPost('precio');
			$this->cantidad     	= $this->validarPost('cantidad');
			$this->estado       	= $this->validarPost('estado');
		
	
		}


	public function guardar(){
		return "1";
	}

	public function cargar($idVenta){
		if($idCliente == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El id del Cliente no puede ser vacio");
			return $retorno;
		}
		$sql = "SELECT * FROM   productoVentas WHERE idVenta= :idVenta AND estadoVenta = 'abierto';";
		
		$arraySQL = array("idCliente" => $idCliente);

		$lista 	= $this->ejecutarConsulta($sql, $arraySQL);

		
		$this->idVenta			= $lista[0]['idVenta'];
		$this->$fechaMod    	= $lista[0]['$fechaMod'];
		$this->fechaReg 		= $lista[0]['fechaReg'];
		$this->precioTotal      = $lista[0]['precioTotal'];
		$this->estado       	= $lista[0]['estado'];
		$this->documento    	= $lista[0]['documento'];



	
}


	
	public function cargarLineas($idVenta){
		//agregar inerjoin con producto

			if($idCliente == ""){
				$retorno = array("estado"=>"Error", "mensaje"=>"El id del Cliente no puede ser vacio" );
				return $retorno;
			}
			$sql = "SELECT * FROM   productoVenta WHERE idVenta= :idVenta AND estadoVenta = 'abierto';";
			
			$arraySQL = array("idCliente" => $idCliente);

			$lista 	= $this->ejecutarConsulta($sql, $arraySQL);
	
			$this->idRenglon		= $lista[0]['idRenglon'];
			$this->apellido 		= $lista[0]['idVenta'];
			$this->cod_Producto 	= $lista[0]['cod_Producto'];
			$this->estadoRenglon	= $lista[0]['estadoRenglon'];
			$this->$fechaMod    	= $lista[0]['$fechaMod'];
			$this->fechaReg 		= $lista[0]['fechaReg'];
			$this->precio        	= $lista[0]['precio'];
			$this->cantidad     	= $lista[0]['cantidad'];
			$this->estadoRenglon	= $lista[0]['Renglon'];
	
	
	
		
	}

	public function ingresarLineas($idVenta,$idProducto,$cantidad){

		if($this->idVenta == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El nombre no puede ser vacio" );
			return $retorno;
		}
		if($this->idProducto == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El apellido no puede ser vacio" );
			return $retorno;
		}

		$fechaHoy   = new DateTime(date("Y-m-d")); 
		$estadoVenta = 'abierto';

		$sqlInsert = "INSERT ventas SET
						idVenta			= :idVenta,
						fechaVenta		= :fechaVenta,
						fechaMod	 	= :fechaMod,
						estadoVenta     = :estadoVenta,
						precioTotal		= :precioTotal,
						estado			= 1 ;";

		
		$arrayInsert = array(
						"idVenta"   		=>	$this->idVenta,
						"fechaVenta"		=>	$this->fechaHoy,    	
						"fechaMod"			=>	$this->FechaHoy,		
						"estadoVenta"		=>	$this->estadoVenta,   
						"precioTotal"		=>	$this->precioTotal      	
		);
		$this->persistirConsulta($sqlInsert, $arrayInsert);
		$retorno = array("estado"=>"Ok", "mensaje"=>"Se ingreso la venta correctamente");
		return $retorno;

	}

}


?>

