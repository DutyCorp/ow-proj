$(document).ready(function() {
	$.ajaxSetup({
  		headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		}
	});

	$('#divLoading').hide();

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		return year + month;
	}

	$('#btnSubmitClaimReport').click(function() {
		var Region = $('#selectClaimRegion').val();
		if ($('#SubmissionPeriodFrom').val() != "" || $('#SubmissionPeriodTo').val() != ""){
			if ($('#SubmissionPeriodFrom').val() == "" ? $('#SubmissionPeriodTo').val() != "" : $('#SubmissionPeriodTo').val() == ""){
				showModal('Submission Date From or Submission Date To must be filled!', 0);
				return false;
			}
		}
		if ($('#ApprovalPeriodFrom').val() != "" || $('#ApprovalPeriodTo').val() != ""){
			if  ($('#ApprovalPeriodFrom').val() == "" ? $('#ApprovalPeriodTo').val() != "" : $('#ApprovalPeriodTo').val() == ""){
				showModal('Approval Date From or Approval Date To must be filled!', 0);
				return false;
			}
		}
		if ($('#SubmissionPeriodFrom').val() != "") {
			var SubmissionDateFrom = getEditFormattedDate(new Date($('#SubmissionPeriodFrom').val()));
		} else {
			var SubmissionDateFrom = $('#SubmissionPeriodFrom').val();
		}
		if ($('#SubmissionPeriodTo').val() != "") {
			var SubmissionDateTo = getEditFormattedDate(new Date($('#SubmissionPeriodTo').val()));
		} else {
			var SubmissionDateTo = $('#SubmissionPeriodTo').val();
		}
		if ($('#ApprovalPeriodFrom').val() != "") {
			var ApprovalDateFrom = getEditFormattedDate(new Date($('#ApprovalPeriodFrom').val()));
		} else {
			var ApprovalDateFrom = $('#ApprovalPeriodFrom').val();
		}
		if ($('#ApprovalPeriodTo').val() != "") {
			var ApprovalDateTo = getEditFormattedDate(new Date($('#ApprovalPeriodTo').val()));
		} else {
			var ApprovalDateTo = $('#ApprovalPeriodTo').val();
		}	
		var ViewType = $("input:radio[name=ViewType]:checked").val();
		if (SubmissionDateTo < SubmissionDateFrom){
			showModal('Submission Date To must be higher than Submission Date From!', 0);
			return false;
		}
		if (ApprovalDateTo < ApprovalDateFrom){
			showModal('Approval Date To must be higher than Approval Date From!', 0);
			return false;
		}
		if (typeof ViewType == 'undefined'){
			showModal('View Type must be filled!', 0);
		} else {
			$('#tableClaimReport').hide();
			$('#divLoading').show();
			var ClaimData = {
				Region: Region,
				SubmissionDateFrom: SubmissionDateFrom,
				SubmissionDateTo: SubmissionDateTo,
				ApprovalDateFrom: ApprovalDateFrom,
				ApprovalDateTo: ApprovalDateTo,
				ViewType: ViewType
			}
			$.ajax({
				type: 'POST',
				url: '/GetClaimReportData',
				data: ClaimData,
				dataType: 'json',
				success:function(data){
					var rows = 0;
					$('#tableClaimReport').html(data);
					$('#tableClaimReport').show();
					if (ViewType != "TEType"){
						$('#tableClaimReport').css("width", "100%");
						$('#tableClaimReport').css("margin", "0 auto");
						$('#claimReportTable').DataTable({
					        scrollX 		: true,
					        scrollCollapse 	: true,
							dom: 'Bfrtip',
							lengthMenu: [
					            [ 10, 25, 50, -1 ],
					            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
					        ],
							buttons: [{extend:'pageLength',text: '<span>Show Page</span>'},	 {
					            extend: 'excelHtml5',
					            title: 'Personal Claim Report '+ViewType+' ' + getEditFormattedDate(new Date()),
					            text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
					            footer: true
					        } ]
						});
					} else {
						$('#tableClaimReport').css("width", "30%");
						$('#tableClaimReport').css("margin", "0 auto");
						$('#claimReportTable').DataTable({
					        scrollX 		: true,
					        scrollCollapse 	: true,
							dom: 'Bfrtip',
							lengthMenu: [
					            [ 10, 25, 50, -1 ],
					            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
					        ],
							buttons: [{extend:'pageLength',text: '<span>Show Page</span>'},	 {
					            extend: 'excelHtml5',
					            title: 'Claim Report ',
					            text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
					            footer: true,
					            customize: function (xlsx) {
					                var sheet = xlsx.xl.worksheets['sheet1.xml'];
					                var numrows = 3;
					                var clR = $('row', sheet);

					                //update Row
					                clR.each(function () {
					                    var attr = $(this).attr('r');
					                    var ind = parseInt(attr);
					                    ind = ind + numrows;
					                    $(this).attr("r",ind);
					                });

					                // Create row before data
					                $('row c ', sheet).each(function () {
					                    var attr = $(this).attr('r');
					                    var pre = attr.substring(0, 1);
					                    var ind = parseInt(attr.substring(1, attr.length));
					                    ind = ind + numrows;
					                    $(this).attr("r", pre + ind);
					                });

					                function Addrow(index,data) {
					                    msg='<row r="'+index+'">'
					                    for(i=0;i<data.length;i++){
					                        var key=data[i].key;
					                        var value=data[i].value;
					                        msg += '<c t="inlineStr" r="' + key + index + '">';
					                        msg += '<is>';
					                        msg +=  '<t>'+value+'</t>';
					                        msg+=  '</is>';
					                        msg+='</c>';
					                    }
					                    msg += '</row>';
					                    return msg;
					                }


					                //insertFileDate
					                var r1 = Addrow(1, [{ key: 'A', value: 'Claim Report by '+ViewType+'' }]);
					                var r2 = Addrow(2, [{ key: 'A', value: 'Last Update : ' + getEditFormattedDate(new Date()) }]);

					                sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + sheet.childNodes[0].childNodes[1].innerHTML;
					            }
					        } ]
						});
					}	
					$('#divLoading').hide();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#divLoading').hide();
					$('#tableClaimReport').show();
					showModal('Whoops! Something wrong', 0);
					console.log(xhr.status);
					console.log(xhr.responseText);
					console.log(thrownError);
				}
			});
		}
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
});