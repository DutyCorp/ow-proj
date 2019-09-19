$(document).ready(function(){
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
		return day + '/' + month + '/' + year;
	}

	$('#tableOvertime tbody').on('click', '.ChooseDeleteOvertime', function (e) {
		var OvertimeID = $(this).val();
		showModalNotification("Delete Overtime");
		$('#YesDelete').click(function() {
			$('#Modal_Notification').modal('hide');
			submitDeleteOvertime(OvertimeID);
		});
		$('#NoDelete').click(function() {
			$('#Modal_Notification').modal('hide');
		});
     } );

	$('#tableOvertime tbody').on('click', '.ChooseEditOvertime', function (e) {
        submitEditOvertime($(this).val());
     } );

	function ClearOvertimeForm() {
		$('#selectOvertimeType').val("None");
		$('#selectEmployeeName').val("None");
		$('#selectManagerName').val("None");
		$('#selectDate').val("");
		$('#entryNotes').val("");
		$('#EmployeeID').val("");
		$('#ManagerID').val("");
		$('#buttonUpdateOvertime, #buttonCancelOvertime').hide();
		$('#buttonSubmitOvertime, #buttonClearOvertime').show();
		$('#selectEmployeeName').removeAttr("disabled");
	}

	function submitEditOvertime(ID_Edit){
		var OvertimeData = {
			OvertimeID: ID_Edit
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/EditOverTime',
			data 		: OvertimeData,
			dataType 	: 'json',
			success:function(data){
				$('#buttonSubmitOvertime, #buttonClearOvertime').hide();
				$('#buttonUpdateOvertime, #buttonCancelOvertime').show();
				$('#selectEmployeeName').attr("disabled","disabled");
				$('#selectOvertimeType').val(data[0].OverTimeTypeID);
				$('#selectDate').val(getEditFormattedDate(new Date(data[0].Date)));
				$('#entryNotes').val(data[0].Notes);
				$('#selectEmployeeName').val(data[0].EmployeeID);
				$('#selectManagerName').val(data[0].CoordinatorName);
				$('#EmployeeID').val(data[0].EmployeeID);
				
				localStorage.setItem('UpdateOvertimeID', ID_Edit);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});

	}

	function submitDeleteOvertime(ID_Delete){
		$('#tableOvertime').hide();
		$('#divLoading').show();
		var OvertimeData = {
			OvertimeID: ID_Delete,
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/DeleteOverTime',
			data 		: OvertimeData,
			dataType 	: 'json',
			success:function(data){
				showModal(data, 1);
				ClearOvertimeForm();
				RefreshTableOvertime();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function RefreshTableOvertime() {
		$('#tableOvertime').hide();
		$('#divLoading').show();
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableOvertime',
			dataType 	: 'json',
			success:function(data){
				$('#tableOvertime').html(data);
				$('#divLoading').hide();
				$('#tableOvertime').show();
				$('#overtimeTable').DataTable({   
					"columnDefs": [         
						{ "width": "15%", "targets":1 },
						{ "width": "15%", "targets":2 },
						{ "width": "5%", "targets":4 },
						{ "width": "13%", "targets":3 },
						{ "width": "10%", "targets":7 },
						{ "width": "7%", "targets":6 },
						{ "width": "30%", "targets":5 },
						{ "width": "5%", "targets":0 }
					],
					"order": [[3, 'asc']]
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#divLoading').hide();
				$('#tableOvertime').show();
				showModal("Whoops Something Wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
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

	function showModalNotification(data){
		$('#btnOK').hide();
		$('#LoadingModal').modal('hide');
		$('#ModalHeaderNotification').html(data);
		$('#ModalContentNotification').html("Are you sure you want to do this?");
		$('#btnAlright').show();
		$('#Modal_Notification').modal(); 
	}
	
});