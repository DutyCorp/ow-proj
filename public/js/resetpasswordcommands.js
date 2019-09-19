$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#spanResetPassword, #spanUsername, #divImg, #btnLogin, #confirmpassword, #password, #background, #btnSubmit, #divLoading').hide();

	if ($('#le').val() == 0){
		if ($(window).width() > 1080) {
			$('#divImg, #background').animate({
				'marginLeft' : "1%"
			}, 'fast');
			$('#spanResetPassword, #spanUsername, #password, #confirmpassword, #btnSubmit').animate({
				'marginLeft' : "41%"
			}, 'fast');
			setTimeout((function() {
				$('#spanResetPassword').animate({
					'marginLeft' : "40%", "opacity": "toggle" 
				}, 'fast');
				$('#divImg, #background').animate({
					'marginLeft' : "0%", "opacity": "toggle" 
				}, 'fast');
			}), 200);
			setTimeout((function() {
				$('#password, #confirmpassword, #btnSubmit, #spanUsername').animate({
					'marginLeft' : "40%", "opacity": "toggle" 
				}, 'fast');
			}), 300);
		} else {
			$('#divImg, #background').animate({
				'marginLeft' : "1%"
			}, 'fast');
			$('#spanResetPassword, #spanUsername, #password, #confirmpassword, #btnSubmit').animate({
				'marginLeft' : "21%" 
			}, 'fast');
			setTimeout((function() {
				$('#spanResetPassword').animate({
					'marginLeft' : "20%", "opacity": "toggle" 
				}, 'fast');
				$('#divImg, #background').animate({
					'marginLeft' : "0%", "opacity": "toggle" 
				}, 'fast');
			}), 200);
			setTimeout((function() {
				$('#spanUsername, #password, #confirmpassword, #btnSubmit').animate({
					'marginLeft' : "20%", "opacity": "toggle" 
				}, 'fast');
			}), 300);
		}
	} else {
		if ($(window).width() > 1080) {
			$('#divImg, #background').animate({
				'marginLeft' : "1%"
			}, 'fast');
			$('#spanResetPassword, #spanUsername, #btnLogin').animate({
				'marginLeft' : "41%"
			}, 'fast');
			setTimeout((function() {
				$('#spanResetPassword').animate({
					'marginLeft' : "40%", "opacity": "toggle" 
				}, 'fast');
				$('#divImg, #background').animate({
					'marginLeft' : "0%", "opacity": "toggle" 
				}, 'fast');
			}), 200);
			setTimeout((function() {
				$('#btnLogin').animate({
					'marginLeft' : "40%", "opacity": "toggle" 
				}, 'fast');
			}), 300);
		} else {
			$('#divImg, #background').animate({
				'marginLeft' : "1%"
			}, 'fast');
			$('#spanResetPassword, #spanUsername, #btnLogin').animate({
				'marginLeft' : "21%" 
			}, 'fast');
			setTimeout((function() {
				$('#spanResetPassword').animate({
					'marginLeft' : "20%", "opacity": "toggle" 
				}, 'fast');
				$('#divImg, #background').animate({
					'marginLeft' : "0%", "opacity": "toggle" 
				}, 'fast');
			}), 200);
			setTimeout((function() {
				$('#btnLogin').animate({
					'marginLeft' : "20%", "opacity": "toggle" 
				}, 'fast');
			}), 300);
		}
	}
	
	$(window).resize(function() {
		var winWidth = $(window).width();

		if (winWidth < 1080) {
			$('#spanResetPassword, #spanUsername, #divImg, #btnLogin, #confirmpassword, #password, #background, #btnSubmit, #divLoading').css('marginLeft', '20%');
			$('#background').css('height', '100%');
			$('#background, #divImg').css('marginLeft', '0%');
		} else {
			$('#spanResetPassword, #spanUsername, #divImg, #btnLogin, #confirmpassword, #password, #background, #btnSubmit, #divLoading').css('marginLeft', '40%');
			$('#background, #divImg').css('marginLeft', '0%');
		}
	});

	$('#btnSubmit').click(function() {
		resetPassword();
	});

	$('#confirmpassword').on('keyup', function(e){
		if (e.keyCode == 13) {
			resetPassword();
		}
	});

	$('#btnLogin').click(function() {
		backToLogin();
	});

	$('#btnAlright').click(function() {
		$('#Modal').modal('hide');
	});

	function backToLogin(){
		window.location.replace('/login');
	}

	function resetPassword(){
		if ($('#password').val() == ""){
			showModal('Password must be filled!', 0);
		} else if ($('#password').val() != $('#confirmpassword').val()){
			showModal('Password and Confirm Password must be matched!', 0);
		} else {
			$('#password, #btnSubmit, #confirmpassword').hide();
			$('#divLoading').show();
			console.log($('#password').val());
			var UserData = {
				EmployeeID: $('#empid').val(),
				Password: $('#password').val()
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/ResetPassword',
				data 		: UserData,
				dataType 	: 'json',
				success:function(data){
					console.log(data);
					if (data == 1){
						$('#divLoading').hide();
						if ($(window).width() > 1080) {
							$('#spanResetPassword, #spanUsername').animate({
								'marginLeft' : "39%", "opacity": "toggle"
							}, 'fast');
						} else {
							$('#spanResetPassword, #spanUsername').animate({
								'marginLeft' : "19%", "opacity": "toggle" 
							}, 'fast');
						}
						setTimeout((function() {
							if ($(window).width() > 1080) {
								$('#spanResetPassword, #btnLogin').css('marginLeft', '41%');
							} else {
								$('#spanResetPassword, #btnLogin').css('marginLeft', '21%');
							}
						}), 200);
						setTimeout((function() {
							$("#spanResetPassword").text("Reset Password Success!");
							if ($(window).width() > 1080) {
								$('#spanResetPassword, #btnLogin').animate({
									'marginLeft' : "40%", "opacity": "toggle" 
								}, 'fast');
							} else {
								$('#spanResetPassword, #btnLogin').animate({
									'marginLeft' : "20%", "opacity": "toggle" 
								}, 'fast');
							}
						}), 400);
					} else {
						$('#divLoading').hide();
						$('#password, #btnSubmit, #confirmpassword').show();
						showModal(data, 0);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#password, #btnSubmit, #confirmpassword').show();
					$('#divLoading').hide();
					showModal('Whoops! Something wrong', 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
	}

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