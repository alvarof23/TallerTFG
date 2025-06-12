
<script>
//------------------Index----------------------------------------------------------------------------------------------------------------------------------------------

	$('#tablaVehiculos').on('init.dt', function() {
		$('#tablaVehiculos thead tr th:last-child').removeClass('sorting');
		$('#tablaVehiculos thead tr th:last-child').removeClass('sorting_asc');
		$('#tablaVehiculos thead tr th:last-child').removeClass('sorting_desc');
	});

	$('#tablaVehiculos').on('draw.dt', function() {
		$('#tablaVehiculos thead tr th:last-child').removeClass('sorting');
		$('#tablaVehiculos thead tr th:last-child').removeClass('sorting_asc');
		$('#tablaVehiculos thead tr th:last-child').removeClass('sorting_desc');
	});

//------------------Fin Index----------------------------------------------------------------------------------------------------------------------------------------------

</script>

<script>

$(document).ready(function () {
	var cargaDesdeModal = false;
//------------------Editar Modal----------------------------------------------------------------------------------------------------------------------------------------------

	$(document).on("click", ".editarModal", function () {       
		 var fila = $(this).closest("tr");

		$("#columna_izquierda").removeClass("col-md-12").addClass("col-md-6");		
		$("#columna_izquierda_izquierda").removeClass("col-md-6").addClass("col-md-12");
		$("#columna_izquierda_derecha").removeClass("col-md-6").addClass("col-md-12");

		$("#columna_izquierda_derecha").css("margin-top", "15px");



        // Obtener los datos del vehículo de la fila seleccionada
        var id = fila.data("id");
        var cliente = fila.data("cliente");
        var marca = fila.data("marca");
        var modelo = fila.data("modelo");
		var img = fila.data("imagen");
        var numBastidor = fila.data("bastidor");
        var color = fila.data("color");
        var matricula = fila.data("matricula");
        var fecha_matriculacion = fila.data("fecha_matriculacion");

		$("#tablaImagenesModal").show();
		$("#div_dropzone").show(); // Solo si quieres mostrar Dropzone al editar

		
        // Guardar el modelo para seleccionarlo después
        var modeloSeleccionado = modelo;

		cargaDesdeModal = true;
        // Cargar los valores en el formulario del modal
        $("#pruebaModal input[name='id_vehiculo']").val(id);
        $("#pruebaModal select[name='id_cliente']").val(cliente).trigger("change");
        $("#pruebaModal select[name='nom_marca']").val(marca).trigger("change"); 
        $("#pruebaModal input[name='nom_imagen']").val(img);
        $("#pruebaModal input[name='matricula']").val(matricula);
        $("#pruebaModal input[name='color']").val(color);
        $("#pruebaModal input[name='num_bastidor']").val(numBastidor);
        $("#pruebaModal input[name='fecha_matriculacion']").val(fecha_matriculacion);

        // Hacer la petición AJAX para cargar los modelos según la marca
        $.ajax({
            url: "<?= base_url('Taller_vehiculos/get_modelos_por_marca'); ?>",
            type: "POST",
            data: { id_marca: marca, id_modelo: modelo },
            dataType: "json",
            success: function (data) {
                console.log("Modelos recibbbbbidos:", data);

                var modeloSelect = document.getElementById("modelo_change");

                modeloSelect.innerHTML = data;

				// Esperar un poco para asegurar que las opciones se han cargado
				var titulo = document.getElementById("defModalHead");
				titulo.innerHTML="Editar vehiculo con matricula: "+matricula;

                // Refrescar si usas selectpicker
                $("#modelo_change").selectpicker("refresh");
            },
            error: function (xhr, status, error) {
                console.error("Error al obtener modelos:", xhr.responseText);
            }
        });

		// NUEVO: Hacer la petición AJAX para cargar las imágenes del vehículo TABLA IMAGENES DENTRO DEL MODAL
		$.ajax({
			url: "<?= base_url('Taller_vehiculos/get_imagenes_vehiculos'); ?>",
			type: "POST",
			data: { id_vehiculo: id },
			dataType: "json",
			success: function (data) {
				console.log("Imagenes recibidas:", data);

				var tbody = $("#imagenesVehiculo");
				tbody.html("");

				var baseUrl = "<?= base_url('assets/img/taller/') ?>";

				if (data.status === "success" && data.data.length > 0) {
					// Acceder correctamente a las imágenes (el array está dentro de 'data')
					var imagenes = data.data[0]; // Accedemos a las imágenes dentro del primer elemento de 'data'
					
					imagenes.forEach(function (image) {

						var nombreImagen = image.nombre;
						console.log("Hola"+ nombreImagen);

						var row = `
								<tr id="images_${image.id}">
								<td>
									<img class="images-preview imgModelo" 
										src="${baseUrl}/${nombreImagen}" 
										alt="${nombreImagen}" 
										value="${nombreImagen}" 
										data-url="${baseUrl}/${nombreImagen}" 
										data-toggle="modal" 
										data-target="#imageModal" 
										style="cursor: pointer; max-width: 100px; margin: 5px;" />
								</td>
									
									<td><a data-toggle="modal" data-target="#image-${image.id}" href="#">${image.nombre}</a></td>
							
									<td class="f-right">
							`;
							if(image.principal == 0){
								row += `
								<a href="${baseUrl}/${id}/${image.id}); ?>" id_product="${id}" id_img="${image.id}" principal="${image.principal}" data-original-title="Cambiar a imagen principal" data-toggle="tooltip" data-placement="top" image="${image.id}" class="text-default" id="cambiarImgPrincipal">
									<span class="fa fa-star-o"></span>
								</a>
								`;
							}else if(image.principal == 1){
								row += `
								<a href="${baseUrl}/${id}/${image.id}); ?>" id_product="${id}" id_img="${image.id}" principal="${image.principal}" data-original-title="Cambiar a imagen principal" data-toggle="tooltip" data-placement="top" image="${image.id}" class="text-default" id="cambiarImgPrincipal">
									<span class="fa-solid fa-star"></span>
								</a>
								`;
							}
							row += `
										<a id="deleteImage_${image.id}" data-original-title="Borrar imagen" data-toggle="tooltip" data-placement="top" image="${image.nombre}" class="text-danger delete-image">
											<span class="fa fa-trash"></span>
										</a>

									</td>
								</tr>
							`;		
							tbody.append(row);
					});
				} else {
					tbody.append('<tr><td colspan="3">No hay imágenes disponibles.</td></tr>');
				}
			},
			error: function () {
				console.error("Error al obtener las imágenes del vehículo");
			}
		});


        // Mostrar el modal
        $('#pruebaModal').modal('show');
    });

	

	$(document).on("click", ".delete-image", function (e) {
		e.preventDefault();

		// Obtenemos los atributos del enlace
		const imageId = $(this).attr("id").replace("deleteImage_", "");
		const imageName = $(this).attr("image");

		// Codificamos el nombre de la imagen para que sea seguro para la URL
		const encodedImageName = encodeURIComponent(imageName);

		// Concatenamos la URL correctamente
		let base_url = "<?= base_url('Taller_vehiculos/delete_image/') ?>" +"/"+ imageId + "/" + encodedImageName;

		// Confirmación antes de eliminar
		if (confirm("¿Estás seguro de que quieres eliminar esta imagen?")) {
			$.ajax({
				url: base_url, // Usamos la URL concatenada correctamente
				method: "POST", // Usamos POST para mayor seguridad
				success: function (response) {
					let res = JSON.parse(response);

					if (res.status === "success") {
						alert(res.message);
						// Eliminar visualmente el elemento del DOM
						$("#deleteImage_" + imageId).closest("tr").remove();
					} else {
						alert("Error: " + res.message);
					}
				},
				error: function () {
					alert("Error en la solicitud. Intenta nuevamente.");
				}
			});
		}
	});

	$(document).on('click', '.imgModelo', function() {
		var url = $(this).data('url');
		$('#modalImage').attr('src', url);
		$('#imageModal').modal('show');
	});

	function modalEstaVisible(selector) {
		return $(selector).hasClass('in') || $(selector).hasClass('show') || $(selector).is(':visible');
	}

	$('#imageModal').on('hidden.bs.modal', function () {
		if (modalEstaVisible('#pruebaModal')) {
			$('body').addClass('modal-open');
		}
	});





	$(document).on("click", "#modalImage", function (e) {
		var $img = $(this);
		var scale =2;  // Factor de zoom
		
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




	// Acción cuando se cambia la marca
	$(document).on("change", "#marca", function () {     
		var id_marca = $(this).val();
		if (!cargaDesdeModal) {
		var modelo = $(".editarModal").closest("tr").data("modelo"); // opcional, o pásalo de otra forma

			if (id_marca) {
				$.ajax({
					url: "<?= base_url('Taller_vehiculos/get_modelos_por_marca'); ?>",
					type: "POST",
					data: { id_marca: id_marca },
					dataType: "json",
					success: function (data) {
						console.log("Modelos recibccccccidos:", data);

						var modeloSelect = document.getElementById("modelo_change");
						modeloSelect.innerHTML = data;

						// Refrescar si usas selectpicker
						$("#modelo_change").selectpicker("refresh");
						
					},
					error: function (xhr, status, error) {
						console.error("Error al obtener modelos:", xhr.responseText);
					}
				});
			}
		}else{
			cargaDesdeModal = false;
		}
	});


//------------------Fin Editar Modal----------------------------------------------------------------------------------------------------------------------------------------------

//------------------ADD Modal----------------------------------------------------------------------------------------------------------------------------------------------


    // Para los casos donde se activa el modal sin editar un vehículo
	$(document).on("click", ".activarModal", function () {       
		$("#pruebaModal input[name='id_vehiculo']").val("");

		var titulo = document.getElementById("defModalHead");
		titulo.innerHTML="Añadir vehiculo";

		document.getElementById('formModal').reset();
		$("#pruebaModal select[name='id_cliente']").val("").trigger("change");
		$("#pruebaModal select[name='nom_marca']").val("").trigger("change");
		$("#pruebaModal select[name='id_modelo']").val("").trigger("change");

		$('#pruebaModal').modal('show');
		
		$("#tablaImagenesModal").hide();
		$("#div_dropzone").hide(); // Solo si quieres ocultar Dropzone también al añadir

		$("#columna_izquierda").removeClass("col-md-6").addClass("col-md-12");
		$("#columna_izquierda_izquierda").removeClass("col-md-12").addClass("col-md-6");
		$("#columna_izquierda_derecha").removeClass("col-md-12").addClass("col-md-6");
				$("#columna_izquierda_derecha").css("margin-top", "0px");



	});

});


//------------------Fin ADD Modal----------------------------------------------------------------------------------------------------------------------------------------------


//------------------Guardar boton----------------------------------------------------------------------------------------------------------------------------------------------

	
    $(document).on("click", ".guarda_vehiculo", function () {       
		var datosFormulario = {
			id_vehiculo: $("#pruebaModal input[name='id_vehiculo']").val(),
			id_cliente: $("#pruebaModal select[name='id_cliente']").val(),
			nom_marca: $("#pruebaModal select[name='nom_marca']").val(), 
			id_modelo: $("#pruebaModal select[name='id_modelo']").val(),
			num_bastidor: $("#pruebaModal input[name='num_bastidor']").val(),
			color: $("#pruebaModal input[name='color']").val(),
			matricula: $("#pruebaModal input[name='matricula']").val(),
			fecha_matriculacion: $("#pruebaModal input[name='fecha_matriculacion']").val(),
			submit_form: true
		};
		

		$.ajax({
			url: "<?= base_url('Taller_vehiculos/vehiculos_form_ajax'); ?>",
			type: 'POST',
			data: datosFormulario,
			dataType: 'json',
			success: function(response) {
				console.log("Respuesta del servidor:", response);

				if (response.status === "success") {
					$('#pruebaModal').modal('hide');
					actualizarTablaVehiculos(response.data);

				} else {
					alert("Error en la validación: " + response.message);
				}
			},
			error: function(xhr, status, error) {
				console.error("Error AJAX:", status, error);
				console.log("Respuesta del servidor:", xhr.responseText);
				alert("Hubo un error en la solicitud.");
			}
		});
	});

	// Actualizar tabla sin recargar la página
	function actualizarTablaVehiculos(nuevaTabla, filtros) {
		if(!filtros){
			if(!nuevaTabla){

				$.ajax({
					url: "<?= base_url('Taller_vehiculos/carga_cuerpo_tabla'); ?>",
					type: 'POST',
					dataType: 'json',
					success: function(response) {
						console.log("Respuesta del servidor:", response);
						actualizarTablaVehiculos(response.data);
						
					},
					error: function(xhr, status, error) {
						console.error("Error AJAX:", status, error);
						console.log("Respuesta del servidor:", xhr.responseText);
						alert("Hubo un error en la solicitud.");
					}
				});
				return
			}
		}

		// Obtener la instancia actual de la tabla DataTable
		var tabla = $('.tabla_vehiculos').DataTable();

		// Limpiar las filas existentes
		tabla.clear();

		// Añadir las nuevas filas (asegúrate de que 'nuevaTabla' solo contenga las filas <tr>)
		tabla.rows.add($(nuevaTabla)).draw();



	}

//------------------Fin Guardar boton----------------------------------------------------------------------------------------------------------------------------------------------

</script>

<script>

//------------------Comun Editar ADD----------------------------------------------------------------------------------------------------------------------------------------------

	Dropzone.options.dropzone = {
		url: "vehiculos/subirImagen", 
		acceptedFiles: "image/*", 
		paramName: "imagen",  
		addRemoveLinks: true,  
		maxFiles: 10,
		uploadMultiple: true,
		parallelUploads: 10,
		autoProcessQueue: false,  // Desactiva el envío automático
		dictDefaultMessage: "Arrastra y suelta una imagen aquí para subirla", 

		init: function() {
			var myDropzone = this;

			// Botón para subir manualmente
			$("#btnSubirImagen").on("click", function(e) {
				e.preventDefault();
				myDropzone.processQueue();
			});

			// Aquí pasamos datos extra al backend
			this.on("sending", function(file, xhr, formData) {
				let idVehiculo = $("#id_vehiculo").val(); 
				formData.append("id_vehiculo", idVehiculo);
			});

			this.on("success", function(file, response) {
				let idVehiculo = $("#id_vehiculo").val(); 

				$.ajax({
					url: "<?= base_url('Taller_vehiculos/imagenes_ajax') ?>",
					type: 'POST',
					data: { id_vehiculo: idVehiculo},
					dataType: 'json',
					success: function(response) {

						if (response.status === "success") {
							actualizarTablaImagenes(response.nuevaTabla);
						} else {
							alert("Error en la validación: " + response.message);
						}
					},
					error: function(xhr, status, error) {
						console.error("Error AJAX:", status, error);
						console.log("Respuesta del servidor:", xhr.responseText);
						alert("Hubo un error en la solicitud.");
					}
				});
			});

			this.on("queuecomplete", function () {
				this.removeAllFiles(true);
			});

			this.on("error", function(file, response) {
				console.error("Hubo un error al subir la imagen", response);
			});
		}

	};
</script>

<script>

	// Actualizar tabla Modal Editar sin cerrar ventana
	function actualizarTablaImagenes(nuevaTabla) {
		var tbody = $('#imagenesVehiculo');
		tbody.html(nuevaTabla);
	}

	$(document).on('click', '#cambiarImgPrincipal', function(e) {
		e.preventDefault();

		var id_vehiculo = $(this).attr('id_product'); //Id del vehculo que vamos a modificar

		var id_img = $(this).attr('id_img'); // Id de la imagen que queremos poner en principal o viceversa

		var principalONo = $(this).attr('principal'); //Guarda si es principal

		var contadorPrincipal = 0; // Nos servira para comprobar internamente si es principal o no

		var imgPrincipal = null; // Cuando encontremos una img principal, la guardamos aqui

		// poner ajax para pasar la informacion a tratar

		$.ajax({
			url: "<?= base_url('Taller_vehiculos/imagenes_ajax') ?>",
			type: "POST",
			data: { id_vehiculo: id_vehiculo, id_img: id_img, principalONo: principalONo },
			dataType: "json",
			success: function (response) {
			
				if (response.status === 'success') {
					console.log(response.nuevaTabla);
					actualizarTablaImagenes(response.nuevaTabla);
				} else {
					console.log("No hay Img o no salio bien");
				}

			}
		});

	});

	//Para actualizar la tabla


//------------------Fin Comun Editar ADD----------------------------------------------------------------------------------------------------------------------------------------------

$(document).ready(function () {

		$(document).on("click", ".fichaModal", function () {

			var info = $(this).data('info');

			console.log(info);

			if (!info){

			// Obtener los datos del vehículo de la fila seleccionada
					var fila = $(this).closest("tr");


					var id = fila.data("id");
					var cliente = fila.data("cliente");
					var id_marca = fila.data("marca");
					var id_modelo = fila.data("modelo");
					var matricula = fila.data("matricula");

					$("#id_vehiculo").val(id);

					var id_vehiculo = $("#id_vehiculo").val();
					console.log("id_vehiculo:", id_vehiculo);

					console.log(id + cliente + id_marca + id_modelo);

					// 🔄 Resetear formulario ANTES de abrir modal
					$("#formPasoAPaso")[0].reset();

					$('.selectpicker').selectpicker('refresh');

					$('#selectorHoras').empty();

					$('#modal_ficha_cita').modal('show');

					$.ajax({
							url: "<?= base_url('Taller_vehiculos/modal_info_cliente'); ?>",
							type: "POST",
							data: { id_marca: id_marca, id_modelo: id_modelo, cliente: cliente, id: id, matricula: matricula },
							dataType: "json",
							success: function (data) {

								var id_vehiculo = document.querySelector("#id_vehiculo").value;

								$("#modal_ficha_cita label[for='nombreUsu']").text(data.cliente);

								$("#modal_ficha_cita label[for='nomCocheUsuMarca']").text(data.marca);
								$("#modal_ficha_cita label[for='nomCocheUsuModelo']").text(data.modelo);
								$("#modal_ficha_cita label[for='nomCocheUsuMatricula']").text(matricula);

							},
							error: function (xhr, status, error) {
								console.error("No funcionoOOO", xhr.responseText);
							}
						});

			}else{
				// En caso de tener cita o citas

				$('#modalCitaExistente').modal('show');

				var fila = $(this).closest("tr");
				var id = fila.data("id");

				console.log(info + " Este coche ya tiene cita o citas, ID: " + id);

				$('#btnNuevaCita').off('click').on('click', function () {
					// Aquí puedes agregar la lógica para añadir una nueva cita
					$('#modalCitaExistente').modal('hide');
					$('#modal_ficha_cita').modal('show');
				});

				$('#btnVerCita').off('click').on('click', function () {
					// Aquí puedes agregar la lógica para ver la cita existente
					$('#modalCitaExistente').modal('hide');
					
					var idVehiculo = id;
					var url = '<?= base_url("citas") ?>?id=' + encodeURIComponent(idVehiculo);
					window.open(url, '_blank');

					// var url = '<?= base_url("citas") ?>';

					// //window.open(url, '_blank');

					// var form = $('<form>', {
					// 	method: 'POST',
					// 	action: url,
					// 	target: '_blank'
					// }).append($('<input>', {
					// 	type: 'hidden',
					// 	name: 'id',
					// 	value: id
					// }));

					// // Agregar el formulario al body, enviarlo y luego eliminarlo
					// form.appendTo('body').submit().remove();
				});

			}

		

});


});



//BOTONES
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
			$.ajax({
				url: '<?= base_url("Taller_vehiculos/obtenerHorasDisponibles") ?>',
				type: 'POST',
				data: {
					tarea_id: tarea_id,
					fecha: fecha
				},
				dataType: 'json',
				success: function (respuesta) {
					let horas = respuesta.horas;
					let citas = respuesta.citas;
					let simultaneo = respuesta.simultaneo;

					let html = '';
					if (horas.length > 0) {
						horas.forEach(hora => {
							console.log("Cantidad de citas: " + citas[hora]);

							let cantidadCitas = citas[hora] || 0;
							console.log(cantidadCitas);
							let clase = (cantidadCitas >= simultaneo) ? 'btn-danger' : 'btn-primary hora_select';

							html += `<button type="button" class="btn ${clase} m-1 btn-hora" style="margin:5px; min-width:63px">${hora}</button>`;
						});
					} else {
						html = '<p class="text-danger">No hay tramos disponibles.</p>';
					}

					$('#selectorHoras').html(html);
				},
				error: function (xhr, status, error) {
					console.error("Error al obtener las horas disponibles:", xhr.responseText);
					$('#selectorHoras').html('<p class="text-danger">Error al cargar las horas disponibles.</p>');
				}
			});

		}
		else if (!tarea_id) {
			$('#selectorHoras').html('<p class="">Selecciona un área de trabajo.</p>');
		} else if (!fecha) {
			$('#selectorHoras').html('<p class="">Selecciona una fecha.</p>');
		}
	});



