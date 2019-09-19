$(document).ready(function() {
	$.ajaxSetup({
  		headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
	});

	$('.ChooseDeleteBA').click(function() {
		var DeleteBA 	 	= $(this).val();
		var DeleteBAData 	= {
	    	BAID 		: DeleteBA
		}
	    $.ajax({
			type 		: 'POST',
			url 		: '/BADelete',
			data 		: DeleteBAData,
			dataType 	: 'json',
			success:function(data){
				ClearBA();
				$('#Info_BA').show();
				$('#Info_BA').text("Success Delete Business Area");
				document.getElementById("Info_BA").style.color = "green";
				document.getElementById("Info_BA").style.fontSize = "14px";
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	});

	function ClearBA(){
		$('#AddBAID').removeAttr("disabled");
		$('#AddBAID').val("");
		$('#AddBAName').val("");
		$('#buttonUpdateBA').hide(); 
		$('#buttonCancelBA').hide(); 
		$('#buttonAddBA').show();
		$('#Info_BA').hide();
		refreshTableBusinessArea();
	}

	$('.ChooseEditBA').click(function() {
		var UpdateBA = $(this).val();
		$('#buttonUpdateBA').show(); 
		$('#buttonCancelBA').show(); 
		$('#buttonAddBA').hide();
		var UpdateBAData = {
	    	BAID 	: UpdateBA
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/BAEdit',
			data 		: UpdateBAData,
			dataType 	: 'json',
			success:function(data){
				EditBAID 		= data[0].BusinessAreaID;
				EditBAName 		= data[0].BusinessAreaName;
				$('#AddBAID').attr("disabled","disabled");
				$('#AddBAID').val(EditBAID);
				$('#AddBAName').val(EditBAName);
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

	function refreshTableBusinessArea() {
		$('#tableBA').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshTableBusinessArea',
			dataType: 'json',
			success:function(data){
				$('#tableBA').html(data);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

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