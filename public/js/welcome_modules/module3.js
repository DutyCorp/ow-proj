$(document).ready(function() {
	convertInvoiceValue();

	$('.chartrevenue').each(function() {
		var id = $(this).attr('id');
		var region = id.slice(2);
		var chartdata = $(this).val().split("+n");
		if (chartdata[1].indexOf("-") >= 0){
			chartdata[1] = 0;
		}
		showChartRevenue(region, chartdata);
		$('#' + id).remove();
	});

	function showChartRevenue(region, chartdata){
		var chartpercentage = [];
		var target = chartdata[1] - chartdata[0];
		var achieved = ((chartdata[0]/chartdata[1])*100).toFixed();
		var chartpercentage = achieved;
		if (target > 0){
			var oldtarget = target;
			target = ((target/chartdata[1])*100).toFixed();
			chartdata[1] = oldtarget;
		} else {
			achieved = 100;
			target = 0;
		}
		var config = {
	        type: 'pie',
	        data: {
	            datasets: [{
	                data: [
	                    achieved,
	                    target,
	                ],
	                backgroundColor: [
	                    '#41AB9E',
	                    '#BFBFBF',
	                ]
	            }],
	            labels: [
	                "Achieved",
	                "Target"
	            ]
	        },
	        options: {
	        	tooltips: {
	        		enabled: true,
	        		mode: 'single',
	        		callbacks: {
	        			label: function(tooltipItem, data){
	        				return '$ ' + addCommas(chartdata[tooltipItem.index]);
	        			}
	        		}
	        	},
	        	legend: {
		            display: false
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
				        ctx.fillStyle = '#000000';
				        ctx.textAlign = 'center';
				        ctx.textBaseline = 'bottom';

				        this.data.datasets.forEach(function(dataset, i) {
				        	var meta = chartInstance.controller.getDatasetMeta(i);
				        	meta.data.forEach(function(bar, index) {
				        		ctx.fillText(chartpercentage + '%', bar._model.x, bar._model.y + 30);
				        	});
				        });
				    }
	            }
	        }
	    };
	    var ctx = document.getElementById("chartRevenue" + region).getContext("2d");
        window.PieChart = new Chart(ctx, config);
	}

	function convertInvoiceValue(){
		var AmountInvoice = $('#numAmountInvoice').html();
		var AmountExpected = $('#numAmountInvoiceExpected').html();
		var OpenInvoice = $('#numOpenInvoice').html().split("/");
		var OpenInvoiceCurrentYear = OpenInvoice[0];
		var OpenInvoiceAll = OpenInvoice[1];

		AmountInvoice = invoiceNumberFormat(AmountInvoice);
		AmountExpected = invoiceNumberFormat(AmountExpected);
		OpenInvoiceCurrentYear = invoiceNumberFormat(OpenInvoiceCurrentYear);
		OpenInvoiceAll = invoiceNumberFormat(OpenInvoiceAll);

		$('#numAmountInvoice').html('$ ' + AmountInvoice);
		$('#numAmountInvoiceExpected').html('$ ' + AmountExpected);
		var value = OpenInvoiceCurrentYear.substr(OpenInvoiceCurrentYear.length - 1);
		if (value == OpenInvoiceAll.substr(OpenInvoiceAll.length - 1)){
			OpenInvoiceCurrentYear = OpenInvoiceCurrentYear.slice(0, -1);
			OpenInvoiceAll = OpenInvoiceAll.slice(0, -1);
			$('#numOpenInvoice').html('$ ' + OpenInvoiceCurrentYear + '/' + OpenInvoiceAll + ' ' + value);
		} else {
			$('#numOpenInvoice').html('$ ' + OpenInvoiceCurrentYear + '/' + OpenInvoiceAll);
		}
	}

	function invoiceNumberFormat(num) {
		if (num.length >= 10){
			var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (1 || -1) + '})?');
			return (num/1000000000).toString().match(re)[0] + 'B';
		} else if (num.length >= 7){
			var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (1 || -1) + '})?');
			return (num/1000000).toString().match(re)[0] + 'M';
		} else if (num.length >= 4){
			var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (1 || -1) + '})?');
			return (num/1000).toString().match(re)[0] + 'K';
		} else {
			return num;
		}
	}

	function addCommas(nStr) {
	    nStr += '';
	    var x = nStr.split('.');
	    var x1 = x[0];
	    var x2 = x.length > 1 ? '.' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + ',' + '$2');
	    }
	    return x1 + x2;
	}
});