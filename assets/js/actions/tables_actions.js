var tablesActions = {
	
	CheckAll : function(){
		
		$("body").on("click", ".check-all", function(){
			
			if (!$(this).is(':checked')){
       			
       			($)("input[type=checkbox].check-single").prop('checked', false);
		        
		    }else{

		        $("input[type=checkbox].check-single").prop('checked', true);
		    }

		});

    },
        
}

$(window).load(tablesActions.CheckAll);