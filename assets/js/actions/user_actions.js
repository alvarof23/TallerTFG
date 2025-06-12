var UsersActions = {

	 GetPass : function(){
		
		$('.get_pass').on('click', function(event){
  			
	        var type = 'POST';
        	var url = site_url+'/usuarios/generate_pass';
    		var data = {};
    		
    		var returndata = ActionAjax(type,url,data,null,null,true,false);
    		result = JSON.parse(returndata);
    		
    		$('#pass_user_front').val(result);

		});

    },
    
    GetCities : function(){
    	
    	$("body").on("change", "#id_province", function(e){
    	
    		e.preventDefault();
    		
    		var id_province = $(this).val();
    		var content = $('#content_cities');
    		var text = 'Valores cargados con éxito.';
    		var select = '';
    		
    		var type = 'POST';
	        var url = site_url+'/usuarios/get_cities';
	    	var data = {'id_province':id_province};
	    		
	    	var returndata = ActionAjax(type,url,data,null,text,true,false);
	    	result = JSON.parse(returndata);
	    	
	    	select +='<select id="id_city" name="id_city"  class="form-control select" data-live-search="true">';
	    	select +='<option value="0">Selecciona uns ciudad...</option>';
	    	
	    	$.each(result, function(i, val){
	 			
	 			select +='<option value="'+ val.id +'">'+ val.city +'</option>';
 
			});
			
			select +='</select>';
	    	
	    	content.html(select);
	    	
	    	LoadJS();
	    	
    		e.stopPropagation();
    		
    	});
    	
    },
    
}

function LoadJS(){

	$.getScript(base_url+"assets_back_office/js/plugins/bootstrap/bootstrap-select.js")
		
		.done(function() {
			
			if($(".select").length > 0){
                $(".select").selectpicker();
                
                $(".select").on("change", function(){
                    if($(this).val() == "" || null === $(this).val()){
                        if(!$(this).attr("multiple"))
                            $(this).val("").find("option").removeAttr("selected").prop("selected",false);
                    }else{
                        $(this).find("option[value="+$(this).val()+"]").attr("selected",true);
                    }
                });
            }
            
			console.log('Carga realizada con éxito.');
			
		})
		
		.fail(function() {
			
			console.log('Problemas al cargar el archivo.');
			
		});
	
	return false;
}

$(window).load(UsersActions.GetPass);
$(window).load(UsersActions.GetCities);