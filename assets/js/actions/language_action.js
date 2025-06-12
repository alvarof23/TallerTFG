var ActionLanguage = {

    HideShowLanguage: function() {
    	
    	//$("body").on("click",".estado-idioma" , function(){
    		$( ".switch-small" ).on("click",function(){
    		
    		var input = $(this).children('input');
    		var id = $(this).attr('id');
    		var value = input.val();
    		var text = "";
    		
    		var type = 'POST';
        	var url = site_url+'/languages/state_language';

    		if(value == 1){
    			
    			input.val(0);
    			input.prop("checked", false);
    			$(this).attr('data-original-title','Activar idioma');
    			value = 0;
    			text = 'El idioma ha sido desactivado con éxito';
    			
    		}else{
    			
    			input.val(1);
    			input.prop("checked", true);
    			$(this).attr('data-original-title','Desactivar idioma');
    			value = 1;
    			text = 'El idioma ha sido activado con éxito';
    		}
    		
    		var data = {'value':value,'id':id};
    		
    		ActionAjax(type,url,data,null,text);
    		
    		return false;
    		
    	});
    	
    },

}

function ActionAjax(type,url,data,content, title){
	
	content = content || null;
	title = title || null;
	
	$.ajax({
        	 	
		  type: type,
		  url: url,
		  data: data,
		  success: function(returndata){
			
			if(content != null){
				
				$( content ).html(returndata);
			}
			
			noty({text: title, layout: 'topCenter', type: 'success'});
			setTimeout(function() {$("#noty_topCenter_layout_container").fadeOut(1500);},3000);
			setTimeout(function() {$("ul").remove("#noty_topCenter_layout_container");},4000);
			
		  },
		  
		  error: function(XMLHttpRequest, textStatus, errorThrown) {
		  	
		  	noty({text: 'Error del servidor, imposible realizar la acción.', layout: 'topRight', type: 'error'});
		  	setTimeout(function() {$("#noty_topCenter_layout_container").fadeOut(1500);},3000);
		  	setTimeout(function() {$("ul").remove("#noty_topCenter_layout_container");},4000);
		  	
		  }
		   
	});
	
}

$(window).load(ActionLanguage.HideShowLanguage);