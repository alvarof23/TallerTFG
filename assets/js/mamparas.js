$('.carousel').owlCarousel({
	loop:true,
	margin:10,
	nav:true,
	responsive:{
		0:{
			items:4
		},
		600:{
			items:4
		},
		1000:{
			items:6
		}
	}
})
var wysiwyg_owloptions = {
    items:3,
	loop: false,
	nav:true,
	navText: ["<span class='fa fa-angle-left fa-2x'></span>","<span class='fa fa-angle-right fa-2x'></span>"],
	onInitialize: function (event) {
                    $(this).addClass("carousel-loaded owl-carousel");
                },
  } 
function owlResize($owl) {
    $owl.trigger('destroy.owl.carousel');
    $owl.html($owl.find('.owl-stage-outer').html()).removeClass('owl-loaded');
    $owl.owlCarousel(wysiwyg_owloptions);
}

//FORMATEA CAMPOS NUMERICOS
$(document).delegate('.numerico','blur',function(){
	var num=$(this).val(); 
	num=num.replace(',','.')
	$(this).val(num);
})
//ALTURA ESPECIAL
var contenedor='.contenedor_configurador_modelo ';

$(document).delegate(contenedor+'.altura_especial','click',function(){
	if($(contenedor+'.altura_especial').prop('checked')){ 
		$(contenedor+'.alto_total').prop('disabled',false)
	}else{
		$(contenedor+'.alto_total').prop('disabled',true);
		if($(contenedor+'.ducha_banera').length>0){
			var tipo=$(contenedor+'.ducha_banera.activo').attr('data-tipo');  
			if(tipo && tipo==0){ //DUCHA
				$(contenedor+'.alto_total').val($(contenedor+'.alto_total').attr('data-estandar-ducha'));
				$(contenedor+'.resumen_alto').html($(contenedor+'.alto_total').attr('data-estandar-ducha'));
			}
			if(tipo && tipo==1){ //BAÑERA
				$(contenedor+'.alto_total').val($(contenedor+'.alto_total').attr('data-estandar-banera'));
				$(contenedor+'.resumen_alto').html($(contenedor+'.alto_total').attr('data-estandar-banera'));
			}
		}
	}
})

//CROQUIS

$(document).delegate(contenedor+'.subir_croquis','click',function(evt){
	$(contenedor+'.imagen_croquis').html('');
	var file_data = $(contenedor+'#croquis').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);

	$.ajax({
       url: site_url + '/home/sube_imagenes_ajax',
       type: 'POST',
       data: form_data,
       async: false,
       cache: false,
       contentType: false,
       enctype: 'multipart/form-data',
       processData: false,
       success: function (response) {
         //alert(response);
		 json=JSON.parse(response);

		if(json['upload']){
			$(contenedor+'.imagen_croquis').html('<img src="'+base_url +json['res']+'" style="width:250px">');
			$(contenedor+'#url_croquis').val(json['res']);
		
		}else{
			$(contenedor+'.imagen_croquis').html(json['res']);
		}
       }
   });
   return false;
})

//PASO A PASO
function valida_paso1(){
	$(contenedor+'.mensaje_error_primer_paso').addClass('hidden');
	//INICIALIZACION DE DATOS
	//$('.segundo-paso').addClass('hidden');
	/*if($('.tercer-paso').length>0){

		$('.tercer-paso').addClass('hidden');
	}*/
	//$('.atributo_vertical').val('');
	var validado=false;

	var validado_horizontal=true;
	if($(contenedor+'.atributo_horizontal').val()==""){
		validado_horizontal=false;
		$(contenedor+'.atributo_horizontal').addClass('border-red');
	}else{
		$(contenedor+'.atributo_horizontal').removeClass('border-red');
	}

	if($(contenedor+'.ancho_izquierdo').length>0 && $(contenedor+'.ancho_derecho').length>0){ 
		if($(contenedor+'.ancho_izquierdo').val()==""){
			validado_horizontal=false;
			$(contenedor+'.ancho_izquierdo').addClass('border-red');
		}else{
			$(contenedor+'.ancho_izquierdo').removeClass('border-red');
		}
		if($(contenedor+'.ancho_derecho').val()==""){
			validado_horizontal=false;
			$(contenedor+'.ancho_derecho').addClass('border-red');
		}else{
			$(contenedor+'.ancho_derecho').removeClass('border-red');
		}
	}

	if($(contenedor+'.altura_murete').length>0 ){ 
		if($(contenedor+'.altura_murete').val()==""){
			validado_horizontal=false;
			$(contenedor+'.altura_murete').addClass('border-red');
		}else{
			$(contenedor+'.altura_murete').removeClass('border-red');
		}
	}
	
	if($(contenedor+'.ancho_parte_plegable').length>0 ){ 
		if($(contenedor+'.ancho_parte_plegable').val()==""){
			validado_horizontal=false;
			$(contenedor+'.ancho_parte_plegable').addClass('border-red');
		}else{
			$(contenedor+'.ancho_parte_plegable').removeClass('border-red');
		}
	}
	if($(contenedor+'.alto_total').val()!="" && validado_horizontal){
		if($(contenedor+'.ducha_banera').length>0){
			$(contenedor+'.ducha_banera').each(function(){
				if($(this).hasClass('activo')){
					validado=true;
				}
			});
		}else{
			validado=true;
		}
	}
	
	if(validado && validado_horizontal){
		$(contenedor+'.segundo-paso').removeClass('hidden');
	}else{
		$(contenedor+'.mensaje_error_primer_paso').removeClass('hidden');
	}
}

$(document).delegate(contenedor+'.alto_total','blur',function(){
	valida_paso1();
});
$(document).delegate(contenedor+'.atributo_horizontal','blur',function(){
	valida_paso1();
});
$(document).delegate(contenedor+'.ancho_izquierdo','blur',function(){ 
	valida_paso1();
});
$(document).delegate(contenedor+'.ancho_derecho','blur',function(){
	valida_paso1();
});
$(document).delegate(contenedor+'.ducha_banera','click',function(){
	valida_paso1();
});
$(document).delegate(contenedor+'.altura_murete','blur',function(){
	valida_paso1();
});
$(document).delegate(contenedor+'.ancho_parte_plegable','blur',function(){
	valida_paso1();
});
function valida_paso2(){
	$(contenedor+'.add-modelo').addClass('hidden');
	$(contenedor+'.mensaje_error_segundo_paso').addClass('hidden');
	if($(contenedor+'.tercer-paso').length>0){
		$(contenedor+'.tercer-paso').addClass('hidden');
	}
	var validado=false;
	if($(contenedor+'.atributo_vertical').val()!=""){
		var id_atributo_vertical_valor=$(contenedor+'.atributo_vertical').val();
		if($(contenedor+'.decorado_v_valor_'+id_atributo_vertical_valor).length>0){
			if($(contenedor+'.decorado_v_valor_'+id_atributo_vertical_valor+' input[name=decorado_v]:checked').val()){
				validado=true;
			}
		}else{
			validado=true;
		}
		
	}
	if(validado){
		if($(contenedor+'.tercer-paso').length>0 && $(contenedor+'#personalizacion').length>0){ //El producto tiene que tener componentes para poder realizar pedido
			$(contenedor+'.tercer-paso').removeClass('hidden');

			$(contenedor+'.add-modelo').removeClass('hidden');
		}
	}else{
		$(contenedor+'.mensaje_error_segundo_paso').removeClass('hidden');
	}
}

$(document).delegate(contenedor+'.atributo_vertical','change',function(){
	valida_paso2();
});
$(document).delegate(contenedor+'.valor_decorados input[type=radio]','change',function(){
	valida_paso2();
})

$(document).delegate(contenedor+'ul.details-image li img','click', function(){
	var img=$(this).attr('src');
	$(contenedor+'.imagen_producto_principal').css('background-image','url('+img+')');
})

