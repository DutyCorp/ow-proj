$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#PermissionAttendanceHistoryTable tbody').on('click', '.ChooseDelete', function (e) {
		var IDPermission = $(this).val();
		showModalNotification("Delete Permission Attendance History");
		$('#YesDelete').click(function() {
			$('#Modal_Notification').modal('hide');
			submitDelete(IDPermission);
		});
		$('#NoDelete').click(function() {
			$('#Modal_Notification').modal('hide');
		});
        
     } );

	function submitDelete(ID_Delete){
		var EntryPermissionData = {
			permitID: ID_Delete,
		}
		$.ajax({
			type: 'POST',
			url: '/PermissionDelete',
			data: EntryPermissionData,
			dataType: 'json',
			success:function(data){
				showModal(data, 1);
				refreshTablePermissionAttendanceHistory();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function refreshTablePermissionAttendanceHistory() {
		$('#tablePermissionAttendanceHistory').hide();
		$('#divLoading').show();
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTablePermissionAttendanceHistory',
			dataType 	: 'json',
			success:function(data){
				$('#tablePermissionAttendanceHistory').html(data);
				$('#divLoading').hide();
				$('#tablePermissionAttendanceHistory').show();
				$('#PermissionAttendanceHistoryTable').DataTable({   
					"columnDefs": [    
						{ "width": "10%", "targets": 0 },
						{ "width": "15%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "10%", "targets": 3 },
						{ "width": "30%", "targets": 4 },
						{ "width": "20%", "targets": 5 }	
					],
					dom: 'Bfrtip',
					lengthMenu: [
			            [ 10, 25, 50, -1 ],
			            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
			        ],
					
					buttons: [{extend:'pageLength',text: '<span>Show Page</span>'},	 {
			            extend: 'excelHtml5',
			            text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>'
			        } ],
			        "order": [[2, 'asc']]
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#divLoading').hide();
				$('#tablePermissionAttendanceHistory').show();
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
		$('#Modal_Notification').modal('hide');
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