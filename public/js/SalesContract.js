$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('.loader').hide();

	var chartDetail = "";
	var chartSummary = "";
	var chartRegion = "";
	var chartCDLS = "";
	var chartCDM = "";
	var chartCDT = "";
	var chartCSLS = "";
	var chartCSM = "";
	var chartCST = ""

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		return year + month ;
	}

	function getEditFormattedMonth(date) {
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		return month;
	}

	function getEditFormattedYear(date) {
		var year = date.getFullYear();
		return year;
	}
	
	$('#SummaryGraphSC').click(function(){
		if (chartSummary != ""){
			chartSummary.destroy();
		}
		var DateFrom = $('#DateFrom').val();
		var DateTo = $('#DateTo').val();
		if(DateFrom != "")
			DateFrom = getEditFormattedDate(new Date($('#DateFrom').val()));
		if(DateTo != "")
			DateTo = getEditFormattedDate(new Date($('#DateTo').val()));

		var MonthFrom = getEditFormattedMonth(new Date($('#DateFrom').val()));
		var MonthTo = getEditFormattedMonth(new Date($('#DateTo').val()));
		var YearFrom = getEditFormattedYear(new Date($('#DateFrom').val()));
		var YearTo = getEditFormattedYear(new Date($('#DateTo').val()));
		if(DateFrom == "" || DateTo == "" ){
			alert("Date From and Date To must be filled");
			return false;
		}
		else if(YearTo < YearFrom)
		{
			alert("Year To must be greater than Year From");
			return false;
		}
		else if(MonthTo < MonthFrom && YearTo == YearFrom)
		{
			alert("Month To must be greater Month From");
			return false;
		}
		var FilterGraphData = {
			ProjectRegion	: $('#projectRegion').val(),
			DateFrom		: getEditFormattedDate(new Date($('#DateFrom').val())),
			DateTo			: getEditFormattedDate(new Date($('#DateTo').val())),
			ProjectStatus 	: $('#projectStatus').val(),
	    	ContractStatus 	: $('#contractStatus').val(),
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/SummaryGraphSC',
			data 		: FilterGraphData,
			dataType 	: 'json',
			success:function(data){
				if(data == ""){
					return false;
				}else{
					$('#SummaryInfo').hide();
					var month = [];
					var Total = [];
					for (var i = 0; i < data.length; i++){
						month[i] = data[i]['Date'];
						if (data[i]['Total'] != null){
							Total[i] = parseInt(data[i]['Total']);
						} else {
							Total[i] = "0";
						}
					}
					var ctx = document.getElementById('myChartSummary').getContext('2d');
					chartSummary = new Chart(ctx, {
					    type: 'horizontalBar',
					    data: 
					    {
					        labels: month,
					        datasets: [
					        	{
						            label: "Total",
						            backgroundColor: "#446CB3",
						            fillColor: "#FC9775",
						            data: Total
					        	}
					        ]
					    },
					    options: {
					    	title: {
					            display: true,
					            text: 'Sales Contract Summary Report, From ' + $('#DateFrom').val() + ' To ' + $('#DateTo').val() + ' ( ' + $('#projectRegion').val() + ' Region )'
					        },
					        scales: {
					    		xAxes: [{
								    ticks: {
								        beginAtZero: true,
								        userCallback: function(value, index, values) {
								            value = value.toString();
								            value = value.split(/(?=(?:...)*$)/);
								            value = value.join(',');
								            return '$' + value;
								        }
								    }
								}]
					        },
					        tooltips: {
				                enabled: true,
				                mode: 'single',
				                callbacks: {
				                    label: function(tooltipItems, data){
				                        return '$' + addCommas(tooltipItems.xLabel);
				                    }
				                }
				            },
					        animation: {
					            duration: 500,
					            easing: "easeOutQuart",
					            onComplete: function () {
					                var ctx = this.chart.ctx;
					                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
					                ctx.textAlign = 'center';
					                ctx.textBaseline = 'bottom';
					                this.data.datasets.forEach(function (dataset) {
					                    for (var i = 0; i < dataset.data.length; i++) {
					                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
					                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
					                        ctx.fillStyle = '#444';
					                        var y_pos = model.y + 8;
					                        if ((scale_max - model.y) / scale_max >= 0.93)
					                            y_pos = model.y + 20;
					                        var newdata = dataset.data[i]; 
					                        newdata = addCommas(newdata);
					                        newdata = '$' + newdata;
					                        ctx.fillText(newdata, model.x + 32, y_pos);
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
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#DetailGraphSC').click(function(){
		$('#DetailInfo').hide();
		if (chartDetail != ""){
			chartDetail.destroy();
		}
		var DateFrom 	= $('#DateFrom').val();
		var DateTo 		= $('#DateTo').val();
		if(DateFrom != "")
			DateFrom = getEditFormattedDate(new Date($('#DateFrom').val()));
		if(DateTo != "")
			DateTo = getEditFormattedDate(new Date($('#DateTo').val()));

		var MonthFrom = getEditFormattedMonth(new Date($('#DateFrom').val()));
		var MonthTo = getEditFormattedMonth(new Date($('#DateTo').val()));
		var YearFrom = getEditFormattedYear(new Date($('#DateFrom').val()));
		var YearTo = getEditFormattedYear(new Date($('#DateTo').val()));
		if(DateFrom == "" || DateTo == "" ) {
			showModal("Date From and Date To must be filled",0);
			return false;
		}
		else if(YearTo < YearFrom) {
			showModal("Year To must be greater than Year From",0);
			return false;
		}
		else if(MonthTo < MonthFrom && YearTo == YearFrom) {
			showModal("Month To must be greater Month From",0);
			return false;
		}else{
			var FilterGraphData = {
				ProjectRegion	: $('#projectRegion').val(),
				DateFrom		: DateFrom,
				DateTo			: DateTo,
				ProjectStatus 	: $('#projectStatus').val(),
		    	ContractStatus 	: $('#contractStatus').val(),
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/DetailGraphSC',
				data 		: FilterGraphData,
				dataType 	: 'json',
				success:function(data){
					if(data == ""){
						$('#DetailInfo').show();
						return false;
					}else {
						$('#DetailInfo').hide();
						var month = [];
						var Licenses = [];
						var Maintenance = [];
						var Service = [];
						for (var i = 0; i < data.length; i++){
							month[i] = data[i]['Date'];
							Licenses[i] = parseInt(data[i]['Licenses']);
							Service[i] = parseInt(data[i]['Service']);
							Maintenance[i] = parseInt(data[i]['Maintenance']);
						}
						var ctx = document.getElementById('myChartDetail').getContext('2d');
						chartDetail = new Chart(ctx, {
						    type: 'horizontalBar',
						    data: 
						    {
						        labels: month,
						        datasets: [
						        	{
							            label: "Licenses",
							            backgroundColor: "#87CEFA",
							            fillColor: "#87CEFA",
							            data: Licenses
						        	},
						        	{
							            label: "Maintenance",
							            backgroundColor: "#ff85a2",
							            fillColor: "#ff85a2",
							            data: Maintenance
						        	},
						        	{
							            label: "Service",
							            backgroundColor: "#FFFF66",
							            fillColor: "#FFFF66",
							            data: Service
						        	}
						        ]
						    },
						    options: {
						    	title: {
						            display: true,
						            text: 'Sales Contract Detail Report, From ' + $('#DateFrom').val() + ' To ' + $('#DateTo').val() + ' ( ' + $('#projectRegion').val() + ' Region )'
						        },
						        scales: {
						    		xAxes: [{
									    ticks: {
									        beginAtZero: true,
									        userCallback: function(value, index, values) {
									            value = value.toString();
									            value = value.split(/(?=(?:...)*$)/);
									            value = value.join(',');
									            return '$' + value;
									        }
									    }
									}]
						        },
						        tooltips: {
					                enabled: true,
					                mode: 'single',
					                callbacks: {
					                    label: function(tooltipItems, data){
					                        return '$' + addCommas(tooltipItems.xLabel);
					                    }
					                }
					            },
						        animation: {
						            duration: 500,
						            easing: "easeOutQuart",
						            onComplete: function () {
						                var ctx = this.chart.ctx;
						                ctx.font = "10px sans-serif";
						                ctx.textAlign = 'center';
						                ctx.textBaseline = 'bottom';
						                this.data.datasets.forEach(function (dataset) {
						                    for (var i = 0; i < dataset.data.length; i++) {
						                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
						                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
						                        ctx.fillStyle = '#444';
						                        var y_pos = model.y + 6;
						                        if ((scale_max - model.y) / scale_max >= 0.93)
						                            y_pos = model.y + 20;
						                        var newdata = dataset.data[i]; 
						                        newdata = addCommas(newdata);
						                        newdata = '$' + newdata;
						                        ctx.fillText(newdata, model.x + 25, y_pos);
						                    }
						                });               
						            }
						        }
						    },
						});
					}				
				},
				error: function (xhr, ajaxOptions, thrownError) {
					showModal("Whoops! Something wrong", 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
	});

	$('#RegionGraphSC').click(function(){
		$('#RegionInfo').hide();
		if (chartRegion != ""){
			chartRegion.destroy();
		}
		var DateFrom = $('#DateFrom').val();
		var DateTo = $('#DateTo').val();
		if(DateFrom != "")
			DateFrom = getEditFormattedDate(new Date($('#DateFrom').val()));
		if(DateTo != "")
			DateTo = getEditFormattedDate(new Date($('#DateTo').val()));

		var MonthFrom = getEditFormattedMonth(new Date($('#DateFrom').val()));
		var MonthTo = getEditFormattedMonth(new Date($('#DateTo').val()));
		var YearFrom = getEditFormattedYear(new Date($('#DateFrom').val()));
		var YearTo = getEditFormattedYear(new Date($('#DateTo').val()));
		if(DateFrom == "" || DateTo == "" ) {
			showModal("Date From and Date To must be filled",0);
			return false;
		} else if(YearTo < YearFrom) {
			showModal("Year To must be greater than Year From",0);
			return false;
		} else if(MonthTo < MonthFrom && YearTo == YearFrom) {
			showModal("Month To must be greater Month From",0);
			return false;
		} else {
			var FilterGraphData = {
				ProjectRegion	: $('#projectRegion').val(),
				DateFrom		: DateFrom,
				DateTo			: DateTo,
				ProjectStatus 	: $('#projectStatus').val(),
		    	ContractStatus 	: $('#contractStatus').val(),
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/RegionGraphSC',
				data 		: FilterGraphData,
				dataType 	: 'json',
				success:function(data){
					if(data == ""){
						$('#RegionInfo').show();
						return false;
					}else {
						$('#RegionInfo').hide();
						var RegionName = [];
						var Licenses = [];
						var Maintenance = [];
						var Service = [];
						for (var i = 0; i < data.length; i++){
							RegionName[i] = data[i]['RegionName'];
							Licenses[i] = parseFloat(data[i]['Licenses']);
							Service[i] = parseFloat(data[i]['Service']);
							Maintenance[i] = parseFloat(data[i]['Maintenance']);
						}
						var ctx = document.getElementById('myChartRegion').getContext('2d');
						chartRegion = new Chart(ctx, {
						    type: 'horizontalBar',
						    data: 
						    {
						        labels: RegionName,
						        datasets: [
						        	{
							            label: "Licenses",
							            backgroundColor: "#87CEFA",
							            fillColor: "#87CEFA",
							            data: Licenses
						        	},
						        	{
							            label: "Maintenance",
							            backgroundColor: "#ff85a2",
							            fillColor: "#ff85a2",
							            data: Maintenance
						        	},
						        	{
							            label: "Service",
							            backgroundColor: "#FFFF66",
							            fillColor: "#FFFF66",
							            data: Service
						        	}
						        ]
						    },
						    options: {
						    	title: {
						            display: true,
						            text: 'Sales Contract Region Report, From ' + $('#DateFrom').val() + ' To ' + $('#DateTo').val() + ' ( ' + $('#projectRegion').val() + ' Region )'
						        },
						        scales: {
						    		xAxes: [{
									    ticks: {
									        beginAtZero: true,
									        userCallback: function(value, index, values) {
									            value = value.toString();
									            value = value.split(/(?=(?:...)*$)/);
									            value = value.join(',');
									            return '$' + value;
									        }
									    }
									}]
						        },
						        tooltips: {
					                enabled: true,
					                mode: 'single',
					                callbacks: {
					                    label: function(tooltipItems, data){
					                        return '$' + addCommas(tooltipItems.xLabel);
					                    }
					                }
					            },
						        animation: {
						            duration: 500,
						            easing: "easeOutQuart",
						            onComplete: function () {
						                var ctx = this.chart.ctx;
						                ctx.font = "10px sans-serif";
						                ctx.textAlign = 'center';
						                ctx.textBaseline = 'bottom';
						                this.data.datasets.forEach(function (dataset) {
						                    for (var i = 0; i < dataset.data.length; i++) {
						                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
						                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
						                        ctx.fillStyle = '#444';
						                        var y_pos = model.y + 6;
						                        if ((scale_max - model.y) / scale_max >= 0.93)
						                            y_pos = model.y + 20;
						                        var newdata = dataset.data[i]; 
						                        newdata = addCommas(newdata);
						                        newdata = '$' + newdata;
						                        ctx.fillText(newdata, model.x + 25, y_pos);
						                    }
						                });               
						            }
						        }
						    },
						});
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					showModal("Whoops! Something wrong", 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
	});

	$('#CustomerDGraphSC').click(function(){
		$('#CDTInfo').hide();
		$('#CDLSInfo').hide();
		$('#CDMInfo').hide();
		if (chartCDLS != ""){
			chartCDLS.destroy();
		}
		if (chartCDM != ""){
			chartCDM.destroy();
		}
		if (chartCDT != ""){
			chartCDT.destroy();
		}
		var CheckMaintenance = 0;
		var DateFrom = $('#DateFrom').val();
		var DateTo = $('#DateTo').val();
		if(DateFrom != "")
			DateFrom = getEditFormattedDate(new Date($('#DateFrom').val()));
		if(DateTo != "")
			DateTo = getEditFormattedDate(new Date($('#DateTo').val()));

		var MonthFrom = getEditFormattedMonth(new Date($('#DateFrom').val()));
		var MonthTo = getEditFormattedMonth(new Date($('#DateTo').val()));
		var YearFrom = getEditFormattedYear(new Date($('#DateFrom').val()));
		var YearTo = getEditFormattedYear(new Date($('#DateTo').val()));
		var CustomerName = $('#CustomerName').val();
		if(DateFrom == "" || DateTo == "" ) {
			showModal("Date From and Date To must be filled",0);
			return false;
		} else if(YearTo < YearFrom) {
			showModal("Year To must be greater than Year From",0);
			return false;
		} else if(MonthTo < MonthFrom && YearTo == YearFrom) {
			showModal("Month To must be greater Month From",0);
			return false;
		} else if(CustomerName == ""){
			showModal("Customer Name must be filled",0);
			return false;
		} else {
			var FilterGraphData = {
				ProjectRegion	: $('#projectRegion').val(),
				DateFrom		: DateFrom,
				DateTo			: DateTo,
				ProjectStatus 	: $('#projectStatus').val(),
		    	ContractStatus 	: $('#contractStatus').val(),
		    	CustomerName 	: CustomerName
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/CDGraphSC',
				data 		: FilterGraphData,
				dataType 	: 'json',
				success:function(data){
					if(data == ""){
						$('#ModalCustomerName').modal('hide');
						$('#GraphCustomerDetail').modal('show');
						$('#CDTInfo').show();
						$('#CDLSInfo').show();
						$('#CDMInfo').show();
						return false;
					}else {
						$('#CDTInfo').hide();
						$('#CDLSInfo').hide();
						$('#CDMInfo').hide();
						$('#ModalCustomerName').modal('hide');
						$('#GraphCustomerDetail').modal('show');
						
						var CheckMaintenance = 0;
						var CheckTotal = 0;
						var CheckLS = 0;

						var ProjectNameLS = [];
						var Licenses = [];
						var Service = [];
						var TotalLS = [];

						var ProjectNameM = [];
						var Maintenance = [];

						var Year = [];
						var Total = [];

						for (var i = 0; i < data['GraphListLS'].length; i++){
							ProjectNameLS[i] = data['GraphListLS'][i]['ProjectName'];
							Licenses[i] = parseFloat(data['GraphListLS'][i]['Licenses']);
							Service[i] = parseFloat(data['GraphListLS'][i]['Service']);
							TotalLS[i] = Licenses[i] + Service[i];
							if(TotalLS[i] != 0){
								CheckLS = 1;
							}
						}
						
						for (var i = 0; i < data['GraphListM'].length; i++){
							ProjectNameM[i] = data['GraphListM'][i]['ProjectName'];
							Maintenance[i] = parseFloat(data['GraphListM'][i]['Maintenance']);
							if(Maintenance[i] != 0){
								CheckMaintenance = 1;
							}
						}
						
						for (var i = 0; i < data['GraphListT'].length; i++){
							Year[i] = data['GraphListT'][i]['Year'];
							Total[i] = parseFloat(data['GraphListT'][i]['Total']);
							if(Total[i] != 0){
								var CheckTotal = 1;
							}
						}

						if(CheckMaintenance == 1){
							$('#CDMInfo').hide();
							$('#myChartCDM').show();
						}else{
							$('#CDMInfo').show();
							$('#myChartCDM').hide();
						}

						if(CheckTotal == 1){
							$('#CDTInfo').hide();
							$('#myChartCDT').show();
						}else{
							$('#CDTInfo').show();
							$('#myChartCDT').hide();
						}

						if(CheckLS == 1){
							$('#CDLSInfo').hide();
							$('#myChartCDLS').show();
						}else{
							$('#CDLSInfo').show();
							$('#myChartCDLS').hide();
						}

						var ctx = document.getElementById('myChartCDLS').getContext('2d');
						chartCDLS = new Chart(ctx, {
						    type: 'horizontalBar',
						    data: 
						    {
						        labels: ProjectNameLS,
						        datasets: [
						        	{
							            label: "Licenses",
							            backgroundColor: "#87CEFA",
							            fillColor: "#87CEFA",
							            data: Licenses
						        	},
						        	{
							            label: "Service",
							            backgroundColor: "#FFFF66",
							            fillColor: "#FFFF66",
							            data: Service
						        	},
						        	{
							            label: "Total",
							            backgroundColor: "#BCAAA4",
							            fillColor: "#BCAAA4",
							            data: TotalLS
						        	}
						        ]
						    },
						    options: {
						    	title: {
						            display: true,
						            text: 'Licenses & Service Customer Detail Report, From ' + $('#DateFrom').val() + ' To ' + $('#DateTo').val() + ' ( ' + CustomerName + ' )'
						        },
						        scales: {
						    		xAxes: [{
									    ticks: {
									        beginAtZero: true,
									        userCallback: function(value, index, values) {
									            value = value.toString();
									            value = value.split(/(?=(?:...)*$)/);
									            value = value.join(',');
									            return '$' + value;
									        }
									    }
									}]
						        },
						        animation: {
						            duration: 500,
						            easing: "easeOutQuart",
						            onComplete: function () {
						                var ctx = this.chart.ctx;
						                ctx.font = "10px sans-serif";
						                ctx.textAlign = 'center';
						                ctx.textBaseline = 'bottom';
						                this.data.datasets.forEach(function (dataset) {
						                    for (var i = 0; i < dataset.data.length; i++) {
						                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
						                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
						                        ctx.fillStyle = '#444';
						                        var y_pos = model.y +5;
						                        if ((scale_max - model.y) / scale_max >= 0.93)
						                            y_pos = model.y + 20;
						                        var newdata = dataset.data[i]; 
						                        
						                        newdata = addCommas(newdata);
						                        if(newdata == 0)
						                        	ctx.fillText("", model.x + 20, y_pos);
						                        else
						                        	ctx.fillText('$' + newdata, model.x + 20, y_pos);
						                    }
						                });               
						            }
						        }
						    },
						});

						var ctx = document.getElementById('myChartCDM').getContext('2d');
						chartCDM = new Chart(ctx, {
						    type: 'horizontalBar',
						    data: 
						    {
						        labels: ProjectNameM,
						        datasets: [
						        	{
							            label: "Maintenance",
							            backgroundColor: "#ff85a2",
							            fillColor: "#ff85a2",
							            data: Maintenance
						        	}
						        ]
						    },
						    options: {
						    	title: {
						            display: true,
						            text: 'Maintenance Customer Detail Report, From ' + $('#DateFrom').val() + ' To ' + $('#DateTo').val() + ' ( ' + CustomerName + ' )'
						        },
						        scales: {
						    		xAxes: [{
									    ticks: {
									        beginAtZero: true,
									        userCallback: function(value, index, values) {
									            value = value.toString();
									            value = value.split(/(?=(?:...)*$)/);
									            value = value.join(',');
									            return '$' + value;
									        }
									    }
									}]
						        },
						        animation: {
						            duration: 500,
						            easing: "easeOutQuart",
						            onComplete: function () {
						                var ctx = this.chart.ctx;
						                ctx.font = "10px sans-serif";
						                ctx.textAlign = 'center';
						                ctx.textBaseline = 'bottom';
						                this.data.datasets.forEach(function (dataset) {
						                    for (var i = 0; i < dataset.data.length; i++) {
						                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
						                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
						                        ctx.fillStyle = '#444';
						                        var y_pos = model.y +5;
						                        if ((scale_max - model.y) / scale_max >= 0.93)
						                            y_pos = model.y + 20;
						                        var newdata = dataset.data[i]; 
						                        newdata = addCommas(newdata);
						                        if(newdata == 0)
						                        	ctx.fillText("", model.x + 20, y_pos);
						                        else
						                        	ctx.fillText('$' + newdata, model.x - 20, y_pos);
						                        
						                    }
						                });               
						            }
						        }
						    },
						});

						var ctx = document.getElementById('myChartCDT').getContext('2d');
						chartCDT = new Chart(ctx, {
						    type: 'bar',
						    data: 
						    {
						        labels: Year,
						        datasets: [
						        	{
							            label: "Total",
							            backgroundColor: "#FFE0B2",
							            fillColor: "#FFE0B2",
							            data: Total
						        	}
						        ]
						    },
						    options: {
						    	title: {
						            display: true,
						            text: 'Year Total Customer Detail Report, From ' + $('#DateFrom').val() + ' To ' + $('#DateTo').val() + ' ( ' + CustomerName + ' )'
						        },
						        scales: {
						    		yAxes: [{
									    ticks: {
									        beginAtZero: true,
									        userCallback: function(value, index, values) {
									            value = value.toString();
									            value = value.split(/(?=(?:...)*$)/);
									            value = value.join(',');
									            return '$' + value;
									        }
									    }
									}]
						        },
						        animation: {
						            duration: 500,
						            easing: "easeOutQuart",
						            onComplete: function () {
						                var ctx = this.chart.ctx;
						                ctx.font = "10px sans-serif";
						                ctx.textAlign = 'center';
						                ctx.textBaseline = 'bottom';
						                this.data.datasets.forEach(function (dataset) {
						                    for (var i = 0; i < dataset.data.length; i++) {
						                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
						                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
						                        ctx.fillStyle = '#444';
						                        var y_pos = model.y - 2;
						                        if ((scale_max - model.y) / scale_max >= 0.93)
						                            y_pos = model.y + 20;
						                        var newdata = dataset.data[i]; 
						                        newdata = addCommas(newdata);
						                        newdata = '$' + newdata;
						                        ctx.fillText(newdata, model.x + 0, y_pos);
						                    }
						                });               
						            }
						        }
						    },
						});
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					showModal("Whoops! Something wrong", 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
	});

	$('#CustomerSGraphSC').click(function(){
		if (chartCSLS != ""){
			chartCSLS.destroy();
		}
		if (chartCSM != ""){
			chartCSM.destroy();
		}
		if (chartCST != ""){
			chartCST.destroy();
		}
		var DateFrom = $('#DateFrom').val();
		var DateTo = $('#DateTo').val();
		if(DateFrom != "")
			DateFrom = getEditFormattedDate(new Date($('#DateFrom').val()));
		if(DateTo != "")
			DateTo = getEditFormattedDate(new Date($('#DateTo').val()));

		var MonthFrom = getEditFormattedMonth(new Date($('#DateFrom').val()));
		var MonthTo = getEditFormattedMonth(new Date($('#DateTo').val()));
		var YearFrom = getEditFormattedYear(new Date($('#DateFrom').val()));
		var YearTo = getEditFormattedYear(new Date($('#DateTo').val()));
		if(DateFrom == "" || DateTo == "" ){
			alert("Date From and Date To must be filled");
			return false;
		}
		else if(YearTo < YearFrom)
		{
			alert("Year To must be greater than Year From");
			return false;
		}
		else if(MonthTo < MonthFrom && YearTo == YearFrom)
		{
			alert("Month To must be greater Month From");
			return false;
		}
		else if(CustomerName == "")
		{
			alert("Customer Name must be filled");
			return false;
		}else{
			var FilterGraphData = {
				ProjectRegion	: $('#projectRegion').val(),
				DateFrom		: DateFrom,
				DateTo			: DateTo,
				ProjectStatus 	: $('#projectStatus').val(),
		    	ContractStatus 	: $('#contractStatus').val(),
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/CSGraphSC',
				data 		: FilterGraphData,
				dataType 	: 'json',
				success:function(data){
					if(data == ""){
						$('#CSInfo').show();
						return false;
					}else {
						var CheckMaintenance = 0;
						var CheckTotal = 0;
						var CheckLS = 0;

						$('#CSInfo').hide();
						var CustomerNameLS = [];
						var Licenses = [];
						var Service = [];
						var TotalLS = [];

						var CustomerNameM = [];
						var Maintenance = [];

						var Year = [];
						var Total = [];

						for (var i = 0; i < data['GraphListLS'].length; i++){
							CustomerNameLS[i] = data['GraphListLS'][i]['CustomerName'];
							Licenses[i] = parseFloat(data['GraphListLS'][i]['Licenses']);
							Service[i] = parseFloat(data['GraphListLS'][i]['Service']);
							TotalLS[i] = Licenses[i] + Service[i];
							if(TotalLS[i] != 0){
								CheckLS = 1;
							}
						}
						
						for (var i = 0; i < data['GraphListM'].length; i++){
							CustomerNameM[i] = data['GraphListM'][i]['CustomerName'];
							Maintenance[i] = parseFloat(data['GraphListM'][i]['Maintenance']);
							if(Maintenance[i] != 0){
								CheckMaintenance = 1;
							}
						}

						for (var i = 0; i < data['GraphListT'].length; i++){
							Year[i] = data['GraphListT'][i]['Year'];
							Total[i] = parseFloat(data['GraphListT'][i]['Total']);
							if(Total[i] != 0){
								CheckTotal = 1;
							}
						}

						if(CheckMaintenance == 1){
							$('#CSMInfo').hide();
							$('#myChartCSM').show();
						}else{
							$('#CSMInfo').show();
							$('#myChartCSM').hide();
						}

						if(CheckTotal == 1){
							$('#CSTInfo').hide();
							$('#myChartCST').show();
						}else{
							$('#CSTInfo').show();
							$('#myChartCST').hide();
						}

						if(CheckLS == 1){
							$('#CSLSInfo').hide();
							$('#myChartCSLS').show();
						}else{
							$('#CSLSInfo').show();
							$('#myChartCSLS').hide();
						}

						var ctx = document.getElementById('myChartCSLS').getContext('2d');
						chartCSLS = new Chart(ctx, {
						    type: 'horizontalBar',
						    data: 
						    {
						        labels: CustomerNameLS,
						        datasets: [
						        	{
							            label: "Licenses",
							            backgroundColor: "#87CEFA",
							            fillColor: "#87CEFA",
							            data: Licenses
						        	},
						        	{
							            label: "Service",
							            backgroundColor: "#FFFF66",
							            fillColor: "#FFFF66",
							            data: Service
						        	},
						        	{
							            label: "Total",
							            backgroundColor: "#BCAAA4",
							            fillColor: "#BCAAA4",
							            data: TotalLS
						        	}
						        ]
						    },
						    options: {
						    	title: {
						            display: true,
						            text: 'Licenses & Service Customer Summary Report, From ' + $('#DateFrom').val() + ' To ' + $('#DateTo').val()
						        },
						        scales: {
						    		xAxes: [{
									    ticks: {
									        beginAtZero: true,
									        userCallback: function(value, index, values) {
									            value = value.toString();
									            value = value.split(/(?=(?:...)*$)/);
									            value = value.join(',');
									            return '$' + value;
									        }
									    }
									}]
						        },
						        animation: {
						            duration: 500,
						            easing: "easeOutQuart",
						            onComplete: function () {
						                var ctx = this.chart.ctx;
						                ctx.font = "10px sans-serif";
						                ctx.textAlign = 'center';
						                ctx.textBaseline = 'bottom';
						                this.data.datasets.forEach(function (dataset) {
						                    for (var i = 0; i < dataset.data.length; i++) {
						                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
						                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
						                        ctx.fillStyle = '#444';
						                        var y_pos = model.y +5;
						                        if ((scale_max - model.y) / scale_max >= 0.93)
						                            y_pos = model.y + 20;
						                        var newdata = dataset.data[i]; 
						                        
						                        newdata = addCommas(newdata);
						                        if(newdata == 0)
						                        	ctx.fillText("", model.x + 20, y_pos);
						                        else
						                        	ctx.fillText('$' + newdata, model.x + 20, y_pos);
						                    }
						                });               
						            }
						        }
						    },
						});

						var ctx = document.getElementById('myChartCSM').getContext('2d');
						chartCSM = new Chart(ctx, {
						    type: 'horizontalBar',
						    data: 
						    {
						        labels: CustomerNameM,
						        datasets: [
						        	{
							            label: "Maintenance",
							            backgroundColor: "#ff85a2",
							            fillColor: "#ff85a2",
							            data: Maintenance
						        	}
						        ]
						    },
						    options: {
						    	title: {
						            display: true,
						            text: 'Maintenance Customer Summary Report, From ' + $('#DateFrom').val() + ' To ' + $('#DateTo').val()
						        },
						        scales: {
						    		xAxes: [{
									    ticks: {
									        beginAtZero: true,
									        userCallback: function(value, index, values) {
									            value = value.toString();
									            value = value.split(/(?=(?:...)*$)/);
									            value = value.join(',');
									            return '$' + value;
									        }
									    }
									}]
						        },
						        animation: {
						            duration: 500,
						            easing: "easeOutQuart",
						            onComplete: function () {
						                var ctx = this.chart.ctx;
						                ctx.font = "10px sans-serif";
						                ctx.textAlign = 'center';
						                ctx.textBaseline = 'bottom';
						                this.data.datasets.forEach(function (dataset) {
						                    for (var i = 0; i < dataset.data.length; i++) {
						                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
						                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
						                        ctx.fillStyle = '#444';
						                        var y_pos = model.y +5;
						                        if ((scale_max - model.y) / scale_max >= 0.93)
						                            y_pos = model.y + 20;
						                        var newdata = dataset.data[i]; 
						                        newdata = addCommas(newdata);
						                        if(newdata == 0)
						                        	ctx.fillText("", model.x + 20, y_pos);
						                        else
						                        	ctx.fillText('$' + newdata, model.x - 20, y_pos);
						                        
						                    }
						                });               
						            }
						        }
						    },
						});

						var ctx = document.getElementById('myChartCST').getContext('2d');
						chartCST = new Chart(ctx, {
						    type: 'bar',
						    data: 
						    {
						        labels: Year,
						        datasets: [
						        	{
							            label: "Total",
							            backgroundColor: "#FFE0B2",
							            fillColor: "#FFE0B2",
							            data: Total
						        	}
						        ]
						    },
						    options: {
						    	title: {
						            display: true,
						            text: 'Year Total Customer Summary Report, From ' + $('#DateFrom').val() + ' To ' + $('#DateTo').val() 
						        },
						        scales: {
						    		yAxes: [{
									    ticks: {
									        beginAtZero: true,
									        userCallback: function(value, index, values) {
									            value = value.toString();
									            value = value.split(/(?=(?:...)*$)/);
									            value = value.join(',');
									            return '$' + value;
									        }
									    }
									}]
						        },
						        animation: {
						            duration: 500,
						            easing: "easeOutQuart",
						            onComplete: function () {
						                var ctx = this.chart.ctx;
						                ctx.font = "10px sans-serif";
						                ctx.textAlign = 'center';
						                ctx.textBaseline = 'bottom';
						                this.data.datasets.forEach(function (dataset) {
						                    for (var i = 0; i < dataset.data.length; i++) {
						                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
						                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
						                        ctx.fillStyle = '#444';
						                        var y_pos = model.y - 2;
						                        if ((scale_max - model.y) / scale_max >= 0.93)
						                            y_pos = model.y + 20;
						                        var newdata = dataset.data[i]; 
						                        newdata = addCommas(newdata);
						                        newdata = '$' + newdata;
						                        ctx.fillText(newdata, model.x + 0, y_pos);
						                    }
						                });               
						            }
						        }
						    },
						});
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					showModal("Whoops! Something wrong", 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
	});

	$('#buttonSubmitSalesContract').click(function(){
		if ($('#DateFrom').val() == "" ? $('#DateTo').val() != "" : $('#DateTo').val() == ""){
			showModal("Filter Date from and Date to must be fill", 0);
			return false;
		}
		$('#tableSalesContract').hide();
		$('.loader').show();;
		var DateFrom = $('#DateFrom').val();
		var OriginalDateFrom = $('#DateFrom').val();
		var DateTo = $('#DateTo').val();
		var OriginalDateTo = $('#DateTo').val();
		if(DateFrom != "")
			DateFrom = getEditFormattedDate(new Date($('#DateFrom').val()));
		if(DateTo != "")
			DateTo = getEditFormattedDate(new Date($('#DateTo').val()));

		var FilterSalesContractData = {
			ProjectRegion	: $('#projectRegion').val(),
			DateFrom		: DateFrom,
			DateTo			: DateTo,
			ProjectStatus 	: $('#projectStatus').val(),
	    	ContractStatus 	: $('#contractStatus').val(),
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/FilterSalesContract',
			data 		: FilterSalesContractData,
			dataType 	: 'json',
			success:function(data){
				var RegionName = [];
				var LicenseTotal = [];
				var MaintenanceTotal = [];
				var ServiceTotal = [];
				var TravelExpenseTotal = [];
				for(var i=0; i<data['TotalRegionSalesContract'].length; i++){
					RegionName[i] = data['TotalRegionSalesContract'][i].RegionName;
					if(data['TotalRegionSalesContract'][i].Licenses == null )
						LicenseTotal[i] = 0;
					else
						LicenseTotal[i] = (parseFloat(data['TotalRegionSalesContract'][i].Licenses).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

					if(data['TotalRegionSalesContract'][i].TravelExpense == null )
						TravelExpenseTotal[i] = 0;
					else
						TravelExpenseTotal[i] = (parseFloat(data['TotalRegionSalesContract'][i].TravelExpense).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

					if(data['TotalRegionSalesContract'][i].Maintenance == null )
						MaintenanceTotal[i] = 0;
					else
						MaintenanceTotal[i] = (parseFloat(data['TotalRegionSalesContract'][i].Maintenance)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
					
					if(data['TotalRegionSalesContract'][i].Service == null )
						ServiceTotal[i] = 0;
					else
						ServiceTotal[i] = (parseFloat(data['TotalRegionSalesContract'][i].Service)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
				$('#tableSalesContract').html(data['returnHTML']);
				$('.loader').hide();
				$('#tableSalesContract').show();
				$('#salesContractTable').DataTable({
					dom: 'Bfrtip',
					lengthMenu: [
			            [ 10, 25, 50, -1 ],
			            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
			        ],
					
					buttons: [{extend:'pageLength',text: '<span>Show Page</span>'},	 {
			            extend: 'excelHtml5',
			            text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
			            customize: function (xlsx) {
			                var sheet 	= xlsx.xl.worksheets['sheet1.xml'];
			                var numrows = 7 + RegionName.length;
			                var clR 	= $('row', sheet);
			                clR.each(function () {
			                    var attr 	= $(this).attr('r');
			                    var ind 	= parseInt(attr);
			                    ind 		= ind + numrows;
			                    $(this).attr("r",ind);
			                });
			                $('row c ', sheet).each(function () {
			                    var attr 	= $(this).attr('r');
			                    var pre 	= attr.substring(0, 1);
			                    var ind 	= parseInt(attr.substring(1, attr.length));
			                    ind 		= ind + numrows;
			                    $(this).attr("r", pre + ind);
			                });
			                function Addrow(index,data) {
			                    msg='<row r="'+index+'">'
			                    for(i=0;i<data.length;i++){
			                        var key=data[i].key;
			                        var value=data[i].value;
			                        msg 	+= '<c t="inlineStr" r="' + key + index + '">';
			                        msg 	+= '<is>';
			                        msg 	+=  '<t>'+value+'</t>';
			                        msg		+=  '</is>';
			                        msg		+= '</c>';
			                    }
			                    msg += '</row>';
			                    return msg;
			                }
			                var Title1 = Addrow(1, [{ key: 'A', value: 'Sales Contract Report'}]);
			                if(DateFrom == ""){
			                	var Title2 = Addrow(2, [{ key: 'A', value: 'Period : All' }]);	
			                } else {
			                	var Title2 = Addrow(2, [{ key: 'A', value: 'Period ' + OriginalDateFrom + ' to ' + OriginalDateTo }]);
			                }
			                var regionExcel = [];
			                for(var k=0; k< RegionName.length; k++)
			                {
			                	regionExcel[k] = Addrow(6+k, [
			                						{ key: 'A', value: RegionName[k] },
			                						{ key: 'B', value: MaintenanceTotal[k] },
			                						{ key: 'C', value: ServiceTotal[k] },
			                						{ key: 'D', value: LicenseTotal[k] },
			                						{ key: 'E', value: TravelExpenseTotal[k] }
			                					]);
			                }

			               	var TotalLicenses = (parseFloat(data['TotalSalesContract'][0]['Licenses'])).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			               	var TotalService = (parseFloat(data['TotalSalesContract'][0]['Service'])).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			               	var TotalMaintenance = (parseFloat(data['TotalSalesContract'][0]['Maintenance'])).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			               	var TotalTravelExpense = (parseFloat(data['TotalSalesContract'][0]['TravelExpense'])).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			               	var Title3 = Addrow(3, [{ key: 'A', value: $('#SalesContractLastUpdate').text() }]);
							var Blank1 = Addrow(4, [{ key: 'A', value: '' }]);
							var TotalTitle = Addrow(5, [
												{ key: 'A', value: 'Region' },
												{ key: 'B', value: 'Maintenance (USD)' },
												{ key: 'C', value: 'Service (USD)' },
												{ key: 'D', value: 'License (USD)' },
												{ key: 'E', value: 'TravelExpense (USD)' }
											]);
							var AllTotal = Addrow(numrows-1, [
												{ key: 'A', value: 'Total' },
												{ key: 'B', value: TotalMaintenance},
												{ key: 'C', value: TotalService},
												{ key: 'D', value: TotalLicenses},
												{ key: 'E', value: TotalTravelExpense}
											]);

							var temp = sheet.childNodes[0].childNodes[1].innerHTML;
							sheet.childNodes[0].childNodes[1].innerHTML = Title1 + Title2 + Title3 + TotalTitle;
							for(var j=0; j< regionExcel.length; j++)
			                {	
			                	sheet.childNodes[0].childNodes[1].innerHTML += regionExcel[j];
			                }
			                sheet.childNodes[0].childNodes[1].innerHTML += AllTotal + temp;
			            }
			        } ],
			        "footerCallback": function ( row, data, start, end, display ) {
			            var api = this.api(), data;
			            var intVal = function ( i ) {
			                return typeof i === 'string' ?
			                    i.replace(/[\$,]/g, '')*1 :
			                    typeof i === 'number' ?
			                        i : 0;
			            };
			            pageTotal_8 = api
			                .column( 8, { page: 'current'} )
			                .data()
			                .reduce( function (a, b) {
			                    return intVal(a) + intVal(b);
			            }, 0 );
		                pageTotal_9 = api
			                .column( 9, { page: 'current'} )
			                .data()
			                .reduce( function (a, b) {
			                    return intVal(a) + intVal(b);
			            }, 0 );
			            pageTotal_10 = api
			                .column( 10, { page: 'current'} )
			                .data()
			                .reduce( function (a, b) {
			                    return intVal(a) + intVal(b);
			            }, 0 );
			            pageTotal_11 = api
			                .column( 11, { page: 'current'} )
			                .data()
			                .reduce( function (a, b) {
			                    return intVal(a) + intVal(b);
			            }, 0 );    
		              
			            $( api.column( 8 ).footer() ).html(
			                parseFloat((pageTotal_8 )).toFixed(1).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
			            );
			            $( api.column( 9 ).footer() ).html(
			                parseFloat((pageTotal_9 )).toFixed(1).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
			            );
			            $( api.column( 10 ).footer() ).html(
			                parseFloat((pageTotal_10 )).toFixed(1).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
			            );	
			            $( api.column( 11 ).footer() ).html(
			                parseFloat((pageTotal_11 )).toFixed(1).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
			            );			            
			        }
				}); 
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});
	
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

	function showModal(data, status){
		$('#LoadingModal').modal('hide');
		if (status == 1){
			$('#ModalHeader').html('<i class="fa fa-check-circle" aria-hidden="true" style="font-size:24px;color:green"></i> Notification');
			$('#ModalContent').html(data);
		} else {
			$('#ModalHeader').html('<i class="fa fa-times-circle" aria-hidden="true" style="font-size:24px;color:red"></i> Notification');
			$('#ModalContent').html(data);
		}
		$('#hahaha').show();
		$('#Modal').modal(); 
	}

	$('#btnAlright').click(function() {
		$('#Modal').modal('hide');
	});
		
	$('#btnOKCS').click(function() {
		$('#GraphCustomerSummary').modal('hide');
	});

	$('#btnOKCD').click(function() {
		$('#GraphCustomerDetail').modal('hide');
	});

	$('#btnOKMCN').click(function() {
		$('#ModalCustomerName').modal('hide');
	});

	$('#btnOKDetail').click(function() {
		$('#GraphDetail').modal('hide');
	});

	$('#btnOKSummary').click(function() {
		$('#GraphSummary').modal('hide');
	});

	$('#btnOKRegion').click(function() {
		$('#GraphRegion').modal('hide');
	});

});