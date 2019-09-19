$(document).ready(function() {
	if ($('#individualAttendanceData').length){
		var array = $('#individualAttendanceData').val().split("+n");
		var now = new Date();
		var prevMonthLastDate = new Date(now.getFullYear(), now.getMonth(), 0);
		var prevMonthFirstDate = new Date(now.getFullYear() - (now.getMonth() > 0 ? 0 : 1), (now.getMonth() - 1 + 12) % 12, 1);
		prevMonthFirstDate = formatDate(prevMonthFirstDate);
		prevMonthLastDate = formatDate(prevMonthLastDate);

		Chart.defaults.doughnutLabels = Chart.helpers.clone(Chart.defaults.doughnut);
		var helpers = Chart.helpers;
		var defaults = Chart.defaults;
		Chart.controllers.doughnutLabels = Chart.controllers.doughnut.extend({
			updateElement: function(arc, index, reset) {
			    var _this 		= this;
			    var chart 		= _this.chart,
		        chartArea 		= chart.chartArea,
		        opts 			= chart.options,
		        animationOpts 	= opts.animation,
		        arcOpts 		= opts.elements.arc,
		        centerX 		= (chartArea.left + chartArea.right) / 2,
		        centerY 		= (chartArea.top + chartArea.bottom) / 2,
		        startAngle 		= opts.rotation, // non reset case handled later
		        endAngle 		= opts.rotation, // non reset case handled later
		        dataset 		= _this.getDataset(),
		        circumference 	= reset && animationOpts.animateRotate ? 0 : arc.hidden ? 0 : _this.calculateCircumference(dataset.data[index]) * (opts.circumference / (2.0 * Math.PI)),
		        innerRadius 	= reset && animationOpts.animateScale ? 0 : _this.innerRadius,
		        outerRadius 	= reset && animationOpts.animateScale ? 0 : _this.outerRadius,
		        custom 			= arc.custom || {},
		        valueAtIndexOrDefault = helpers.getValueAtIndexOrDefault;

			    helpers.extend(arc, {
			      	// Utility
			    	_datasetIndex: _this.index,
			    	_index: index,
			      	// Desired view properties
			      	_model: {
			        x: centerX + chart.offsetX,
			        y: centerY + chart.offsetY,
			        startAngle: startAngle,
			        endAngle: endAngle,
			        circumference: circumference,
			        outerRadius: outerRadius,
			        innerRadius: innerRadius,
			        label: valueAtIndexOrDefault(dataset.label, index, chart.data.labels[index])
			    	},
				    draw: function () {
				      	var ctx 	= this._chart.ctx,
							vm		= this._view,
							sA 		= vm.startAngle,
							eA 		= vm.endAngle,
							opts 	= this._chart.config.options;
								
						var labelPos = this.tooltipPosition();
						var segmentLabel = vm.circumference / opts.circumference * 100;
						
						ctx.beginPath();
						
						ctx.arc(vm.x, vm.y, vm.outerRadius, sA, eA);
						ctx.arc(vm.x, vm.y, vm.innerRadius, eA, sA, true);
						
						ctx.closePath();
						ctx.strokeStyle = vm.borderColor;
						ctx.lineWidth = vm.borderWidth;
						
						ctx.fillStyle = vm.backgroundColor;
						
						ctx.fill();
						ctx.lineJoin = 'bevel';
									
						if (vm.borderWidth) {
							ctx.stroke();
						}			
						if (vm.circumference > 0.15) { 
							// Trying to hide label when it doesn't fit in segment
							ctx.beginPath();
							ctx.font = helpers.fontString(14, opts.defaultFontStyle, opts.defaultFontFamily);
							ctx.fillStyle = "#000";
							ctx.textBaseline = "top";
							ctx.textAlign = "center";
	            			// Round percentage in a way that it always adds up to 100%
							ctx.fillText(segmentLabel.toFixed(0) + "%", labelPos.x, labelPos.y);
						}
				    }
			    });
			    var model = arc._model;
			    model.backgroundColor = custom.backgroundColor ? custom.backgroundColor : valueAtIndexOrDefault(dataset.backgroundColor, index, arcOpts.backgroundColor);
			    model.hoverBackgroundColor = custom.hoverBackgroundColor ? custom.hoverBackgroundColor : valueAtIndexOrDefault(dataset.hoverBackgroundColor, index, arcOpts.hoverBackgroundColor);
			    model.borderWidth = custom.borderWidth ? custom.borderWidth : valueAtIndexOrDefault(dataset.borderWidth, index, arcOpts.borderWidth);
			    model.borderColor = custom.borderColor ? custom.borderColor : valueAtIndexOrDefault(dataset.borderColor, index, arcOpts.borderColor);

			    // Set correct angles if not resetting
			    if (!reset || !animationOpts.animateRotate) {
			    	if (index === 0) {
			    		model.startAngle = opts.rotation;
			    	}else {
			        	model.startAngle = _this.getMeta().data[index - 1]._model.endAngle;
			    	}
			      model.endAngle = model.startAngle + model.circumference;
			    }
			    arc.pivot();
		  	}
		});
		var ctx = document.getElementById('individualAttendanceChart').getContext('2d');
		chartIndividual = new Chart(ctx, {
		    type: 'doughnutLabels',
		    data: {
		        labels: ["On Time", "Late", "Permit"],
		        datasets: [{
		            label: "Attendance",
		            backgroundColor: ["#87CEFA", "#ff85a2", "#FFFF66"],
		            borderColor: ["#87CEFA", "#ff85a2", "#FFFF66"],
		            data: [parseFloat(array[0]), parseFloat(array[1]), parseFloat(array[2])],
		        }]
		    },
		    options: {
		    	legend: {
		            labels: {
		                fontSize: 14
	            	}
					},
		    	title: {
		            display: true,
		            text: 'Personal Attendance Report, From ' + prevMonthFirstDate + ' to ' + prevMonthLastDate,
		            fontSize: 14
		        },
		        animation: {
			      	animateScale: true,
			      	animateRotate: true
			    }
		    },
		});
		$('#individualAttendanceData').remove();
	} else {
		$('#individualError').html('No data found');
	}
	if ($('#individualOccupationData').length){
		var array = $('#individualOccupationData').val().split("+n");
		var Chargeability = [];
		var Utilization = [];
		var LabelName = [];
		Chargeability.push(array[0]);
		Utilization.push(array[1]);
		var Month = array[2];
		LabelName.push(array[3]);
		var Title = "Occupation Report YTD as of " + Month;
		var config = {
			type: 'bar',
			data: 
			{
				labels: LabelName,
				datasets: [
				{
					label: "Chargeability",
					backgroundColor: "#87CEFA",
					fillColor: "#87CEFA",
					data: Chargeability,
				},
				{
					label: "Utilization",
					backgroundColor: "#ff85a2",
					fillColor: "#ff85a2",
					data: Utilization,
				}
				]
			},
			options: {
				title: {
					display: true,
					text: Title,
					fontSize:16
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							userCallback: function(value, index, values) {
								value = value.toString();
								value = value.split(/(?=(?:...)*$)/);
								value = value.join(',');
								return value + '%';
							},
							stepSize: 20
						}
					}],
					xAxes: [{
						ticks: {
							fontSize: 14
						}
					}]
				},
				legend: {
					display: true,
					labels: {
						fontSize: 14
					}
				},
				tooltips: {
					enabled: true,
					mode: 'single',
					callbacks: {
						label: function(tooltipItems, data){
							return tooltipItems.yLabel + '%';
						}
					}
				},
				animation: {
					duration: 500,
					easing: "easeOutQuart",
					onComplete: function () {
						var ctx = this.chart.ctx;

						ctx.font = "bold 14px sans-serif";
						ctx.textAlign = 'center';
						ctx.textBaseline = 'bottom';
						
						this.data.datasets.forEach(function (dataset) {
							for (var i = 0; i < dataset.data.length; i++) {
								var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
								scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
								ctx.fillStyle = '#444';
								var y_pos = model.y + 0;
								if ((scale_max - model.y) / scale_max >= 0.93)
									y_pos = model.y + 20;
								var newdata = dataset.data[i];
								if(newdata == 0){
									ctx.fillText("", model.x + 25, y_pos);
								}else{
									ctx.fillText(newdata+'%', model.x , y_pos);
								}
							}
						});               
					}
				}
			}
		};
		
		var ctx = document.getElementById("individualOccupationChart").getContext("2d");
        window.BarChart = new Chart(ctx, config);

		$('#individualAttendanceData, #individualError').remove();
	} else {
		$('#individualError').html('No data found');
	}

	function formatDateComponent(dateComponent){
		return (dateComponent < 10 ? '0' : '') + dateComponent;
	}

	function formatDate(date){
		return formatDateComponent(date.getMonth() + 1) + '/' + formatDateComponent(date.getDate()) + '/' + date.getFullYear();
	}
});