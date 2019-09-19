$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#ProjectLeadTable tbody').on('click', '.ChooseDeletePL', function (e) {
		var DeleteProjectLead = $(this).val();
		var ProjectLeadData = {
	    	PL_ID 	: DeleteProjectLead
		}
		$.ajax({
			type: 'POST',
			url: '/DeleteProjectLead',
			data: ProjectLeadData,
			dataType: 'json',
			success:function(data){
				document.getElementById("InfoProjectLead").style.color = "green";
				$('#InfoProjectLead').text("Success Delete Project Lead");
				$('#InfoProjectLead').show();
				refreshTableProjectLead();
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
    });

    function refreshTableProjectLead(){
		var RegionData = {
	    	RegionID 	: $('#RegionProjectLead').val()
		}
		$.ajax({
			type: 'POST',
			url: '/GetProjectLeadList',
			data: RegionData,
			dataType: 'json',
			success:function(data){
				$('#ProjectLeadTable').html(data);
				$('#TableRegionProjectLead').DataTable({
					"columnDefs": [    
						{ "width": "10%", "targets": 0 },
						{ "width": "80%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
					],
					"bPaginate": false,
					"info":     false,
					"bFilter": false,
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

