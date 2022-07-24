<?php
   
	
	require_once("php/modelos/ventas_modelo.php");
	require_once("php/modelos/productoVenta_modelo.php");
	require_once("php/modelos/clientes_modelo.php");
	require_once("php/modelos/productos_modelo.php");

	//$objVentas = new ventas_modelo();
	$objProductos = new productos_modelo();
	$objClientes = new clientes_modelo();
   

		

	if(isset($_POST['accion']) && $_POST['accion'] == "login"){

		$documento = isset($_POST['documento'])?$_POST['documento']:"";
		$clave 	   = isset($_POST['clave'])?$_POST['clave']:"";
	
		$respuesta = $objClientes->login($documento, $clave);

		if($respuesta){
			@session_start();		
			$_SESSION['documento'] = $documento;
	
			//header('Location: index2.php');
			echo("ESTOY LOGUEADO");
			print_r($documento);
		
		}else{
			echo("ERROR EN EL LOGUEO");
		}

	}


	if(isset($_POST['accion']) && $_POST['accion'] == "agregarProducto"){
		
		
		$idCliente = isset($_SESSION['documento'])?$_SESSION['documento']:1;
		echo ("estoy en agregar prod");
		print_r($idCliente);
		$objVenta = new ventas_modelo();
		// Traer El ultimo carro abierto del usuario
		$idVenta= $objVenta->obtenerBuscarVenta($idCliente);
		
		$objProductoVenta= new productoVenta_modelo();

		$idProductoVenta = isset($_POST['id'])?$_POST['id']:"";	
		$cantidad 	= isset($_POST['cantidad'])?$_POST['cantidad']:"";	

		$respuesta = $objProductoVenta->ingresarLinea($idVenta,$idProducto,$cantidad);

		// Ingresar en la tabla producto el articulo + idArticulo (lo paso por hidden)
		// Procedo a guardar la idLinea	idTicket idArticulo	Cantidad
		
		} else{
			echo("error en agregar producto");
		}
	

	
	//$anio = date("Y");
	//$filtros = array('anio' => $anio);
	if(isset($_POST['action']) && $_POST['action'] == "buscar"){
		$filtros['buscar'] = $_POST['busqueda'];
		$listaProductos = $objproductoVentas->listarLineas($filtros);
		$estado = "";
	}
	

	

	// ------------------------------------------------------------ \\


	$arrayFiltro 	= array("pagina" => "1");
	if(isset($_GET['p']) && !Empty($_GET['p']) && $_GET['p'] != ""){
		$arrayFiltro["pagina"] = $_GET['p'];
	}
	$arrayPagina= $objProductos->paginador($arrayFiltro["pagina"]);

	$listaProductos = $objProductos->listar($arrayFiltro);

//	$listaCodCategoria = $objProductos->listaCodCategoria();
	
	//$listaProductos = $objProductos->listar();
	$estado = "";


?>

<!DOCTYPE html>
<html>
	<head>
		  <!--Import Google Icon Font-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
		  <!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

		<link rel="stylesheet" href="css/estilo.css" media="screen,projection"/>

		  <!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	</head>

	<body>

	<body>

		<nav>
			<div class="nav-wrapper">
				<a href="#!" class="brand-logo center">
					Cosmeticos
				</a>				
				<ul class="right hide-on-med-and-down">
					<li>
<?PHP 			if(isset($_SESSION['documento']) && $_SESSION['documento'] != ""){

 ?>
						<a >
						<?=$_SESSION['documento']?>
						</a>
					</li>
<?PHP 
				}
?>
					<li>
						<a class="modal-trigger" href="#modal1">
							<i class="material-icons">person</i>
						</a>
					</li>
<?PHP 			if(isset($_SESSION['documento']) && $_SESSION['documento'] != ""){

 ?>
					<li>
						<a class="modal-trigger" href="#modalCarrito">
							<i class="material-icons">add_shopping_cart</i>
						</a>
					</li>
<?PHP 
				}
?>
					<li>
						<form method="post" action="index2.php">
							<div class="input-field">
								<input type="hidden" name="action" value="buscar" required>
								<input id="search" type="search" name="busqueda" required>
									<label class="label-icon" for="search">
									<i class="material-icons">search</i>
								</label>
								<i class="material-icons">close</i>
							</div>
						</form>
					</li>
					<li>
						<a class="modal-trigger" href="logout.php">
							<i class="material-icons">exit_to_app</i>
						</a>
					</li>
					
				</ul>
			</div>
	</nav>


<div>
	<br><br>
</div>
<div id="modal1" class="modal modal-fixed-footer">

<div class="center-modal">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<div class="card">
					<div class="card-content">
						<div class="card-action teal lighten-1 white-text">
							<h6>Iniciar Sesion</h6>
						</div>
						
						<form method="POST" action="index2.php">
						<br><br>
							<div class="row">
								<div class="input-field col s12">
									<input id="documento" type="text" class="validate" name="documento">
										<label for="documento">Documento</label>
								</div>
								<div class="input-field col s12">
									<input id="clave" type="password" class="validate" name="clave">
									<label for="clave">Clave</label>
								</div>										
							</div>		
							<div class="row">
								<div class="input-field col s12">
									<input type="hidden" name="accion" value="login">
									<!--<button class="btn waves-effect waves-light btnIngresar" type="submit">Entrar
										<i class="material-icons right">send</i>
									</button>-->
									<div class="form-field">
										<button class="btn-large waves-effect waves-dark" style="width:100%;">Entrar</button>
									</div><br>
								</div>	
							</div>																													
						</form>
					</div>
				</div>
			</div>	
		</div>		
	</div>	
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Salir</a>		
	</div>	
