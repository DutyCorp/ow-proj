$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	var currentTime = new Date();
	
	$('#submitProfitability').click(function() {
		if($('#uploadProfitability').val() == "") { 
			showModal("Please choose Profitability file",2);
			return false;
		}
		$('#LoadingModal').modal({
		  backdrop: 'static',
		  keyboard: false
		}); 
		var ProfitabilityData = new FormData();
		ProfitabilityData.append('ProfitabilityExcelData', 	$('#uploadProfitability').get(0).files[0]);
		ProfitabilityData.append('currentTime', 	currentTime);
		$.ajax({
			type 		: 'POST',
			url 		: '/UploadProfitabilityData',
			data 		: ProfitabilityData,
			processData : false,
  			contentType : false,
			dataType 	: 'json',
			success:function(data){
				if(data == "")
					showModal("Success Upload Profitabillity",1);
				else if(data == "Wrong File Extension!")
					showModal("Wrong File Extension!",2);
				else if(data == "Please check your Excel file")
					showModal("Please check your Excel file!",2);
				else
					showModal("Success Upload Profitabillity<br><br>Not Inserted Project :<br>" + data.join("<br>"),1);

				$('#LoadingModal').modal('hide');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Something error with your file, please check your file",2);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#submitTimesheetYearly').click(function() {
		if($('#uploadTimesheetYearly').val() == "") { 
			showModal("Please choose Timesheet Yearly file",2);
			return false;
		}
		$('#LoadingModal').modal({
		  backdrop: 'static',
		  keyboard: false
		}); 
		var TSYearlyData = new FormData();
		TSYearlyData.append('TSYearlyExcelData', 	$('#uploadTimesheetYearly').get(0).files[0]);
		TSYearlyData.append('currentTime', 			currentTime);
		$.ajax({
			type 		: 'POST',
			url 		: '/UploadTSData',
			data 		: TSYearlyData,
			processData : false,
  			contentType : false,
			dataType 	: 'json',
			success:function(data){
				if(data == "")
					showModal("Success Upload Timesheet",1);
				else if(data == "Wrong File Extension!")
					showModal("Wrong File Extension!",2);
				else if(data == "Please check your Excel file")
					showModal("Please check your Excel file!",2);
				else
					showModal("Success Upload Timesheet " + data['year'] + "<br><br>Not Inserted Employee :<br>" + data['EmployeeID'].join("<br>") + "<br><br>Not Inserted Project :<br>" + data['ProjectID'].join("<br>"),1);

				$('#LoadingModal').modal('hide');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Something error with your file, please check the file",2);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#submitOpar').click(function() {
		if($('#uploadOpar').val() == "") { 
			showModal("Please choose OPAR file",2);
			return false;
		}
		$('#LoadingModal').modal({
		  backdrop: 'static',
		  keyboard: false
		});
		var OparData = new FormData();
		OparData.append('OparExcelData', 	$('#uploadOpar').get(0).files[0]);
		OparData.append('currentTime', 	currentTime);
		$.ajax({
			type 		: 'POST',
			url 		: '/UploadOparData',
			data 		: OparData,
			processData : false,
  			contentType : false,
			dataType 	: 'json',
			success:function(data){
				console.log(data);
				if(data == "")
					showModal("Success Upload OPAR",1);
				else if(data == "Wrong File Extension!")
					showModal("Wrong File Extension!",2);
				else if(data == "Please check your Excel file")
					showModal("Please check your Excel file!",2);
				else
					showModal("Success Upload Opar" + "<br><br>Not Inserted Project :<br>" + data.join("<br>"),1);

				$('#LoadingModal').modal('hide');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Something error with your file, please check the file",2);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#submitProject').click(function() {
		if($('#uploadProject').val() == "") { 
			showModal("Please choose Project file",2);
			return false;
		}
		$('#LoadingModal').modal({
		  backdrop: 'static',
		  keyboard: false
		}); 
		var ProjectData = new FormData();
		ProjectData.append('ProjectExcelData', 	$('#uploadProject').get(0).files[0]);
		ProjectData.append('currentTime', 		currentTime);
		$.ajax({
			type 		: 'POST',
			url 		: '/UploadProjectData',
			data 		: ProjectData,
			processData : false,
  			contentType : false,
			dataType 	: 'json',
			success:function(data){
				if(data == "")
					showModal("Success Upload Project",1);
				else if(data == "Wrong File Extension!")
					showModal("Wrong File Extension!",2);
				else if(data == "Please check your Excel file")
					showModal("Please check your Excel file!",2);
				else
					showModal("Success Upload Project" + "<br><br>New Inserted Project :<br>" + data.join("<br>"),1);

				$('#LoadingModal').modal('hide');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Something error with your file, please check null value",2);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#submitClaim').click(function() {
		if($('#uploadClaim').val() == "") { 
			showModal("Please choose Claim file",2);
			return false;
		}
		$('#LoadingModal').modal({
		  backdrop: 'static',
		  keyboard: false
		}); 
		var ClaimData = new FormData();
		ClaimData.append('ClaimExcelData', 	$('#uploadClaim').get(0).files[0]);
		ClaimData.append('currentTime', 		currentTime);
		$.ajax({
			type 		: 'POST',
			url 		: '/UploadClaimData',
			data 		: ClaimData,
			processData : false,
  			contentType : false,
			dataType 	: 'json',
			success:function(data){
				if(data == "")
					showModal("Success Upload Claim",1);
				else if(data == "Wrong File Extension!")
					showModal("Wrong File Extension!",2);
				else if(data == "Please check your Excel file")
					showModal("Please check your Excel file!",2);
				else
					showModal("Success Upload Claim<br><br>Not Inserted Claim :<br>" + data.join("<br>"),1);

				$('#LoadingModal').modal('hide');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Something error with your file, please check null value",2);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#submitAging').click(function() {
		if($('#uploadAging').val() == "") { 
			showModal("Please choose Aging file",2);
			return false;
		}
		$('#LoadingModal').modal({
		  backdrop: 'static',
		  keyboard: false
		}); 
		var AgingData = new FormData();
		AgingData.append('AgingExcelData', 	$('#uploadAging').get(0).files[0]);
		AgingData.append('currentTime', 	currentTime);
		$.ajax({
			type 		: 'POST',
			url 		: '/UploadAgingData',
			data 		: AgingData,
			processData : false,
  			contentType : false,
			dataType 	: 'json',
			success:function(data){
				if(data == "")
					showModal("Success Upload Aging",1);
				else if(data == "Wrong File Extension!")
					showModal("Wrong File Extension!",2);
				else if(data == "Please check your Excel file")
					showModal("Please check your Excel file!",2);
				
				$('#LoadingModal').modal('hide');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Something error with your file, please check your file",2);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

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
		$('#Modal').modal('hide');
	});

});	