$(document).on("click", ".hora_select", function (event) {
    var textoBoton = $(this).text(); // variable local
    var botonesHora = $('button.hora_select').toArray();
	var id_vehiculo = document.querySelector("#id_vehiculo").value;

	console.log(id_vehiculo);


    $(botonesHora).each(function(index, boton) {
        $(boton).css('background-color', '#0081C6');
        $(boton).css('color', 'white');
    });

    $(this).css({
        'background-color': 'green',
        'color': 'black'
    });

    // ✅ Guardar el texto seleccionado en el propio botón de pedir cita (temporalmente)
    $("#pedirCita").data("textoBoton", textoBoton);
	$("#pedirCita").data("id_vehiculo", id_vehiculo);

    console.log("evento done HOAS: " + textoBoton + "ID VEHICULO: " + id_vehiculo);
});

$(document).on("click", "#pedirCita", function (event) {
    event.preventDefault();

    var textoBoton = $(this).data("textoBoton") || ""; // recuperar el texto guardado
    var id_vehiculo = $(this).data("id_vehiculo") || "";


    console.log("Evento pedir cita");
    console.log("Texto botón:", textoBoton);
    console.log("ID vehículo:", id_vehiculo);

    var fecha = $("#fecha").val();
    let datos = $("#formPasoAPaso").serializeArray();
    var base_url = "<?= base_url(); ?>";

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
        url: base_url + "Taller_vehiculos/add_cita",
        type: "POST",
        data: { datos: datos, textoBoton: textoBoton, fecha: fecha, id_vehiculo: id_vehiculo },
        dataType: "json",
        success: function (data) {
            console.log("Funciono :)", data);
			actualizarTablaVehiculos();
        },
        error: function (xhr, status, error) {
            console.error("No funcionoOOO", xhr.responseText);
        }
    });
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

