$(function($){
	    // $.fn.datepicker.dates['es'] = {
	        // closeText: 'Cerrar',
	        // prevText: '<Ant',
	        // nextText: 'Sig>',
	        // currentText: 'Hoy',
	        // monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	        // monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	        // dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	        // dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	        // dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	        // weekHeader: 'Sm',
	        // dateFormat: 'dd/mm/yy',
	        // firstDay: 1,
	        // isRTL: false,
	        // showMonthAfterYear: false,
	        // yearSuffix: ''
	    // };
	    // $.datepicker.setDefaults($.datepicker.regional['es']);
	    $.fn.datepicker.dates['en'] = {
		    days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		    daysShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		    daysMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		    monthsShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic']
		};
	});