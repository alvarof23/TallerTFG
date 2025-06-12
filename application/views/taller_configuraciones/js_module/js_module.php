<script>

	document.addEventListener("DOMContentLoaded", function() {

		function cargarConfiguraciones() {
			$.ajax({
				url: '<?= site_url("taller_configuraciones/get_conf") ?>',
				method: 'GET',
				dataType: 'json',
				success: function(configuraciones) {
					var html = '';
					configuraciones.forEach(function(conf, i) {
						html += `
							<div class="panel panel-info">
								<a data-toggle="collapse" data-parent="#accordion_conf" href="#accordion_conf${i}">      
									<div class="panel-heading">
										<h4 class="panel-title">
											Configuración (${conf.id})
										</h4>
									</div>
								</a>
								<div id="accordion_conf${i}" class="panel-collapse collapse">
									<div class="panel-body">
										<form method="post" action="<?= site_url('taller_configuraciones/guardar_area/') ?>${conf.id}" class="well well-sm">
											<input type="hidden" name="id" value="${conf.id}">
											<div class="form-group">
												<label>Hora Inicio</label>
												<input type="time" name="hora_inicio" value="${conf.hora_inicio}" class="form-control">
											</div>
											<div class="form-group">
												<label>Hora Fin</label>
												<input type="time" name="hora_fin" value="${conf.hora_fin}" class="form-control">
											</div>
											<div class="form-group">
												<label>Duración Intervalo (min)</label>
												<input type="time" name="duracion_intervalo" value="${conf.duracion_intervalo}" class="form-control">
											</div>
											<div class="form-group">
												<label>Simultaneidad</label>
												<input type="number" name="simultaneo" value="${conf.simultaneo}" class="form-control">
											</div>
											<button class="btn btn-success btn-sm editar_conf">Guardar Área</button>
											<button type="button" class="btn btn-danger btn-sm eliminar_conf" data-id="${conf.id}">Eliminar Configuración</button>
										</form>
									</div>
								</div>
							</div>
						`;
					});
					$('#accordion_conf').html(html);
				},
				error: function() {
					alert('Error al cargar las configuraciones.');
				}
			});
		}

		// Cargar cuando se muestra la pestaña
		$('a[href="#configuraciones"]').on('shown.bs.tab', function () {
			cargarConfiguraciones();
		});

		$('#btn_nueva_conf').on('click', function() {
			$('#formCrearConfiguracion')[0].reset(); // limpia el formulario
			$('#modalCrearConfiguracion').modal('show');
		});

		$(document).on('submit', '#formCrearConfiguracion', function (event) {
			event.preventDefault();

			var datos = $(this).serialize();
			console.log(datos);

			$.ajax({
				url: '<?= site_url("taller_configuraciones/guardar_configuracion") ?>', // Cambia la ruta según tu controlador
				type: 'POST',
				data: datos,
				dataType: 'json',
				success: function(response) {
				if (response.status === 'success') {
					alert('Configuración creada correctamente.');
					$('#modalCrearConfiguracion').modal('hide');
					cargarConfiguraciones();
				} else {
					alert('Error al crear la configuración: ' + response.message);
				}
				},
				error: function() {
				alert('Error en la solicitud AJAX.');
				}
			});
		});
		
		$(document).on('click', '.editar_conf', function (event) {
			event.preventDefault(); // evitar envío tradicional del formulario

			var form = $(this).closest('form');

			// validar el formulario
			if (form[0].checkValidity()) {
				// obtener datos del formulario
				var id = form.find('[name="id"]').val();
				var hora_inicio = form.find('[name="hora_inicio"]').val();
				var hora_fin = form.find('[name="hora_fin"]').val();
				var duracion_intervalo = form.find('[name="duracion_intervalo"]').val();
				var simultaneo = form.find('[name="simultaneo"]').val();

				var datos = {
					id: id,
					hora_inicio: hora_inicio,
					hora_fin: hora_fin,
					duracion_intervalo: duracion_intervalo,
					simultaneo: simultaneo
				};

				$.ajax({
					url: '<?= base_url("taller_configuraciones/editar_configuracion") ?>', // ajusta la URL según controlador/método
					type: 'POST',
					data: datos,
					dataType: 'json',
					success: function(response) {
						if (response.status === "success") {
							alert('Configuración actualizada correctamente.');
							cargarConfiguraciones();
						} else {
							alert('Error al actualizar la configuración: ' + response.message);
						}
					},
					error: function() {
						alert('Error en la solicitud AJAX.');
					}
				});
			} else {
				form[0].reportValidity(); // mostrar mensajes nativos de validación
			}
		});

		$(document).on('click', '.eliminar_conf', function (event) {
			var confId = $(this).data('id');

			if (!confirm('¿Estás seguro que deseas eliminar esta configuración?')) {
				return; // Cancelar si no confirma
			}

			$.ajax({
				url: '<?= site_url("taller_configuraciones/eliminar_configuracion") ?>',
				type: 'POST',
				data: { id: confId },
				dataType: 'json',
				success: function(response) {
					if (response.status === 'success') {
						alert('Configuración eliminada correctamente.');
						cargarConfiguraciones();
					} else {
						alert('Error al eliminar la configuración: ' + response.message);
					}
				},
				error: function() {
					alert('Error en la solicitud AJAX.');
				}
			});
		});

		/*
		TAREAS------------------------------------------------------------------------------------------------------------------------------
		*/

		function cargarnavTareas() {
			$.ajax({
				url: '<?= site_url("taller_configuraciones/get_Tarea") ?>',
				method: 'GET',
				dataType: 'json',
				success: function(tareas) {
					const idsProcesados = new Set();
					let html = '';

					// Construimos los tabs (li > a)
					tareas.forEach(function(tarea) {
						if (!idsProcesados.has(tarea.id)) {
							html += `
								<li>
									<a href="#area${tarea.id}" aria-controls="area${tarea.id}"
										data-toggle="tab" role="tab" data-area-id="${tarea.id}">
										${tarea.nombre}
									</a>
								</li>
							`;
							idsProcesados.add(tarea.id);
							primera = false;
						}
					});

					$('#nav_tareas').html(html);

					// Ahora creamos el contenedor vacío para cada área, con clases y IDs necesarios
					let htmlContent = '';
					primera = true;
					idsProcesados.forEach(id => {
						htmlContent += `
							<div role="tabpanel" class="tab-pane fade ${primera ? 'in active' : ''}" id="area${id}" style="padding:10px;">
								<p class="text-muted"><em>Selecciona la pestaña para cargar tareas...</em></p>
							</div>
						`;
						primera = false;
					});
					$('#tab_content_tareas').html(htmlContent);
				},
				error: function() {
					alert('Error al cargar las áreas de trabajo.');
				}
			});
		}

		// Cargar las pestañas cuando se muestra la pestaña padre "#tareas"
		$('a[href="#tareas"]').on('shown.bs.tab', function () {
			cargarnavTareas();
		});

		// Cargar contenido al mostrar la pestaña específica de área
		$(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
			const areaId = $(this).data('area-id');
			if (!areaId) return;
			cargarTareas(areaId);
			
		});


		function cargarTareas(areaId) {
			$.ajax({
				url: '<?= site_url("taller_configuraciones/get_Tarea_area") ?>',
				method: 'GET',
				dataType: 'json',
				success: function(tareas) {
					const tareasArea = tareas.filter(t => t.id_area_trabajo == areaId);
					let html = '';

					if (tareasArea.length > 0) {
						// Como todas las tareas pertenecen a la misma área, solo un panel
						html += `
							<div class="panel panel-default">
								<div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
									<strong>${tareasArea[0].nombre || 'Área'} - Tareas</strong>
									<button class="btn btn-primary btn-sm add_tarea" data-area-id="${areaId}" type="button"
										style="border-radius: 50%; width: 30px; height: 30px; padding: 0; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center;">
										<i class="fa fa-plus"></i>
									</button>
								</div>
								<div class="panel-body panel-body-tareas">
						`;

						tareasArea.forEach(tarea => {
							html += `
								<form class="form_tareas well well-sm">
									<input type="hidden" name="id" id="id_area" value="${tarea.id_tarea}">
									<div class="form-group"><label>Descripción</label>
										<input type="text" name="descripcion" id="descripcion" value="${tarea.descripcion}" class="form-control">
									</div>
									<div class="form-group"><label>Tiempo Estimado</label>
										<input type="time" name="tiempo_estimado" id="tiempo_estimado" value="${tarea.tiempo_estimado}" class="form-control">
									</div>
									<div class="form-group"><label>Precio Unitario (€)</label>
										<input type="number" name="precio_unitario" step="0.01" id="precio_unitario" value="${tarea.precio_unitario}" class="form-control">
									</div>
									<div class="form-group"><label>Max. Unidades</label>
										<input type="number" name="max_unidades" id="max_unidades" value="${tarea.max_unidades}" class="form-control">
									</div>
									<div class="form-group"><label>¿Externa?</label>
										<select name="externa" class="form-control" id="externa">
											<option value="0" ${tarea.externa == 0 ? 'selected' : ''}>No</option>
											<option value="1" ${tarea.externa == 1 ? 'selected' : ''}>Sí</option>
										</select>
									</div>
									<button type="button" class="btn btn-primary btn-sm editar_tarea" data-id="${tarea.id_tarea}">Guardar Tarea</button>
									<button type="button" class="btn btn-danger btn-sm eliminar-tarea" data-id="${tarea.id_tarea}">
										<i class="fa fa-trash"></i> Eliminar
									</button>
								</form>
							`;
						});

						html += '</div></div>'; // Cerrar panel-body y panel
					} else {
						html += `<p class="text-muted"><em>No hay tareas asociadas a esta área.</em></p>`;
					}

					$(`#area${areaId}`).html(html);
				},
				error: function() {
					alert('Error al cargar las tareas del área.');
				}
			});
		}


		$(document).on('click', '.add_tarea', function (event) {
			// Limpiar el formulario
			$('#formNuevaTarea')[0].reset();

			var areaId = $(this).data('area-id');
			$('#m_id_area').val(areaId);

			// Cambiar el título del modal (opcional, ya está en el HTML)
			$('#modalNuevaTareaLabel').text('Añadir Nueva Tarea');

			// Mostrar el modal
			$('#modalNuevaTarea').modal('show');
		});

		$(document).on('click', '.editar_tarea', function (event) {
			event.preventDefault(); // Evitar el envío del formulario

			var form = $(this).closest('form');

			// Validar el formulario
			if (form[0].checkValidity()) {
				// Recoger los datos
				var id = form.find('[name="id"]').val();
				var descripcion = form.find('[name="descripcion"]').val();
				var tiempo_estimado = form.find('[name="tiempo_estimado"]').val();
				var precio_unitario = form.find('[name="precio_unitario"]').val();
				var max_unidades = form.find('[name="max_unidades"]').val();
				var externa = form.find('[name="externa"]').val();

				var datos = {
					id,
					descripcion,
					tiempo_estimado,
					precio_unitario,
					max_unidades,
					externa
				};

				$.ajax({
					url: '<?= base_url('taller_configuraciones/editar_tarea') ?>',
					type: 'POST',
					data: datos,
					dataType: "json",
					success: function(response) {
						if (response.status == "success") {
							alert('Tarea actualizada correctamente.');
							cargarTareas(id);
						} else {
							alert('Error al actualizar la tarea.');
						}
					},
					error: function() {
						alert('Error en la solicitud AJAX.');
					}
				});
			} else {
				form[0].reportValidity(); // Mostrar mensaje de validación HTML5
			}
		});

		$(document).on('click', '.guardar_tarea', function (event) {

			// Prevenir el envío normal del formulario
			event.preventDefault();
			const tareaId = $(this).data('id');

			
			// Validar el formulario
			if ($('#formNuevaTarea')[0].checkValidity()) {
				var descripcion = $('#m_descripcion').val();
				var id_area = $('#m_id_area').val();
				var tiempo_estimado = $('#m_tiempo_estimado').val();
				var precio_unitario = $('#m_precio_unitario').val();
				var max_unidades = $('#m_max_unidades').val();
				var externa = $('#m_externa').val();

				var datos = {
					descripcion, id_area, tiempo_estimado, precio_unitario, max_unidades, externa
				};

				$.ajax({
					url: '<?= base_url('taller_configuraciones/guardar_tarea') ?>', // Asegúrate de tener esta ruta configurada
					type: 'POST',
					data: datos,
					dataType: "json",
					success: function(response) {
						if (response.status == "success") {
							$('#modalNuevaTarea').modal('hide');
							cargarTareas(id_area);


						} else {
							alert('Error al guardar la tarea.');
						}
					},
					error: function() {
						alert('Error en la solicitud AJAX.');
					}
				});

			} else {
				alert('Por favor, completa todos los campos requeridos.');
			}
		});

		$(document).on('click', '.eliminar-tarea', function (event) {
			event.preventDefault();

			const tareaId = $(this).data('id');
			console.log(tareaId);

				var id_area = $('#m_id_area').val();

				$.ajax({
					url: '<?= base_url('taller_configuraciones/eliminar_tarea') ?>',
					type: 'POST',
					data: { id: tareaId },
					dataType: 'json',
					success: function(response) {
						if (response.status == "success") {
							alert('Tarea eliminada correctamente.');
							cargarTareas(id_area);

						} else {
							alert('Error al eliminar la tarea.');
						}
					},
					error: function() {
						alert('Error en la solicitud AJAX.');
					}
				});
		});

/*
		AREAS------------------------------------------------------------------------------------------------------------------------------
		*/

		function cargarAreas() {
			$.ajax({
				url: '<?= site_url("taller_configuraciones/get_areas") ?>',
				method: 'GET',
				dataType: 'json',
				success: function(data) {
					var areas = data.areas;
					var configuraciones = data.configuraciones;

					// Guarda configuraciones global para luego pintarlas en los selects
					window.configuraciones = configuraciones;

					// Aquí pintas las áreas y usas configuraciones para el select
					var html = '';
					$.each(areas, function(i, area) {
						html += `
						<div class="panel panel-info">
							<a data-toggle="collapse" data-parent="#accordion_areas" href="#collapse_area${i}">
								<div class="panel-heading">
									<h4 class="panel-title">
										${area.nombre} (${area.codigo})
									</h4>
								</div>
							</a>
							<div id="collapse_area${i}" class="panel-collapse collapse">
								<div class="panel-body">
									<form class="well well-sm form_area" data-area-id="${area.id}">
										<input type="hidden" name="id" value="${area.id}">

										<div class="form-group">
											<label>Nombre</label>
											<input type="text" name="nombre" value="${area.nombre}" class="form-control">
										</div>

										<div class="form-group">
											<label>Código</label>
											<input type="text" name="codigo" value="${area.codigo}" class="form-control">
										</div>

										<div class="form-group">
											<label>Configuración</label>
											<select class="form-control" name="id_configuracion" required>
												<option value="">Seleccione una configuración</option>
												${configuraciones.map(conf => `
													<option value="${conf.id}" ${conf.id == area.id_configuracion ? 'selected' : ''}>
														Configuración ${conf.id}
													</option>
												`).join('')}
											</select>
										</div>

										<button type="button" class="btn btn-success btn-sm editar_area">Guardar Área</button>
										<button type="button" class="btn btn-danger btn-sm eliminar_area" data-area-id="${area.id}">Eliminar Área</button>
									</form>
								</div>
							</div>
						</div>
						`;
					});

					$('#accordion_areas').html(html);
				},
				error: function() {
					alert('Error al cargar las áreas.');
				}
			});
		}


		// Cargar cuando se muestra la pestaña
		$('a[href="#areas"]').on('shown.bs.tab', function () {
			cargarAreas();

		});

		$(document).on('click', '#btn_nueva_area', function (event) {
			$('[name="nombre"]').val('');
			$('[name="codigo"]').val('');
			$('#area_configuracion option[value = ""').prop('selected', true);
			$('#area_configuracion').trigger('change');

			$('#modalCrearArea').modal('show');
		});

		$(document).on('submit', '#formCrearArea', function (event) {
			event.preventDefault();

			var formData = $(this).serialize(); // Serializa todos los inputs del formulario
			console.log(formData);

			$.ajax({
				url: '<?= site_url('taller_configuraciones/guardar_area') ?>', // Cambia esta URL
				method: 'POST',
				data: formData,
				success: function(response) {
					$('#modalCrearArea').modal('hide');
					cargarAreas();

				},
				error: function(xhr) {
					console.log('Error al guardar');
				}
			});
		});

		$(document).on('click', '.editar_area', function(event) {
			event.preventDefault();

			var form = $(this).closest('form');

			if (form[0].checkValidity()) {
				// Recoger datos del formulario
				var datos = {
					id: form.find('[name="id"]').val(),
					nombre: form.find('[name="nombre"]').val(),
					codigo: form.find('[name="codigo"]').val(),
					id_configuracion: form.find('select[name="id_configuracion"]').val(),
				};

				$.ajax({
					url: '<?= site_url('taller_configuraciones/editar_area') ?>',
					type: 'POST',
					data: datos,
					dataType: "json",
					success: function(response) {
						if (response.status === "success") {
							alert('Área actualizada correctamente.');
							cargarAreas();
						} else {
							alert('Error al actualizar el área.');
						}
					},
					error: function() {
						alert('Error en la solicitud AJAX.');
					}
				});
			} else {
				form[0].reportValidity();
			}
		});

		$(document).on('click', '.eliminar_area', function(event) {
			var area_id = $(this).data('area-id');

			if (!confirm('¿Estás seguro de que deseas eliminar esta área?')) {
				return;
			}

			$.ajax({
				url: '<?= site_url('taller_configuraciones/eliminar_area') ?>',
				type: 'POST',
				data: { id: area_id },
				dataType: "json",
				success: function(response) {
					if (response.status === "success") {
						alert('Área eliminada correctamente.');
						cargarAreas();
					} else {
						alert('Error al eliminar el área.');
					}
				},
				error: function() {
					alert('Error en la solicitud AJAX.');
				}
			});
		});




		$('a[href="#productos_tarea"]').on('shown.bs.tab', function () {
			// Resetear select_tarea y ocultar tabla
			$('#select_tarea')
				.html('<option value="">-- Selecciona primero un área --</option>')
				.prop('disabled', true)
				.selectpicker('refresh');  // refrescar selectpicker

			$('#productos_tarea_table_container').hide();

			$.ajax({
				url: '<?= site_url("taller_configuraciones/get_Areas") ?>',
				method: 'GET',
				dataType: 'json',
				success: function(data) {
					var areas = data.areas;
					var options = '<option value="">-- Selecciona un área --</option>';
					areas.forEach(function(area) {
						options += '<option value="'+area.id+'">'+area.nombre+'</option>';
					});
					$('#select_area').html(options).prop('disabled', false).selectpicker('refresh');
				},
				error: function() {
					alert('Error al cargar las áreas.');
				}
			});
		});

		// Cuando se selecciona un área, cargar tareas
		$('#select_area').on('changed.bs.select', function() {  // evento específico de selectpicker
			var areaId = $(this).val();

			$('#select_tarea')
				.prop('disabled', true)
				.html('<option>Cargando tareas...</option>')
				.selectpicker('refresh');

			$('#productos_tarea_table_container').hide();

			if (!areaId) {
				$('#select_tarea')
					.html('<option>-- Selecciona primero un área --</option>')
					.prop('disabled', true)
					.selectpicker('refresh');
				return;
			}

			$.ajax({
				url: '<?= site_url("taller_configuraciones/get_tareas_por_area") ?>',
				method: 'POST',
				data: { area_id: areaId },
				dataType: 'json',
				success: function(tareas) {
					if (tareas.length === 0) {
						$('#select_tarea')
							.html('<option>-- No hay tareas para esta área --</option>')
							.prop('disabled', true)
							.selectpicker('refresh');
						return;
					}
					var options = '<option value="">-- Selecciona una tarea --</option>';
					tareas.forEach(function(tarea) {
						options += '<option value="'+tarea.id+'">'+tarea.descripcion+'</option>';
					});
					$('#select_tarea')
						.html(options)
						.prop('disabled', false)
						.selectpicker('refresh');
				},
				error: function() {
					alert('Error al cargar las tareas.');
					$('#select_tarea')
						.html('<option>-- Error cargando tareas --</option>')
						.prop('disabled', true)
						.selectpicker('refresh');
				}
			});
		});

		// Cuando se selecciona una tarea, cargar productos
		$('#select_tarea').on('changed.bs.select', function() {
			var tareaId = $(this).val();
			$('#productos_tarea_table tbody').empty();
			$('#productos_tarea_table_container').hide();

			$('.add_producto').attr('data-tarea-id', tareaId);

			if (!tareaId) return;

			cargarProductos(tareaId);
		});


		// Abrir modal y poner id de tarea
		$('#btnCrearProducto').on('click', function() {
			var tareaId = $(this).data('tarea-id');
			if (!tareaId) {
				alert('Por favor, selecciona una tarea antes.');
				return;
			}
			$('#producto_id_tarea').val(tareaId);
			$('#formCrearProducto')[0].reset(); // limpiar formulario
			$('#modalCrearProducto').modal('show');
		});

		// Enviar formulario con AJAX
		$('#formCrearProducto').on('submit', function(e) {
			e.preventDefault();

			var formData = $(this).serialize();
			var editar = $('#producto_id').val();

			// Verificamos si editar está vacío o 0
			if (editar == 0 || editar === '' || editar === null) {
				// Crear nuevo producto
				$.ajax({
					url: '<?= site_url("taller_configuraciones/crear_producto") ?>',
					method: 'POST',
					data: formData,
					dataType: 'json',
					success: function(response) {
						if (response.status === 'success') {
							alert('Producto creado correctamente.');
							$('#modalCrearProducto').modal('hide');
							cargarProductos(response.id_tarea);
						} else {
							alert('Error: ' + response.message);
						}
					},
					error: function() {
						alert('Error en la solicitud AJAX.');
					}
				});
			} else {
				var id_tarea = $('#producto_id_tarea').val();
				console.log(formData);
				// Editar producto existente
				$.ajax({
					url: '<?= site_url("taller_configuraciones/editar_producto") ?>',
					method: 'POST',
					data: formData,
					dataType: 'json',
					success: function(response) {
						if (response.status === 'success') {
							alert('Producto actualizado correctamente.');
							$('#modalCrearProducto').modal('hide');
							cargarProductos(id_tarea);
						} else {
							alert('Error: ' + response.message);
						}
					},
					error: function() {
						alert('Error en la solicitud AJAX.');
					}
				});
			}
		});


		function cargarProductos(idTarea) {
			console.log("tarea: "+idTarea);
			$.ajax({
				url: '<?= site_url("taller_configuraciones/get_productos_por_tarea") ?>',
				method: 'POST',
				data: {tarea_id: idTarea},
				dataType: 'json',
				success: function(productos) {
					if (productos.length === 0) {
						$('#productos_tarea_table tbody').html('<tr><td colspan="4">No hay productos para esta tarea.</td></tr>');
					} else {
						let html = '';
						productos.forEach(function(p) {
							html += '<tr>';
							html += '<td>' + p.nombre + '</td>';
							html += '<td>' + (p.descripcion || '') + '</td>';
							html += '<td>' + p.precio + ' €</td>';
							html += '<td>' + p.stock + '</td>';

							html += '<td style="padding: 3px;">';
							html += '<button type="button" class="btn btn-primary editar_producto_Modal" id="boton_vehiculos" data-id="'+ p.id +'" title="Editar">';
							html += '<i class="fa fa-edit"></i></button> ';

							// Botón de eliminar (cambia la URL a la que necesites)
							html += '<button type="button" class="text-danger delete_producto" id="boton_vehiculos" data-id="'+ p.id +'" data-id_tarea="'+ idTarea +'" title="Borrar producto">';
							html += '<i class="fa fa-trash"></i></button> ';
							html += '</td>';
							html += '</tr>';

						});
						$('#productos_tarea_table tbody').html(html);
					}
					$('#productos_tarea_table_container').show();
				},
				error: function() {
					alert('Error al cargar productos.');
				}
			});
		}

		$(document).on('click', '.delete_producto', function(e) {
			e.preventDefault();

			var product_id = $(this).data('id');
			var id_tarea = $(this).data('id_tarea');

			if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
				$.ajax({
					url: '<?= site_url("taller_configuraciones/eliminar_producto") ?>',
					type: 'POST',
					data: { product_id: product_id },
					dataType: 'json',
					success: function(response) {
						if (response.status === 'success') {
							cargarProductos(id_tarea); // recarga la tabla
						} else {
							alert('No se pudo eliminar el producto.');
						}
					},
					error: function() {
						alert('Error de conexión con el servidor.');
					}
				});
			}
		});


		$(document).on('click', '.editar_producto_Modal', function(e) {
			e.preventDefault();

			// Limpiar el formulario
			$('#formCrearProducto')[0].reset();

			var product_id = $(this).data('id');
			$('#producto_id').val(product_id); // Input oculto para saber si es edición

			$.ajax({
				url: '<?= site_url("taller_configuraciones/cargar_producto") ?>',
				type: 'POST',
				data: { product_id: product_id },
				dataType: 'json',
				success: function(response) {
					if (response.status === 'success') {
						const p = response.producto;
						$('#producto_id_tarea').val(p.id_tarea);
						$('#producto_nombre').val(p.nombre);
						$('#producto_descripcion').val(p.descripcion);
						$('#producto_precio').val(p.precio);
						$('#producto_stock').val(p.stock);
					} else {
						alert('No se pudo cargar el producto.');
					}
				},
				error: function() {
					alert('Error de conexión con el servidor.');
				}
			});

			// Cambiar el título del modal
			$('#modalCrearProductoLabel').text('Editar producto Tarea');

			// Mostrar el modal
			$('#modalCrearProducto').modal('show');
		});


		
		function inicializa_tabla() {
			// Vuelve a inicializar el DataTable
			$('#productos_tarea_table').DataTable({
				order: [[0, 'desc']],
				responsive: true,
				autoWidth: false,
				searching: false,
				paging: true,
				lengthChange: false,
				info: true,
				deferRender: true,
				processing: true,
				// scrollY: alturaDisponible + "px",
				// scrollCollapse: true,
				// scrollX: true,
				language: {
					emptyTable: "No se encontraron vehículos con los filtros aplicados.",
					lengthMenu: "Mostrar _MENU_ registros por página",
					zeroRecords: "No se encontraron resultados",
					info: "Página _PAGE_ de _PAGES_",
					infoEmpty: "",
					infoFiltered: "(filtrado de _MAX_ registros totales)",
					search: "Buscar:",
					paginate: {
						first: "Primero",
						last: "Último",
						next: "Siguiente",
						previous: "Anterior"
					}
				}
			})
		}
		inicializa_tabla();


		$('#form_taller').on('submit', function(e) {
			e.preventDefault();

			var formData = new FormData(this);

			$.ajax({
				url: 'taller_configuraciones/guardar_taller',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				dataType: 'json',
				success: function(response) {
					if (response.success) {
						alert('Cambios guardados correctamente.');

						var t = response.taller;

						// Rellenar los campos del formulario con los datos devueltos
						$('#nombre_taller').val(t.nombre);
						$('#telefono').val(t.telefono);
						$('#email').val(t.email);
						$('#direccion').val(t.direccion);
						$('#codigo_postal').val(t.codigo_postal);
						$('#localidad').val(t.localidad);
						$('#provincia').val(t.provincia);
						$('#pais').val(t.pais);
						$('#nif').val(t.nif);
						$('#horario_atencion_cliente').val(t.horario_atencion_cliente);

						
						if (t.logo) {
							var base_url = "<?= base_url(); ?>";
							$('img[alt="Logo del Taller"]').attr('src', base_url + t.logo);
						}

						// Limpiar input file
						$('#logo').val('');
					} else {
						alert('Error: ' + response.message);
					}
				},

				error: function(xhr, status, error) {
				alert('Error al guardar: ' + error);
				}
			});
		});
	});
</script>