<script>
$(document).ready(function () {
    let botonPresionado = null;
	let filtros = true;

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
            url: "<?= base_url('Taller_vehiculos/carga_cuerpo_tabla') ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                console.log(response.data);
                actualizarTablaVehiculos(response.data, filtros);
            },
            error: function (xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                console.error("Respuesta completa:", xhr.responseText)
            }
        });
    });
});


  $('#buscarMarca').on('change', function () {

	const id_marca = $(this).val();
	var modeloSelect = document.getElementById("buscaModelo");
	console.log(id_marca);

	if (!id_marca) {
        modeloSelect.innerHTML = '<option value="">-- No seleccionar --</option>';
        $('#buscaModelo').selectpicker('refresh');
        return; // salimos de la función
    }
    
	$.ajax({
            url: "<?= base_url('Taller_vehiculos/get_modelos_por_marca') ?>",
            type: "POST",
            data: { id_marca: id_marca },
            dataType: "json",
            success: function (data) {
                console.log("Modelos recibbbbbidos:", data);

                modeloSelect.innerHTML = data;

				$('#buscaModelo').selectpicker('refresh');

            },
            error: function (xhr, status, error) {
                console.error("Error al obtener modelos:", xhr.responseText);
            }
        });

  });
</script>

<script>

	$('.mostrar_filtros').on('click', function() {
		if ($('#filtro_modal').hasClass('hidden')) {
			$('#filtro_modal').removeClass('hidden')
		} else {
			$('#filtro_modal').addClass('hidden')
		}
	})

</script>

<script>

$(document).ready(function () {
	const alturaDisponible = window.innerHeight - 250; // Ajusta según tu layout

	$('.tabla_vehiculos').DataTable({
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
	});
});

$('.selectpicker').selectpicker({
    container: 'body'
});
</script>

<?php if ($this->input->get('nueva') == 1): ?>
<script>
    $(document).ready(function() {
        $('.activarModal').trigger('click');
    });
</script>
<?php endif; ?>



	

