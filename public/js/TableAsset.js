$(document).ready(function() {
	$.ajaxSetup({
  		headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
	});

	function refreshTableAsset() {
		$('#tableAsset').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshTableAsset',
			dataType: 'json',
			success:function(data){
				$('#tableAsset').html(data);
				$('#assetTable').DataTable({   
					"columnDefs": [     
						{ "width": "8%", "targets": 0 },
						{ "width": "5%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
						{ "width": "5%", "targets": 3 },
						{ "width": "5%", "targets": 4 },
						{ "width": "8%", "targets": 5 },
						{ "width": "3%", "targets": 6 },
						{ "width": "8%", "targets": 7 },
						{ "width": "6%", "targets": 8 },
						{ "width": "10%", "targets": 9 },         
						{ "width": "8%", "targets": 11 },     
						{ "width": "5%", "targets": 10 },
					] 
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	$('#tableAsset tbody').on('click', '.ChooseDeleteAsset', function (e) {
        var DeleteAssetID = $(this).val();
        showModalNotification("One Record will be deleted",1);
		$('#YesDelete').click(function() {
			$('#Modal_Notification').modal('hide');
			var DeleteAssetData = {
	    	assetID: DeleteAssetID
			}
		    $.ajax({
				type: 'POST',
				url: '/AssetDelete',
				data: DeleteAssetData,
				dataType: 'json',
				success:function(data){
					ModalAlert("ATInfo",data,"green");
					refreshTableAsset();
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

	$('#tableAsset tbody').on('click', '.ChooseEditAsset', function (e) {
        var UpdateAssetID = $(this).val();
		var temp_SPC;
		localStorage.setItem('flagChangeAssetID',"0");
		$('#buttonUpdateAsset').show();
		$('#buttonCancelAsset').show();
		$('#buttonSubmitAsset').hide();
		$('#buttonClearAsset').hide();
		$('#MS').removeAttr("disabled");
		$('#IS').removeAttr("disabled");
		$('#selectOwner').attr("disabled","disabled");
		$('#assetLocation').attr("disabled","disabled");
		$('#assetClass').attr("disabled","disabled");
		
		var UpdateAssetData = {
	    	assetID : UpdateAssetID
		}
		$.ajax({
			type: 'POST',
			url: '/AssetEdit',
			data: UpdateAssetData,
			dataType: 'json',
			success:function(data){
				$('#insertAsset').show();
				var UpdateID = data[0].TransactionAssetID;
				localStorage.setItem('UpdateID_for_Asset', UpdateID);
				$('#assetNumber').val(data[0].AssetNumber);
				$('#assetClass').val(data[0].AssetClassID);
				$('#assetLocation').val(data[0].RegionID);
				$('#assetStatus').val(data[0].AssetStatus);
				$('#assetSerialNumber').val(data[0].SerialNumber);
				$('#assetDescription').val(data[0].AssetDescription);
				$('#selectOwner').val(data[0].EmployeeID);
				$('#assetRoom').val(data[0].AssetRoom);
				$('#assetAcquisitionDate').val(getEditFormattedDate(new Date(data[0].AcquisitionDate)));
				$('#assetGuaranteeDate').val(getEditFormattedDate(new Date(data[0].GuaranteeDate)));
				$('#assetType').val(data[0].AssetTypeID);
				$('#assetNotes').val(data[0].Notes);
				$('#assetValue').val(data[0].PriceBuy);
				$('#assetValueCurrency').val(data[0].CurrencyBuy);
				$('#assetSellingPrice').val(data[0].PriceSell);
				temp_SPC = data[0].CurrencySell;
				if(temp_SPC == "")
					temp_SPC == "None";
				$('#assetSellingPriceCurrency').temp_SPC;
				$('html, body').animate({ scrollTop: $('#insertAsset').offset().top }, 'slow');
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
    });

	function ModalAlert(Info,Alert,Color){
    	$('#'+Info).show();
        $('#'+Info).text(Alert);
		document.getElementById(Info).style.color = Color;
		document.getElementById(Info).style.fontSize = "14px";
    }

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return day + '/' + month + '/' + year;
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