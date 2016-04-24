	/* Charts */
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
	
	var ctxLC = document.getElementById("lineChart").getContext("2d");
	var ctxBC = document.getElementById("barChart").getContext("2d");
	var ctxRC = document.getElementById("radarChart").getContext("2d");
	var ctxPAC = document.getElementById("polarAreaChart").getContext("2d");
	var ctxDC = document.getElementById("doughnutChart").getContext("2d");
	var ctxPC = document.getElementById("pieChart").getContext("2d");
	
	var dataLC = {
    labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
    datasets: [
        {
        	title:"Graphic Design",
            label: "My First dataset",
            fillColor: "rgba(0,204,204,0.2)",
            strokeColor: "rgba(0,204,204,1)",
            pointColor: "rgba(0,204,204,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(0,204,204,1)",
            data: [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        },
        {
            title:"Web Design",
            label: "My Second dataset",
            fillColor: "rgba(255,153,153,0.2)",
            strokeColor: "rgba(255,153,153,1)",
            pointColor: "rgba(255,153,153,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(255,153,153,1)",
            data: [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        },
        {
        	title:"Development",
            label: "My Third dataset",
            fillColor: "rgba(153,204,255,0.2)",
            strokeColor: "rgba(153,204,255,1)",
            pointColor: "rgba(153,204,255,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(153,204,255,1)",
            data: [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        }
    ]
};
	
	var dataBC = {
    labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
    datasets: [
        {
        	title:"Graphic Design",
            label: "My First dataset",
            fillColor: "rgba(0,204,204,0.2)",
            strokeColor: "rgba(0,204,204,1)",
            highlightFill: "rgba(0,204,204,0.75)",
            highlightStroke: "rgba(0,204,204,1)",
            data: [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        },
        {
            title:"Web Design",
            label: "My Second dataset",
            fillColor: "rgba(255,153,153,0.2)",
            strokeColor: "rgba(255,153,153,1)",
            highlightFill: "rgba(255,153,153,0.75)",
            highlightStroke: "rgba(255,153,153,1)",
            data: [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        },
        {
        	title:"Development",
            label: "My Third dataset",
            fillColor: "rgba(153,204,255,0.2)",
            strokeColor: "rgba(153,204,255,1)",
            highlightFill: "rgba(153,204,255,0.75)",
            highlightStroke: "rgba(153,204,255,1)",
            data: [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        }
    ]
};

	var dataRC = {
    labels: ["Creativity","Graphic Design","Web Design","Development","Consulting"],
    datasets: [
        {
        	label: "My First dataset",
            fillColor: "rgba(0,204,204,0.2)",
            strokeColor: "rgba(0,204,204,1)",
            pointColor: "rgba(0,204,204,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(0,204,204,1)",
            data: [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        },
        {
        	label: "My Second dataset",
            fillColor: "rgba(255,153,153,0.2)",
            strokeColor: "rgba(255,153,153,1)",
            pointColor: "rgba(255,153,153,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(255,153,153,1)",
            data: [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        },
        {
        	label: "My Third dataset",
            fillColor: "rgba(153,204,255,0.2)",
            strokeColor: "rgba(153,204,255,1)",
            pointColor: "rgba(153,204,255,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(153,204,255,1)",
            data: [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        }
    ]
};

	var dataPAC = [
    {
        value: randomScalingFactor(),
        color:"#00cccc",
        highlight: "#00cccc",
        label: "Creativity",
        title:"Creativity"
    },
    {
        value: randomScalingFactor(),
        color: "#ff9999",
        highlight: "#ff9999",
        label: "Graphic Design",
        title:"Graphic Design"
    },
    {
        value: randomScalingFactor(),
        color: "#ccff99",
        highlight: "#ccff99",
        label: "Web Design",
        title:"Web Design"
    },
    {
        value: randomScalingFactor(),
        color: "#99ccff",
        highlight: "#99ccff",
        label: "Development",
        title:"Development"
    },
    {
        value: randomScalingFactor(),
        color: "#ffcc99",
        highlight: "#ffcc99",
        label: "Consulting",
        title:"Consulting"
    }

];
	
	var dataDC = [
    {
        value: 15,
        color:"#00cccc",
        highlight: "#00cccc",
        label: "Creativity",
        title:"Creativity"
    },
    {
        value: 20,
        color: "#ff9999",
        highlight: "#ff9999",
        label: "Graphic Design",
        title:"Graphic Design"
    },
    {
        value: 30,
        color: "#ccff99",
        highlight: "#ccff99",
        label: "Web Design",
        title:"Web Design"
    },
    {
        value: 15,
        color: "#99ccff",
        highlight: "#99ccff",
        label: "Development",
        title:"Development"
    },
    {
        value: 20,
        color: "#ffcc99",
        highlight: "#ffcc99",
        label: "Consulting",
        title:"Consulting"
    }

];
	var optionsLC={
		responsive : true,
		maintainAspectRatio: true,
		scaleLineColor: "rgba(255,255,255,1)",
		scaleShowGridLines : false,
		scaleGridLineColor : "rgba(255,255,255,1)",
		scaleFontColor: "#fff",
		showTooltips: true
	}
	
	var myLineChart;
	legend(document.getElementById("lineLegend"), dataLC);
	
	var optionsBC={
		responsive : true,
		maintainAspectRatio: true,
		scaleLineColor: "rgba(255,255,255,1)",
		scaleShowGridLines : false,
		scaleGridLineColor : "rgba(255,255,255,1)",
		scaleFontColor: "#fff"
	}
	
	var myBarChart; 
	legend(document.getElementById("barLegend"), dataBC); 
	
	var optionsRC={
		responsive : true,
		maintainAspectRatio: true,
		scaleLineColor: "rgba(255,255,255,1)",
		scaleShowGridLines : false,
		scaleGridLineColor : "rgba(255,255,255,1)",
		scaleFontColor: "#fff",
		angleLineColor : "rgba(255,255,255,1)",
		pointLabelFontColor : "#fff",
		pointLabelFontSize : 12
	}
	var myRadarChart;
	
	var optionsPAC={
		responsive : true,
		maintainAspectRatio: true,
		scaleLineColor: "rgba(255,255,255,1)",
		scaleShowGridLines : false,
		scaleGridLineColor : "rgba(255,255,255,1)",
		scaleFontColor: "#333",
		scaleBackdropColor : "rgba(255,255,255,0.75)",
	}
	var myPolarAreaChart; 
	legend(document.getElementById("polarAreaLegend"), dataPAC);
	
	var optionsDC={
		responsive : true,
		maintainAspectRatio: true
	}
	var myDoughnutChart;
	legend(document.getElementById("doughnutLegend"), dataDC);
	
	var myPieChart;
	legend(document.getElementById("pieLegend"), dataDC);

function renderChart(anchorLink) {
	//first slide of the second section
	if (anchorLink == 'chart-01') {
		// Reseting animations charts
		myLineChart = new Chart(ctxLC).Line(dataLC, optionsLC);
	}

	if (anchorLink == 'chart-02') {
		// Reseting animations charts
		myBarChart = new Chart(ctxBC).Bar(dataBC, optionsBC);
	}

	if (anchorLink == 'chart-03') {
		// Reseting animations charts
		myRadarChart = new Chart(ctxRC).Radar(dataRC, optionsRC);
	}

	if (anchorLink == 'chart-04') {
		// Reseting animations charts
		myPolarAreaChart = new Chart(ctxPAC).PolarArea(dataPAC, optionsPAC);
	}

	if (anchorLink == 'chart-05') {
		// Reseting animations charts
		myDoughnutChart = new Chart(ctxDC).Doughnut(dataDC, optionsDC);
	}

	if (anchorLink == 'chart-06') {
		// Reseting animations charts
		myPieChart = new Chart(ctxPC).Pie(dataDC, optionsDC);

	}
}