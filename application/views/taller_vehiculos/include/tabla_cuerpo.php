<tbody id="cuerpo_tabla">	
	<?php foreach ($list_vehiculos as $vehiculo): ?>
		<tr class="fila_sel fila-vehiculo" data-id="<?= $vehiculo->id ?>"
											data-cliente="<?= $vehiculo->id_cliente ?>"
											data-marca="<?= $vehiculo->marca_id ?>"
											data-modelo="<?= $vehiculo->id_modelo ?>"
											data-matricula="<?= $vehiculo->matricula ?>"
											data-color="<?= $vehiculo->color ?>"
											data-bastidor="<?= $vehiculo->num_bastidor ?>"
											data-fecha_mant_basico="<?= $vehiculo->fecha_mant_basico ?>"
											data-fecha_mant_completo="<?= $vehiculo->fecha_mant_completo ?>"
											data-fecha_matriculacion="<?= $vehiculo->fecha_matriculacion ?>"
		
		>
			<td class="col_sel">
				<?= $vehiculo->id ?>
			</td>
			<td class="col_sel">
				<?= $vehiculo->cliente_nombre ?>
			</td>
			<td class="col_sel">
				<?= $vehiculo->marca_nombre ?>
			</td>
			<td class="col_sel">
				<?= $vehiculo->modelo_nombre ?>
			</td>


			<td class="col_sel">
				<div class="divImgModelo">
					<?php if($vehiculo->nombre_img) : ?>
						<img class="imgModelo" src="<?= base_url('assets/img/taller/'. $vehiculo->nombre_img ); ?>" 
							alt="<?php echo($vehiculo->nombre_img)?>" 
							value="<?php echo($vehiculo->nombre_img)?>" 
							data-url=<?= base_url('assets/img/taller/'. $vehiculo->nombre_img ); ?>
							data-toggle="modal" data-target="#imageModal" 
							style="cursor: pointer;">
					<?php else :?>
						<p>Imagen principal sin asignar</p>
					<?php endif; ?>
				</div>
			</td>



			<td class="col_sel">
				<?= $vehiculo->num_bastidor ?>
			</td>
			<td class="col_sel">
				<?= $vehiculo->color ?>
			</td>
			<td class="col_sel">
				<?= $vehiculo->matricula ?>
			</td>
			<td class="col_sel">
				<?= $vehiculo->fecha_mant_basico ?>
			</td>
			<td class="col_sel">
				<?= $vehiculo->fecha_mant_completo ?>
			</td>
			<td class="col_sel">
				<?= $vehiculo->fecha_matriculacion ?>
			</td>
			<td class="col_sel" id="columna_botones">
				<div id="div_botones">
					<?php if (isset($vehiculo->id) && $vehiculo->id != 0): ?>
						<!-- Botón de edición -->
						<button type="button" class="btn btn-primary editarModal" data-toggle="modal" data-target="#modal_form" title="Editar" id="boton_vehiculos">
							<i class="fa fa-edit"></i>
						</button>

						<?php if (isset($vehiculo->tiene_cita) && $vehiculo->tiene_cita != 1): ?>
							<!-- Enlace para pedir cita al vehículo -->
							<button type="button" class="btn btn-primary fichaModal" data-toggle="modal" data-target="#modal_ficha" id="boton_vehiculos">
								<i class="fa fa-clipboard"></i>
							</button>

						<?php elseif (isset($vehiculo->tiene_cita) && $vehiculo->tiene_cita == 1): ?>
							<button type="button" class="btn btn-primary fichaModal" data-toggle="modal" data-target="#modal_ficha" id="boton_vehiculos" style="background-color: green; border-color: #449d48;" data-info="tiene_cita">
								<i class="fa fa-clipboard"></i>
							</button>
						<?php endif ?>

						<!-- Enlace para eliminar el vehículo -->
						<?= anchor('vehiculos/delete/'.$vehiculo->id, '<span class="fa fa-trash"></span>', 'class="text-danger delete" id="boton_vehiculos" data-placement="top" data-toggle="tooltip" data-original-title="Borrar vehiculo"') ?>
					<?php endif ?>
				</div>
			</td>

			
		</tr>
	<?php endforeach ?>
</tbody>