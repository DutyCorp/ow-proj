$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	function refreshDocumentTable(){
		$.ajax({
			type: 'POST',
			url: '/refreshTableDocument',
			dataType: 'json',
			success:function(data){
				$('#TableDocument').html(data);
				$('#DocumentRegistrationTable').DataTable();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function refreshDropdownDocumentType(){
		$('#DocumentType').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownDocumentType',
			dataType: 'json',
			success:function(data){
				$('#DocumentType').append('<option value="None">Select</option>');
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#DocumentType').append('<option value="'+data[i]['DocumentTypeID']+'">'+data[i]['DocumentTypeName']+'</option>');
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

	function ClearDocument(){
		$('#DocumentRegion').val("None");
		$('#DocumentNumber').val("");
		$('#DocumentType').val("None");
		$('#DocumentOwner').val("None");
		$('#DocumentDate').val("");
		$('#DocumentDestination').val("");
		$('#DocumentDescription').val("");
		$('#DocumentApprover').val("");
		$('#buttonSubmitDocumentRegistration').show();
		$('#buttonClearDocumentRegistration').show();
		$('#buttonUpdateDocumentRegistration').hide();
		$('#buttonCancelDocumentRegistration').hide();
		$('#DocumentNumber').removeAttr("disabled");
	}

	$('#TableDocument tbody').on('click', '.ChooseDeleteDocument', function (e) {
		var DeleteDocumentNumber = $(this).val();
        showModalNotification("One Document will be deleted",1);
		$('#YesDelete').click(function() {
			$('#Modal_Notification').modal('hide');
			var DeleteDocumentData = {
	    		DocumentNumber : DeleteDocumentNumber
			}
		    $.ajax({
				type: 'POST',
				url: '/DeleteDocument',
				data: DeleteDocumentData,
				dataType: 'json',
				success:function(data){
					showModal(data, 1);
					refreshDocumentTable();
					ClearDocument();
					refreshDropdownDocumentType();
				},
				error: function (xhr, ajaxOptions, thrownError) {
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	        		console.log(thrownError);
	       		}
			});
		});
		$('#NoDelete').click(function() {
			$('#Modal_Notification').modal('hide');
		});
    });

    function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return day + '/' + month + '/' + year;
	}

    $('#TableDocument tbody').on('click', '.ChooseEditDocument', function (e) {
        var DocumentNumber = $(this).val();
		$('#buttonUpdateDocumentRegistration').show();
		$('#buttonCancelDocumentRegistration').show();
		$('#buttonSubmitDocumentRegistration').hide();
		$('#buttonClearDocumentRegistration').hide();
		var UpdateDocumentNumber = {
	    	DocumentNumber : DocumentNumber
		}
		$.ajax({
			type: 'POST',
			url: '/EditDocument',
			data: UpdateDocumentNumber,
			dataType: 'json',
			success:function(data){
				$('#DocumentRegion').val(data[0].RegionID);
				$('#DocumentNumber').attr("disabled","disabled");
				$('#DocumentNumber').val(data[0].DocumentNumber);
				$('#DocumentType').val(data[0].DocumentTypeID);
				$('#DocumentOwner').val(data[0].Owner);
				$('#DocumentDate').val(getEditFormattedDate(new Date(data[0].DocumentDate)));
				$('#DocumentDestination').val(data[0].Destination);
				$('#DocumentDescription').val(data[0].Description);
				$('#DocumentApprover').val(data[0].DocumentApprover);
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

    function showModalNotification(data, status){
		$('#LoadingModal').modal('hide');
		if (status == 1){
			$('#ModalHeaderNotification').html('<i class="fa fa-check-circle" aria-hidden="true" style="font-size:24px;color:green"></i> Notification');
			$('#ModalContentNotification').html(data);
		} else {
			$('#ModalHeaderNotification').html('<i class="fa fa-times-circle" aria-hidden="true" style="font-size:24px;color:red"></i> Notification');
			$('#ModalContentNotification').html(data);
		}
		$('#Modal_Notification').modal(); 
	}

});