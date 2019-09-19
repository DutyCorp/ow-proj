$(document).ready(function() {
	$.ajaxSetup({
  		headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
	});

	$('.ChooseDeleteGrade').click(function() {
		var DeleteGradeID 	= $(this).val();
		var DeleteGradeData 	= {
	    	GradeID: DeleteGradeID
		}
	    $.ajax({
			type 		: 'POST',
			url 		: '/GradeDelete',
			data 		: DeleteGradeData,
			dataType 	: 'json',
			success:function(data){
				ClearGrade();
				$('#GradeInfo').show();
				document.getElementById("GradeInfo").style.color = "green";
				document.getElementById("GradeInfo").style.fontSize = "14px";;
				$('#GradeInfo').text("Success Delete Grade");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	});

	$('.ChooseEditGrade').click(function() {
		var UpdateGradeID = $(this).val();
		$('#buttonUpdateGrade').show();
		$('#buttonCancelGrade').show(); 
		$('#buttonSubmitGrade').hide();
		var UpdateGradeData = {
	    	GradeID 	: UpdateGradeID
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/GradeEdit',
			data 		: UpdateGradeData,
			dataType 	: 'json',
			success:function(data){
				EditGradeID 		= data[0].GradeID;
				EditGradeName 	= data[0].GradeName;
				$('#GradeInfo').hide();
				$('#GradeID b').remove();
				$('#GradeID').append("<b>"+EditGradeID+"</b>");
				$('#GradeName').val(""+EditGradeName+"");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
	});

	function ClearGrade(){
		$('#buttonUpdateGrade').hide();
		$('#buttonCancelGrade').hide();
		$('#buttonSubmitGrade').show();
		$('#GradeID b').remove();
		$('#GradeName').val("");
		$('#GradeInfo').hide();
		refreshTableGrade();
		refreshGradeID();
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

	function refreshGradeID() {
		$('#GradeID b').remove();
		$.ajax({
			type 		: 'POST',
			url 		: '/GradeCheckID',
			dataType 	: 'json',
			success:function(data) {
				data++;
				var GradeID 		= 'G' + padToTWo(data);
				$('#GradeID').append("<b>"+GradeID+"</b>");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
           		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	}

	function refreshTableGrade() {
		$('#tableGrade').html("");
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableGrade',
			dataType 	: 'json',
			success:function(data) {
				$('#tableGrade').html(data);
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