<script>

	document.addEventListener("DOMContentLoaded", function () {
		function inicializa_tabla() {
			// Vuelve a inicializar el DataTable
			$('.tabla_usuarios').DataTable({
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

		$(document).on("click", ".activarModal", function (event) {
			event.preventDefault();
			$('#formUsuario')[0].reset();
			$('#usuario_id').val('');
			document.getElementById("firmaBase64").value = "";
			limpiarFirma();

			$('.alert').remove();

			$('#modalUsuario').modal('show');
		});

		
		// Función para manejar el envío del formulario
		$('#formUsuario').on('submit', function (e) {
			e.preventDefault();

			// Guarda la firma antes de enviar el formulario
			guardarFirma();

			var formData = new FormData(this);
			var usuarioId = $('#usuario_id').val();
			var url = usuarioId ? "<?= base_url('taller_usuarios/actualizar_usuario') ?>" : "<?= base_url('taller_usuarios/guardar_usuario') ?>";

			$.ajax({
				url: url,
				method: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function (response) {
					if (response.status === 'success') {
						alert(usuarioId ? 'Usuario actualizado con éxito' : 'Usuario guardado con éxito');
						$('#modalUsuario').modal('hide');
						cargarTabla();
					} else {
						alert('Error: ' + response.message);
					}
				},
				error: function (xhr, status, error) {
					console.log("Respuesta del servidor:", xhr.responseText);
					alert('Error al procesar la solicitud');
				}
			});
		});

		$(document).on("click", ".eliminar_usuario", function (event) {
			event.preventDefault();

			var usuarioId = $(this).data('usuario-id');
			console.log("ID del usuario a eliminar:", usuarioId);

			if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
				$.ajax({
					url: "<?= base_url('taller_usuarios/eliminar_usuario') ?>",
					method: 'POST',
					data: { usuario_id: usuarioId },
					dataType: 'json',
					success: function (response) {
						if (response.status === 'success') {
							alert('Usuario eliminado con éxito');
							cargarTabla();
						} else {
							alert('Error al eliminar el usuario: ' + response.message);
						}
					},
					error: function (xhr, status, error) {
						console.log("Respuesta del servidor:", xhr.responseText);
						console.log("Estado de la solicitud:", status);
						console.log("Error:", error);
						alert('Error al eliminar el usuario');
					}
				});
			}
		});

		$(document).on("click", ".editar_usuario", function (event) {
			limpiarFirma();

			var usuarioId = $(this).data('usuario-id');

			$.ajax({
				url: "<?= base_url('taller_usuarios/obtener_usuario') ?>",
				method: 'POST',
				data: { usuario_id: usuarioId },
				dataType: 'json',
				success: function (response) {
					if (response.status === 'success') {
						var usuario = response.data;
						$('#usuario_id').val(usuario.id);
						$('#nombre').val(usuario.nombre);
						$('#email').val(usuario.email);
						$('#rol').val(usuario.rol);
						$('#password').val(usuario.password);

						// Cargar la firma si existe
						if (usuario.firma) {
							cargarFirma(usuario.firma);
						}

						$('#modalUsuario').modal('show');
					} else {
						alert('Error al cargar los datos del usuario: ' + response.message);
					}
				},
				error: function (xhr, status, error) {
					console.log("Respuesta del servidor:", xhr.responseText);
					alert('Error al cargar los datos del usuario');
				}
			});
		});


		function cargarTabla() {
			$.ajax({
				url: "<?= base_url('taller_usuarios/listar_usuarios') ?>",
				method: 'POST',
				dataType: 'json',
				success: function (response) {
					if (response.status === 'success') {

						$('.tabla_usuarios tbody').empty(); // Limpia la tabla antes de agregar nuevos datos
						$('.tabla_usuarios tbody').append(response.data)
						console.log("Datos de usuarios:", response.data);
					} else {
						alert('Error al cargar los usuarios: ' + response.message);
					}
				},
				error: function (xhr, status, error) {
					console.log("Respuesta del servidor:", xhr.responseText);
					alert('Error al cargar los usuarios');
				}
			});
		}


		// Manejar el evento de clic en el botón de buscar
		$('#submit_filtrar').on('click', function(event) {
			event.preventDefault(); // Evita que el formulario se envíe
			var nombre = $('#buscarNombre').val();
			var email = $('#buscarEmail').val();
			var rol = $('#buscarRol').val();

			$.ajax({
				url: "<?= base_url('taller_usuarios/filtrar_usuarios') ?>",
				method: 'POST',
				data: { nombre: nombre, email: email, rol: rol },
				dataType: 'json',
				success: function(response) {
					if (response.status === 'success') {
						$('.tabla_usuarios tbody').empty();
						$('.tabla_usuarios tbody').append(response.data);
					} else {
						alert('Error al filtrar usuarios: ' + response.message);
					}
				},
				error: function(xhr, status, error) {
					console.log("Respuesta del servidor:", xhr.responseText);
					alert('Error al filtrar usuarios');
				}
			});
		});

		// Manejar el evento de clic en el botón de "Ver todo"
		$('#submit_ver_todos').on('click', function(event) {
			event.preventDefault(); // Evita que el formulario se envíe
			$('#buscarNombre').val('');
			$('#buscarEmail').val('');
			$('#buscarRol').val('');

			$.ajax({
				url: "<?= base_url('taller_usuarios/listar_usuarios') ?>",
				method: 'POST',
				dataType: 'json',
				success: function(response) {
					if (response.status === 'success') {
						$('.tabla_usuarios tbody').empty();
						$('.tabla_usuarios tbody').append(response.data);
					} else {
						alert('Error al cargar los usuarios: ' + response.message);
					}
				},
				error: function(xhr, status, error) {
					console.log("Respuesta del servidor:", xhr.responseText);
					alert('Error al cargar los usuarios');
				}
			});
		});

	});

	// Función para cargar la firma en el canvas
		function cargarFirma(rutaFirma) {
			const canvas = document.getElementById("firmaCanvas");
			const ctx = canvas.getContext("2d");
			const img = new Image();
			img.onload = function () {
				ctx.clearRect(0, 0, canvas.width, canvas.height);
				ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
			};
			img.src = rutaFirma;
		}

		// Función para guardar la firma como base64
		function guardarFirma() {
			const canvas = document.getElementById("firmaCanvas");
			const dataURL = canvas.toDataURL("image/png");
			document.getElementById("firmaBase64").value = dataURL;
		}

		// Lógica de dibujo en el canvas con ajuste para zoom y tamaño real
		let pintando = false;
		const canvas = document.getElementById("firmaCanvas");
		const ctx = canvas.getContext("2d");
		let lastX, lastY;

		function getCanvasCoords(e) {
			const rect = canvas.getBoundingClientRect();
			const scaleX = canvas.width / rect.width;
			const scaleY = canvas.height / rect.height;
			let clientX, clientY;
			if (e.touches && e.touches.length > 0) {
				clientX = e.touches[0].clientX;
				clientY = e.touches[0].clientY;
			} else {
				clientX = e.clientX;
				clientY = e.clientY;
			}
			return {
				x: (clientX - rect.left) * scaleX,
				y: (clientY - rect.top) * scaleY
			};
		}

		canvas.addEventListener("mousedown", (e) => {
			pintando = true;
			const pos = getCanvasCoords(e);
			lastX = pos.x;
			lastY = pos.y;
			ctx.beginPath();
			ctx.moveTo(lastX, lastY);
		});

		canvas.addEventListener("mouseup", () => {
			pintando = false;
		});

		canvas.addEventListener("mouseleave", () => {
			pintando = false;
		});

		canvas.addEventListener("mousemove", (e) => {
			if (!pintando) return;
			const pos = getCanvasCoords(e);
			ctx.lineWidth = 2;
			ctx.lineCap = "round";
			ctx.strokeStyle = "#000";
			ctx.lineTo(pos.x, pos.y);
			ctx.stroke();
			ctx.beginPath();
			ctx.moveTo(pos.x, pos.y);
			lastX = pos.x;
			lastY = pos.y;
		});

		// Soporte para pantallas táctiles
		canvas.addEventListener("touchstart", (e) => {
			e.preventDefault();
			pintando = true;
			const pos = getCanvasCoords(e);
			lastX = pos.x;
			lastY = pos.y;
			ctx.beginPath();
			ctx.moveTo(lastX, lastY);
		});

		canvas.addEventListener("touchend", (e) => {
			e.preventDefault();
			pintando = false;
		});

		canvas.addEventListener("touchcancel", (e) => {
			e.preventDefault();
			pintando = false;
		});

		canvas.addEventListener("touchmove", (e) => {
			e.preventDefault();
			if (!pintando) return;
			const pos = getCanvasCoords(e);
			ctx.lineWidth = 2;
			ctx.lineCap = "round";
			ctx.strokeStyle = "#000";
			ctx.lineTo(pos.x, pos.y);
			ctx.stroke();
			ctx.beginPath();
			ctx.moveTo(pos.x, pos.y);
			lastX = pos.x;
			lastY = pos.y;
		});

		// Función para limpiar la firma
		window.limpiarFirma = function () {
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			document.getElementById("firmaBase64").value = "";
		};

		function isCanvasVacio(canvas) {
			const context = canvas.getContext('2d');
			const pixelBuffer = new Uint32Array(
				context.getImageData(0, 0, canvas.width, canvas.height).data.buffer
			);
			return !pixelBuffer.some(color => color !== 0);
		}

</script>