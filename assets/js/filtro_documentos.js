$('#grupos').on('change',function(){
    var grupo=$(this).val(); 
    $('.filtro_entidades').addClass('hidden');
    if(grupo){ 
        var text = "";
        var type = 'POST';
        var url = site_url + '/docs_documentos/get_tipos_ajax';
        var data = {
            'grupo':grupo
        };

        result=ActionAjax(type, url, data, null, text, true,false);
      
        var json=JSON.parse(result);
        if(json[0]){
            $('#tipos').html(json[0]);
            $('#tipos').selectpicker('refresh');
        }
    }
})
$('#tipos').on('change',function(){
    $('.filtro_entidades').addClass('hidden');
    var tipo=$(this).val();
    if(tipo){
        var text = "";
        var type = 'POST';
        var url = site_url + '/docs_documentos/get_entidades_ajax';
        var data = {
            'tipo':tipo
        };

        result=ActionAjax(type, url, data, null, text, true,false);
      
        var json=JSON.parse(result);
        for(var i=0;i<json.length;i++){
            $('.filtro_entidad_'+json[i]).removeClass('hidden');
        }
    }
});
    $('.muestra_tipos').on('click',function(e){  
        e.preventDefault();
        $('.nuevo_tipos').toggleClass('hidden');
    })
    $(document).delegate('.edit-active','click',function(){
     var contenedor=$(this).parent();
     $(this).addClass('hidden');
     var form_class=$(this).attr('data-form');
     var form=$('#'+form_class);
     contenedor.find('.save-active').removeClass('hidden');
     contenedor.find('.cancel-active').removeClass('hidden');
     form.find('input').prop('disabled',false);
     form.find('select').prop('disabled',false);
     form.find('select').selectpicker('refresh');
     form.find('textarea').prop('disabled',false);

     form.find('.contenedor-metadatos').removeClass('hidden');
     form.find('.componente_form').removeClass('hidden');

     form.find('.contenido_oculto').removeClass('tapa_contenido');
     form.find('.contenido_muestra').addClass('hidden');

    var otros=$(this).attr('data-otros');
     if(otros){
         $('.'+otros).removeClass('hidden');
     }
 });