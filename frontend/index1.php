<?php

	//echo("Estoy en el frontend");    
	require_once("php/modelos/productos_modelo.php");
	require_once("php/modelos/clientes_modelo.php");
	

	$objProductos = new productos_modelo();
	$objClientes = new clientes_modelo();


	if(isset($_POST['accion']) && $_POST['accion'] == "login"){

		$documento = isset($_POST['documento'])?$_POST['documento']:"";
		$clave 	   = isset($_POST['clave'])?$_POST['clave']:"";
		//print_r($clave);
		$respuesta = $objClientes->login($documento, $clave);
     
		if($respuesta){
			@session_start();
			$_SESSION['fecha'] = date("Y-m-a");		
			$_SESSION['documento'] = $respuesta[0]['documento'];
			//$_SESSION['mail'] = $respuesta[0]['mail'];
			header('Location: index2.php');
			echo("ESTOY LOGUEADO");
		}else{
			echo("ERROR EN EL LOGUEO");
			$estado = "Error";
		}

	}


	//$anio = date("Y");
	// ------------------------------------------------------------ \\
	$arrayFiltro 	= array("pagina" => "1");
	if(isset($_GET['p']) && !Empty($_GET['p']) && $_GET['p'] != ""){
		$arrayFiltro["pagina"] = $_GET['p'];
	}
	$arrayPagina= $objProductos->paginador($arrayFiltro["pagina"]);
	//$listaproducto = $objProductos->listar($arrayFiltro);
	$listaCodCategoria = $objProductos->listaCodCategoria();
	$listaProductos = $objProductos->listar();

	$estado = "";




?>

<!DOCTYPE html>
<html>
	<head>
	  	<!--Import Google Icon Font-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	  	<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

	 	 <!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<style>	
			  body {
			    display: flex;
			    min-height: 100vh;
			    flex-direction: column;
			  }
			  main {
			    flex: 1 0 auto;
			  }
		</style>
	</head>
	
	<body>
		<nav>
			<div class="nav-wrapper">
				<a href="#!" class="brand-logo"><i class="material-icons">cloud</i>Logo</a>
				<ul class="right hide-on-med-and-down">
					<li>
					<li>
						<a class=" " href="index.php?r=clientes">Clientes</a>
					</li>
					
					<li>
						<a class="modal-trigger" href="#modal1">
							<i class="material-icons">person</i>
						</a>
					</li>
					<li>
						<a href="logout.php">
							<i class="material-icons">close </i>
						</a>
					</li>
				</ul>
			</div>
		</nav>

	

		<div id="modal1" class="modal modal-fixed-footer">
			<div class="modal-content">
				<h4 class="center-align">Login</h4>
				<?PHP if($estado == "Error"){ ?>
					<div class="red lighten-4 valign-wrapper" style="height:70px">
						<h5 class="center-align" style="width:100%">
							Error en el usuario y/o clave
						</h5>
					</div>
				<?PHP } ?>
				<form method="POST" action="index.php" class="col s12">
					<div class="row">
						<div class="input-field col s12 m12 l6 offset-l3">
							<input id="documento" type="text" class="validate" name="documento">
							<label for="documento">Documento</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12 m12 l6 offset-l3">
							<input id="clave" type="password" class="validate" name="clave">
							<label for="clave">Clave</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12 m12 l6 offset-l3">
							<input type="hidden" name="accion" value="login">
							<button class="btn waves-effect waves-light center-align" type="submit">Entrar
								<i class="material-icons right">send</i>
							</button>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-close waves-effect waves-green btn-flat">Salir</a>
			</div>
		</div>

	<!--	<div class="parallax-container">
	    	<div class="parallax"><img src="img/img_phpFront.jpeg"></div>
	    </div>-->

		
	</div>
		<main>
		
		   <div class="container">
				<?PHP include ("router.php"); ?>
			</div>
		
			<div class="container">
				<div class="row">
<?php 			
				//print_r($listaProductos);
				foreach($listaProductos as $productos){
					//print_r($listaProductos);
					//echo("estoy en foreah");
?>
					<div class="col s4">
						<div class="card">
							<div class="card-image waves-effect waves-block waves-light">
								<img class="activator" src="http://localhost:8888/_proyectoPOO/backend/<?=$productos['imagen']?>" width="100px">
							</div>
							<div class="card-content">
								<span class="card-title activator grey-text text-darken-4"><?=$productos['nombre']?><i class="material-icons right">more_vert</i></span>
								<p><a href="#">Ver Mas</a></p>
							</div>
							<div class="card-reveal">
								<span class="card-title grey-text text-darken-4">
									<?=$productos['nombre']?><i class="material-icons right">close</i>
								</span>
								<p>
									<span>Producto:</span><?=$productos['nombre']?><br><br>
									<span>Descripcion</span><?=$productos['descripcion']?><br><br>
									<span>Precio:</span><?=$productos['precio']?>
								</p>
							</div>
						</div>
					</div>
				
<?PHP
				}
?>
				</div>


			</div>
		</main>
		
        <footer class="page-footer">
			<div class="container">
        
			</div>
			<div class="footer-copyright">
				<div class="container">
					© <?=date("Y")?> Copyright Text
					<a class="grey-text text-lighten-4 right" href="#!">More Links</a>
				</div>
			</div>
		</footer>
	<!--JavaScript at end of body for optimized loading-->
	<script type="text/javascript" src="js/materialize.min.js"></script>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				M.AutoInit();	
				var elems = document.querySelectorAll('.modal');
    			var instances = M.Modal.init(elems, options);		
			});	
		</script>
		
	</body>
</html>