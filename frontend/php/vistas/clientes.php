<?PHP

	require_once("php/modelos/clientes_modelo.php");

	$objclientes = new clientes_modelo();

	$error = array();
	if(isset($_POST['accion']) && $_POST['accion'] == "ingresar"){

		// En caso que la accion sera ingresar procedemos a ingresar el registro
		$objclientes->constructor();
		$error = $objclientes->ingresar();
	}
	if(isset($_POST['accion']) && $_POST['accion'] == "guardar"){

		// En caso que la accion sera ingresar procedemos a ingresar el registro
		$objclientes->constructor();
		$error = $objclientes->guardar();

	}
	

	// Armamos el paginado
	$arrayFiltro 	= array("pagina" => "1");
	if(isset($_GET['p']) && !Empty($_GET['p']) && $_GET['p'] != ""){
		$arrayFiltro["pagina"] = $_GET['p'];
	}
	$arrayPagina = $objclientes->paginador($arrayFiltro["pagina"]);
	$listaTiposDocu = $objclientes->listaTipoDocumuento();
	$listaclientes = $objclientes->listar($arrayFiltro);


?>

<div>
	<h5>Clientes</52>
	<?PHP if(isset($error['estado']) && $error['estado']=="Error"){ ?>
		<div class="red valign-wrapper" style="height:70px">
			<h5 class="center-align" style="width:100%">
	<?PHP	print_r($error['mensaje']); ?>
			</h5>
		</div>
	<?PHP } ?>

	<?PHP if(isset($error['estado']) && $error['estado']=="Ok"){ ?>
		<div class="teal lighten-4 valign-wrapper" style="height:70px">
			<h5 class="center-align" style="width:100%">
	<?PHP print_r($error['mensaje']); ?>
			</h5>
		</div>
	<?PHP } ?>

<?php
		if(isset($_GET['a']) && $_GET['a'] == "borrar"){ 
			$idRegistro = isset($_GET['id'])?$_GET['id']:"";

?>
			<div class="divider"></div>
			<form method="POST" action="index.php?r=clientes" class="col s12">
				<h3>Quiere borrar al cliente?</h3>
				<input type="hidden" name="documento" value="<?=$idRegistro?>" >
				<button class="btn waves-effect waves-light" type="submit" name="accion" value="borrar">Aceptar
					<i class="material-icons right">delete_sweep</i>
				</button>
				<button class="btn waves-effect waves-light red" type="submit" name="accion">Cancelar
					<i class="material-icons right">cancel</i>
				</button>
			</form>
			<br><br>
			<div class="divider"></div>
<?PHP } ?>


<?PHP 
		if(isset($_GET['a']) && $_GET['a'] == "editar" && isset($_GET['id']) && $_GET['id'] != ""){ 
			$idRegistro = isset($_GET['id'])?$_GET['id']:"";
			$objclientes->cargar($idRegistro);
?>
			<div class="divider"></div>
				<form method="POST" action="index.php?r=clientes" class="col s12">
				<h3>Editar cliente </h3>
				<input type="hidden" name="documento" value="<?=$idRegistro?>" >
				<input type="hidden" name="accion" value="guardar">
				<div class="row">
					<div class="input-field col s6">
						<input id="nombre" type="text" class="validate" name="nombre" value="<?=$objclientes->obtenerNombre()?>">
						<label for="nombre">Nombre</label>
					</div>
					<div class="input-field col s6">
						<input id="apellido" type="text" class="validate" name="apellido"  value="<?=$objclientes->obtenerApellido()?>">
						<label for="apellido">Apellido</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s4">
						<input id="documento" type="number" class="validate" name="documento" value="<?=$objclientes->obtenerDocumento()?>" disabled >
					 	<label for="documento">Documento</label>
					</div>
					
					<div class="input-field col s4">
						<select id="tipoDocumento" name="tipoDocumento" >
							<option value="" disabled selected>Seleccione una opcion</option>
<?php
							foreach($listaTiposDocu as $tipoDocumento){
?>
							<option value="<?=$tipoDocumento?>" <?php if($tipoDocumento == $objclientes->obtenerTipoDocumento()){ echo("selected"); } ?> ><?=$tipoDocumento?></option>
<?php
							}
?>
						</select>
						<label>Tipo Documento</label>
					</div>
					<div class="input-field col s4">
						<input id="fecha_nac" type="date" class="validate" name="fecha_nac" value="<?=$objclientes->obtenerFechaNacimiento()?>" >
						<label for="fecha_nac">Fecha Nacimiento</label>
					</div>
				</div>				
				<button class="btn waves-effect waves-light" type="submit">Guardar
					<i class="material-icons right">send</i>
				</button>
			</form>
			<br><br>
			<div class="divider"></div>
<?PHP } ?>

	<a class="waves-effect waves-light btn modal-trigger right" href="#modal2">Ingresar</a>
	<br><br>
	<table class="striped">
		<thead>
			<tr class=" ">
				<th>Documento</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>Tipo Documento</th>
				<th>Fecha nacimiento</th>
				<th class="center-align" style="width: 130px;" >Acciones</th>
			</tr>
		</thead>
		<tbody>

