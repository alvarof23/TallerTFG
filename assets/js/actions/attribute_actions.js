var AttributeActions = {

	 SetCategory : function(){
		
		$('.set_category').on('click', function(event){
  			
  			var product = $(this).attr('id');
  			var id_category = $('#id_category').val();
  			var category = $('#id_category option:selected').text();
  			var item = 'id_category';
  			var content_category = $('#content_category');
  			var text = 'Categoría actualizada con éxito.';
   			
   			if(category == 0){
   				
   				alert('Por favor selecciona una categoría.');
   				
   			}else{
   				
   				var type = 'POST';
	        	var url = site_url+'/productos/update_ajax';
	    		var data = {'value':id_category,'id':product,'item':item};
	    		
	    		ActionAjax(type,url,data,null,text,false,false);
	    		
	    		var get_category = '';

    			get_category +='<div class="messages">';
    			get_category +='<div class="item item-visible">';
    			get_category +='<div class="text">';
    			get_category +='<div class="heading">';
    			get_category +='<a href="#">Categoría vinculada</a>';
    			get_category +='</div>';
    			get_category +='<span class="category">'+category+'</span>';
    			get_category +='</div></div></div>';
    			
    			content_category.html('');
    			content_category.html(get_category);
    		
   			}


		});

    },
    
    ActionAttributeProduct : function(){
    	
    	$("body").on("click", ".action_attribute_product", function(e){
    		
    		e.preventDefault();
    		
    		var a = $(this).attr('product');
    		var b = $(this).attr('attribute');
    		var c = '';
    		var action = $(this).attr('action');
    		var value = '';
    		var text = '';
    		var table = $('#table-attribute-'+b+' tbody');
    		var tr = '';
    		
    		if(action == 1){
    			
    			value = $('#id_attribute_value_'+b).val();
    			var text = 'Atributo añadido con éxito.';
    		}
    		
    		if(action == 0){
    			
    			c = $(this).attr('id');
    			var text = 'Atributo eliminado con éxito.';
    		}
    		
    		if(value == 0 && action == 1){
   				
   				alert('Por favor selecciona una opción.'+action);
   				
   			}else{
   				
   				var type = 'POST';
	        	var url = site_url+'/productos/action_attribute_product';
	    		var data = {'product':a,'attribute':b,'id_product_attribute':c,'value':value,'action':action};
	    		
	    		var returndata = ActionAjax(type,url,data,null,text,true,false);
	    		result = JSON.parse(returndata);
	    		
	    		$.each(result, function(i, val){
	 			
		 			tr +='<tr id="value-'+ val.id +'">';
		 			tr +='<td>'+ val.id +'</td>';
		 			tr +='<td>'+ val.value +'€</td>';
		 			tr +='<td><a id="'+ val.id +'" attribute="'+ b +'" product="'+ a +'" action="0" href="#" class="text-danger action_attribute_product" data-placement="top" data-toggle="tooltip" data-original-title="Borrar valor"><span class="fa fa-times"></span></a></td>';
					tr +='</tr>';
	 
				});
				
				table.html(tr);
				
				e.stopPropagation();
    		
   			}
    		
    	});
    },
    
    GetValue : function(){
    	
    	$("body").on("change", "#load_value_attribute", function(e){
    	
    		e.preventDefault();
    		
    		var attribute = $(this).val();
    		var value_attribute = $('#content_value_attribute');
    		var text = 'Valores cargados con éxito.';
    		var select = '';
    		
    		var type = 'POST';
	        var url = site_url+'/productos/get_attribute_value';
	    	var data = {'attribute':attribute};
	    		
	    	var returndata = ActionAjax(type,url,data,null,text,true,false);
	    	result = JSON.parse(returndata);
	    	
	    	select +='<select id="value_attribute" name="id_banner" class="form-control select" data-live-search="true">';
	    	select +='<option value="0">Selecciona un valor...</option>';
	    	
	    	$.each(result, function(i, val){
	 			
	 			select +='<option value="'+ val.id +'">'+ val.value +'</option>';
 
			});
			
			select +='</select>';
	    	
	    	value_attribute.html(select);
	    	
	    	LoadJS();
	    	
    		e.stopPropagation();
    		
    	});
    	
    },
    
    AddValue : function(){
    	
    	$("body").on("change", "#value_attribute", function(e){
    		
    		e.preventDefault();
    		
    		var id_value = $(this).val();
    		var name_value = $('#value_attribute option:selected').text();
    		var name_attribute = $('#load_value_attribute option:selected').text();
    		var box_value_selected = $('#box_value_selected');
    		var combination = $('#combination');
    		var combination_nomenclature = $('#combination_nomenclature');
    		var combination_value = 0;
    		var a = id_value;
    		
    		//combination_value = (parseInt(id_value)+parseInt(id_attribute))+parseInt(combination.val());
    		
    		box_value_selected.append('<option value="'+id_value+'">'+name_attribute+': '+name_value+'</option>');
    		combination.val(combination.val()+a);
    		combination_nomenclature.val(combination_nomenclature.val()+name_attribute+': '+name_value+',');
    		
    		e.stopPropagation();
    		
    	});
    	
    },
    
    EraserValue : function(){
    	
    	$("body").on("click", ".eraser-box-values", function(e){
    		
    		e.preventDefault();
    		
    		var box_value_selected = $('#box_value_selected');
    		var combination = $('#combination');
    		var combination_nomenclature = $('#combination_nomenclature');
    		box_value_selected.html('');
    		combination.val('');
    		combination_nomenclature.val('');
    		
    		e.stopPropagation();
    		
    	});
    	
    },
    
    SetCombination : function(){
    	
    	$("body").on("click", ".add-combination", function(e){
    		
    		e.preventDefault();
    		
    		var product = $(this).attr('id');
    		var combination = $('#combination').val();
    		var combination_nomenclature = $('#combination_nomenclature').val();
    		var box_value_selected = $('#box_value_selected');
    		var impact = $('#price_impact').val();
    		var text = 'Combinación guardada con éxito.';
    		var table = $('.combinations-table tbody');
    		var tr = '';
    		if(combination == ''){
    			
    			alert('No tienes ninguna combinación seleccionada.');
    			
    		}else{
    			
    			var type = 'POST';
	        	var url = site_url+'/productos/set_combination';
	    		var data = {'product':product,'combination':combination,'combination_nomenclature':combination_nomenclature,'impact':impact};
	    		
	    		var returndata = ActionAjax(type,url,data,null,text,true,false);
	    		result = JSON.parse(returndata);
	    		
	    		$.each(result, function(i, val){
	 			
		 			tr +='<tr">';
		 			tr +='<td>'+ val.id +'</td>';
		 			tr +='<td>'+ val.nomenclature +'</td>';
		 			tr +='<td>'+ val.impact +'€</td>';
		 			tr +='<td><a id="'+ val.id +'" product="'+ product +'" href="#" class="text-danger delete-combination" data-placement="top" data-toggle="tooltip" data-original-title="Borrar valor"><span class="fa fa-times"></span></a></td>';
					tr +='</tr>';
	 
				});
				
				table.html(tr);
				
				box_value_selected.html('');
    			$('#combination').val('');
    			$('#combination_nomenclature').val('');
    			
				e.stopPropagation();
    			
    		}
    		
    	});
    	
    },
    
    DeleteCombination : function(){
    	
    	$("body").on("click", ".delete-combination", function(e){
    		
    		e.preventDefault();
    		
    		var product = $(this).attr('product');
    		var combination = $(this).attr('id');
    		var text = 'Combinación eliminada con éxito.';
    		var table = $('.combinations-table tbody');
    		var tr = '';
    		
    		var type = 'POST';
        	var url = site_url+'/productos/delete_combination';
    		var data = {'product':product,'combination':combination};
    		
    		var returndata = ActionAjax(type,url,data,null,text,true,false);
    		result = JSON.parse(returndata);
    		
    		$.each(result, function(i, val){
 			
	 			tr +='<tr">';
	 			tr +='<td>'+ val.id +'</td>';
	 			tr +='<td>'+ val.nomenclature +'</td>';
	 			tr +='<td>'+ val.impact +'</td>';
	 			tr +='<td><a id="'+ val.id +'" product="'+ product +'" href="#" class="text-danger delete-combination" data-placement="top" data-toggle="tooltip" data-original-title="Borrar valor"><span class="fa fa-times"></span></a></td>';
				tr +='</tr>';
 
			});
			
			table.html(tr);
			
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
$(window).load(AttributeActions.SetCategory);
$(window).load(AttributeActions.ActionAttributeProduct);
$(window).load(AttributeActions.GetValue);
$(window).load(AttributeActions.AddValue);
$(window).load(AttributeActions.EraserValue);
$(window).load(AttributeActions.SetCombination);
$(window).load(AttributeActions.DeleteCombination);