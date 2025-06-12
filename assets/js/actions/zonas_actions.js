var ProductActions = {


	getProvincias : function() { //Mostrar select con subcategorias

		var action;

		$("#id_pais").on('change', function() {

			if ($(this).val() == 0) {
				$('#provincia-group').slideToggle();
			} else {
				
				var id = $(this).val();
				var id_zona = $('#id_zona').val();
				var type = 'POST';
				var url = site_url + '/zonas/get_provincias';
				var data = {
					'id' : id,
					'id_zona' : id_zona
				};
				
				var returndata = ActionAjax(type,url,data,null,false,true);
	    		result = JSON.parse(returndata);
	    		
	    		$("#id_provincia").html(result);
				
				if($('#provincia-group').css('display') == 'none'){
				
					$('#provincia-group').slideToggle();
				}
			}

		});

	},

	
}

$(window).load(ProductActions.getProvincias);