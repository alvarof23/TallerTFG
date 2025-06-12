var ActionContact = {

    HideShowField: function() {
    	
    	$( ".list-group-item" ).on("click",function(){
    		
    		var id = $(this).attr('id');
    		var viewfield = $(this).attr('viewfield');
    		
    		var type = 'POST';
        	var url = site_url+'/contacto/viewfield';
    		var data = {'viewfield':viewfield,'id':id};
    		
    		if(viewfield == 0){
    			
    			var text = 'Campo activado con éxito';
    			
    		}else{
    			
    			var text = 'Campo desactivado con éxito';
    		}
    		
    		if(ActionAjax(type,url,data,null,text)){
    			
				if(viewfield == 0){
			
	    			$(this).attr('viewfield',1);
	    			$('.check-'+id).css('color', '#95B75D'); 
	    			
	    		}else{
	    			
	    			$(this).attr('viewfield',0);
	    			$('.check-'+id).css('color', '#7F848A');
	    		}
    		}
    		
    		return false;
    		
    	});
    },
    
    AddSocial: function() {
    	
    	$("body").on("change", "#social-list", function(e){
			e.preventDefault();
			
			var id = $(this).find("option:selected").val();
			var  div = $('#social-select');
			
			var type = 'POST';
        	var url = site_url+'/contacto/update_social';
    		var data = {'id':id,'viewsocial':1};
    		var text = 'Red social añadida con éxito';
    		
    		var returndata = ActionAjax(type,url,data,null,text,true);
    		var social_select = "";
    		result = JSON.parse(returndata);
			location.reload();
    		
    		$.each(result[1], function(i, val){
	 			
	 			social_select +='<div class="alert">';
		 			social_select +='<div class="col-xs-12"><strong>'+ val.name_social +'</strong></div>';
					social_select +='<div class="form-group">';
						social_select +='<div class="col-xs-10"><input id="input_'+ val.id +'" value="'+ val.url_social +'" type="text" placeholder="URL" class="form-control url-social"></div>';
						social_select +='<div class="col-xs-2">';
							social_select +='<button id="'+ val.id +'" class="text-danger pull-right delete-social" type="button"><i class="fa fa-trash"></i></button>';
							social_select +='<button id="'+ val.id +'" class="text-primary pull-right save-social" type="button"><i class="fa fa-save"></i></button>';
						social_select +='</div>';
					social_select +='</div>';
				social_select +='</div>';
 
			});
    		
    		div.html(social_select);
			
		});
    	
    },
    
    DeleteSocial: function() {
    	
    	$("body").on("click", ".delete-social", function(e){
    		e.preventDefault();
    		
    		var id = $(this).attr("id");
    		var div = $('#social-select');
    		
    		var type = 'POST';
        	var url = site_url+'/contacto/update_social';
    		var data = {'id':id,'viewsocial':0};
    		var text = 'Red social eliminada con éxito';
    		
    		var returndata = ActionAjax(type,url,data,null,text,true);
    		var social_select = "";
    		result = JSON.parse(returndata);
    		location.reload();
    		$.each(result[1], function(i, val){

								
				social_select +='<div class="alert">';
		 			social_select +='<div class="col-xs-12"><strong>'+ val.name_social +'</strong></div>';
					social_select +='<div class="form-group">';
						social_select +='<div class="col-xs-10"><input id="input_'+ val.id +'" value="'+ val.url_social +'" type="text" placeholder="URL" class="form-control url-social"></div>';
						social_select +='<div class="col-xs-2">';
							social_select +='<button id="'+ val.id +'" class="text-danger pull-right delete-social" type="button"><i class="fa fa-trash"></i></button>';
							social_select +='<button id="'+ val.id +'" class="text-primary pull-right save-social" type="button"><i class="fa fa-save"></i></button>';
						social_select +='</div>';
					social_select +='</div>';
				social_select +='</div>';
 
			});
    		
    		div.html(social_select);
    		
    	});	
    },
    
     GetUrlSocial: function() {
    	
    	$("body").on("click", ".save-social", function(e){
    		e.preventDefault();
    		
    		var id = $(this).attr("id");
    		var val = $('#input_'+id).val();
			var id_portal= $('#id_portal_'+id).val();

    		var type = 'POST';
        	var url = site_url+'/contacto/update_social';
    		var data = {'id':id,'val':val,'id_portal':id_portal};
    		var text = 'URL guardada con éxito';
    		
    		ActionAjax(type,url,data,null,text);
    		
    	});	
    		
     },
     
     UpdateServer: function() {
     	
     	$("body").on("click", ".update-server", function(e){
    		e.preventDefault();
    		
    		var email = $('#email_server').val();
    		var protocol = $('#protocol_server').val();
    		var host = $('#host_server').val();
    		var port = $('#port_server').val();
    		var user = $('#user_server').val();
    		var pass = $('#pass_server').val();

    		var type = 'POST';
        	var url = site_url+'/contacto/update_server_comentarios';
    		var data = {'email':email,'protocol':protocol,'host':host,'port':port,'user':user,'pass':pass};
    		var text = 'Servidor configurado con éxito';
    		
    		ActionAjax(type,url,data,null,text);
    		
    	});	
    		
	},
	 UpdateServerEmails: function() {
		$("body").on("click", ".update-server-contacto", function(e){
    		e.preventDefault();
    		
    		var email = $('#email').val();
    		var comentarios = $('#comentarios').val(); 
    		var pedidos=$('#pedidos').val();

    		var type = 'POST';
        	var url = site_url+'/contacto/update_server';
    		var data = {'email':email,'comentarios':comentarios,'pedidos':pedidos};
    		var text = 'Servidor configurado con éxito';

    		ActionAjax(type,url,data,null,text);
    		
    	});	
     },
     
     SetDataContact: function() {
     	
     	$("body").on("click", ".add-data", function(e){
    		e.preventDefault();
    		var id_portal=$('#id_portal').val();
    		var name = $('#name_data').val();
    		var address = $('#address_data').val();
    		var city = $('#city_data').val();
    		var zip = $('#zip_data').val();
    		var phone = $('#phone_data').val();
    		var fax = $('#fax_data').val();
    		var email = $('#email_data').val();
    		var map = $('#map_data').val();
    		var div = $('#data-contact');

    		var type = 'POST';
        	var url = site_url+'/contacto/set_data';
    		var data = {'id_portal':id_portal,'name':name,'address':address,'city':city,'zip':zip,'phone':phone,'fax':fax,'email':email,'map':map};
    		var text = 'Contacto creado con éxito';
    		
    		var returndata = ActionAjax(type,url,data,null,text,true);
    		var html = "";
    		result = JSON.parse(returndata);
    		
    		// $.each(result, function(i, val){
//     			
	 			// html +='<tr>';
	 			// html +='<td>'+ val.description +'</td>';
				// html +='<td style="color:#A84140; padding: 15px 0px" class="text-right">-'+ val.cost +'€</td>';
				// html +='<td style="padding: 15px 30px 0 0"><button id="'+'" class="close delete-data" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button></td>';
				// html +='</tr>';
//  
			// });
    		
    		div.html(result);
			location.reload();
    		
    	});	
    		
     },
     
     DeleteDataContact: function() {
     	
     	$("body").on("click", ".delete-data", function(e){
    		e.preventDefault();
    		
    		var id = $(this).attr("id");
    		var div = $('#data-contact');

    		var type = 'POST';
        	var url = site_url+'/contacto/delete_data';
    		var data = {'id':id};
    		var text = 'Contacto eliminado con éxito';
    		
    		var returndata = ActionAjax(type,url,data,null,text,true);
    		var html = "";
    		result = JSON.parse(returndata);

    		div.html(result);
			location.reload();
    		
    	});	
    		
     },
     
     GetUpdateDataContact: function() {
  
     	$(document).delegate( ".get-update-data","click", function(e){
    		e.preventDefault();
    		
    		var id = $(this).attr("id");
    		var id_portal=$("#id_portal");
    		var name = $('#name_data');
    		var address = $('#address_data');
    		var city = $('#city_data');
    		var zip = $('#zip_data');
    		var phone = $('#phone_data');
    		var fax = $('#fax_data');
    		var email = $('#email_data');
    		var map = $('#map_data');
    		var div = $('.content-buttons');
			var button_add=$('.add-data');
    		var button_update = $('.update-data');
    		
		
    		var type = 'POST';
        	var url = site_url+'/contacto/get_data';
    		var data = {'id':id};
    		var text = 'Contacto eliminado con éxito';
    		
    		var returndata = ActionAjax(type,url,data,null,null,true);
    	
    		var html = "";
    		
    		result = JSON.parse(returndata);
			id_portal.val(result.id_portal);
			id_portal.selectpicker('refresh');
			name.val(result.name_data);
    		address.val(result.address_data);
    		city.val(result.city_data);
    		zip.val(result.zip_data);
    		phone.val(result.phone_data);
    		fax.val(result.fax_data);
    		email.val(result.email_data);
    		map.val(result.map_data);
    		button_add.remove();
    		div.append('<button id="'+result.id+'" class="btn btn-primary pull-right update-data" name="submit_form" type="button"><span class="fa fa-save"></span> Guardar dirección</button>');
    		//location.reload();
    	});	
    		
     },
     
     PrincipalDataContact: function(){
     	$(document).delegate(".principal-data","click",  function(e){
    		e.preventDefault();
    		
    		var id = $(this).attr("id");
    		
    		var type = 'POST';
        	var url = site_url+'/contacto/principal_data';
    		var data = {'id':id};
    		var text = 'Contacto actualizado con éxito';
    		
			var returndata = ActionAjax(type,url,data,null,text,true);
			
			location.reload(); 
    		});	
     },
     
     UpdateDataContact: function() {
     	
     	$(document).delegate(".update-data","click",  function(e){
    		e.preventDefault();
           
    		
    		var id = $(this).attr("id");
    		var name = $('#name_data').val();
    		var address = $('#address_data').val();
    		var city = $('#city_data').val();
    		var zip = $('#zip_data').val();
    		var phone = $('#phone_data').val();
    		var fax = $('#fax_data').val();
    		var email = $('#email_data').val();
    		var map = $('#map_data').val();
    		var div = $('#data-contact');

    		var type = 'POST';
        	var url = site_url+'/contacto/update_data';
    		var data = {'id':id,'name':name,'address':address,'city':city,'zip':zip,'phone':phone,'fax':fax,'email':email,'map':map};
    		var text = 'Contacto actualizado con éxito';
    		
    		var returndata = ActionAjax(type,url,data,null,text,true);
    		var html = "";
    		result = JSON.parse(returndata);
			$('#name_data').val('');
			$('#address_data').val('');
			$('#city_data').val('');
			$('#zip_data').val('');
			$('#phone_data').val('');
			$('#fax_data').val('');
			$('#email_data').val('');
			$('#map_data').val('');
			location.reload();
    		//div.html(result);
    		
    	});
     	
     },
     
     StateMessage : function() {

		$('body').on('click','.switch-small', function(event) {

			var id = $(this).attr('id');
			var rel = $(this).attr('rel');
			var input = $(this).children('input');
			var value = input.val();
			var text = "";

			if (value == 1) {
				
				$(this).attr('data-original-title', 'Marcar como leído');
				
				value = 0;
				input.val(value);
				input.prop("checked", false);
				text = 'Se ha marcado como no leido';
				
			}else{
				
				$(this).attr('data-original-title', 'Marcar como no leído');
				
				value = 1;
				input.val(value);
				input.prop("checked", true);
				text = 'Se ha marcado como leido';
			}

			var type = 'POST';
			var url = site_url + '/contacto/state_form';
			var data = {
				'value' : value,
				'id' : id,
				'rel' : rel
			};

			ActionAjax(type, url, data, null, text, false, false);
			
			return false;

		});

	},

}

$(window).load(ActionContact.HideShowField);
$(window).load(ActionContact.AddSocial);
$(window).load(ActionContact.DeleteSocial);
$(window).load(ActionContact.GetUrlSocial);
$(window).load(ActionContact.SetDataContact);
$(window).load(ActionContact.DeleteDataContact);
$(window).load(ActionContact.GetUpdateDataContact);
$(window).load(ActionContact.PrincipalDataContact);
$(window).load(ActionContact.UpdateServer);
$(window).load(ActionContact.UpdateServerEmails);
$(window).load(ActionContact.UpdateDataContact);
$(window).load(ActionContact.StateMessage);
