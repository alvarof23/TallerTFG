<script>

	document.addEventListener("DOMContentLoaded", function() {
		function inicializa_tabla(){
			// Vuelve a inicializar el DataTable
			$('.tabla_clientes').DataTable({
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
					infoEmpty: "No hay registros disponibles",
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

		$('.activarModal').on('click', function() {
			// Limpiar el formulario
			$('#formCliente')[0].reset();
			$('#clienteModalHead').text('Crear Cliente');
			
			// Limpiar campos
			$('#dni').val('');
			$('#nombre').val('');
			$('#telefono').val('');
			$('#correo_electronico').val('');

			// Mostrar el modal
			$('#modalCliente').modal('show');

			// Cambiar el título del modal
			$('#clienteModalHead').text('Crear Cliente');

		});

		$('.editarModal').on('click', function() {
			// Obtener el ID del cliente
			var id_cliente = $(this).data('id');

			$.ajax({
				url: '<?= base_url('taller_clientes/get_cliente') ?>',
				type: 'POST',
				data: { id_cliente: id_cliente },
				dataType: 'json',
				success: function(data) {
					if (data) {
						// Llenar el formulario con los datos del cliente
						$('#dni').val(data.dni);
						$('#nombre').val(data.nombre);
						$('#telefono').val(data.telefono);
						$('#correo_electronico').val(data.correo_electronico);

						// Cambiar el título del modal
						$('#clienteModalHead').text('Editar Cliente');

						// Mostrar el modal
						$('#modalCliente').modal('show');

						$('#dni').val(data.dni);
						$('#nombre').val(data.nombre);
						$('#telefono').val(data.telefono);
						$('#correo_electronico').val(data.correo_electronico);

					} else {
						alert('Error al obtener los datos del cliente.');
					}
				},
				error: function() {
					alert('Error en la solicitud AJAX.');
				}
			});
		});

		$('.guarda_cliente').on('click', function(event) {
			// Prevenir el envío del formulario por defecto
			event.preventDefault();
			// Validar el formulario
			if ($('#formCliente')[0].checkValidity()) {
				console.log($('#formCliente').serialize());	
				// Enviar el formulario
				$.ajax({
					url: '<?= base_url('taller_clientes/guardar_cliente') ?>',
					type: 'POST',
					data: $('#formCliente').serialize(),
					dataType: "json",
					success: function(response) {
						if (response.success === "validacion") {
							alert('Por favor, revise todos los campos.');
						
						}else if (response.success) {
							alert('Cliente guardado con éxito.');
							location.reload(); // Recargar la página para ver los cambios
						} else {
							alert('Error al guardar el cliente.');
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


		$('#contactForm').on('submit', function(event) {
			event.preventDefault(); // Prevenir el envío del formulario por defecto

			var buscar = $('#buscar').val().trim();

			if (buscar) {
				// Realizar la búsqueda
				$.ajax({
					url: '<?= base_url('taller_clientes/buscar_clientes') ?>',
					type: 'POST',
					data: { buscar: buscar },
					dataType: 'json',
					success: function(data) {
						clientes = data.cliente;

						if (clientes.length > 0) {
							// Limpiar la tabla antes de mostrar los resultados
							$('.tabla_clientes_cuerpo').empty();
							// Agregar los resultados a la tabla
							clientes.forEach(function(cliente) {
								$('.tabla_clientes_cuerpo').append(
									'<tr>' +
									'<td>' + cliente.dni + '</td>' +
									'<td>' + cliente.nombre + '</td>' +
									'<td>' + cliente.telefono + '</td>' +
									'<td>' + cliente.correo_electronico + '</td>' +
									'<td class="pull-right">' +
										'<button type="button" class="btn btn-primary editarModal" data-id="' + cliente.dni + '" title="Editar cliente" id="boton_vehiculos">' +
											'<i class="fa fa-edit"></i>' +
										'</button>' +
										'<a href="clientes/eliminar_cliente/' + cliente.dni + '" class="text-danger delete" id="boton_vehiculos" data-placement="top" data-toggle="tooltip" data-original-title="Borrar vehiculo">' +
											'<span class="fa fa-trash"></span>' +
										'</a>' +
									'</td>' +
									'</tr>'
								);
							});

						} else {
							alert('No se encontraron resultados.');
						}
					},
					error: function() {
						alert('Error en la solicitud AJAX.');
					}
				});
			} else {
				alert('Por favor, ingrese un término de búsqueda.');
			}
		});

		$('#submit_ver_todos').on('click', function(event) {
			event.preventDefault(); // Prevenir comportamiento por defecto

			$.ajax({
				url: '<?= base_url('taller_clientes/get_clientes') ?>',
				type: 'POST',
				dataType: 'json',
				success: function(data) {
					clientes = data.cliente;

					if (clientes.length > 0) {
						// Limpiar la tabla antes de mostrar los resultados
						$('.tabla_clientes_cuerpo').empty();
						// Agregar los resultados a la tabla
						clientes.forEach(function(cliente) {
							$('.tabla_clientes_cuerpo').append(
								'<tr>' +
								'<td>' + cliente.dni + '</td>' +
								'<td>' + cliente.nombre + '</td>' +
								'<td>' + cliente.telefono + '</td>' +
								'<td>' + cliente.correo_electronico + '</td>' +
								'<td class="pull-right">' +
									'<button type="button" class="btn btn-primary editarModal" data-id="' + cliente.dni + '" title="Editar cliente" id="boton_vehiculos">' +
										'<i class="fa fa-edit"></i>' +
									'</button>' +
									'<a href="clientes/eliminar_cliente/' + cliente.dni + '" class="text-danger delete" id="boton_vehiculos" data-placement="top" data-toggle="tooltip" data-original-title="Borrar vehiculo">' +
										'<span class="fa fa-trash"></span>' +
									'</a>' +
								'</td>' +
								'</tr>'
							);
						});
					} else {
						alert('No se encontraron clientes.');
					}
				},
				error: function() {
					alert('Error en la solicitud AJAX.');
				}
			});
		});

	});
</script>