$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	var DateData = [];
	$('#Download').attr("disabled", "disabled");
	$('#TableBTN').hide();
	$('#Reset').hide();
	var IDWD = [];
	var MYWD = [];
	var THWD = [];
	var VNWD = [];
	var SPDateFrom;
	var SPDateTo;

	$('#UploadBTN').click(function(){
		$('#Loader').hide();
		$('#RP_Info').hide();
	});
	
	
	$('#Upload').click(function(){
		if($('#file').val() == "") { 
			$('#RP_Info').text("Please choose the file");
			$('#RP_Info').show();
			document.getElementById('RP_Info').style.color = "red";
			document.getElementById('RP_Info').style.fontSize = "14px";
			return false;
		}
		$('#RP_Info').hide();
		$('#Loader').show();
		var RPData = new FormData();
		RPData.append('RPExcelData', 	$('#file').get(0).files[0]);
		$.ajax({
			type 		: 'POST',
			url 		: '/UploadResourcePlanning',
			data 		: RPData,
			processData : false,
  			contentType : false,
			dataType 	: 'json',
			success:function(data){
				$('#Loader').hide();
				$('#RP_Info').text(data);
				$('#RP_Info').show();
				document.getElementById('RP_Info').style.color = "green";
				document.getElementById('RP_Info').style.fontSize = "14px";
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Something error with your file, please check your file",2);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#Download').click(function(){
		window.location.href = '/DownloadTemplateRP/' + DateData + '/' + IDWD + '/' + MYWD + '/' + THWD + '/' + VNWD + '/' + SPDateFrom + '/' + SPDateTo + '/';
	});

	$('#Versus').click(function(){
		window.location.href = '/BVATemplate';
	});

	function getEditFormattedYear(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		return year;
	}

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		return year + '-' + month + '-01';
	}

	$('#SaveBTN').click(function(){
		IDWD = [];
		MYWD = [];
		THWD = [];
		VNWD = [];
		var CheckID = 1;
		var CheckMY = 1;
		var CheckTH = 1;
		var CheckVN = 1;
		$(".IDWD").each(function(){
			if($(this).val() != ""){
				IDWD.push($(this).val());
			} else {
    			IDWD.push("");
    		}
		});
		$(".MYWD").each(function(){
    		if($(this).val() != ""){
				MYWD.push($(this).val());
			} else {
    			MYWD.push("");
    		}
		});
		$(".THWD").each(function(){
    		if($(this).val() != ""){
				THWD.push($(this).val());
			} else {
    			THWD.push("");
    		}
		});
		$(".VNWD").each(function(){
    		if($(this).val() != ""){
				VNWD.push($(this).val());
			} else {
    			VNWD.push("");
    		}
		});

		for(var i=0; i<IDWD.length; i++){
			if(IDWD[i] == "")
				CheckID = 0;

			if(MYWD[i] == "")
				CheckMY = 0;

			if(THWD[i] == "")
				CheckTH = 0;

			if(VNWD[i] == "")
				CheckVN = 0;
		}
		if(CheckID == 0){
			showModal("All Indonesia Working Day must be filled",0);
			return false;
		}else if(CheckMY == 0){
			showModal("All Malaysia Working Day must be filled",0);
			return false;
		}else if(CheckTH == 0){
			showModal("All Thailand Working Day must be filled",0);
			return false;
		}else if(CheckVN == 0){
			showModal("All Vietnam Working Day must be filled",0);
			return false;
		} else {
			$('#Download').removeAttr("disabled");
			$('#ResourcePlanningTable').hide();
			$('#TableBTN').hide();
			$('#Reset').show();
			SPDateFrom = $('#DateFrom').val();
			SPDateTo = $('#DateFrom').val();
		}
	});

	$('#Reset').click(function(){
		$('#DateFrom').removeAttr("disabled");
		$('#Set').removeAttr("disabled");
		$('#ResourcePlanningTable').hide();
		$('#TableBTN').hide();
		$('#Download').attr("disabled","disabled");
		$('#Reset').hide();
	})

	$('#CancelBTN').click(function(){
		$('#DateFrom').removeAttr("disabled");
		$('#Set').removeAttr("disabled");
		$('#ResourcePlanningTable').hide();
		$('#TableBTN').hide();
	});

	$('#Set').click(function(){
		if($('#DateFrom').val() == ""){
			showModal("Date From must be chosen",0);
			return false;
		}else{
			dateRange( $('#DateFrom').val() + "-01-01" , $('#DateFrom').val() + "-12-01");
			var TemplateData={
				DateData: DateData,
			}
			$.ajax({
				type: 'POST',
				url: '/ResourceDateTemplate',
				data: TemplateData,
				dataType: 'json',
				success:function(data){
					$("#ResourcePlanningTable").show();
					$("#ResourcePlanningTable").html(data);
					$('#RP_Table').DataTable({
						scrollX:        "200px",
	        			scrollCollapse: true,
						bPaginate: false,
						info:     false,
						bFilter: false,
					});
					$('#DateFrom').attr("disabled","disabled");
					$('#DateTo').attr("disabled","disabled");
					$('#Set').attr("disabled","disabled");
					$('#TableBTN').show();
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

	function dateRange(startDate, endDate) {
		var start      = startDate.split('-');
		var end        = endDate.split('-');
		var startYear  = parseInt(start[0]);
		var endYear    = parseInt(end[0]);
		var dates      = [];
		DateData	   = [];

		for(var i = startYear; i <= endYear; i++) {
		    var endMonth = i != endYear ? 11 : parseInt(end[1]) - 1;
		    var startMon = i === startYear ? parseInt(start[1])-1 : 0;
		    for(var j = startMon; j <= endMonth; j = j > 12 ? j % 12 || 11 : j+1) {
		    	var month = j+1;
		    	var displayMonth = month < 10 ? '0'+month : month;
		    	dates.push([i, displayMonth, '01'].join('-'));
		    }
		}
		for(var i=0; i< dates.length; i++){
		  	DateData[i] = formatDate(new Date(dates[i]));
		}
	}

	function formatDate(date) {
		var monthNames = [
			"Jan", "Feb", "Mar",
		    "Apr", "May", "Jun", "Jul",
		    "Aug", "Sep", "Oct",
		    "Nov", "Dec"
		];
		var day = date.getDate();
		var monthIndex = date.getMonth();
		var year = date.getFullYear();
		return monthNames[monthIndex] + ' ' + year;
	}

	$('#btnAlright').click(function() {
		$('#Modal').modal('hide');
	});

	$('#btnCloseRP').click(function() {
		$('#RP_Modal').modal('hide');
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