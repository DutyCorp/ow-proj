$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('#submit').click(function(){
		changePassword();
	});

	$('#ConPass').on('keyup', function(e){
		if (e.keyCode == 13) {
			changePassword();
		}
	});

	function changePassword(){
		var Old = $('#OldPass').val();
		var New = $('#NewPass').val();
		var Con = $('#ConPass').val();
		if(Old == ""){
			showModal("Old Password Must be filled", 0);
			return false;
		} else if(New == ""){
			showModal("New Password Must be filled", 0);
			return false;
		} else if(New != Con){
			showModal("New Password and Confirm Password doesn't match", 0);
			return false;
		} else {
			var data = {
				OldPassword: Old,
				NewPassword: New
			}
			$.ajax({
				type: 'POST',
				url: '/ChangePassword',
				data: data,
				dataType: 'json',
				success:function(data){
					if (data == 'Success'){
						showModal("Success Change Password!", 1);
					} else {
						showModal(data, 0);
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