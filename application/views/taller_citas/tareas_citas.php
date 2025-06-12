
<ul class="panel-controls">
	<?php if($acceso[1]==1): ?>
		<li>
			<button type="button" class="btn btn-primary activarModal" data-toggle="modal" data-target="#modal_form" title="Crear vehiculo" style="border-radius: 100%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
				<i class="fa fa-plus"></i>
			</button>
		</li>
	<?php endif ?>
</ul> 
<div class="panel panel-default" style="border-top:none;">
	<?php if(isset($acceso[1]) && $acceso[1]==1): ?>
		<?php if(isset($_POST['nuevo-tipos-tareas'])): ?>
			<div class="col-md-12"><?= validation_errors(); ?></div>  
			<?php if(isset($error_subida_archivo) && $error_subida_archivo) echo $error_subida_archivo; ?>
		<?php endif ?>
		<div class="panel-body">
			<div class="col-md-12 table-responsive m-top-10">
				<?php if (isset($list_citas) && $list_citas!=0): ?>
					<div class="row">
						<div class="col-md-5">
							<h2>Citas</h2>
							<table class="table table-bordered" id="tablaCitas">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_vehiculo</th>
										<th>estado</th>
										<th>fecha</th>
										<th>hora</th>
										<th>id_tarea</th>
									</tr>
								</thead>
								<tbody>
									<!-- Aquí deberías cargar las filas dinámicamente -->
									<?php foreach($list_citas as $cita): ?>
										<tr>
											<td><?= $cita->id ?></td>
											<td><?= $cita->id_vehiculo ?></td>
											<td><?= $cita->estado ?></td>
											<td><?= $cita->fecha ?></td>
											<td><?= $cita->hora ?></td>
											<td><?= $cita->id_tarea ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<div class="col-md-2 d-flex justify-content-center align-items-center">
							<div class="text-center">
								<button class="btn btn-sm btn-success pasar-a-tareas mb-2">→</button><br>
								<button class="btn btn-sm btn-danger volver-a-citas-directo">←</button>
							</div>
						</div>


						<div class="col-md-5">
							<h2>Tareas</h2>
							<table class="table table-bordered" id="tablaTareas">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_vehiculo</th>
										<th>estado</th>
										<th>fecha</th>
										<th>hora</th>
										<th>id_tarea</th>
									</tr>
								</thead>
								<tbody>
									<!-- Esta tabla empieza vacía -->
								</tbody>
							</table>
						</div>
					</div>

				<?php else: ?>	
					<div role="alert" class="alert alert-warning">
						<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Cerrar</span></button>
						<strong><i class="fa fa-warning"></i></strong> Esta sección no tiene datos para mostrar.
					</div>	
				<?php endif ?>
			</div>
		</div>
	<?php endif ?>
</div>

<script>
$(document).ready(function () {
	// Inicializar ambas tablas con DataTables y orden por fecha y hora
	let tablaCitas = $('#tablaCitas').DataTable({
		order: [[3, 'asc'], [4, 'asc']], // Columna 3 = fecha, columna 4 = hora
	});

	let tablaTareas = $('#tablaTareas').DataTable({
		order: [[3, 'asc'], [4, 'asc']],
	});

	let filaSeleccionada = null;

	// Manejar selección de fila
	$('#tablaCitas tbody, #tablaTareas tbody').on('click', 'tr', function () {
		$('tr').removeClass('fila-seleccionada');
		$(this).addClass('fila-seleccionada');
		filaSeleccionada = $(this);
	});

	// Mover de citas a tareas
	$('.pasar-a-tareas').click(function () {
		if (filaSeleccionada && filaSeleccionada.closest('table').attr('id') === 'tablaCitas') {
			let datos = tablaCitas.row(filaSeleccionada).data();
			tablaTareas.row.add(datos).draw();
			tablaCitas.row(filaSeleccionada).remove().draw();
			filaSeleccionada = null;
		}
	});

	// Mover de tareas a citas
	$('.volver-a-citas-directo').click(function () {
		if (filaSeleccionada && filaSeleccionada.closest('table').attr('id') === 'tablaTareas') {
			let datos = tablaTareas.row(filaSeleccionada).data();
			tablaCitas.row.add(datos).draw();
			tablaTareas.row(filaSeleccionada).remove().draw();
			filaSeleccionada = null;
		}
	});
});
</script>

<style>
	.fila-seleccionada {
		background-color: #d1ecf1 !important;
		cursor: pointer;
	}
</style>