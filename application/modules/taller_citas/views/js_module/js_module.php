<script>
<?php if ($reference == "Index"): ?>
	//------------------Index----------------------------------------------------------------------------------------------------------------------------------------------

	$('#tablaCitas').on('init.dt', function () {
		$('thead tr th:last-child').removeClass('sorting');
		$('thead tr th:last-child').removeClass('sorting_asc');
		$('thead tr th:last-child').removeClass('sorting_desc');
	});

	$('#tablaCitas').on('draw.dt', function () {
		$('thead tr th:last-child').removeClass('sorting');
		$('thead tr th:last-child').removeClass('sorting_asc');
		$('#thead tr th:last-child').removeClass('sorting_desc');
	});

//------------------Fin Index----------------------------------------------------------------------------------------------------------------------------------------------

// $(document).ready(function () {
// 	actualizarTablaCitas();
// });


function limpiarSelectsFormulario() {
		$('#contactForm').find('select').each(function () {
			$(this).prop('selectedIndex', 0); // Selecciona la primera opción visualmente
		}).selectpicker('refresh'); // Refresca los selectpicker
	}



	$(document).on("click", ".activar_modal_add", function () {

		// 🔄 Resetear formulario ANTES de abrir modal
		$("#formPasoAPaso")[0].reset();

		$('.selectpicker').selectpicker('refresh');

		$('#info_nombre_cliente').text("Nombre: -");
		$('#info_email_cliente').text("Email: -");
		$('#info_telefono_cliente').text("Teléfono: -");

		$('#info_marca_vehiculo').text("Marca: -");
		$('#info_modelo_vehiculo').text("Modelo: -");
		$('#info_bastidor_vehiculo').text("Bastidor: -");
		$('#info_bastidor_vehiculo').text("Color: -");

		$('#selectorHoras').empty();

		$('#modal_ficha_cita').modal('show');
	});

	$(document).ready(function () {

		$(document).on("click", "#pedirCita", function (event) {
		event.preventDefault();

		var textoBoton = $(this).data("textoBoton") || ""; // recuperar el texto guardado
		var id_vehiculo = document.getElementById("info_id_vehiculo").value;

		var fecha = $("#fecha").val();
		let datos = $("#formPasoAPaso").serializeArray();

		if (textoBoton.trim() === "") {
			alert("Debes seleccionar una hora antes de pedir la cita.");
			return;
		}

		if (id_vehiculo.trim() === "") {
			alert("Hola, No se ha detectado el vehículo. Inténtalo otra vez.");
			return;
		}

		$('#modal_ficha_cita').modal('hide');

		$.ajax({
			url: "<?= base_url('admin.php/taller_citas/add_cita') ?>",
			type: "POST",
			data: { datos: datos, textoBoton: textoBoton, fecha: fecha, id_vehiculo: id_vehiculo },
			dataType: "json",
			success: function (data) {
				alert("Vehículo actualizado con exito");
				
				$('#pruebaModal').modal('hide');
				actualizarTablaCitas();
				
			},
			error: function (xhr, status, error) {
				console.error("No funcionoOOO", xhr.responseText);
			}
		});
	});

});
		
