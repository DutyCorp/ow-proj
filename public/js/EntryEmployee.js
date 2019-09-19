$(document).ready(function() {
	$.ajaxSetup({
  		headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
	});
	var Username;
	
	$("#ShowImg").hide();
	$('#DepartmentInfo').hide();
	$('#PositionInfo').hide();
	$('#RegionInfo').hide();

	$('#AddRole').click(function(){
		window.open('/role','Add Role');
	});

	/////REGION/////

	$('#addNewRegion').click(function() {
		ClearRegion();
	});

	$('#buttonSubmitRegion').click(function() {
		var EntryRegionID = $('#RegionID').val();
		var EntryRegionName = $('#RegionName').val();
		var EntryRegionPhone = $('#RegionPhone').val();
		var EntryRegionAddress = $('#RegionAddress').val();
		var EntryRegionFax = $('#RegionFax').val();
	    if (EntryRegionID == ""){
	        ModalAlert("RegionInfo","Region ID must be filled","red");
	        return false;
	    }
	    else if (EntryRegionName == ""){
	        ModalAlert("RegionInfo","Region Name must be filled","red");
	        return false;
	    }
	    else{	
	    	var CheckRegionData = {
	    		RegionID 		: EntryRegionID,
	    	}
	    	$.ajax({
				type: 'POST',
				url: '/CheckRegionID',
				data: CheckRegionData,
				dataType: 'json',
				success:function(data){
					if(data != "")
					{
						ModalAlert("RegionInfo","Region ID already exist","red");
				        return false;
					}
					else
					{
						var EntryRegionData = {
				    		RegionID 		: EntryRegionID,
				    		RegionName 		: EntryRegionName,
				    		RegionPhone 	: EntryRegionPhone,
				    		RegionAddress 	: EntryRegionAddress,
				    		RegionFax 		: EntryRegionFax
						}
				    	$.ajax({
							type: 'POST',
							url: '/EntryRegion',
							data: EntryRegionData,
							dataType: 'json',
							success:function(data){
								ClearRegion();
								ModalAlert("RegionInfo","Success Entry Region","green");
							},
							error: function (xhr, ajaxOptions, thrownError) {
			           			showModal("Whoops! Something wrong", 0);
			           			console.log(xhr.status);
			           			console.log(xhr.responseText);
			           			console.log(thrownError);
			       			}
						});
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
	});

	$('#closeRegionButton').click(function() {
		refreshDropdownRegion();
	});

	$('#RegionModal').on('hidden.bs.modal', function (e) {
        refreshDropdownRegion();
    });

	$('#buttonUpdateRegion').click(function() {
		var UpdateRegionName 	= $('#RegionName').val();
		var UpdateRegionPhone 	= $('#RegionPhone').val();
		var UpdateRegionAddress = $('#RegionAddress').val();
		var UpdateRegionFax 	= $('#RegionFax').val();
	    if (UpdateRegionName == "") {
	    	ModalAlert("RegionInfo","Region Name must be filled","red");
	        return false;
	    } else {
	    	var UpdateRegionData = {
		    	RegionID 		: $('#RegionID').val(),
		    	RegionName  	: UpdateRegionName,
		    	RegionAddress 	: UpdateRegionAddress,
		    	RegionPhone 	: UpdateRegionPhone,
		    	RegionFax 		: UpdateRegionFax
		    }
		    $.ajax({
		    	type 		: 'POST',
		    	url 		: '/RegionUpdate',
		    	data 		: UpdateRegionData,
		    	dataType 	: 'json',
		    	success:function(data){
		    		ClearRegion();
					ModalAlert("RegionInfo","Success Update Region","green");
		    	},
		    	error: function (xhr, ajaxOptions, thrownError) {
		    		showModal("Whoops! Something wrong", 0);
		    		console.log(xhr.status);
		    		console.log(xhr.responseText);
		    		console.log(thrownError);
		    	}
		    });	
	    }
	});

	$('#buttonCancelRegion').click(function(){
		ClearRegion();
	});

	function refreshDropdownRegion(){
		$('#selectRegion').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownRegion',
			dataType: 'json',
			success:function(data){
				$('#selectRegion').append('<option value="None">Select</option>');
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#selectRegion').append('<option value="'+data[i]['RegionID']+'">'+data[i]['RegionName']+'</option>');
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

	function refreshTableRegion() {
		$('#tableRegion').html("");
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableRegion',
			dataType 	: 'json',
			success:function(data) {
				$('#tableRegion').html(data);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function ClearRegion(){
		$('#buttonUpdateRegion').hide();
		$('#buttonCancelRegion').hide();
		$('#buttonSubmitRegion').show();
		$('#RegionID').removeAttr("disabled");
		$('#RegionID').val("");
		$('#RegionName').val("");
		$('#RegionPhone').val("");
		$('#RegionAddress').val("");
		$('#RegionFax').val("");
		$('#RegionInfo').hide();
		refreshTableRegion();
	}

	//////GRADE/////
	$('#addNewGrade').click(function() {
		ClearGrade();
	});

	$('#closeGradeButton').click(function() {
		refreshDropdownGrade();
	});

	$('#GradeModal').on('hidden.bs.modal', function (e) {
        refreshDropdownGrade();
    });

	$('#buttonSubmitGrade').click(function() {
		var EntryGradeName = $('#GradeName').val();
	    if (EntryGradeName == "") {
	        ModalAlert("GradeInfo","Grade Name must be filled","red");
	        return false;
	    }
	    else {
	    	var EntryGradeData = {
	   			GradeID 	: $('#GradeID').text(),
	    		GradeName 	: EntryGradeName,
			}
	    	$.ajax({
				type: 'POST',
				url: '/EntryGrade',
				data: EntryGradeData,
				dataType: 'json',
				success:function(data){
					ClearGrade();
					ModalAlert("GradeInfo","Success Entry Grade","green");
				},
				error: function (xhr, ajaxOptions, thrownError) {
           			showModal("Whoops! Something wrong", 0);
           			console.log(xhr.status);
           			console.log(xhr.responseText);
           			console.log(thrownError);
       			}
			});
	    }
	});

	$('#buttonUpdateGrade').click(function() {
		var UpdateGradeName = $('#GradeName').val();
	    if (UpdateGradeName == "") {
	    	ModalAlert("GradeInfo","Grade Name must be filled","red");
	        return false;
	    }
	    var UpdateGradeData = {
	    	GradeID 	: $('#GradeID').text(),
	    	GradeName 	: $('#GradeName').val()
	    }
	    $.ajax({
	    	type 		: 'POST',
	    	url 		: '/GradeUpdate',
	    	data 		: UpdateGradeData,
	    	dataType 	: 'json',
	    	success:function(data){
	    		ClearGrade();
	    		ModalAlert("GradeInfo","Success Update Grade","green");
	    	},
	    	error: function (xhr, ajaxOptions, thrownError) {
	    		showModal("Whoops! Something wrong", 0);
	    		console.log(xhr.status);
	    		console.log(xhr.responseText);
	    		console.log(thrownError);
	    	}
	    });
	});

	$('#buttonCancelGrade').click(function() {
		ClearGrade();
	});

	function ClearGrade(){
		$('#buttonUpdateGrade').hide();
		$('#buttonCancelGrade').hide();
		$('#buttonSubmitGrade').show();
		$('#GradeID b').remove();
		$('#GradeName').val("");
		$('#GradeInfo').hide();
		refreshTableGrade();
		refreshGradeID();
	}

	function refreshDropdownGrade(){
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownGrade',
			dataType: 'json',
			success:function(data){
				$('#selectGrade').html("");
				$('#selectGrade').append('<option value="None">Select</option>');
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#selectGrade').append('<option value="'+data[i]['GradeID']+'">'+data[i]['GradeName']+'</option>');
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

	function refreshTableGrade() {
		$('#tableGrade').html("");
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableGrade',
			dataType 	: 'json',
			success:function(data) {
				$('#tableGrade').html(data);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function refreshGradeID() {
		$('#GradeID b').remove();
		$.ajax({
			type 		: 'POST',
			url 		: '/GradeCheckID',
			dataType 	: 'json',
			success:function(data) {
				data++;
				var GradeID = 'G' + padToTWo(data);
				$('#GradeID').append("<b>"+GradeID+"</b>");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
           		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	}	

	//////POSITION/////
	$('#addNewPosition').click(function() {
		ClearPosition();
	});

	$('#closePositionButton').click(function() {
		refreshDropdownPosition();
	});

	$('#myModal').on('hidden.bs.modal', function (e) {
        refreshDropdownPosition();
    });

	$('#buttonSubmitPosition').click(function() {
		var EntryPositionName = $('#positionName').val();
	    if (EntryPositionName == "") {
	    	ModalAlert("PositionInfo","Position Name must be filled","red");
	        return false;
	    }
	    else 
	    {
	    	var EntryPositionData = {
	   			positionID 	: $('#positionID').text(),
	    		positionName: EntryPositionName,
			}
	    	$.ajax({
				type: 'POST',
				url: '/Position',
				data: EntryPositionData,
				dataType: 'json',
				success:function(data){
					ClearPosition();
					ModalAlert("PositionInfo","Success Entry Position","green");
				},
				error: function (xhr, ajaxOptions, thrownError) {
           			showModal("Whoops! Something wrong", 0);
           			console.log(xhr.status);
           			console.log(xhr.responseText);
           			console.log(thrownError);
       			}
			});
	    }
	});

	$('#buttonUpdatePosition').click(function() {
		var UpdatePositionName = $('#positionName').val();
	    if (UpdatePositionName == "") {
	    	ModalAlert("PositionInfo","Position Name must be filled","red");
	        return false;
	    }
	    var UpdatePositionData = {
	    	positionID 	: $('#positionID').text(),
	    	positionName: UpdatePositionName
	    }
	    $.ajax({
	    	type 		: 'POST',
	    	url 		: '/PositionUpdate',
	    	data 		: UpdatePositionData,
	    	dataType 	: 'json',
	    	success:function(data){
	    		ClearPosition();
	    		ModalAlert("PositionInfo","Success Update Position","green");
	    	},
	    	error: function (xhr, ajaxOptions, thrownError) {
	    		showModal("Whoops! Something wrong", 0);
	    		console.log(xhr.status);
	    		console.log(xhr.responseText);
	    		console.log(thrownError);
	    	}
	    });
	});

	$('#buttonCancelPosition').click(function() {
		ClearPosition();
	});

	function ClearPosition(){
		$('#buttonUpdatePosition').hide();
		$('#buttonCancelPosition').hide();
		$('#buttonSubmitPosition').show();
		$('#positionID b').remove();
		$('#positionName').val("");
		$('#PositionInfo').hide();
		refreshTablePosition();
		refreshPositionID();
	}

	function refreshDropdownPosition(){
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownPosition',
			dataType: 'json',
			success:function(data){
				$('#selectPosition').html("");
				$('#selectPosition').append('<option value="None">Select</option>');
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#selectPosition').append('<option value="'+data[i]['PositionID']+'">'+data[i]['PositionName']+'</option>');
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

	function refreshTablePosition() {
		$('#tablePosition').html("");
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTablePosition',
			dataType 	: 'json',
			success:function(data) {
				$('#tablePosition').html(data);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function refreshPositionID() {
		$('#positionID b').remove();
		$.ajax({
			type 		: 'POST',
			url 		: '/PositionCheckID',
			dataType 	: 'json',
			success:function(data) {
				data++;
				var positionID 		= 'PS' + padToTWo(data);
				$('#positionID').append("<b>"+positionID+"</b>");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
           		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	}

	/////DEPARTMENT//////

	$('#addNewDepartment').click(function() {
		ClearDepartment();
	});

	$('#closeDepartmentButton').click(function() {
		refreshDropdownDepartment();
	});

	$('#DepartmentModal').on('hidden.bs.modal', function (e) {
        refreshDropdownDepartment();
    });

    $('#buttonSubmitDepartment').click(function() {
		var EntryDepartmentName = $('#DepartmentName').val();
	    if (EntryDepartmentName == "") {
	    	ModalAlert("DepartmentInfo","Department Name must be filled","red");
	        return false;
	    }
	    else {
	    	var EntryDepartmentData = {
	   			DepartmentID 	: $('#DepartmentID').text(),
	    		DepartmentName 	: EntryDepartmentName,
			}
	    	$.ajax({
				type: 'POST',
				url: '/EntryDepartment',
				data: EntryDepartmentData,
				dataType: 'json',
				success:function(data){
					ClearDepartment();
					ModalAlert("DepartmentInfo","Success Entry Department","green");
				},
				error: function (xhr, ajaxOptions, thrownError) {
           			showModal("Whoops! Something wrong", 0);
           			console.log(xhr.status);
           			console.log(xhr.responseText);
           			console.log(thrownError);
       			}
			});
	    }
	});

	$('#buttonUpdateDepartment').click(function() {
		var UpdateDepartmentName = $('#DepartmentName').val();
	    if (UpdateDepartmentName == "") {
	    	ModalAlert("DepartmentInfo","Department Name must be filled","red");
	        return false;
	    }
	    var UpdateDepartmentData = {
	    	DepartmentID 	: $('#DepartmentID').text(),
	    	DepartmentName  : UpdateDepartmentName
	    }
	    $.ajax({
	    	type 		: 'POST',
	    	url 		: '/DepartmentUpdate',
	    	data 		: UpdateDepartmentData,
	    	dataType 	: 'json',
	    	success:function(data){
	    		ClearDepartment();
	    		ModalAlert("DepartmentInfo","Success Update Department","green");
	    	},
	    	error: function (xhr, ajaxOptions, thrownError) {
	    		showModal("Whoops! Something wrong", 0);
	    		console.log(xhr.status);
	    		console.log(xhr.responseText);
	    		console.log(thrownError);
	    	}
	    });
	});

	$('#buttonCancelDepartment').click(function() {
		ClearDepartment();
	});

	function refreshDropdownDepartment() {
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownDepartment',
			dataType: 'json',
			success:function(data){
				$('#selectDepartment').html("");
				$('#selectDepartment').append('<option value="None">Select</option>');
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#selectDepartment').append('<option value="'+data[i]['DepartmentID']+'">'+data[i]['DepartmentName']+'</option>');
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

	function refreshTableDepartment() {
		$('#tableDepartment').html("");
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableDepartment',
			dataType 	: 'json',
			success:function(data) {
				$('#tableDepartment').html(data);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function refreshDepartmentID() {
		$('#DepartmentID b').remove();
		$.ajax({
			type 		: 'POST',
			url 		: '/DepartmentCheckID',
			dataType 	: 'json',
			success:function(data) {
				data++;
				var departmentID 			= 'D' + padToTWo(data);
				$('#DepartmentID').append("<b>"+departmentID+"</b>");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
           		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	}

	function ClearDepartment(){
		$('#buttonUpdateDepartment').hide();
		$('#buttonCancelDepartment').hide();
		$('#buttonSubmitDepartment').show();
		$('#DepartmentName').val("");
		$('#DepartmentID b').remove();
		$('#DepartmentInfo').hide();
		refreshTableDepartment();
		refreshDepartmentID();
	}

	function ModalAlert(Info,Alert,Color){
    	$('#'+Info).show();
        $('#'+Info).text(Alert);
		document.getElementById(Info).style.color = Color;
		document.getElementById(Info).style.fontSize = "14px";
    }

	/////Entry Employee//////
	$("#buttonClear").click(function() {
		clearEmployeeForm();
	});

	$("#filePhoto").change(function() {
	    readURL(this);
	    if($("#filePhoto").val() == "")
			$("#ShowImg").hide();
		else
		{
			$("#ShowImg").show();
			$("#PhotoGAP").hide();
		}
	});

  	$('#entryPhone').change(function() {
		var PhoneCheck = $('#entryPhone').val();
		if(!/^[0-9]+$/.test(PhoneCheck))
		{
    		showModal("Please only enter numeric characters only! (Allowed input:0-9)", 0);
  		}
	});	

	$('#entryEmail').change(function() {
		var EmailCheck = $('#entryEmail').val();
		validate(EmailCheck);	
	});	

	$('#buttonSubmit').click(function(){
		var EntryEmployeeDOB 						  = $('#selectDOB').val();
		var Tanggal = EntryEmployeeDOB.split("/");
		EntryEmployeeDOB = getEditFormattedDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));

		var EntryEmployeeSWD 						  = $('#selectSWD').val();
		var Tanggal = EntryEmployeeSWD.split("/");
		EntryEmployeeSWD = getEditFormattedDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));

		var EntryEmployeeID 						  = $('#entryID').val();
		var EntryEmployeePosition 					  = $('#selectPosition').val();
	    var EntryEmployeeName 						  = $('#entryName').val();
	    var EntryEmployeePhone 						  = $('#entryPhone').val();
	    var EntryEmployeeEmail 						  = $('#entryEmail').val();
	    var EntryEmployeeSkype 						  = $('#entrySkype').val();
	    var EntryEmployeePassword 					  = $('#entryPassword').val();
	    var EntryReTypePassword 					  = $('#retypePassword').val();
	    var EntryEmployeeRole 						  = $('#selectRole').val();
	 	var EntryEmployeeRegion 					  = $('#selectRegion').val();
	 	var EntryEmployeeDepartment 				  = $('#selectDepartment').val();
	 	var EntryEmployeeGrade 						  = $('#selectGrade').val();
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

	    if (EntryEmployeeID == "")
	    {
	        showModal("Employee ID must be filled!", 0);
	        return false;
	    }
	    else if (EntryEmployeeName == "")
	    {
	        showModal("Name must be filled!", 0);
	        return false;
	    }
	    else if (EntryEmployeeEmail == "")
	    {
	    	ashowModal("Email must be filled!", 0);
	    	return false;
		}
		else if (EntryEmployeePassword == "")
		{
	    	showModal("Password must be filled!", 0);
	    	return false;
		}
		else if (EntryEmployeePassword != EntryReTypePassword)
		{
	    	showModal("Password and Retype Password doesn't match", 0);
	    	return false;
		}
		else if (EntryEmployeeRegion == "None")
		{
	    	showModal("Region must be chosen!", 0);
	    	return false;
		}
		else if (EntryEmployeeRole == "None")
		{
	    	showModal("Role must be chosen!", 0);
	    	return false;
		}
		else if (EntryEmployeeDepartment == "None")
		{
	    	showModal("Department must be chosen!", 0);
	    	return false;
		}	
		else if (EntryEmployeePhone == "")
		{
	    	showModal("Mobile Phone must be filled!", 0);
	    	return false;
		}
		else if (EntryEmployeeGrade == "")
		{
	    	showModal("Grade must be chosen!", 0);
	    	return false;
		}
		else if (EntryEmployeePosition == "None")
		{
	    	showModal("Position must be chosen!", 0);
	    	return false;
		}
		else if (EntryEmployeeSkype == "")
		{
	    	showModal("Skype ID must be filled!", 0);
	    	return false;
		}
	    else if (EntryEmployeeSWD == "")
	    {
	        showModal("Start Working Date must be filled!", 0);
	        return false;
	    }
	    else if (EntryEmployeeDOB == "") 
	    {
	        showModal("Date of Birth must be filled!", 0);
	        return false;
	    }
	    else if (EntryEmployeeAddress == "") 
	    {
	        showModal("Address must be filled!", 0);
	        return false;
	    }
	    else 
	    {
	    	var formData = new FormData();
	    	formData.append('EmployeeID', EntryEmployeeID);
	    	formData.append('EmployeeName', EntryEmployeeName);
	    	formData.append('EmployeeEmail', EntryEmployeeEmail);
	    	formData.append('EmployeeUsername', Username);
	    	formData.append('EmployeePassword', EntryEmployeePassword);
	    	formData.append('EmployeeRole', EntryEmployeeRole);
	    	formData.append('EmployeeDOB', EntryEmployeeDOB);
	    	formData.append('EmployeeRegion', EntryEmployeeRegion);
	    	formData.append('EmployeeDepartment', EntryEmployeeDepartment);
	    	formData.append('EmployeeSWD', EntryEmployeeSWD);
	    	formData.append('EmployeePosition', EntryEmployeePosition);
	    	formData.append('EmployeeGrade', EntryEmployeeGrade);
	    	formData.append('EmployeePhone', $('#selectRegionCodeNumber').val() + EntryEmployeePhone);
	    	formData.append('EmployeeSkype', EntryEmployeeSkype);
	    	formData.append('EmployeeNationalID', $('#fileNationalId').get(0).files[0]);
	    	formData.append('EmployeeTaxRegID', $('#fileTaxRegistrationId').get(0).files[0]);
	    	formData.append('EmployeePassport', $('#filePassport').get(0).files[0]);
	    	formData.append('EmployeePhoto', $('#filePhoto').get(0).files[0]);
	    	formData.append('EmployeeCV', $('#fileCV').get(0).files[0]);
	    	formData.append('EmployeeKK', $('#fileKK').get(0).files[0]);
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
	    	$.ajax({
				type 		: 'POST',
				url 		: '/EntryNewEmployee',
				data 		: formData,
				processData	: false,
  				contentType	: false,
				dataType: 'json',
				success:function(data) {
					showModal(data,1);
					clearEmployeeForm();
				},
				error: function (xhr, ajaxOptions, thrownError) {
           			showModal("Whoops! Something wrong", 0);
           			console.log(xhr.status);
           			console.log(xhr.responseText);
           			console.log(thrownError);
       			}
			});
	    }
	});

	$('#btnAlright').click(function() {
		$('#Modal').modal('hide');
	});

	function getEditFormattedDate(date){
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return year + '-' + month + '-' + day;
	}

	function clearEmployeeForm() {
		$('#entryID').val("");
		$('#selectPosition').val("None");
	    $('#entryName').val("");
	    $('#entryPhone').val("");
	    $('#entryEmail').val("");
	    $('#entrySkype').val("");
	    $('#fileNationalId').val("");
	    $('#entryPassword').val("");
	    $('#fileTaxRegistrationId').val("");
	    $('#selectRole').val("None");
	    $('#selectGrade').val("None");
	    $('#filePassport').val("");
	    $('#selectRegion').val("None");
	    $('#filePhoto').val("");
	    $('#fileKK').val("");
	 	$('#selectDepartment').val("None");
	 	$('#fileCV').val("");
	 	$('#selectSWD').val("");
	    $('#selectRegionCodeNumber').val("");
		$('#employeeUsername').html('-');
		$('#ShowImg').hide();
		$('#selectDOB').val("");
		$('#entryAddress').val("");
		$('#entryEmergencyContact').val("");
		$('#entryEmergencyContactName').val("");
		$('#entryEmergencyContactRelationship').val("");
		$('#entryUSDBankName').val("");
		$('#entryUSDBankAccount').val("");
		$('#entryUSDName').val("");
		$('#entryLocalBankName').val("");
		$('#entryLocalBankAccount').val("");
		$('#entryLocalName').val("");
	}

	function validateEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

	function validate(EmailCheck) {
		if (validateEmail(EmailCheck)) {
			var EntryEmployeeUsername 	= $('#entryEmail').val();
			var PureEmail 				= EntryEmployeeUsername.split('@');
			Username 					= PureEmail[0];
			$('#employeeUsername').html(Username);
		}
		else {
		   	showModal('Email is not Valid', 0);
		   	$('#employeeUsername').html('-');
		}
		return false;
	}

	function padToTWo(number) {
		if (number<=99) { number = ("0"+number).slice(-2); }
		return number;
	}

	function padToThree(number) {
		if (number<=999) { number = ("00"+number).slice(-3); }
		return number;
	}

	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader 		= new FileReader();
	        reader.onload 	= function (e) {
	            $('#ShowImg').attr('src', e.target.result);
	        }
	        reader.readAsDataURL(input.files[0]);
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