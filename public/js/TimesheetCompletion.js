$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var FileDate;
	var currentTime = new Date();
	var WorkingDayList = [];

	$('#EditHours').hide();
	$('#SubmitEditBtn').hide();
	$('#EditEmployee').hide();

	function refreshDropdownEmployee(){
		$('#selectEmployee').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownTC',
			dataType: 'json',
			success:function(data){
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#selectEmployee').append('<option value="'+data[i]['EmployeeID']+'">'+data[i]['EmployeeName']+'</option>');
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

	$('.WorkingDay').each(function(){
		$('#' + $(this).attr("id")).val("0");
		WorkingDayList.push($(this).attr("id"));
	});
	
	$('#SubmitEditBtn').click(function(){
		if ( $('#EditEmployeeHours').val() == "0" || $('#EditEmployeeHours').val() == "" ) {
			showModal("Working Hours must be filled", 0);
			return false;
		}
		var EditTimesheetCompletion = {
			EmployeeID  : $('#selectEmployee').val(),
			Hours 		: $('#EditEmployeeHours').val()
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/UpdateTWH',
			data 		: EditTimesheetCompletion,
			dataType 	: 'json',
			success:function(data){
				refreshTableTimeSheet();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});
	
	$('#SubmitFileBtn').click(function() {
		if($('#IDWorkingDay').val() == "0" || $('#THWorkingDay').val() == "0" || $('#MYWorkingDay').val() == "0" || $('#VNWorkingDay').val() == "0" ) {
			showModal("All working day must be greater than 0", 0);
			return false;
		}
		$('#LoadingModal').modal({
		  	backdrop 	: 'static',
		  	keyboard 	: false
		}); 
		var ListRegion = [];
		var TimesheetData = new FormData();
		TimesheetData.append('TimesheetExcelData', 	$('#UploadFileTimeSheetCompletion').get(0).files[0]);
		for(var g = 0; g < WorkingDayList.length; g++){
			var tempRegion = WorkingDayList[g][0] + WorkingDayList[g][1];
			ListRegion.push(tempRegion);
			TimesheetData.append( tempRegion, $('#' + tempRegion + 'TotalWorkingHours').val());
		}
		TimesheetData.append('ListRegion', ListRegion);
		$.ajax({
			type 		: 'POST',
			url 		: '/UploadTimeSheetData',
			data 		: TimesheetData,
			processData : false,
  			contentType : false,
			dataType 	: 'json',
			success:function(data){
				FileDate = data['FileDate'];
				if(data['Status'] == "0")
					showModal("Success Upload Timesheet Completion ", 1);
				else
					showModal("Success Upload Timesheet Completion<br><br>This employee below are now in employee list<br><br>" + data['MissMatchEmployee'].join("<br>") + "<br><br>Please insert into your employee list", 1);
				$('#EditHours').show();
				$('#SubmitEditBtn').show();
				$('#EditEmployee').show();
				refreshDropdownEmployee();
				refreshTableTimeSheet();			
				$('#LoadingModal').modal('hide');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('.WorkingDay').change(function(){
		var temp = $(this).attr("id");
		if( $('#' + temp).val() == "" )
			$('#' + temp).val("0");
		else if( $('#' + temp).val() != "" )
			$('#' + temp[0] + temp[1] +'TotalWorkingHours').val($('#' + temp).val() * 8);
	});

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

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return  day + '-' + month + '-' + year;
	}

	function refreshTableTimeSheet() {
		$('#table').html("");
		$.ajax({
			type 	 	: 'POST',
			url 	 	: '/ShowTableTimesheet',
			dataType 	: 'json',
			success:function(data){
				$('#table').html(data);
				$('#TimesheetCompletionTable').DataTable({
					dom: 'Bfrtip',
					lengthMenu: [
			            [ 10, 25, 50, -1 ],
			            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
			        ],
					buttons: [{extend:'pageLength',text: '<span>Show Page</span>'},	 {
			            extend 	: 'excelHtml5',
			            title 	: 'Timesheet Completion ' + getEditFormattedDate(currentTime),
			            text 	: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
			            customize: function (xlsx) {
			                var sheet 	= xlsx.xl.worksheets['sheet1.xml'];
			                var numrows = 3;
			                var clR 	= $('row', sheet);
			                //update Row
			                clR.each(function () {
			                    var attr 	= $(this).attr('r');
			                    var ind 	= parseInt(attr);
			                    ind 		= ind + numrows;
			                    $(this).attr("r",ind);
			                });
			                // Create row before data
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
			                var r1 = Addrow(1, [{ key: 'C', value: 'Timesheet Completion ' + FileDate }]);
			                var r2 = Addrow(2, [{ key: 'C', value: 'Export : ' + getEditFormattedDate(currentTime) }]);
			                sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + sheet.childNodes[0].childNodes[1].innerHTML;
			            }
			        } ]
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