$('select[name="id_cliente"]').on('change', function () {
		let id_cliente = $(this).val();

		
		$.ajax({
			url: "<?= base_url('admin.php/taller_citas/getMatriculas') ?>",
			type: "POST",
			data: { id_cliente: id_cliente },
			dataType: "json",
			success: function (response) {
				let matriculas = response.matriculas;
				let ids = response.ids;
				let cliente = response.cliente[0];
				let vehiculos = response.vehiculos;

				// Mostrar datos del cliente
				if (cliente) {
					console.log("antes de declarar que va: " + $('#info_nombre_cliente'));
					$('#info_nombre_cliente').text("Nombre: " + cliente.nombre);
					$('#info_email_cliente').text("Email: " + cliente.correo_electronico);
					$('#info_telefono_cliente').text("Teléfono: " + cliente.telefono);
					console.log("despues de declarar que va: " + $('#info_nombre_cliente'));
				} else {
					$('#info_nombre_cliente').text("Nombre: -");
					$('#info_email_cliente').text("Email: -");
					$('#info_telefono_cliente').text("Teléfono: -");
				}

				// Rellenar el select de matrículas
				let html = '<option value="" selected disabled>Seleccione una matrícula</option>';
				if (matriculas.length > 0) {
					matriculas.forEach((matricula, i) => {
						html += `<option value="${ids[i]}" data-index="${i}">${matricula}</option>`;
					});
				} else {
					html += '<option disabled>No hay vehículos disponibles</option>';
				}

				$('#id_matricula').html(html).selectpicker("refresh").trigger('change');
				$('#id_matricula').data('vehiculos', vehiculos);

			},
			error: function (xhr, status, error) {
				console.error("Error AJAX:", status, error);
				console.log("Respuesta del servidor:", xhr.responseText);
				alert("Hubo un error en la solicitud.");
			}
		});
	});


	$('#id_matricula').on('change', function () {
		const selectedId = $(this).val(); // ID seleccionado del select
		if(selectedId){
			const vehiculos = $(this).data('vehiculos'); // Recuperamos el array que guardamos antes

			console.log("selectedId: "+selectedId);
			console.log("selectedId: "+vehiculos);

			if (!vehiculos){
				return;
			}
				// Buscamos el vehículo que coincida con ese ID

			var vehiculo = vehiculos.find(v => v.id == selectedId);
			console.log("id: "+vehiculo.id);

			$.ajax({
				url: "<?= base_url('admin.php/taller_citas/getDatosVehiculo') ?>",
				type: "POST",
				data: { id_vehiculo: vehiculo.id },
				dataType: "json",
				success: function (response) {
					let vehiculo = response.vehiculo[0];


					// Mostrar datos del vehiculo
					if (vehiculo) {
						$('#info_marca_vehiculo').text("Marca: " + vehiculo.marca);
						$('#info_modelo_vehiculo').text("Modelo: " + vehiculo.modelo);
						$('#info_bastidor_vehiculo').text("Bastidor: " + vehiculo.num_bastidor);
						$('#info_id_vehiculo').val(vehiculo.id);

					} else {
						$('#info_marca_vehiculo').text("Marca: -");
						$('#info_modelo_vehiculo').text("Modelo: -");
						$('#info_bastidor_vehiculo').text("Bastidor: -");
					}
				},
				error: function (xhr, status, error) {
					console.error("Error AJAX:", status, error);
					console.log("Respuesta del servidor:", xhr.responseText);
					alert("Hubo un error en la solicitud.");
				}
			});
		}
		
	});

	
	$(document).on("click", ".imageModals, .imgModelo", function () {
		var imageUrl = $(this).data('url');
		console.log(imageUrl);
		// Mostrar el modal
		$('#imageModal').modal('show');

		// Cargar la imagen en el modal
		$("#modalImage").attr("src", imageUrl);
	});

	//BOTONES
	

	


	$(document).on("click", ".btn_estado", function (event) {
		var fila = $(this).closest("tr");

		var id = fila.data("id");
		var id_vehiculo = fila.data("id_vehiculo");
		var fecha = fila.data("fecha");
		var hora = fila.data("hora");
		var id_tarea = fila.data("id_tarea");
		var estado = $(this).data("estado");

		$.ajax({
			url: "<?= base_url('admin.php/taller_citas/edit_cita') ?>",
			type: "POST",
			data: {
				id: id,
				id_vehiculo: id_vehiculo,
				fecha: fecha,
				hora: hora,
				id_tarea: id_tarea,
				estado: estado
			},
			dataType: "json",
			success: function (data) {
				actualizarTablaCitas();
			},
			error: function (xhr, status, error) {
				console.error("Error al actualizar cita", xhr.responseText);
			}
		});
	});

	$('.mostrar_filtros').on('click', function() {
		if ($('#filtro_modal').hasClass('hidden')) {
			$('#filtro_modal').removeClass('hidden')
		} else {
			$('#filtro_modal').addClass('hidden')
		}
	})

	$(document).ready(function () {
		let botonPresionado = null;

		$("#submit_filtrar").on("click", function () {
			botonPresionado = "filtrar";
		});

		$("#submit_ver_todos").on("click", function () {
			botonPresionado = "ver_todos";
			$("#contactForm")[0].reset();
			$("#contactForm select").val('').trigger('change');
		});

		$("#contactForm").on("submit", function (e) {
			e.preventDefault();

			const form = $(this)[0];
			const formData = new FormData(form);
			formData.append("botonPresionado", botonPresionado);

			actualizarTablaCitas(null, formData);
		});

	});

