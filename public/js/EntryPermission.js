$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	$('.loader').hide();
	var UpdateID;
	refreshTablePermission();
	var flagChangeID = 1;
	localStorage.setItem("flagChangeID", null);
	var permissionID;
	var now = new Date();
	$('#buttonUpdate, #buttonCancel').hide();

	function refreshDropdownPT(){
		$('#permitType').html("");
		$.ajax({
			type: 'POST',
			url: '/GetAllPT',
			dataType: 'json',
			success:function(data){
				$('#permitType').append('<option value="None">Select</option>');
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#permitType').append('<option value="'+data[i]['PermissionID']+'">'+data[i]['PermissionType']+'</option>');
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	$('#buttonUpdatePermissionType').click(function(){
		var ID = $('#PTID').text();
		var Name = $('#PermissionTypeName').val();
		if(Name == "")
		{
			$('#Info').text("Permission Type Name must be filled");
		}else{
			var PTData = {
				ID : ID,
				Name : Name
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/UpdatePermissionType',
				data 		: PTData,
				dataType 	: 'json',
				success:function(data){
					$('#PTID').html("");
					document.getElementById("Info").style.color = "green";
					$('#Info').text("Success Update Permission Type");
					refreshPermissionTypeID();
					refreshTablePT();
					$('#PermissionTypeName').val("");
					$('#buttonUpdatePermissionType').hide();
					$('#buttonCancelPermissionType').hide();
					$('#buttonAddPermissionType').show();
					refreshDropdownPT();
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

	function padToTWo(number) {
		if (number<=99) { number = ("0"+number).slice(-2); }
		return number;
	}

	function refreshPermissionTypeID() {
		$('#positionID b').remove();
		$.ajax({
			type 		: 'POST',
			url 		: '/CheckPermissionTypeID',
			dataType 	: 'json',
			success:function(data) {
				data++;
				PermissionTypeID 		= 'P' + padToTWo(data);
				NewPermissionTypeID 	= PermissionTypeID;
				$('#PTID').append("<b>"+NewPermissionTypeID+"</b>");
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
           		console.log(xhr.responseText);
        		console.log(thrownError);
       		}
		});
	}

	function refreshTablePT(){
		$.ajax({
			type 		: 'POST',
			url 		: '/RefreshTablePT',
			dataType 	: 'json',
			success:function(data){
				console.log(data);
				$('#table').html(data);				
				$('#PTTable').DataTable({
					"bPaginate": false,
					"info":     false,
					"bFilter": false,
				});			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	$('#buttonAddPermissionType').click(function(){
		var ID = $('#PTID').text();
		var Name = $('#PermissionTypeName').val();
		if(Name == "")
		{
			$('#Info').text("Permission Type Name must be filled");
		}else{
			var PTData = {
				ID : ID,
				Name : Name
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/EntryPermissionType',
				data 		: PTData,
				dataType 	: 'json',
				success:function(data){
					$('#PTID').html("");
					refreshPermissionTypeID();
					refreshTablePT();
					$('#PermissionTypeName').val("");
					document.getElementById("Info").style.color = "green";
					$('#Info').text("Success Entry Permission Type");
					refreshDropdownPT();
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

	$('#AddPT').click(function(){
		$('#PTID b').remove();
		$('#Info').html("");
		refreshTablePT();
		$('#buttonUpdatePermissionType').hide();
		$('#buttonCancelPermissionType').hide();
		refreshPermissionTypeID();
	});

	$('#SelectEmployeeID').change(function(){
		var EmployeeID  = $(this).val();
		$('#EmployeeID').val(EmployeeID);
	});

	$('#buttonCancel, #buttonClear').click(function() {
		flagChangeID = 1;
		cancel();
		if ($('#RoleI').val() == '0'){
			$('#insertPermission').hide();
		}
		localStorage.setItem("flagChangeID", null);
		$('#SelectEmployeeID').val("None");
		$('#coorID').val("None");
		$('#EmployeeID').val("");
	});
	
	$('#buttonSubmit').click(function() {
		SubmitEntryPermission();
		flagChangeID = 1;
	});

	$('#buttonUpdate').click(function() {
		submitEdit();
		flagChangeID = 1;
		localStorage.setItem('flagChangeID', null);
	});
	
	$('#permitDate').datepicker({
		autoClose : true,
	});

	function SubmitEntryPermission(){
		var EntryEmployeeID 		= $('#EmployeeID').val();
		var EntryPermissionDate 	= $('#permitDate').val();
		var EntryPermissionType 	= $('#permitType').val();
		var EntryPermissionNotes 	= $('#permitNotes').val();
		var EntryCoor 			 	= $('#coorID').val();
	    if (EntryEmployeeID == "") {
	    	showModal("Employee must be filled!", 0);
	    	return false;
	    }else if (EntryEmployeeID == EntryCoor) {
	    	showModal("Employee can't be same with Coordinator!", 0);
	    	return false;
	    }
	    else if (EntryPermissionDate == "") {
	    	showModal("Date must be chosen!", 0);
	    	return false;
	    }
	    else if (EntryPermissionType == "None") {
	    	showModal("Type must be chosen!", 0);
	    	return false;
	    }
	    else if (EntryPermissionNotes == "") {
	    	showModal("Notes must be filled!", 0);
	    	return false;
	    }
	    else 
	    {
	    	$('.loader').show();
			$('#tablePermission').hide();
			if (localStorage.getItem("flagChangeID") != 'null'){
				flagChangeID = localStorage.getItem("flagChangeID");
			} else {
				flagChangeID = 1;
			}
			if (flagChangeID == 1) {
				var EntryPermissionDate = $('#permitDate').val();
				var Tanggal = EntryPermissionDate.split("/");
				var newdate = getEditFormattedDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));
				permissionID 			= newdate.replace("-", "");
				permissionID 			= permissionID.replace("-", "");
				if (EntryPermissionDate != "") {
					var CheckData = {
						permitID : permissionID
					}
					$.ajax({
						type 		: 'POST',
						url 		: '/PermissionCheckID',
						data 		: CheckData,
						dataType 	: 'json',
						success:function(data){
							data++;
							permissionID += padToFour(data);
							var EntryPermissionData = {
					    		permitID 		: permissionID,
					    		permitEmployeeID: EntryEmployeeID,
					    		permitDate 		: $('#permitDate').val(),
					    		permitType 		: $('#permitType').val(),
					    		permitNotes 	: $('#permitNotes').val(),
					    		coorID 		 	: $('#coorID').val()
					    	}
					    	$.ajax({
					    		type 		: 'POST',
					    		url 		: '/PermissionAttendance',
					    		data 		: EntryPermissionData,
					    		dataType 	: 'json',
					    		success:function(data){
					    			showModal(data, 1);
					    			refreshTablePermission();
					    			cancel();
					    			if($('#SelectEmployeeID').val() == "")
										$('#EmployeeID').val("");
					    		},
					    		error: function (xhr, ajaxOptions, thrownError) {
					    			$('.loader').hide();
					    			$('#tablePermission').show();
					    			showModal("Duplicate or Something Error with your Form Data ", 0);
					    			console.log(xhr.status);
					    			console.log(xhr.responseText);
					    			console.log(thrownError);
					    		}
					    	});
						},
						error: function (xhr, ajaxOptions, thrownError) {
							showModal("Whoops! Something wrong", 0);
							console.log(xhr.status);
							console.log(xhr.responseText);
							console.log(thrownError);
						}
					});
				}
			} else {
				return false;
			}
	    }
	}

	function submitEdit(){
		var EntryPermissionDate  	= $('#permitDate').val();
		var EntryPermissionType  	= $('#permitType').val();
		var EntryPermissionNotes  	= $('#permitNotes').val();

		if (EntryPermissionDate == "") {
			showModal("Date must be chosen!", 0);
			return false;
		}else if (EntryPermissionType == "None") {
			showModal("Type must be choosen!", 0);
			return false;
		}else if (EntryPermissionNotes == "") {
			showModal("Notes must be filled!", 0);
			return false;
		}else if ($('#EmployeeID').val() == $('#coorID').val()) {
	    	showModal("Employee can't be same with Coordinator!", 0);
	    	return false;
	    }else 
		{
			$('.loader').show();
			$('#tablePermission').hide();
			if(EntryPermissionDate.includes("-") == true){
				var EntryPermissionData = {
					permitID 		: localStorage.getItem('UpdateID'),
					permitDate 		: EntryPermissionDate,
					permitType 		: $('#permitType').val(),
					permitNotes 	: $('#permitNotes').val(),
					coorID 		 	: $('#coorID').val()
				}
				$.ajax({
					type 		: 'POST',
					url 		: '/PermissionUpdate',
					data 		: EntryPermissionData,
					dataType 	: 'json',
					success:function(data){
						if ($('#RoleI').val() == "0"){
							$('#insertPermission').hide();
						}
						showModal(data, 1);
						refreshTablePermission();
						cancel();
						$('#SelectEmployeeID').show();
						if($('#SelectEmployeeID').val() == "")
							$('#EmployeeID').val("");
					},
					error: function (xhr, ajaxOptions, thrownError) {
						showModal("Whoops! Something wrong", 0);
						console.log(xhr.status);
						console.log(xhr.responseText);
						console.log(thrownError);
					}
				});
			}else{
				var Tanggal = EntryPermissionDate.split("/");
				var newdate = getEditFormattedDate(new Date(Tanggal[1]+'/'+Tanggal[0]+'/'+Tanggal[2]));
				var EntryPermissionData = {
					permitID 		: $('#permitID').val(),
					permitDate 		: newdate,
					permitType 		: $('#permitType').val(),
					permitNotes 	: $('#permitNotes').val(),
					coorID 		 	: $('#coorID').val()
				}
				$.ajax({
					type 		: 'POST',
					url 		: '/PermissionUpdate',
					data 		: EntryPermissionData,
					dataType 	: 'json',
					success:function(data){
						if ($('#RoleI').val() == "0"){
							$('#insertPermission').hide();
						}
						showModal(data, 1);
						refreshTablePermission();
						cancel();
						$('#SelectEmployeeID').show();
						if($('#SelectEmployeeID').val() == "")
							$('#EmployeeID').val("");
					},
					error: function (xhr, ajaxOptions, thrownError) {
						showModal("Whoops! Something wrong", 0);
						console.log(xhr.status);
						console.log(xhr.responseText);
						console.log(thrownError);
					}
				});
			}			
		}
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

	function padToFour(number) {
		if (number<=999) { number = ("00"+number).slice(-3); }
		return number;
	}

	function cancel() {
		$('#buttonUpdate, #buttonCancel').hide();
		$('#buttonSubmit, #buttonClear').show();
		$('#permitID b').html("-");
		$('#permitType').val("None");
		$('#permitNotes').val("");
		$('#permitDate').val("");
		$('#SelectEmployeeID').removeAttr("disabled");
	}

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return year + '-' + month + '-' + day;
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