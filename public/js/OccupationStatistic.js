$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var chartOccupation = "";

	$('#Info1').hide();
	$('#Info2').hide();
	$('.loader').hide();	 
	$(".rButton").click(function(){
		var ReportType = $("input:radio[name=reportType]:checked").val();
		if(ReportType == "Quarterly"){
			$('#DefaultInfo').hide();
			$('#Info2').show();
			$('#Info1').hide();
		} else {
			$('#Info1').show();
			$('#Info2').hide();	
			$('#DefaultInfo').hide();
		}
	});
	$('#SelectEmployeeName').attr("disabled","disabled");
	$('#SelectEmployeeName').val("");
	$('#OccupationStatisticRegion').change(function(){
		if($('#OccupationStatisticRegion').val() == "Asia" || $('#OccupationStatisticRegion').val() == "All" || $('#OccupationStatisticRegion').val() == "AllID" || $('#OccupationStatisticRegion').val() == "AllMY" || $('#OccupationStatisticRegion').val() == "AllVN" || $('#OccupationStatisticRegion').val() == "AllTH"){
			$('#SelectEmployeeName').val("");
			$('#EmployeeID').val("");
			$('#SelectEmployeeName').attr("disabled","disabled");
		} else {
			$('#SelectEmployeeName').val("None");
			$('#SelectEmployeeName').removeAttr("disabled");
			var GetEmployee = {
				RegionID	: $('#OccupationStatisticRegion').val()
			};
			$.ajax({
				type: 'POST',
				url: '/ShowEmployee',
				data: GetEmployee,
				dataType: 'json',
				success:function(data){
					$('#SelectEmployeeName').html("");
					$('#SelectEmployeeName').append('<option value="None">Select</option>');
					var j = data.length;
					for (var i = 0; i < j; i++){
						$('#SelectEmployeeName').append('<option value="'+data[i]['EmployeeID']+'">'+data[i]['EmployeeName']+'</option>');
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
	$('#SelectEmployeeName').change(function(){
		if($('#SelectEmployeeName').val() == "None")
			$('#EmployeeID').val("");
		else	
			$('#EmployeeID').val($('#SelectEmployeeName').val());
	});

	$('#buttonSubmitOccupationStatistic').click(function(){
		if (chartOccupation != ""){
			chartOccupation.destroy();
		}
		var valid;
		var ReportType = $("input:radio[name=reportType]:checked").val();
		var date = $('#PeriodOccupationStatistic').val();
		var Region = $('#OccupationStatisticRegion').val();
		var EmployeeID = $('#SelectEmployeeName').val();
		var regex_Summary_Detail = /\d{4}(1[0-2]|0[1-9])/;
		var regex_Quarterly = /\d{4}(1[0-2]|Q[1-4])/;
		var SplitYear = date.substring(0, 4);
		if(ReportType == "Quarterly"){
			var isValidQuarterly = regex_Quarterly.test(date);
			valid = isValidQuarterly;
		} else {
			var isValidDate = regex_Summary_Detail.test(date);
			valid = isValidDate;
		}
		var Month = date.substring(4, 6);

		console.log(date);

		if(date.length > 6){
			showModal("Period can't be greater than 6 characters", 0);
			return false;
		} else if (!valid ) {
			showModal("Wrong " + ReportType + " period, please re-type", 0);
			return false;
		} else if(ReportType == null) {
			showModal("Report type must be chosen", 0);
			return false;
		} else {
			$('.loader').show();
			$('#columnchart').hide();
			var FilterDataColumnChart = {
				Region 		: Region,
				EmployeeID	: EmployeeID,
				Month : Month,
				date : date,
				ReportType : ReportType
			};
			$.ajax({
				type: 'POST',
				url: '/ShowColumnChart',
				data: FilterDataColumnChart,
				dataType: 'json',
				success:function(data){
					if(data == ""){
						showModal("No Data",0);
						$('.loader').hide();
					} else {
						var LabelName = [];
						var Chargeability = [];
						var Utilization = [];
						for (var i = 0; i < data.length; i++){
							if(Region == "All" || Region == "Asia" || EmployeeID == "None"){
								LabelName[i] = data[i]['RegionName'];
							}else if(EmployeeID != "None")
								LabelName[i] = data[i]['EmployeeName'];		

							Chargeability[i] = parseFloat(data[i]['Chargeability']);
							Utilization[i] = parseFloat(data[i]['Utilization']);
						}
						
						if(Region != "Asia"){
							if(LabelName[0] == null){
								showModal("No Data",0);
								$('.loader').hide();
								return false;
							}	
						}

						if(ReportType == "Ytd")
							if(EmployeeID == "None")
								var Judul = "Occupation YTD Report, " + GetMonthName(new Date(Month + '-' + '01-' + SplitYear)) + ' ( ' + Region + ' Region )';
							else if(EmployeeID == null)
								var Judul = " Occupation YTD Report, " + GetMonthName(new Date(Month + '-' + '01-' + SplitYear)) + ' ( ' + Region + ' Region )';
							else 
								var Judul = LabelName[0] + " Occupation YTD Report, " + GetMonthName(new Date(Month + '-' + '01-' + SplitYear)) + ' ( ' + Region + ' Region )';
						else if(ReportType == "Monthly")
							if(EmployeeID == "None")
								var Judul = "Occupation Monthly Report, " + GetMonthName(new Date(Month + '-' + '01-' + SplitYear)) + ' ( ' + Region + ' Region )';
							else if(EmployeeID == null)
								var Judul = "Occupation Monthly Report, " + GetMonthName(new Date(Month + '-' + '01-' + SplitYear)) + ' ( ' + Region + ' Region )';
							else
								var Judul = LabelName[0] + " Occupation Monthly Report, " + GetMonthName(new Date(Month + '-' + '01-' + SplitYear));
						else
							if(EmployeeID == "None")
								var Judul = "Occupation Quarterly Report, " + date + ' ( ' + Region + ' Region )';
							else if(EmployeeID == null)
								var Judul = "Occupation Quarterly Report, " + date + ' ( ' + Region + ' Region )';
							else
								var Judul = LabelName[0] + " Occupation Quarterly Report, " + date

						$('.loader').hide();
						var ctx = document.getElementById('MyChart').getContext('2d');
						chartOccupation = new Chart(ctx, {
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
						            text: Judul,
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
									        }
									    }
						            }],
						            xAxes: [{
						            	ticks: {
									        fontSize:14
									    }
						            }]
						        },
						        legend: {
								    display: true,
						            labels: {
						                fontSize:14
						            }
								},
						        tooltips: {
					                enabled: true,
					                mode: 'single',
					                callbacks: {
					                    label: function(tooltipItems, data){
					                        return tooltipItems.xLabel + '%';
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
						    },
						});
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('.loader').hide();
					showModal("Whoops! Something wrong", 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
	});

	function GetMonthName(date) {
		var monthNames = [
		    "January", "February", "March",
		    "April", "May", "June", "July",
		    "August", "September", "October",
		    "November", "December"
		];
		var day = date.getDate();
		var monthIndex = date.getMonth();
		var year = date.getFullYear();
		return monthNames[monthIndex] + ' ' + year;
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