<?php endif ?>
</script>

















<!-- 
	SCRIPTS COMUNES 
-->
<script>

	function actualizarTablaCitas(html = null, formData = null) {
		if (html !== null) {
			if ($.fn.DataTable.isDataTable('.tabla_citas')) {
				$('.tabla_citas').DataTable().destroy();
			}
			$('.tabla_citas tbody').html(html);
			inicializa_tabla();
			return;
		}

		$.ajax({
			url: "<?= base_url('admin.php/taller_citas/recargar_tabla_citas') ?>",
			type: "POST",
			data: formData || {},
			contentType: formData ? false : "application/x-www-form-urlencoded; charset=UTF-8",
			processData: formData ? false : true,
			dataType: "json",
			success: function (response) {
				if (response.status === "success") {
					if ($.fn.DataTable.isDataTable('.tabla_citas')) {
						$('.tabla_citas').DataTable().destroy();
					}
					$('.tabla_citas tbody').html(response.response);
					inicializa_tabla();
				} else {
					alert("Error en la validación: " + response.message);
				}
			},
			error: function (xhr, status, error) {
				console.error("Error al recargar tabla", xhr.responseText);
			}
		});
	}
	
	function inicializa_tabla(){
		// Vuelve a inicializar el DataTable
		$('.tabla_citas').DataTable({
			order: [[0, 'desc']], // orden por la primera columna descendente
			responsive: true,
			autoWidth: false,
			searching: false, // 🔥 desactiva el filtro de búsqueda
			paging: true,    // 🔥 desactiva la paginación
			lengthChange: false, // oculta el "Show entries"
			info: true,       // 🔥 desactiva el "Mostrando 1 a 10 de 50 entradas"
			deferRender: true,
			processing: true
		});
	}
	inicializa_tabla();



	document.addEventListener("DOMContentLoaded", function () {
		let currentStep = 0;

		function setupModal(modalId) {
			const modal = document.querySelector(modalId);
			
			if(!modal){
				return;
			}

			const form = modal.querySelector("form");
			const steps = modal.querySelectorAll(".form-step");
			const nextBtn = modal.querySelector(".btn-next");
			const prevBtn = modal.querySelector(".btn-prev");
			const submitBtn = modal.querySelector(".btn-success");

			function updateButtons() {
				prevBtn.style.display = currentStep === 0 ? "none" : "flex";
				nextBtn.style.display = currentStep === steps.length - 1 ? "none" : "flex";
				submitBtn.style.display = currentStep === steps.length - 1 ? "flex" : "none";
			}

			updateButtons(); // Inicializar botones

			nextBtn.addEventListener("click", () => {
				if (currentStep < steps.length - 1) {
					steps[currentStep].classList.remove("active");
					currentStep++;
					steps[currentStep].classList.add("active");
					updateButtons();
				}
			});

			prevBtn.addEventListener("click", () => {
				if (currentStep > 0) {
					steps[currentStep].classList.remove("active");
					currentStep--;
					steps[currentStep].classList.add("active");
					updateButtons();
				}
			});

			$(modalId).on("hidden.bs.modal", function () {
				currentStep = 0;
				steps.forEach((step, i) => {
					step.classList.remove("active");
					if (i === 0) step.classList.add("active");
				});
				form.reset();
				updateButtons();
			});
		}

		// Inicializar en ambos modales
		setupModal("#modal_ficha_cita");
		setupModal("#modal_recogida");
	});	


	$('#fecha, select[name="areasTrabajo"]').on('change', function () {
		let tarea_id = $('select[name="areasTrabajo"]').val();
		let fecha = $('#fecha').val();

		if (tarea_id && fecha) {
			$.post('<?= base_url("admin.php/taller_citas/obtenerHorasDisponibles") ?>', {
				tarea_id: tarea_id,
				fecha: fecha
			}, function (data) {
				let respuesta = JSON.parse(data);
				let horas = respuesta.horas;
				let citas = respuesta.citas;
				let simultaneo = respuesta.simultaneo;

				let html = '';
				if (horas.length > 0) {
					let horaAsignada = ($("#pedirCita").data("textoBoton") || "").substring(0, 5);

					horas.forEach(hora => {
						let cantidadCitas = citas[hora] || 0;
						console.log(cantidadCitas);

						let clase = '';
						
						if (cantidadCitas >= simultaneo) {
							clase = 'btn-danger';
						} else if (hora === horaAsignada) {
							clase = 'btn-success hora_select';
						} else {
							clase = 'btn-primary hora_select';
						}
						html += `<button type="button" class="btn ${clase} m-1 btn-hora" style="margin:5px; min-width:63px">${hora}</button>`;
					});
				} else {
					html = '<p class="text-danger">No hay tramos disponibles.</p>';
				}

				$('#selectorHoras').html(html);
			});
		}
	});


	$(document).on("click", ".hora_select", function (event) {
		var textoBoton = $(this).text(); // variable local
		var botonesHora = $('button.hora_select').toArray();
		var id_vehiculo = document.getElementById("info_id_vehiculo").value;

		$(botonesHora).each(function (index, boton) {
			$(boton).css('background-color', '#0081C6');
			$(boton).css('color', 'white');
		});

		$(this).css({
			'background-color': 'green',
			'color': 'black'
		});

		// ✅ Guardar el texto seleccionado en el propio botón de pedir cita (temporalmente)
		$("#pedirCita").data("textoBoton", textoBoton);
	});

	//Solo los fines de semana
	document.getElementById("fecha").addEventListener("input", function () {
		const fechaSeleccionada = new Date(this.value);
		const dia = fechaSeleccionada.getDay(); // 0 = domingo, 6 = sábado

		if (dia === 0 || dia === 6) {
			alert("Los fines de semana no estamos disponibles.");
			this.value = ""; // Limpia la fecha
		}
	});

	
	let currentZoom = 1;
	const maxZoom = 3;

	$(document).on("click", "#modalImage", function (e) {
		const $img = $(this);
		const imgWidth = $img.width();
		const imgHeight = $img.height();
		const offsetX = e.offsetX;
		const offsetY = e.offsetY;
		const xPercent = (offsetX / imgWidth) * 100;
		const yPercent = (offsetY / imgHeight) * 100;

		// Aumenta el zoom o reinicia
		currentZoom = currentZoom >= maxZoom ? 1 : currentZoom + 1;

		if (currentZoom === 1) {
			$img.css({
				"transform": "none",
				"cursor": "zoom-in"
			});
		} else if (currentZoom ===2) {
			$img.css({
				"transform": `scale(${currentZoom})`,
				"transform-origin": `${xPercent}% ${yPercent}%`,
				"cursor": "zoom-in"
			});
		}else {
			$img.css({
				"transform": `scale(${currentZoom})`,
				"transform-origin": `${xPercent}% ${yPercent}%`,
				"cursor": "zoom-out"
			});
		}
	});

	// Clic derecho para reiniciar el zoom
	$(document).on("contextmenu", "#modalImage", function (e) {
		e.preventDefault();
		currentZoom = 1;
		$(this).css({
			"transform": "none",
			"cursor": "zoom-in"
		});
	});


	
	
