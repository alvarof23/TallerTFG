var ActionMenu = {
	
	DropItem : function() {
		
		$( ".dd-p" ).draggable();
        $(".dd-placeholder").droppable({
        	
		   drop: function( event, ui ) {
		    
		    	alert("main drop function");
		    
		   }
		   
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

$(window).load(ActionMenu.DropItem);