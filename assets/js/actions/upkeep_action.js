var ActionContact = {

    HideShowUpkeep: function() {
    	
    	$( ".switch-small" ).on("click",function(){
    		
    		var input = $(this).children('input');
    		var value = input.val();
    		var text = "";
    		
    		var type = 'POST';
        	var url = site_url+'/upkeep/state_upkeep';

    		if(value == 1){
    			
    			input.val(0);
    			input.prop("checked", false);
    			$(this).attr('data-original-title','Activar modo mantenimiento');
    			value = 0;
    			text = 'El modo mantenimiento ha sido desactivado con éxito';
    			
    		}else{
    			
    			input.val(1);
    			input.prop("checked", true);
    			$(this).attr('data-original-title','Desactivar modo mantenimiento');
    			value = 1;
    			text = 'El modo mantenimiento ha sido activado con éxito';
    		}
    		
    		var data = {'value':value};
    		
    		ActionAjax(type,url,data,null,text);
    		
    		return false;
    		
    	});
    	
    },

     
     GetIP: function() {
     	
     	$("body").on("click", ".add-ip", function(e){
    		e.preventDefault();
    		
    		var ip = $('#ip_upkeep').val();
			var div = $('#data-ip');
			
    		var type = 'POST';
        	var url = site_url+'/upkeep/set_ip';
    		var data = {'ip_upkeep':ip};
    		var text = 'IP añadida con éxito';
    		
    		var returndata = ActionAjax(type,url,data,null,text,true);
    		var html = "";
    		result = JSON.parse(returndata);
    		
    		$.each(result, function(i, val){
    			
	 			html +='<div class="alert">';
	 			html +='<button id="'+ val.id +'" class="close delete-ip" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
				html +='<strong>'+ val.ip_upkeep +'</strong>';
				html +='</div>';
 
			});
    		
    		div.html(html);
    		$('#ip_upkeep').val(" ");
    		
    	});	
    		
     },
     
     DeleteIP: function() {
     	
     	$("body").on("click", ".delete-ip", function(e){
    		e.preventDefault();
    		
    		var id = $(this).attr("id");
    		var div = $('#data-ip');

    		var type = 'POST';
        	var url = site_url+'/upkeep/delete_ip';
    		var data = {'id':id};
    		var text = 'IP eliminada con éxito';
    		
    		var returndata = ActionAjax(type,url,data,null,text,true);
    		var html = "";
    		result = JSON.parse(returndata);
    		
    		$.each(result, function(i, val){
    			
	 			html +='<div class="alert">';
	 			html +='<button id="'+ val.id +'" class="close delete-ip" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
				html +='<strong>'+ val.ip_upkeep +'</strong>';
				html +='</div>';
 
			});
    		
    		div.html(html);
    		
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

$(window).load(ActionContact.HideShowUpkeep);
$(window).load(ActionContact.GetIP);
$(window).load(ActionContact.DeleteIP);
