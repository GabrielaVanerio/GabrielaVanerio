
<?php

require_once("generico_modelo.php");

class ventas_modelo extends generico_modelo {

	protected 	$idVenta;
	
	protected 	$fechaMod;   

	protected 	$fechaReg; 	

	protected 	$precioTotal;

	protected 	$estado;      

	protected	$documento;    	
	
	protected	$estadoVenta;   



	public function constructor(){

	
		$this->idVenta  		= $this->validarPost('idVenta');
		$this->$fechaMod    	= $this->validarPost('$fechaMod');
		$this->fechaReg 		= $this->validarPost('fechaReg');
		$this->precio        	= $this->validarPost('precioTotal');
		$this->cantidad     	= $this->validarPost('cantidad');
		$this->estado       	= $this->validarPost('estado');
		$this->documento       	= $this->validarPost('documento');
		$this->estadoVenta      = $this->validarPost('estadoVenta');
	

	}
	public function cargarVenta($idCliente){
		if($idCliente == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El id del Cliente no puede ser vacio" );
			return $retorno;
		}
		$sql = "SELECT * FROM  ventas WHERE idCliente= :idCliente AND estadoVenta = 'abierto' ORDER BY idVenta DESC LIMIT 1";
		$arraySQL = array("idCliente" => $idCliente);

		$lista 	= $this->ejecutarConsulta($sql, $arraySQL);

		
		$this->$idVenta			= $lista[0]['idVenta'];
		$this->$fechaMod    	= $lista[0]['fechaMod'];
		$this->fechaReg 		= $lista[0]['fechaReg'];
		$this->$precioTotal     = $lista[0]['precioTotal'];
		$this->$estado       	= $lista[0]['estado'];
		$this->$documento    	= $lista[0]['documento'];
		$this->$estadoVenta     = $lista[0]['estadoVenta'];

	}

	
	public function obtenerBuscarVenta($idCliente){

		//Busco si el cliente tiene ventas abiertas, si tiene, obtengo el id de la venta si no lo tiene grabo una venta y obtengo el id

		if($idCliente == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El id del Cliente no puede ser vacio" );
			return $retorno;
		}
		$sql = "SELECT idVentas FROM ventas WHERE idCliente = $idCliente AND estado = 'abierto' ORDER BY idVenta DESC LIMIT 1";
		
		$resultado = $this->ejecutarConsulta($sql, $arrayDatos);

		if($resultado == vacio){
			//$sql = "Ingreso la venta set idCliente = $idCliente, estado = 'abierto' ";

			$resultadoIngresar=$this->Ingresar($idCliente);

			$sql = "SELECT idVentas FROM ventas WHERE idCliente = $idCliente AND estado = 'abierto' ORDER BY idVenta DESC LIMIT 1";
		
			$resultado = $this->ejecutarConsulta($sql, $arrayDatos);
		} else {
			$sql = "SELECT idVentas from ventas WHERE idCliente = $idCliente AND estado = 'abierto' ORDER BY idVenta DESC LIMIT 1";
			$resultado = $this->ejecutarConsulta($sql, $arrayDatos);
		}

		$idVenta = $resultado[0]['idVenta'];
		return $idVenta;

	}


		public function ingresar(){

		if($this->idVenta == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El nombre no puede ser vacio" );
			return $retorno;
		}
		if($this->documento == ""){
			$retorno = array("estado"=>"Error", "mensaje"=>"El apellido no puede ser vacio" );
			return $retorno;
		}

		$fechaHoy   = new DateTime(date("Y-m-d")); 
		$estadoVenta = 'abierto';

		$sqlInsert = "INSERT ventas SET
						idVenta			= :idVenta,
						documento		= :documento,
						fechaVenta		= :fechaVenta,
						fechaMod	 	= :fechaMod,
						estadoVenta     = :estadoVenta,
						precioTotal		= :precioTotal,
						estado			= 1 ;";

		
		$arrayInsert = array(
						"documento" 		=> $this->documento,
						"fechaVenta"		=>	$this->fechaHoy,    	
						"fechaMod"			=>	$this->FechaHoy,		
						"estadoVenta"		=>	$this->estadoVenta,   
						"precioTotal"		=>	$this->precioTotal      	
		);
		$this->persistirConsulta($sqlInsert, $arrayInsert);
		$retorno = array("estado"=>"Ok", "mensaje"=>"Se ingreso la venta correctamente");
		return $retorno;

	}
	public function borrar(){

		//$sql = "DELETE FROM alumnos WHERE documento = :documento";
		$sql = "UPDATE ventas SET estado = 0 WHERE idVenta = :idVenta";
		$arraySQL = array("idVenta"=>$this->idVenta);
		$this->persistirConsulta($sql, $arraySQL);
		$retorno = array("estado"=>"Ok", "mensaje"=>"Se borro la Venta" );
		return $retorno;

	}
}


?>

