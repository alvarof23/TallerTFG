<form method="post" action="" class="buscar_form form-horizontal" id="contactForm">

	<div>
		<?php $this->load->view('include/filtro_modal'); ?>
	</div>

		<div class="col-sm-3">
			<label class="col-md-3 col-xs-12 control-label">Buscar</label>
			<div class="col-sm-8">
				<input type="text" name="buscar" class="form-control" id="buscar">
			</div>
		</div>

		<div class="col-sm-3">
			<label class="col-md-3 col-xs-12 control-label">Cliente</label>
			<div class="col-sm-8">
				<select class="form-control select" name="buscarCliente" id="buscarCliente" data-live-search="true">
					<option value="default" selected disabled>Seleccione un cliente</option>
					<option value="">-- No seleccionar --</option>
					<?php foreach ($clientes as $cliente): ?>
						<option value="<?= $cliente->dni ?>">
							<?= $cliente->nombre ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="col-sm-3">
			<label class="col-md-3 col-xs-12 control-label">Matricula</label>
			<div class="col-sm-8">
				<input type="text" name="buscarMatricula" class="form-control" id="buscarMatricula">
			</div>
		</div>

		<div class="col-sm-3 text-right">
			<button class="btn btn-primary" name="submit_filtrar" id="submit_filtrar" type="submit">
				<i class="fa fa-search"></i> Buscar
			</button>

			<button type="submit" name="submit_ver_todos" id="submit_ver_todos" class="btn btn-warning btn-search m-left-20">
				Ver todo
			</button>
		</div>
</form>