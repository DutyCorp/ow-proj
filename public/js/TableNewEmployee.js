$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#TableNewEmployee tbody').on('click', '.ContributeNE', function (e) {
        if($(this).is(":checked")){
        	var ContributingData = {
				Region : $('#RA_Region').val(),
				Year   : $('#PP_Year').val(),
				Code   : $(this).val()
			}
			$.ajax({
				type: 'POST',
				url: '/InsertNewEmployeeContributing',
				data: ContributingData,
				dataType: 'json',
				success:function(data){
					refreshTableNewEmployee();
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
	    		Code : ContributingCode
			}
		    $.ajax({
				type: 'POST',
				url: '/DeleteNEContributing',
				data: DeleteContributingData,
				dataType: 'json',
				success:function(data){
					refreshTableNewEmployee();
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

	/*$('#TableNewEmployee tbody').on('click', '.DeleteContributingNE', function (e) {
		var ContributingCode = $(this).val();
		var DeleteContributingData = {
    		Code : ContributingCode
		}
	    $.ajax({
			type: 'POST',
			url: '/DeleteNEContributing',
			data: DeleteContributingData,
			dataType: 'json',
			success:function(data){
				refreshTableNewEmployee();
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
    });

	$("input:checkbox.Contribute").click(function() {
        if($(this).is(":checked")){
        	var ContributingData = {
				Region : $('#RA_Region').val(),
				Year   : $('#PP_Year').val(),
				Code   : $(this).val()
			}
			$.ajax({
				type: 'POST',
				url: '/InsertNewEmployeeContributing',
				data: ContributingData,
				dataType: 'json',
				success:function(data){
					refreshTableNewEmployee();
				},
				error: function (xhr, ajaxOptions, thrownError) {
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	           		console.log(thrownError);
	       		}
			});
        }
    });*/

    function refreshTableNewEmployee(){
		var NewEmployeeData = {
			Region : $('#RA_Region').val(),
			Year   : $('#NE_Year').val(),
		}
		$.ajax({
			type: 'POST',
			url: '/refreshTableNewEmployee',
			data: NewEmployeeData,
			dataType: 'json',
			success:function(data){
				$('#TableNewEmployee').html(data);
				$('#NE_Table').DataTable();
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