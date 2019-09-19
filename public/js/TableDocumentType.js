$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	function ClearDocumentType(){
		$('#DocumentTypeName').val("");
		$('#buttonUpdateDocumentType').hide();
		$('#buttonCancelDocumentType').hide();
		$('#buttonAddDocumentType').show();
	}



	$('#tableDocumentType tbody').on('click', '.ChooseEditDocumentType', function (e) {
        var DocumentTypeID = $(this).val();
		$('#buttonUpdateDocumentType').show();
		$('#buttonCancelDocumentType').show();
		$('#buttonAddDocumentType').hide();
		
		var UpdateDocumentTypeData = {
	    	DocumentTypeID : DocumentTypeID
		}
		$.ajax({
			type: 'POST',
			url: '/EditDocumentType',
			data: UpdateDocumentTypeData,
			dataType: 'json',
			success:function(data){
				localStorage.setItem('UpdateID_for_DocumentType', DocumentTypeID);
				$('#DocumentTypeName').val(data[0].DocumentTypeName);
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
    });

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

	$('#tableDocumentType tbody').on('click', '.ChooseDeleteDocumentType', function (e) {
		$('#ModalAddDocumentType').modal('hide');
        var DeleteDocumentTypeID = $(this).val();
        showModalNotification("One Document Type will be deleted",1);
		$('#YesDelete').click(function() {
			$('#Modal_Notification').modal('hide');
			var DeleteDocumentTypeData = {
	    		DocumentTypeID : DeleteDocumentTypeID
			}
		    $.ajax({
				type: 'POST',
				url: '/DeleteDocumentType',
				data: DeleteDocumentTypeData,
				dataType: 'json',
				success:function(data){
					showModal(data, 1);
					refreshDocumentTypeTable();
					ClearDocumentType();
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

    function refreshDocumentTypeTable(){
		$.ajax({
			type: 'POST',
			url: '/refreshTableDocumentType',
			dataType: 'json',
			success:function(data){
				$('#tableDocumentType').html(data);
				$('#DocumentTypeTable').DataTable();
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