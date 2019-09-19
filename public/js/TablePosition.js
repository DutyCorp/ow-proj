$(document).ready(function() {
	$.ajaxSetup({
  		headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
	});

	$('.ChooseDeletePosition').click(function() {
		var DeletePositionID 	= $(this).val();
		var DeletePositionData 	= {
	    	positionID: DeletePositionID
		}
	    $.ajax({
			type 		: 'POST',
			url 		: '/PositionDelete',
			data 		: DeletePositionData,
			dataType 	: 'json',
			success:function(data){
				$('#buttonUpdatePosition').hide();
				$('#buttonCancelPosition').hide();
				$('#buttonSubmitPosition').show();
				refreshTablePosition();
				refreshPositionID();
				$('#positionName').val("");
				$('#PositionInfo').show();
				document.getElementById("PositionInfo").style.color = "green";
				document.getElementById("PositionInfo").style.fontSize = "14px";;
				$('#PositionInfo').text("Success Delete Position");

			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	});

	$('.ChooseEditPosition').click(function() {
		var UpdatePositionID = $(this).val();
		$('#buttonUpdatePosition').show();
		$('#buttonCancelPosition').show();
		$('#buttonSubmitPosition').hide();
		var UpdatePositionData = {
	    	positionID 	: UpdatePositionID
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/PositionEdit',
			data 		: UpdatePositionData,
			dataType 	: 'json',
			success:function(data){
				EditPositionID 		= data[0].PositionID;
				EditPositionName 	= data[0].PositionName;
				localStorage.setItem('UpdateID',EditPositionID);
				$('#PositionInfo').hide();
				$('#positionID b').remove();
				$('#positionID').append("<b>"+EditPositionID+"</b>");
				$('#positionName').val(""+EditPositionName+"");
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

	function refreshPositionID(){
		$('#positionID b').remove();
		$.ajax({
			type 		: 'POST',
			url 		: '/PositionCheckID',
			dataType 	: 'json',
			success:function(data){
				data++;
				positionID 		= 'PS' + padToTWo(data);
				NewPositionID 	= positionID;
				localStorage.setItem('GlobalNewPositionID',NewPositionID);
				$('#positionID').append("<b>"+NewPositionID+"</b>");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
           		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	}

	function refreshTablePosition(){
		$('#tablePosition').html("");
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTablePosition',
			dataType 	: 'json',
			success:function(data){
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
});