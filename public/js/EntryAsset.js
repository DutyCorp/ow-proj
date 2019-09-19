$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('#assetValue').maskNumber();
	$('#assetSellingPrice').maskNumber();
	localStorage.setItem("flagChangeAssetID","1");
	refreshTableAsset();
	var assetClassDescription;
	var assetCount;
	$('#buttonUpdateAsset').hide();
	$('#buttonCancelAsset').hide();
	$('#assetSellingPrice').attr("disabled","disabled");
	$('#assetSellingPriceCurrency').attr("disabled","disabled");
	$('#MS').attr("disabled","disabled");
	$('#IS').attr("disabled","disabled");

	function ModalAlert(Info,Alert,Color){
    	$('#'+Info).show();
        $('#'+Info).text(Alert);
		document.getElementById(Info).style.color = Color;
		document.getElementById(Info).style.fontSize = "14px";
    }

    $('#myModal').on('hidden.bs.modal', function (e) {
        $('#assetType').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownAssetType',
			dataType: 'json',
			success:function(data){
				$('#assetType').append('<option value="None">Select</option>');
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#assetType').append('<option value="'+data[i]['AssetTypeID']+'">'+data[i]['AssetTypeName']+'</option>');
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

	$('#closeATButton').click(function() {
		$('#assetType').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownAssetType',
			dataType: 'json',
			success:function(data){
				$('#assetType').append('<option value="None">Select</option>');
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#assetType').append('<option value="'+data[i]['AssetTypeID']+'">'+data[i]['AssetTypeName']+'</option>');
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

	$('#buttonCancelAssetType').click(function() {
		$('#buttonUpdateAssetType').hide();
		$('#buttonCancelAssetType').hide();
		$('#buttonSubmitAssetType').show();
		$('#assetTypeName').val("");
		refreshTableAssetType();
		refreshAssetTypeID();
	});
	
	$('#buttonUpdateAssetType').click(function() {
		var UpdateAssetTypeName = $('#assetTypeName').val();
	    if (UpdateAssetTypeName == "") {
	        ModalAlert("ATInfo","Asset Type must be filled","red");
	        return false;
	    }
	    var UpdateAssetTypeData = {
	    	assetTypeID: localStorage.getItem('UpdateAssetTypeID'),
	    	assetTypeName: $('#assetTypeName').val()
	    }
	    $.ajax({
	    	type: 'POST',
	    	url: '/AssetTypeUpdate',
	    	data: UpdateAssetTypeData,
	    	dataType: 'json',
	    	success:function(data){
	    		ModalAlert("ATInfo",data,"red");
	    		$('#buttonCancelAssetType').hide();
				$('#buttonUpdateAssetType').hide();
				$('#buttonSubmitAssetType').show();
	    		$('#assetTypeName').val("");
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

	$('#buttonSubmitAssetType').click(function() {
		var EntryAssetTypeName = $('#assetTypeName').val();
	    if (EntryAssetTypeName == "") {
	    	ModalAlert("ATInfo","Asset Type must be filled","red");
	        return false;
	    }
	    else 
	    {
	    	var EntryPositionData = {
	   			assetTypeID: $('#assetTypeID').val(),
	    		assetTypeName: $('#assetTypeName').val(),
			}
	    	$.ajax({
				type: 'POST',
				url: '/AddAssetTypeID',
				data: EntryPositionData,
				dataType: 'json',
				success:function(data){
					$('#assetTypeID b').remove();
					refreshTableAssetType();
					refreshAssetTypeID();
					$('#assetTypeName').val("");
					ModalAlert("ATInfo",data,"green");
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

	function refreshTableAssetType() {
		$('#tableAssetType').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshTableAssetType',
			dataType: 'json',
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
			type: 'POST',
			url: '/AssetTypeCheckID',
			dataType: 'json',
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

	$('#addAssetType').click(function() {
		refreshTableAssetType();
		$('#buttonUpdateAssetType').hide();
		$('#buttonCancelAssetType').hide();
		$('#ATInfo').hide();
		refreshAssetTypeID();
	});

	$('#buttonCancelAsset').click(function() {
		if ($('#RoleI').val() == "0"){
			$('#insertAsset').hide();
		}
		clearAllAssetForm();
	});

	$('#assetLocation').change(function() {
		if(localStorage.getItem('flagChangeAssetID') == 1){
			if($('#assetClass').val() == "None" || $('#assetLocation').val() == "None")
				$('#assetNumber').val("");
			if($('#assetClass').val() != "None" && $('#assetLocation').val() != "None")
				getAssetNumber();
		}
	});
	
	$('#assetClass').change(function(){
		if($('#assetClass').val() == "None")
			$('#assetClassDescription').html("-");
		else if($('#assetClass').val() == "CE")
			$('#assetClassDescription').html("Computer Equipment");
		else if($('#assetClass').val() == "FF")
			$('#assetClassDescription').html("Furniture and Fixtures");	
		else if($('#assetClass').val() == "OE")
			$('#assetClassDescription').html("Office Equipment");	
		else if($('#assetClass').val() == "SO")
			$('#assetClassDescription').html("Software");

		if($('#assetClass').val() == "None" || $('#assetLocation').val() == "None")
			$('#assetNumber').val("");

		if($('#assetLocation').val() != "None" && $('#assetClass').val() != "None")
			getAssetNumber();
	});	
	
	$('#assetStatus').change(function() {
		if($('#assetStatus').val() == "Sold") {
			$('#assetSellingPriceCurrency').removeAttr("disabled");
			$('#assetSellingPrice').removeAttr("disabled");
			if(localStorage.getItem('flagChangeAssetID') == 0) {
				$('#selectOwner').attr("disabled","disabled");
				$('#assetLocation').attr("disabled","disabled");
			}
		}else if($('#assetStatus').val() == "Mutation") {
			$('#selectOwner').removeAttr("disabled");
			$('#assetLocation').removeAttr("disabled");
			$('#assetSellingPrice').attr("disabled","disabled");
			$('#assetSellingPriceCurrency').attr("disabled","disabled");
		}else {
			$('#assetSellingPrice').attr("disabled","disabled");
			$('#assetSellingPriceCurrency').attr("disabled","disabled");
			if(localStorage.getItem('flagChangeAssetID') == 0) {
				$('#selectOwner').attr("disabled","disabled");
				$('#assetLocation').attr("disabled","disabled");
			}
		}
	});

	$('#buttonUpdateAsset').click(function() {
		var assetIsActive = 1;

		var AssetStatus 	= $('#assetStatus').val();
		var AssetLocation 	= $('#assetLocation').val();
		var SerialNumber 	= $('#assetSerialNumber').val();
		var AssetDesc 		= $('#assetDescription').val();
		AssetDesc 			= AssetDesc.replace(/"/g,"''");
		var Owner 			= $('#selectOwner').val();
		var AssetType 		= $('#assetType').val();
		var AssetValue 		= $('#assetValue').val();
		var AssetValueCurr 	= $('#assetValueCurrency').val();
		var AssetSellPrice 	= $('#assetSellingPrice').val();
		var AssetSellCurr 	= $('#assetSellingPriceCurrency').val();

		var AcqDate 		= $('#assetAcquisitionDate').val();
		var Tanggal 		= AcqDate.split("/");
		AcqDate 			= getEditFormattedDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));

		var GuaranteeDate 	= $('#assetGuaranteeDate').val();
		if(GuaranteeDate == ""){
			GuaranteeDate = "1900-01-01";
		}else{
			var Tanggal 		= GuaranteeDate.split("/");
			GuaranteeDate 		= getEditFormattedDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));	
		}

		if(AssetLocation == "None") {
			showModal("Asset Location must be chosen", 0);
	    	return false;
		}
		else if(SerialNumber == "") {
			showModal("Serial Number must be filled", 0);
	    	return false;
		}
		else if(AssetStatus == "None") {
			showModal("Asset Status must be chosen", 0);
	    	return false;
		}
		else if(AssetDesc == "") {
			showModal("Asset Description must be filled", 0);
	    	return false;
		}
		else if(Owner == "None") {
			showModal("Asset Owner must be filled", 0);
	    	return false;
		}
		else if(AcqDate == "") {
			showModal("Acquisition Date must be chosen", 0);
	    	return false;
		}
		else if(AssetType == "None") {
			showModal("Asset Type must be chosen", 0);
	    	return false;
		}
		else if(AssetValue == "") {
			showModal("Asset Value must be filled", 0);
	    	return false;
		}
		else if(AssetValueCurr == "None") {
			showModal("Asset Value Currency must be chosen", 0);
	    	return false;
		}
		else if(AssetStatus == "Sold" && (AssetSellPrice == "0" || AssetSellCurr == "None")) {
			if(AssetSellPrice == "0" || AssetSellPrice == "") {
				showModal("Asset Selling Price must be filled", 0);
		    	return false;
			}
			if(AssetSellCurr == "None") {
				showModal("Asset Selling Price Currency must be chosen", 0);
		    	return false;
		    }
		}else {
			if(AssetStatus == "Mutation")
				EntryNewAsset();
			if(AssetStatus == "Sold" || AssetStatus == "InActive" || AssetStatus == "Mutation") 
				assetIsActive = 0;
			var UpdateAssetData = {
		    	assetLocation 				: AssetLocation,
		    	assetStatus 				: AssetStatus,
		    	assetSerialNumber 			: SerialNumber,
		    	assetDescription 			: AssetDesc,
		    	assetRoom 					: $('#assetRoom').val(),
		    	assetAcquisitionDate 		: AcqDate,
		    	assetGuaranteeDate 			: GuaranteeDate,
		    	assetType 					: AssetType,
		    	assetValue 					: AssetValue,
		    	assetValueCurrency 			: AssetValueCurr,
		    	assetNotes 					: $('#assetNotes').val(),
		    	assetSellingPrice 			: AssetSellPrice,
		    	assetSellingPriceCurrency 	: AssetSellCurr,
		    	assetIsActive 				: assetIsActive,
		    	assetMainKey 				: localStorage.getItem('UpdateID_for_Asset')
			}
			$.ajax({
				type: 'POST',
				url: '/AssetUpdate',
				data: UpdateAssetData,
				dataType: 'json',
				success:function(data) {
					if ($('#RoleI').val() == "0")
						$('#insertAsset').hide();
					showModal(data, 1);
					refreshTableAsset();
					clearAllAssetForm();
					localStorage.setItem('flagChangeAssetID',"1");
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

	$('#buttonSubmitAsset').click(function() {
		if($('#assetClass').val() == "None") {
			showModal("Asset Class must be chosen", 0);
	    	return false;
		}
		else if($('#assetLocation').val() == "None") {
			showModal("Asset Location must be chosen", 0);
	    	return false;
		}
		else if($('#assetStatus').val() == "None") {
			showModal("Asset Status must be chosen", 0);
	    	return false;
		}
		else if($('#assetDescription').val() == "") {
			showModal("Asset Description must be filled", 0);
	    	return false;
		}
		else if($('#assetOwner').val() == "") {
			showModal("Asset Owner must be filled", 0);
	    	return false;
		}
		else if($('#assetAcquisitionDate') == "") {
			showModal("Asset Acquisition must be chosen", 0);
	    	return false;
		}
		else if($('#assetDepartment').val() == "None") {
			showModal("Asset Department must be chosen", 0);
	    	return false;
		}
		else if($('#assetValue').val() == "") {
			showModal("Asset Value must be filled", 0);
	    	return false;
		}
		else if($('#assetValueCurrency').val() == "None") {
			showModal("Asset Value Currency must be chosen", 0);
	    	return false;
		}
		else if($('#assetStatus').val() == "Sold") {
			if($('#assetSellingPrice').val() == "") {
				showModal("Asset Selling Price must be filled", 0);
		    	return false;
			}else if($('#assetSellingPriceCurrency').val() == "None") {
				showModal("Asset Selling Price Currency must be chosen", 0);
		    	return false;
			}else
				EntryNewAsset();
		}else {
			EntryNewAsset();
		}
	});

	$('#buttonClearAsset').click(function() {
		clearAllAssetForm();
	});

	function padToTWo(number) {
		if (number<=99) { number = ("0"+number).slice(-2); }
		return number;
	}

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return year + '-' + month + '-' + day;
	}

	function getAssetNumber() {
		var AssetData = {
			assClass : $('#assetClass').val()
		}
		$.ajax({
			type: 'POST',
			url: '/CheckAssetNumber',
			data: AssetData,
			dataType: 'json',
			success:function(data){
				assetCount = parseInt(data) + 1;
				var AssLocaction = $('#assetLocation').val();
				var AssClass = $('#assetClass').val();
				var AssNumber = 'OWA-'  + AssLocaction + '/' + AssClass + '-' + padToFive(assetCount);
				$('#assetNumber').val(AssNumber);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function clearAllAssetForm(){
		$('#assetNumber').val("");
		$('#assetStatus').val("None");
		$('#assetSerialNumber').val("");
		$('#assetClass').val("None");
		$('#assetLocation').val("None");
		$('#assetClassDescription').html("-");
		$('#assetDescription').val("");
		$('#selectOwner').val("None");
		$('#assetRoom').val("");
		$('#assetAcquisitionDate').val("");
		$('#assetGuaranteeDate').val("");
		$('#assetType').val("None");
		$('#assetValue').val("");
		$('#assetValueCurrency').val("None");
		$('#assetNotes').val("");
		$('#assetSellingPrice').val("");
		$('#assetSellingPriceCurrency').val("None");
		$('#buttonUpdateAsset').hide();
		$('#buttonCancelAsset').hide();
		$('#buttonSubmitAsset').show();
		$('#buttonClearAsset').show();
		$('#selectOwner').removeAttr("disabled");
		$('#assetLocation').removeAttr("disabled");
		$('#assetAcquisitionDate').removeAttr("disabled");
		$('#assetValue').removeAttr("disabled");
		$('#assetValueCurrency').removeAttr("disabled");
		$('#assetGuaranteeDate').removeAttr("disabled");
		$('#assetSerialNumber').removeAttr("disabled");
		$('#assetType').removeAttr("disabled");
		$('#assetClass').removeAttr("disabled");
		localStorage.setItem('flagChangeAssetID',"1");
		$('#assetSellingPrice').attr("disabled","disabled");
		$('#assetSellingPriceCurrency').attr("disabled","disabled");
	}

	function EntryNewAsset(){
		var assetIsActive = 1;
		var temp_StatusMutation = $('#assetStatus').val();
		if($('#assetStatus').val() == "Sold") {
			assetIsActive = 0;
		}
		if(temp_StatusMutation == "Mutation") {
			temp_StatusMutation = "Active";
		}
		var AcqDate 		= $('#assetAcquisitionDate').val();
		var Tanggal 		= AcqDate.split("/");
		AcqDate 			= getEditFormattedDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));

		var GuaranteeDate 	= $('#assetGuaranteeDate').val();
		if(GuaranteeDate == ""){
			GuaranteeDate = "1900-01-01";
		}else{
			var Tanggal 		= GuaranteeDate.split("/");
			GuaranteeDate 		= getEditFormattedDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));	
		}

		var assetDescription = $('#assetDescription').val();
		assetDescription = assetDescription.replace(/"/g,"''");

		var EntryAssetData = {
			assetNumber  				: $('#assetNumber').val(),
	    	assetClass 					: $('#assetClass').val(),
	    	assetLocation 				: $('#assetLocation').val(),
	    	assetStatus 				: temp_StatusMutation,
	    	assetSerialNumber 			: $('#assetSerialNumber').val(),
	    	assetDescription 			: assetDescription,
	    	assetOwner 					: $('#selectOwner').val(),
	    	assetRoom 					: $('#assetRoom').val(),
	    	assetAcquisitionDate 		: AcqDate,
	    	assetGuaranteeDate 			: GuaranteeDate,
	    	assetType 					: $('#assetType').val(),
	    	assetDepartment 			: $('#assetDepartment').val(),
	    	assetNotes 					: $('#assetNotes').val(),
	    	assetValue 					: $('#assetValue').val(),
	    	assetValueCurrency 			: $('#assetValueCurrency').val(),
	    	assetSellingPrice 			: $('#assetSellingPrice').val(),
	    	assetSellingPriceCurrency	: $('#assetSellingPriceCurrency').val(),
	    	assetIsActive 				: assetIsActive
		}
		$.ajax({
			type: 'POST',
			url: '/EntryNewAsset',
			data: EntryAssetData,
			dataType: 'json',
			success:function(data) {
				showModal(data, 1);
				refreshTableAsset();
				clearAllAssetForm();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
       			console.log(xhr.status);
       			console.log(xhr.responseText);
       			console.log(thrownError);
   			}
		});
	}

	function refreshTableAsset() {
		$('#tableAsset').html("");		
		$('#divLoading').show();
		$.ajax({
			type: 'POST',
			url: '/refreshTableAsset',
			dataType: 'json',
			success:function(data){
				$('#divLoading').hide();
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

	function padToFive(number) {
		if (number<=9999) { number = ("0000"+number).slice(-5); }
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