$(document).ready(function() {
	showChartClosedProjects();

	function showChartClosedProjects(){
		var data1array = [];
		var data2array = [];
		var labelarray = [];
		var colorarray = [];
		var i = 1;

		$('.closedprojects').each(function() {
			var temparray = $('#clp'+i).val().split('+-');
			data1array.push(temparray[0]);
			data2array.push(temparray[1]);
			labelarray.push(temparray[2]);
			colorarray.push(randomOpenwayColor());
			$('#clp'+i).remove();
			i++;
		});

		var config = {
			type: 'horizontalBar',
	        data: {
				labels: labelarray,
	            datasets: [
			        {
			            label: "Target MD",
			            backgroundColor: '#128DD9',
			            data: data1array
			        },
			        {
			            label: "Actual MD",
			            backgroundColor: "#9E0071",
			            data: data2array
			        }
			    ]
	        },
	        options: {
	        	scales: {
	        		xAxes: [{
	        			ticks: {
	        				beginAtZero: true,
	        				userCallback: function(value, index, values) {
	        					return value;
	        				}
	        			},
	        			gridLines: {
		                    display: false
		                },
		                display : false
	        		}],
	        		yAxes: [{
	        			ticks: {
	        				fontSize: 16,
	        				fontStyle: 'bold'
	        			}
	        		}]
	        	},
	        	tooltips: {
	        		enabled: true,
	        		mode: 'index',
	        		callbacks: {
	        			label: function(tooltipItems, data){
	        				return tooltipItems.yLabel + ' Md';
	        			}
	        		}
	        	},
	        	legend: {
		            display: false
		        },
		        elements: {
                    rectangle: {
                        borderWidth: 2,
                    }
                },
	            responsive: true,
	            title: {
	                display: false
	            },
	            animation: {
	                animateScale: true,
	                animateRotate: true,
	                onComplete: function () {
				        var chartInstance = this.chart,
				        ctx = chartInstance.ctx;

				        ctx.font = Chart.helpers.fontString(16, 'bold', Chart.defaults.global.defaultFontFamily);
				        
				        ctx.textAlign = 'center';
				        ctx.textBaseline = 'bottom';

				        this.data.datasets.forEach(function(dataset, i) {
				        	var meta = chartInstance.controller.getDatasetMeta(i);
				        	meta.data.forEach(function(bar, index) {
				        		var data = dataset.data[index] + ' Md';
				        		if ($(window).width() == 1366){
				        			if (bar._model.x <= 300){
					        			ctx.fillStyle = '#000000';
					        			ctx.fillText(data, bar._model.x + 35, bar._model.y + 5);
					        		} else {
					        			ctx.fillStyle = '#FFFFFF';
					        			ctx.fillText(data, bar._model.x - (bar._model.x - 300), bar._model.y + 5);
					        		}
				        		} else {
				        			if (bar._model.x <= 450){
					        			ctx.fillStyle = '#000000';
					        			ctx.fillText(data, bar._model.x + 35, bar._model.y + 5);
					        		} else {
					        			ctx.fillStyle = '#FFFFFF';
					        			ctx.fillText(data, bar._model.x - 35, bar._model.y + 5);
					        		}
				        		}
				        	});
				        });
				    }
	            }
	        }
	    };
	    var ctx = document.getElementById("chartClosedProjects").getContext("2d");
        window.BarChart = new Chart(ctx, config);
	}

    function randomOpenwayColor() {
		var OpenwayColor = ["#128DD9", "#128EDB", "#41AB9E", "#9E0071", "#DC002B", "#E97508", "#FDD70A"];

		return OpenwayColor[Math.floor(Math.random()*OpenwayColor.length)];
    }
});