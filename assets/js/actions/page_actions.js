var ActionPages = {
	

    ShowFileInput: function() {
    	
    	$( "#attached_type" ).on("change",function(){
    		
    		if($(this).val() > 0){
    			
    			$('.filebutton').attr('disabled',false);
    		}else{
    			$('.filebutton').attr('disabled',true);
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
        	
        	var title = "Se ha copiado al portapapeles el enlace de la página";
        	
        	noty({text: title, layout: 'topCenter', type: 'success'});
			setTimeout(function() {$("#noty_topCenter_layout_container").fadeOut(1500);},3000);
			setTimeout(function() {$("ul").remove("#noty_topCenter_layout_container");},4000);

		});

    }

}

// function ActionAjax(type,url,data,content, title, ajax){
// 	
	// content = content || null;
	// title = title || null;
	// ajax = ajax || false;
// 	
	// var returnfunction = true;
	// var async = true;
	// var cache = true;
	// if(ajax){async = false; async = false}
	// $.ajax({
// 	 	
		// type: type,
		// url: url,
		// data: data,
		// async: async,
	    // cache: cache,
//      	
		// success: function(returndata){
// 			
			// if(content != null){
// 				
				// $( content ).html(returndata);
			// }
// 			
			// if(ajax){
// 				
				// returnfunction = returndata;
			// }
// 			
			// if(title != null){
// 				
				// noty({text: title, layout: 'topCenter', type: 'success'});
				// setTimeout(function() {$("#noty_topCenter_layout_container").fadeOut(1500);},3000);
				// setTimeout(function() {$("ul").remove("#noty_topCenter_layout_container");},4000);
			// }
// 
		// },
// 		  
		// error: function(XMLHttpRequest, textStatus, errorThrown) {
// 		  	
		  	// noty({text: 'Error del servidor, imposible realizar la acción.', layout: 'topRight', type: 'error'});
		  	// setTimeout(function() {$("#noty_topCenter_layout_container").fadeOut(1500);},3000);
		  	// setTimeout(function() {$("ul").remove("#noty_topCenter_layout_container");},4000);
			// returnfunction = false;
		// }
// 		   
	// });
// 	
	// return returnfunction;
// }

$(window).load(ActionPages.ShowFileInput);
$(window).load(ActionPages.CopyURL);