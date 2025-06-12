<tbody id="cuerpo_tabla">
	<?php foreach($list_citas as $cita): ?>
		<?php $estado_legible = ucwords(str_replace('_', ' ', $cita->estado)); ?>

		<tr class="fila_sel fila-cita"
			data-id="<?= $cita->id ?>"
			data-id_vehiculo="<?= $cita->id_vehiculo ?>"
			data-estado="<?= $cita->estado ?>"
			data-fecha="<?= $cita->fecha ?>"
			data-hora="<?= $cita->hora ?>"
			data-id_tarea="<?= $cita->id_tarea ?>"
			data-id_cliente="<?= $cita->id_cliente ?>"
		>
			<td class="col_sel"><?= $cita->id ?></td>
			<td class="col_sel"><?= $cita->id_cliente ?></td>
			<td class="col_sel"><?= $cita->nombre ?></td>
			<td class="col_sel">
				<?= $cita->matricula ?>
				<?php if($cita->img): ?>
					<button type="button" class="btn btn-primary fichaModal boton_citas imgModelo" alt="<?= $cita->img ?>" title="ver imagen"
							data-url="<?= base_url('assets_app/images/taller/'. $cita->img); ?>"
							style="cursor: pointer;" id="boton_citas">
						<i class="fa fa-car-side"></i>
					</button>
				<?php endif; ?>
			</td>
			<td class="col_sel"><?= $cita->num_bastidor ?></td>
			<td class="col_sel"><?= $cita->fecha ?></td>
			<td class="col_sel"><?= $cita->hora ?></td>
			<td class="col_sel"><?= $cita->descripcion ?></td>
			<td class="col_sel"><?= $cita->tiempo_estimado ?></td>
			<td class="col_sel"><?= $estado_legible ?></td>

			<td class="col_sel">
				<div id="div_botones">
					<?php if($cita->estado !== "Esperando_recepcion"): ?>
						<!-- Botón a la izquierda -->
						<div class="btns-izquierda">
							<a href="<?= base_url('admin.php/citas/detalles/' . $cita->id . '/' . $cita->id_cliente) ?>" class="btn btn-primary boton_citas" id="boton_citas" title="<?= $estado_legible ?>"
								<?php if($cita->estado == "Completada"): ?>
									style="background-color: rgba(0, 255, 0, 0.4)"
								<?php elseif($cita->estado == "Procesando"): ?>
									style="background-color: rgba(255, 255, 0, 0.4)"
								<?php elseif($cita->estado == "Esperando_recepcion"): ?>
									style="background-color: rgb(209, 236, 241)"
								<?php elseif($cita->estado == "Anulada"): ?>
									style="background-color: rgba(255, 0, 0, 0.7)"
								<?php endif ?>
							>
								<i class="fa fa-info" 
									<?php if ($cita->estado == "Completada" || $cita->estado == "Procesando" || $cita->estado == "Esperando_recepcion") : ?>
										style = "color: black"
									<?php endif ?>
								>
								</i>
							</a>
						</div>	

						<!-- Botones a la derecha -->
						<div class="btns-derecha">
							<?php if($cita->estado !== "Entregado"): ?>
								<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas" title="Entregado" data-estado="Entregado" data-toggle="modal" data-target="#modal_ficha" id="boton_citas">
									<i class="fa fa-car-side"></i>
								</button>
							<?php endif ?>
							<?php if($cita->estado !== "Completada") : ?>
								<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas" title="Completada" data-estado="Completada" data-toggle="modal" data-target="#modal_ficha" id="boton_citas">
									<i class="fa fa-flag-checkered"></i>
								</button>
							<?php endif ?>
							<?php if($cita->estado !== "Procesando") : ?>
								<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas" title="Procesando" data-estado="Procesando" data-toggle="modal" data-target="#modal_ficha" id="boton_citas">
									<i class="fa fa-wrench"></i>
								</button>
							<?php endif ?>
							<?php if($cita->estado !== "Esperando_recepcion") : ?>
								<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas" title="Esperando recepcion" data-estado="Esperando_recepcion" data-toggle="modal" data-target="#modal_ficha" id="boton_citas">
									<i class="fa fa-bell-concierge"></i>
								</button>
							<?php endif ?>
							<?php if($cita->estado !== "Anulada") : ?>
								<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas" title="Anulada" data-estado="Anulada" data-toggle="modal" data-target="#modal_ficha" id="boton_citas">
									<i class="fa fa-ban"></i>
								</button>
							<?php endif ?>
						</div>

					<?php else: ?>
						<!-- Botón a la izquierda -->
						<div class="btns-izquierda">
							<a href="<?= base_url('admin.php/citas/detalles/' . $cita->id . '/' . $cita->id_cliente) ?>" class="btn btn-primary boton_citas" id="boton_citas" title="<?= $estado_legible ?>" style="background-color: rgb(209, 236, 241)">
								<i class="fa fa-info" style = "color: black">
								</i>
							</a>
						</div>	

						<!-- Botones a la derecha -->
						<div class="btns-derecha">
							<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas" title="Anulada" data-estado="Anulada" data-toggle="modal" data-target="#modal_ficha" id="boton_citas">
								<i class="fa fa-ban"></i>
							</button>
						</div>
					<?php endif ?>

				</div>
			</td>

		</tr>
	<?php endforeach; ?>
</tbody>
