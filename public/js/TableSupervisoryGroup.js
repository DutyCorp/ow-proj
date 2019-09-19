$(document).ready(function() {
	$.ajaxSetup({
  		headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
	});

	$('.cbxSubordinates').on('change', function() {
		$('#tableSG').hide();
		$('.loader').show();
		if ($(this).is(':checked')){
			var EmployeeID = [];
			EmployeeID[0] = $(this).val();
			var SGData = {
				EmployeeID	: EmployeeID,
				PM_ID 		: $('#selectPM').val()
			};
			$.ajax({
				type: 'POST',
				url: '/SetSubordinates',
				data: SGData,
				dataType: 'json',
				success:function(data){
					var PM_Data = {
						PM_ID	: $('#selectPM').val()
					};
					$.ajax({
						type: 'POST',
						url: '/GetTeamLeadRegion',
						data: PM_Data,
						dataType: 'json',
						success:function(data){
							var Region_Data = {
								RegionID	: data[0].RegionID
							};
							$.ajax({
								type: 'POST',
								url: '/GetDeliveryList',
								data: Region_Data,
								dataType: 'json',
								success:function(data){
									$('.loader').hide();
									$('#tableSG').show();
									$('#tableSG').html(data);
									$('#SubordinateTable').DataTable({
										"bPaginate": false,
										"info":     false,
										"bFilter": false,
										"columnDefs": [    
											{ "width": "10%", "targets": 0 },
											{ "width": "45%", "targets": 1 },
											{ "width": "45%", "targets": 2 }
										],
										"order": [[1, 'asc']]
									});
								},
								error: function (xhr, ajaxOptions, thrownError) {
									$('.loader').hide();
									$('#tableSG').show();
									showModal("Whoops! Something wrong", 0);
									console.log(xhr.status);
									console.log(xhr.responseText);
									console.log(thrownError);
								}
							});
							$('#selectRegion').val(data[0].RegionID);
							$('#GRM_1').val(data[0].GRM_1);
							$('#GRM_2').val(data[0].GRM_2);
							$('#PMO').val(data[0].PMO);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							$('.loader').hide();
							$('#tableSG').show();
							showModal("Whoops! Something wrong", 0);
							console.log(xhr.status);
							console.log(xhr.responseText);
							console.log(thrownError);
						}
					});
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('.loader').hide();
					$('#tableSG').show();
					showModal("Whoops! Something wrong",0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		} else {
			var DeleteSubordinates = $(this).val();
			var DeleteSubData = {
	    		Sub_ID 			: DeleteSubordinates,
			}
		    $.ajax({
				type: 'POST',
				url: '/DeleteSubordinates',
				data: DeleteSubData,
				dataType: 'json',
				success:function(data){
					var PM_Data = {
						PM_ID	: $('#selectPM').val()
					};
					$.ajax({
						type: 'POST',
						url: '/GetTeamLeadRegion',
						data: PM_Data,
						dataType: 'json',
						success:function(data){
							var Region_Data = {
								RegionID	: data[0].RegionID
							};
							$.ajax({
								type: 'POST',
								url: '/GetDeliveryList',
								data: Region_Data,
								dataType: 'json',
								success:function(data){
									$('.loader').hide();
									$('#tableSG').show();
									$('#tableSG').html(data);
									$('#SubordinateTable').DataTable({
										"bPaginate": false,
										"info":     false,
										"bFilter": false,
										"columnDefs": [    
											{ "width": "10%", "targets": 0 },
											{ "width": "45%", "targets": 1 },
											{ "width": "45%", "targets": 2 }
										],
										"order": [[1, 'asc']]
									});
								},
								error: function (xhr, ajaxOptions, thrownError) {
									$('.loader').hide();
									$('#tableSG').show();
									showModal("Whoops! Something wrong", 0);
									console.log(xhr.status);
									console.log(xhr.responseText);
									console.log(thrownError);
								}
							});
							$('#selectRegion').val(data[0].RegionID);
							$('#GRM_1').val(data[0].GRM_1);
							$('#GRM_2').val(data[0].GRM_2);
							$('#PMO').val(data[0].PMO);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							$('.loader').hide();
							$('#tableSG').show();
							showModal("Whoops! Something wrong", 0);
							console.log(xhr.status);
							console.log(xhr.responseText);
							console.log(thrownError);
						}
					});
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('.loader').hide();
					$('#tableSG').show();
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	        		console.log(thrownError);
	       		}
			});
		}
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