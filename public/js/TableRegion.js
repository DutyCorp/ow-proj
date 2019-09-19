$(document).ready(function() {
	$.ajaxSetup({
  		headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
	});

	$('.ChooseDeleteRegion').click(function() {
		var DeleteRegionID 	= $(this).val();
		$('#RegionModal').modal('hide');
		showModalNotification("One Region will be deleted",1);
		$('#YesDelete').click(function() {
			$('#Modal_Notification').modal('hide');
			var DeleteRegionData 	= {
		    	RegionID: DeleteRegionID
			}
		    $.ajax({
				type 		: 'POST',
				url 		: '/RegionDelete',
				data 		: DeleteRegionData,
				dataType 	: 'json',
				success:function(data){
					$('#RegionModal').modal('show');
					ClearRegion();
					refreshTableRegion();
					$('#RegionInfo').show();
					document.getElementById("RegionInfo").style.color = "green";
					document.getElementById("RegionInfo").style.fontSize = "14px";;
					$('#RegionInfo').text("Success Delete Region");

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
			$('#RegionModal').modal('show');
		});
	});

	$('.ChooseEditRegion').click(function() {
		var UpdateRegionID = $(this).val();
		$('#RegionInfo').hide();
		$('#buttonUpdateRegion').show();
		$('#buttonCancelRegion').show();
		$('#buttonSubmitRegion').hide();
		var UpdateRegionData = {
	    	RegionID 	: UpdateRegionID
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/RegionEdit',
			data 		: UpdateRegionData,
			dataType 	: 'json',
			success:function(data){
				$('#RegionID').attr("disabled","disabled");
				$('#RegionID').val(data[0].RegionID);
				$('#RegionName').val(data[0].RegionName);
				$('#RegionPhone').val(data[0].Phone_Office);
				$('#RegionAddress').val(data[0].Address);
				$('#RegionFax').val(data[0].Fax);
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
	});

	function ClearRegion(){
		$('#buttonUpdateRegion').hide();
		$('#buttonCancelRegion').hide();
		$('#buttonSubmitRegion').show();
		$('#RegionID').val("");
		$('#RegionID').removeAttr("disabled");
		$('#RegionName').val("");
		$('#RegionPhone').val("");
		$('#RegionAddress').val("");
		$('#RegionFax').val("");
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

	function padToTWo(number) {
		if (number<=99) { number = ("0"+number).slice(-2); }
		return number;
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