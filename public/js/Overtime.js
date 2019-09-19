$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	$('#buttonUpdateOvertime, #buttonCancelOvertime').hide();
	
	RefreshTableOvertime();

	$('#selectEmployeeName').change(function(){
		$('#EmployeeID').val($(this).val());
	});

	function RefreshTableOvertime() {
		$('#tableOvertime').hide();
		$('#OvertimeLoading').show();
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableOvertime',
			dataType 	: 'json',
			success:function(data){
				$('#tableOvertime').html(data);
				$('#OvertimeLoading').hide();
				$('#tableOvertime').show();
				$('#overtimeTable').DataTable({   
					"columnDefs": [         
						{ "width": "15%", "targets":1 },
						{ "width": "15%", "targets":2 },
						{ "width": "8%", "targets":4 },
						{ "width": "13%", "targets":3 },
						{ "width": "10%", "targets":7 },
						{ "width": "7%", "targets":6 },
						{ "width": "27%", "targets":5 },
						{ "width": "5%", "targets":0 }
					],
					"order": [[3, 'asc']],
					scrollX 		: true,
					scrollCollapse 	: true,
					dom: 'Bfrtip',
					lengthMenu: [
					[ 10, 25, 50, -1 ],
					[ '10 rows', '25 rows', '50 rows', 'Show all' ]
					],
					buttons: [{extend:'pageLength',text: '<span>Show Page</span>'},	 {
						extend: 'excelHtml5',
						title: 'Entry Overtime',
						text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
						footer: true
					} ]
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#OvertimeLoading').hide();
				$('#tableOvertime').show();
				showModal("Whoops Something Wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function ClearOvertimeForm() {
		$('#selectOvertimeType').val("None");
		$('#selectEmployeeName').val("None");
		$('#selectManagerName').val("None");
		$('#selectDate').val("");
		$('#entryNotes').val("");
		$('#ManagerID').val("");
		$('#EmployeeID').val("");
		$('#buttonUpdateOvertime, #buttonCancelOvertime').hide();
		$('#buttonSubmitOvertime, #buttonClearOvertime').show();
		$('#selectEmployeeName').removeAttr("disabled");
	}

	
	$('#buttonCancelOvertime, #buttonClearOvertime').click(function(){
		if ($('#RoleI').val() == "0"){
			$('#inserOvertime').hide();
		}
		ClearOvertimeForm();
	});

	$('#buttonUpdateOvertime').click(function(){
		var OvertimeType = $('#selectOvertimeType').val();
		var ManagerName = $('#selectManagerName').val();
		var OvertimeDate = $('#selectDate').val();
		var Tanggal = OvertimeDate.split("/");
		OvertimeDate = getFormatDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));
		var Notes = $('#entryNotes').val();
		var EmployeeID = $('#EmployeeID').val();

		if(ManagerName == "None") {
			showModal("Coordinator must be chosen", 0);
			return false;
		}else if(ManagerName != "None"){
			var EmployeeData = {
				EmployeeID 			: EmployeeID
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/GetEmployeeName',
				data 		: EmployeeData,
				dataType 	: 'json',
				success:function(data){
					EmployeeName = data[0].EmployeeName;
					if(EmployeeName == ManagerName) {
						showModal("Coordinator cant be same with Employee", 0);
						return false;
					}else if(OvertimeDate == "") {
						showModal("Date must be chosen", 0);
						return false;
					}else if(OvertimeType == "None") {
						showModal("Overtime Type must be choosen", 0);
						return false;
					}else if(Notes == "") {
						showModal("Notes must be filled", 0);
						return false;
					}else {
						$('#tableOvertime').hide();
						$('#OvertimeLoading').show();
						var OvertimeUpdateData = {
							OvertimeID		: localStorage.getItem('UpdateOvertimeID'),
							Manager 		: ManagerName,
							OvertimeDate 	: OvertimeDate,
							Type 			: OvertimeType,
							Notes 			: Notes
						}
						$.ajax({
							type 		: 'POST',
							url 		: '/UpdateOvertime',
							data 		: OvertimeUpdateData,
							dataType 	: 'json',
							success:function(data){
								if(data == 0) {
									showModal("Can't Register with same Date", 0);
								} else {
									if ($('#RoleI').val() == "0"){
										$('#inserOvertime').hide();
									}
									ClearOvertimeForm();
									RefreshTableOvertime();
									showModal("Success Update Overtime", 1);
									if($('#selectEmployeeName').val() == "None")
									{
										$('#EmployeeID').val("");
									}
								}
							},
							error: function (xhr, ajaxOptions, thrownError) {
								$('#OvertimeLoading').hide();
								$('#tableOvertime').show();
								showModal("Whoops Something Wrong", 0);
								console.log(xhr.status);
								console.log(xhr.responseText);
								console.log(thrownError);
							}
						});
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					showModal("Whoops Something Wrong", 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
	});

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return year + month + day;
	}

	function getFormatDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return year + '-' + month + '-' + day;
	}

	$('#buttonSubmitOvertime').click(function(){
		var OvertimeType = $('#selectOvertimeType').val();
		var EmployeeID = $('#EmployeeID').val();
		var ManagerName = $('#selectManagerName').val();
		var OvertimeDate = $('#selectDate').val();
		var Tanggal = OvertimeDate.split("/");
		OvertimeDate = getFormatDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));
		var Notes = $('#entryNotes').val();
		var EmployeeName;
		var CheckingOvertimeID = getEditFormattedDate(new Date(OvertimeDate));

		if(EmployeeID == "None") {
			showModal("Employee must be choosen", 0);
			return false;
		}else if(ManagerName == "None") {
			showModal("Coordinator must be choosen", 0);
			return false;
		}else if(ManagerName != "None"){
			var EmployeeData = {
				EmployeeID 			: EmployeeID
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/GetEmployeeName',
				data 		: EmployeeData,
				dataType 	: 'json',
				success:function(data){
					EmployeeName = data[0].EmployeeName;
					if(ManagerName == EmployeeName) {
						showModal("Coordinator cant be same with Employee", 0);
						return false;
					}else if(OvertimeDate == "") {
						showModal("Date must be choosen", 0);
						return false;
					}else if(OvertimeType == "None") {
						showModal("Overtime Type must be choosen", 0);
						return false;
					}else if(Notes == "") {
						showModal("Notes must be filled", 0);
						return false;
					}else {
						$('#tableOvertime').hide();
						$('#OvertimeLoading').show();
						var CheckOvertimeData = {
							CheckingOvertimeID	: CheckingOvertimeID
						}
						
						$.ajax({
							type 		: 'POST',
							url 		: '/CheckOvertimeID',
							data 		: CheckOvertimeData,
							dataType 	: 'json',
							success:function(data){
								var Count;
								if(data == 0){
									Count = 1;
								}else{
									Count = ++data[0].TotalID;
								}
								var OvertimeData = {
									OvertimeID 			: CheckingOvertimeID + padToThree(Count)	,
									Employee			: EmployeeID,
									Manager 			: ManagerName,
									OvertimeDate 		: OvertimeDate,
									Type 				: OvertimeType,
									Notes 				: Notes
								}

								$.ajax({
									type 		: 'POST',
									url 		: '/EntryOvertime',
									data 		: OvertimeData,
									dataType 	: 'json',
									success:function(data){
										if(data == 0) {
											showModal("Can't Register with same Date", 0);
											RefreshTableOvertime();
										} else {
											if ($('#RoleI').val() == "0"){
												$('#inserOvertime').hide();
											}
											ClearOvertimeForm();
											RefreshTableOvertime();
											if($('#selectEmployeeName').val() == "None")
											{
												$('#EmployeeID').val("");
											}
											showModal("Success Insert Overtime!", 1);
										}
									},
									error: function (xhr, ajaxOptions, thrownError) {
										$('#OvertimeLoading').hide();
										$('#tableOvertime').show();
										showModal("Whoops Something Wrong", 0);
										console.log(xhr.status);
										console.log(xhr.responseText);
										console.log(thrownError);
									}
								});
							},
							error: function (xhr, ajaxOptions, thrownError) {
								showModal("Whoops Something Wrong", 0);
								console.log(xhr.status);
								console.log(xhr.responseText);
								console.log(thrownError);
							}
						});		
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					showModal("Whoops Something Wrong", 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
	});

	function padToThree(number) {
		if (number<=999) { number = ("00"+number).slice(-3); }
		return number;
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