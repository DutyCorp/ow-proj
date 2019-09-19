$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('#divLoading').hide();
	$('#btnUpdate').hide();
	$('#btnCancel').hide();
	refreshRoleList();
	$('#btnSubmit').click(function() {
		if ($('#txtRoleName').val() == ""){
			showModal("Role Name must be filled!", 0);
			return false;
		}
		var RoleAccessArray 		= [];
		var RAArray 				= [];
		var RegionVisibilityArray 	= [];
		var RegionArray 			= [];
		var MenuChildArray 			= [];
		var GradeArray 				= [];
		var GradeIDArray 			= [];
		var i = 0; j = 0; k = 0; l = 0;
		$('#tableRoleAccess tbody tr td input[type=checkbox]').each(function() {
			if(this.checked){
				RAArray[j] = 1;
			} else {
				RAArray[j] = 0;
			}
			j++;
		});
		$('#tableRoleAccess tbody tr').each(function() {
			MenuChildArray[l] = $(this).attr('value');
			l++;
		});
		l = 0; k = j/4;
		for (i = 0; i < k; i++){
			RoleAccessArray[i] = RAArray.splice(0, 4);	
		}
		$('#RegionDiv div input[type=checkbox]').each(function() {
			if(this.checked){
				RegionVisibilityArray[l] 	= 1;
				RegionArray[l] 				= $(this).attr('value');
			} else {
				RegionVisibilityArray[l] 	= 0;
				RegionArray[l] 				= $(this).attr('value');
			}
			l++;
		});
		l = 0;
		$('#GradeDiv div input[type=checkbox]').each(function() {
			if(this.checked){
				GradeArray[l] 	= 1;
				GradeIDArray[l] = $(this).attr('value');
			} else {
				GradeArray[l] 	= 0;
				GradeIDArray[l] = $(this).attr('value');
			}
			l++;
		});
		var RoleData = {
			RoleAccess 		: RoleAccessArray,
			RoleID 			: $('#divRoleID').html(),
			RoleName 		: $('#txtRoleName').val(),
			MenuChildID 	: MenuChildArray,
			RegionVisibility: RegionVisibilityArray,
			RegionID 		: RegionArray,
			Grade 			: GradeArray,
			GradeID 		: GradeIDArray
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/SubmitRole',
			data 		: RoleData,
			dataType 	: 'json',
			success:function(data){
				showModal('Role Insert Success!', 1);
				ClearForm(data);
				refreshRoleList();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#btnClear, #btnCancel').click(function() {
		$.ajax({
			type 		: 'POST',
			url 		: '/GetNewRole',
			dataType 	: 'json',
			success:function(data){
				if ($('#RoleI').val() == "0"){
					$('#insertRole').hide();
				}
				ClearForm(data);
				$('#divRoleID').html(data);
				$('#btnUpdate, #btnCancel').hide();
				$('#btnSubmit, #btnClear').show();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	$('#btnUpdate').click(function() {
		if ($('#txtRoleName').val() == ""){
			showModal("Role Name must be filled!", 0);
			return false;
		}
		var RoleAccessArray 		= [];
		var RAArray  				= [];
		var RegionVisibilityArray 	= [];
		var RegionArray 			= [];
		var GradeArray 				= [];
		var GradeIDArray 			= [];
		var MenuChildArray 			= [];
		var i = 0; j = 0; k = 0; l = 0;
		$('#tableRoleAccess tbody tr td input[type=checkbox]').each(function() {
			if(this.checked){
				RAArray[j] = 1;
			} else {
				RAArray[j] = 0;
			}
			j++;
		});
		$('#tableRoleAccess tbody tr').each(function() {
			MenuChildArray[l] = $(this).attr('value');
			l++;
		});
		l = 0; k = j/4;
		for (i = 0; i < k; i++){
			RoleAccessArray[i] = RAArray.splice(0, 4);	
		}
		$('#RegionDiv div input[type=checkbox]').each(function() {
			if(this.checked){
				RegionVisibilityArray[l] = 1;
				RegionArray[l] = $(this).attr('value');
			} else {
				RegionVisibilityArray[l] = 0;
				RegionArray[l] = $(this).attr('value');
			}
			l++;
		});
		l = 0;
		$('#GradeDiv div input[type=checkbox]').each(function() {
			if(this.checked){
				GradeArray[l] 	= 1;
				GradeIDArray[l] = $(this).attr('value');
			} else {
				GradeArray[l] 	= 0;
				GradeIDArray[l] = $(this).attr('value');
			}
			l++;
		});
		var RoleData = {
			RoleAccess 		: RoleAccessArray,
			RoleID 			: $('#divRoleID').html(),
			RoleName   		: $('#txtRoleName').val(),
			MenuChildID 	: MenuChildArray,
			RegionVisibility: RegionVisibilityArray,
			RegionID 		: RegionArray,
			Grade 			: GradeArray,
			GradeID 		: GradeIDArray
		}
		$.ajax({
			type 		: 'POST',
			url 		: '/UpdateRole',
			data 		: RoleData,
			dataType 	: 'json',
			success:function(data){
				if ($('#RoleI').val() == "0"){
					$('#insertRole').hide();
				}
				showModal('Role Update Success!', 1);
				ClearForm(data);
				$('#btnUpdate, #btnCancel').hide();
				$('#btnSubmit, #btnClear').show();
				refreshRoleList();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	})

	$('#btnAlright').click(function() {
		$('#Modal').modal('hide');
	});

	function showModal(data, status){
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

	function refreshRoleList(){
		$('#divLoading2').show();
		$('#divRoleList').hide();
		$.ajax({
			type 		: 'POST',
			url 		: '/RefreshRoleList',
			dataType 	: 'json',
			success:function(data){
				$('#divLoading2').hide();
				$('#divRoleList').html(data);
				$('#divRoleList').fadeIn();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function ClearForm(RoleID){
		$('#divRoleID').html(RoleID);
		$('input[type="checkbox"]').prop('checked', false);
		$('#txtRoleName').val('');
	}
});