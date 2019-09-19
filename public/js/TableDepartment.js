$(document).ready(function() {
	$.ajaxSetup({
  		headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
	});

	$('.ChooseDeleteDepartment').click(function() {
		var DeleteDepartmentID 	= $(this).val();
		var DeleteDepartmentData 	= {
	    	DepartmentID: DeleteDepartmentID
		}
	    $.ajax({
			type 		: 'POST',
			url 		: '/DepartmentDelete',
			data 		: DeleteDepartmentData,
			dataType 	: 'json',
			success:function(data){
				$('#buttonUpdateDepartment').hide();
				$('#buttonCancelDepartment').hide();
				$('#buttonSubmitDepartment').show();
				refreshTableDepartment();
				refreshDepartmentID();
				$('#DepartmentName').val("");
				$('#DepartmentInfo').show();
				document.getElementById("DepartmentInfo").style.color = "green";
				document.getElementById("DepartmentInfo").style.fontSize = "14px";;
				$('#DepartmentInfo').text("Success Delete Department");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	});

	$('.ChooseEditDepartment').click(function() {
		var UpdateDepartmentID = $(this).val();
		$('#buttonUpdateDepartment').show(); $('#buttonCancelDepartment').show(); $('#buttonSubmitDepartment').hide();
		var UpdateDepartmentData = {
	    	DepartmentID 	: UpdateDepartmentID
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/DepartmentEdit',
			data 		: UpdateDepartmentData,
			dataType 	: 'json',
			success:function(data){
				EditDepartmentID 		= data[0].DepartmentID;
				EditDepartmentName 	= data[0].DepartmentName;
				localStorage.setItem('UpdateIDDepartment',EditDepartmentID);
				$('#DepartmentInfo').hide();
				$('#DepartmentID b').remove();
				$('#DepartmentID').append("<b>"+EditDepartmentID+"</b>");
				$('#DepartmentName').val(""+EditDepartmentName+"");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
	});

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

	function padToTWo(number) {
		if (number<=99) { number = ("0"+number).slice(-2); }
		return number;
	}

	function refreshDepartmentID() {
		$('#DepartmentID b').remove();
		$.ajax({
			type 		: 'POST',
			url 		: '/DepartmentCheckID',
			dataType 	: 'json',
			success:function(data) {
				data++;
				departmentID 			= 'D' + padToTWo(data);
				NewDepartmentID 		= departmentID;
				localStorage.setItem('GlobalNewDepartmentID',NewDepartmentID);
				$('#DepartmentID').append("<b>"+NewDepartmentID+"</b>");
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
});