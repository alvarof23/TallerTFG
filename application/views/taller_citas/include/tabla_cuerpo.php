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
			<?php
				$opacidad = $cita->estado;
			?>
			<td class="col_sel"><?= $cita->id ?></td>
			<td class="col_sel"><?= $cita->id_cliente ?></td>
			<td class="col_sel"><?= $cita->nombre ?></td>
			<td class="col_sel">
				<?= $cita->matricula ?>
				<?php if($cita->img): ?>
					<button type="button" class="btn btn-primary fichaModal boton_citas imgModelo" alt="<?= $cita->img ?>" title="ver imagen"
							data-url="<?= base_url('assets/img/taller/'. $cita->img); ?>"
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
					<!-- Botón a la izquierda -->
					<div class="btns-izquierda">
						<a href="<?= base_url('taller_citas/detalles/' . $cita->id . '/' . $cita->id_cliente) ?>" 
						class="btn btn-primary boton_citas" 
						id="boton_citas" 
						title="<?= $estado_legible ?>"
						style="
							<?php if($cita->estado == "Completada"): ?>
								background-color: rgba(0, 255, 0, 0.4);
							<?php elseif($cita->estado == "Procesando"): ?>
								background-color: rgba(255, 255, 0, 0.4);
							<?php elseif($cita->estado == "Esperando_recepcion"): ?>
								background-color: rgb(209, 236, 241);
							<?php elseif($cita->estado == "Anulada"): ?>
								background-color: rgba(255, 0, 0, 0.7);
							<?php endif ?>
						">
							<i class="fa fa-info" 
								<?php if(in_array($cita->estado, ["Completada", "Procesando", "Esperando_recepcion"])): ?>
									style = "color: black"
								<?php endif ?>>
							</i>
						</a>
					</div>	

					<!-- Botones a la derecha -->
					<div class="btns-derecha">
						<?php
							$estados_posibles = [
								"Entregado" => "car-side",
								"Completada" => "flag-checkered",
								"Procesando" => "wrench",
								"Anulada" => "ban",
							];

							if ($cita->estado !== "Esperando_recepcion" && $cita->estado !== "Anulada") {
								// Mostrar todos menos el actual
								foreach ($estados_posibles as $estado => $icono) {
									if ($estado !== $cita->estado) {
										echo '<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas"
												title="'.$estado.'"
												data-estado="'.$estado.'"
												data-toggle="modal" data-target="#modal_ficha" id="boton_citas">
												<i class="fa fa-'.$icono.'"></i>
											</button>';
									}
								}
							} elseif ($cita->estado === "Esperando_recepcion") {
								// Solo mostrar botón "Anulada"
								echo '<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas"
										title="Anulada"
										data-estado="Anulada"
										data-toggle="modal" data-target="#modal_ficha" id="boton_citas">
										<i class="fa fa-ban"></i>
									</button>';
							} elseif ($cita->estado === "Anulada") {
								if (isset($hay_recepciones) and $hay_recepciones) {
									// Mostrar todos menos "Anulada"
									foreach ($estados_posibles as $estado => $icono) {
										if ($estado !== "Anulada") {
											echo '<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas"
													title="'.$estado.'"
													data-estado="'.$estado.'"
													data-toggle="modal" data-target="#modal_ficha" id="boton_citas">
													<i class="fa fa-'.$icono.'"></i>
												</button>';
										}
									}
								} else {
									// Solo mostrar botón "Esperando_recepcion"
									echo '<button type="button" class="btn btn-primary fichaModal btn_estado boton_citas"
											title="Esperando recepción"
											data-estado="Esperando_recepcion"
											data-toggle="modal" data-target="#modal_ficha" id="boton_citas">
											<i class="fa fa-bell-concierge"></i>
										</button>';
								}
							}
						?>
					</div>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
</tbody>
