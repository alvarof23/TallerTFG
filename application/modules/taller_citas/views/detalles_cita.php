<?php
	switch ($cita->estado) {
		case "Completada":
			$style = "background-color: rgba(0, 255, 0, 0.4); color: black";
			break;
		case "Procesando":
			$style = "background-color: rgba(255, 255, 0, 0.4); color: black";
			break;
		case "Esperando_recepcion":
			$style = "background-color: rgb(209, 236, 241); color: black";
			break;
		case "Anulada":
			$style = "background-color: rgba(255, 0, 0, 0.7)";
			break;
		default:
			$style = "";
	}
	$estado_legible = ucwords(str_replace('_', ' ', $cita->estado));

?>

<ul class="panel-controls">
	<?php if($acceso[1]==1): ?>
		<li>
			<a href="<?= site_url('citas') ?>" class="btn-thinner"> <i class="fa fa-reply"></i></a>
		</li>

		<li>
			<button type="button" class="btn btn-primary activar_modal_add boton_citas" data-toggle="modal" data-target="#modal_form" title="Editar" id="boton_vehiculos"
				data-id="<?= $cita->id ?>"
				data-id_cliente="<?= $cita->dni ?>"
				data-id_vehiculo="<?= $cita->id_vehiculo ?>"
				data-estado="<?= $cita->estado ?>"
				data-observaciones="<?= $cita->observaciones ?>"
				data-fecha="<?= $cita->fecha ?>"
				data-hora="<?= $cita->hora ?>"
				data-id_tarea="<?= $cita->id_tarea ?>"
			>
				<i class="fa fa-edit"></i>
			</button>
		</li>

		<li>
			<button type="button" class="btn btn-primary activar_modal_recogida boton_citas" data-toggle="modal" data-target="#modal_form" title="Recoger vehiculo" id="boton_tareas"
				data-id="<?= $cita->id ?>"
				data-id_cliente="<?= $cita->dni ?>"
				data-id_vehiculo="<?= $cita->id_vehiculo ?>"
				data-estado="<?= $cita->estado ?>"
				data-observaciones="<?= $cita->observaciones ?>"
				data-fecha="<?= $cita->fecha ?>"
				data-hora="<?= $cita->hora ?>"
				data-id_tarea="<?= $cita->id_tarea ?>"
				<?php if($vehiculos_recepcion): ?>
					style="background-color: green;"
				<?php endif ?>
			>
				<i class="fa fa-car"></i>
			</button>
		</li>
		
		<li>
			<button type="button" class="btn btn-primary activar_factura boton_citas" data-toggle="modal" data-target="#modal_form" title="Generar factura" id="boton_tareas">
				<i class="fa-solid fa-file-invoice"></i>
			</button>
		</li>

		<li>
			<div class="btns-izquierda">
				<a href="<?= base_url('admin.php/citas/detalles/' . $cita->id . '/' . $cita->id_cliente) ?>" class="btn btn-primary boton_citas" id="boton_citas" 
				style="<?= $style ?>" disabled>
					<i class="fa fa-info">
					</i>
				</a>
			</div>
		</li>

		<li>
			<p style="font-size: 28px;"> || </p>
		</li>

		<?php
			$hay_recepciones = $this->db
				->from('taller_recepcion')
				->where('id_cita', $cita->id)
				->count_all_results() > 0;

			if ($cita->estado !== "Esperando_recepcion" && $cita->estado !== "Anulada") {
				// Mostrar todos menos el actual
				$estados = [
					"Entregado" => "car-side",
					"Completada" => "flag-checkered",
					"Procesando" => "wrench",
					"Esperando_recepcion" => "bell-concierge",
					"Anulada" => "ban"
				];

				foreach ($estados as $estado => $icono) {
					if ($cita->estado !== $estado) {
						echo '<li>
								<button class="btn btn-primary fichaModal btn_estado boton_citas btn-xs" title="'.$estado.'"
									data-id="'.$cita->id.'"
									data-id_vehiculo="'.$cita->id_vehiculo.'"
									data-fecha="'.$cita->fecha.'"
									data-hora="'.$cita->hora.'"
									data-id_tarea="'.$cita->id_tarea.'"
									data-estado="'.$estado.'">
									<i class="fa fa-'.$icono.'"></i>
								</button>
							</li>';
					}
				}

			} elseif ($cita->estado === "Esperando_recepcion") {
				// Solo mostrar botón de "Anulada"
				echo '<li>
						<button class="btn btn-primary fichaModal btn_estado boton_citas btn-xs" title="Anulada"
							data-id="'.$cita->id.'"
							data-id_vehiculo="'.$cita->id_vehiculo.'"
							data-fecha="'.$cita->fecha.'"
							data-hora="'.$cita->hora.'"
							data-id_tarea="'.$cita->id_tarea.'"
							data-estado="Anulada">
							<i class="fa fa-ban"></i>
						</button>
					</li>';

			} elseif ($cita->estado === "Anulada") {
				if ($hay_recepciones) {
					// Mostrar todos menos "Anulada"
					$estados = [
						"Entregado" => "car-side",
						"Completada" => "flag-checkered",
						"Procesando" => "wrench",
						"Esperando_recepcion" => "bell-concierge"
					];

					foreach ($estados as $estado => $icono) {
						echo '<li>
								<button class="btn btn-primary fichaModal btn_estado boton_citas btn-xs" title="'.$estado.'"
									data-id="'.$cita->id.'"
									data-id_vehiculo="'.$cita->id_vehiculo.'"
									data-fecha="'.$cita->fecha.'"
									data-hora="'.$cita->hora.'"
									data-id_tarea="'.$cita->id_tarea.'"
									data-estado="'.$estado.'">
									<i class="fa fa-'.$icono.'"></i>
								</button>
							</li>';
					}
				} else {
					// Solo mostrar botón de "Esperando_recepcion"
					echo '<li>
							<button class="btn btn-primary fichaModal btn_estado boton_citas btn-xs" title="Esperando recepción"
								data-id="'.$cita->id.'"
								data-id_vehiculo="'.$cita->id_vehiculo.'"
								data-fecha="'.$cita->fecha.'"
								data-hora="'.$cita->hora.'"
								data-id_tarea="'.$cita->id_tarea.'"
								data-estado="Esperando_recepcion">
								<i class="fa fa-bell-concierge"></i>
							</button>
						</li>';
				}
			}
		?>


	<?php endif ?>
