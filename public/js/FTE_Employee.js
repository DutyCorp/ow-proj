$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#divLoading').hide();
	$('#buttonSaveAll').hide();

	$('#buttonSaveAll').click(function(){
		var FArray = [];
		var EmployeeArray = [];
		var FTEArray = [];
		var YearArray = [];
		var i = 0; j = 0; errorcounter = 0;
		$('#FTETable tbody tr td input[type=text]').each(function(){
			if (!isNaN($(this).val())){
				if ($(this).val() % 1 == 0){
					if ($(this).val() < 0 || $(this).val() > 100){
						errorcounter++;
					} else {
						FArray[i] = $(this).val();		
						i++;	
					}
				} else {
					errorcounter++;
				}
			} else {
				errorcounter++;
			}
		});
		j = i/12; i = 0;
		for (i = 0; i < j; i++){
			FTEArray[i] = FArray.splice(0, 12);
		}
		i = 0;
		$('.EmployeeID').each(function(){
			EmployeeArray[i] = $(this).text();
			i++; 
		});
		i = 0;
		$('.Year').each(function(){
			YearArray[i] = $(this).text();
			i++;
		});
		if (errorcounter >= 1){
			showModal('Please check your data, and try again', 0);
			return false;
		} else {
			$("#tableFTE").hide();
			$("#divLoading").show();
			var SubmitData = {
				EmployeeID: EmployeeArray,
				Year: YearArray,
				FTE: FTEArray
			}
			$.ajax({
				type: 'POST',
				url: '/SaveAllFTE',
				data: SubmitData,
				dataType: 'json',
				success:function(data){
					showModal(data, 1);
					GetFTE(new Date().getFullYear());
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#tableFTE').show();
					showModal("Whoops! Something wrong", 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
	});

	$('#btnViewFTE').click(function(){
		if($('#FTEYear').val() == ''){
			showModal('Year must be filled!', 0);
		} else if(isNaN($('#FTEYear').val())) {
			showModal('Invalid year!', 0);
		} else {
			GetFTE($('#FTEYear').val());
		}
	});

	$('#btnGenerateFTE').click(function(){
		if($('#FTEYear').val() == ''){
			showModal('Year must be filled!', 0);
		} else if(isNaN($('#FTEYear').val())) {
			showModal('Invalid year!', 0);
		} else {
			$('#buttonSaveAll').hide();
			$("#tableFTE").hide();
			$("#divLoading").show();
			var dataFilter={
				filterYear: $('#FTEYear').val()
			}
			$.ajax({
				type: 'POST',
				url: '/GenerateFTE',
				data: dataFilter,
				dataType: 'json',
				success:function(data){
					$("#tableFTE").html(data);
					$("#divLoading").hide();
					$('#tableFTE').show();
					$('#buttonSaveAll').show();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#tableFTE').show();
					showModal("Whoops! Something wrong", 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
	});

	function GetFTE(year){
		$('#buttonSaveAll').hide();
		$("#tableFTE").hide();
		$("#divLoading").show();
		var dataFilter={
			filterYear: year
		}
		$.ajax({
			type: 'POST',
			url: '/GetFTEData',
			data: dataFilter,
			dataType: 'json',
			success:function(data){
				$("#tableFTE").html(data);
				$("#divLoading").hide();
				$('#tableFTE').show();
				$('#buttonSaveAll').show();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#tableFTE').show();
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