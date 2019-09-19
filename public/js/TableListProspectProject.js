$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#prospectprojectTable tbody').on('click', '.ChooseDeletePP', function (e) {
		var ProjectCode = $(this).val();
		var DeleteProject = {
    		ID : ProjectCode
		}
	    $.ajax({
			type: 'POST',
			url: '/DeletePP',
			data: DeleteProject,
			dataType: 'json',
			success:function(data){
				refreshListProspectProject();
				document.getElementById("InfoPP_Form").style.color = "green";
				document.getElementById("InfoPP_Form").style.fontSize = "14px";
				$('#InfoPP_Form').text("Success Delete New Employee");
				$('#InfoPP_Form').show();
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
    });

    $('#prospectprojectTable tbody').on('click', '.ChooseEditPP', function (e) {
		var EmployeeCode = $(this).val();
		var EditEmployee = {
    		ID : EmployeeCode
		}
	    $.ajax({
			type: 'POST',
			url: '/EditPP',
			data: EditEmployee,
			dataType: 'json',
			success:function(data){
				$('#PP_Form_Region').val(data[0].RegionID);
				$('#projectBA').val(data[0].BusinessArea);
				$('#PP_Form_Year').val(data[0].Year);
				$('#PP_Form_Code').val(data[0].ProspectProjectID);
				$('#PP_Form_Name').val(data[0].ProjectName);
				$('#PP_Form_MDPlan').val(data[0].MDPlan);
				$('#PP_Form_Opportunity').val(data[0].Opportunity);
				$('#PP_Form_StartDate').val(formatDate(new Date(data[0].StartProject)));
				$('#PP_Form_WeightedMD').val((parseInt($('#PP_Form_MDPlan').val()) * parseInt($('#PP_Form_Opportunity').val()))/100);
				$('#Update_PP_Form').show();
				$('#Cancel_PP_Form').show();
				$('#Add_PP_Form').hide();
				$('#Clear_PP_Form').hide();
				$('#PP_Form_Year').attr("disabled","disabled");
				$('#PP_Form_Region').attr("disabled","disabled");
				$('#PP_Form_Code').attr("disabled","disabled");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		alert("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
    });

    function formatDate(date) {
		var monthNames = [
		    "January", "February", "March",
		    "April", "May", "June", "July",
		    "August", "September", "October",
		    "November", "December"
		];
		var day = date.getDate();
		var monthIndex = date.getMonth();
		var year = date.getFullYear();
		return monthNames[monthIndex] + ' ' + year;
	}

    function refreshListProspectProject(){
		$.ajax({
			type: 'POST',
			url: '/RefreshProspectProject',
			dataType: 'json',
			success:function(data){
				$('#prospectprojectTable').html(data);
				$('#PP_List_Table').DataTable();
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