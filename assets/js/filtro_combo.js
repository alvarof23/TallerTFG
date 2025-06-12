
 function busca_datos_tabla(){
    $('#campos_busqueda').html();
    var id_campo=$('#id_campo_search').val();
    var tabla=$('#tabla_search').val();
    var filtro=$('#filtro_search').val();
    var id_ref=$('#id_ref_search').val();
    var valor_ref=$('#valor_ref_search').val();
    var tabla_ref=$('#tabla_ref_search').val();
    var busco=$('#busca_dato').val();
    var desde="";
    if($('#fecha_inicio').length>0){
        desde=$('#fecha_inicio').val();
    }
    var hasta="";
    if($('#fecha_fin').length>0){
        hasta=$('#fecha_fin').val();
    }
   if(id_ref==0 || valor_ref!=""){
        var text = "";
        var type = 'POST';
        var url = site_url + '/docs_documentos/carga_datos_combo_ajax';
        var data = {
            'id_campo':id_campo,
            'tabla':tabla,
            'filtro':filtro,
            'id_ref':id_ref,
            'valor_ref':valor_ref,
            'tabla_ref':tabla_ref,
            'busco':busco,
            'desde':desde,
            'hasta':hasta
        };

        result=ActionAjax(type, url, data, null, text, true,false);

        var json=JSON.parse(result);
        if(json[0]){
            $('#datos_list').html(json[0]);
           
        }else{
            $('#datos_list').html('<div class="alert alert-warning">No se han encontrado resultados asociados a la búsqueda</div>');
        }

    }
}
$('.campo_combo').on('click',function(){ 
    $(this).removeClass('fa-search');
    $(this).addClass('fa-spinner fa-spin');
    $('#modal_combo .fecha').addClass('hidden');

    $('#titulo_combo_search').html('');
    $('#id_campo_search').val(0);
    $('#tabla_search').val('');
    $('#filtro_search').val('');
    $('#id_ref_seach').val(0);
    $('#tabla_ref_search').val('');
    $('#valor_ref_search').val('');
    $('#busca_dato').val('');
    $('#datos_list').html('');
    $('#campos_busqueda').html('');

    var id_campo=$(this).attr('data-id');
    $('.mensaje_error_combo_'+id_campo).addClass('hidden');
    var tabla=$('#tabla_campo_'+id_campo).val();
    var campos_busqueda=$('#campos_busqueda_'+id_campo).val();
    var filtro=$('#filtro_campo_'+id_campo).val();
    var id_ref=$(this).attr('data-ref');
    var valor_ref="";
    var tabla_ref="";
	if(id_ref!=0){
        valor_ref=$('#campo_'+id_ref).val();
        tabla_ref=$('#tabla_campo_'+id_ref).val();
    }
    var etiqueta=$('#label_combo_'+id_campo).html();
    var etiqueta_ref=$('#label_combo_'+id_ref).html(); 
   
    var fecha=$(this).attr('data-fecha');
    if(fecha==1){
        $('#modal_combo .fecha').removeClass('hidden');
    }
   if(id_ref==0 || valor_ref!=""){ 
        $('#titulo_combo_search').html(etiqueta);
        $('#id_campo_search').val(id_campo);
        $('#tabla_search').val(tabla);
        $('#filtro_search').val(filtro);
        $('#id_ref_seach').val(id_ref);
        $('#tabla_ref_search').val(tabla_ref);
        $('#valor_ref_search').val(valor_ref);
        $('#campos_busqueda').html('Campos de búsqueda: '+campos_busqueda);
       // if(valor_ref!=""){
        busca_datos_tabla();
        //}
        $(this).removeClass('fa-spinner fa-spin');
        $(this).addClass('fa-search');
        $("#modal_combo").modal('show');
    }else{
       $('.mensaje_error_combo_'+id_campo).html('Debe indicar primero un '+etiqueta_ref); 
       $('.mensaje_error_combo_'+id_campo).removeClass('hidden');
    }
})
$(document).delegate('.dato_sel','click',function(){
    var dato_id=$(this).find('.dato_id').val();
    var dato_valor=$(this).find('.dato_valor').val(); 
    var id_campo=$('#id_campo_search').val();
    $('#campo_valor_'+id_campo).val(dato_valor);
    $('.campo_'+id_campo+'_combo').html(dato_valor);
    $('#campo_'+id_campo).val(dato_id);
    $('.edita_tabla_'+id_campo).attr('data-id',dato_id);

    $("#modal_combo").modal('hide');
})
$('.campo_search_combo').on('click',function(){
   // var busco=$('#busca_dato').val();
    //if(busco!=""){
        busca_datos_tabla();
    //}
  
})
$('.limpa_combo').on('click',function(){
    var id=$(this).attr('data-id');
    var tabla=$(this).attr('data-tabla');
    
    $('#campo_'+id).val('');
    $('#campo_'+id+'_combo').html('');
    $('.edita_tabla_'+id).attr('data-id',0);
    if(tabla == 'oportunidades'){
        $('.modal_ofertas').attr('data-id-oportunidad','')
    }else if(tabla == 'clientes'){
        $('.modal_oportunidades').attr('data-id-cliente','');
        $('.modal_ofertas').attr('data-id-cliente','');
    }
    
})
$('.edita_tabla').on('click',function(){
    var tabla=$(this).attr('data-tabla');
    var id=$(this).attr('data-id');
    var campo=$(this).attr('data-campo');
    $('.mensaje_error_combo_'+campo).html('');
    $('.mensaje_error_combo_'+campo).addClass('hidden');
    var text = "";
    var type = 'POST';
    var url = site_url + '/docs_documentos/redirige_crear_tabla_ajax';
    var data = {
        'id_tabla':tabla,
        'id':id,
    };

    result=ActionAjax(type, url, data, null, text, true,false); 

    var json=JSON.parse(result);
    if(json[0]!=""){
        $('.mensaje_error_combo_'+campo).html(json[0]);
        $('.mensaje_error_combo_'+campo).removeClass('hidden');
    }else{
        window.open(json[1], '_blank');
    }

})