$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('#divLoading').hide();
	LoadRoleAccessTable($('#roleid').val());
	$('#role').val($('#roleid').val());
	$('#selectGrade').val($('#gradeid').val());
	$('#selectDepartment').val($('#departmentid').val());
	$('#selectPosition').val($('#positionid').val());
	$('#selectRegion').val($('#regionid').val());
	$('#role').change(function(){
		LoadRoleAccessTable($(this).val());
	});
	$('#btnSubmit').click(function() {
		if ($('#txtEmail').val() == ""){
			showModal("Email cannot be empty!", 0);
			return false;
		} else if ($('#txtUsername').val() == ""){
			showModal("Username cannot be empty!", 0);
			return false;
		} else if ($('#dtStart').val() == ""){
			showModal("Start Working Date cannot be empty!", 0);
			return false;
		} else if ($('#dtDOB').val() == ""){
			showModal("Date of Birth cannot be empty!", 0);
			return false;
		} else if (isNaN($('#txtEmergencyContact').val())){
			showModal("Emergency Contact should be a number!", 0);
			return false;
		}
		var formData = new FormData();
		formData.append('EmployeeID', $('#divEmployeeID').text());
		formData.append('RoleID', $('#role').val());
		formData.append('DepartmentID', $('#selectDepartment').val());
		formData.append('GradeID', $('#selectGrade').val());
		formData.append('Position', $('#selectPosition').val());
		formData.append('MobilePhone', $('#txtMobilePhone').val());
		formData.append('SkypeID', $('#txtSkypeID').val());
		formData.append('NationalID', $('#fileNationalId').get(0).files[0]);
		formData.append('TaxRegistrationID', $('#fileTaxRegistrationId').get(0).files[0]);
		formData.append('Passport', $('#filePassport').get(0).files[0]);
		formData.append('Photo', $('#filePhoto').get(0).files[0]);
		formData.append('CV', $('#fileCV').get(0).files[0]);
		formData.append('KK', $('#fileKK').get(0).files[0]);
		formData.append('TerminationDate', $('#dtTermination').val());
		formData.append('Email', $('#txtEmail').val());
		formData.append('Username', $('#txtUsername').val());
		formData.append('StartWorkingDate', $('#dtStart').val());
		formData.append('Region', $('#selectRegion').val());
		formData.append('DateOfBirth', $('#dtDOB').val());	
		formData.append('Address', $('#txtAddress').val());
		formData.append('EmergencyContact', $('#txtEmergencyContact').val());
		formData.append('EmergencyContactName', $('#txtEmergencyContactName').val());
		formData.append('EmergencyContactRelationship', $('#txtEmergencyContactRelationship').val());
		formData.append('USDBankName', $('#txtUSDBankName').val());
		formData.append('USDBankAccount', $('#txtUSDBankAccount').val());
		formData.append('USDName', $('#txtUSDName').val());
		formData.append('LocalBankName', $('#txtLocalBankName').val());
		formData.append('LocalBankAccount', $('#txtLocalBankAccount').val());
		formData.append('LocalName', $('#txtLocalName').val());
		$.ajax({
			type: 'POST',
			url: '/SubmitEmployeeUpdate',
			data: formData,
			processData: false, // important
  			contentType: false, // important
			dataType: 'json',
			success:function(data){
				if (data != 'Success'){
					showModal(data, 0);	
				} else {
					showModal('User Update Success!', 1);
					window.location.replace('/employee/list');
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#btnCancel').click(function() {
		window.location.replace('/employee/list');
	});

	function ClearForm(){
		$('input[type="checkbox"]').prop('checked', false);
	}
	
	function LoadRoleAccessTable(role){
		$('#roleAccessTableDiv').hide();
		$('#divLoading').show();
		var RoleData = {
			RoleID: role
		}
		ClearForm();
		$.ajax({
			type: 'POST',
			url: '/GetRoleAccess',
			data: RoleData,
			dataType: 'json',
			success:function(data){
				var j = 0;
				$('#tableRoleAccess tbody tr').each(function() {
					if (typeof(data['rolemenu'][j]) != 'undefined'){
						if(data['rolemenu'][j]['Role_S'] == "1"){
							$(this).find('#s').prop('checked', true);
						}
						if(data['rolemenu'][j]['Role_I'] == "1"){
							$(this).find('#i').prop('checked', true);
						}
						if(data['rolemenu'][j]['Role_U'] == "1"){
							$(this).find('#u').prop('checked', true);
						}
						if(data['rolemenu'][j]['Role_D'] == "1"){
							$(this).find('#d').prop('checked', true);
						}
					}
					j++;
				});
				$('.cbxRegion').each(function() {
					for (var i = 0; i < data['regionvisibility'].length; i++){
						if (data['regionvisibility'][i]['RegionID'] == $(this).val()){
							if (data['regionvisibility'][i]['isVisible'] == 1){
								$(this).prop('checked', true);
							} else {
								$(this).prop('checked', false);
							}
						}
					}
				});
				$('#divLoading').hide();
				$('#roleAccessTableDiv').fadeIn();

			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
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