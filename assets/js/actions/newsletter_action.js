var ActionNewsletter = {

    Export : function(){
		
		$(".export-news").click(function(){
			
			window.location = site_url+'/newsletter/export_excel/';

		});
		
		
		$(".export-concurso").click(function(){
			
			var code = $("#concursos").val()
			
			window.location = site_url+'/newsletter/export_excel/'+code;

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

$(window).load(ActionNewsletter.Export);
