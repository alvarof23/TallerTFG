var ActionOrder = {
	
	
	ChangeStateOrder: function() {
		
		$( "#select-state" ).on("change",function(){
			
			var value = $(this).val();
			var id_order = $(this).attr('order');
			
			var type = 'POST';
        	var url = site_url+'/pedidos/state_order';
        	var data = {'value':value,'id':id_order};
        	var text = 'El estado del pedido ha sido cambiado con éxito';
			
			var returndata = ActionAjax(type,url,data,null,text,true);
			
			result = JSON.parse(returndata);
			
			$('#state_order').attr('class',result[1]);
			$('#state_order').html(result[0]);
		});
	},
    
    // ChangeStateOrder: function() {
//     	
    	// $( ".switch" ).on("click",function(){
//     		
    		// var input = $(this).children('input');
    		// var id = $(this).attr('id');
    		// var value = input.val();
    		// var text = "";
//     		
    		// var type = 'POST';
        	// var url = site_url+'/pedidos/state_order';
// 
    		// if(value == 1){
//     			
    			// input.val(0);
    			// input.prop("checked", false);
    			// value = 0;
    			// text = 'El estado del pedido ha sido cambiado con éxito';
//     			
    			// $( "#wait" ).removeClass('disabled');
    			// $( "#send" ).addClass('disabled');
//     			
    		// }else{
//     			
    			// input.val(1);
    			// input.prop("checked", true);
    			// value = 1;
    			// text = 'El pedido se ha marcado como enviado con éxito';
//     			
    			// $( "#wait" ).addClass('disabled');
    			// $( "#send" ).removeClass('disabled');
    		// }
//     		
    		// var data = {'value':value,'id':id};
//     		
    		// ActionAjax(type,url,data,null,text);
//     		
    		// return false;
//     		
    	// });
//     	
    	// $( ".cancel-order" ).on("click",function(){
//     		
    		// var id = $(this).attr('id');
    		// var input = $('.switch').children('input');
    		// var value = $(this).val();
    		// var text = "";
//     		
    		// var type = 'POST';
        	// var url = site_url+'/pedidos/state_order';
// 
    		// if(value == 2){
//     			
    			// $(this).val(input.val());
    			// input.prop("checked", false);
    			// input.prop("disabled", false);
    			// value = 0;
    			// $(this).html('<span class="fa fa-times"></span>');
    			// $(this).attr("data-original-title", "Cancelar pedido");
    			// text = 'El estado del pedido ha sido cambiado con éxito';
//     			
    			// $( "#cancel" ).addClass('disabled');
    			// $( "#wait" ).removeClass('disabled');
    			// $( "#send" ).addClass('disabled');
//     			
    		// }else{
//     			
    			// $(this).val(2);
    			// input.prop("disabled", true);
    			// input.prop("checked", false);
    			// value = 2;
    			// $(this).html('<span class="fa fa-times"></span> Pedido cancelado');
    			// $(this).attr("data-original-title", "Volver a aceptar pedido");
    			// text = 'El pedido se ha marcado como cancelado';
//     			
    			// $( "#cancel" ).removeClass('disabled');
    			// $( "#wait" ).addClass('disabled');
    			// $( "#send" ).addClass('disabled');
    		// }
//     		
    		// var data = {'value':value,'id':id};
//     		
    		// ActionAjax(type,url,data,null,text);
//     		
    		// return false;
//     		
    	// });
//     	
    // },
//     
    
    PrintPDF : function(){
		
		$(".print-order").click(function(){
			
			var id = $(this).attr('id');

			window.location = site_url+'/pedidos/print_order/'+id;

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

$(window).load(ActionOrder.ChangeStateOrder);
$(window).load(ActionOrder.PrintPDF);