</script>
























<!-- 
	SCRIPTS DETALLES 
-->
<script>
<?php if ($reference == "Detalles"): ?>

	$(document).on("click", ".btn_estado", function (event) {
		event.preventDefault();

		var $btn = $(this);

		var id = $btn.data("id");
		var id_vehiculo = $btn.data("id_vehiculo");
		var fecha = $btn.data("fecha");
		var hora = $btn.data("hora");
		var id_tarea = $btn.data("id_tarea");
		var estado = $btn.data("estado");

		$.ajax({
			url: "<?= base_url('admin.php/taller_citas/cambiar_estado') ?>",
			type: "POST",
			data: {
				id: id,
				estado: estado
			},
			dataType: "json",
			success: function (data) {
				if (data.status === "success") {
					location.reload(); // Refresca la página para mostrar el nuevo estado
				} else {
					alert("Error: " + data.message);
				}
			},
			error: function (xhr, status, error) {
				console.error("Error al actualizar cita", xhr.responseText);
				alert("Hubo un error al actualizar la cita.");
			}
		});
	});

	
	$(document).on("click", ".btn_vehiculos_citas", function (event) {
		var id_vehiculo = $(this).data('id');
		var id_cita = $(this).data('id_original');

		$.ajax({
			url: "<?= base_url('admin.php/taller_citas/actualizar_citas') ?>",
			type: "POST",
			data: {
				id_vehiculo: id_vehiculo,
				id_cita: id_cita
			},
			dataType: "json",
			success: function (data) {
				
				$("#mensaje_tabla_citas").hide();
				$("#activador_tabla_citas").show();

				var nuevaTabla = data.response;

				// Destruye DataTable si ya está inicializado
				if ( $.fn.DataTable.isDataTable('#tabla_citas') ) {
					$('#tabla_citas').DataTable().destroy();
				}
				
				$('#cuerpo_tabla').html(nuevaTabla);

				inicializa_tabla();
			},
			error: function (xhr, status, error) {
				
				console.error("Error al actualizar cita", xhr.responseText);
				alert("Hubo un error al actualizar la cita.");
			}
		});

	});

