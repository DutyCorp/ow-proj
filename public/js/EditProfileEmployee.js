$(document).ready(function() {
	$.ajaxSetup({
  		headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
	});
	$("#ShowImg").hide();

	$('[data-toggle="tooltip"]').tooltip();   
	
	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader 		= new FileReader();
	        reader.onload 	= function (e) {
	            $('#ShowImg').attr('src', e.target.result);
	        }
	        reader.readAsDataURL(input.files[0]);
		}
	}
	$("#filePhoto").change(function() {
	    readURL(this);
	    if($("#filePhoto").val() == "")
			$("#ShowImg").hide();
		else
	    	$("#ShowImg").show();
	});

	$('#buttonSubmit').click(function() {
		var EntryEmployeeID  						  = $('#entryID').val();
		var EntryEmployeeSkype  					  = $('#entrySkype').val();
	    var EntryEmployeePhone 						  = $('#entryPhone').val();
	    var EntryEmployeeAddress 					  = $('#entryAddress').val();
	 	var EntryEmployeeEmergencyContact 			  = $('#entryEmergencyContact').val();
	 	var EntryEmployeeEmergencyContactName 		  = $('#entryEmergencyContactName').val();
	 	var EntryEmployeeEmergencyContactRelationship = $('#entryEmergencyContactRelationship').val();
	 	var EntryEmployeeUSDBankName			 	  = $('#entryUSDBankName').val();
	 	var EntryEmployeeUSDBankAccount 			  = $('#entryUSDBankAccount').val();
	 	var EntryEmployeeUSDName 					  = $('#entryUSDName').val();
	 	var EntryEmployeeLocalBankName	 			  = $('#entryLocalBankName').val();
	 	var EntryEmployeeLocalBankAccount 			  = $('#entryLocalBankAccount').val();
	 	var EntryEmployeeLocalName 					  = $('#entryLocalName').val();

		if (EntryEmployeePhone == "") {
	    	showModal("Mobile Phone must be filled!", 0);
	    	return false;
		}
		else if (EntryEmployeeSkype == "") {
	    	showModal("Skype ID must be filled!", 0);
	    	return false;
		}
		else if (EntryEmployeeAddress == "") {
	        showModal("Address must be filled!", 0);
	        return false;
	    }
	    else {
	    	var formData = new FormData();
	    	formData.append('EmployeeID', EntryEmployeeID);
	    	formData.append('EmployeePhone', EntryEmployeePhone);
	    	formData.append('EmployeeSkype', EntryEmployeeSkype);
	    	formData.append('NationalID', $('#fileNationalId').get(0).files[0]);
	    	formData.append('TaxRegistrationID', $('#fileTaxRegistrationId').get(0).files[0]);
	    	formData.append('Passport', $('#filePassport').get(0).files[0]);
	    	formData.append('Photo', $('#filePhoto').get(0).files[0]);
	    	formData.append('CV', $('#fileCV').get(0).files[0]);
	    	formData.append('KK', $('#fileKK').get(0).files[0]);
	    	formData.append('EmployeeAddress', EntryEmployeeAddress);
	    	formData.append('EmployeeEmergencyContact', EntryEmployeeEmergencyContact);
	    	formData.append('EmployeeEmergencyContactName', EntryEmployeeEmergencyContactName);
	    	formData.append('EmployeeEmergencyContactRelationship', EntryEmployeeEmergencyContactRelationship);
	    	formData.append('EmployeeUSDBankName', EntryEmployeeUSDBankName);
	    	formData.append('EmployeeUSDBankAccount', EntryEmployeeUSDBankAccount);
	    	formData.append('EmployeeUSDName', EntryEmployeeUSDName);
	    	formData.append('EmployeeLocalBankName', EntryEmployeeLocalBankName);
	    	formData.append('EmployeeLocalBankAccount', EntryEmployeeLocalBankAccount);
	    	formData.append('EmployeeLocalName', EntryEmployeeLocalName);
	    	console.log(formData);
	    	$.ajax({
				type 		: 'POST',
				url 		: '/SubmitEditEmployeeData',
				data 		: formData,
				processData : false,
  				contentType : false,
				dataType 	: 'json',
				success:function(data) {
					if (data != 'Success'){
						showModal(data, 0);	
					} else {
						showModal('Success Update Profile!', 1);	
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
	})

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