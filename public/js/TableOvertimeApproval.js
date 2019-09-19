$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#tableApprovalOvertime tbody').on('click', '.ChooseApproveOvertime', function (e) {
        var approval = 'selectApproval' + $(this).val();
        var approvalID;
		if($('#'+approval).val() == "Approved")	{
			approvalID = 2;
		}else if($('#'+approval).val() == "Rejected") {
			approvalID = 3;
		}else if($('#'+approval).val() == "ApprovedHalf") {
			approvalID = 5;
		}else if($('#'+approval).val() == "ApprovedOne") {
			approvalID = 6;
		}
		$('#tableApprovalOvertime').hide();
		$('#divLoading').show();
			var OvertimeApprovalData = {
				OvertimeID		: $(this).val(),
				ApprovalID 		: approvalID
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/ApprovalOvertime',
				data 		: OvertimeApprovalData,
				dataType 	: 'json',
				success:function(data){
					showModal(data, 1);
					refreshTableApprovalOvertime();
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

     } );

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
					"order": [[2, 'asc']]
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