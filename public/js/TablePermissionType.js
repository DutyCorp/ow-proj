$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	function refreshDropdownPT(){
		$('#permitType').html("");
		$.ajax({
			type: 'POST',
			url: '/GetAllPT',
			dataType: 'json',
			success:function(data){
				$('#permitType').append('<option value="None">Select</option>');
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#permitType').append('<option value="'+data[i]['PermissionID']+'">'+data[i]['PermissionType']+'</option>');
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

	function padToTWo(number) {
		if (number<=99) { number = ("0"+number).slice(-2); }
		return number;
	}

	function refreshPermissionTypeID() {
		$('#positionID b').remove();
		$.ajax({
			type 		: 'POST',
			url 		: '/CheckPermissionTypeID',
			dataType 	: 'json',
			success:function(data) {
				data++;
				PermissionTypeID 		= 'P' + padToTWo(data);
				NewPermissionTypeID 	= PermissionTypeID;
				//localStorage.setItem('GlobalNewPositionID',NewPositionID);
				$('#PTID').append("<b>"+NewPermissionTypeID+"</b>");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
           		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	}

	function refreshTablePT(){
		$.ajax({
			type 		: 'POST',
			url 		: '/RefreshTablePT',
			dataType 	: 'json',
			success:function(data){
				console.log(data);
				$('#table').html(data);				
				$('#PTTable').DataTable({
					"bPaginate": false,
					"info":     false,
					"bFilter": false,
				});			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	

	$('#table tbody').on('click', '.ChooseEditPT', function (e) {
        var PTData = {
			ID : $(this).val()
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/EditPermissionType',
			data 		: PTData,
			dataType 	: 'json',
			success:function(data){
				$('#PTID').text(data[0].PermissionID);
				$('#PermissionTypeName').val(data[0].PermissionType);
				$('#buttonAddPermissionType').hide();
				$('#buttonUpdatePermissionType').show();
				$('#buttonCancelPermissionType').show();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
    });

	$('#table tbody').on('click', '.ChooseDeletePT', function (e) {
        var PTData = {
			ID : $(this).val()
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/DeletePermissionType',
			data 		: PTData,
			dataType 	: 'json',
			success:function(data){
				$('#PTID').html("");
				refreshPermissionTypeID();
				refreshTablePT();
				$('#PermissionTypeName').val("");
				$('#buttonUpdatePermissionType').hide();
				$('#buttonCancelPermissionType').hide();
				$('#buttonAddPermissionType').show();
				document.getElementById("Info").style.color = "green";
				$('#Info').text("Success Delete Permission Type");
				refreshDropdownPT();
				
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

});