$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	$('#divLoading').hide();
	 
	$('#buttonSubmitFilterOccupation').click(function(){
		var valid;
		var ReportType = $("input:radio[name=reportType]:checked").val();
		var TableType = $("input:radio[name=TableType]:checked").val();
		var date = $('#PeriodUtilization').val();
		var regex_Summary_Detail = /\d{4}(1[0-2]|0[1-9])/;
		var regex_Quarterly = /\d{4}(1[0-2]|Q[1-4])/;
		if(ReportType == "Quarterly"){
			var isValidQuarterly = regex_Quarterly.test(date);
			valid = isValidQuarterly;
		} else {
			var isValidDate = regex_Summary_Detail.test(date);
			valid = isValidDate;
		}
		var SplitYear = date.substring(0, 4);
		if(ReportType == "Quarterly"){
			var Month = date.substring(5, 6);
		} else {
			var Month = date.substring(4, 6);
		}
		if(ReportType == null) {
			showModal("Report type must be chosen", 0);
			return false;
		} else if(date.length > 6){
			showModal("Period can't be greater than 6 characters", 0);
			return false;
		} else if (!valid) {
			showModal("Wrong " + ReportType + " period, please re-type", 0);
			return false;
		} else if(TableType == null) {
			showModal("Table type must be chosen", 0);
			return false;
		}else {
			$('#divLoading').show();
			$('#tableUtilization').hide();
			var FilterData = {
				Month 		: Month,
				Year 		: date,
				ReportType 	: ReportType,
				TableType	: TableType
			};
			$.ajax({
				type: 'POST',
				url: '/FilterTableOccupation',
				data: FilterData,
				dataType: 'json',
				success:function(data){
					$('#divLoading').hide();
					$('#tableUtilization').show();
					if(TableType == "Detail") {
						$('#tableUtilization').css("width", "100%");
						$('#tableUtilization').css("margin", "0 auto");
						$('#tableUtilization').html(data['returnHTML']);
						$('#utilizationTable').DataTable({
							lengthMenu: [
					            [ 10, 25, 50, -1 ],
					            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
					        ],
							"columnDefs": [     
								{ "width": "5%", "targets": 0 },
								{ "width": "5%", "targets": 1 },
								{ "width": "15%", "targets": 2 },
								{ "width": "5%", "targets": 3 },
								{ "width": "5%", "targets": 4 },
								{ "width": "5%", "targets": 5 },
								{ "width": "5%", "targets": 6 },
								{ "width": "5%", "targets": 7 },
								{ "width": "5%", "targets": 8 },
								{ "width": "5%", "targets": 9 },         
								{ "width": "5%", "targets": 10 },
								{ "width": "5%", "targets": 11 }
							],
							dom: 'Bfrtip',
							buttons: [ {extend:'pageLength',text: '<span>Show Page</span>'},{
					            extend: 'excelHtml5',
					            text 	: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
					            title 	: 'OWA Occupation Detail Report ' + getEditFormattedDate(currentTime),
					            customize: function (xlsx) {
					                var sheet 	= xlsx.xl.worksheets['sheet1.xml'];
					                var numrows = 11;
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
					                        msg		+='</c>';
					                    }
					                    msg += '</row>';
					                    return msg;
					                }
					                var NewFormatDate = new Date(Month + '-' + '01-' +  SplitYear);
					                var Title1 = Addrow(1, [{ key: 'A', value: 'OWA Occupation ' + ReportType + ' Report' }]);
					                if( ReportType == "Ytd" ) {
					                	var Title2 = Addrow(2, [{ key: 'A', value: 'as per YTD ' +  formatDate(NewFormatDate) }]);
					                } else if( ReportType == "Monthly" ) {
					                	var Title2 = Addrow(2, [{ key: 'A', value: 'as per ' +  formatDate(NewFormatDate) }]);
					                } else {
					                	var Title2 = Addrow(2, [{ key: 'A', value: 'as per Quartal ' +  Month }]);
					                }
					                /* for(var i=0; i<data['ListRegion'].length; i++) {
										console.log(data['ListRegion'][i]['RegionName']);
									}*/
									var r = [];
									var Blank1 = Addrow(3, [{ key: 'A', value: '' }]);
									var r1 = Addrow(4, [{ key: 'A', value: 'Region' }, { key: 'B', value: 'FTE' }, { key: 'C', value: '%Chargeability' }, { key: 'D', value: '%Utilization' }]);
									var Lastrow;
									for(var j=0; j<data['ListRegion'].length; j++) {
										r[j]= Addrow(j+5, [{ key: 'A', value: data['ListRegion'][j]['RegionName']}, { key: 'B', value: $('#FTEDetail'+data['ListRegion'][j]['RegionName']).text() }, { key: 'C', value: $('#ChargeDetail'+data['ListRegion'][j]['RegionName']).text() }, { key: 'D', value: $('#UtilizationDetail'+data['ListRegion'][j]['RegionName']).text() } ]);
										Lastrow = j + 5;
									}
					                var rAsia = Addrow(Lastrow + 1, [{ key: 'A', value: 'Asia'}, { key: 'B', value: $('#FTEDetailAsia').text() }, { key: 'C', value: $('#ChargeDetailAsia').text() }, { key: 'D', value: $('#UtilizationDetailAsia').text() } ]);
					                var sheetdata = sheet.childNodes[0].childNodes[1].innerHTML;
					                var Blank2 = Addrow(Lastrow + 2, [{ key: 'A', value: '' }]);
					                sheet.childNodes[0].childNodes[1].innerHTML = Title1 + Title2 + Blank1 + r1;
					                for(var j=0; j<data['ListRegion'].length; j++) {
										sheet.childNodes[0].childNodes[1].innerHTML += r[j];
									}
					                sheet.childNodes[0].childNodes[1].innerHTML += rAsia + sheetdata;  
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
					            pageTotal_3 = api
					                .column( 3, { page: 'current'} )
					                .data()
					                .reduce( function (a, b) {
					                    return intVal(a) + intVal(b);
					            }, 0 );
				                pageTotal_4 = api
					                .column( 4, { page: 'current'} )
					                .data()
					                .reduce( function (a, b) {
					                    return intVal(a) + intVal(b);
					            }, 0 );
					            pageTotal_5 = api
					                .column( 5, { page: 'current'} )
					                .data()
					                .reduce( function (a, b) {
					                    return intVal(a) + intVal(b);
					            }, 0 );
					            pageTotal_6 = api
					                .column( 6, { page: 'current'} )
					                .data()
					                .reduce( function (a, b) {
					                    return intVal(a) + intVal(b);
					            }, 0 );
					            pageTotal_7 = api
					                .column( 7, { page: 'current'} )
					                .data()
					                .reduce( function (a, b) {
					                    return intVal(a) + intVal(b);
					            }, 0 );
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
					            $( api.column( 3 ).footer() ).html(
					                parseFloat((pageTotal_3 * 100) / 100).toFixed(2)
					            );
					            $( api.column( 4 ).footer() ).html(
					                parseFloat((pageTotal_4 * 100) / 100).toFixed(2)
					            );
					            $( api.column( 5 ).footer() ).html(
					                parseFloat((pageTotal_5 * 100) / 100).toFixed(2)
					            );
					            $( api.column( 6 ).footer() ).html(
					                parseFloat((pageTotal_6 * 100) / 100).toFixed(2)
					            );
					            $( api.column( 7 ).footer() ).html(
					                parseFloat((pageTotal_7 * 100) / 100).toFixed(2)
					            );
					            $( api.column( 8 ).footer() ).html(
					                parseFloat((pageTotal_8 * 100) / 100).toFixed(1)
					            );
					            $( api.column( 9 ).footer() ).html(
					                parseFloat((pageTotal_9 * 100) / 100).toFixed(1)
					            );
					            if( ReportType == "Monthly" ) {
					            	$( api.column( 10 ).footer() ).html(
						            	parseFloat((( ((pageTotal_3+pageTotal_4) / ( 18.75 ) ) / pageTotal_9 ) * 100)).toFixed(1) + '%'
						            );
						            $( api.column( 11 ).footer() ).html(
						            	parseFloat(( ( ( (pageTotal_3 + pageTotal_4 + pageTotal_5 + pageTotal_6 + pageTotal_8) / ( 18.75 ) ) / pageTotal_9) * 100)).toFixed(1) + '%'    
						            );
					            } else if( ReportType == "Ytd" ) {
					            	$( api.column( 10 ).footer() ).html(
						            	parseFloat((( ((pageTotal_3 + pageTotal_4) / ( 18.75 * Month ) ) / pageTotal_9 ) * 100)).toFixed(1) + '%'
						            );
						            $( api.column( 11 ).footer() ).html(
						            	parseFloat(( ( ( (pageTotal_3 + pageTotal_4 + pageTotal_5 + pageTotal_6 + pageTotal_8) / ( 18.75 * Month ) ) / pageTotal_9) * 100)).toFixed(1) + '%'    
						            );
					            } else {
					            	$( api.column( 10 ).footer() ).html(
						            	parseFloat((( ((pageTotal_3 + pageTotal_4) / ( 18.75 * 3 ) ) / pageTotal_9 ) * 100)).toFixed(1) + '%'
						            );
						            $( api.column( 11 ).footer() ).html(
						            	parseFloat(( ( ( (pageTotal_3 + pageTotal_4 + pageTotal_5 + pageTotal_6 + pageTotal_8) / ( 18.75 * 3) ) / pageTotal_9) * 100)).toFixed(1) + '%'    
						            );
					            }
					        }
						});
					} else {
						$('#tableUtilization').css("width", "50%");
						$('#tableUtilization').css("margin", "0 auto");
						$('#tableUtilization').html(data['returnHTML']);
						$('#utilizationTable').DataTable({
							lengthMenu: [
					            [ 10, 25, 50, -1 ],
					            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
					        ],
							dom: 'Bfrtip',
							buttons: [ {extend:'pageLength',text: '<span>Show Page</span>'},{
					            extend: 'excelHtml5',
					            text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
					            title 	: 'OWA Occupation Summary Report ' + getEditFormattedDate(currentTime),
					            customize: function (xlsx) {
					                var sheet 	= xlsx.xl.worksheets['sheet1.xml'];
					                var numrows = 11;
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
					                        msg		+='</c>';
					                    }
					                    msg += '</row>';
					                    return msg;
					                }

					                var NewFormatDate = new Date(Month + '-' + '01-' +  SplitYear);
					                var Title1 = Addrow(1, [{ key: 'A', value: 'OWA Occupation ' + ReportType + ' Report' }]);
					                if( ReportType == "Ytd" ) {
					                	var Title2 = Addrow(2, [{ key: 'A', value: 'as per YTD ' +  formatDate(NewFormatDate) }]);
					                } else if( ReportType == "Monthly" ) {
					                	var Title2 = Addrow(2, [{ key: 'A', value: 'as per ' +  formatDate(NewFormatDate) }]);
					                } else {
					                	var Title2 = Addrow(2, [{ key: 'A', value: 'as per Quartal ' +  Month }]);
					                }
					                /* for(var i=0; i<data['ListRegion'].length; i++) {
										console.log(data['ListRegion'][i]['RegionName']);
									}*/
									var r = [];
									var Blank1 = Addrow(3, [{ key: 'A', value: '' }]);
									var r1 = Addrow(4, [{ key: 'A', value: 'Region' }, { key: 'B', value: 'FTE' }, { key: 'C', value: '%Chargeability' }, { key: 'D', value: '%Utilization' }]);
									var Lastrow;
									for(var j=0; j<data['ListRegion'].length; j++) {
										r[j]= Addrow(j+5, [{ key: 'A', value: data['ListRegion'][j]['RegionName']}, { key: 'B', value: $('#FTESummary'+data['ListRegion'][j]['RegionName']).text() }, { key: 'C', value: $('#ChargeSummary'+data['ListRegion'][j]['RegionName']).text() }, { key: 'D', value: $('#UtilizationSummary'+data['ListRegion'][j]['RegionName']).text() } ]);
										Lastrow = j + 5;
									}
					                var rAsia = Addrow(Lastrow + 1, [{ key: 'A', value: 'Asia'}, { key: 'B', value: $('#FTESummaryAsia').text() }, { key: 'C', value: $('#ChargeSummaryAsia').text() }, { key: 'D', value: $('#UtilizationSummaryAsia').text() } ]);
					                var sheetdata = sheet.childNodes[0].childNodes[1].innerHTML;
					                var Blank2 = Addrow(Lastrow + 2, [{ key: 'A', value: '' }]);
					                sheet.childNodes[0].childNodes[1].innerHTML = Title1 + Title2 + Blank1 + r1;
					                for(var j=0; j<data['ListRegion'].length; j++) {
										sheet.childNodes[0].childNodes[1].innerHTML += r[j];
									}
					                sheet.childNodes[0].childNodes[1].innerHTML += rAsia + sheetdata;  
					            }
					        } ],
						});
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#divLoading').hide();
					showModal("Whoops! Something wrong", 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});

		}
	});


	$('#Info1').hide();
	$('#Info2').hide();
	var currentTime = new Date();
		 
	$(".rButton").click(function(){
		var ReportType = $("input:radio[name=reportType]:checked").val();
		if(ReportType == "Quarterly"){
			$('#Info2').show();
			$('#Info1, #DefaultInfo').hide();
		} else {
			$('#Info1').show();
			$('#Info2, #DefaultInfo').hide();	
		}
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

		  return monthNames[monthIndex] + ' ' + year;
	}

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return year + month + day ;
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