</ul>



	
<div class="panel panel-default" style="border-top:none;">
	<?php if(isset($acceso[1]) && $acceso[1]==1): ?>
		<?php if(isset($_POST['nuevo-tipos-tareas'])): ?>
			<div class="col-md-12"><?= validation_errors(); ?></div>  
			<?php if(isset($error_subida_archivo) && $error_subida_archivo) echo $error_subida_archivo; ?>
		<?php endif ?>
		<div class="panel-body">
			<div class="page-content-wrap">
				<div class="row" style="margin-top:10px">
				<!-- A la Izquierda -->
					<div class="col-md-6">
						<div class="col-md-12">
							<h4>Información de cliente</h4>
							<div class="row row_data">
								<label class="col-md-3 col-xs-12 control-label text-right">Nombre de cliente:</label>
								<div class="col-md-9">
									<?php
									if (isset($cita->cliente_nombre)) {
										echo $cita->cliente_nombre;
									}
									?>
								</div>
							</div>
							<div class="row row_data">
								<label class="col-md-3 col-xs-12 control-label text-right">CIF:</label>
								<div class="col-md-9">
									<?php
									if (isset($cita->dni)) {
										echo $cita->dni;
									}
									?>
								</div>
							</div>	
							<div class="row row_data">
								<label class="col-md-3 col-xs-12 control-label text-right">Teléfono:</label>
								<div class="col-md-9">
									<?php
									if (isset($cita->cliente_telefono)) {
										echo $cita->cliente_telefono;
									}
									?>
								</div>
							</div>
							<div class="row row_data">
								<label class="col-md-3 col-xs-12 control-label text-right">Email:</label>
								<div class="col-md-9">
									<?php
									if (isset($cita->cliente_email )) {
										echo $cita->cliente_email ;
									}
									?>
								</div>
							</div>
							<br>
						</div>

						<div class="col-md-12">
							<h4>Información de vehiculo</h4>
							<div class="row row_data">
								<label class="col-md-3 col-xs-12 control-label text-right">Vehículo:</label>
								<div class="col-md-9">	
									<?php
									if (isset($cita->marca)) {
										echo  $cita->marca;
									}
									if (isset($cita->modelo)) {
										echo ' ' . $cita->modelo;
									}
									?>
								</div>
							</div>
							<div class="row row_data">
								<label class="col-md-3 col-xs-12 control-label text-right">Matrícula:</label>
								<div class="col-md-9">
									<?php
									if (isset($cita->matricula)) {
										echo  $cita->matricula;
									}
									?>
								</div>
							</div>
							<div class="row row_data">
								<label class="col-md-3 col-xs-12 control-label text-right">Nº Bastidor:</label>
								<div class="col-md-9">
									<?php
									if (isset($cita->num_bastidor)) {
										echo  $cita->num_bastidor;
									}
									?>
								</div>
							</div>
							<br>
						</div>

						<div class="col-md-12">
							<h4>Información de Cita</h4>
							<div class="row row_data">
								<label class="col-md-3 col-xs-12 control-label text-right">Id:</label>
								<div class="col-md-9">
									<?php
									if (isset($cita->id)) {
										echo  $cita->id;
									}
									?>
								</div>
							</div>
							<div class="row row_data">
								<label class="col-md-3 col-xs-12 control-label text-right">Fecha:</label>
								<div class="col-md-9">
									<?php
									if (isset($cita->fecha)) {
										echo  date('d/m/Y', strtotime($cita->fecha));
									}
									?>
								</div>
							</div>
							<div class="row row_data">
								<label class="col-md-3 col-xs-12 control-label text-right">Hora:</label>
								<div class="col-md-9">
									<?php
									if (isset($cita->hora)) {
										echo  $cita->hora;
									}
									?>
								</div>
							</div>
							<div class="row row_data">
								<label class="col-md-3 col-xs-12 control-label text-right">Área de trabajo:</label>
								<div class="col-md-9">
									<?php
									if (isset($cita->area_nombre)) {
										echo  $cita->area_nombre;
									}
									?>
								</div>
							</div>

							<div class="row row_data" id="estado_contenedor">
								<label class="col-md-3 col-xs-12 control-label text-right">Estado:</label>
								<div class="col-md-9 col-xs-12">
									<?php if (isset($cita->estado)): ?>
										<span class="badge bg-info text-dark" id="bg-info" style="<?= $style ?>"><?= $estado_legible ?></span>
									<?php endif; ?>
								</div>
							</div>

							
							<div class="row row_data">
								<label class="col-md-3 col-xs-12 control-label text-right">Observaciones:</label>
								<div class="col-md-9">
									<?php
									if (isset($cita->area_nombre)) {
										echo  nl2br($cita->observaciones);
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<!-- A al derecha -->
					<div class="col-md-6">
						<div class=col-md-12>
							<h4 class="m-top-10" style="margin-bottom:0px;">Vehiculos del cliente con cita:</h4>
							<div id="selectorVehiculos" class="mt-3">
								<?php foreach ($vehiculos_cita as $vehiculos): ?>
									<button type="button" class="btn btn-primary btn_vehiculos_citas" id="btn_vehiculos_citas" data-id="<?= $vehiculos->id ?>" data-id_original="<?= $cita->id ?>" style="margin:5px; min-width:63px"><?= $vehiculos->matricula ?></button>
								<?php endforeach; ?>
							</div>
						<hr>
						</div>
						<div class=col-md-12>
							<h4 class="m-top-10" style="margin-bottom:0px;">Citas pendientes del vehiculo</h4>
							<br>
							<div id="mensaje_tabla_citas">
								<span style="margin: 10px; color: grey;">Seleccione un vehiculo</span>
							</div>
							<div id="activador_tabla_citas" style="display: none;">
								<table class="table table-striped tabla_citas" id="tabla_citas">
									<thead>
										<tr>
											<th>ID</th>
											<th>fecha</th>
											<th>hora</th>
											<th>Tarea</th>
											<th>T. Estimado</th>
											<th>estado</th>
										</tr>
									</thead>
									<tbody id="cuerpo_tabla">
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>
</div>


<?php $this->load->view('include/modal_add_cita'); ?>
<?php $this->load->view('include/modal_recogida'); ?>
