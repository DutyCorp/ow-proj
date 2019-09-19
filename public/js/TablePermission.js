$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#PermitTable').DataTable({
		"columnDefs": 
			[         
			{ "width": "10%", "targets":0 },
			{ "width": "12%", "targets":1 },
			{ "width": "12%", "targets":2 },
			{ "width": "10%", "targets":3 },
			{ "width": "10%", "targets":4 },
			{ "width": "23%", "targets":5 },
			{ "width": "6%", "targets":6 },
			{ "width": "7%", "targets":7 }   
		],
		"order": [[2, 'desc']],
		scrollX : true,
		scrollCollapse 	: true,
		dom: 'Bfrtip',
		lengthMenu: [
		[ 10, 25, 50, -1 ],
		[ '10 rows', '25 rows', '50 rows', 'Show all' ]
		],
		buttons: [{extend:'pageLength',text: '<span>Show Page</span>'},	 {
			extend: 'excelHtml5',
			title: 'Entry Permission Table',
			text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
			footer: true
		} ]
	});

	$('#tablePermission tbody').on('click', '.ChooseEdit', function (e) {
        $('#insertPermission').show();
        $('#buttonSubmit, #buttonClear').hide(); $('#buttonUpdate, #buttonCancel').show();
		$('#SelectEmployeeID').attr("disabled","disabled");
		flagChangeID = 0;
		localStorage.setItem('flagChangeID', flagChangeID);
		editForm($(this).val());
		$('html, body').animate({ scrollTop: $('#insertPermission').offset().top }, 'slow');
     } );

	function cancel() {
		$('#buttonUpdate').hide();
		$('#buttonSubmit').show();
		$('#permitID b').html("-");
		$('#permitType').val("None");
		$('#permitNotes').val("");
		$('#permitDate').val("");
		$('#SelectEmployeeID').removeAttr("disabled");
	}

	$('#tablePermission tbody').on('click', '.ChooseDelete', function (e) {
        submitDelete($(this).val());

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

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return day + '/' + month + '/' + year;
	}

	function editForm(Edit_ID){
		var EditID;
		var EditDate;
		var EditType; 
		var EditNotes; 
		var UpdateID;
		var CoorID;
		flagChangeID = 0;
		var EditData = {
			permitID : Edit_ID
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/PermissionEdit',
			data 		: EditData,
			dataType 	: 'json',
			success:function(data){
				EditID 		= data[0].TransactionPermissionID;
				UpdateID 	= EditID;
				localStorage.setItem('UpdateID', UpdateID);
				EditNotes 	= data[0].Notes;
				EditType 	= data[0].PermissionID;
				EditDate 	= data[0].Date;
				$('#permitID').val(EditID);
				$('#permitType').val(""+EditType+"");
				$('#permitNotes').val(""+EditNotes+"");
				$('#permitDate').val(""+getEditFormattedDate(new Date(EditDate))+"");
				$('#EmployeeID').val(data[0].EmployeeID);
				$('#SelectEmployeeID').val(data[0].EmployeeID);
				$('#coorID').val(data[0].CoordinatorID)
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function submitDelete(ID_Delete){
		var EntryPermissionData = {
			permitID: ID_Delete,
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/PermissionDelete',
			data 		: EntryPermissionData,
			dataType 	: 'json',
			success:function(data){
				showModal(data, 1);
				refreshTablePermission();
				cancel();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function refreshTablePermission(){
		$('#tablePermission').hide();
		$('.loader').show();
		$.ajax({
			type 		: 'POST',
			url 		: '/RefreshTablePermission',
			dataType 	: 'json',
			success:function(data){
				$('#tablePermission').html(data);				
				$('.loader').hide();
				$('#tablePermission').show();
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

});