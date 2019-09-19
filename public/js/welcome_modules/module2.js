$(document).ready(function() {
	showChartSalesTrendLine();

	function showChartSalesTrendLine(){
		var dataarray = [];
		var labelarray = [];

		for (var i = 0; i < 4; i++){
			var j = i + 1;
			var temparray = $('#stl'+j).val().split('+-');
			dataarray.push(temparray[1]);
			labelarray.push(temparray[0]);
			$('#stl'+j).remove();
		}

		var config = {
	        type: 'bar',
	        data: {
	            datasets: [{
	                data: dataarray,
	                backgroundColor: '#DC002B'
	            }],
	            labels: labelarray
	        },
	        options: {
	        	scales: {
	        		yAxes: [{
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
	        		}]
	        	},
	        	tooltips: {
	        		enabled: false
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
	    var ctx = document.getElementById("chartSalesTrendLine").getContext("2d");
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

    /*function randomOpenwayColor() {
		var OpenwayColor = ["#128EDB", "#41AB9E", "#9E0071", "#DC002B", "#E97508"];

		return OpenwayColor[Math.floor(Math.random()*OpenwayColor.length)];
    }*/
});