<?php $this->load->view('include/Header'); ?>

<ul class="panel-controls list-unstyled d-flex justify-content-center align-items-center gap-3 p-3">

	<li>
		<button type="button" class="btn btn-primary activar_modal_add" data-toggle="modal" data-target="#modal_form"
			title="Crear cita"
			style="border-radius: 100%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
			<i class="fa fa-plus"></i>
		</button>
	</li>
	<li>
		<a href="#" class="btn-thinner mostrar_filtros" name="btn_filtros"><span class="fa fa-filter"></span></a>
	</li>
</ul>

<div class="panel panel-default" style="border-top:none;">
	<?php if (isset($_POST['nuevo-tipos-tareas'])): ?>
		<div class="col-md-12"><?= validation_errors(); ?></div>
		<?php if (isset($error_subida_archivo) && $error_subida_archivo)
			echo $error_subida_archivo; ?>
	<?php endif ?>
	<div class="panel-body">
		<div class="d-flex justify-content-center align-items-center" style="margin-top: 20px; width: 100%;">

			<div class="col-md-11 col-xs-12 m-top-10">
				<?php
				$this->load->view('taller_citas/include/filtro');
				?>
			</div>
		</div>
		<div class="d-flex justify-content-center align-items-center" style="margin-top: 20px; width: 100%;">
			<div class="col-md-11 table-responsive m-top-10">
				<?php if (isset($list_citas) && $list_citas != 0): ?>
					<table class="table table-striped tabla_citas " id="tablaCitas">
						<thead>
							<tr>
								<th>ID</th>
								<th>Cliente</th>
								<th>Nombre</th>
								<th>matricula</th>
								<th>bastidor</th>
								<th>fecha</th>
								<th>hora</th>
								<th>Tarea</th>
								<th>T. Estimado</th>
								<th>estado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<?php $this->load->view('taller_citas/include/tabla_cuerpo'); ?>

					</table>
				<?php else: ?>
					<div role="alert" class="alert alert-warning">
						<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span
								class="sr-only">Cerrar</span></button>
						<strong><i class="fa fa-warning"></i></strong> Esta sección no tiene datos para mostrar.
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view('taller_citas/include/modal_imagen'); ?>
<?php $this->load->view('taller_citas/include/modal_add_cita'); ?>


<?php $this->load->view('include/Footer'); ?>