$(document).ready(function () {
    $(document).on("click", ".activar_modal_add", function () {
		// Mostrar modal
		$('#modal_ficha_cita').modal('show');
		// Resetear formulario
		$("#formPasoAPaso")[0].reset();
		$('.selectpicker').selectpicker('refresh');
		$('#selectorHoras').empty();
		
		// Reset info visual
		$('#info_nombre_cliente').text("Nombre: -");
		$('#info_email_cliente').text("Email: -");
		$('#info_telefono_cliente').text("Teléfono: -");
		$('#info_marca_vehiculo').text("Marca: -");
		$('#info_modelo_vehiculo').text("Modelo: -");
		$('#info_bastidor_vehiculo').text("Bastidor: -");

		// Obtener datos del botón
		var id_cita = $(this).data("id");
		var id_cliente = $(this).data("id_cliente");
		var id_vehiculo = $(this).data("id_vehiculo");
		var fecha = $(this).data("fecha");
		var hora = $(this).data("hora");
		var observaciones = $(this).data("observaciones");
		var id_area_trabajo = $(this).data("id_tarea");
		var estado = $(this).data("estado");

		$('#modalFichaTitulo').text("Editar cita "+id_cita);	

		// Cargar modal y setear campos
		$("#id_cita").val(id_cita);
		$("#estado").val(estado);

		$("#id_cliente").data("id_vehiculo", id_vehiculo);

		$("#modal_ficha_cita select[name='id_cliente']").val(id_cliente).selectpicker('refresh').trigger('change');

		$("#fecha").val(fecha);
		$("select[name='areasTrabajo']").val(id_area_trabajo).selectpicker('refresh').trigger("change");
		$("textarea[name='descripcion']").val(observaciones);

		var hora = $(this).data("hora");
		$("#pedirCita").data("textoBoton", hora);
	});


    // Evento cuando cambia el cliente
	$('#id_cliente').on('change', function () {

		var id_cliente = $(this).val();
		var id_vehiculo = $(this).data("id_vehiculo");
		
		$.ajax({
			url: "<?= base_url('admin.php/taller_citas/getMatriculas') ?>",
			type: "POST",
			data: { id_cliente: id_cliente },
			dataType: "json",
			success: function (response) {
				let matriculas = response.matriculas;
				let ids = response.ids;
				let cliente = response.cliente[0];
				let vehiculos = response.vehiculos;
				// Mostrar datos del cliente
				if (cliente) {
					$('#info_nombre_cliente').text("Nombre: " + cliente.nombre);
					$('#info_email_cliente').text("Email: " + cliente.correo_electronico);
					$('#info_telefono_cliente').text("Teléfono: " + cliente.telefono);
				} else {
					$('#info_nombre_cliente').text("Nombre: -");
					$('#info_email_cliente').text("Email: -");
					$('#info_telefono_cliente').text("Teléfono: -");
				}

				// Rellenar el select de matrículas
				let html = '<option value="" selected disabled>Seleccione una matrícula</option>';
				if (matriculas.length > 0) {
					matriculas.forEach((matricula, i) => {
						html += `<option value="${ids[i]}" data-index="${i}">${matricula}</option>`;
					});
				} else {
					html += '<option disabled>No hay vehículos disponibles</option>';
				}

				// Establecer los datos de vehículos en el select
				$('#id_matricula').html(html).selectpicker("refresh");
				$('#id_matricula').data('vehiculos', vehiculos); // <- AÑADIR ESTO

				$("#id_matricula").val(id_vehiculo).selectpicker('refresh').trigger("change");
			},
			error: function (xhr, status, error) {
				console.error("Error AJAX:", status, error);
				alert("Hubo un error en la solicitud.");
			}
		});
	});





    // Evento cuando cambia la matrícula
	$('#id_matricula').on('change', function () {
	    const selectedId = $(this).val(); // ID seleccionado del select
	    const vehiculos = $(this).data('vehiculos'); // Recuperamos el array de vehículos

	    if (!vehiculos) {
	        return; // Si no hay vehículos disponibles, no hacemos nada
	    }

	    // Buscar el vehículo seleccionado
	    var vehiculo = vehiculos.find(v => v.id == selectedId);

	    if (vehiculo) {
	        // Mostrar datos del vehículo
	        $('#info_marca_vehiculo').text("Marca: " + vehiculo.marca);
	        $('#info_modelo_vehiculo').text("Modelo: " + vehiculo.modelo);
	        $('#info_bastidor_vehiculo').text("Bastidor: " + vehiculo.num_bastidor);
	        $('#info_id_vehiculo').val(vehiculo.id);

			
	    } else {
	        $('#info_marca_vehiculo').text("Marca: -");
	        $('#info_modelo_vehiculo').text("Modelo: -");
	        $('#info_bastidor_vehiculo').text("Bastidor: -");
			$('#info_id_vehiculo').val("");

	    }
	});


	$(document).on("click", "#pedirCita", function (event) {
		event.preventDefault();

		var textoBoton = $(this).data("textoBoton") || ""; // recuperar el texto guardado
		var id_vehiculo = document.getElementById("info_id_vehiculo").value;
		var id_cita = document.getElementById("id_cita").value;
		var estado = document.getElementById("estado").value;
		console.log(estado);

		var fecha = $("#fecha").val();
		let datos = $("#formPasoAPaso").serializeArray();

		if (textoBoton.trim() === "") {
			alert("Debes seleccionar una hora antes de pedir la cita.");
			return;
		}

		if (id_vehiculo.trim() === "") {
			alert("No se ha detectado el vehículo. Inténtalo otra vez.");
			return;
		}

		$('#modal_ficha_cita').modal('hide');

		$.ajax({
			url: "<?= base_url('admin.php/taller_citas/update_cita') ?>",
			type: "POST",
			data: { datos: datos, textoBoton: textoBoton, fecha: fecha, id_vehiculo: id_vehiculo, id_cita: id_cita, estado: estado},
			dataType: "json",
			success: function (data) {
				alert("Vehículo actualizado con exito");
				
				$('#pruebaModal').modal('hide');
				location.reload();
				
			},
			error: function (xhr, status, error) {
				console.error("No funcionoOOO", xhr.responseText);
			}
		});
	});



	


	$(document).on("click", ".fila-cita", function () {
		let id_cita = $(this).data("id_cita");
		let id_cliente = $(this).data("id_cliente");

		let url = "<?= base_url('admin.php/citas/detalles') ?>/" + id_cita + "/" + id_cliente;
		window.location.href = url;
	});

});




