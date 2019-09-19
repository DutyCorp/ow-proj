$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('.ChooseDeleteAT').click(function() {
		var DeleteAssetTypeID 	= $(this).val();
		var DeleteAssetTypeData = {
	    	AssetTypeID: DeleteAssetTypeID
		}
	    $.ajax({
			type 		: 'POST',
			url 		: '/AssetTypeDelete',
			data 		: DeleteAssetTypeData,
			dataType 	: 'json',
			success:function(data){
				showModal(data, 1);
				refreshTableAssetType();
				refreshAssetTypeID();
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	});

	$('.ChooseEditAT').click(function() {
		var UpdateAssetTypeID 	= $(this).val();
		$('#buttonUpdateAssetType').show(); 
		$('#buttonCancelAssetType').show(); 
		$('#buttonSubmitAssetType').hide();

		var UpdateAssetTypeData = {
	    	AssetTypeID : UpdateAssetTypeID
		}
		$.ajax({
			type 	 	: 'POST',
			url 	 	: '/AssetTypeEdit',
			data 	 	: UpdateAssetTypeData,
			dataType 	: 'json',
			success:function(data){
				EditPAssetTypeID = data[0].AssetTypeID;
				EditPositionName = data[0].AssetTypeName;
				localStorage.setItem('UpdateAssetTypeID',EditPAssetTypeID);
				$('#assetTypeID').val(EditPAssetTypeID);
				$('#assetTypeName').val(EditPositionName);
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
	});

	function refreshTableAssetType() {
		$('#tableAssetType').html("");
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableAssetType',
			dataType 	: 'json',
			success:function(data) {
				$('#tableAssetType').html(data);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function refreshAssetTypeID() {
		$('#assetTypeID b').remove();
		$.ajax({
			type 		: 'POST',
			url 		: '/AssetTypeCheckID',
			dataType 	: 'json',
			success:function(data) {
				data++;
				AssetTypeID = 'AT' + padToTWo(data);
				$('#assetTypeID').val(AssetTypeID);
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
           		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	}

	function padToTWo(number) {
		if (number<=99) { number = ("0"+number).slice(-2); }
		return number;
	}

	$('#btnAlright').click(function() {
		$('#Modal').modal('hide');
	});

	function showModal(data, status){
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