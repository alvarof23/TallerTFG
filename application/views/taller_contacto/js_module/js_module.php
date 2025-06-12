<script>
	

$(document).ready(function(){


	$('.contact-method').on('click', function() {
		const texto = $(this).text().trim(); // ✔ Extrae el texto del elemento clicado
		navigator.clipboard.writeText(texto).then(() => {
			const alerta = document.getElementById('copiado-alerta');
			alerta.style.display = 'block';
			setTimeout(() => {
				alerta.style.display = 'none';
			}, 1500);
		});
	});

	$('#contactForm').on('submit', function(e){
		e.preventDefault();

		$.ajax({
			url: '<?= base_url('taller_contacto/enviar') ?>',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function(response){
				$('#formMessage')
					.removeClass('alert-info alert-danger alert-success')
					.addClass(response.success ? 'alert-success' : 'alert-danger')
					.text(response.msg)
					.show();

				if (response.success) {
					$('#contactForm')[0].reset(); // Limpia el formulario
				}
			},
			error: function(){
				$('#formMessage')
					.removeClass('alert-success')
					.addClass('alert-danger')
					.text('Error inesperado al enviar el formulario.')
					.show();
			}
		});
	});


});
</script>