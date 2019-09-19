$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return year + '-' + month + '-' + day;
	}


	$('#regionLoader').hide();
	$('#individualLoader').hide();
	var chartRegion = "";
	var chartIndividual = "";
	getEmployeeList();

	$('#divLoadingName').hide();

	$('#btnSubmitRegion').click(function() {
		$('#regionError').text('');
		var DateFrom = $('#filterDatefrom').val();
		var Tanggal = DateFrom.split("/");
		DateFrom = getEditFormattedDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));
		var NewDateFrom = formatDate(new Date(Tanggal[1]+'-'+Tanggal[0]+'-'+Tanggal[2]));

		var DateTo = $('#filterDateto').val()
		var Tanggal = DateTo.split("/");
		DateTo = getEditFormattedDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));
		var NewDateTo = formatDate(new Date(Tanggal[1]+'-'+Tanggal[0]+'-'+Tanggal[2]));

		if (chartRegion != ""){
			chartRegion.destroy();
		}
		if (DateFrom == "NaN-NaN-NaN" && DateTo == "NaN-NaN-NaN"){
			showModal('Filter Date from and Date to must be filled!', 0);
			return false;
		} else if (DateFrom == "NaN-NaN-NaN" || DateTo == "NaN-NaN-NaN"){
			showModal('Filter Date from and Date to must be filled!', 0);
			return false;
		} else if (DateFrom == "NaN-NaN-NaN" ? DateTo != "NaN-NaN-NaN" : DateTo == "NaN-NaN-NaN"){
			showModal('Filter Date from and Date to must be filled!', 0);
			return false;
		} else if (DateTo < DateFrom) {
			showModal("Date to must be greater than date from", 0);
			return false;
		} else {
			$('#regionLoader').show();
			var SubmitRegionData = {
				RegionID: $('#selectRegion').val(),
				DateFrom: DateFrom,
				DateTo: DateTo
			}
			$.ajax({
				type: 'POST',
				url: '/getAttendanceReportColumnChart',
				data: SubmitRegionData,
				dataType: 'json',
				success:function(data){
					$('#regionLoader').hide();
					if (data.length == 0){
						$('#regionError').text('No data found');
					} else {
						var region = [];
						var OnTime = [];
						var Late = [];
						var Permit = [];
						for (var i = 0; i < data.length; i++){
							region[i] 	= data[i].RegionID;
							if (data[i].OnTime != null){
								OnTime[i] 	= parseFloat(data[i].OnTime);
							} else {
								OnTime[i] = "0";
							}
							if (data[i].Late != null){
								Late[i] 	= parseFloat(data[i].Late);
							} else {
								Late[i] = "0";
							}
							if (data[i].Permit != null){
								Permit[i] 	= parseFloat(data[i].Permit);
							} else {
								Permit[i] = "0";
							}
						}
						var ctx = document.getElementById('RegionChart').getContext('2d');
						chartRegion = new Chart(ctx, {
						    type: 'horizontalBar',
						    data: {
						        labels: region,
						        datasets: [
						        	{
							            label: "OnTime",
							            backgroundColor: "#87CEFA",
							            fillColor: "#87CEFA",
							            data: OnTime
						        	},
						        	{
							            label: "Late",
							            backgroundColor: "#ff85a2",
							            fillColor: "#ff85a2",
							            data: Late
						        	},
						        	{
							            label: "Permit",
							            backgroundColor: "#FFFF66",
							            fillColor: "#FFFF66",
							            data: Permit
					        		}
						        ]
						    },
						    options: {
						    	legend: {
							            labels: {
							                fontSize: 20
						            }
	       						},
						    	title: {
						            display: true,
						            text: 'Attendance Region Report, From ' + NewDateFrom + ' to ' + NewDateTo + ' ( ' + $('#selectRegion').val() + ' Region )',
						            fontSize: 20
						        },
						        animation: {
						            duration: 500,
						            easing: "easeOutQuart",
						            onComplete: function () {
						                var ctx = this.chart.ctx;
						                ctx.font = "bold 12px sans-serif";
						                ctx.textAlign = 'center';
						                ctx.textBaseline = 'bottom';
						                this.data.datasets.forEach(function (dataset) {
						                    for (var i = 0; i < dataset.data.length; i++) {
						                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
						                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
						                        ctx.fillStyle = '#444';
						                        var y_pos = model.y + 6;
						                        var newdata = dataset.data[i];
						                        if ((scale_max - model.y) / scale_max >= 0.93)
						                            y_pos = model.y + 20;

						                        if (newdata == "0"){
						                        	newdata = "";
						                        }

						                        if (model.x >= 100) {
						                        	ctx.fillText(newdata + '%', model.x - 20, y_pos);
						                        } else if (newdata == "") {
						                        	ctx.fillText(newdata, model.x + 25, y_pos);
						                        } else {
						                        	ctx.fillText(newdata + '%', model.x + 25, y_pos);
						                        }
						                    }
						                });               
						            }
						        }
						    }
						});
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					showModal("Whoops! Something wrong", 0);
					$('#regionLoader').hide();
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
	});

	$('#btnSubmitIndividual').click(function() {
		$('#individualError').text('');
		var DateFrom = $('#filterDatefromIndividual').val();
		var Tanggal = DateFrom.split("/");
		DateFrom = getEditFormattedDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));
		var NewDateFrom = formatDate(new Date(Tanggal[1]+'-'+Tanggal[0]+'-'+Tanggal[2]));

		var DateTo = $('#filterDatetoIndividual').val()
		var Tanggal = DateTo.split("/");
		DateTo = getEditFormattedDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));
		var NewDateTo = formatDate(new Date(Tanggal[1]+'-'+Tanggal[0]+'-'+Tanggal[2]));

		if (chartIndividual != ""){
			chartIndividual.destroy();
		}
		if (DateFrom == "NaN-NaN-NaN" && DateTo == "NaN-NaN-NaN"){
			showModal('Filter Date from and Date to must be filled!', 0);
			return false;
		} else if (DateFrom == "NaN-NaN-NaN" || DateTo == "NaN-NaN-NaN"){
			showModal('Filter Date from and Date to must be filled!', 0);
			return false;
		} else if (DateFrom == "NaN-NaN-NaN" ? DateTo != "NaN-NaN-NaN" : DateTo == "NaN-NaN-NaN"){
			showModal('Filter Date from and Date to must be filled!', 0);
			return false;
		} else if (DateTo < DateFrom) {
			showModal("Date to must be greater than date from", 0);
			return false;
		} else {

			$('#individualLoader').show();

			var SubmitIndividualData = {
				EmployeeID 		: $('#filterName').val(),
				DateFrom 		: DateFrom,
				DateTo 			: DateTo
			}
			$.ajax({
				type: 'POST',
				url: '/getAttendanceReportPieChart',
				data: SubmitIndividualData,
				dataType: 'json',
				success:function(data){
					$('#individualLoader').hide();
					if (data['Row'].length == 0){
						$('#individualError').text('No data found');
					} else {
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
											ctx.font = helpers.fontString(20, opts.defaultFontStyle, opts.defaultFontFamily);
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
						var ctx = document.getElementById('individualChart').getContext('2d');
						chartIndividual = new Chart(ctx, {
						    type: 'doughnutLabels',
						    data: {
						        labels: ["On Time", "Late", "Permit"],
						        datasets: [{
						            label: "Attendance",
						            backgroundColor: ["#87CEFA", "#ff85a2", "#FFFF66"],
						            borderColor: ["#87CEFA", "#ff85a2", "#FFFF66"],
						            data: [parseFloat(data['Row'][0].OnTime), parseFloat(data['Row'][0].Late), parseFloat(data['Row'][0].Permit)],
						        }]
						    },
						    options: {
						    	legend: {
						            labels: {
						                fontSize: 20
					            	}
	       						},
						    	title: {
						            display: true,
						            text: data['EmployeeData'][0].EmployeeName + ' Attendance Report, From ' + NewDateFrom + ' to ' + NewDateTo,
						            fontSize: 20
						        },
						        animation: {
							      	animateScale: true,
							      	animateRotate: true
							    }
						    },
						});
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					showModal("Whoops! Something wrong", 0);
					$('#individualLoader').hide();
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
	});

	$('#selectRegionIndividual').change(function() {
		getEmployeeList();
	});

	function formatDate(date) {
		  var monthNames = [
		    "January", "February", "March",
		    "April", "May", "June", "July",
		    "August", "September", "October",
		    "November", "December"
		  ];

		  var day = date.getDate();
		  var monthIndex = date.getMonth();
		  var year = date.getFullYear();

		  return day + ' ' + monthNames[monthIndex] + ' ' + year;
	}

	function getEmployeeList(){
		$('#divFilterName').hide();
		$('#divLoadingName').show();
		$('#filterName').html('');
		$.ajax({
			type: 'POST',
			url: '/getEmployeeAttendanceReport',
			dataType: 'json',
			success:function(data){
				for (var i = 0; i < data.length; i++){
					$('#filterName').append('<option value="'+data[i]['EmployeeID']+'">'+data[i]['EmployeeName']+'</option>');
				}
				$('#divLoadingName').hide();
				$('#divFilterName').show();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	$('#btnAlright').click(function() {
		$('#Modal').modal('hide');
	});

	function showModal(data, status){
		$('#btnOK').hide();
		$('#LoadingModal').modal('hide');
		if (status == 1){
			$('#ModalHeader').html('<i class="fa fa-check-circle" aria-hidden="true" style="font-size:24px;color:green"></i> Notification');
			$('#ModalContent').html(data);
		} else {
			$('#ModalHeader').html('<i class="fa fa-times-circle" aria-hidden="true" style="font-size:24px;color:red"></i> Notification');
			$('#ModalContent').html(data);
		}
		$('#btnAlright').show();
		$('#Modal').modal(); 
	}
});