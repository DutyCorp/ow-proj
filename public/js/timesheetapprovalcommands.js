$(document).ready(function(){
	var lei, mth, uu;
	$('#btnBroadcastEmail').hide();
	$('#btnSubmit').click(function() {
		$('#tableTimesheetApproval').html("");
		$('#btnBroadcastEmail').hide();
		if ($('#fileUpload').get(0).files.length === 0) {
		    showModal('Please input Timesheet file first!', 0);
		    return false;
		}
		var formData = new FormData();
		formData.append('TimesheetApprovalFile', $('#fileUpload').get(0).files[0]);
		$('#LoadingModal').modal({
		  backdrop: 'static',
		  keyboard: false
		}); 
		$.ajax({
			type: 'POST',
			url: '/sendTimesheetApproval',
			data: formData,
			processData: false,
  			contentType: false,
			dataType: 'json',
			success:function(data){
				console.log(data);
				if (typeof data === 'object'){
					$('#tableTimesheetApproval').html(data['returnHTML']);
					lei = data['lei'];
					mth = data['mth'];
					uu = data['uu'];
					$('#TimesheetApprovalTable').DataTable();
					$('#btnBroadcastEmail').show();
					$('#LoadingModal').modal('hide');
				} else {
					if (data.indexOf("Process Aborted") > 0){
						showModal(data, 0);
					} else if (data == "Wrong File Extension!") {
						showModal(data, 0);
					} else {
						showModal(data, 1);
					}
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal('Whoops! Something wrong', 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#btnBroadcastEmail').click(function() {
		$('#LoadingModal').modal({
		  backdrop: 'static',
		  keyboard: false
		}); 
		var TimesheetData = {
			lei : lei,
			mth : mth,
			uu : uu
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/sendTimesheetApprovalEmail',
			data 		: TimesheetData,
			dataType 	: 'json',
			success:function(data){
				showModal(data, 1);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
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

	$('#btnAlright').click(function() {
		$('#Modal').modal('hide');
	});
});