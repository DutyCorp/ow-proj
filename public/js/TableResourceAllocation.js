$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#TableProspectProject tbody').on('click', '.ContributeCB', function (e) {
        if($(this).is(":checked")){
        	var ContributingData = {
				Region : $('#RA_Region').val(),
				Year   : $('#PP_Year').val(),
				Code   : $(this).val()
			}
			$.ajax({
				type: 'POST',
				url: '/InsertProspectProjectContributing',
				data: ContributingData,
				dataType: 'json',
				success:function(data){
					refreshTableProspectProject();
				},
				error: function (xhr, ajaxOptions, thrownError) {
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	           		console.log(thrownError);
	       		}
			});
        } else {
        	var ContributingCode = $(this).val();
			var DeleteContributingData = {
	    		Code : ContributingCode,
	    		Region : $('#RA_Region').val(),
				Year   : $('#PP_Year').val(),
			}
		    $.ajax({
				type: 'POST',
				url: '/DeleteContributing',
				data: DeleteContributingData,
				dataType: 'json',
				success:function(data){
					refreshTableProspectProject();
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

    function refreshTableProspectProject(){
		var ProspectProjectData = {
			Region : $('#RA_Region').val(),
			Year   : $('#PP_Year').val(),
		}
		$.ajax({
			type: 'POST',
			url: '/refreshTableProspectProject',
			data: ProspectProjectData,
			dataType: 'json',
			success:function(data){
				$('#TableProspectProject').html(data);
				$('#PP_Table').DataTable({
					"order": [[8, 'asc']]
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