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


		console.log("Evento pedir cita");
		console.log("Texto botón:", textoBoton);
		console.log("ID vehículo:", id_vehiculo);

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
			url: "<?= base_url('taller_citas/add_cita') ?>",
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
			url: "<?= base_url('taller_citas/getMatriculas') ?>",
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
		const vehiculos = $(this).data('vehiculos'); // Recuperamos el array que guardamos antes


		if (!vehiculos){
			return;
		}
			// Buscamos el vehículo que coincida con ese ID

		var vehiculo = vehiculos.find(v => v.id == selectedId);
		console.log("id: "+vehiculo.id)

		$.ajax({
			url: "<?= base_url('taller_citas/getDatosVehiculo') ?>",
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

		
	});

	
	$(document).on("click", ".imageModals, .imgModelo", function () {
		var imageUrl = $(this).data('url');
		console.log(imageUrl);
		// Mostrar el modal
		$('#imageModal').modal('show');

		// Cargar la imagen en el modal
		$("#modalImage").attr("src", imageUrl);
	});

	$(document).on("click", "#modalImage", function (e) {
		var $img = $(this);
		var scale = 2;  // Factor de zoom

		// Si la imagen ya tiene un zoom aplicado, deshacer el zoom
		if ($img.css("transform") !== "none") {
			$img.css("transform", "none");
			$img.css("cursor", "zoom-in");
		} else {
			// Calcular la posición del ratón dentro de la imagen
			var offsetX = e.offsetX;  // Posición X del ratón dentro de la imagen
			var offsetY = e.offsetY;  // Posición Y del ratón dentro de la imagen
			var imgWidth = $img.width();
			var imgHeight = $img.height();

			// Calcular los porcentajes de la posición del ratón en relación con la imagen
			var xPercent = offsetX / imgWidth * 100;
			var yPercent = offsetY / imgHeight * 100;

			// Aplicar el zoom centrado en el ratón
			$img.css({
				"transform": "scale(" + scale + ")",
				"transform-origin": xPercent + "% " + yPercent + "%",
				"cursor": "zoom-out"
			});
		}
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
			url: "<?= base_url('taller_citas/edit_cita') ?>",
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
    });

    $("#contactForm").on("submit", function (e) {
        e.preventDefault();

        const form = $(this)[0];
        const formData = new FormData(form);
        formData.append("botonPresionado", botonPresionado);

        $.ajax({
            url: "<?= base_url('taller_citas/recargar_tabla_citas') ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                console.log(response.data);
                actualizarTablaCitas(response.data);
            },
            error: function (xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                console.error("Respuesta completa:", xhr.responseText)
            }
        });
    });
});


<?php endif ?>
</script>

















<!-- 
	SCRIPTS COMUNES 
-->
<script>

	 function actualizarTablaCitas(html) { // acabo de añadir $html para cargar la tabla con la info que saco del filtro
	 	$.ajax({
	 		url: "<?= base_url('taller_citas/recargar_tabla_citas') ?>",
	 		type: "POST",
	 		dataType: "json",
	 		success: function (response) {
	 			console.log("Funcionó :)", response.status);

	 			if (response.status === "success") {
	 				var nuevaTabla = response.response;

	 				// Destruye DataTable si ya está inicializado
	 				if ( $.fn.DataTable.isDataTable('.tabla_citas') ) {
	 					$('.tabla_citas').DataTable().destroy();
	 				}
	 				// Reemplaza el contenido del tbody
	 				if(html){
	 					console.log(html)
	 					$('.tabla_citas tbody').html(html);

	 				}else{
	 					$('.tabla_citas tbody').html(nuevaTabla);
	 				}

	 				inicializa_tabla();
	 			} else {
	 				alert("Error en la validación: " + response.message);
	 			}
	 		},
	 		error: function (xhr, status, error) {
	 			console.error("No funcionó", xhr.responseText);
	 		}
	 	});
	
	 }

	// function actualizarTablaCitas(nuevaTabla) {
	// 	// Obtener la instancia actual de la tabla DataTable
	// 	var tabla = $('.tabla_citas').DataTable();

	// 	// Limpiar las filas existentes
	// 	tabla.clear();

	// 	// Añadir las nuevas filas (asegúrate de que 'nuevaTabla' solo contenga las filas <tr>)
	// 	tabla.rows.add($(nuevaTabla)).draw();

	// }

	
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
		const steps = document.querySelectorAll(".form-step");
		const nextBtn = document.querySelector(".btn-next");
		const prevBtn = document.querySelector(".btn-prev");
		const submitBtn = document.querySelector(".btn-success");

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


		// función para retroceder
		prevBtn.addEventListener("click", () => {
			if (currentStep > 0) {
				steps[currentStep].classList.remove("active");
				currentStep--;
				steps[currentStep].classList.add("active");
				updateButtons();
			}
		});


		$('#modal_ficha_cita').on('hidden.bs.modal', function () {
			currentStep = 0;
			steps.forEach((step, i) => {
				step.classList.remove("active");
				if (i === 0) step.classList.add("active");
			});
			document.getElementById("formPasoAPaso").reset();
			updateButtons();
		});
	});

	$('#fecha, select[name="areasTrabajo"]').on('change', function () {
		let tarea_id = $('select[name="areasTrabajo"]').val();
		let fecha = $('#fecha').val();

		if (tarea_id && fecha) {
			$.post('<?= base_url("taller_citas/obtenerHorasDisponibles") ?>', {
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
			url: "<?= base_url('taller_citas/cambiar_estado') ?>",
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
			url: "<?= base_url('taller_citas/actualizar_citas') ?>",
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

				setTimeout(() => {
					inicializa_tabla();
				}, 10);

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

		$('#modalFichaTitulo').text("Editar cita "+id_cita);	

		// Cargar modal y setear campos
		$("#id_cita").val(id_cita);

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
			url: "<?= base_url('taller_citas/getMatriculas') ?>",
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


		console.log("Evento pedir cita");
		console.log("Texto botón:", textoBoton);
		console.log("ID vehículo:", id_vehiculo);

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
			url: "<?= base_url('taller_citas/update_cita') ?>",
			type: "POST",
			data: { datos: datos, textoBoton: textoBoton, fecha: fecha, id_vehiculo: id_vehiculo, id_cita: id_cita},
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



	$(document).on("click", ".activar_modal_recogida", function () {
		// Mostrar modal
		$('#modal_recogida').modal('show');
		// Resetear formulario
		$("#formPasoAPaso")[0].reset();
		$('.selectpicker').selectpicker('refresh');
		$('#selectorHoras').empty();
		
	});

	$(document).on("click", ".fila-cita", function () {
		let id_cita = $(this).data("id_cita");
		let id_cliente = $(this).data("id_cliente");

		let url = "<?= base_url('citas/detalles/') ?>/" + id_cita + "/" + id_cliente;
		
		window.location.href = url;
	});

});





<?php endif ?>
</script>