//ATRIBUTOS
	function get_incrementos_alto(id_product,total){
		var type = 'POST';
			var url = site_url + '/home/get_incrementos_alto_ajax';
			
			var total=total;
			var alto=$(contenedor+'.alto_total').val();
			var id_product=id_product;
			var tipo=0;
			if($(contenedor+'.ducha_banera').length>0){
				if($(contenedor+'#ducha').hasClass('activo')){
					tipo=1;
				}else{
					tipo=2;
				}
			}
	
			var data = {
				'total': total,
				'id_product' : id_product,
				'alto' : alto,
				'tipo': tipo
			};
			
			var result = ActionAjax(type, url, data, null, null, true);

    		json=JSON.parse(result);
    		
    		if(json){
    			return json[0];
    		}else{
    			return 0;
    		}
	}
	
	function get_incrementos_ancho(id_product,total){
		var type = 'POST';
			var url = site_url + '/home/get_incrementos_ancho_ajax';
			
			var total=total;
			var ancho=0;
			if($(contenedor+'.ancho_total').length>0){
				ancho=$(contenedor+'.ancho_total').val();
			}else{
				ancho=parseFloat($(contenedor+'.ancho_izquierdo').val())+parseFloat($(contenedor+'.ancho_derecho').val());
			}
			var id_product=id_product;
			
	
			var data = {
				'total': total,
				'id_product' : id_product,
				'ancho' : ancho,
			};
			
			var result = ActionAjax(type, url, data, null, null, true);

    		json=JSON.parse(result);
    		
    		if(json){
    			return json[0];
    		}else{
    			return 0;
    		}
	}

	function calcula_incremento_vidrio_espejo(total_sin_iva,base){
		var incremento=0;
		var version=$(contenedor+'input[name=version_sel]:checked').val();
		var espesor=0;
		//var id_product=$('.atributo_horizontal').attr('data-id');
		var id_product=$(contenedor+'#id_product_modelo').val();
		$(contenedor+'.valor_componente').each(function(){
			var input=$(this).find('input');
			if(input.attr('data-tipo-espesor')==1 && input.is(':checked') ){
				espesor=input.val();
			}
		})

		if($(contenedor+'.vidrio_espejo_input').length>0){
			$(contenedor+'.vidrio_espejo_input').each(function(){
				if($(this).prop('checked')){

					var type = 'POST';
					var url = site_url + '/home/get_incrementos_espejo_ajax';

					var data = {
						'id_product':id_product,
						'id_panel': $(this).attr('data-id-panel'),
						'espesor':espesor,
						'version':version,
						'total_sin_iva': total_sin_iva,
						'base':base
					}; 
					var result = ActionAjax(type, url, data, null, null, true);

					json=JSON.parse(result);
					
					if(json && !isNaN(parseFloat(json[0]))){
						incremento =parseFloat(incremento)+ parseFloat(json[0]);
					}
				}
			});
		}
		return incremento;
	}
	function calcula_incremento_version(total_sin_iva,base){
				// INCREMENTO VERSIONES
		
		var incremento_version=0;
		var type = 'POST';
		var url = site_url + '/home/get_incrementos_versiones_ajax';
	
		var version=$(contenedor+'input[name=version_sel]:checked').val(); 
		var atributo_horizontal=$(contenedor+'.atributo_horizontal').val();
		var atributo_vertical =$(contenedor+'.atributo_vertical').val();
		//var id_product=$('.atributo_horizontal').attr('data-id');
		var id_product=$(contenedor+'#id_product_modelo').val();
		var vidrio_espejo=0;
		if($(contenedor+'.vidrio_espejo_input').length>0){
			$(contenedor+'.vidrio_espejo_input').each(function(){
				if($(this).prop('checked')){
					vidrio_espejo = parseInt(vidrio_espejo) +1;
				}
			})
		}

		var tercera_bisagra=0;
		if($(contenedor+'.tercera_bisagra_input').length>0){
			$(contenedor+'.tercera_bisagra_input').each(function(){
				if($(this).prop('checked')){
					tercera_bisagra = parseInt(tercera_bisagra) +1;
				}
			})
		}
		
		
		var data = {
			'atributo_horizontal': atributo_horizontal,
			'atributo_vertical' : atributo_vertical,
	
			'id_product':id_product,
			'total_sin_iva': total_sin_iva,
			'vidrio_espejo':0, //EL INCREMENTO POR VIDRIO ESPEJO SE CALCULA APARTE POR ESPESOR
			'tercera_bisagra':tercera_bisagra,
			'version':version,

			'base':base
		};
		
		var result = ActionAjax(type, url, data, null, null, true);

		json=JSON.parse(result);
		
		if(json && !isNaN(parseFloat(json[0]))){
			incremento_version = parseFloat(json[0]);
		}

		//MODIFICA MEDIDA DEL PANEL MARCADO
		if($(contenedor+'.tercera_bisagra_input').length>0 ){
			var incremento_maximo_ancho_total=0;
			var maximo_total=$(contenedor+'.ancho_total').attr('data-max');
			$(contenedor+'.tercera_bisagra_input').each(function(){
				var n_panel=$(this).attr('data-panel');
				$(contenedor+'.mensaje_tercera_bisagra_'+n_panel).addClass('hidden');
				$(contenedor+'.mensaje_tercera_bisagra_'+n_panel).html('');
				if($(this).is(':checked')){
					if(json[1]>0){
						$(contenedor+'.mensaje_tercera_bisagra_'+n_panel).removeClass('hidden');
						$(contenedor+'.mensaje_tercera_bisagra_'+n_panel).html('El ancho máximo del panel es '+json[1]);
						$(contenedor+'.m_panel_'+n_panel).attr('data-max',json[1]);

						//CAMBIO EL ANCHO MAXIMO
						incremento_maximo_ancho_total+=parseFloat($(contenedor+'.m_panel_'+n_panel).attr('data-max'))-$(contenedor+'.m_panel_'+n_panel).attr('data-max-old');
					}
				}else{ 
					$(contenedor+'.m_panel_'+n_panel).attr('data-max',$(contenedor+'.m_panel_'+n_panel).attr('data-max-old'));
					if(parseFloat($(contenedor+'.m_panel_'+n_panel).val())> parseFloat($(contenedor+'.m_panel_'+n_panel).attr('data-max')) && $(contenedor+'.m_panel_'+n_panel).attr('data-max')!=0){
						$(contenedor+'.m_panel_'+n_panel).val('');
					}
				}
			})
			if(maximo_total!=0){
				if(incremento_maximo_ancho_total!=0){
					$(contenedor+'.ancho_total').attr('data-max',parseFloat($(contenedor+'.ancho_total').attr('data-max-old'))+incremento_maximo_ancho_total);
					$(contenedor+'.ancho_total').next('.mensaje_error_medida').html('Ancho máximo actual es de '+$(contenedor+'.ancho_total').attr('data-max'));	
					$(contenedor+'.ancho_total').next('.mensaje_error_medida').removeClass('hidden');
				}else{
					$(contenedor+'.ancho_total').attr('data-max',parseFloat($(contenedor+'.ancho_total').attr('data-max-old')));
					$(contenedor+'.ancho_total').next('.mensaje_error_medida').html('');	
					$(contenedor+'.ancho_total').next('.mensaje_error_medida').addClass('hidden');
				}
			}
		}
		return incremento_version;
	}

	function calcula_incremento_componentes(total_sin_iva,base){
		var incremento_componentes=0;
		var componentes_sel="";
		//var id_product=$('.atributo_horizontal').attr('data-id');
		var id_product=$(contenedor+'#id_product_modelo').val();

		var version=$(contenedor+'input[name=version_sel]:checked').val(); 

		$(contenedor+'.componentes_version_'+version+' .valor_componente').each(function(){
			var input=$(this).find('input[type=radio],input[type=checkbox]');
			if(input.prop('checked')){
				componentes_sel +=input.val()+',';
			}
		});
		
		var vidrio_espejo=0;
		if($(contenedor+'.vidrio_espejo_input').length>0){
			$(contenedor+'.vidrio_espejo_input').each(function(){
				if($(this).prop('checked')){
					vidrio_espejo = parseInt(vidrio_espejo) +1;
				}
			})
		}
		
		$(contenedor+'.componentes_version_'+version+' .valor_componente').each(function(){
			var estandar=$(this).attr('data-estandar');
			//var incremento_comp=$(this).attr('data-incremento');
			//var tipo_incremento_comp=$(this).attr('data-tipo');
			var input=$(this).find('input[type=radio],input[type=checkbox]'); 
			//if(input.prop('checked') && estandar==0){
			if(input.prop('checked')){		
				var type = 'POST';
				var url = site_url + '/home/get_incrementos_componentes_ajax';
				
				var atributo_horizontal=$(contenedor+'.atributo_horizontal').val();
				var atributo_vertical =$(contenedor+'.atributo_vertical').val();
				 
				var data = {
					'atributo_horizontal': atributo_horizontal,
					'atributo_vertical' : atributo_vertical,
					'componentes_sel' : componentes_sel,
					'id_relacion': input.val(),
					'id_product':id_product,
					'total_sin_iva': total_sin_iva,
					'vidrio_espejo':0,
					'version':version,
					'base':base
				};
				
				var result = ActionAjax(type, url, data, null, null, true);

	    		json=JSON.parse(result);
				
				if(json && !isNaN(parseFloat(json[0]))){
	    			incremento_componentes += parseFloat(json[0]);
	    		}
				/*
				if( tipo_incremento_comp == 1){
					incremento_componentes += parseFloat(incremento_comp);
					
				}else if(tipo_incremento_comp == 0){
					incremento_componentes += total_sin_iva*parseFloat(incremento_comp)/100;
				}*/
			}
		});
		return parseFloat(incremento_componentes);
	}
	function combinacion_actualiza(devuelve=false){
			$(contenedor+'.product-price').html('<span class="fa fa-spinner fa-pulse"></span>');
			//$('.product-price').html('');
			$(contenedor+'#tab_resumen').addClass('hidden');
    		var type = 'POST';
			var url = site_url + '/home/get_comb_stock_precio_mampara_ajax';
			var combinaciones_attr="";
			
			//var id_product=$('.atributo_horizontal').attr('data-id');
			var id_product=$(contenedor+'#id_product_modelo').val();
			var id_atributo_vertical=$(contenedor+'.atributo_vertical').attr('data-id');
			var id_atributo_vertical_valor=$(contenedor+'.atributo_vertical').val();
			var atributo_horizontal_valor=$(contenedor+'.atributo_horizontal').val();

			var alto=$(contenedor+'.alto_total').val();
			var tipo=alto_banera=0;
			if($(contenedor+'.ducha_banera').length>0){
				if($(contenedor+'.ducha_banera.activo').attr('data-tipo')==1){ //BAÑERA
					tipo=1;
					alto_banera=$(contenedor+'.alto_total').attr('data-estandar-banera');
				}
			}
			var ancho_derecho=0;
			if($(contenedor+'.ancho_derecho').length>0){
				ancho_derecho=$(contenedor+'.ancho_derecho').val();
			}
			
			var ancho_izquierdo=0;
			if($(contenedor+'.ancho_izquierdo').length>0){
				ancho_derecho=$(contenedor+'.ancho_izquierdo').val();
			}
			//TARIFA SEGUN ESPESOR
			var tarifa="";
			$(contenedor+'.valor_componente').each(function(){
				var compo=$(contenedor+'.valor_componente').find('input');
				if(compo.attr(contenedor+'data-tipo-espesor')==1 && compo.is(':checked')){
					tarifa=$(contenedor+'.valor_componente').attr('data-tarifa');
				}
			}); 
			if(atributo_horizontal_valor!="" && id_atributo_vertical_valor!=""){ //SE HAN SELECCIONADO VALORES Y SE PUEDE CALCULAR EL PRECIO
					var data = {
						'id_atributo_vertical': id_atributo_vertical,
						'id_product' : id_product,
						'id_atributo_vertical_valor' : id_atributo_vertical_valor,
						'atributo_horizontal_valor' : atributo_horizontal_valor,
						'qty':1,
						'ancho_derecho':ancho_derecho,
						'ancho_izquierdo':ancho_izquierdo,
						'tarifa':tarifa,
						'alto':alto,
						'tipo':tipo,
						'alto_banera':alto_banera
						//'aplica_promocion':aplica_promocion
					};
				
					var result = ActionAjax(type, url, data, null, null, true);
				//	console.log(result);
					//array$stock_combinacion,$precio_base,$combinacion_id,$valor_iva,$id_atributo_horizontal_valor,$id_atributo_vertical_valor,$tiene_descuento,$precio_descuento,$promociones,$qty)
		//console.log(result);
					json=JSON.parse(result); 
				//	console.log(json);
					if(json){ 
						var total_sin_iva=json[1];
						var total_descuento=json[7]
						//INCREMENTOS
						var incrementos=0;
						
						//POR FORMA
						var incremento_formas=0;
						var n_formas=0;
						var precio_forma=$(contenedor+'.formas_panel').attr('data-info'); 
						$(contenedor+'.formas_panel').each(function(){ 
							var num=parseInt($(this).val());
							if(!num.isNaN && num>0){
								incremento_formas = parseFloat(incremento_formas) + num*precio_forma;
								n_formas=n_formas+num;
							}
							
						})

						if(n_formas>0){
							$(contenedor+'.croquis_forma').removeClass('hidden');
						}else{
							$(contenedor+'.croquis_forma').addClass('hidden');
						}

						//INCREMENTOS VERSIONES
						
						var incremento_version=calcula_incremento_version(total_sin_iva,0);
						//INCREMENTOS VIDRIO ESPEJO
						var incremento_espejo=calcula_incremento_vidrio_espejo(total_sin_iva,0);

						//INCREMENTOS COMPONENTES
						var incremento_componentes=calcula_incremento_componentes(total_sin_iva,0);
						
						//INCREMENTOS ALTO
						var incrementos_alto=get_incrementos_alto(id_product,total_sin_iva);
						
						//INCREMENTOS ANCHO
						var incrementos_ancho=get_incrementos_ancho(id_product,total_sin_iva);
						

						//DUCHA BANERA
						var incremento_banera=0;
						if($(contenedor+'.ducha_banera').length>0){
							var in_banera=$(contenedor+'.ducha_banera.activo').attr('data-in'); 
							//INCREMENTO BAÑERA HASTA ALTURA ESTANDAR BAÑERA, ALTURAS SUPERIORES PRECIO DUCHA
							var altura_estandar_banera=$(contenedor+'.alto_total').attr('data-estandar-banera');
							var alto_total=$(contenedor+'.alto_total').val();
							if(parseFloat(altura_estandar_banera)!=0 && parseFloat(altura_estandar_banera)>parseFloat(alto_total))
							{
								incremento_banera=total_sin_iva*in_banera/100;
							}
							
						}

						//RECERCO
						incremento_recerco=0;
						if($(contenedor+'.recerco_input').length >0){
							$(contenedor+'.resumen_paneles .resumen_recerco').addClass('hidden');
							$(contenedor+'.recerco_input').each(function(){
								if($(this).is(':checked')){
									var num_recerco=$(this).attr('data-panel');
									var incre=$(this).attr('data-recerco');
									var alto_recerco=$('.alto_total').val();
									//SI NO SE PIDE LA MEDIDA DEL HUECO SE TOMA EL ANCHO TOTAL (PARA PUERTAS)
									if($(contenedor+'.m_panel_'+num_recerco).length>0){
										var ancho_recerco=$(contenedor+'.m_panel_'+num_recerco).val();
									}else{
										var ancho_recerco=$(contenedor+'.atributo_horizontal').val();
									}
									
									incremento_recerco=parseFloat(incremento_recerco)+[2*parseFloat(alto_recerco)+parseFloat(ancho_recerco)]*incre/100;
									if(isNaN(incremento_recerco)){ incremento_recerco=0}
									var num=$(this).attr('data-panel');
									$(contenedor+'#resumen_panel_'+num+' .resumen_recerco').html('Recerco');
									$(contenedor+'#resumen_panel_'+num+' .resumen_recerco').removeClass('hidden');
								}
							});
							
						}

		
						incrementos=incremento_formas+incrementos_alto+incrementos_ancho+incremento_componentes+incremento_version+incremento_espejo+incremento_banera+incremento_recerco;


						total=parseFloat(total_sin_iva)+parseFloat(incrementos);
						total_descuento=parseFloat(total_descuento)+parseFloat(incrementos);

						var total_primer_incremento=total;

						//INCREMENTOS SOBRE BASE INCREMENTADAD EN VERSIONES Y COMPONENTES
						var incremento_version_incrementada=calcula_incremento_version(total,1);
						var incremento_espejo_incrementada=calcula_incremento_vidrio_espejo(total,1);
						var incremento_componentes_incrementada=calcula_incremento_componentes(total,1);
					

						total=parseFloat(total)+parseFloat(incremento_version_incrementada)+parseFloat(incremento_componentes_incrementada)+parseFloat(incremento_espejo_incrementada);
						total_descuento=parseFloat(total_descuento)+parseFloat(incremento_version_incrementada)+parseFloat(incremento_componentes_incrementada)+parseFloat(incremento_espejo_incrementada);

						incremento_version=parseFloat(incremento_version)+parseFloat(incremento_version_incrementada);
						incremento_componentes=parseFloat(incremento_componentes)+parseFloat(incremento_componentes_incrementada);
						incremento_espejo=parseFloat(incremento_espejo)+parseFloat(incremento_espejo_incrementada);
						
						//DUCHA BAÑERA
						/*
						if($('.ducha_banera').length>0){
							var incremento_banera=$('.ducha_banera.activo').attr('data-in');
							total=total+total*incremento_banera/100;
							total_descuento=total_descuento+total_descuento*incremento_banera/100;
						}*/
						
						//ADICIONALES
						var total_adicionales=0;
						if($(contenedor+'#total_adicionales').length>0){
							total_adicionales=$(contenedor+'#total_adicionales').val();
						}
					
						total=parseFloat(total)+parseFloat(total_adicionales);
						total_descuento=parseFloat(total_descuento)+parseFloat(total_adicionales);

						//RESUMEN VIDRIO ESPEJO
						if($(contenedor+'.vidrio_espejo_input').length >0){
							var cont_vidrios=0; 
							$(contenedor+'.resumen_paneles .resumen_espejo').addClass('hidden');
							$(contenedor+'.vidrio_espejo_input').each(function(){
								if($(this).prop('checked')){
									cont_vidrios =parseInt(cont_vidrios)+1;
									var num=$(this).attr('data-panel');
									$(contenedor+'#resumen_panel_'+num+' .resumen_espejo').html('Vidrio Espejo');
									$(contenedor+'#resumen_panel_'+num+' .resumen_espejo').removeClass('hidden');
								}
							});
							if($(contenedor+'.resumen_vidrio_espejo').length>0){
								$(contenedor+'.resumen_vidrio_espejo').html(cont_vidrios);
							}
						}

						//RESUMEN TERCERA BISAGRA
						if($(contenedor+'.tercera_bisagra_input').length >0){
							var cont_vidrios=0; 
							$(contenedor+'.resumen_paneles .resumen_tercera_bisagra').addClass('hidden');
							$(contenedor+'.tercera_bisagra_input').each(function(){
								if($(this).is(':checked')){
									
									var num=$(this).attr('data-panel');
									$(contenedor+'#resumen_panel_'+num+' .resumen_tercera_bisagra').html('Tercera Bisagra');
									$(contenedor+'#resumen_panel_'+num+' .resumen_tercera_bisagra').removeClass('hidden');
								}
							});
							
						}
						
						//PRECIO BASE
						if(total!=total_sin_iva){
							$(contenedor+'.row-precio_base').removeClass('hidden');
							$(contenedor+'.product-price-base').html(parseFloat(total_sin_iva).toFixed(2)+' €');
						}else{
							$(contenedor+'.row-precio_base').addClass('hidden');
						}
						
						//INCREMENTOS
						if(incremento_formas!=0){
							$(contenedor+'.row-incremento-formas').removeClass('hidden');
							$(contenedor+'.price-incremento-formas').html(incremento_formas.toFixed(2)+' €');
						}else{
							$(contenedor+'.row-incremento-formas').addClass('hidden');
						}
						if(incrementos_alto!=0){
							$(contenedor+'.row-incremento-alto').removeClass('hidden');
							$(contenedor+'.price-incremento-alto').html(incrementos_alto.toFixed(2)+' €');
						}else{
							$(contenedor+'.row-incremento-alto').addClass('hidden');
						}
						if(incrementos_ancho!=0){
							$(contenedor+'.row-incremento-ancho').removeClass('hidden');
							$(contenedor+'.price-incremento-ancho').html(incrementos_ancho.toFixed(2)+' €');
						}else{
							$(contenedor+'.row-incremento-ancho').addClass('hidden');
						}
						if(incremento_componentes!=0){
							$(contenedor+'.row-incremento-componentes').removeClass('hidden');
							$(contenedor+'.price-incremento-componentes').html(incremento_componentes.toFixed(2)+' €');
						}else{
							$(contenedor+'.row-incremento-componentes').addClass('hidden');
						}
						if(incremento_version!=0){
							$(contenedor+'.row-incremento-version').removeClass('hidden');
							$(contenedor+'.price-incremento-version').html(incremento_version.toFixed(2)+' €');
						}else{
							$(contenedor+'.row-incremento-version').addClass('hidden');
						}
						if(incremento_espejo!=0){
							$(contenedor+'.row-incremento-espejo').removeClass('hidden');
							$(contenedor+'.price-incremento-espejo').html(incremento_espejo.toFixed(2)+' €');
						}else{
							$(contenedor+'.row-incremento-espejo').addClass('hidden');
						}
						if(incremento_banera!=0){
							$(contenedor+'.row-incremento-banera').removeClass('hidden');
							$(contenedor+'.price-incremento-banera').html(incremento_banera.toFixed(2)+' €');
						}else{
							$(contenedor+'.row-incremento-banera').addClass('hidden');
						}
						if(incremento_recerco!=0){
							$(contenedor+'.row-incremento-recerco').removeClass('hidden');
							$(contenedor+'.price-incremento-recerco').html(incremento_recerco.toFixed(2)+' €');
						}else{
							$(contenedor+'.row-incremento-recerco').addClass('hidden');
						}
						if(total_adicionales!=0){
							$(contenedor+'.row-incremento-fijo-adicional').removeClass('hidden');
							$(contenedor+'.price-incremento-fijo-adicional').html(parseFloat(total_adicionales).toFixed(2)+' €');
						}else{
							$(contenedor+'.row-incremento-fijo-adicional').addClass('hidden');
						}
						//TOTAL
						//18.10.2019 NO SE MUESTRAN LOS DESCUENTOS EN LA FICHA DEL PRODUCTO
						//if(total==total_descuento){
							$(contenedor+'.product-price').html('<ins>'+total.toFixed(2)+' €</ins>');
						//}else{
						//	$('.product-price').html('<ins>'+total_descuento.toFixed(2)+' €</ins><del>'+total.toFixed(2)+' €</del>');
						//}
						
						$(contenedor+'#tab_resumen').removeClass('hidden');

						if(devuelve){
							return [result,total,total_primer_incremento];
						}
	    		
				}
	    		
    		}
    		
	}

	function valida_restricciones_por_rango(id_product,valor){
		var validado=true;
		var mensaje_error='';
		var type = 'POST';
		var url = site_url + '/home/get_resticciones_por_rango_ajax';
		
		var data = {
			'id_product':id_product,
			'ancho':valor
		};
		
		var result = ActionAjax(type, url, data, null, null, true);
//console.log(result);
		json=JSON.parse(result);
		if(json[0]!=1){
			mensaje_error="Ancho derecho fuera de rango";
			validado=false;
		}

		return [validado,mensaje_error];
	}
	
	function valida_suma_ancho(){
		//var id_product=$('.atributo_horizontal').attr('data-id');
		var id_product=$(contenedor+'#id_product_modelo').val();
		$('.ancho_total').next(contenedor+'.mensaje_error_medida').addClass('hidden');
		var validado=true;
		var mensaje_error="";
		
		var ancho_derecho=ancho_izquierdo=0;
		if($(contenedor+'.ancho_derecho').length>0 && !isNaN(parseFloat($(contenedor+'.ancho_derecho').val()))){
			ancho_derecho=parseFloat($(contenedor+'.ancho_derecho').val());
		}
		if($(contenedor+'.ancho_izquierdo').length>0 && !isNaN(parseFloat($(contenedor+'.ancho_izquierdo').val()))){
			ancho_izquierdo=parseFloat($(contenedor+'.ancho_izquierdo').val());
		}
		
		var suma=ancho_izquierdo + ancho_derecho;

		var max_ancho=$(contenedor+'.ancho_total').attr('data-max'); 
		var min_ancho=$(contenedor+'.ancho_total').attr('data-min');
	
		if(max_ancho!=0 && parseFloat(suma)>parseFloat(max_ancho)){
			validado=false;
			mensaje_error +="<p>El ancho total debe ser menor a "+max_ancho+"</p>";
		}
		if(parseFloat(suma)<parseFloat(min_ancho)){
			validado=false;
			mensaje_error +="<p> El ancho total debe ser mayor a "+min_ancho+"</p>";
		}
			//RANGO DE PRECIOS QUE NO SE SOLAPAN
	/*	26.08.2020 Medida no personalizable
	if(validado && ancho_derecho!=0 && ancho_izquierdo!=0){
			var type = 'POST';
			var url = base_url + 'productos/get_resticciones_por_rango_ajax';
			
			var data = {
				'id_product':id_product,
				'ancho':suma
			};
			
			var result = ActionAjax(type, url, data, null, null, true);

			json=JSON.parse(result);
			if(json[0]!=1){
				mensaje_error="Medida no disponible para este modelo";
				validado=false;
			}
			
		}*/
		if(validado && ancho_derecho!=0){
			var aux=valida_restricciones_por_rango(id_product,ancho_derecho);
			validado=aux[0];
			mensaje_error=aux[1];
			/*var type = 'POST';
			var url = base_url + 'productos/get_resticciones_por_rango_ajax';
			
			var data = {
				'id_product':id_product,
				'ancho':ancho_derecho
			};
			
			var result = ActionAjax(type, url, data, null, null, true);

			json=JSON.parse(result);
			if(json[0]!=1){
				mensaje_error="Ancho derecho fuera de rango";
				validado=false;
			}
			*/
		}
		if(validado && ancho_izquierdo!=0){
			var aux=valida_restricciones_por_rango(id_product,ancho_izquierdo);
			validado=aux[0];
			mensaje_error=aux[1];
		/*	var type = 'POST';
			var url = base_url + 'productos/get_resticciones_por_rango_ajax';
			
			var data = {
				'id_product':id_product,
				'ancho':ancho_izquierdo
			};
			
			var result = ActionAjax(type, url, data, null, null, true);

			json=JSON.parse(result);
			if(json[0]!=1){
				mensaje_error="Ancho izquierdo fuera de rango";
				validado=false;
			}
			*/
		}
		if(validado){
			$(contenedor+'.ancho_total').val(suma.toFixed(2));
			$(contenedor+'.resumen_ancho_derecho').html(ancho_derecho+' cm');
			$(contenedor+'.resumen_ancho_izquierdo').html(ancho_izquierdo+' cm');
			
			$(contenedor+'.resumen_ancho').html(suma.toFixed(2));
			
			combinacion_actualiza();
		}else{
			$(contenedor+'.ancho_derecho').val('');
			$(contenedor+'.ancho_izquierdo').val('');

			$(contenedor+'.ancho_total').next('.mensaje_error_medida').html(mensaje_error);
			$(contenedor+'.ancho_total').next('.mensaje_error_medida').removeClass('hidden');
		}
		
	}
	
	function inicializa_modelo(){
	
			combinacion_actualiza();
		$(contenedor+'.valor_componente input[type=radio]').each(function(){
			if($(this).prop('checked')){
				$(this).prev('img').addClass('border-gray');
			}
		});

		$(contenedor+'.valor_componente input[type=checkbox]').each(function(){
			if($(this).prop('checked')){
				$(this).prev('img').addClass('border-gray');
			}
		});

		$(contenedor+'.adicionales_valor_componente input[type=radio]').each(function(){
			if($(this).prop('checked')){
				$(this).prev('img').addClass('border-gray');
			}
		});

		$(contenedor+'.adicionales_valor_componente input[type=checkbox]').each(function(){
			if($(this).prop('checked')){
				$(this).prev('img').addClass('border-gray');
			}
		});
		var vertical=$('.atributo_vertical').val();
		if(vertical && $('.decorado_v_valor_'+vertical).length>0){
			$('.decorado_v_valor_'+vertical).removeClass('oculta');
		}
		$('.image_decorado_v').each(function(){
			$(this).removeClass('border-gray');
			if($(this).next().is(':checked')){
				$(this).addClass('border-gray');
			}
		})
		/*$('.carousel').owlCarousel({
			loop:true,
			margin:10,
			nav:true,
			responsive:{
				0:{
					items:4
				},
				600:{
					items:4
				},
				1000:{
					items:6
				}
			}
		})*/
	}
	$(document).delegate(contenedor+'.valor_decorados input[type=radio]','change',function(){
		var id=$(this).attr('name');
		$(contenedor+'img.image_'+id).removeClass('border-gray');
		if($(this).prop('checked')){
				$(this).prev('img').addClass('border-gray');
			}
	});
	$(document).delegate(contenedor+'input[name=version_sel]','change' , function(){
		$(contenedor+'.componentes_version').addClass('hidden');
		var id=$(contenedor+'input[name=version_sel]:checked').val(); 
		$(contenedor+'.componentes_version_'+id).removeClass('hidden');

		$(contenedor+'.resumen_componentes').addClass('hidden');
		$(contenedor+'.resumen_version_'+id).removeClass('hidden');

		combinacion_actualiza();
	})

	$(document).delegate(contenedor+'.valor_componente input[type=radio]','change',function(){
		var id=$(this).attr('name'); 
		$(contenedor+'img.img_'+id).removeClass('border-gray');
		if($(this).prop('checked')){
				$(this).prev('img').addClass('border-gray');
			}
	});
	$(document).delegate(contenedor+'.valor_componente input[type=checkbox]','change',function(){
		var id=$(this).attr('name'); 
		$(contenedor+'img.img_'+id).removeClass('border-gray');
		if($(this).prop('checked')){
				$(this).prev('img').addClass('border-gray');
			}
	});

	$(document).delegate(contenedor+'.alto_total','blur',function(){ 
		$(this).next().next(contenedor+'.mensaje_error_medida').addClass('hidden');
		var validado=true;
		var max=$(this).attr('data-max');
		var min =$(this).attr('data-min');
		var alto=$(this).val();
		var mensaje_error="";
		if(max!=0 && parseFloat(alto)>parseFloat(max)){
			validado=false;
			mensaje_error="El valor debe ser menor a "+max;
		}
		if(parseFloat(alto)<parseFloat(min)){
			validado=false;
			mensaje_error=" El valor debe ser mayor a "+min;
		}
		if(validado){
			$(contenedor+'.resumen_alto').html(alto);
		
			combinacion_actualiza();
		}else{
			$(contenedor+'.resumen_alto').html('');
			$(this).next().next(contenedor+'.mensaje_error_medida').html(mensaje_error);
			$(this).next().next(contenedor+'.mensaje_error_medida').removeClass('hidden');
			$(contenedor+'.product-price').html('');
		}
	});
	
	$(document).delegate(contenedor+'.atributo_horizontal','blur',function(){ 
		$(this).next(contenedor+'.mensaje_error_medida').addClass('hidden');
		//var id_product=$('.atributo_horizontal').attr('data-id');
		var id_product=$(contenedor+'#id_product_modelo').val();
		var validado=true;
		var max=$(this).attr('data-max');
		var min =$(this).attr('data-min');
		var ancho=$(this).val();
		var mensaje_error="";
		if(max!=0 && parseFloat(ancho)>parseFloat(max)){
			validado=false;
			mensaje_error="El valor debe ser menor a "+max;
		}
		if(parseFloat(ancho)<parseFloat(min)){
			validado=false;
			mensaje_error=" El valor debe ser mayor a "+min;
		}
		//RANGO DE PRECIOS QUE NO SE SOLAPAN
		if(validado){
			var type = 'POST';
			var url = site_url + '/home/get_resticciones_por_rango_ajax';
			
			var data = {
				'id_product':id_product,
				'ancho':ancho
			};
			
			var result = ActionAjax(type, url, data, null, null, true);

			json=JSON.parse(result);
			if(json[0]!=1){
				mensaje_error="Medida no disponible para este modelo";
				validado=false;
			}
			
		}
		if(validado){
			$(contenedor+'.resumen_ancho').html(ancho);
			
			combinacion_actualiza();
		}else{
			$(contenedor+'.resumen_ancho').html('');
			$(this).next('.mensaje_error_medida').html(mensaje_error);
			$(this).next('.mensaje_error_medida').removeClass('hidden');
			$(contenedor+'.product-price').html('');
		}
	});
	
	$(document).delegate(contenedor+'.medida_panel','blur',function(){ 
		$(this).removeClass('border-red');
		$(this).next('.mensaje_error_medida').addClass('hidden');
		var validado=true;
		var max=parseFloat($(this).attr('data-max'));
		var min =parseFloat($(this).attr('data-min'));
		var max_fix=parseFloat($(this).attr('data-max-fix'));
		var min_fix =parseFloat($(this).attr('data-min-fix'));
		var max_vidrios=parseFloat($(this).attr('data-max-vidrios'));
		var min_vidrios =parseFloat($(this).attr('data-min-vidrios'));
		var max_guia=parseFloat($(this).attr('data-max-guia'));
		var min_guia =parseFloat($(this).attr('data-min-guia'));
		var anchura=parseFloat($(this).val());
		var ancho_total=parseFloat($('.ancho_total').val());
		var derecha=$(this).attr('data-derecha');
		var izquierda=$(this).attr('data-izquierda');
		var fijo=parseFloat($(this).attr('data-fix'));
		var mensaje_error="";
		var suma_sin_huecos=suma_con_huecos=0;
		var tiene_huecos=false;
		var medida_huecos=0;
		var is_hueco=$(this).attr('data-hueco');
		$(contenedor+'.paneles').each(function(){
			var medida_item=$(this).find('.medida_panel');

			if(medida_item){
				medida=medida_item.val();
				if( medida && !isNaN(parseFloat(medida))){
					if($(this).attr('data-hueco')=='0'){
						suma_sin_huecos = parseFloat(suma_sin_huecos) + parseFloat(medida);
					}else{
						tiene_huecos=true;
						medida_huecos=parseFloat(medida_huecos)  + parseFloat(medida);
					}

					suma_con_huecos = parseFloat(suma_con_huecos) + parseFloat(medida);
				}
			}
		})

		if(fijo==1){
			if(max_fix!=0 && anchura>max_fix){
				validado=false;
				mensaje_error="El valor debe ser menor a "+max_fix;
			}
			if(anchura<min_fix){
				validado=false;
				mensaje_error=" El valor debe ser mayor a "+min_fix;
			}
		}
		if(derecha=='1'){
			var suma_paneles_derecho="";
			$(contenedor+'.medida_panel').each(function(){
				if($(this).attr('data-derecha')=='1'){
					suma_paneles_derecho=suma_paneles_derecho+parseFloat($(this).val());
				}
			})
			if($(contenedor+'.ancho_derecho').length>0 && suma_paneles_derecho>parseFloat($('.ancho_derecho').val())){
				validado=false;
				mensaje_error="Se ha superado el ancho derecho indicado";
			}
		}
		if(izquierda=='1'){
			var suma_paneles_izquierda="";
			$(contenedor+'.medida_panel').each(function(){
				if($(this).attr('data-izquierda')=='1'){
					suma_paneles_izquierda=suma_paneles_izquierda+parseFloat($(this).val());
				}
			})
			if($(contenedor+'.ancho_izquierdo').length>0 && suma_paneles_izquierda>parseFloat($('.ancho_izquierdo').val())){
				validado=false;
				mensaje_error="Se ha superado el ancho izquierdo indicado";
			}
		}
		if(max!=0 && anchura>max){
			validado=false;
			mensaje_error="El valor debe ser menor a "+max;
		}
		if(anchura<min){
			validado=false;
			mensaje_error=" El valor debe ser mayor a "+min;
		}
		
		
		if(anchura>ancho_total && is_hueco=='0'){
			validado=false;
			mensaje_error="La anchura no puede ser superior a la ancho total ";
		}
		if(max_vidrios!=0 && suma_sin_huecos>max_vidrios){
			validado=false;
			mensaje_error="La suma de los vidrios no puede ser mayor a "+max_vidrios;
		}

		if(min_vidrios!=0 && suma_sin_huecos<min_vidrios){
			validado=false;
			mensaje_error="La suma de los vidrios no puede ser inferior a "+min_vidrios;
		}

		if(max_guia!=0 && suma_con_huecos>max_guia){
			validado=false;
			mensaje_error="La suma de la guía no puede ser mayor a "+max_guia;
		}

		if(min_guia!=0 && suma_con_huecos<min_guia){
			validado=false;
			mensaje_error="La suma de la guía no puede ser inferior a "+min_guia;
		}

		if(validado){

			var num =$(this).attr('data-panel');
			$(contenedor+'#resumen_panel_'+num+' .resumen_medidas_panel').html($(this).val()+' cm');
			$(contenedor+'#resumen_panel_'+num+' .resumen_medidas_panel').removeClass('hidden');
			if(tiene_huecos){
				$(contenedor+'.mensaje_ancho_mas_huecos').removeClass('hidden');
				var ancho_total_huecos=parseFloat(ancho_total)+parseFloat(medida_huecos);
				$(contenedor+'.mensaje_ancho_mas_huecos').html('Ancho total: '+ancho_total_huecos+' cm');
			}
		
			combinacion_actualiza();
		}else{
			$(contenedor+'.mensaje_ancho_mas_huecos').addClass('hidden');
			$(contenedor+'.mensaje_ancho_mas_huecos').html('');
			$(this).val('');
			$(this).next('.mensaje_error_medida').html(mensaje_error);
			$(this).next('.mensaje_error_medida').removeClass('hidden');
			$(contenedor+'.product-price').html('');
		}
	});
	
	$(document).delegate(contenedor+'.ancho_panel','blur',function(){ 
		$(this).next('.mensaje_error_medida').addClass('hidden');
		var validado=true;
		var max=parseFloat($(this).attr('data-max'));
		var min =parseFloat($(this).attr('data-min'));
		var max_fix=parseFloat($(this).attr('data-max-fix'));
		var min_fix =parseFloat($(this).attr('data-min-fix'));
		var ancho=parseFloat($(this).val());
		var ancho_total=parseFloat($('.ancho_total').val());
		var fijo=parseFloat($(this).attr('data-fix'));
		var mensaje_error="";
		if(max!=0 && ancho>max){
			validado=false;
			mensaje_error="El valor debe ser menor a "+max;
		}
		if(ancho<min){
			validado=false;
			mensaje_error=" El valor debe ser mayor a "+min;
		}
		if(fijo==1){
			if(max_fix!=0 && ancho>max_fix){
				validado=false;
				mensaje_error="El valor debe ser menor a "+max;
			}
			if(ancho<min_fix){
				validado=false;
				mensaje_error=" El valor debe ser mayor a "+min;
			}
		}
		
		var suma_anchos=0;
		if($(contenedor+'.ancho_panel').length>0){
			$(contenedor+'.ancho_panel').each(function(){
			if(!isNaN(parseFloat($(this).val())))
				suma_anchos += parseFloat($(this).val());
			});
			if(suma_anchos>ancho_total){
				validado=false;
				mensaje_error="la suma de los anchos de los paneles no puede ser superior al total";
			}
		}
		//validado=valida_suma_ancho();
		if(validado){
			combinacion_actualiza();
		}else{
			$(this).next('.mensaje_error_medida').html(mensaje_error);
			$(this).next('.mensaje_error_medida').removeClass('hidden');
			$(contenedor+'.product-price').html('');
		}
	});
	$(document).delegate(contenedor+'.ancho_derecho','blur',function(){
		$(this).next('.mensaje_error_medida').addClass('hidden');
		var validado=true;
		var max=$(this).attr('data-max-lado');
		var min =$(this).attr('data-min-lado');
		var alto=$(this).val();
		var mensaje_error="";
		if(max!=0 && parseFloat(alto)>parseFloat(max)){
			validado=false;
			mensaje_error="El valor debe ser menor a "+max;
		}
		if(parseFloat(alto)<parseFloat(min)){
			validado=false;
			mensaje_error=" El valor debe ser mayor a "+min;
		}
		if(validado){
			valida_suma_ancho();
		}else{
			$(this).val('');
			$(this).next('.mensaje_error_medida').html(mensaje_error);
			$(this).next('.mensaje_error_medida').removeClass('hidden');
			$(contenedor+'.product-price').html('');
		}
		
		
	})
	$(document).delegate(contenedor+'.ancho_izquierdo','blur',function(){
		$(this).next('.mensaje_error_medida').addClass('hidden');
		var validado=true;
		var max=$(this).attr('data-max-lado');
		var min =$(this).attr('data-min-lado');
		var alto=$(this).val();
		var mensaje_error="";
		if(max!=0 && parseFloat(alto)>parseFloat(max)){
			validado=false;
			mensaje_error="El valor debe ser menor a "+max;
		}
		if(parseFloat(alto)<parseFloat(min)){
			validado=false;
			mensaje_error=" El valor debe ser mayor a "+min;
		}
	
		if(validado){
			
			valida_suma_ancho();
		}else{
			$(this).val('');
			$(this).next('.mensaje_error_medida').html(mensaje_error);
			$(this).next('.mensaje_error_medida').removeClass('hidden');
			$(contenedor+'.product-price').html('');
		}
		
		
	})

	$(document).delegate(contenedor+'.atributo_vertical','change',function(){
		
		var id=$(this).attr('data-id');
		var valor=$(this).val().split("-"); 
		
		//MUESTRO DECORADOS ASOCIADOS
		$(contenedor+'.valor_decorados').children().addClass('oculta');
		$(contenedor+'.decorado_v_valor_'+$(this).val()).removeClass('oculta');
		/*var owl = $(contenedor+'.decorado_v_valor_'+$(this).val()+' .carousel'); 
		owlResize(owl.owlCarousel(wysiwyg_owloptions)); */

		$(contenedor+'#resumen_decorado_'+id).html('');
		$(contenedor+'input[name=decorado_v]').prop('checked', false);
		$(contenedor+'.image_decorado_v').removeClass('border-gray');
		
		//ACTUALIZO RESUMEN
		$(contenedor+'#resumen_atributo_vertical_'+id+' .resumen_valores').addClass('hidden');
		$(contenedor+'#resumen_atributo_vertical_'+id+' .resumen_valores').each(function(){
			if($(this).attr('data-valor')==valor || $(this).attr('data-valor')==valor[1]){
				$(this).removeClass('hidden');
			}
		})
		
		
		combinacion_actualiza();
	});

	$(document).delegate(contenedor+'.pregunta','blur',function(){
		var id=$(this).attr('data-id');
		$(contenedor+'.resumen_pregunta_'+id).html($(this).val());
	})
	$(document).delegate(contenedor+'.formas_panel','blur',function(){ 
		var n_formas=0;
		$(contenedor+'.resumen_paneles .resumen_formas ').addClass('hidden');
		$(contenedor+'.formas_panel').each(function(){
			var num=parseInt($(this).val());
			if(!num.isNaN && num>0){
				n_formas +=  num;

				var id=$(this).attr('data-panel');
				$(contenedor+'#resumen_panel_'+id+' .resumen_formas_panel').html($(this).val()+' formas');
				$(contenedor+'#resumen_panel_'+id+' .resumen_formas_panel').removeClass('hidden');
			}
		});
		$(contenedor+'.resumen_formas').html(n_formas);
		
		combinacion_actualiza();
	});
	$(document).delegate(contenedor+'.ducha_banera','click',function(){ 
		$(contenedor+'.ducha_banera').addClass('btn-outline');
		$(contenedor+'.ducha_banera').removeClass('activo');
		$(this).removeClass('btn-outline');
		$(this).addClass('activo');

		//CAMBIO ALTO ESTANDAR SI NO ESTA MARCADO LA ESPOCION DE ALTURA ESPECIAL
		if(!$(contenedor+'.altura_especial').prop('checked')){ 
			if($(contenedor+'.ducha_banera').length>0){
				var tipo=$(contenedor+'.ducha_banera.activo').attr('data-tipo');  
				if(tipo && tipo==0){ //DUCHA
					$(contenedor+'.alto_total').val($(contenedor+'.alto_total').attr('data-estandar-ducha'));
					$(contenedor+'.resumen_alto').html($(contenedor+'.alto_total').attr('data-estandar-ducha'));
				}
				if(tipo && tipo==1){ //BAÑERA
					$(contenedor+'.alto_total').val($(contenedor+'.alto_total').attr('data-estandar-banera'));
					$(contenedor+'.resumen_alto').html($(contenedor+'.alto_total').attr('data-estandar-banera'));
				}
			}
		}
		
		var tipo=$(this).attr('data-tipo');
		if(tipo==1){
			$(contenedor+'.resumen_ducha_banera').html('Bañera');
		}else{
			$(contenedor+'.resumen_ducha_banera').html('Ducha');
		}
		
		combinacion_actualiza();
	});

	$(document).delegate(contenedor+'.valor_componente','click',function(){
		var input=$(this).find('input[type=radio],input[type=checkbox]');
		if(input){
			if(input.prop('checked')){
				var id=input.attr('id');
				var name=input.attr('name');
				var valor=input.val();
				var version=input.attr('version');
				$(contenedor+'#resumen_'+name+' .resumen_componente_valor').addClass('hidden');
				$(contenedor+'#resumen_'+name+' .resumen_componente_valor').each(function(){ 
					if($(this).attr('data-valor')==id){
						$(this).removeClass('hidden');
					}
				});

				//MODIFICO VALORES MAXIMOS DE ALTO Y ANCHO
				if(input.attr('data-alto')!="" && input.attr('data-alto')!=0){
					$(contenedor+'.alto_total').attr('data-max',input.attr('data-alto'));
				}else{
					$(contenedor+'.alto_total').attr('data-max',$(contenedor+'.alto_total').attr('data-max-old'));
				}

				if(parseFloat($(contenedor+'.alto_total').val())> parseFloat($(contenedor+'.alto_total').attr('data-max')) && $(contenedor+'.alto_total').attr('data-max')!=0){
						$(contenedor+'.alto_total').val('');
						$(contenedor+'.alto_total').next('.mensaje_error_medida').removeClass('hidden');
						$(contenedor+'.alto_total').next('.mensaje_error_medida').html('El valor debe ser menor a '+$(contenedor+'.alto_total').attr('data-max'));
					}else{
						$(contenedor+'.alto_total').next('.mensaje_error_medida').addClass('hidden');
					}
				if(input.attr('data-ancho')!="" && input.attr('data-ancho')!=0){
					$(contenedor+'.ancho_total').attr('data-max',input.attr('data-ancho'));
				}else{
					$(contenedor+'.ancho_total').attr('data-max',$(contenedor+'.ancho_total').attr('data-max-old')); 
				} 
				if(parseFloat($(contenedor+'.ancho_total').val())> parseFloat($(contenedor+'.ancho_total').attr('data-max')) && $(contenedor+'.ancho_total').attr('data-max')!=0){
						$(contenedor+'.ancho_total').val('');
						$(contenedor+'.ancho_total').next('.mensaje_error_medida').removeClass('hidden');
						$(contenedor+'.ancho_total').next('.mensaje_error_medida').html('El valor debe ser menor a '+$('.ancho_total').attr('data-max'));
					}else{
						$(contenedor+'.ancho_total').next('.mensaje_error_medida').addClass('hidden');
					}
			}
			if(input.attr('type')=='checkbox'){
				if(!input.is(':checked')){
					var name=input.attr('name');
					$(contenedor+'#resumen_'+name+' .resumen_componente_valor').addClass('hidden');
				}
			}
		}

		//COLORES
		var id=input.attr('id');
		$(contenedor+'.valor_componente').each(function(){
			var input2=$(this).find('input[type=radio],input[type=checkbox]');
			if(input2.is(':checked')){	
				var valor=input2.val(); 
				var color=input2.attr('data-color'); 
				var name=input2.attr('name');
				$(contenedor+'.color_'+name).addClass('hidden');
				if(color==1){
					$(contenedor+'.color_ral_'+valor).removeClass('hidden');
				}
			}
		})
		combinacion_actualiza();
	});
	
	$(document).delegate(contenedor+'.color_ral','blur',function(){
		var name=$(this).attr('name');
		$(contenedor+'.resumen_'+name).html($(this).val());
	})
	$(document).delegate(contenedor+'input[name=decorado_v]','change',function(){
		var input=$(contenedor+'input[name=decorado_v]:checked');
		var decorado=input.attr('data-decorado');
		var atributo=input.attr('data-atributo');
		var valor=input.val();
		$(contenedor+'#resumen_decorado_'+atributo).html('<br>('+decorado+': '+valor+')');
	});
	$(document).delegate(contenedor+'.vidrio_espejo_input','click',function(){
		combinacion_actualiza();
	})

	$(document).delegate(contenedor+'.tercera_bisagra_input','change',function(){ 
		combinacion_actualiza();
	})
	
	$(document).delegate(contenedor+'.recerco_input','click',function(){
		combinacion_actualiza();
	})
	
	//ADICIONALES
	
	function get_incrementos_alto_adicionales(id_product,total){
		var type = 'POST';
			var url = site_url + '/home/get_incrementos_alto_ajax';
			
			var total=total;
			var alto=$('.adicionales_alto_total').val();
			var id_product=id_product;
			var tipo=0;
			if($(contenedor+'.ducha_banera').length>0){
				if($(contenedor+'#ducha').hasClass('activo')){
					tipo=1;
				}else{
					tipo=2;
				}
			}
	
			var data = {
				'total': total,
				'id_product' : id_product,
				'alto' : alto,
				'tipo': tipo
			};
			
			var result = ActionAjax(type, url, data, null, null, true);

    		json=JSON.parse(result);
    		
    		if(json){
    			return json[0];
    		}else{
    			return 0;
    		}
	}
	
	function get_incrementos_ancho_adicionales(id_product,total){
		var type = 'POST';
			var url = site_url + '/home/get_incrementos_ancho_ajax';
			
			var total=total;
			var ancho=$(contenedor+'.adicionales_ancho_total').val();
			var id_product=id_product;
			
	
			var data = {
				'total': total,
				'id_product' : id_product,
				'ancho' : ancho,
			};
			
			var result = ActionAjax(type, url, data, null, null, true);

    		json=JSON.parse(result);
    		
    		if(json){
    			return json[0];
    		}else{
    			return 0;
    		}
	}
	
    function calcula_incremento_version_adicionales(total_sin_iva,base){
		var incremento_version=0;
		var type = 'POST';
		var url = site_url + '/home/get_incrementos_versiones_ajax';
	
		var version=$(contenedor+'input[name=adicionales_version_sel]:checked').val(); 
		var atributo_horizontal=$(contenedor+'.adicionales_atributo_horizontal').val();
		var atributo_vertical =$(contenedor+'.adicionales_atributo_vertical').val();
		var id_product=$(contenedor+'.adicionales_atributo_horizontal').attr('data-id');
		var vidrio_espejo=0;
		if($(contenedor+'.adicionales_vidrio_espejo_input').length>0){
			$(contenedor+'.adicionales_vidrio_espejo_input').each(function(){
				if($(this).prop('checked')){
					vidrio_espejo = parseInt(vidrio_espejo) +1;
				}
			})
		}
		
		var data = {
			'atributo_horizontal': atributo_horizontal,
			'atributo_vertical' : atributo_vertical,
	
			'id_product':id_product,
			'total_sin_iva': total_sin_iva,
			'vidrio_espejo':vidrio_espejo,
			'version':version,
			'base':base
		};
		
		var result = ActionAjax(type, url, data, null, null, true);
//alert(result);
		json=JSON.parse(result);
		
		if(json && !isNaN(parseFloat(json[0]))){
			incremento_version = parseFloat(json[0]);
		}

		return incremento_version;
	}

	function calcula_incremento_componentes_adicionales(total_sin_iva,base){
		var incremento_componentes=0;
		var componentes_sel="";
		var id_product=$(contenedor+'.adicionales_atributo_horizontal').attr('data-id');
		var version=$(contenedor+'input[name=adicionales_version_sel]:checked').val();
		$(contenedor+'.adicionales_componentes_version_'+version+' .adicionales_valor_componente').each(function(){
			var input=$(this).find('input[type=radio],input[type=checkbox]');
			if(input.prop('checked')){
				componentes_sel +=input.val()+',';
			}
		});
		
		var vidrio_espejo=0;
		if($(contenedor+'.adicionales_vidrio_espejo_input').length>0){
			$(contenedor+'.adicionales_vidrio_espejo_input').each(function(){
				if($(this).prop('checked')){
					vidrio_espejo = parseInt(vidrio_espejo) +1;
				}
			})
		}
		

		$(contenedor+'.adicionales_componentes_version_'+version+'  .adicionales_valor_componente').each(function(){
			var estandar=$(this).attr('data-estandar');
			//var incremento_comp=$(this).attr('data-incremento');
			//var tipo_incremento_comp=$(this).attr('data-tipo');
			var input=$(this).find('input[type=radio],input[type=checkbox]');
			//if(input.prop('checked') && estandar==0){
			if(input.prop('checked')){		
				var type = 'POST';
				var url = site_url + '/home/get_incrementos_componentes_ajax';
				
				var atributo_horizontal=$(contenedor+'.adicionales_atributo_horizontal').val();
				var atributo_vertical =$(contenedor+'.adicionales_atributo_vertical').val();
				
				var data = {
					'atributo_horizontal': atributo_horizontal,
					'atributo_vertical' : atributo_vertical,
					'componentes_sel' : componentes_sel,
					'id_relacion': input.val(),
					'id_product':id_product,
					'total_sin_iva': total_sin_iva,
					'vidrio_espejo':vidrio_espejo,
					'version':version,
					'base':base
				};
				
				var result = ActionAjax(type, url, data, null, null, true);
	
	    		json=JSON.parse(result);
				
				if(json && !isNaN(parseFloat(json[0]))){
	    			incremento_componentes += parseFloat(json[0]);
	    		}
				/*
				if( tipo_incremento_comp == 1){
					incremento_componentes += parseFloat(incremento_comp);
					
				}else if(tipo_incremento_comp == 0){
					incremento_componentes += total_sin_iva*parseFloat(incremento_comp)/100;
				}*/
			}
		});
	
		return parseFloat(incremento_componentes);
	}
	function combinacion_actualiza_adicionales(){
    	
    		var type = 'POST';
			var url = site_url + '/home/get_comb_stock_precio_mampara_ajax';
			var combinaciones_attr="";
			
			var id_product=$(contenedor+'.adicionales_atributo_horizontal').attr('data-id');
			var id_atributo_vertical=$(contenedor+'.adicionales_atributo_vertical').attr('data-id');
			var id_atributo_vertical_valor=$(contenedor+'.adicionales_atributo_vertical').val();
			var atributo_horizontal_valor=$(contenedor+'.adicionales_atributo_horizontal').val();
			
			var data = {
				'id_atributo_vertical': id_atributo_vertical,
				'id_product' : id_product,
				'id_atributo_vertical_valor' : id_atributo_vertical_valor,
				'atributo_horizontal_valor' : atributo_horizontal_valor,
				'qty':1,
				//'aplica_promocion':aplica_promocion
			};
			
			var result = ActionAjax(type, url, data, null, null, true);
			//parray($stock_combinacion,$precio_base,$combinacion_id,$valor_iva,$id_atributo_horizontal_valor,$id_atributo_vertical_valor,$tiene_descuento,$precio_descuento,$promociones,$qty,$procentaje_iva,$porcentaje_recargo,$id_atributo_vertical,$id_atributo_horizontal,$descuento1,$descuento2,$descuento3,$descuento4)
//alert(result);
    		json=JSON.parse(result);
    		if(json){
    			//var total_sin_iva=json[1]-json[3];
				var total_sin_iva=json[1];
    		
	    		//INCREMENTOS
	    		var incrementos=0;
	    		
	    		//POR FORMA
	    		var incremento_formas=0;
	    		var precio_forma=$(contenedor+'.formas_adicionales').attr('data-info'); 
	    		$(contenedor+'.formas_adicionales').each(function(){ 
	    			var num=parseInt($(this).val());
	    			if(!num.isNaN && num>0){
	    				incremento_formas = parseFloat(incremento_formas) + num*precio_forma;
	    			}
	    			
	    		})
				
				//VERSUION
				var version=$('input[name=adicionales_version_sel]:checked').val();

				var incremento_version=calcula_incremento_version_adicionales(total_sin_iva,0);

	    		//INCREMENTOS COMPONENTES
	    		var incremento_componentes=calcula_incremento_componentes_adicionales(total_sin_iva,0);
	    		
	    		
	    		//INCREMENTOS ALTO
	    		var incrementos_alto=get_incrementos_alto_adicionales(id_product,total_sin_iva);
	    		
	    		//INCREMENTOS ANCHO
	    		var incrementos_ancho=get_incrementos_ancho_adicionales(id_product,total_sin_iva);
	    		
	    		incrementos=incremento_formas+incrementos_alto+incrementos_ancho+incremento_componentes+incremento_version;
	    		total=parseFloat(total_sin_iva)+parseFloat(incrementos);

				//INCREMENTOS SOBRE BASE INCREMENTADAD EN VERSIONES Y COMPONENTES
				var incremento_version_incrementada=calcula_incremento_version_adicionales(total,1);
				var incremento_componentes_incrementada=calcula_incremento_componentes_adicionales(total,1);

				total=parseFloat(total)+parseFloat(incremento_version_incrementada)+parseFloat(incremento_componentes_incrementada);
				
				incremento_version=parseFloat(incremento_version)+parseFloat(incremento_version_incrementada);
				incremento_componentes=parseFloat(incremento_componentes)+parseFloat(incremento_componentes_incrementada);
	    		
	    		//DUCHA BAÑERA
	    		/*if($('.ducha_banera').length>0){
	    			var incremento_banera=$('.ducha_banera.activo').attr('data-in');
	    			total=total+total*incremento_banera/100;
	    		}*/
	    		$(contenedor+'.precio-adicional-fijo').html(total.toFixed(2)+' €');
	    		$(contenedor+'#precio-adicional-fijo').val(total);
	    	
    		}
    		
	}
	

	$(document).delegate(contenedor+'.adicionales_atributo_vertical','change',function(){
	
		var id=$(this).attr('data-id');
		var valor=$(this).val();
		
		
		//MUESTRO DECORADOS ASOCIADOS
		$(contenedor+'.decorados_'+id).children().addClass('oculta');
		$(contenedor+'.adicionales_decorado_v_valor_'+valor).removeClass('oculta');
		/*var owl = $(contenedor+'.adicionales_decorado_v_valor_'+valor+' .carousel'); 
		owlResize(owl.owlCarousel(wysiwyg_owloptions));*/
		$(contenedor+'.decorados_'+id+' input[name=adicionales_decorado_v]').prop('checked', false);
		$(contenedor+'.decorados_'+id+' .image_decorado_v').removeClass('border-gray');
	
		combinacion_actualiza_adicionales();
		
	});
	
	$(document).delegate(contenedor+'.adicionales_alto_total','blur',function(){ 
		$(this).next('.mensaje_error_medida_adicional').addClass('hidden');
		var validado=true;

		var valor=$(this).val();
		var max=$(this).attr('data-max'); 
		var min =$(this).attr('data-min');
		var mensaje_error="";
	
		if(max!=0 && parseFloat(valor)>parseFloat(max)){
			validado=false;
			mensaje_error="El valor debe ser menor a "+max;
		}
		if(parseFloat(valor)<parseFloat(min)){
			validado=false;
			mensaje_error=" El valor debe ser mayor a "+min;
		}
		if(validado){
			
			combinacion_actualiza_adicionales();
		}else{
			$(this).next('.mensaje_error_medida_adicional').html(mensaje_error);
			$(this).next('.mensaje_error_medida_adicional').removeClass('hidden');
			$(contenedor+'.precio-adicional-fijo').html('');
			$(contenedor+'#precio-adicional-fijo').val('');
		}
	});

	$(document).delegate(contenedor+'.adicionales_atributo_horizontal','blur',function(){ 
		$(this).next('.mensaje_error_medida_adicional').addClass('hidden');
		var validado=true;
		var max=$(this).attr('data-max');
		var min =$(this).attr('data-min');
		var alto=$(this).val();
		var mensaje_error="";
		if(max!=0 && parseFloat(alto)>parseFloat(max)){
			validado=false;
			mensaje_error="El valor debe ser menor a "+max;
		}
		if(parseFloat(alto)<parseFloat(min)){
			validado=false;
			mensaje_error=" El valor debe ser mayor a "+min;
		}
		if(validado){
			//$('.resumen_ancho').html(alto);
			
			combinacion_actualiza_adicionales();
		}else{
			$(this).next('.mensaje_error_medida_adicional').html(mensaje_error);
			$(this).next('.mensaje_error_medida_adicional').removeClass('hidden');
			$(contenedor+'.precio-adicional-fijo').html('');
			$(contenedor+'#precio-adicional-fijo').val('');
		}
	});
	
	$(document).delegate(contenedor+'.adicionales_valor_componente','click',function(){
		var input=$(this).find('input[type=radio]');
		/*if(input.prop('checked')){
			var id=input.attr('id');
			var name=input.attr('name');
			$('#resumen_'+name+' .resumen_componente_valor').addClass('hidden');
			$('#resumen_'+name+' .resumen_componente_valor').each(function(){ 
				if($(this).attr('data-valor')==id){
					$(this).removeClass('hidden');
				}
			});
		}*/
		
		combinacion_actualiza_adicionales();
	});
	
	$(document).delegate(contenedor+'.formas_adicionales','blur',function(){
		combinacion_actualiza_adicionales();
	})
	$(document).delegate(contenedor+'.adicionales_vidrio_espejo_input','click',function(){
		combinacion_actualiza_adicionales();
	})
	
	$(document).delegate(contenedor+'.muestra_adicionales','click',function(){
		var id=$(this).attr('data-id');
		if($(contenedor+'#adicional'+id).hasClass('oculta')){
			$(contenedor+'#adicional'+id).removeClass('oculta');
		}else{
			$(contenedor+'#adicional'+id).addClass('oculta');
		}

		combinacion_actualiza_adicionales();
	})

	$(document).delegate(contenedor+'input[name=adicionales_version_sel]','change' , function(){
		$(contenedor+'.adicionales_componentes_version').addClass('hidden');
		var id=$(contenedor+'input[name=adicionales_version_sel]:checked').val(); 
		$(contenedor+'.adicionales_componentes_version_'+id).removeClass('hidden');
		
		combinacion_actualiza_adicionales();

	})

	$(document).delegate(contenedor+'.adicionales_valor_decorados input[type=radio]','change',function(){
		var id=$(this).attr('name');
		$(contenedor+'img.image_'+id).removeClass('border-gray');
		if($(this).prop('checked')){
				$(this).prev('img').addClass('border-gray');
			}
	});
	$(document).delegate(contenedor+'.adicionales_valor_componente input[type=radio]','change',function(){
		var id=$(this).attr('name');
		$(contenedor+'img.img_'+id).removeClass('border-gray');
		if($(this).prop('checked')){
				$(this).prev('img').addClass('border-gray');
			}
	});

	$(document).delegate(contenedor+'.adicionales_valor_componente input[type=checkbox]','change',function(){
		var id=$(this).attr('name');
		$(contenedor+'img.img_'+id).removeClass('border-gray');
		if($(this).prop('checked')){
				$(this).prev('img').addClass('border-gray');
			}
	});
	
	$(document).delegate(contenedor+'.add-adicional','click',function(){
		var validado=true;
		if($(contenedor+'.adicionales_alto_total').length>0){
			if($(contenedor+'.adicionales_alto_total').val()=="" || $(contenedor+'.adicionales_alto_total').val()==0){
				$(contenedor+'.adicionales_alto_total').addClass('border-red');
				validado=false;
			}else{
				$(contenedor+'.adicionales_alto_total').removeClass('border-red');
			} 
		}
		if($(contenedor+'.adicionales_ancho_total').length>0){
			if($(contenedor+'.adicionales_ancho_total').val()=="" || $(contenedor+'.adicionales_ancho_total').val()==0){
				$(contenedor+'.adicionales_ancho_total').addClass('border-red');
				validado=false;
			}else{
				$(contenedor+'.adicionales_ancho_total').removeClass('border-red');
			} 
		}
		if($(contenedor+'.adicionales_atributo_vertical').length>0){
			if($(contenedor+'.adicionales_atributo_vertical').val()=="" || $(contenedor+'.adicionales_atributo_vertical').val()==0){
				$(contenedor+'.adicionales_atributo_vertical').addClass('border-red');
				validado=false;
			}else{
				$(contenedor+'.adicionales_atributo_vertical').removeClass('border-red');
				var id_atributo_vertical_valor_a=$(contenedor+'.adicionales_atributo_vertical').val();
				if($(contenedor+'.adicionales_decorado_v_valor_'+id_atributo_vertical_valor_a).length>0){
					if($(contenedor+'.adicionales_decorado_v_valor_'+id_atributo_vertical_valor_a+' input[name=adicionales_decorado_v]').length>0){
							if(!$(contenedor+'.adicionales_decorado_v_valor_'+id_atributo_vertical_valor_a+' input[name=adicionales_decorado_v]:checked').val()){
								validado=false;
								$(contenedor+'.adicionales_decorado_v_valor_'+id_atributo_vertical_valor_a+' .carousel').addClass('border-red');
							}else{
								$(contenedor+'.adicionales_decorado_v_valor_'+id_atributo_vertical_valor_a+' .carousel').removeClass('border-red');
							}
							
					}
				}
			} 
		}
	
		if(validado){
			var vidrio_nuevo="";
			if($(contenedor+'.adicionales_vidrio_espejo_input').length>0){
				if($(contenedor+'.adicionales_vidrio_espejo_input').prop('checked')){
					vidrio_nuevo=1;
				}
			}
			var alto_nuevo=0;
			if($(contenedor+'.adicionales_alto_total').length>0){
				alto_nuevo=$(contenedor+'.adicionales_alto_total').val();
			}
			var ancho_nuevo=0;
			if($(contenedor+'.adicionales_ancho_total').length>0){
				ancho_nuevo=$(contenedor+'.adicionales_ancho_total').val();
			}
			var id_atributo_vertical_a=0;
			if($(contenedor+'.adicionales_atributo_vertical').length>0){
				id_atributo_vertical_a=$(contenedor+'.adicionales_atributo_vertical').attr('data-id');
			}
			var id_atributo_vertical_valor_a=0;
			var atributo_vertical_a="";
			if($(contenedor+'.adicionales_atributo_vertical').length>0){
				id_atributo_vertical_valor_a=$(contenedor+'.adicionales_atributo_vertical').val();
				var valor_hijo=$(this).val().split("-"); 
				if(valor_hijo.length>1){
					id_atributo_vertical_valor_a=valor_hijo[0];
				}
				var valores_attr=$(contenedor+'.adicionales_atributo_vertical').children('option');
				valores_attr.each(function(){
					if($(this).attr('value')==id_atributo_vertical_valor_a){
						atributo_vertical_a=$(this).html();
					}
				})
			}
			var id_decorado_nuevo=0;
			var decorado_nuevo="";
			if(id_atributo_vertical_valor_a!="" && $(contenedor+'.adicionales_decorado_v_valor_'+id_atributo_vertical_valor_a).length>0){
				if($(contenedor+'.adicionales_decorado_v_valor_'+id_atributo_vertical_valor_a+' input[name=adicionales_decorado_v]').length>0){
						decorado_nuevo=$(contenedor+'.adicionales_decorado_v_valor_'+id_atributo_vertical_valor_a+' input[name=adicionales_decorado_v]:checked').attr('data-decorado')+' - '+$(contenedor+'.adicionales_decorado_v_valor_'+id_atributo_vertical_valor_a+' input[name=adicionales_decorado_v]:checked').val();
						id_decorado_nuevo=$(contenedor+'.adicionales_decorado_v_valor_'+id_atributo_vertical_valor_a+' input[name=adicionales_decorado_v]:checked').attr('data-atributo');
				}
			}
			var version =$(contenedor+'input[name=adicionales_version_sel]:checked').val(); 
			var id_componentes_nuevos="";
			var componentes_nuevos="";
			if($(contenedor+'.adicionales_componentes_version_'+version+' .adicionales_componentes').length>0){
				$(contenedor+'.adicionales_componentes_version_'+version+' .adicionales_componentes').each(function(){
					//var input_adicional=$(this).find('input');
					var id_comp=$(this).attr('data-id');
					var name_comp=$(this).attr('data-name');
					var id_comp_valor=$(contenedor+'input[name=adicionales_valor_'+version+'_'+id_comp+']:checked').val();
					var name_comp_valor=$(contenedor+'input[name=adicionales_valor_'+version+'_'+id_comp+']:checked').attr('data-name');
					
					id_componentes_nuevos+=id_comp+'-'+id_comp_valor+',';
					componentes_nuevos +=name_comp+': '+name_comp_valor+',';
				})
			}
			var formas_adicionales=0;
			if($(contenedor+'.formas_adicionales').length>0){
				formas_adicionales=$(contenedor+'.formas_adicionales').val();
			}
			var precio_adicional=0;
			if($(contenedor+'#precio-adicional-fijo').length>0){
				precio_adicional=$(contenedor+'#precio-adicional-fijo').val();
			}
			var num_nuevo=$(contenedor+'#n_adicionales').val();
			if(isNaN(parseInt(num_nuevo))){
				num_nuevo=0;
			}else{
				num_nuevo=parseInt(num_nuevo);
			}
			num_nuevo=num_nuevo+1;
			$(contenedor+'#n_adicionales').val(num_nuevo);
			
			var nuevo='<li class="nuevo_adicional adicional_'+num_nuevo+'" data-vidrio="';
				nuevo +=vidrio_nuevo+'" data-alto="';
				nuevo +=alto_nuevo+'" data-ancho="'
				nuevo +=ancho_nuevo+'" data-id-vertical="';
				nuevo +=id_atributo_vertical_a+'" data-id-attrv="';
				nuevo +=id_atributo_vertical_valor_a+'" data-attrv="';
				nuevo +=atributo_vertical_a+'" data-id-decorado="';
				nuevo +=id_decorado_nuevo+'" data-decorado="';
				nuevo +=decorado_nuevo+'" data-id-componentes="';
				nuevo +=id_componentes_nuevos+'" data-componentes="';
				nuevo +=componentes_nuevos+'" data-formas="';
				nuevo +=formas_adicionales+'" data-precio="';
				nuevo +=precio_adicional+'" data-version="';
				nuevo +=version+'">';
				nuevo +='<b>ADICIONAL '+alto_nuevo+'X'+ancho_nuevo+'</b>';
				nuevo +='<span class="delete delete_adicional pull-right fa fa-trash" data-id="'+num_nuevo+'" data-precio="'+precio_adicional+'"></span>';
				nuevo += '<br>';
				if(vidrio_nuevo!=""){
					nuevo += 'Vidrio Espejo <br>';
				}
				nuevo +=atributo_vertical_a+' '+decorado_nuevo+'<br>';
				nuevo +=componentes_nuevos+'</br>';
				if(formas_adicionales>0){
					nuevo += formas_adicionales+' formas <br>';
				}
				
				nuevo += '<b>PRECIO: '+precio_adicional+' €</li>';
			$(contenedor+'.adicionales_list').prepend(nuevo);
			
			var total_adicionales=$(contenedor+'#total_adicionales').val();
			total_adicionales=parseFloat(total_adicionales)+parseFloat(precio_adicional);
			$(contenedor+'#total_adicionales').val(total_adicionales);
			
		
			if(num_nuevo>0){
				$(contenedor+'.adicionales_resumen').removeClass('hidden');
				$(contenedor+'.n_adicionales_resumen').html(num_nuevo);
			}else{
				$(contenedor+'.adicionales_resumen').addClass('hidden');
			}
			
			combinacion_actualiza();
		}
	});
	$(document).delegate(contenedor+'.delete_adicional','click',function(){
			var id=$(this).attr('data-id');
			$(contenedor+'.adicional_'+id).addClass('hidden');
			
			var precio=$(this).attr('data-precio');
			
			var num_nuevo=$(contenedor+'#n_adicionales').val();
			if(isNaN(parseInt(num_nuevo))){
				num_nuevo=0;
			}else{
				num_nuevo=parseInt(num_nuevo);
			}
			num_nuevo=num_nuevo-1;
			$(contenedor+'#n_adicionales').val(num_nuevo);
			
			var total_adicionales=$(contenedor+'#total_adicionales').val();
			total_adicionales=parseFloat(total_adicionales)-parseFloat(precio);
			$(contenedor+'#total_adicionales').val(total_adicionales);
			
	
			if(num_nuevo>0){
				$(contenedor+'.adicionales_resumen').removeClass('hidden');
				$(contenedor+'.n_adicionales_resumen').html(num_nuevo);
			}else{
				$(contenedor+'.adicionales_resumen').addClass('hidden');
			}
			
			combinacion_actualiza();
	});



	$(document).delegate(contenedor+'.add-modelo','click',function(){ 
		var tiene_formas=false;

		var id_order=$(this).attr('data-order');
		var id_item=$(this).attr('data-item');
		var cont_edit=$(this).attr('data-edit');

		//var id_product=$('.atributo_horizontal').attr('data-id');
		var id_product=$(contenedor+'#id_product_modelo').val();

		$(contenedor+'.mensaje_error_pedido_modelo').html('');
		$(contenedor+'.mensaje_error_pedido_modelo').addClass('hidden');

		var validado=true;
		var mensaje_error="";
		var atributo_horizontal_valor=$(contenedor+'.atributo_horizontal').val();

		//DUCHA o BAÑERA
		var ducha=-1;
		if($(contenedor+'.ducha_banera.activo').length>0){
			ducha=$(contenedor+'.ducha_banera.activo').attr('data-tipo');
		}

		var alto_total=0;

		if($(contenedor+'.alto_total').length>0){
			if($(contenedor+'.alto_total').val()=="" || $(contenedor+'.alto_total').val()==0){
				$(contenedor+'.alto_total').addClass('border-red');
				mensaje_error="<p>Debe indicar el alto total</p>";
				validado=false;
			}else{
				$(contenedor+'.alto_total').removeClass('border-red');
				alto_total=$(contenedor+'.alto_total').val();
				var max_alto=$(contenedor+'.alto_total').attr('data-max'); 
				var min_alto=$(contenedor+'.alto_total').attr('data-min');
			
				if(max_alto!=0 && parseFloat(alto_total)>parseFloat(max_alto)){
					validado=false;
					mensaje_error +="<p>El alto total debe ser menor a "+max_alto+"</p>";
				}
				if(parseFloat(alto_total)<parseFloat(min_alto)){
					validado=false;
					mensaje_error +="<p> El alto total debe ser mayor a "+min_alto+"</p>";
				}


			} 
		}

		var ancho_total=0;
		if($(contenedor+'.ancho_total').length>0){
			if($(contenedor+'.ancho_total').val()=="" || $(contenedor+'.ancho_total').val()==0){
				$(contenedor+'.ancho_total').addClass('border-red');
				if($(contenedor+'.ancho_derecho').length==0 && $(contenedor+'.ancho_izquierdo').length==0){
					mensaje_error="<p>Debe indicar el ancho total</p>";
				}
				
				validado=false;
			}else{
				$(contenedor+'.ancho_total').removeClass('border-red');
				ancho_total=$(contenedor+'.ancho_total').val();
				var max_ancho=$(contenedor+'.ancho_total').attr('data-max'); 
				var min_ancho=$(contenedor+'.ancho_total').attr('data-min');
			
				if(max_ancho!=0 && parseFloat(ancho_total)>parseFloat(max_ancho)){
					validado=false;
					mensaje_error +="<p>El ancho total debe ser menor a "+max_ancho+"</p>";
					$(contenedor+'.ancho_total').val('');
				}
				if(parseFloat(ancho_total)<parseFloat(min_ancho)){
					validado=false;
					mensaje_error +="<p> El ancho total debe ser mayor a "+min_ancho+"</p>";
					$(contenedor+'.ancho_total').val('')
				}
			} 
		}

		var ancho_izquierdo=ancho_derecho=0;
		if($(contenedor+'.ancho_derecho').length>0){
			if($(contenedor+'.ancho_derecho').val()=="" || $(contenedor+'.ancho_drecho').val()==0){
				$(contenedor+'.ancho_derecho').addClass('border-red');
				mensaje_error+="<p>Debe indicar el ancho derecho</p>";
			}else{
				$(contenedor+'.ancho_derecho').removeClass('border-red');
				ancho_derecho=$(contenedor+'.ancho_derecho').val();
			}
		}
		if($(contenedor+'.ancho_izquierdo').length>0){
			if($(contenedor+'.ancho_izquierdo').val()=="" || $(contenedor+'.ancho_izquierdo').val()==0){
				$(contenedor+'.ancho_izquierdo').addClass('border-red');
				mensaje_error+="<p>Debe indicar el ancho izquierdo</p>";
			}else{
				$(contenedor+'.ancho_izquierdo').removeClass('border-red');
				ancho_izquierdo=$(contenedor+'.ancho_izquierdo').val();
			}
		}

		var altura_murete=0;
		if($(contenedor+'.altura_murete').length>0){
			if($(contenedor+'.altura_murete').val()==""){
				$(contenedor+'.altura_murete').addClass('border-red');
				mensaje_error+="<p>Debe indicar la altura del murete</p>";
			}else{
				$(contenedor+'.altura_murete').removeClass('border-red');
				altura_murete=$('.altura_murete').val();
			}
		}

		var ancho_parte_plegable=0;
		if($(contenedor+'.ancho_parte_plegable').length>0){
			if($(contenedor+'.ancho_parte_plegable').val()==""){
				$(contenedor+'.ancho_parte_plegable').addClass('border-red');
				mensaje_error+="<p>Debe indicar el ancho de la parte plegable</p>";
			}else{
				$(contenedor+'.ancho_parte_plegable').removeClass('border-red');
				ancho_parte_plegable=$('.ancho_parte_plegable').val();
			}
		}

		var id_atributo_vertical=0;
		var id_atributo_vertical_valor=0;
		var atributo_vertical="";
		if($(contenedor+'.atributo_vertical').length>0){
			id_atributo_vertical=$(contenedor+'.atributo_vertical').attr('data-id'); 
			id_atributo_vertical_valor=$(contenedor+'.atributo_vertical').val();
			
			var valores_attr=$(contenedor+'.atributo_vertical').children('option');
			valores_attr.each(function(){
				if($(this).attr('value')==id_atributo_vertical_valor){
					atributo_vertical=$(this).html();
				}
			})
		}

		var id_decorado=0;
		var decorado="";
		if(id_atributo_vertical_valor!="" && $(contenedor+'.decorado_v_valor_'+id_atributo_vertical_valor).length>0){
			if($(contenedor+'.decorado_v_valor_'+id_atributo_vertical_valor+' input[name=decorado_v]').length>0){
				if(!$(contenedor+'.decorado_v_valor_'+id_atributo_vertical_valor+' input[name=decorado_v]:checked').val()){
					validado=false;
					$(contenedor+'.decorado_v_valor_'+id_atributo_vertical_valor+' .carousel').addClass('border-red');
					mensaje_error+="<p>Debe seleccionar un decorado</p>";
				}else{
					$(contenedor+'.decorado_v_valor_'+id_atributo_vertical_valor+' .carousel').removeClass('border-red');
					decorado=$(contenedor+'.decorado_v_valor_'+id_atributo_vertical_valor+' input[name=decorado_v]:checked').attr('data-decorado')+' - '+$(contenedor+'.decorado_v_valor_'+id_atributo_vertical_valor+' input[name=decorado_v]:checked').val();
					id_decorado=$(contenedor+'.decorado_v_valor_'+id_atributo_vertical_valor+' input[name=decorado_v]:checked').attr('data-atributo');
				}
					
			}
		}
		var tarifa="";
		$(contenedor+'.valor_componente').each(function(){
			var compo=$(contenedor+'.valor_componente').find('input');
			if(compo.attr(contenedor+'data-tipo-espesor')==1 && compo.is(':checked')){
				tarifa=$(contenedor+'.valor_componente').attr('data-tarifa');
			}
		})

		var paneles=[];
		if($(contenedor+'.paneles').length>0){
			$(contenedor+'.paneles').each(function(){
				var aux={};
				aux['num']=$(this).attr('data-num');
				aux['fijo']=$(this).attr('data-fix');

				aux['nombre_panel']=$(this).attr('data-nombre');
				aux['hueco']=$(this).attr('data-hueco');
				aux['frontal']=$(this).attr('data-frontal');
				aux['plegable']=$(this).attr('data-plegable');
				aux['id']=$(this).attr('data-id');
				aux['espesor']=$(this).attr('data-espesor');
				
				if($(this).has('.vidrio_espejo_input')){
					var espejo=$(this).find('.vidrio_espejo_input');
					if(espejo.prop('checked')){
						aux['espejo']=1;
						
					}else{
						aux['espejo']=0;
					}
				}

				if($(this).has('.recerco_input')){
					var recerco=$(this).find('.recerco_input');
					if(recerco.prop('checked')){
						aux['recerco']=1;
						aux['incremento_recerco']=recerco.attr('data-recerco');
					}else{
						aux['recergo']=0;
						aux['incremento_recerco']=0;
					}
				}

				if($(this).has('.tercera_bisagra_input')){
					var bisagra=$(this).find('.tercera_bisagra_input');
					if(bisagra.prop('checked')){
						aux['tercera_bisagra']=1;
						
					}else{
						aux['tercera_bisagra']=0;
					}
				}

				if($(this).has('.formas_panel')){
					var formas=$(this).find('.formas_panel'); 
					aux['n_formas']=formas.val();
					
					if(aux['n_formas']>0){
						tiene_formas=true;
					}
				}
				/*
				if($(this).has('.espesor_panel')){
					var espesor=$(this).find('.espesor_panel');
					if(espesor.val()=="" || espesor.val()==0){
						validado=false;
						$(this).addClass('border-red');
						espesor.addClass('border-red');
						mensaje_error+="<p>Debe indicar el espesor del Panel "+aux['nombre_panel']+"</p>";	
					}else{
						aux['espesor']=espesor.val();
					}
				}*/
				if($(this).has('.medida_panel')){ 
					var medida=$(this).find('.medida_panel');
					if(medida.val()=="" || medida.val()==0){
						validado=false;
						$(this).addClass('border-red');
						medida.addClass('border-red');
						mensaje_error+="<p>Debe indicar la medida de "+aux['nombre_panel']+"</p>";	
					}else{
						
						aux['medida']=medida.val();
						var max_medida=parseFloat(medida.attr('data-max'));
						var min_medida =parseFloat(medida.attr('data-min'));
						var max_fix=parseFloat(medida.attr('data-max-fix'));
						var min_fix =parseFloat(medida.attr('data-min-fix'));
						
						var ancho_total=parseFloat($(contenedor+'.ancho_total').val());
						var fijo_medida=parseFloat(medida.attr('data-fix'));
				
						
						if(fijo_medida==1){
							if(max_fix!=0 && aux['medida']>max_fix){
								validado=false;
								mensaje_error +="<p>La medida de "+aux['nombre_panel']+"  debe ser menor a "+max_fix+"</p>";
							}
							if(aux['medida']<min_fix){
								validado=false;
								mensaje_error="<p>La medida de "+aux['nombre_panel']+" debe ser mayor a "+min_fix+"</p>";
							}
						}else{
							if(max_medida!=0 && aux['medida']>max_medida){
								validado=false;
								mensaje_error +="<p>La medida de "+aux['nombre_panel']+" debe ser menor a "+max_medida+"</p>";
							}
							if(aux['medida']<min_medida){
								validado=false;
								mensaje_error +="<p>La medida de "+aux['nombre_panel']+" debe ser mayor a "+min_medida+"</p>";
							}
						}
						
						if(aux['medida']>ancho_total){
							validado=false;
							mensaje_error +="<p>La medida de "+aux['nombre_panel']+" no puede ser superior a "+ancho_total+"</p>";
						}

						if(validado){
							$(this).removeClass('border-red');
							medida.removeClass('border-red');

							paneles.push(aux);
							
						}else{
							$(this).addClass('border-red');
							medida.addClass('border-red');
						}
					}
					
					
				} 
			})
		}
		

		var paneles_adicionales=[];
		if($(contenedor+'.adicionales_list').length>0 && $(contenedor+'.adicionales_list').has('li')){
			$(contenedor+'.adicionales_list').find('li').each(function(){
				if(!$(this).hasClass('hidden')){
					var aux={};
					aux['id_product_adicional']=$(contenedor+'.adicionales_atributo_horizontal').attr('data-id');
					aux['version']=$(this).attr('data-version');
					aux['vidrio']=$(this).attr('data-vidrio');
					aux['alto']=$(this).attr('data-alto');
					aux['ancho']=$(this).attr('data-ancho');
					aux['id_atributo_vertical']=$(this).attr('data-id-vertical')
					aux['id_atributo_vertical_valor']=$(this).attr('data-id-attrv');
					aux['atributo_vertical']=$(this).attr('data-attrv');
					aux['id_decorado']=$(this).attr('data-id-decorado');
					aux['decorado']=$(this).attr('data-decorado');
					aux['id_componentes']=$(this).attr('data-id-componentes');
					aux['componentes']=$(this).attr('data-componentes');
					aux['formas']=$(this).attr('data-formas');
					aux['precio']=$(this).attr('data-precio');

					paneles_adicionales.push(aux);
				}
			})
		}
		var version=$(contenedor+'input[name=version_sel]:checked').val();
		var componentes=[];
		if($(contenedor+'.componentes_version_'+version+' .componentes-art').length>0){
			$(contenedor+'.componentes_version_'+version+' .componentes-art').each(function(){
				$(this).removeClass('border-red');
				var aux={};
				aux['id']=$(this).attr('data-id');
				aux['nombre']=$(this).attr('data-name');  

				var val=$(contenedor+'input[name=valor_'+version+'_'+aux['id']+']:checked'); 
				if(val.val()!="" && val.val()!=0 && val.val()!=undefined){
					aux['id_valor']=val.val();
					aux['nombre_valor']=val.attr('data-name'); 
					aux['color']="";
					if(val.attr('data-color')==1 && $(contenedor+'.color_ral_'+val.val()).length>0){
						aux['color']=$(contenedor+'.color_ral_'+val.val()).val();
					}
					componentes.push(aux);
				}else{
					if($(contenedor+'input[name=valor_'+version+'_'+aux['id']+']').attr('type')=='radio'){
						validado=false;
						mensaje_error +="<p>Seleccione una opción para el componente: "+aux['nombre']+"</p>";
						$(this).addClass('border-red');
					}
				}
			})
		}

		var preguntas=[];
		if($(contenedor+'.preguntas-list').length>0){
			$(contenedor+'.preguntas-list').each(function(){

				aux={};
				aux['id']=$(this).attr('data-id');
				aux['respuesta']=$(contenedor+'#respuesta_'+aux['id']).val();
				if(aux['respuesta']!="" ){
					$(contenedor+'#respuesta_'+aux['id']).removeClass('border-red');
					preguntas.push(aux);
				}else{
					validado=false;
					$(contenedor+'#respuesta_'+aux['id']).addClass('border-red');
				}


			})

			if(!validado){
				mensaje_error +="<p>Tiene preguntas importantes sin responder</p>";
			}
		}
		
		var url_croquis="";
		if($(contenedor+'#url_croquis').length>0 && tiene_formas){
			url_croquis=$(contenedor+'#url_croquis').val();

			if(tiene_formas && (url_croquis==" " || url_croquis=="")){
				validado=false;
				mensaje_error +="<p>Debe aportar croquis de las formas</p>";
			}
		}
		if(validado){ 
			var precios=combinacion_actualiza(true);

			var type = 'POST';
			/*if(id_order !="" && id_item!="")
			{
				var url = site_url + '/home/edit_modelo_pedido';
			}else{*/
				var url = site_url + '/home/add_modelo_carrito';
			//}
			
			var data = {
				'num':$('#num_items').val(),
				'id_producto': id_product,
				'ducha': ducha,
				'alto_total': alto_total,
				'ancho_total': ancho_total,
				'ancho_izquierdo': ancho_izquierdo,

				'altura_murete': altura_murete,
				'ancho_parte_plegable':ancho_parte_plegable,

				'ancho_derecho': ancho_derecho,
				'atributo_horizontal_valor':atributo_horizontal_valor,
				'id_atributo_vertical': id_atributo_vertical,
				'id_atributo_vertical_valor': id_atributo_vertical_valor,
				'atributo_vertical': atributo_vertical,
				'id_decorado': id_decorado,
				'decorado': decorado,
				'paneles':paneles,
				'paneles_adicionales': paneles_adicionales,
				'componentes': componentes,
				'preguntas': preguntas,
				'precio_web': precios,
				'tarifa':tarifa,
				'version':version,
				'url_croquis':url_croquis,

				'id_order':id_order,
				'id_item':id_item,

				'cont_edit':cont_edit
			}

				var result = ActionAjax(type, url, data, null, null, true);
//console.log(result);
				if(result){
					json=JSON.parse(result);
					if(json[0]!=""){
						$('.contenedor_lineas_pedido').append(json[0]);
						$('.contenedor_lineas_pedido_2').append(json[1]);
						//carga_calculadora();
						
						num=parseInt(num)+1;
						$('#num_items').val(num);
						//for(var i=1;i<=num;i++){
							$("#observaciones_nuevo_"+num).redactor({
								plugins: ['source','fontfamily','fontcolor','alignment','textdirection','filemanager','imagemanager','table','clips'],
								focus: true,
								lang: 'es',
								imageUpload: '<?php echo base_url()?>assets_back_office/js/plugins/redactor/upload.php',
							imageResizable: true,
								imagePosition: true,
								imageManagerJson: '<?php echo base_url()?>assets_back_office/js/plugins/redactor/images/images.json',
							fileUpload: '<?php echo base_url()?>assets_back_office/js/plugins/redactor/file-upload.php',
							fileManagerJson: 'files/files.json',
							})
						//}

						$('#modelos_sel').val('');
						$('#modelos_sel').selectpicker('refresh');
						$('.contenedor_configurador_modelo').html('<div class="alert alert-success">El modelo se ha añadido con éxito al pedido</div>');
						ajusta_totales(true);
					}else if(json[2]){
						$('#atributo_producto_'+cont_edit).html(json[2][0]);
						$('#combinacion_valor_'+cont_edit).val(json[2][0]);
						$('#cod_producto_'+cont_edit).val(json[2][1]);
						$('#atributo_vertical_'+cont_edit).val(json[2][2]);
						$('#atributo_vertical_valor_'+cont_edit).val(json[2][3]);
						$('#atributo_horizontal_'+cont_edit).val(json[2][5]);
						$('#atributo_horizontal_valor_'+cont_edit).val(json[2][6]);

						$('#valor_precio_'+cont_edit).html(json[2][7]);
						$('#precio_'+cont_edit).val(json[2][8]);

						$('.contenedor_configurador_modelo').html('<div class="alert alert-success">La línea se ha editado con éxito</div>');

						$('.edita-mampara').each(function(){
							if($(this).attr('data-row')==cont_edit){
								$(this).attr('data-item',json[2][9]);
							}
						})
						ajusta_totales(true);
					}
				}
		}else{ 
			$(contenedor+'.mensaje_error_pedido_modelo').html(mensaje_error);
			$(contenedor+'.mensaje_error_pedido_modelo').removeClass('hidden');
		}
	});

	$(document).delegate('.edita-mampara','click',function(){ 
		var cont=$(this).attr('data-row');
		var item=$(this).attr('data-item');
		var text = '';
		var type = 'POST';
		var url = site_url + '/home/carga_configurador_modelo_edit_ajax';
	
		var data={'cont':cont,
				'id_item':item
				};
		var result = ActionAjax(type, url, data, null, text, true); 
		//console.log(result);
		if(result){
			var json=JSON.parse(result);
			$('.contenedor_configurador_modelo').html(json[0]);
			$('.nav-tabs a[href="#lineas_modelo"]').tab('show');
			inicializa_modelo();
			combinacion_actualiza();
		}else{
			$('.contenedor_configurador_modelo').html('<div class="alert alert-danger">Debe guardar el pedido para poder modificar esta línea</div>');
			$('.nav-tabs a[href="#lineas_modelo"]').tab('show');
		}

	})

