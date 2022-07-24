
<?php

	/*
		usando la funcion isset() Evaluo si existe el prametro
		usando la funcion Empty() Evaluo si el parametro esta vacio y es distinto de null
		Evaluamos != "" si esta vacio
	*/

 print_r($_GET);
	if(isset($_GET['r']) && !Empty($_GET['r']) && $_GET['r'] != ""){

		$ruta = $_GET['r'];

		
		if($ruta == "clientes"){
			echo("estoy en  clientes");
			include("php/vistas/clientes.php");
			
		}
	
	}


?>