document.addEventListener('DOMContentLoaded', function () {

	$(document).on("click", ".activar_modal_recogida", function () {
		// Mostrar modal
		$('#modal_recogida').modal('show');

		// Resetear formulario
		$("#formPasoAPaso")[0].reset();
		$('.selectpicker').selectpicker('refresh');
		$('#selectorHoras').empty();

		// Desmarcar todos los checkboxes de impactos
		$('.checkbox-impacto').prop('checked', false);

		// Vaciar todas las tablas de impacto
		$('.tabla_impactos tbody').empty();

		// Obtener ID de cita desde atributo data-id o campo oculto
		let cita_id = $(this).data('id') || $('#cita_id').val();

		// Establecer el valor en el input oculto
		$('#cita_id').val(cita_id);

		// Cargar datos de recepción si existen
		$.ajax({
			url: "<?= base_url('admin.php/citas/get_recepcion') ?>/" + cita_id,
			type: 'GET',
			dataType: 'json',
			success: function (response) {
				if (response.recepcion_existente) {
					$('#kilometros').val(response.kilometros);
					$('#combustible').val(response.combustible);
					$('#observaciones_cliente').val(response.observaciones);
					$('#confirmacion_cliente').prop('checked', response.confirmacion_cliente == 1);

					// Marcar zonas de impacto y mostrar imágenes
					if (response.fotos && Array.isArray(response.fotos)) {
						response.fotos.forEach(function (foto) {
							const parte = foto.parte;
							const zona = parte.replace(/ /g, '_');
							const imagen = foto.imagen_path;

							let checkbox = $(`.checkbox-impacto[value="${zona}"]`);
							if (checkbox.length) {
								checkbox.prop('checked', true).trigger('change');

								// Esperar a que se cree el contenedor
								setTimeout(function () {
									const inputFile = $(`input[name="imagen_${zona}"]`);
									const previewContainer = inputFile.closest('td').find('.preview-container');

									if (inputFile.length && previewContainer.length) {
										inputFile.parent().hide();

										const img = document.createElement('img');
										img.src = base_url + imagen;
										img.classList.add('img-fluid');
										img.classList.add('img-impacto');
										img.style.cursor = 'pointer';

										// Permitir cambiar imagen haciendo clic
										img.addEventListener('click', function () {
											$('#modalConfirmacionImagen').modal('show');
											
											$(document).on("click", "#ampliarImagen", function () {
												$('#modalConfirmacionImagen').modal('hide');
												$('#imageModal').modal('show');

												var Img = document.getElementById("modalImage");
												Img.src = base_url + imagen;

											});

											$(document).on("click", "#cambiarImagen", function () {
												$('#modalConfirmacionImagen').modal('hide');
												inputFile.click();

											});

										});

										previewContainer.append(img);
									}
								}, 100);
							}
						});
					}
				}
			},
			error: function (xhr, status, error) {
				console.error("No funcionó la carga de recepción:", xhr.responseText);
			}
		});
	});

		

    const checkboxes = document.querySelectorAll('.checkbox-impacto');

    checkboxes.forEach(checkbox => {
		$(checkbox).on('change', function () {
            const parte = this.name.replace('impacto_', '').replace(/_/g, ' ');
            const target = this.dataset.target;

            // Determina contenedor según el nombre
            let contenedor = '';
            if (target.includes('Techo')) {
                contenedor = 'contenedorInputsImpacto_Arriba';
            } else if (target.includes('Izquierda')) {
                contenedor = 'contenedorInputsImpacto_Lateral_Izquierdo';
            } else if (target.includes('Derecha')) {
                contenedor = 'contenedorInputsImpacto_Lateral_Derecho';
            } else if (target.includes('Frontal') || target.includes('Capo') || target.includes('Luna_Delantera') || target.includes('Luna_Delantera')) {
                contenedor = 'contenedorInputsImpacto_Delante';
            } else if (target.includes('Trasero') || target.includes('Maletero') || target.includes('Luna_Trasera')) {
                contenedor = 'contenedorInputsImpacto_Detras';
            }

            const tbody = document.querySelector(`#${contenedor} tbody`);
            const rowId = `row_${target}`;

            if (this.checked) {
                if (!document.getElementById(rowId)) {
                    const row = document.createElement('tr');
					row.id = rowId;
					row.innerHTML = `
						<td>${parte}</td>
						<td>
							<label class="btn btn-sm btn-outline-primary">
								<i class="fa fa-upload"></i>
								<input type="file" name="imagen_${this.value}" style="display: none;" accept="image/*">
							</label>
							<div class="preview-container mt-2"></div>
						</td>
					`;
					tbody.appendChild(row);

					// Añadir funcionalidad de previsualización y ocultar input al cargar imagen
					const fileInput = row.querySelector(`input[type="file"]`);
					const previewContainer = row.querySelector('.preview-container');

					fileInput.addEventListener('change', function (event) {
						const file = event.target.files[0];
						if (file && file.type.startsWith('image/')) {
							const reader = new FileReader();
							reader.onload = function (e) {
								const img = document.createElement('img');
								img.src = e.target.result;
								img.classList.add('img-fluid');
								img.classList.add('img-impacto');
								img.style.cursor = 'pointer';

								img.addEventListener('click', function () {
									fileInput.click();
								});

								// Oculta el botón de carga original
								fileInput.parentElement.style.display = 'none';

								previewContainer.innerHTML = '';
								previewContainer.appendChild(img);
							};

							reader.readAsDataURL(file);
						}
					});

                }
            } else {
                const existingRow = document.getElementById(rowId);
                if (existingRow) {
                    existingRow.remove();
                }
            }
        });
    });

	


	// Función para manejar la carga de la firma
	function cargarFirma() {
			const citaId = $('#cita_id').val();
			const canvas = document.getElementById("firmaCanvas");
			const ctx = canvas.getContext("2d");
			const firmaUrl = `<?= base_url('assets_app/images/taller/recepcion/') ?>/${citaId}/firma_cliente.png`;

			// Verificar si la imagen existe antes de cargarla
			fetch(firmaUrl, { method: 'HEAD' }).then(response => {
				if (response.ok) {
					const img = new Image();
					img.onload = function () {
						ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
					};
					img.src = firmaUrl;
				}
			});
		}

		// Llamada para cargar la firma al cargar la página
		cargarFirma();

		// Función para guardar la firma como base64
		function guardarFirma() {
			const canvas = document.getElementById("firmaCanvas");
			const dataURL = canvas.toDataURL("image/png");
			document.getElementById("firmaBase64").value = dataURL;
		}

		// Lógica de dibujo en el canvas
		let pintando = false;
		const canvas = document.getElementById("firmaCanvas");
		const ctx = canvas.getContext("2d");

		canvas.addEventListener("mousedown", () => { pintando = true });
		canvas.addEventListener("mouseup", () => {
			pintando = false;
			guardarFirma();
		});
		canvas.addEventListener("mousemove", dibujar);

		function dibujar(e) {
			if (!pintando) return;
			const rect = canvas.getBoundingClientRect();
			ctx.lineWidth = 2;
			ctx.lineCap = "round";
			ctx.strokeStyle = "#000";
			ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
			ctx.stroke();
			ctx.beginPath();
			ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
		}

		// Función para limpiar la firma
		window.limpiarFirma = function () {
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			document.getElementById("firmaBase64").value = "";
		};




	// Función para enviar el formulario con los datos
	$('#pedirRecepcion').on('click', function (e) {
		e.preventDefault();

		// Guardar firma antes de enviar el formulario
		guardarFirma();

		let formData = new FormData();
		formData.append('cita_id', $('#cita_id').val());
		formData.append('kilometraje', $('#kilometros').val());
		formData.append('combustible', $('#combustible').val());
		formData.append('observaciones', $('#observaciones_cliente').val());
		formData.append('confirmacion_cliente', $('#confirmacion_cliente').is(':checked') ? 1 : 0);
		formData.append('firma_base64', $('#firmaBase64').val());

		// Recolectar zonas de impacto y archivos
		$('.zona-impacto input[type="checkbox"]:checked').each(function () {
			let zona = $(this).val();
			formData.append('zonas_impacto[]', zona);

			// Buscar el input file correspondiente a esta zona
			let inputFile = $(`input[name="imagen_${zona}"]`)[0];
			if (inputFile && inputFile.files.length > 0) {
				formData.append(`imagen_${zona}`, inputFile.files[0]);
			}
		});

		// Enviar datos al backend para guardar o actualizar
		$.ajax({
			url: base_url + 'admin.php/taller_citas/guardar_o_actualizar',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function () {
				alert('Recepción guardada o actualizada con éxito');
				$('#modal_recogida').modal('hide');
				$('#estado_contenedor').load(location.href + " #estado_contenedor > *");
			},
			error: function () {
				alert('Error al guardar o actualizar la recepción');
			}
		});
	});

});


<?php endif ?>
</script>