$('.ajusta_fecha').on('click',function(){
    var contenedor=$(this).parent().parent().parent();
    contenedor.find('#select_mes').parent().removeClass('border-red');
    contenedor.find('#select_anio').parent().removeClass('border-red');
    var valor=$('.ajusta_fecha:checked').val();
    var d=new Date(); 
    if(valor==1){//HOY
        contenedor.find('#select_mes').val();
        contenedor.find('#select_anio').val(d.getFullYear());
        contenedor.find('#select_anio').selectpicker('refresh');
        contenedor.find('.fecha_desde').val(d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear());
        contenedor.find('.fecha_hasta').val(d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear());
    }
    if(valor==2){//SEMANA
        contenedor.find('#select_mes').val();
        contenedor.find('#select_anio').val(d.getFullYear());
        var dia_semana=d.getDay(d.getFullYear(),d.getMonth()-1,d.getDate());
        if(dia_semana==0){ dia_semana=7;}
        var d7=new Date(d.getFullYear(),d.getMonth(),d.getDate()-(dia_semana-1));
         
        contenedor.find('.fecha_desde').val(d7.getDate()+'-'+(d7.getMonth()+1)+'-'+d7.getFullYear());
        contenedor.find('.fecha_hasta').val(d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear());
        
    }
    if(valor==3){//MES
        var mes=contenedor.find('#select_mes').val(); 
        var anio=contenedor.find('#select_anio').val();
        if(mes==""){
            contenedor.find('#select_mes').parent().addClass('border-red');
        }else{
            //var d30=new Date(d.getFullYear(),mes-1,d.getDate());
            var ultimo=new Date(anio,mes,0);
            var ultimo_dia=ultimo.getDate();
            contenedor.find('.fecha_desde').val('01'+'-'+mes+'-'+anio);
            contenedor.find('.fecha_hasta').val(ultimo_dia+'-'+mes+'-'+anio);    
        }
        
    }
    if(valor==4){//ULT MES
        contenedor.find('#select_mes').val(); 
        contenedor.find('#select_anio').val(d.getFullYear());
        contenedor.find('#select_anio').selectpicker('refresh');
        var mes=d.getMonth();
        var d30=new Date(d.getFullYear(),d.getMonth(),1);
         
        contenedor.find('.fecha_desde').val(d30.getDate()+'-'+(d30.getMonth()+1)+'-'+d30.getFullYear());
        contenedor.find('.fecha_hasta').val(d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear());
    }
    if(valor==5){//AÑO
        var anio=contenedor.find('#select_anio').val();
        contenedor.find('#select_mes').val();
        if(anio==""){
            contenedor.find('#select_anio').parent().addClass('border-red');
        }else{
            
            contenedor.find('.fecha_desde').val('01-01-'+anio);
            contenedor.find('.fecha_hasta').val('01-12-'+anio);
        }
    }
    if(valor==6){//TODO 
    	
        contenedor.find('#select_mes').val();
        contenedor.find('#select_anio').val(d.getFullYear());
        contenedor.find('.fecha_desde').val('');
        contenedor.find('.fecha_hasta').val('');
    }
})
$('#select_mes').on('change',function(){
    var contenedor=$(this).parent().parent().parent();
    contenedor.find('#fecha_mes').prop('checked',true);
    var mes=$(this).val();
    var anio=contenedor.find('#select_anio').val();
    var ultimo=new Date(anio,mes,0);
    var ultimo_dia=ultimo.getDate();
    contenedor.find('.fecha_desde').val('01'+'-'+mes+'-'+anio);
    contenedor.find('.fecha_hasta').val(ultimo_dia+'-'+mes+'-'+anio); 
})
$('#select_anio').on('change',function(){
    var contenedor=$(this).parent().parent().parent();
    var anio=$(this).val();
    var mes=contenedor.find('#select_mes').val();
    if(mes==""){
        contenedor.find('#fecha_anio').prop('checked',true);
        contenedor.find('.fecha_desde').val('01-01-'+anio);
        contenedor.find('.fecha_hasta').val('01-12-'+anio);

    }else{
        contenedor.find('#fecha_mes').prop('checked',true);
        var ultimo=new Date(anio,mes,0);
        var ultimo_dia=ultimo.getDate();
        contenedor.find('.fecha_desde').val('01'+'-'+mes+'-'+anio);
        contenedor.find('.fecha_hasta').val(ultimo_dia+'-'+mes+'-'+anio); 
    }
    
})