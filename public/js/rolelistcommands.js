$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('.btnDelete').click(function() {
		var RoleID 		= $(this).val();
		showModalDelete("Are you sure you want to delete "+ RoleID +"?");
		$('#YesDelete').click(function() {
			$('#ModalDelete').modal('hide');
			var RoleData 	= {
				RoleID: RoleID
			}
			$.ajax({
				type 		: 'POST',
				url 		: '/DeleteRole',
				data 		: RoleData,
				dataType 	: 'json',
				success:function(data){
					showModal('Role Success Deleted!', 1);
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
		$('#NoDelete').click(function() {
			$('#ModalDelete').modal('hide');
		});
	});

	$('.btnEdit').click(function() {
		$('#divLoading').show();
		$('#divTableRoleAccess').hide();
		var RoleID  	= $(this).val();
		var RoleData  	= {
			RoleID: RoleID
		}
		ClearForm(RoleID);
		$.ajax({
			type 		: 'POST',
			url 		: '/GetRoleData',
			data 		: RoleData,
			dataType 	: 'json',
			success:function(data){
				$('#insertRole').show();
				$('#btnUpdate, #btnCancel').show();
				$('#btnSubmit, #btnClear').hide();
				$('.cbxRegion').each(function() {
					for (var i = 0; i < data['regionvisibility'].length; i++){
						if (data['regionvisibility'][i]['RegionID'] == $(this).val()){
							if (data['regionvisibility'][i]['isVisible'] == 1){
								$(this).prop('checked', true);
							} else {
								$(this).prop('checked', false);
							}
						}
					}
				});
				$('.cbxGrade').each(function() {
					for (var i = 0; i < data['grade'].length; i++){
						if (data['grade'][i]['GradeID'] == $(this).val()){
							if (data['grade'][i]['isVisible'] == 1){
								$(this).prop('checked', true);
							} else {
								$(this).prop('checked', false);
							}
						}
					}
				});
				var j = 0;
				$('#tableRoleAccess tbody tr').each(function() {
					if (typeof(data['rolemenu'][j]) != 'undefined'){
						if ($(this).attr('id') == data['rolemenu'][j]['MenuChildID']){
							if(data['rolemenu'][j]['Role_S'] == "1"){
								$(this).find('#s').prop('checked', true);
							}
							if(data['rolemenu'][j]['Role_I'] == "1"){
								$(this).find('#i').prop('checked', true);
							}
							if(data['rolemenu'][j]['Role_U'] == "1"){
								$(this).find('#u').prop('checked', true);
							}
							if(data['rolemenu'][j]['Role_D'] == "1"){
								$(this).find('#d').prop('checked', true);
							}	
							j++;
						}
					}
				});
				$('#txtRoleName').val(data['rolename'][0]['RoleName']);
				$('#divLoading').hide();
				$('#divTableRoleAccess').fadeIn();
				$('html, body').animate({ scrollTop: $('#insertRole').offset().top }, 'slow');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});
	
	function ClearForm(RoleID){
		$('#divRoleID').html(RoleID);
		$('input[type="checkbox"]').prop('checked', false);
		$('#txtRoleName').val('');
	}

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

	function showModalDelete(text){
		$('#ModalDeleteContent').html(text);
		$('#ModalDelete').modal(); 
	}
});