</div>
</div>

	<!--	<div class="parallax-container">
			<div class="parallax"><img src="img/img_codigo.jpg"></div>
		</div>-->

	<main>

	<br><br>
		<div class="section, container">
			
			<div class="row"> 
<?php 			
			//depliego productos portada
			foreach($listaProductos as $productos){
?>
				<div class="col s3">
					<div class="card small">
						<div class="card-image waves-effect waves-block waves-light">
							<img class="activator" src="http://localhost:8888/_proyectoPOO/backend/<?=$productos['imagen']?>" width="100px">
						</div>
						<div class="card-content">
							<span class="card-title activator grey-text text-darken-4"><?=$productos['nombre']?><i class="material-icons right">more_vert</i></span>
						</div>
						<div class="card-reveal">
							<span class="card-title grey-text text-darken-4">
								<?=$productos['nombre']?><i class="material-icons right">close</i>
							</span>
							<p>
								<span>Producto:</span><?=$productos['nombre']?><br><br>
								<span>Descripcion:</span><?=$productos['descripcion']?><br><br>
								<span>Precio:</span><?=$productos['precio']?>	
							</p>
								<!--Formulario comprar-->
								<form method="POST" action="index2.php" class="col s12">
									
									<input type="hidden" name="id" value="<?=$productos['id']?>" >
									<input type="hidden" name="accion" value="agregarProducto">										
									
									<div class="row">
										<div class="input-field col s12">
											<input id="name_<?=$productos['id']?>" type="text" class="validate" name="cantidad" value="">
											<label for="name_<?=$productos['id']?>">Cantidad</label>
										</div>
									</div>			
										<button class="btn waves-effect waves-light btnIngresar" type="submit">Comprar
											<i class="material-icons right">send</i>
										</button>
								</form>	
						
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
			
			<div class="container white-text">
				Nuestra tienda
				<a class="right white-text" href="#!">Quienes somos?</a>
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




<?PHP
	/*$objProductos = new productos_modelo();
	
	$arrayFiltro 	= array("pagina" => "1");
	f(isset($_GET['p']) && !Empty($_GET['p']) && $_GET['p'] != ""){
		$arrayFiltro["pagina"] = $_GET['p'];
	}
	$arrayPagina= $objProductos->paginador($arrayFiltro["pagina"]);
	$listaProductos = $objProductos->listar($arrayFiltro);*/


?>

<div id="modalCarrito" class="modal modal-fixed-footer">
			<div class="modal-content">
				<h4 class="center-align">Carrito</h4>
				<?PHP if($estado == "Error"){ ?>
					<div class="red lighten-4 valign-wrapper" style="height:70px">
						<h5 class="center-align" style="width:100%">
							Error el ingresar al carro de compras.
						</h5>
					</div>
				<?PHP } ?>
					<table class="striped">
						<thead>
							<tr class="light-blue lighten-3">
								<th>Producto</th>
								<th>precio</th>					
								<th>cantidad</th>
								<th>Imagen</th>
								<th class="center-align" style="width: 130px;" >Acciones</th>
							</tr>
						</thead>
						<tbody>

<?php
			foreach($listaRengloProducto as $RenglonProduco){
?>
					<tr>
						<td><?=$RenglonProduco['nombre']?></td>
						<td><?=$RenglonProduco['precio']?></td>
						<td><?=$RenglonProduco['cantidad']?></td>
						<td>
							<img src="<?=$RenglonProduco['imagen']?>" width="100px">
						</td>
						<td>
							<div class="right">
								<a class="waves-effect waves-light btn" href="sistema.php?r=renglonProducto&id=<?=$RenglonProducto['id']?>&a=editar">
									<i class="material-icons">create</i>
								</a>
							</div>	
						</td>
					</tr>
<?PHP
			}
?>
					<tr>
						<td colspan="6">
							<ul class="pagination right">
								<li class="waves-effect"><a href="sistema.php?r=renglonProducto&p=<?=$arrayPagina['paginaAtras']?>"><i class="material-icons">chevron_left</i></a></li>
<?php
					for($i = 1; $i<=$arrayPagina['totalPagina'] ; $i++){
						$activo = "waves-effect";
						if($arrayPagina['pagina'] == $i){
							$activo = "active";
						}						
?>
						<li class="<?=$activo?>"><a href="sistema.php?r=renglonProducto&p=<?=$i?>"><?=$i?></a></li>
<?php
					}
?>
								<li class="waves-effect"><a href="sistema.php?r=renglonProducto&p=<?=$arrayPagina['paginaSiguiente']?>"><i class="material-icons">chevron_right</i></a></li>
							</ul>
						</td>
					</tr>

				</tbody>
			</table>
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-close waves-effect waves-green btn-flat">Salir</a>
			</div>
		</div>
