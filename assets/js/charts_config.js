var myLine = null;
var datas;

function saleCanvas(){
	
	if(myLine != null){
		myLine.destroy();
	}
	
	datas = {
	    labels: dates,
	    datasets: [
	        {
	            label: "Pedidos por Mes",
	            fillColor: "rgba(92, 184, 92, 0.2)",
	            strokeColor: "rgba(92, 184, 92, 1)",
	            pointColor: "rgba(92, 184, 92, 1)",
	            pointStrokeColor: "#fff",
	            pointHighlightFill: "#fff",
	            pointHighlightStroke: "rgba(92, 184, 92, 1)",
	            data: sales
	        }
	    ]
	};
	
	var ctx = document.getElementById("sales-canvas").getContext("2d");
	myLine = new Chart(ctx).Line(datas, {
		responsive: false,
		tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %> €",
		scaleLabel: "<%=value%> €"
	});
	
	return myLine;
}

myLine = window.saleCanvas();