<?php
			foreach($listaclientes as $cliente){
?>
			<tr>
				<td><?=$cliente['documento']?></td>
				<td><?=$cliente['nombre']?></td>
				<td><?=$cliente['apellido']?></td>
				<td><?=$cliente['tipoDocumento']?></td>
				<td><?=$cliente['fecha_nac']?></td>
				<td>
					<div class="right">
						<a class="waves-effect waves-light btn" href="index.php?r=clientes&id=<?=$cliente['documento']?>&a=editar">
							<i class="material-icons">create</i>
						</a>
						<a class="waves-effect waves-light btn red" href="index.php?r=clientes&id=<?=$cliente['documento']?>&a=borrar">
							<i class="material-icons">delete</i>
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
						<li class="waves-effect"><a href="index.php?r=clientes&p=<?=$arrayPagina['paginaAtras']?>"><i class="material-icons">chevron_left</i></a></li>
<?php
					for($i = 1; $i<=$arrayPagina['totalPagina'] ; $i++){
						$activo = "waves-effect";
						if($arrayPagina['pagina'] == $i){
							$activo = "active";
						}						
?>
						<li class="<?=$activo?>"><a href="index.php?r=clientes&p=<?=$i?>"><?=$i?></a></li>
<?php
					}
?>
				    	<li class="waves-effect"><a href="index.php?r=clientesp=<?=$arrayPagina['paginaSiguiente']?>"><i class="material-icons">chevron_right</i></a></li>
					</ul>
				</td>
			</tr>

		</tbody>
	</table>







</div>



<!-- Modal Structure -->
	<div id="modal2" class="modal modal-fixed-footer">
		<div class="modal-content">
			<h4>Ingresar Clientes</h4>
			<form method="POST" action="index.php?r=clientes" class="col s12">
				<div class="row">
					<div class="input-field col s6">
						<input id="first_name" type="text" class="validate" name="nombre">
						<label for="first_name">Nombre</label>
					</div>
					<div class="input-field col s6">
						<input id="last_name" type="text" class="validate" name="apellido">
						<label for="last_name">Apellido</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s4">
						<input id="documento" type="number" class="validate" name="documento">
					 	<label for="documento">Documento</label>
					</div>

					<div class="input-field col s4">
						<select id="tipoDocumento" name="tipoDocumento" >
							<option value="" disabled selected>Seleccione una opcion</option>
<?php
							foreach($listaTiposDocu as $tipoDocumento){
?>
							<option value="<?=$tipoDocumento?>"><?=$tipoDocumento?></option>
<?php
							}
?>
						</select>
						<label>Tipo Documento</label>
					</div>
					<div class="input-field col s4">
						<input id="fechaNacimiento" type="date" class="validate" name="fecha_nac">
						<label for="fechaNacimiento">Fecha Nacimiento</label>
					</div>
				</div>
				
				<input type="hidden" name="accion" value="ingresar">
				<button class="btn waves-effect waves-light" type="submit">Enviar
					<i class="material-icons right">send</i>
				</button>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
		</div>
	</div>