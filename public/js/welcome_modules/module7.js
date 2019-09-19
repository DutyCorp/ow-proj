$(document).ready(function() {
	$('.staffperformance').each(function() {
		var id = $(this).attr('id');
		var region = id.slice(2);
		var chartdata = $(this).val().split("+-");
		showChartStaffPerformance(region, chartdata);
		$('#' + id).remove();
	});

	function showChartStaffPerformance(region, chartdata){
		var config = {
	        type: 'bar',
	        data: {
	            datasets: [{
	                data: chartdata,
	                backgroundColor: ["#9E0071", '#DC002B']
	            }],
	            labels: ['Chargeability', 'Utilization']
	        },
	        options: {
	        	scales: {
	        		xAxes: [{
		                display: false
		            }],
	        		yAxes: [{
	        			ticks: {
	        				beginAtZero: true,
	        				min: 0,
				            max: 300,
				            stepSize: 40,
	        				userCallback: function(value, index, values) {
	        					return value + '%';
	        				}
	        			},
	        			gridLines: {
		                    display: false
		                },
		                display : false
	        		}]
	        	},
	        	tooltips: {
	        		enabled: false
	        	},
	        	legend: {
		            display: false
		        },
	            responsive: true,
	            title: {
	                display: false
	            },
	            maintainAspectRatio: false,
	            animation: {
	                animateScale: true,
	                animateRotate: true,
	                onComplete: function () {
				        var chartInstance = this.chart,
				        ctx = chartInstance.ctx;

				        ctx.font = Chart.helpers.fontString(16, 'bold', Chart.defaults.global.defaultFontFamily);
				        ctx.fillStyle = '#FFFFFF';
				        ctx.textAlign = 'center';
				        ctx.textBaseline = 'bottom';

				        this.data.datasets.forEach(function(dataset, i) {
				        	var meta = chartInstance.controller.getDatasetMeta(i);
				        	meta.data.forEach(function(bar, index) {
				        		var data = dataset.data[index] + '%';
				        		if (bar._model.y > 150){
				        			ctx.fillStyle = '#000000';
				        			ctx.fillText(data, bar._model.x, bar._model.y - 5);
				        		} else {
				        			ctx.fillStyle = '#FFFFFF';
				        			ctx.fillText(data, bar._model.x, bar._model.y + 20);
				        		}
				        	});
				        });
				    }
	            }
	        }
	    };
	    var ctx = document.getElementById("chartStaffPerformance" + region).getContext("2d");
        window.BarChart = new Chart(ctx, config);
	}

    function randomOpenwayColor() {
		var OpenwayColor = ["#128DD9", "#128EDB", "#41AB9E", "#9E0071", "#DC002B", "#E97508", "#FDD70A"];

		return OpenwayColor[Math.floor(Math.random()*OpenwayColor.length)];
    }

    function numberFormat(num){
	    if (num >= 1000000000) {
	       return '$'+(num / 1000000000).toFixed(1).replace(/\.0$/, '') + 'G';
	    }
	    if (num >= 1000000) {
	       return '$'+(num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
	    }
	    if (num >= 1000) {
	       return '$'+(num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
	    }
	    return num;
    }
});