$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var EmployeeTo = []; EmployeeCc = [];

	$('#employeeCc').DataTable({
		"paging":   false,
		"autoWidth": false,
		"columnDefs": [     
			{ "width": "5%", "targets": 0 },
			{ "width": "95%", "targets": 1 }
		]
	});

	$('#employeeTo').DataTable({
		"paging":   false,
		"autoWidth": false,
		"columnDefs": [     
			{ "width": "5%", "targets": 0 },
			{ "width": "95%", "targets": 1 }
		]
	});

	$('#selectRegion').change(function() {
		changeTo();
	});
	$('#btnTo').click(function() {
		$('#ModalTo').modal();
	});
	$('#btnCC').click(function() {
		$('#ModalCc').modal();
	});
	$('#btnSaveTo').click(function() {
		$('#ModalTo').modal('hide');
		saveTo();
	});
	$('#btnSaveCc').click(function() {
		$('#ModalCc').modal('hide');
		saveCc();
	});
	$('#btnSend').click(function() {
		sendEmail();
	});
	$('#btnAlright').click(function() {
		$('#Modal').modal('hide');
	});

	function changeTo(){
		var RegionData = {
			RegionID: $('#selectRegion').val()
		}
		$.ajax({
			type: 'POST',
			url: '/GetEmployeeData',
			data: RegionData,
			dataType: 'json',
			success:function(data){
				console.log(data);
				$('#employeeTo').dataTable().fnDestroy();
				$('#employeeTo tbody').html("");
				var tbody = "";
				for (var i = 0; i < data.length; i++){
					var html = "";
					html += "<tr>";
					html += "<td><input type=checkbox class=cbxTo value="+data[i]['EmployeeID']+"></td>";
					html += "<td><p>"+data[i]['EmployeeName']+"</p></td>";
					html += "</tr>";
					tbody += html;
				}
				$('#employeeTo tbody').html(tbody);
				$('#employeeTo').DataTable({
					"paging":   false,
					"autoWidth": false,
					"columnDefs": [     
						{ "width": "5%", "targets": 0 },
						{ "width": "95%", "targets": 1 }
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

	function saveTo(){
		var CheckedTo = 0;
		EmployeeTo = [];
		$('.cbxTo').each(function() {
			if ($(this).is(':checked')){
				EmployeeTo.push($(this).val());
				CheckedTo++;
			}
		});
		$('#totalTo').text(CheckedTo);
	}

	function saveCc(){
		var CheckedCc = 0;
		EmployeeCc = [];
		$('.cbxCc').each(function() {
			if ($(this).is(':checked')){
				EmployeeCc.push($(this).val());
				CheckedCc++;
			}	
		});
		$('#totalCc').text(CheckedCc);
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

	function sendEmail(){
		if (EmployeeTo.length == 0){
			showModal('Employee To must be filled!', 0);
			return false;
		}
		$('#LoadingModal').modal();
		var formData = new FormData();
		formData.append('BodyEmail', $('#txtBodyEmail').val().replace(/\r\n|\r|\n/g,"<br />"));
		for (var i = 0; i < $('#fileAttachment')[0].files.length; i++){
			formData.append('File'+ i, $('#fileAttachment').get(0).files[i]);
		}
		formData.append('TotalFile', i);
		formData.append('ListEmployeeIDTo', EmployeeTo);
		formData.append('ListEmployeeIDCc', EmployeeCc);
		formData.append('Subject', $('#txtSubject').val());
		$.ajax({
			type: 'POST',
			url: '/SendEmailBlast',
			data: formData,
			processData: false,
  			contentType: false,
			dataType: 'json',
			success:function(data){
				showModal(data, 1);
				resetForm();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal('Whoops! Something wrong', 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function resetForm(){
		$('#selectRegion').val("None");
		$('.cbxTo').each(function() {
			this.checked = false;
		});
		$('.cbxCc').each(function() {
			 this.checked = false;
		});
		$('#txtSubject').val("");
		$('#txtBodyEmail').val("");
		$('#fileAttachment').val("");
		$('#totalTo').text('0');
		$('#totalCc').text('0');
	}
});