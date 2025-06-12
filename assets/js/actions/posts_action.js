var ActionNavBacks = {
	

    HideShowPost: function() {
    	
    	$( ".switch-small.post" ).on("click",function(){
    		
    		var input = $(this).children('input');
    		var id = $(this).attr('id');
    		var value = input.val();
    		var text = "";
    		
    		var type = 'POST';
        	var url = site_url+'/posts/state_post';

    		if(value == 1){
    			
    			input.val(0);
    			input.prop("checked", false);
    			$(this).attr('data-original-title','Mostrar post');
    			value = 0;
    			text = 'El post ha sido ocultado con éxito';
    			
    		}else{
    			
    			input.val(1);
    			input.prop("checked", true);
    			$(this).attr('data-original-title','Ocultar post');
    			value = 1;
    			text = 'El post ha sido cambiado con éxito';
    		}
    		
    		var data = {'value':value,'id':id};
    		
    		ActionAjax(type,url,data,null,text);
    		
    		return false;
    		
    	});
    	
    },
    
    HideShowComment: function() {
    	
    	$( ".switch.comment" ).on("click",function(){
    		
    		var input = $(this).children('input');
    		var id = $(this).attr('id');
    		var value = input.val();
    		var text = "";
    		
    		var type = 'POST';
        	var url = site_url+'/posts/state_comment';

    		if(value == 1){
    			
    			input.val(0);
    			input.prop("checked", false);
    			$(this).attr('data-original-title','Aprobar comentario');
    			value = 0;
    			text = 'El comentario ha sido ocultado con éxito';
    			
    		}else{
    			
    			input.val(1);
    			input.prop("checked", true);
    			$(this).attr('data-original-title','Ocultar comentario');
    			value = 1;
    			text = 'El comentario ha sido aprobado con éxito';
    			
    			$("#notifyModal").modal('show');
    			$('#id_comment').val(id);
    		}
    		
    		var data = {'value':value,'id':id};
    		
    		ActionAjax(type,url,data,null,text);
    		
    		return false;
    		
    	});
    	
    },
    
    ChangeNotify: function() {
    	
    	$( ".switch.notify" ).on("click",function(){
    		
    		var input = $(this).children('input');
    		var value = input.val();
    		var text ='Se ha cambiado la configuración con éxito';
    		
    		var type = 'POST';
        	var url = site_url+'/posts/state_notify';

    		if(value == 1){
    			
    			input.val(0);
    			input.prop("checked", false);
    			$(this).attr('data-original-title','Notificar nuevos comentarios');
    			value = 0;
    			
    		}else{
    			
    			input.val(1);
    			input.prop("checked", true);
    			$(this).attr('data-original-title','Cancelar notificación de nuevos comentarios');
    			value = 1;
    		}
    		
    		var data = {'value':value};
    		
    		ActionAjax(type,url,data,null,text);
    		
    		return false;
    		
    	});
    	
    },
    
    ChangeHead: function() {
    	
    	$("body").on("change", ".select-head-post", function(e){
			e.preventDefault();
			
			var type = $(this).find("option:selected").val();
			var forms = $('.head-post');
			var div;
			
			forms.addClass('hidden');
			
			switch (type) {
			    case '1':
			        div = $('#image_post_form');
			        $('#image_post_preview').removeClass('hidden');
			        break;
			    case '2':
			        div = $('#carrusel_post_form');
			        break;
			    case '3':
			        div = $('#video_type_form');
			        break;
			    case '4':
			        div = $('#video_post_form');
			        $('#video_type_form').removeClass('hidden');
			        break;
			    case '5':
			        div = $('#video_post_form');
			        $('#video_type_form').removeClass('hidden');
			        break;
			}
			
			
			div.removeClass('hidden');
			
		});
    	
    },
    
    DzmessageHide: function(){
		
		
		
    	if ( $('.dz-image-preview').length > 0 )
    		$('.dz-message').hide();
    },
    
    RemoveImageCarrusel: function(){
		
		$("body").on("click", ".dz-remove", function(e){
			e.preventDefault();
			
			var image = $(this).attr('image');

			var message = $('.dz-message');
			
			var type = 'POST';
        	var url = site_url+'/posts/delete_image_carrusel';
        	var data = {'image':image};
    		var text = 'Imagen borrada con éxito';
    		
    		var returndata = ActionAjax(type,url,data,null,text,true);
			
			if(returndata)
				$(this).parent().remove();
			
			if ( $('.dz-image-preview').length == 0 )
				message.show();
			
		});

    },

}

function ActionAjax(type,url,data,content, title, ajax){
	
	content = content || null;
	title = title || null;
	ajax = ajax || false;
	
	var returnfunction = true;
	var async = true;
	var cache = true;
	if(ajax){async = false; async = false}
	$.ajax({
	 	
		type: type,
		url: url,
		data: data,
		async: async,
	    cache: cache,
     	
		success: function(returndata){
			
			if(content != null){
				
				$( content ).html(returndata);
			}
			
			if(ajax){
				
				returnfunction = returndata;
			}
			
			if(title != null){
				
				noty({text: title, layout: 'topCenter', type: 'success'});
				setTimeout(function() {$("#noty_topCenter_layout_container").fadeOut(1500);},3000);
				setTimeout(function() {$("ul").remove("#noty_topCenter_layout_container");},4000);
			}

		},
		  
		error: function(XMLHttpRequest, textStatus, errorThrown) {
		  	
		  	noty({text: 'Error del servidor, imposible realizar la acción.', layout: 'topRight', type: 'error'});
		  	setTimeout(function() {$("#noty_topCenter_layout_container").fadeOut(1500);},3000);
		  	setTimeout(function() {$("ul").remove("#noty_topCenter_layout_container");},4000);
			returnfunction = false;
		}
		   
	});
	
	return returnfunction;
}

$(window).load(ActionNavBacks.HideShowPost);
$(window).load(ActionNavBacks.HideShowComment);
$(window).load(ActionNavBacks.ChangeNotify);
$(window).load(ActionNavBacks.ChangeHead);
$(window).load(ActionNavBacks.DzmessageHide);
$(window).load(ActionNavBacks.RemoveImageCarrusel);