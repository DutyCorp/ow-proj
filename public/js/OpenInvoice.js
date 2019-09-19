$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#divLoading').hide();

	var chartDetail = "";
	var chartSummary = "";
	var chartRegion = "";
	var chartCSLS = "";
	var chartCSM = "";
	var chartCST = "";
	var chartCDLS = "";
	var chartCDM = "";
	var chartCDT = "";

	$('#CustomerSGraphIP').click(function(){
		$('#CSTInfo').hide();
		$('#CSLSInfo').hide();
		$('#CSMInfo').hide();
		if (chartCSLS != ""){
			chartCSLS.destroy();
		}
		if (chartCSM != ""){
			chartCSM.destroy();
		}
		if (chartCST != ""){
			chartCST.destroy();
		}

		var DateFrom = $('#PeriodFrom').val();
		var DateTo = $('#PeriodTo').val();
		if(DateFrom != "")
			DateFrom = getEditFormattedDate(new Date($('#PeriodFrom').val()));
		if(DateTo != "")
			DateTo = getEditFormattedDate(new Date($('#PeriodTo').val()));
		var MonthFrom = getEditFormattedMonth(new Date($('#PeriodFrom').val()));
		var MonthTo = getEditFormattedMonth(new Date($('#PeriodTo').val()));
		var YearFrom = getEditFormattedYear(new Date($('#PeriodFrom').val()));
		var YearTo = getEditFormattedYear(new Date($('#PeriodTo').val()));
		if(DateFrom == "" || DateTo == "" ){
			showModal("Period From and Date To must be filled",0);
			return false;
		}
		else if(YearTo < YearFrom)
		{
			showModal("Year To must be greater than Year From",0);
			return false;
		}
		else if(MonthTo < MonthFrom && YearTo == YearFrom)
		{
			showModal("Month To must be greater Month From",0);
			return false;
		}else{
			var FilterGraphData = {
				ProjectRegion	: $('#selectInvoiceRegion').val(),
				DateFrom		: DateFrom,
				DateTo			: DateTo,
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/CSGraphIP',
				data 		: FilterGraphData,
				dataType 	: 'json',
				success:function(data){
					var CheckLS = 0;
					var CheckMaintenance = 0;
					var CheckTotal = 0;

					var CNameLS = [];
					var License = [];
					var Service = [];
					var TotalLS = [];

					var CNameM = [];
					var Maintenance = [];

					var Year = [];
					var Total = [];

					for (var i = 0; i < data['GraphListT'].length; i++){
						Year[i] = data['GraphListT'][i]['Year'];
						Total[i] = parseInt(data['GraphListT'][i]['Total']);
						if(Total[i] != 0){
							CheckTotal = 1;
						}
					}

					for (var i = 0; i < data['GraphListLS'].length; i++){
						CNameLS[i] = data['GraphListLS'][i]['CName'];
						License[i] = parseInt(data['GraphListLS'][i]['License']);
						Service[i] = parseInt(data['GraphListLS'][i]['Service']);
						TotalLS[i] = License[i] + Service[i];
						if(TotalLS[i] != 0){
							CheckLS = 1;
						}
					}

					for (var i = 0; i < data['GraphListM'].length; i++){
						CNameM[i] = data['GraphListM'][i]['CName'];
						Maintenance[i] = parseInt(data['GraphListM'][i]['Maintenance']);
						if(Maintenance[i] != 0){
							CheckMaintenance = 1;
						}
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

					if(CheckMaintenance == 1){
						$('#CSMInfo').hide();
						$('#myChartCSM').show();
					}else{
						$('#CSMInfo').show();
						$('#myChartCSM').hide();
					}

					var ctx = document.getElementById('myChartCST').getContext('2d');
					chartCST = new Chart(ctx, {
					    type: 'bar',
					    data: 
					    {
					        labels: Year,
					        datasets: [
					        	{
						            label: "Total",
						            backgroundColor: "#ff85a2",
						            fillColor: "#ff85a2",
						            data: Total
					        	}
					        ]
					    },
					    options: {
					    	title: {
					            display: true,
					            text: 'Open Invoice Customer Summary Report, From ' + $('#PeriodFrom').val() + ' To ' + $('#PeriodTo').val() + ' ( ' + $('#selectInvoiceRegion').val() + ' Region )'
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
					                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, '5', Chart.defaults.global.defaultFontFamily);
					                ctx.textAlign = 'center';
					                ctx.textBaseline = 'bottom';
					                this.data.datasets.forEach(function (dataset) {
					                    for (var i = 0; i < dataset.data.length; i++) {
					                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
					                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
					                        ctx.fillStyle = '#444';
					                        var y_pos = model.y ;
					                        if ((scale_max - model.y) / scale_max >= 0.93)
					                            y_pos = model.y + 20;
					                        var newdata = dataset.data[i]; 
					                        
					                        if(newdata == 0)
					                        	ctx.fillText("", model.x, y_pos);
					                        else{
					                        	newdata = addCommas(newdata);
					                        	ctx.fillText('$' + newdata, model.x, y_pos);
					                        }
					                        	
					                    }
					                });               
					            }
					        }
					    },
					});

					var ctx = document.getElementById('myChartCSLS').getContext('2d');
					chartCSLS = new Chart(ctx, {
					    type: 'horizontalBar',
					    data: 
					    {
					        labels: CNameLS,
					        datasets: [
					        	{
						            label: "License",
						            backgroundColor: "#87CEFA",
						            fillColor: "#87CEFA",
						            data: License
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
					            text: 'Open Invoice Customer Summary Report, From ' + $('#PeriodFrom').val() + ' To ' + $('#PeriodTo').val() + ' ( ' + $('#selectInvoiceRegion').val() + ' Region )'
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
					                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, '5', Chart.defaults.global.defaultFontFamily);
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
					                        
					                        if(newdata == 0)
					                        	ctx.fillText("", model.x + 25, y_pos);
					                        else{
					                        	newdata = addCommas(newdata);
					                        	ctx.fillText('$' + newdata, model.x + 25, y_pos);
					                        }
					                        	
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
					        labels: CNameM,
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
					            text: 'Open Invoice Customer Summary Report, From ' + $('#PeriodFrom').val() + ' To ' + $('#PeriodTo').val() + ' ( ' + $('#selectInvoiceRegion').val() + ' Region )'
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
					                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, '5', Chart.defaults.global.defaultFontFamily);
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
					                        
					                        if(newdata == 0)
					                        	ctx.fillText("", model.x + 25, y_pos);
					                        else{
					                        	newdata = addCommas(newdata);
					                        	ctx.fillText('$' + newdata, model.x + 25, y_pos);
					                        }
					                        	
					                    }
					                });               
					            }
					        }
					    },
					});
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

	$('#CustomerDGraphIP').click(function(){
		$('#CDTInfo').hide();
		$('#CDLSInfo').hide();
		$('#CDMInfo').hide();
		if (chartCSLS != ""){
			chartCSLS.destroy();
		}
		if (chartCSM != ""){
			chartCSM.destroy();
		}
		if (chartCST != ""){
			chartCST.destroy();
		}

		var DateFrom = $('#PeriodFrom').val();
		var DateTo = $('#PeriodTo').val();
		if(DateFrom != "")
			DateFrom = getEditFormattedDate(new Date($('#PeriodFrom').val()));
		if(DateTo != "")
			DateTo = getEditFormattedDate(new Date($('#PeriodTo').val()));

		var MonthFrom = getEditFormattedMonth(new Date($('#PeriodFrom').val()));
		var MonthTo = getEditFormattedMonth(new Date($('#PeriodTo').val()));
		var YearFrom = getEditFormattedYear(new Date($('#PeriodFrom').val()));
		var YearTo = getEditFormattedYear(new Date($('#PeriodTo').val()));
		var CustomerName = $('#CustomerName').val();
		if(DateFrom == "" || DateTo == "" ){
			showModal("Period From and Date To must be filled",0);
			return false;
		}
		else if(YearTo < YearFrom)
		{
			showModal("Year To must be greater than Year From",0);
			return false;
		}
		else if(MonthTo < MonthFrom && YearTo == YearFrom)
		{
			showModal("Month To must be greater Month From",0);
			return false;
		}
		else if(CustomerName == "")
		{
			showModal("Customer Name must be filled");
			return false;
		}else{
			var FilterGraphData = {
				ProjectRegion	: $('#selectInvoiceRegion').val(),
				DateFrom		: DateFrom,
				DateTo			: DateTo,
				CustomerName 	: CustomerName
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/CDGraphIP',
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

						var CheckLS = 0;
						var CheckMaintenance = 0;
						var CheckTotal = 0;

						var CNameLS = [];
						var License = [];
						var Service = [];
						var TotalLS = [];

						var CNameM = [];
						var Maintenance = [];

						var Year = [];
						var Total = [];

						for (var i = 0; i < data['GraphListT'].length; i++){
							Year[i] = data['GraphListT'][i]['Year'];
							Total[i] = parseInt(data['GraphListT'][i]['Total']);
							if(Total[i] != 0){
								CheckTotal = 1;
							}
						}

						for (var i = 0; i < data['GraphListLS'].length; i++){
							CNameLS[i] = data['GraphListLS'][i]['CName'];
							License[i] = parseInt(data['GraphListLS'][i]['License']);
							Service[i] = parseInt(data['GraphListLS'][i]['Service']);
							TotalLS[i] = License[i] + Service[i];
							if(TotalLS[i] != 0){
								CheckLS = 1;
							}
						}

						for (var i = 0; i < data['GraphListM'].length; i++){
							CNameM[i] = data['GraphListM'][i]['CName'];
							Maintenance[i] = parseInt(data['GraphListM'][i]['Maintenance']);
							if(Maintenance[i] != 0){
								CheckMaintenance = 1;
							}
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

						if(CheckMaintenance == 1){
							$('#CDMInfo').hide();
							$('#myChartCDM').show();
						}else{
							$('#CDMInfo').show();
							$('#myChartCDM').hide();
						}

						var ctx = document.getElementById('myChartCDT').getContext('2d');
						chartCDT = new Chart(ctx, {
						    type: 'bar',
						    data: 
						    {
						        labels: Year,
						        datasets: [
						        	{
							            label: "Total",
							            backgroundColor: "#ff85a2",
							            fillColor: "#ff85a2",
							            data: Total
						        	}
						        ]
						    },
						    options: {
						    	title: {
						            display: true,
						            text: 'Open Invoice Customer Detail Report, From ' + $('#PeriodFrom').val() + ' To ' + $('#PeriodTo').val() + ' ( ' + $('#selectInvoiceRegion').val() + ' Region )'
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
						                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, '5', Chart.defaults.global.defaultFontFamily);
						                ctx.textAlign = 'center';
						                ctx.textBaseline = 'bottom';
						                this.data.datasets.forEach(function (dataset) {
						                    for (var i = 0; i < dataset.data.length; i++) {
						                        var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
						                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
						                        ctx.fillStyle = '#444';
						                        var y_pos = model.y ;
						                        if ((scale_max - model.y) / scale_max >= 0.93)
						                            y_pos = model.y + 20;
						                        var newdata = dataset.data[i]; 
						                        
						                        if(newdata == 0)
						                        	ctx.fillText("", model.x, y_pos);
						                        else{
						                        	newdata = addCommas(newdata);
						                        	ctx.fillText('$' + newdata, model.x, y_pos);
						                        }
						                        	
						                    }
						                });               
						            }
						        }
						    },
						});

						var ctx = document.getElementById('myChartCDLS').getContext('2d');
						chartCDLS = new Chart(ctx, {
						    type: 'horizontalBar',
						    data: 
						    {
						        labels: CNameLS,
						        datasets: [
						        	{
							            label: "License",
							            backgroundColor: "#87CEFA",
							            fillColor: "#87CEFA",
							            data: License
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
						            text: 'Open Invoice Customer Detail Report, From ' + $('#PeriodFrom').val() + ' To ' + $('#PeriodTo').val() + ' ( ' + $('#selectInvoiceRegion').val() + ' Region )'
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
						                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, '5', Chart.defaults.global.defaultFontFamily);
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
						                        
						                        if(newdata == 0)
						                        	ctx.fillText("", model.x + 25, y_pos);
						                        else{
						                        	newdata = addCommas(newdata);
						                        	ctx.fillText('$' + newdata, model.x + 25, y_pos);
						                        }
						                        	
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
						        labels: CNameM,
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
						            text: 'Open Invoice Customer Detail Report, From ' + $('#PeriodFrom').val() + ' To ' + $('#PeriodTo').val() + ' ( ' + $('#selectInvoiceRegion').val() + ' Region )'
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
						                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, '5', Chart.defaults.global.defaultFontFamily);
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
						                        
						                        if(newdata == 0)
						                        	ctx.fillText("", model.x + 25, y_pos);
						                        else{
						                        	newdata = addCommas(newdata);
						                        	ctx.fillText('$' + newdata, model.x + 25, y_pos);
						                        }
						                        	
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

	$('#SummaryGraphIP').click(function(){
		$('#SummaryInfo').hide();
		$('#SummaryG').hide();
		if (chartSummary != ""){
			chartSummary.destroy();
		}
		var DateFrom = $('#PeriodFrom').val();
		var DateTo = $('#PeriodTo').val();
		if(DateFrom != "")
			DateFrom = getEditFormattedDate(new Date($('#PeriodFrom').val()));
		if(DateTo != "")
			DateTo = getEditFormattedDate(new Date($('#PeriodTo').val()));

		var MonthFrom = getEditFormattedMonth(new Date($('#PeriodFrom').val()));
		var MonthTo = getEditFormattedMonth(new Date($('#PeriodTo').val()));
		var YearFrom = getEditFormattedYear(new Date($('#PeriodFrom').val()));
		var YearTo = getEditFormattedYear(new Date($('#PeriodTo').val()));
		if(DateFrom == "" || DateTo == "" ){
			showModal("Period From and Date To must be filled",0);
			return false;
		}
		else if(YearTo < YearFrom)
		{
			showModal("Year To must be greater than Year From",0);
			return false;
		}
		else if(MonthTo < MonthFrom && YearTo == YearFrom)
		{
			showModal("Month To must be greater Month From",0);
			return false;
		}
		var FilterGraphData = {
			ProjectRegion	: $('#selectInvoiceRegion').val(),
			DateFrom		: DateFrom,
			DateTo			: DateTo,
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/SummaryGraphIP',
			data 		: FilterGraphData,
			dataType 	: 'json',
			success:function(data){
				if(data == "") {
					$('#SummaryInfo').show();
					$('#SummaryG').hide();
				} else {
					$('#SummaryInfo').hide();
					$('#SummaryG').show();
					var month = [];
					var Total = [];
					for (var i = 0; i < data.length; i++){
						month[i] = data[i]['Date'];
						Total[i] = parseInt(data[i]['Total']);
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
					            text: 'Open Invoice Summary Report, From ' + $('#PeriodFrom').val() + ' To ' + $('#PeriodTo').val() + ' ( ' + $('#selectInvoiceRegion').val() + ' Region )'
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
					                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, '5', Chart.defaults.global.defaultFontFamily);
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
					                        
					                        if(newdata == 0)
					                        	ctx.fillText("", model.x + 25, y_pos);
					                        else{
					                        	newdata = addCommas(newdata);
					                        	ctx.fillText('$' + newdata, model.x + 25, y_pos);
					                        }
					                        	
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
	});

	$('#DetailGraphIP').click(function(){
		$('#DetailInfo').hide();
		$('#DetailG').hide();
		
		if (chartDetail != ""){
			chartDetail.destroy();
		}
		var DateFrom = $('#PeriodFrom').val();
		var DateTo = $('#PeriodTo').val();
		if(DateFrom != "")
			DateFrom = getEditFormattedDate(new Date($('#PeriodFrom').val()));
		if(DateTo != "")
			DateTo = getEditFormattedDate(new Date($('#PeriodTo').val()));

		var MonthFrom = getEditFormattedMonth(new Date($('#PeriodFrom').val()));
		var MonthTo = getEditFormattedMonth(new Date($('#PeriodTo').val()));
		var YearFrom = getEditFormattedYear(new Date($('#PeriodFrom').val()));
		var YearTo = getEditFormattedYear(new Date($('#PeriodTo').val()));
		if(DateFrom == "" || DateTo == "" ){
			showModal("Period From and Date To must be filled",0);
			return false;
		}
		else if(YearTo < YearFrom)
		{
			showModal("Year To must be greater than Year From",0);
			return false;
		}
		else if(MonthTo < MonthFrom && YearTo == YearFrom)
		{
			showModal("Month To must be greater Month From",0);
			return false;
		}
		var FilterGraphData = {
			ProjectRegion	: $('#selectInvoiceRegion').val(),
			DateFrom		: DateFrom,
			DateTo			: DateTo,
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/DetailGraphIP',
			data 		: FilterGraphData,
			dataType 	: 'json',
			success:function(data){
				if(data == ""){
					$('#DetailG').hide();
					$('#DetailInfo').show();
					return false;
				} else {
					$('#DetailInfo').hide();
					$('#DetailG').show();
					var month = [];
					var Licenses = [];
					var Maintenance = [];
					var Service = [];
					for (var i = 0; i < data.length; i++){
						month[i] = data[i]['Date'];
						Licenses[i] = parseInt(data[i]['License']);
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
						            label: "Service",
						            backgroundColor: "#ff85a2",
						            fillColor: "#ff85a2",
						            data: Service
					        	},
					        	{
						            label: "Maintenance",
						            backgroundColor: "#FFFF66",
						            fillColor: "#FFFF66",
						            data: Maintenance
					        	}
					        ]
					    },
					    options: {
					    	title: {
					            display: true,
					            text: 'Open Invoice Detail Report, From ' + $('#PeriodFrom').val() + ' To ' + $('#PeriodTo').val() + ' ( ' + $('#selectInvoiceRegion').val() + ' Region )'
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
					                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, '5', Chart.defaults.global.defaultFontFamily);
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
					                        if(newdata == 0){
					                        	ctx.fillText("", model.x + 25, y_pos);
					                        }else{
					                        	newdata = addCommas(newdata);
					                        	ctx.fillText('$' + newdata, model.x + 25, y_pos);
					                        }
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
	});

	$('#RegionGraphIP').click(function(){
		$('#RegionInfo').hide();
		$('#RegionG').hide();
		if (chartRegion != ""){
			chartRegion.destroy();
		}
		var DateFrom = $('#PeriodFrom').val();
		var DateTo = $('#PeriodTo').val();
		if(DateFrom != "")
			DateFrom = getEditFormattedDate(new Date($('#PeriodFrom').val()));
		if(DateTo != "")
			DateTo = getEditFormattedDate(new Date($('#PeriodTo').val()));

		var MonthFrom = getEditFormattedMonth(new Date($('#PeriodFrom').val()));
		var MonthTo = getEditFormattedMonth(new Date($('#PeriodTo').val()));
		var YearFrom = getEditFormattedYear(new Date($('#PeriodFrom').val()));
		var YearTo = getEditFormattedYear(new Date($('#PeriodTo').val()));
		if(DateFrom == "" || DateTo == "" ){
			showModal("Period From and Date To must be filled",0);
			return false;
		}
		else if(YearTo < YearFrom)
		{
			showModal("Year To must be greater than Year From",0);
			return false;
		}
		else if(MonthTo < MonthFrom && YearTo == YearFrom)
		{
			showModal("Month To must be greater Month From",0);
			return false;
		}
		var FilterGraphData = {
			ProjectRegion	: $('#selectInvoiceRegion').val(),
			DateFrom		: DateFrom,
			DateTo			: DateTo,
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/RegionGraphIP',
			data 		: FilterGraphData,
			dataType 	: 'json',
			success:function(data){
				if(data == ""){
					$('#RegionInfo').show();
					$('#RegionG').hide();	
				} else {
					$('#RegionInfo').hide();
					$('#RegionG').show();	
					var RegionName = [];
					var Licenses = [];
					var Maintenance = [];
					var Service = [];
					for (var i = 0; i < data.length; i++){
						RegionName[i] = data[i]['RegionID'];
						Licenses[i] = parseInt(data[i]['Licenses']);
						Service[i] = parseInt(data[i]['Service']);
						Maintenance[i] = parseInt(data[i]['Maintenance']);
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
						            label: "Service",
						            backgroundColor: "#ff85a2",
						            fillColor: "#ff85a2",
						            data: Service
					        	},
					        	{
						            label: "Maintenance",
						            backgroundColor: "#FFFF66",
						            fillColor: "#FFFF66",
						            data: Maintenance
					        	}
					        ]
					    },
					    options: {
					    	title: {
					            display: true,
					            text: 'Open Invoice Region Report, From ' + $('#PeriodFrom').val() + ' To ' + $('#PeriodTo').val() + ' ( ' + $('#selectInvoiceRegion').val() + ' Region )'
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
					                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, '5', Chart.defaults.global.defaultFontFamily);
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
					                        if(newdata == 0)
					                        	ctx.fillText("", model.x + 25, y_pos);
					                        else
					                        	ctx.fillText('$' +newdata, model.x + 25, y_pos);
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
	});

	$('#btnSubmitOpenInvoice').click(function() {
		if ($('#PeriodFrom').val() != "" || $('#PeriodTo').val() != ""){
			if ($('#PeriodFrom').val() == "" ? $('#PeriodTo').val() != "" : $('#PeriodTo').val() == ""){
				showModal('Period Date From or Period Date To must be filled!', 0);
				return false;
			}
		}
		$('#divLoading').show();
		$('#tableOpenInvoice').hide();
		var Region = $('#selectInvoiceRegion').val();
		if ($('#PeriodFrom').val() == "") {
			var PeriodFrom = $('#PeriodFrom').val();
		} else {
			var PeriodFrom = getEditFormattedDate(new Date($('#PeriodFrom').val()));
		}
		if ($('#PeriodTo').val() == "") {
			var PeriodTo = $('#PeriodTo').val();
		} else {
			var PeriodTo = getEditFormattedDate(new Date($('#PeriodTo').val()));
		}
		
		var InvoicedProgressData = {
			Region: Region,
			PeriodFrom: PeriodFrom,
			PeriodTo: PeriodTo
		}
		$.ajax({
			type: 'POST',
			url: '/GetOpenInvoiceData',
			data: InvoicedProgressData,
			dataType: 'json',
			success:function(data){
				var RegionName = [];
				var LicenseTotal = [];
				var MaintenanceTotal = [];
				var ServiceTotal = [];
				for(var i=0; i<data['RegionTotal'].length; i++){
					RegionName[i] = data['RegionTotal'][i].RegionID;
					if(data['RegionTotal'][i].Licenses == null )
						LicenseTotal[i] = 0;
					else
						LicenseTotal[i] = (parseFloat(data['RegionTotal'][i].Licenses).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

					if(data['RegionTotal'][i].Maintenance == null )
						MaintenanceTotal[i] = 0;
					else
						MaintenanceTotal[i] = (parseFloat(data['RegionTotal'][i].Maintenance)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
					
					if(data['RegionTotal'][i].Service == null )
						ServiceTotal[i] = 0;
					else
						ServiceTotal[i] = (parseFloat(data['RegionTotal'][i].Service)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
				$('#tableOpenInvoice').html(data['returnHTML']);
				$('#tableOpenInvoice').show();
				$('#OpenInvoiceTable').DataTable({
					dom: 'Bfrtip',
					buttons: [ {extend:'pageLength',text: '<span>Show Page</span>'},{
			            extend: 'excelHtml5',
			            text 	: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
			            title 	: 'Open Invoice Report',	
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
			                var Title1 = Addrow(1, [{ key: 'A', value: 'Open Invoice Report'}]);
			                if($('#PeriodFrom').val() == ""){
			                	var Title2 = Addrow(2, [{ key: 'A', value: 'Period : All' }]);	
			                } else {
			                	var Title2 = Addrow(2, [{ key: 'A', value: 'Period ' + $('#PeriodFrom').val() + ' To ' + $('#PeriodTo').val() }]);
			                }
			                var regionExcel = [];
			                for(var k=0; k< RegionName.length; k++)
			                {
			                	regionExcel[k] = Addrow(6+k, [{ key: 'A', value: RegionName[k] }, { key: 'B', value: MaintenanceTotal[k] }, { key: 'C', value: ServiceTotal[k] }, { key: 'D', value: LicenseTotal[k] }]);
			                }
			               	
			               	var Title3 = Addrow(3, [{ key: 'A', value: $('#OpenInvoiceLastUpdate').text() }]);
							var Blank1 = Addrow(4, [{ key: 'A', value: '' }]);
							var TotalHeader = Addrow(5, [{ key: 'A', value: 'Region' }, { key: 'B', value: 'License ( USD )' }, { key: 'C', value: 'Service ( USD )' }, { key: 'D', value: 'Maintenance ( USD )' }]);
							var TotalAll = Addrow(numrows-1, [{ key: 'A', value: 'Total' }, { key: 'B', value: $('#License').text() }, { key: 'C', value: $('#Service').text() }, { key: 'D', value: $('#Maintenance').text() }]);
							
							var temp = sheet.childNodes[0].childNodes[1].innerHTML;

			                sheet.childNodes[0].childNodes[1].innerHTML = Title1 + Title2 + Title3 + Blank1 + TotalHeader ;
			                for(var j=0; j< regionExcel.length; j++)
			                {	
			                	sheet.childNodes[0].childNodes[1].innerHTML += regionExcel[j];
			                }
			                sheet.childNodes[0].childNodes[1].innerHTML +=  TotalAll + temp;
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
			            $( api.column( 8 ).footer() ).html(
			                parseFloat((pageTotal_8 )).toFixed(1).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
			            );
			            $( api.column( 9 ).footer() ).html(
			                parseFloat((pageTotal_9 )).toFixed(1).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
			            );
			            $( api.column( 10 ).footer() ).html(
			                parseFloat((pageTotal_10 )).toFixed(1).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
			            );
			        }
				});	
				$('#divLoading').hide();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#divLoading').hide();
				showModal('Whoops! Something wrong', 0);
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

	function showModal(data, status){
		$('#LoadingModal').modal('hide');
		if (status == 1){
			$('#ModalHeader').html('<i class="fa fa-check-circle" aria-hidden="true" style="font-size:24px;color:green"></i> Notification');
			$('#ModalContent').html(data);
		} else {
			$('#ModalHeader').html('<i class="fa fa-times-circle" aria-hidden="true" style="font-size:24px;color:red"></i> Notification');
			$('#ModalContent').html(data);
		}
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

	$('#btnOKSummary').click(function() {
		$('#GraphSummary').modal('hide');
	});

	$('#btnOKDetail').click(function() {
		$('#GraphDetail').modal('hide');
	});

	$('#btnOKRegion').click(function() {
		$('#GraphRegion').modal('hide');
	});
});