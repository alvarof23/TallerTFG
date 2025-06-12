function formatea(n, c, d, t)
	{
		var c = isNaN(c = Math.abs(c)) ? 2 : c,
		d = d == undefined ? "." : d,
		t = t == undefined ? "," : t,
		s = n < 0 ? "-" : "",
		i = String(parseInt(n = Math.abs(Number(n) || 0))),
		j = (j = i.length) > 3 ? j % 3 : 0;

		return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	}
function formatNumber(number, decPlaces, decSep, thouSep) {
   number= isNaN(parseFloat(number)) ? 0 : parseFloat(number);
    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
    decSep = typeof decSep === "undefined" ? "." : decSep;
    thouSep = typeof thouSep === "undefined" ? "," : thouSep;
    var sign = number < 0 ? "-" : "";
    var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
    var j = (j = i.length) > 3 ? j % 3 : 0;
 
    return sign +
        (j ? i.substr(0, j) + thouSep : "") +
        i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
        (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
}
function converNumber(number){
    if(number!=""){
        number= number.toString().replace(/\./g,'');
        number= number.replace(/,/g,'.');
        number=isNaN(parseFloat(number)) ? 0 : parseFloat(number);
    }else{
        number=0;
    }
    return number;
}

$(document).delegate('.number_format','input blur',function(){
    var num=converNumber($(this).val());
    var id=$(this).attr('data-num');
    $('#'+id).val(num);
})