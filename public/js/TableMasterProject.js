$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('#masterProjectTable').DataTable();

	function ClearMasterProject() {
		$('#newProjectType').val("")
		$('#projectCode').val("");
		$('#projectName').val("");
		$('#projectRegion').val("AS");
		$('#projectType').val("None");
		$('#newPT').hide();
		$('#PT').show();
		$('#projectCode').removeAttr("disabled");
		$('#buttonUpdateMasterProject').hide();
		$('#buttonCancelMasterProject').hide();
		$('#buttonSubmitMasterProject').show();
		$('#buttonClearMasterProject').show();
	}

	$('#tableMasterProject tbody').on('click', '.ChooseEditMasterProject', function (e) {
        var ProjectID = $(this).val();
		$('#buttonUpdateMasterProject').show();
		$('#buttonCancelMasterProject').show();
		$('#buttonSubmitMasterProject').hide();
		$('#buttonClearMasterProject').hide();

		$('#PT').show();
		$('#newPT').hide();
		$('#projectCode').attr("disabled","disabled");
		
		var UpdateProjectData = {
	    	ProjectID : ProjectID
		}
		$.ajax({
			type: 'POST',
			url: '/EditProject',
			data: UpdateProjectData,
			dataType: 'json',
			success:function(data){
				localStorage.setItem('UpdateID_for_MasterProject', ProjectID);
				$('#projectCode').val(data[0].ProjectID);
				$('#projectName').val(data[0].ProjectName);
				$('#projectType').val(data[0].ProjectType);
				$('#projectRegion').val(data[0].RegionID);
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
     } );

	$('#tableMasterProject tbody').on('click', '.ChooseDeleteMasterProject', function (e) {
        var DeleteProjectID = $(this).val();
        showModalNotification("One Project will be deleted",1);
		$('#YesDelete').click(function() {
			$('#Modal_Notification').modal('hide');
			var DeleteProjectData = {
	    		ProjectID : DeleteProjectID
			}
		    $.ajax({
				type: 'POST',
				url: '/DeleteProject',
				data: DeleteProjectData,
				dataType: 'json',
				success:function(data){
					showModal(data, 1);
					refreshTableProject();
					ClearMasterProject();
					$.ajax({
						type: 'POST',
						url: '/refreshProjectType',
						dataType: 'json',
						success:function(data){
							$('#projectType').empty();
							$('#projectType').append('<option value="None">Select</option>');
							var j = data.length;
							for (var i = 0; i < j; i++){
								$('#projectType').append('<option value="'+data[i]['ProjectType']+'">'+data[i]['ProjectType']+'</option>');
							}
						},
						error: function (xhr, ajaxOptions, thrownError) {
							showModal("Whoops! Something wrong", 0);
							console.log(xhr.status);
							console.log(xhr.responseText);
							console.log(thrownError);
						}
					});
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

    function refreshTableProject() {
		$.ajax({
			type: 'POST',
			url: '/refreshTableProject',
			dataType: 'json',
			success:function(data){
				$('#tableMasterProject').html(data);
				$('#masterProjectTable').DataTable();
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