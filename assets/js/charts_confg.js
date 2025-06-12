var data = {
    labels: dates,
    datasets: [
        
        {
            label: "My Second dataset",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: sales
        }
    ]
};

window.onload = function(){
		var ctx = document.getElementById("sales-canvas").getContext("2d");
		window.myLine = new Chart(ctx).Line(data, {
			responsive: false,
			tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>€",
			scaleLabel: "<%=value%>€"
		});
}

