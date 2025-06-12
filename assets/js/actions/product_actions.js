var ProductActions = {

	UpdateProduct : function() {

		//$(".switch-small.actualiza").on("click", function() { 
			$(document).delegate(".switch-small.actualiza",'click',function() {

			var input = $(this).children('input');
			var id = $(this).attr('id');
			var item = $(this).attr('dir');
			var value = input.val();
			if(item != 'pack'){
			
			var text = '¡Editado con éxito!';

			var type = 'POST';
			var url = site_url + '/productos/update_ajax';
			

			if (value == 1) {

				input.val(0);
				input.prop("checked", false);
				if(item == 'view_product'){
					$(this).attr('data-original-title', 'Ocultar producto en la tienda');
				}
				value = 0;
				

			} else {

				input.val(1);
				input.prop("checked", true);
				if(item == 'view_product'){
					$(this).attr('data-original-title', 'Mostrar producto en la tienda');
				}
				
				value = 1;
			}

			var data = {
				'value' : value,
				'id' : id,
				'item' : item
			};

			ActionAjax(type, url, data, null, text);
			location.reload();

			return false;
		}
		});
	},

	// OptionsProduct : function() {
// 
		// var action;
// 
		// $(".price").keyup(function() {
// 
			// var id = $(this).attr('dir');
			// var item = $(this).attr('id');
			// var value = $(this).val();
			// var text = 'El campo se ha actualizado';
// 
			// action = setTimeout(function() {
// 
				// var type = 'POST';
				// var url = site_url + '/productos/update_ajax';
				// var data = {
					// 'value' : value,
					// 'id' : id,
					// 'item' : item
				// };
// 
				// ActionAjax(type, url, data, null, text, false, false);
// 
			// }, 2000);
// 
		// });
// 
		// $(".price").keypress(function() {
// 
			// clearTimeout(action);
		// });
// 
	// },

	// CategoryProduct : function() { //Mostrar select con subcategorias
// 
		// var action;
// 
		// $("#category").on('change', function() {
// 
			// if ($(this).val() == 0) {
				// $('#subcategory').css('display', 'none');
			// } else {
				// var lang = $(this).attr('lang');
				// var sub =$(this).attr('sub');
				// var id = $(this).val();
				// var text = 'OK';
				// var type = 'POST';
				// var url = site_url + '/productos/get_subcategory';
				// var data = {
					// 'id' : id,
					// 'lang' : lang
				// };
				// $("#subcategory").html('');
				// var returndata = ActionAjax(type,url,data,null,text,true);
	    		// var social_select = "";
	    		// result = JSON.parse(returndata);
// 	    		
	    		// $("#subcategory").append('<option value="0"></option>');
// 
				// $.each(result, function(i, val) {
// 					
					// if(sub==val.id){
// 						
						// $("#subcategory").append('<option value="' + val.id + '" selected>' + val.name+ '</option>');
// 						
					// }else{
// 						
						// $("#subcategory").append('<option value="' + val.id + '">' + val.name+ '</option>');	
					// }
// 					
// 					
// 					
				// });
				// $('#subcategory').css('display', '');
// 
			// }
// 
		// });
// 
	// },

	// CheckProduct : function() {
// 
		// var action;
// 
		// $(".check-product").on('ifChecked', function() {
// 
			// var id = $(this).attr('dir');
			// var item = $(this).attr('id');
			// var value = $(this).val();
			// var aux = $(this).attr('text');
			// var text = 'Producto marcado como '+aux+'.';
// 
			// action = setTimeout(function() {
// 
				// var type = 'POST';
				// var url = site_url + '/productos/update_ajax';
				// var data = {
						// 'value' : value,
						// 'id' : id,
						// 'item' : item
					// };
// 
				// ActionAjax(type, url, data, null, text, false, false);
// 
			// }, 2000);
// 
		// });
		// $(".check-product").on('ifUnchecked', function() {
			// var id = $(this).attr('dir');
			// var item = $(this).attr('id');
			// var value = 0;
			// var aux = $(this).attr('text');
			// var text = 'Producto desmarcado '+aux+'.';
// 
			// action = setTimeout(function() {
// 
				// var type = 'POST';
				// var url = site_url + '/productos/update_ajax';
				// var data = {
						// 'value' : value,
						// 'id' : id,
						// 'item' : item
					// };
// 
				// ActionAjax(type, url, data, null, text, false, false);
// 
			// }, 2000);
		// });
// 
	// },

	SubmitForm : function() {

		// $(".btn-form-data").click(function() {
// 
			// var form = $(this).attr('dir');
// 			
			// $('#ficha-producto').submit();
			// $('#' + form).submit();
// 
		// });

		$('.btn-upload').change(function() {

			//var form = $(this).attr('dir');
			
			$('<input>').attr({
			    type: 'hidden',
			    id: 'submit_form',
			    name: 'submit_form'
			}).appendTo('#ficha-producto');
			
			//$('#' + form).submit();
			$('#ficha-producto').submit();
			
		});
	},

	// HideShowCategory : function() {
// 
		// $(".switch-small").on("click", function() {
// 
			// var input = $(this).children('input');
			// var id = $(this).attr('id');
			// var value = input.val();
			// var text = "";
// 
			// var type = 'POST';
			// var url = site_url + '/productos/update_ajax';
// 
			// if (value == 1) {
// 
				// input.val(0);
				// input.prop("checked", false);
				// $(this).attr('data-original-title', 'Destacar categoría');
				// value = 0;
				// text = 'El producto ha sido ocultado';
// 
			// } else {
// 
				// input.val(1);
				// input.prop("checked", true);
				// $(this).attr('data-original-title', 'No destacar categoría');
				// value = 1;
				// text = 'El producto ahora es visible';
			// }
// 
			// var data = {
				// 'value' : value,
				// 'id' : id,
				// 'item' : 'view_product'
			// };
// 
			// ActionAjax(type, url, data, null, text);
// 
			// return false;
// 
		// });
// 
	// },

	DeleteImage : function() {

		$(".delete-image").click(function() {

			var id_product = $(this).attr('id_product');
			var id = $(this).attr('id');
			var image = $(this).attr('image');
			var text = 'La imagen ha sido eliminada con éxito';
			var type = 'post';
			var url = site_url + '/productos/delete_image_carrusel';
			var data = {
				'id_product' : id_product,
				'id' : id,
				'image' : image
			};

			ActionAjax(type, url, data, null, text, false, false);

			$('#images_' + id).hide();

		});
		
		$("body").on("click", ".dz-remove", function() {
		
		    var image = $(this).attr('image');
			var id_product = $('#id_proyecto').val();
			var url = $('#url_delete').val();
			var parent = $(this).parent('.dz-preview');
			
			var text = 'La imagen ha sido eliminada con éxito';
			var type = 'post';
			var data = {
				'id_product' : id_product,
				'image' : image
			};

			ActionAjax(type, url, data, null, text, false, false);	
			
			parent.addClass('dz-deleted');
			parent.hide();
			
			if($('.dz-deleted').length == $('.dz-preview').length){
				$('#images-upload').removeClass('dz-started');
			}
		});
	},

	 CopyURL : function() {
        	
        $( ".copy-url" ).on("click",function(){
        	
        	var url = $(this).val();
        	
        	var aux = document.createElement("input");
			aux.setAttribute("value", url);
			document.body.appendChild(aux);
			aux.select();
			document.execCommand("copy");
			document.body.removeChild(aux);
        	
        	var title = "Se ha copiado al portapapeles el enlace";
        	
        	noty({text: title, layout: 'topCenter', type: 'success'});
			setTimeout(function() {$("#noty_topCenter_layout_container").fadeOut(1500);},3000);
			setTimeout(function() {$("ul").remove("#noty_topCenter_layout_container");},4000);

		});

    }
}
$(window).load(ProductActions.UpdateProduct);
// $(window).load(ProductActions.CategoryProduct);
// $(window).load(ProductActions.OptionsProduct);
// $(window).load(ProductActions.CheckProduct);
$(window).load(ProductActions.SubmitForm);
// $(window).load(ProductActions.HideShowCategory);
$(window).load(ProductActions.DeleteImage);
$(window).load(ProductActions.CopyURL);