$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('#save').hide();
	$('.loader').hide();

	/*$('#save').click(function(){
		var EmployeeID = []; 
		i = 0;
		$('#tableSG').hide();
		$('.loader').show();
		$('#tableSG tbody tr').each(function(){
			if ($(this).find('input[type="checkbox"]').is(':checked') == true && $('.PLName').val() == ""){
				EmployeeID[i] = $(this).find('input[type="checkbox"]').val();
				if(EmployeeID[i] == "on")
					EmployeeID[i] = "";z
				i++;
			}
		});
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
						showModal("Whoops! Something wrong", 0);
						console.log(xhr.status);
						console.log(xhr.responseText);
						console.log(thrownError);
					}
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong",0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});*/

	$('#SubordinateTable').DataTable({
		"bPaginate": false,
		"info":     false,
		"bFilter": false,
		"columnDefs": [    
			{ "width": "2%", "targets": 0 },
			{ "width": "45%", "targets": 1 },
			{ "width": "45%", "targets": 2 }
		]
	});

	$('#submitAddSub').click(function(){
		if($('#selectPM').val() == $('#selectSubordinates').val()){
			showModal("Cant add same Project Manager and Subordinates", 0);
			return false;
		}
		var SubordinatesData = {
			PM_ID	: $('#selectPM').val(),
			Sub_ID	: $('#selectSubordinates').val()
		};
		$.ajax({
			type: 'POST',
			url: '/AddSubordinates',
			data: SubordinatesData,
			dataType: 'json',
			success:function(data){
				refreshTableSG();
				$('#selectPM').removeAttr("disabled");
				$('#AddSub').show();
				$('#SubmitAddSub').hide();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Subordinates already exist, please choose another Subordinates", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#selectPM').change(function(){
		if($(this).val() != "None"){
			//$('#save').show();
			$('#tableSG').hide();
			$('.loader').show();
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
					showModal("Whoops! Something wrong", 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}else{
			$('#save').hide();
			$('#tableSG').hide();
			$('#selectRegion').val("");
			$('#GRM_1').val("");
			$('#GRM_2').val("");
			$('#PMO').val("");
		}
	})

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