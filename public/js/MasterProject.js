$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	$('#Info_ProjectType').hide();
	$('#newPT').hide();
	$('#buttonCancelMasterProject').hide();
	$('#buttonUpdateMasterProject').hide();
	$('#masterProjectTable').DataTable();
	refreshTableProject();

	/////REGION/////

	$('#addNewRegion').click(function() {
		ClearRegion();
	});

	$('#buttonSubmitRegion').click(function() {
		var EntryRegionID = $('#RegionID').val();
		var EntryRegionName = $('#RegionName').val();
		var EntryRegionPhone = $('#RegionPhone').val();
		var EntryRegionAddress = $('#RegionAddress').val();
		var EntryRegionFax = $('#RegionFax').val();
	    if (EntryRegionID == ""){
	        ModalAlert("RegionInfo","Region ID must be filled","red");
	        return false;
	    }
	    else if (EntryRegionName == ""){
	        ModalAlert("RegionInfo","Region Name must be filled","red");
	        return false;
	    }
	    else{	
	    	var CheckRegionData = {
	    		RegionID 		: EntryRegionID,
	    	}
	    	$.ajax({
				type: 'POST',
				url: '/CheckRegionID',
				data: CheckRegionData,
				dataType: 'json',
				success:function(data){
					if(data != "")
					{
						ModalAlert("RegionInfo","Region ID already exist","red");
				        return false;
					}
					else
					{
						var EntryRegionData = {
				    		RegionID 		: EntryRegionID,
				    		RegionName 		: EntryRegionName,
				    		RegionPhone 	: EntryRegionPhone,
				    		RegionAddress 	: EntryRegionAddress,
				    		RegionFax 		: EntryRegionFax
						}
				    	$.ajax({
							type: 'POST',
							url: '/EntryRegion',
							data: EntryRegionData,
							dataType: 'json',
							success:function(data){
								ClearRegion();
								ModalAlert("RegionInfo","Success Entry Region","green");
							},
							error: function (xhr, ajaxOptions, thrownError) {
			           			showModal("Whoops! Something wrong", 0);
			           			console.log(xhr.status);
			           			console.log(xhr.responseText);
			           			console.log(thrownError);
			       			}
						});
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
	});

	$('#closeRegionButton').click(function() {
		refreshDropdownRegion();
	});

	$('#RegionModal').on('hidden.bs.modal', function (e) {
        refreshDropdownRegion();
    });

	$('#buttonUpdateRegion').click(function() {
		var UpdateRegionName 	= $('#RegionName').val();
		var UpdateRegionPhone 	= $('#RegionPhone').val();
		var UpdateRegionAddress = $('#RegionAddress').val();
		var UpdateRegionFax 	= $('#RegionFax').val();
	    if (UpdateRegionName == "") {
	    	ModalAlert("RegionInfo","Region Name must be filled","red");
	        return false;
	    } else {
	    	var UpdateRegionData = {
		    	RegionID 		: $('#RegionID').val(),
		    	RegionName  	: UpdateRegionName,
		    	RegionAddress 	: UpdateRegionAddress,
		    	RegionPhone 	: UpdateRegionPhone,
		    	RegionFax 		: UpdateRegionFax
		    }
		    $.ajax({
		    	type 		: 'POST',
		    	url 		: '/RegionUpdate',
		    	data 		: UpdateRegionData,
		    	dataType 	: 'json',
		    	success:function(data){
		    		ClearRegion();
					ModalAlert("RegionInfo","Success Update Region","green");
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

	$('#buttonCancelRegion').click(function(){
		ClearRegion();
	});

	function refreshDropdownRegion(){
		$('#selectRegion').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownRegion',
			dataType: 'json',
			success:function(data){
				$('#selectRegion').append('<option value="None">Select</option>');
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#selectRegion').append('<option value="'+data[i]['RegionID']+'">'+data[i]['RegionName']+'</option>');
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

	function refreshTableRegion() {
		$('#tableRegion').html("");
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableRegion',
			dataType 	: 'json',
			success:function(data) {
				$('#tableRegion').html(data);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function ClearRegion(){
		$('#buttonUpdateRegion').hide();
		$('#buttonCancelRegion').hide();
		$('#buttonSubmitRegion').show();
		$('#RegionID').removeAttr("disabled");
		$('#RegionID').val("");
		$('#RegionName').val("");
		$('#RegionPhone').val("");
		$('#RegionAddress').val("");
		$('#RegionFax').val("");
		$('#RegionInfo').hide();
		refreshTableRegion();
	}

    //////PROJECT//////


	function ClearMasterProject() {
		$('#newProjectType').val("")
		$('#projectCode').val("");
		$('#projectName').val("");
		$('#projectRegion').val("AS");
		$('#projectType').val("None");
		$('#projectBA').val("BG");
		$('#newPT').hide();
		$('#PT').show();
		$('#projectCode').removeAttr("disabled");
		$('#buttonUpdateMasterProject').hide();
		$('#buttonCancelMasterProject').hide();
		$('#buttonSubmitMasterProject').show();
		$('#buttonClearMasterProject').show();
	}

	$('#buttonClearMasterProject').click(function(){
		ClearMasterProject();
	});

	$('#buttonCancelMasterProject').click(function(){
		ClearMasterProject();
	});

	$('#buttonUpdateMasterProject').click(function(){
		var ProjectCode 	= $('#projectCode').val();
		var ProjectName 	= $('#projectName').val();
		var ProjectRegion 	= $('#projectRegion').val();
		var ProjectBA 		= $('#projectBA').val();	

		if($('#projectType').val() == "None")
			var ProjectType 	= $('#newProjectType').val();
		else
			var ProjectType 	= $('#projectType').val();
		
		if(ProjectName == ""){
			showModal("Project Name must be filled", 0);
			return false;
		}else if(ProjectType == "None" || ProjectType == "" ){
			showModal("Project Type must be chosen", 0);
			return false;
		}else{
			var ProjectData = {
		    	ProjectCode 	: ProjectCode,
		    	ProjectName 	: ProjectName,
		    	ProjectType 	: ProjectType,
		    	ProjectRegion 	: ProjectRegion,
		    	ProjectBA 		: ProjectBA
		    }
		    $.ajax({
		    	type: 'POST',
		    	url: '/UpdateProject',
		    	data: ProjectData,
		    	dataType: 'json',
		    	success:function(data){
	    			showModal(data,1);
	    			ClearMasterProject();
	    			refreshTableProject();
	    			$('#projectType').html("");
					$.ajax({
						type: 'POST',
						url: '/refreshProjectType',
						dataType: 'json',
						success:function(data){
							$('#projectType').append('<option value="None">Select</option>');
							var j = data.length;
							for (var i = 0; i < j; i++){
								$('#projectType').append('<option value="'+data[i]['ProjectType']+'">'+data[i]['ProjectType']+'</option>');
							}
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
		    		showModal("Whoops! Something wrong", 0);
		    		console.log(xhr.status);
		    		console.log(xhr.responseText);
		    		console.log(thrownError);
		    	}
		    });
		}
	});

	$('#AddPTBtn').click(function(){
		$('#AddProjectType').val("");
	});

	$('#buttonAddProjectType').click(function(){
		var NewProjectType = $('#AddProjectType').val();
		if( NewProjectType == ""){
			ModalAlert("Info_ProjectType","Project Type must be filled","red");
			return false;
		} else {
			$('#projectType').val("None");
			var ProjectTypeData = {
		    	ProjectType 	: NewProjectType,
		    }
			$.ajax({
		    	type: 'POST',
		    	url: '/CheckProjectType',
		    	data: ProjectTypeData,
		    	dataType: 'json',
		    	success:function(data){
		    		if(data == 1){
		    			$('#AddProjectType').val("")
		    			$('#Info_ProjectType').hide();
		    			$('#ModalAddProjectType').modal('hide');
		    			$('#PT').hide();
		    			$('#newPT').show();
		    			$('#newProjectType').val(NewProjectType);
		    		} else {
						ModalAlert("Info_ProjectType","Project Type already registered","red");
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
	});

	$('#buttonSubmitMasterProject').click(function(){
		var ProjectCode 	= $('#projectCode').val();
		var ProjectName 	= $('#projectName').val();
		var ProjectRegion 	= $('#projectRegion').val();
		var ProjectBA 		= $('#projectBA').val();

		if($('#projectType').val() == "None")
			var ProjectType 	= $('#newProjectType').val();
		else
			var ProjectType 	= $('#projectType').val();
		
		if(ProjectCode.length != 7 ){
			showModal("Project Code length must be 7 words", 0);
			return false;
		}else if(ProjectName == ""){
			showModal("Project Name must be filled", 0);
			return false;
		}else if(ProjectType == "None" || ProjectType == "" ){
			showModal("Project Type must be chosen", 0);
			return false;
		}else{
			var ProjectData = {
		    	ProjectCode 	: ProjectCode,
		    	ProjectName 	: ProjectName,
		    	ProjectType 	: ProjectType,
		    	ProjectRegion 	: ProjectRegion,
		    	ProjectBA 		: ProjectBA
		    }
		    $.ajax({
		    	type: 'POST',
		    	url: '/EntryProject',
		    	data: ProjectData,
		    	dataType: 'json',
		    	success:function(data){
		    		if(data == 1){
		    			showModal("Success Register Project",1);
		    			ClearMasterProject();
		    			refreshTableProject();
		    			$('#projectType').html("");
						$.ajax({
							type: 'POST',
							url: '/refreshProjectType',
							dataType: 'json',
							success:function(data){
								$('#projectType').append('<option value="None">Select</option>');
								var j = data.length;
								for (var i = 0; i < j; i++){
									$('#projectType').append('<option value="'+data[i]['ProjectType']+'">'+data[i]['ProjectType']+'</option>');
								}
							},
							error: function (xhr, ajaxOptions, thrownError) {
								showModal("Whoops! Something wrong", 0);
								console.log(xhr.status);
								console.log(xhr.responseText);
								console.log(thrownError);
							}
						});
		    		} else {
		    			showModal("Project Code already registered",0);
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
	});

	function refreshTableProject() {
		$.ajax({
			type: 'POST',
			url: '/refreshTableProject',
			dataType: 'json',
			success:function(data){
				$('#tableMasterProject').html(data['returnHTML']);
				$('#tableMasterProject').css("width", "60%");
				$('#tableMasterProject').css("margin", "0 auto");
				$('#masterProjectTable').DataTable({
					dom: 'Bfrtip',
					buttons: [ {extend:'pageLength',text: '<span>Show Page</span>'},{
			            extend: 'excelHtml5',
			            text 	: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
			            title 	: 'Master Project',	
			            customize: function (xlsx) {
			                var sheet 	= xlsx.xl.worksheets['sheet1.xml'];
			                var numrows = 3;
			                var clR 	= $('row', sheet);
			                clR.each(function () {
			                    var attr 	= $(this).attr('r');
			                    var ind 	= parseInt(attr);
			                    ind 		= ind + numrows;
			                    $(this).attr("r",ind);
			                });
			                $('row c ', sheet).each(function () {
			                    var attr 	= $(this).attr('r');
			                    var pre 	= attr.substring(0, 1);
			                    var ind 	= parseInt(attr.substring(1, attr.length));
			                    ind 		= ind + numrows;
			                    $(this).attr("r", pre + ind);
			                });
			                function Addrow(index,data) {
			                    msg='<row r="'+index+'">'
			                    for(i=0;i<data.length;i++){
			                        var key=data[i].key;
			                        var value=data[i].value;
			                        msg 	+= '<c t="inlineStr" r="' + key + index + '">';
			                        msg 	+= '<is>';
			                        msg 	+=  '<t>'+value+'</t>';
			                        msg		+=  '</is>';
			                        msg		+= '</c>';
			                    }
			                    msg += '</row>';
			                    return msg;
			                }
			                var Title1 = Addrow(1, [{ key: 'A', value: 'Master Project'}]);
			               	var Title3 = Addrow(2, [{ key: 'A', value: 'Last Update : ' + data['ProjectDate'][0].Tr_Date_I }]);
			                sheet.childNodes[0].childNodes[1].innerHTML = Title1 + Title3 + sheet.childNodes[0].childNodes[1].innerHTML;
			            }
			        } ],
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

	function ModalAlert(Info,Alert,Color){
    	$('#'+Info).show();
        $('#'+Info).text(Alert);
		document.getElementById(Info).style.color = Color;
		document.getElementById(Info).style.fontSize = "14px";
    }

	//////Business Area//////
	
	$('#AddBABtn').click(function(){
		ClearBA();
	});

	function ClearBA(){
		$('#AddBAID').removeAttr("disabled");
		$('#AddBAID').val("");
		$('#AddBAName').val("");
		$('#buttonUpdateBA').hide(); 
		$('#buttonCancelBA').hide(); 
		$('#buttonAddBA').show();
		$('#Info_BA').hide();
		refreshTableBusinessArea();
	}

	function refreshDropdownBA(){
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownBA',
			dataType: 'json',
			success:function(data){
				$('#projectBA').html("");
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#projectBA').append('<option value="'+data[i]['BusinessAreaID']+'">'+data[i]['BusinessAreaName']+'</option>');
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

	$('#ModalAddBusinessArea').on('hidden.bs.modal', function (e) {
        refreshDropdownBA();
    });

    $('#closeAddBA').click(function(){
		refreshDropdownBA();
	});
	
	$('#buttonAddBA').click(function(){
		var BAID	= $('#AddBAID').val();
		var BAName 	= $('#AddBAName').val();
		if( BAID == "" ){
			ModalAlert("Info_BA","Business Area ID must be filled","red");
			return false;
		} else if( BAID.length != 2 ){
			ModalAlert("Info_BA","Business Area can't more than 2 character","red");
			return false;
		} else if( BAName == "" ){
			ModalAlert("Info_BA","Business Area Name must be filled","red");
			return false;
		} else {
			var BAData = {
		    	BAID 	: BAID,
		    	BAName 	: BAName
		    }
			$.ajax({
		    	type: 'POST',
		    	url: '/EntryBusinessArea',
		    	data: BAData,
		    	dataType: 'json',
		    	success:function(data){
		    		if(data == 1){
		    			ClearBA();
		    			ModalAlert("Info_BA","Success Entry Business Area","green");
		    		} else {
		    			ModalAlert("Info_BA","Business Area ID already registered","red");
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
	});

	$('#buttonUpdateBA').click(function(){
		var BAID	= $('#AddBAID').val();
		var BAName 	= $('#AddBAName').val();
		if( BAName == "" ){
			ModalAlert("Info_BA","Business Area Name must be filled","red");
			return false;
		} else {
			var BAData = {
		    	BAID 	: BAID,
		    	BAName 	: BAName
		    }
			$.ajax({
		    	type: 'POST',
		    	url: '/BAUpdate',
		    	data: BAData,
		    	dataType: 'json',
		    	success:function(data){
	    			ClearBA();
	    			ModalAlert("Info_BA","Success Update Business Area","green");
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

	$('#buttonCancelBA').click(function(){
		ClearBA();
	});

	function refreshTableBusinessArea() {
		$('#tableBA').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshTableBusinessArea',
			dataType: 'json',
			success:function(data){
				$('#tableBA').html(data);
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