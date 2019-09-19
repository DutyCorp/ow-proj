$(document).ready(function() {
	showChartClosedDeals();

	function showChartClosedDeals(){
		var dataarray = [];
		var labelarray = [];
		var numberarray = [];

		for (var i = 0; i < 5; i++){
			var j = i + 1;
			var temparray = $('#cd'+j).val().split('+-');
			var number = temparray[1];
			dataarray.push(temparray[1]);
			labelarray.push(temparray[0]);
			numberarray.push(numberFormat(number));
			$('#cd'+j).remove();
		}

		var config = {
	        type: 'horizontalBar',
	        data: {
	            datasets: [{
	                data: dataarray,
	                backgroundColor: '#128EDB'
	            }],
	            labels: labelarray
	        },
	        options: {
	        	scales: {
	        		xAxes: [{
	        			ticks: {
	        				beginAtZero: true,
	        				userCallback: function(value, index, values) {
	        					value = numberFormat(value);
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
	        				fontSize: 12,
	        				fontStyle: "bold"
	        			}
	        		}]
	        	},
	        	tooltips: {
	        		enabled: true,
	        		mode: 'single',
	        		callbacks: {
	        			label: function(tooltipItems, data){
	        				return numberFormat(tooltipItems.xLabel);
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
	            maintainAspectRatio: false,
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
				        		var data = numberFormat(dataset.data[index]);
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
	    var ctx = document.getElementById("chartClosedDeals").getContext("2d");
	    ctx.height = 800;
        window.BarChart = new Chart(ctx, config);
	}

	function numberFormat(num) {
		if (num.length >= 10){
			var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (1 || -1) + '})?');
			return '$' + (num/1000000000).toString().match(re)[0] + 'B';
		} else if (num.length >= 7){
			var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (1 || -1) + '})?');
			return '$' + (num/1000000).toString().match(re)[0] + 'M';
		} else if (num.length >= 4){
			var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (1 || -1) + '})?');
			return '$' + (num/1000).toString().match(re)[0] + 'K';
		} else {
			return '$' + num;
		}
	}

    /*function numberFormat(num){
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
    }*/
});