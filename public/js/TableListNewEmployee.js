$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#TableListNewEmployee tbody').on('click', '.ChooseDeleteNE', function (e) {
		var EmployeeCode = $(this).val();
		var DeleteEmployee = {
    		ID : EmployeeCode
		}
	    $.ajax({
			type: 'POST',
			url: '/DeleteNE',
			data: DeleteEmployee,
			dataType: 'json',
			success:function(data){
				refreshListNewEmployee();
				document.getElementById("InfoNE_Form").style.color = "green";
				document.getElementById("InfoNE_Form").style.fontSize = "14px";
				$('#InfoNE_Form').text("Success Delete New Employee");
				$('#InfoNE_Form').show();
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
    });

    $('#TableListNewEmployee tbody').on('click', '.ChooseEditNE', function (e) {
		var EmployeeCode = $(this).val();
		var EditEmployee = {
    		ID : EmployeeCode
		}
	    $.ajax({
			type: 'POST',
			url: '/EditNE',
			data: EditEmployee,
			dataType: 'json',
			success:function(data){
				$('#NE_Form_Region').val(data[0].RegionID);
				$('#NE_Form_ID').val(data[0].NewEmployeeID);
				$('#NE_Form_Name').val(data[0].EmployeeName);
				$('#NE_Form_SWD').val(formatDate(new Date(data[0].StartWorkingDate)));
				$('#Update_NE_Form').show();
				$('#Cancel_NE_Form').show();
				$('#Add_NE_Form').hide();
				$('#Clear_NE_Form').hide();
				$('#NE_Form_Region').attr("disabled","disabled");
				$('#NE_Form_ID').attr("disabled","disabled");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
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

    function refreshListNewEmployee(){
		$.ajax({
			type: 'POST',
			url: '/RefreshNewEmployee',
			dataType: 'json',
			success:function(data){
				$('#TableListNewEmployee').html(data);
				$('#NE_List_Table').DataTable();
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