$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#download').hide();
	var HTML = $('#LoadingContent center').html();
	$('#btnAlright, #btnOK, #divLoading').hide();
	var duplicatedata, count, notinsert;

	$('#download').click(function(){
		var Region = 'All';
		var DateFrom = $('#filterDateFrom').val().replace(/\//g, '-');
		var DateTo = $('#filterDateTo').val().replace(/\//g, '-');
		if ($('#filterRegion').length){
			Region = $('#filterRegion').val();
		}
		window.location.href = '/downloadExcel/'+Region+'/'+ DateFrom +'/'+ DateTo +'';
	});

	$('#btnUpload').click(function(){
		if ($('#fileUpload').get(0).files.length === 0) {
		    showModal('Please input Attendance file first!', 0);
		    $('#btnUpload').removeAttr("disabled");
		    return false;
		}
		/*$('#LoadingModal').modal({
		  backdrop: 'static',
		  keyboard: false
		});*/
		$('#btnUpload').attr("disabled", true);
		$('#divLoading').show(); 
		var formData = new FormData();
		formData.append('RegionID', $('#selectRegion').val());
		formData.append('AttendanceExcelData', $('#fileUpload').get(0).files[0]);
		$.ajax({
			type: 'POST',
			url: '/UploadAttendanceData',
			data: formData,
			processData: false,
  			contentType: false,
			dataType: 'json',
			success:function(data){
				if (typeof(data['msg']) == 'undefined'){
					if (data['notinsert'] == ""){
						duplicatedata = data['duplicatearray'];
						duplicateConfirmation(data['count']);
					} else {
						notinsert = data['notinsert'];
						duplicatedata = data['duplicatearray'];
						duplicateConfirmation(data['count']);
					}
				} else {
					$('#divLoading').hide(); 
					if (data['msg'] == 'Success' || data['msg'] == 'Success, '){
						if (data['msg'] == 'Success'){
							showModal("Success Upload Attendance", 1);
						} else {
							showModal(data['msg'] + data['notinsert'], 1);
						}
						$('#btnUpload').removeAttr("disabled");
					} else {
						$('#btnUpload').removeAttr("disabled");
						showModal(data['msg'], 0);
					}
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#btnUpload').removeAttr("disabled");
				$('#divLoading').hide();
				showModal('Whoops! Something wrong', 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#submitFilter').click(function(){
		$('#download').hide();
		$('#table').html('');
		var rawfdf = $('#filterDateFrom').val().split("/"), rawfdt = $('#filterDateTo').val().split("/");
		var filterDateFrom = new Date(rawfdf[2], rawfdf[1] - 1, rawfdf[0]), filterDateTo = new Date(rawfdt[2], rawfdt[1] - 1, rawfdt[0]);
		if ($('#filterDateFrom').val() == "" ? $('#filterDateTo').val() != "" : $('#filterDateTo').val() == ""){
			showModal('Filter Date from and Date to must be fill', 0);
			$('#table').show();
			return false;
		} else if(filterDateTo < filterDateFrom) {
			showModal("Date to must be greater than date from", 0);
			$('#table').show();
			return false;
		}
		$('#download').hide();
		$('#LoadingModal').modal({
		  backdrop: 'static',
		  keyboard: false
		});
		var Region = 'All';
		if ($('#filterRegion').length){
			Region = $('#filterRegion').val();
		}
		var dataFilter={
			filterRegion: Region,
			filterDateFrom: $('#filterDateFrom').val(),
			filterDateTo: $('#filterDateTo').val()
		}
		$.ajax({
			type: 'POST',
			url: '/getAttendanceData',
			data: dataFilter,
			dataType: 'json',
			success:function(data){
				$('#download').show();
				$("#table").html(data);
				$('#attendanceListTable').DataTable({
					"autoWidth": false,
					"columnDefs": [    
						{ "width": "10%", "targets": 0 },
						{ "width": "20%", "targets": 9 }
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
						title: 'Attendance List '+Region+' from ' + $('#filterDateFrom').val() + ' to '+ $('#filterDateTo').val(),
						text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
						footer: true
					} ]
				});
				$('#LoadingModal').modal('hide');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#table').show();
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#btnOK').click(function() {
		$('#divLoading').show(); 
		$('#Modal').modal('hide');
		/*$('#LoadingModal').modal('show');*/
		var dataReplace = {
			data: duplicatedata
		}
		$.ajax({
			type: 'POST',
			url: '/ReplaceDuplicateData',
			data: dataReplace,
			dataType: 'json',
			success:function(data){
				$('#btnUpload').removeAttr("disabled");
				$('#divLoading').hide();
				if (typeof notinsert == "undefined"){
					showModal(data, 1);
				} else {
					showModal(data + notinsert, 1);
				}
				notinsert = null;
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#btnUpload').removeAttr("disabled");
				$('#divLoading').hide();
				showModal('Whoops! Something wrong', 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	function refreshTable(){
		$('#download').hide();
		$('#table').hide();
		$('.loader').show();
		var dataFilter={
			filterRegion: 'All',
			filterDateFrom: '',
			filterDateTo: ''
		}
		$.ajax({
			type: 'POST',
			url: '/getAttendanceData',
			data: dataFilter,
			dataType: 'json',
			success:function(data){
				$('.loader').hide();
				$("#table").html(data);
				$('#attendanceListTable').DataTable({
					"autoWidth": false,
					"columnDefs": [    
						{ "width": "10%", "targets": 0 },
						{ "width": "20%", "targets": 9 }
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
						title: 'Attendance List '+Region+' from ' + $('#filterDateFrom').val() + ' to '+ $('#filterDateTo').val(),
						text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
						footer: true
					} ]
				});
				$('#table').show();
				$('#download').show();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('.loader').hide();
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function duplicateConfirmation(count){
		$('#btnAlright').hide();
		$('#divLoading').hide(); 
		//$('#LoadingModal').modal('hide');
		$('#ModalHeader').html('Duplicate');
		$('#ModalContent').html('<b>'+count+'</b> duplicate entries will be replaced');
		$('#btnOK').show();
		$('#count').html(count);
		$('#Modal').modal({
		  backdrop: 'static',
		  keyboard: false
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
