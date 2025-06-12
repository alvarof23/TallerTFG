
<ul class="panel-controls">
	<?php if($acceso[1]==1): ?>
		<li>
			<button type="button" class="btn btn-primary activarModal" data-toggle="modal" data-target="#modal_form" title="Crear vehiculo" style="border-radius: 100%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
				<i class="fa fa-plus"></i>
			</button>
		</li>
		<li>
			<a href="#" class="btn-thinner mostrar_filtros" name="btn_filtros"><span class="fa fa-filter"></span></a>
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

<!-- -->
	<?php
		// USARLO MAS ADELANTE PARA DIFERENCIAR DESDE DONDE VIENE EL FILTRO 
		// $data['origen'] = 'vehiculos/modificar'; 
		 $this->load->view('include/filtro', $data);
	?>
<!-- -->

			<div class="col-md-12 table-responsive m-top-10">
				<?php if (isset($list_vehiculos) && $list_vehiculos!=0): ?>
					<table class="table tabla_vehiculos" id="tablaVehiculos">
						<thead>
							<tr>
								<th>ID</th>
								<th>Cliente</th>
								<th>Marca</th>
								<th>Modelo</th>
								<th>Imagen</th>
								<th>Número Bastidor</th>
								<th>Color</th>
								<th>Matricula</th>
								<th>Fecha mant básico</th>
								<th>Fecha mant completo</th>
								<th>Fecha Matriculacion</th>
								<th></th>
							</tr>
						</thead>
						<?php $this->load->view('include/tabla_cuerpo'); ?>
					</table>
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

<?php $this->load->view('include/modal_form'); ?>
<?php $this->load->view('include/modal_form_cita'); ?>
<?php $this->load->view('include/modal_Imagen'); ?>
<?php $this->load->view('include/modal_tiene_cita'); ?>
