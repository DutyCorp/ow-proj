$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#spanSignIn, #spanMenuPath, #divImg, #btnLogin, #username, #password, #background, #btnForgotPassword, #defaultProfilePicture').hide();
	
	if(typeof Storage !== "undefined")
	{		
		if (localStorage.getItem("menuName") != 'null'){
			$('#menuPath').html(localStorage.getItem("menuName"));
		} else {
			$('#menuPath').html('Home');
		}
	} else {
		$('#menuPath').html('Home');
	}

	if ($(window).width() > 1080) {
		$('#divImg, #background').animate({
			'marginLeft' : "1%"
		}, 'fast');
		$('#spanSignIn, #spanMenuPath').animate({
			'marginLeft' : "40.5%"
		}, 'fast');
		setTimeout((function() {
			$('#spanSignIn').animate({
				'marginLeft' : "40%", "opacity": "toggle" 
			}, 'fast');
			$('#divImg, #background').animate({
				'marginLeft' : "0%", "opacity": "toggle" 
			}, 'fast');
		}), 200);
		setTimeout((function() {
			$('#spanMenuPath, #username, #password, #btnLogin, #btnForgotPassword').animate({
				'marginLeft' : "40%", "opacity": "toggle" 
			}, 'fast');
		}), 300);
	} else {
		$('#divImg, #background').animate({
			'marginLeft' : "1%"
		}, 'fast');
		$('#spanSignIn, #spanMenuPath').animate({
			'marginLeft' : "20.5%" 
		}, 'fast');
		setTimeout((function() {
			$('#spanSignIn').animate({
				'marginLeft' : "20%", "opacity": "toggle" 
			}, 'fast');
			$('#divImg, #background').animate({
				'marginLeft' : "0%", "opacity": "toggle" 
			}, 'fast');
		}), 200);
		setTimeout((function() {
			$('#spanMenuPath, #username, #password, #btnLogin, #btnForgotPassword').animate({
				'marginLeft' : "20%", "opacity": "toggle" 
			}, 'fast');
		}), 300);
	}

	$(window).resize(function() {
		var winWidth = $(window).width();

		if (winWidth < 1080) {
			$('#username, #spanSignIn, #spanMenuPath, #password, #email, #btnLogin, #btnBack, #btnBackForgot, #btnForgotPassword').css('marginLeft', '20%');
			$('#background').css('height', '100%');
		} else {
			$('#username, #spanSignIn, #spanMenuPath, #password, #email, #btnLogin, #btnForgotPassword, #btnBack, #btnBackForgot').css('marginLeft', '40%');
		}
	});
	
	var HTML = $('#ErrorContent center').html();
	$('#btnBack, #email, #forgotPassword, #btnSubmit, #tempprofilePicture, #profilePicture, #divLoading, #btnBackForgot').hide();
	$('#username').focus();
	$('#username').on('keydown', function(e){
		if (e.keyCode == 9) {
			$('#btnLogin').prop('disabled', true);
			$('#profilePicture').attr('src', "");
			if(typeof Storage !== "undefined")
			{
				localStorage.setItem("profileImg", "");
			}			
			var profileName = $('#username').val();
			var UserData  	= {
				Username: profileName
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/CheckUsername',
				data 		: UserData,
				dataType 	: 'json',
				success:function(data){
					if (typeof(data) == "object"){
						$('#defaultProfilePicture').hide();
						$('#btnLogin').prop('disabled', false);
						$('#btnBack').show();
						if ($(window).width() > 1080) {
							$('#spanSignIn').animate({
								'marginLeft' : "39.5.5%", "opacity": "toggle" 
							}, 'fast');
						} else {
							$('#spanSignIn').animate({
								'marginLeft' : "19.5%", "opacity": "toggle" 
							}, 'fast');
						}
						setTimeout((function() {
							$('#spanSignIn').html('Welcome, <b>'+$('#username').val()+'</b>');
							if ($(window).width() > 1080) {
								$('#spanSignIn').animate({
									'marginLeft' : "40%", "opacity": "toggle" 
								}, 'fast');
							} else {
								$('#spanSignIn').animate({
									'marginLeft' : "20%", "opacity": "toggle" 
								}, 'fast');
							}
							$('#btnForgotPassword').show();
						}), 200);
						if (data[0] != null || data[0] != "uploads/"){
							$('#profilePicture').attr('src', data[0]);
							$('#profilePicture').show();
						}
						$("#profilePicture").on('error', function () {
						  	$('#profilePicture').hide();
						  	$('#defaultProfilePicture').show();
						});	
						$('#profilePicture, #spanProfileName').fadeIn();
						$('#password').focus();
						if ($(window).width() > 1080) {
							$('#username').animate({
								'marginLeft' : "39.5%", "opacity": "toggle" 
							}, 'fast');
						} else {
							$('#username').animate({
								'marginLeft' : "19.5%", "opacity": "toggle" 
							}, 'fast');
						}
					} else {
						showModal(data, 0);
						$('#btnLogin').prop('disabled', false);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					showModal('Whoops! Something wrong', 0);
					$('#btnLogin').prop('disabled', false);
					$('#spanProfileName').show();
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
			return false;
		}
	});

	$('#btnForgotPassword').click(function(){
		$('#profilePicture, #defaultProfilePicture, #spanProfileName').hide();
		if ($('#btnBack').is(':visible')){
			if ($(window).width() > 1080) {
				$('#btnBack, #btnLogin, #password, #btnForgotPassword, #spanMenuPath, #spanSignIn').animate({
					'marginLeft' : "39.5%", "opacity": "toggle" 
				}, 'fast');
			} else {
				$('#btnBack, #btnLogin, #password, #btnForgotPassword, #spanMenuPath, #spanSignIn').animate({
					'marginLeft' : "19.5%", "opacity": "toggle" 
				}, 'fast');
			}
			setTimeout((function() {
				$('#spanSignIn').html('Forgot Password');
				if ($(window).width() > 1080) {
					$('#btnSubmit, #email, #btnBackForgot, #spanSignIn').animate({
						'marginLeft' : "40.5%" 
					}, 'fast');
					$('#btnForgotPassword, #btnBack').css('marginLeft', '40%');
				} else {
					$('#btnSubmit, #email, #btnBackForgot, #spanSignIn').animate({
						'marginLeft' : "20.5%"
					}, 'fast');
					
				}
			}), 200);
			setTimeout((function() {
				if ($(window).width() > 1080) {
					$('#btnSubmit, #email, #btnBackForgot, #spanSignIn').animate({
						'marginLeft' : "40%", "opacity": "toggle" 
					}, 'fast');
				} else {
					$('#btnSubmit, #email, #btnBackForgot, #spanSignIn').animate({
						'marginLeft' : "20%", "opacity": "toggle" 
					}, 'fast');
				}
			}), 400);
		} else {
			if ($(window).width() > 1080) {
				$('#btnLogin, #password, #btnForgotPassword, #spanMenuPath, #spanSignIn, #username').animate({
					'marginLeft' : "39.5%", "opacity": "toggle" 
				}, 'fast');
			} else {
				$('#btnLogin, #password, #btnForgotPassword, #spanMenuPath, #spanSignIn, #username').animate({
					'marginLeft' : "19.5%", "opacity": "toggle" 
				}, 'fast');
			}
			setTimeout((function() {
				$('#spanSignIn').html('Forgot Password');
				if ($(window).width() > 1080) {
					$('#btnSubmit, #email, #btnBackForgot, #spanSignIn').animate({
						'marginLeft' : "40.5%" 
					}, 'fast');
					$('#btnForgotPassword, #btnBack').css('marginLeft', '40%');
				} else {
					$('#btnSubmit, #email, #btnBackForgot, #spanSignIn').animate({
						'marginLeft' : "20.5%"
					}, 'fast');
					
				}
			}), 200);
			setTimeout((function() {
				if ($(window).width() > 1080) {
					$('#btnSubmit, #email, #btnBackForgot, #spanSignIn').animate({
						'marginLeft' : "40%", "opacity": "toggle" 
					}, 'fast');
				} else {
					$('#btnSubmit, #email, #btnBackForgot, #spanSignIn').animate({
						'marginLeft' : "20%", "opacity": "toggle" 
					}, 'fast');
				}
			}), 400);
		}
		$('#username, #password').val('');
	});

	$('#password').on('keyup', function(e){
		if (e.keyCode == 13) {
			signIn();
		}
	});

	$('#btnBack').click(function() {
		$('#btnBack, #profilePicture').hide();
		if ($(window).width() > 1080) {
			$('#spanSignIn').animate({
				'marginLeft' : "39.5%", "opacity": "toggle" 
			}, 'fast');
		} else {
			$('#spanSignIn').animate({
				'marginLeft' : "19.5%", "opacity": "toggle" 
			}, 'fast');
		}
		setTimeout((function() {
			$('#spanSignIn').html('Login');
			if ($(window).width() > 1080) {
				$('#username, #spanSignIn').animate({
				'marginLeft' : "40%", "opacity": "toggle" 
				}, 'fast');
			} else {
				$('#username, #spanSignIn').animate({
					'marginLeft' : "20%", "opacity": "toggle" 
				}, 'fast');
			}
		}), 200);
		$('#defaultProfilePicture').hide();
		$('#username').val('');
	});

	$('#btnBackForgot').click(function() {
		$('#btnBack, #profilePicture, #btnForgotPassword').hide();
		if ($(window).width() > 1080) {
			$('#spanSignIn, #email, #btnBackForgot, #btnSubmit').animate({
				'marginLeft' : "39.5%", "opacity": "toggle" 
			}, 'fast');
		} else {
			$('#spanSignIn, #email, #btnSubmit, #btnBackForgot').animate({
				'marginLeft' : "19.5%", "opacity": "toggle" 
			}, 'fast');
		}
		$('#email').val('');
		setTimeout((function() {
			$('#spanSignIn').html('Login');
			if ($(window).width() > 1080) {
				$('#username, #password, #spanSignIn, #spanMenuPath, #btnLogin, #btnForgotPassword').animate({
					'marginLeft' : "40.5%" 
				}, 'fast');
				$('#btnForgotPassword, #btnBack').css('marginLeft', '40%');
			} else {
				$('#username, #password, #spanSignIn, #spanMenuPath, #btnLogin, #btnForgotPassword').animate({
					'marginLeft' : "20.5%"
				}, 'fast');
				$('#btnForgotPassword, #btnBack').css('marginLeft', '20%');
			}
		}), 200);
		setTimeout((function() {
			if ($(window).width() > 1080) {
				$('#username, #password, #spanSignIn, #spanMenuPath, #btnLogin, #btnForgotPassword').animate({
					'marginLeft' : "40%", "opacity": "toggle" 
				}, 'fast');
			} else {
				$('#username, #password, #spanSignIn, #spanMenuPath, #btnLogin, #btnForgotPassword').animate({
					'marginLeft' : "20%", "opacity": "toggle" 
				}, 'fast');
			}
		}), 400);
		//$('#defaultProfilePicture').show();
		$('#email').val('');
		localStorage.removeItem("profileImg");
	});

	$('#btnLogin').click(function() {
		signIn();
	});

	$('#email').on('keyup', function(e){
		if (e.keyCode == 13) {
			sendEmail();
		}
	});

	$('#btnSubmit').click(function(e){
		sendEmail();
	});

	$('#btnAlright').click(function() {
		$('#Modal').modal('hide');
	});

	function sendEmail(){
		$('#email, #btnSubmit, #forgotPassword, #btnBackForgot').hide();
		$('#divLoading').show();
		var UserData = {
			Email: $('#email').val()
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/SendForgotPassword',
			data 		: UserData,
			dataType 	: 'json',
			success:function(data){
				if (data == 1){
					showModal('Email sent. Check your inbox', 1);
					if ($(window).width() > 1080) {
						$('#divLoading, #spanSignIn').animate({
							'marginLeft' : "39.5%", "opacity": "toggle" 
						}, 'fast');
					} else {
						$('#divLoading, #spanSignIn').animate({
							'marginLeft' : "19.5%", "opacity": "toggle" 
						}, 'fast');
					}
					$('#email').val('');
					setTimeout((function() {
						$('#spanSignIn').html('Login');
						if ($(window).width() > 1080) {
							$('#btnLogin, #username, #password, #spanSignIn, #spanMenuPath, #btnForgotPassword').animate({
								'marginLeft' : "40.5%" 
							}, 'fast');
						} else {
							$('#btnLogin, #username, #password, #spanSignIn, #spanMenuPath, #btnForgotPassword').animate({
								'marginLeft' : "20.5%"
							}, 'fast');
						}
					}), 200);
					setTimeout((function() {
						//$('#defaultProfilePicture').show();
						if ($(window).width() > 1080) {
							$('#btnLogin, #username, #password, #spanSignIn, #spanMenuPath, #btnForgotPassword').animate({
								'marginLeft' : "40%", "opacity": "toggle" 
							}, 'fast');
							$('#btnForgotPassword, #btnBack, #divLoading').css('marginLeft', '40%');
						} else {
							$('#btnLogin, #username, #password, #spanSignIn, #spanMenuPath, #btnForgotPassword').animate({
								'marginLeft' : "20%", "opacity": "toggle" 
							}, 'fast');
						}
					}), 400);
				} else {
					$('#email, #btnSubmit, #forgotPassword, #spanSignIn, #btnBackForgot').show();
					$('#divLoading').hide();
					showModal("Email not found!", 0);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#email, #btnSubmit, #forgotPassword, #spanSignIn, #btnBackForgot').show();
				$('#divLoading').hide();
				showModal('Whoops! Something wrong', 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function signIn(){
		/* Hello, function */
		$('#btnLogin').prop('disabled', true);
		if ($('#username').val() == "" && $('#password').val() == ""){
			showModal('Username and Password must be filled!', 0);
			$('#btnLogin').prop('disabled', false);
			return false;
		}
		var UserData = {
			Username: $('#username').val(),
			Password: $('#password').val()
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/UserLogin',
			data 		: UserData,
			dataType 	: 'json',
			success:function(data){
				console.log(data);
				$('#btnLogin').prop('disabled', false);
				if (data == 1){
					if ($(window).width() > 1080) {
						$('#btnBack, #btnForgotPassword, #btnLogin, #password, #spanSignIn, #spanMenuPath').animate({
							'marginLeft' : "39.5%", "opacity": "toggle" 
						}, 'fast');
						$('#divLoading').animate({
							'marginLeft' : "40.5%"
						}, 'fast');
					} else {
						$('#btnBack, #btnForgotPassword, #btnLogin, #password, #spanSignIn, #spanMenuPath').animate({
							'marginLeft' : "19.5%", "opacity": "toggle" 
						}, 'fast');
						$('#divLoading').animate({
							'marginLeft' : "40.5%" 
						}, 'fast');
					}
					setTimeout((function() {
						if ($(window).width() > 1080) {
							$('#divLoading').animate({
								'marginLeft' : "40%", "opacity": "toggle" 
							}, 'fast');
						} else {
							$('#divLoading').animate({
								'marginLeft' : "40%", "opacity": "toggle" 
							}, 'fast');
						}
					}), 200);
					$('#btnBack, #btnForgotPassword, #username').hide();
					if(typeof Storage !== "undefined")
					{
						if (localStorage.getItem("currentURL") != 'null'){
							window.location.replace(localStorage.getItem("currentURL"));
						} else {
							window.location.replace('/');
						}
					} else {
						window.location.replace('/');
					}
				} else {
					showModal('Username or Password not valid!', 0);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				/* function machine broke */
				$('#btnLogin').prop('disabled', false);
				showModal('Whoops! Something wrong', 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
		/* Understandable, have a nice day */
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