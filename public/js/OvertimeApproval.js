$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	refreshTableApprovalOvertime();

	function refreshTableApprovalOvertime() {
		$('#tableApprovalOvertime').hide();
		$('#divLoading').show();
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableApprovalOvertime',
			dataType 	: 'json',
			success:function(data){
				$('#tableApprovalOvertime').html(data);
				$('#divLoading').hide();
				$('#tableApprovalOvertime').show();
				$('#overtimeApprovalTable').DataTable({   
					"columnDefs": [         
						{ "width": "15%", "targets":1 },
						{ "width": "15%", "targets":2 },
						{ "width": "15%", "targets":3 },
						{ "width": "5%", "targets":4 },
						{ "width": "40%", "targets":5 }   
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
						title: 'Overtime Approval',
						text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
						footer: true
					} ]
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#divLoading').hide();
				$('#tableApprovalOvertime').show();
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