$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	refreshTableHistoryOvertime();

	function getFormatDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return year + '-' + month + '-' + day;
	}

	$('#submitFilterDate').click(function() {
		var DateFrom = $('#filterDateFrom').val();
		var Tanggal = DateFrom.split("/");
		DateFrom = getFormatDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));

		var DateTo = $('#filterDateTo').val();
		var Tanggal = DateTo.split("/");
		DateTo = getFormatDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));

		if ($('#filterDateFrom').val() == "" ? $('#filterDateTo').val() != "" : $('#filterDateTo').val() == ""){
			showModal('Filter Date from and Date to must be fill', 0);
			return false;
		}else if($('#filterDateFrom').val() == "" && $('#filterDateTo').val() == ""){
			showModal('Filter Date from and Date to must be fill', 0);
			return false;
		}
		$('#tableOvertimeHistory').hide();
		$('#divLoading').show();
		var OvertimeFilterData = {
			DateFrom 	: DateFrom,
			DateTo 		: DateTo
		}
		console.log (DateFrom + DateTo);
		return false;
		$.ajax({
			type 		: 'POST',
			url 		: '/FilterDateHistoryOvertime',
			data 		: OvertimeFilterData,
			dataType 	: 'json',
			success:function(data){
				refreshTableHistoryOvertime();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#divLoading').hide();
				$('#tableOvertimeHistory').show();
				showModal("Whoops Something Wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	function refreshTableHistoryOvertime() {
		$('#tableOvertimeHistory').hide();
		$('#divLoading').show();
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableHistoryOvertime',
			dataType 	: 'json',
			success:function(data){
				$('#tableOvertimeHistory').html(data);
				$('#divLoading').hide();
				$('#tableOvertimeHistory').show();
				$('#overtimeHistoryTable').DataTable({   
					"columnDefs": [         
						{ "width": "15%", "targets":1 },
						{ "width": "15%", "targets":2 },
						{ "width": "15%", "targets":3 },
						{ "width": "5%", "targets":4 },
						{ "width": "30%", "targets":5 },
						{ "width": "5%", "targets":6 },	
						{ "width": "15%", "targets":7 }
					],
					"order": [[2, 'asc']],
					scrollX 		: true,
					scrollCollapse 	: true,
					dom: 'Bfrtip',
					lengthMenu: [
					[ 10, 25, 50, -1 ],
					[ '10 rows', '25 rows', '50 rows', 'Show all' ]
					],
					buttons: [{extend:'pageLength',text: '<span>Show Page</span>'},	 {
						extend: 'excelHtml5',
						title: 'Overtime History',
						text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
						footer: true
					} ] 
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#divLoading').hide();
				$('#tableOvertimeHistory').show();
				showModal("Whoops Something Wrong", 0);
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