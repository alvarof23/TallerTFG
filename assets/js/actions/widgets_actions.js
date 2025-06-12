var SalesActions = {

	SalesRefresh : function(){
	
		$('#refresh-ventas').on('click', function() {
			
			var desde = $('#desde-ventas').val();
			var hasta = $('#hasta-ventas').val();
			
			if(desde != '' && hasta != ''){
			
				var type = 'POST';
				var url = site_url + '/home/refresh_sales';
				var data = {
					'desde' : desde,
					'hasta' : hasta
				};
	
				var returndata = ActionAjax(type,url,data,null,'',true);
	    		
	    		var result = JSON.parse(returndata);
								
				$('#cuerpo-ventas').html(result[1]+result[0]);
				$('#titulo-ventas').html('<i class="fa fa-area-chart m-right-5"></i> Ventas del ' + desde + ' al ' + hasta);
								
				myLine = window.saleCanvas();
				
			}
		});
	},
	
	ActivityRefresh : function(){
	
		$('#refresh-actividad').on('click', function() {
			
			var desde = $('#desde-actividad').val();
			var hasta = $('#hasta-actividad').val();
			
			if(desde != '' && hasta != ''){
			
				var type = 'POST';
				var url = site_url + '/home/refresh_activity';
				var data = {
					'desde' : desde,
					'hasta' : hasta
				};
	
				var returndata = ActionAjax(type,url,data,null,'',true);
	    		
	    		var result = JSON.parse(returndata);
								
				$('#cuerpo-actividad').html(result[0]);
				$('#titulo-actividad').html('<i class="fa fa-bar-chart m-right-5"></i> Actividad del ' + desde + ' al ' + hasta);
								
				myLine = window.saleCanvas();
				
			}
		});
	}
}

$(window).load(SalesActions.SalesRefresh);
$(window).load(SalesActions.ActivityRefresh);