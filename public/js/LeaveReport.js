$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#leaveTable').DataTable({
		"lengthMenu": [[50, -1], [50, "All"]],
		dom: 'Bfrtip',
		buttons: [ {
            extend: 'excelHtml5',
            text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>'
        } ],
	});

	$('#LastUpdate').hide();

	$('#tableLeave').hide();

	$('#LeaveDateFrom').datepicker({
		autoClose : true,
	});

	$('#LeaveDateTo').datepicker({
		autoClose : true
	});

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		return year + month;
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

	$('#LeaveDateFrom').focusout(function(){
		$('#LeaveDateTo').val($('#LeaveDateFrom').val());
	});

	$('#LeaveDateTo').focusout(function(){
		var MonthFrom = getEditFormattedMonth(new Date($('#LeaveDateFrom').val()));
		var MonthTo = getEditFormattedMonth(new Date($('#LeaveDateTo').val()));
		var YearFrom = getEditFormattedYear(new Date($('#LeaveDateFrom').val()));
		var YearTo = getEditFormattedYear(new Date($('#LeaveDateTo').val()));
		if(MonthTo < MonthFrom || YearTo != YearFrom)
		{
			showModal("Month must be greater month from , and in the same year", 0);
			$('#LeaveDateTo').val($('#LeaveDateFrom').val());
		}
	});

	$('#LeaveSubmitFilter').click(function(){
		var From = getMonthFromString(new Date($('#LeaveDateFrom').val()));
		var To = getMonthFromString(new Date($('#LeaveDateTo').val()));
		var Region = $('#LeaveRegion').val();
		if($('#LeaveDateFrom').val() == "" && $('#LeaveDateTo').val() == ""){
			showModal("Month from and to must be filled", 0);
			return false;
		}
		DataLeaveFilter = {
			Region 	: Region
		}
		$.ajax({
			type: 'POST',
			url: '/FilterLeaveReport',
			data: DataLeaveFilter,
			dataType: 'json',
			success:function(data){
				$('#LastUpdate').show();
				table = $('#leaveTable').DataTable();
				table.clear().draw();
				var ann = 0.00, abs = 0.00; total = 0.00;
				for (var i = 0; i < data.length; i++){
					if (data[i+1] !== undefined){
						if(data[i]['EmployeeName'] == data[i+1]['EmployeeName']){
							if (data[i]['ProjectName'].indexOf('Vacation') >= 0){
								for (var j = From; j <= To; j++){
									ann = parseFloat(ann) + parseFloat(data[i][''+j+'']);
								}
								j = 0;
								for (j = From; j <= To; j++){
									abs = parseFloat(abs) + parseFloat(data[i+1][''+j+'']);
								}
							} else if (data[i]['ProjectName'].indexOf('Absences') >= 0){
								for (var j = From; j <= To; j++){
									ann = parseFloat(ann) + parseFloat(data[i+1][''+j+'']);
								}
								j = 0;
								for (j = From; j <= To; j++){
									abs = parseFloat(abs) + parseFloat(data[i][''+j+'']);
								}
							}
							total = parseFloat(abs) + parseFloat(ann);
							table.rows.add(
						       [[ data[i]['RegionName'], data[i]['EmployeeName'], ann.toFixed(2), abs.toFixed(2), total.toFixed(2)]]
						    ).draw(); 
							ann = 0.00; abs = 0.00; total = 0.00;
						} else {
							if (data[i-1] !== undefined){
								if(data[i]['EmployeeName'] != data[i-1]['EmployeeName']){
									if (data[i]['ProjectName'].indexOf('Vacation') >= 0){
										for (var j = From; j <= To; j++){
											ann = parseFloat(ann) + parseFloat(data[i][''+j+'']);
										}
										j = 0;
									} else if (data[i]['ProjectName'].indexOf('Absences') >= 0){
										for (j = From; j <= To; j++){
											abs = parseFloat(abs) + parseFloat(data[i][''+j+'']);
										}
										j = 0;
									}
									total = parseFloat(abs) + parseFloat(ann);
									table.rows.add(
								       [[ data[i]['RegionName'], data[i]['EmployeeName'], ann.toFixed(2), abs.toFixed(2), total.toFixed(2)]]
								    ).draw(); 
									ann = 0.00; abs = 0.00; total = 0.00;
								}
							} else {
								if (data[i]['ProjectName'].indexOf('Vacation') >= 0){
									for (var j = From; j <= To; j++){
										ann = parseFloat(ann) + parseFloat(data[i][''+j+'']);
									}
									j = 0;
								} else if (data[i]['ProjectName'].indexOf('Absences') >= 0){
									for (j = From; j <= To; j++){
										abs = parseFloat(abs) + parseFloat(data[i][''+j+'']);
									}
									j = 0;
								}
								total = parseFloat(abs) + parseFloat(ann);
								table.rows.add(
							       [[ data[i]['RegionName'], data[i]['EmployeeName'], ann.toFixed(2), abs.toFixed(2), total.toFixed(2)]]
							    ).draw(); 
								ann = 0.00; abs = 0.00; total = 0.00;
							}
						}
					} else {
						if(data[i]['EmployeeName'] != data[i-1]['EmployeeName']){
							if (data[i]['ProjectName'].indexOf('Vacation') >= 0){
								for (var j = From; j <= To; j++){
									ann = parseFloat(ann) + parseFloat(data[i][''+j+'']);
								}
								j = 0;
							} else if (data[i]['ProjectName'].indexOf('Absences') >= 0){
								for (j = From; j <= To; j++){
									abs = parseFloat(abs) + parseFloat(data[i][''+j+'']);
								}
								j = 0;
							}
							total = parseFloat(abs) + parseFloat(ann);
							table.rows.add(
						       [[ data[i]['RegionName'], data[i]['EmployeeName'], ann.toFixed(2), abs.toFixed(2), total.toFixed(2)]]
						    ).draw(); 
							ann = 0.00; abs = 0.00; total = 0.00;
						}
					}
				}
				$('#tableLeave').show();
				$('td').each(function(){
					$(this).css("padding", "3px 10px 1px");
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
		$('#leaveTable').DataTable();
	});

	function getMonthFromString(date){
	   	var month = (1 + date.getMonth()).toString();
	   	month = month.length > 1 ? month : month;
	   	return month;
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