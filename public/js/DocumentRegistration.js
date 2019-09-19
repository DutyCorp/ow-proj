$(document).ready(function() {
	$.ajaxSetup({
  		headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
	});
	$('#DocumentRegistrationTable').DataTable();
	$('#Info_DocumentType').hide();
	$('#buttonUpdateDocumentType').hide();
	$('#buttonCancelDocumentType').hide();
	refreshDocumentTable();
	$('#buttonUpdateDocumentRegistration').hide();
	$('#buttonCancelDocumentRegistration').hide();

	function RefreshDocumentByDropdown(){
		var FilterData = {
	    	DocumentRegion 			: $('#DocumentRegion').val(),
	    	DocumentType 			: $('#DocumentType').val(),
		}
	    $.ajax({
	    	type: 'POST',
	    	url: '/FilterDocumentByDropdown',
	    	data: FilterData,
	    	dataType: 'json',
	    	success:function(data){
	    		$('#TableDocument').html(data);
				$('#DocumentRegistrationTable').DataTable({
					dom: 'Bfrtip',
					"columnDefs": [     
						{ "width": "8%", "targets": 3 },
					],
					"order": [[ 0, 'desc' ]],
					buttons: [ {extend:'pageLength',text: '<span>Show Page</span>'},{
			            extend: 'excelHtml5',
			            text 	: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
			            title 	: 'Document Registrations Report',	
			            customize: function (xlsx) {
			                var sheet 	= xlsx.xl.worksheets['sheet1.xml'];
			                var numrows = 4;
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
			                var Title1 = Addrow(1, [{ key: 'A', value: 'Invoice Progress Report'}]);
			               	var Title3 = Addrow(2, [{ key: 'A', value: $('#DocumentLastUpdate').text() }]);
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

	$('#DocumentRegion').change(function(){
		if($('#DocumentType').val() != "None" && $('#DocumentRegion').val() != "None" ){
			RefreshDocumentByDropdown();
		} else if($('#DocumentType').val() == "None" || $('#DocumentRegion').val() == "None" ){
			refreshDocumentTable();
		}
	});

	$('#DocumentType').change(function(){
		if($('#DocumentType').val() != "None" && $('#DocumentRegion').val() != "None" ){
			RefreshDocumentByDropdown();
		} else if($('#DocumentType').val() == "None" || $('#DocumentRegion').val() == "None" ){
			refreshDocumentTable();
		}
	})

	$('#buttonUpdateDocumentRegistration').click(function(){
		var DocumentRegion 	= $('#DocumentRegion').val();
		var DocumentNumber 	= $('#DocumentNumber').val();
		var DocumentType 	= $('#DocumentType').val();
		var DocumentOwner 	= $('#DocumentOwner').val();
		var DocumentDate 	= $('#DocumentDate').val();
		var DocumentDestination 	= $('#DocumentDestination').val();
		var DocumentDescription 	= $('#DocumentDescription').val();
		var DocumentApprover 	= $('#DocumentApprover').val();

		if(DocumentRegion == "None"){
			showModal("Document Region must be choosen", 0);
			return false;
		} else if(DocumentType == "None"){
			showModal("Document Type must be choosen", 0);
			return false;
		} else if(DocumentDate == ""){
			showModal("Document Date must be choosen", 0);
			return false;
		} else if(DocumentDescription == ""){
			showModal("Document Description must be filled", 0);
			return false;
		} else if(DocumentOwner == ""){
			showModal("Document Owner must be choosen", 0);
			return false;
		} else if(DocumentDestination == ""){
			showModal("Document Destination must be filled", 0);
			return false;
		} else if(DocumentApprover == ""){
			showModal("Document Approver must be filled", 0);
			return false;
		} else{
			var DocumentData = {
		    	DocumentRegion 			: DocumentRegion,
		    	DocumentNumber 			: DocumentNumber,
		    	DocumentType 			: DocumentType,
		    	DocumentOwner 			: DocumentOwner,
		    	DocumentDate 			: DocumentDate,
		    	DocumentDestination 	: DocumentDestination,
		    	DocumentDescription 	: DocumentDescription,
		    	DocumentApprover		: DocumentApprover
		    }
		    $.ajax({
		    	type: 'POST',
		    	url: '/UpdateDocument',
		    	data: DocumentData,
		    	dataType: 'json',
		    	success:function(data){
		    			showModal("Success Update Document",1);
		    			ClearDocument();
		    			refreshDocumentTable();
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

	function ClearDocument(){
		$('#DocumentRegion').val("None");
		$('#DocumentNumber').val("");
		$('#DocumentType').val("None");
		$('#DocumentOwner').val("None");
		$('#DocumentDate').val("");
		$('#DocumentDestination').val("");
		$('#DocumentDescription').val("");
		$('#DocumentApprover').val("");
		$('#buttonSubmitDocumentRegistration').show();
		$('#buttonClearDocumentRegistration').show();
		$('#buttonUpdateDocumentRegistration').hide();
		$('#buttonCancelDocumentRegistration').hide();
		$('#DocumentNumber').removeAttr("disabled");
	}

	$('#buttonCancelDocumentRegistration').click(function(){
		ClearDocument();
	});

	function refreshDocumentTable(){
		$.ajax({
			type: 'POST',
			url: '/refreshTableDocument',
			dataType: 'json',
			success:function(data){
				$('#TableDocument').html(data);
				$('#DocumentRegistrationTable').DataTable({
					dom: 'Bfrtip',
					"columnDefs": [     
						{ "width": "8%", "targets": 3 },
					],
					"order": [[ 3, 'desc' ]],
					buttons: [ {extend:'pageLength',text: '<span>Show Page</span>'},{
			            extend: 'excelHtml5',
			            text 	: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
			            title 	: 'Document Registrations Report',	
			            customize: function (xlsx) {
			                var sheet 	= xlsx.xl.worksheets['sheet1.xml'];
			                var numrows = 4;
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
			                var Title1 = Addrow(1, [{ key: 'A', value: 'Document Registration Report'}]);
			               	var Title3 = Addrow(2, [{ key: 'A', value: $('#DocumentLastUpdate').text() }]);
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
	
	$('#buttonClearDocumentRegistration').click(function(){
		ClearDocument();
	});	

	$('#buttonSubmitDocumentRegistration').click(function(){
		var DocumentRegion 	= $('#DocumentRegion').val();
		var DocumentNumber 	= $('#DocumentNumber').val();
		var DocumentType 	= $('#DocumentType').val();
		var DocumentOwner 	= $('#DocumentOwner').val();
		var DocumentDate 	= $('#DocumentDate').val();
		var DocumentDestination 	= $('#DocumentDestination').val();
		var DocumentDescription 	= $('#DocumentDescription').val();
		var DocumentApprover 	= $('#DocumentApprover').val();
		
		if(DocumentRegion == "None"){
			showModal("Document Region must be choosen", 0);
			return false;
		} else if(DocumentType == "None"){
			showModal("Document Type must be choosen", 0);
			return false;
		} else if(DocumentDate == ""){
			showModal("Document Date must be choosen", 0);
			return false;
		} else if(DocumentDescription == ""){
			showModal("Document Description must be filled", 0);
			return false;
		} else if(DocumentNumber == ""){
			showModal("Document Number must be filled", 0);
			return false;
		} else if(DocumentOwner == ""){
			showModal("Document Owner must be choosen", 0);
			return false;
		} else if(DocumentDestination == ""){
			showModal("Document Destination must be filled", 0);
			return false;
		} else if(DocumentApprover == ""){
			showModal("Document Approver must be filled", 0);
			return false;
		} else{
			var DocumentData = {
		    	DocumentRegion 			: DocumentRegion,
		    	DocumentNumber 			: DocumentNumber,
		    	DocumentType 			: DocumentType,
		    	DocumentOwner 			: DocumentOwner,
		    	DocumentDate 			: DocumentDate,
		    	DocumentDestination 	: DocumentDestination,
		    	DocumentDescription 	: DocumentDescription,
		    	DocumentApprover		: DocumentApprover
		    }
		    $.ajax({
		    	type: 'POST',
		    	url: '/EntryDocument',
		    	data: DocumentData,
		    	dataType: 'json',
		    	success:function(data){
		    		if(data == 1){
		    			showModal("Success Register Document",1);
		    			ClearDocument();
		    			refreshDocumentTable();
		    		} else {
		    			showModal("Document Number already registered",0);
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

	$('#buttonCancelDocumentType').click(function(){
		ClearDocumentType();
	});

	$('#buttonUpdateDocumentType').click(function(){
		var DocumentTypeID 	= localStorage.getItem('UpdateID_for_DocumentType');
		var DocumentTypeName = $('#DocumentTypeName').val();

		if(DocumentTypeName == ""){
			$('#Info_DocumentType').text("Document Type must be filled");
			$('#Info_DocumentType').show();
			return false;
		}else{
			var DocumentTypeData = {
		    	DocumentTypeID 		: DocumentTypeID,
		    	DocumentTypeName 	: DocumentTypeName,
		    }
		    $.ajax({
				type: 'POST',
				url: '/CheckDocumentTypeName',
				data : DocumentTypeData,
				dataType: 'json',
				success:function(data){
					if(data == 1){
						$('#ModalAddDocumentType').modal('hide');
						$.ajax({
					    	type: 'POST',
					    	url: '/UpdateDocumentType',
					    	data: DocumentTypeData,
					    	dataType: 'json',
					    	success:function(data){
				    			showModal(data,1);
				    			ClearDocumentType();
				    			refreshDocumentTypeTable();
				    			refreshDropdownDocumentType();
					    	},
					    	error: function (xhr, ajaxOptions, thrownError) {
					    		showModal("Whoops! Something wrong", 0);
					    		console.log(xhr.status);
					    		console.log(xhr.responseText);
					    		console.log(thrownError);
					    	}
					    });
						showModal("Success Register Document Type",1);
						refreshDocumentTypeTable();
					}
					else{
						$('#Info_DocumentType').text("Document Type already registered");
						$('#Info_DocumentType').show();
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

	function refreshDropdownDocumentType(){
		$('#DocumentType').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownDocumentType',
			dataType: 'json',
			success:function(data){
				$('#DocumentType').append('<option value="None">Select</option>');
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#DocumentType').append('<option value="'+data[i]['DocumentTypeID']+'">'+data[i]['DocumentTypeName']+'</option>');
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

	$('#buttonAddDocumentType').click(function(){
		var DocumentTypeName = $('#DocumentTypeName').val();
		if(DocumentTypeName == ""){
			$('#Info_DocumentType').text("Document Type must be filled");
			$('#Info_DocumentType').show();
			return false;
		}else{
			var DocumentTypeData = {
				DocumentTypeName  : DocumentTypeName,
			};
			$.ajax({
				type: 'POST',
				url: '/CheckDocumentTypeName',
				data : DocumentTypeData,
				dataType: 'json',
				success:function(data){
					if(data == 1){
						$('#ModalAddDocumentType').modal('hide');
						showModal("Success Register Document Type",1);
						refreshDocumentTypeTable();
						refreshDropdownDocumentType();
					}
					else{
						$('#Info_DocumentType').text("Document Type already registered");
						$('#Info_DocumentType').show();
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

	$('#AddDocumentType').click(function(){
		$('#Info_DocumentType').hide();
		ClearDocumentType();
		refreshDocumentTypeTable();
	});

	$('#btnAlright').click(function() {
		$('#Modal').modal('hide');
	});

	function refreshDocumentTypeTable(){
		$.ajax({
			type: 'POST',
			url: '/refreshTableDocumentType',
			dataType: 'json',
			success:function(data){
				$('#tableDocumentType').html(data);
				$('#DocumentTypeTable').DataTable({
					"bAutoWidth": false,
					"columnDefs": [     
						{ "width": "5%", "targets": 0 },
					]
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

	function ClearDocumentType(){
		$('#DocumentTypeName').val("");
		$('#buttonUpdateDocumentType').hide();
		$('#buttonCancelDocumentType').hide();
		$('#buttonAddDocumentType').show();
	}

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