$(document).delegate('.id_grupo1','change',function(){
    var g=$(this).val();
    var c=$(this).closest('.grupos-cliente');
    var sel=c.find('.id_grupo2');
    var sel_id=sel.attr('id');

    var text = "";
    var type = 'POST';
    var url = site_url + '/home/get_subgrupos_ajax';
    var data = {
        'id_grupo':g,
    };

    result=ActionAjax(type, url, data, null, text, true,false);

    if(result){
        json=JSON.parse(result);
        $('#'+sel_id).html(json[0]);
        $('#'+sel_id).selectpicker('refresh');
    }
   
})

$('.add_grupo_v').on('click',function(){
    var tipo=$(this).attr('data-tipo');
    var id=$(this).attr('data-page');
    var n=0;
    if(tipo=="bloque"){
        n=$(this).attr('data');
    }
   
    var c=$(this).closest('.grupos-cliente');
    var s=c.find('.id_grupo1').val();
    var s2=c.find('.id_grupo2').val();
    if(s && s!=""){
        var text = "";
        var type = 'POST';
        var url = site_url + '/home/set_grupo_visible_ajax';
        var data = {
            'id':id,
            'n':n,
            'id_grupo':s,
            'id_grupo2':s2,
            'tipo':tipo
        };

        result=ActionAjax(type, url, data, null, text, true,false);
        
        if(result){
            json=JSON.parse(result);
            c.find('.grupos_visible').html(json[0]);
        }
    }
})

$(document).delegate('.remove_gcli','click',function(){
    var id=$(this).attr('data');
    var n=$(this).attr('data-num');
    var p=$(this).attr('data-campo');
    var tipo=$(this).attr('data-tipo');
    var c=$(this).closest('.grupos-cliente');
    var text = "";
        var type = 'POST';
        var url = site_url + '/home/delete_grupo_visible_ajax';
        var data = {
            'id':id,
            'n':n,
            'p':p,
            'tipo':tipo
        };

        result=ActionAjax(type, url, data, null, text, true,false);
       console.log(result);
        if(result){
            json=JSON.parse(result);
            c.find('.grupos_visible').html(json[0]);
        }
})

$('.add_grupo_ex').on('click',function(){
    var tipo=$(this).attr('data-tipo');
    var id=$(this).attr('data-page');
    var n=0;
    if(tipo=="bloque"){
        n=$(this).attr('data');
    }
    var c=$(this).closest('.grupos-cliente');
    var s=c.find('.id_grupo1').val();
    var s2=c.find('.id_grupo2').val();
    if(s && s!=""){
        var text = "";
        var type = 'POST';
        var url = site_url + '/home/set_grupo_excluido_ajax';
        var data = {
            'id':id,
            'n':n,
            'id_grupo':s,
            'id_grupo2':s2,
            'tipo':tipo
        };

        result=ActionAjax(type, url, data, null, text, true,false);
        if(result){
            json=JSON.parse(result);
            c.find('.grupos_excluido').html(json[0]);
        }
    }
})

$(document).delegate('.remove_gcli_ex','click',function(){
    var id=$(this).attr('data');
    var n=$(this).attr('data-num');
    var p=$(this).attr('data-campo');
    var tipo=$(this).attr('data-tipo');
    var c=$(this).closest('.grupos-cliente');
    var text = "";
        var type = 'POST';
        var url = site_url + '/home/delete_grupo_excluido_ajax';
        var data = {
            'id':id,
            'n':n,
            'p':p,
            'tipo':tipo
        };

        result=ActionAjax(type, url, data, null, text, true,false);
        if(result){
            json=JSON.parse(result);
            c.find('.grupos_excluido').html(json[0]);
        }
})
