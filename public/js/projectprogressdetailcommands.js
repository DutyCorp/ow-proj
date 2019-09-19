$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('#divLoading, #divLegend').hide();
	$('#tableSalesContract').hide();

	function GetDateClosure(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		return year + month;
	}

	function getEditFormattedMonth(date) {
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		return month;
	}

	function getEditFormattedYear(date) {
		var year = date.getFullYear();
		return year;
	}
	
	$('#buttonSubmitProjectProgress').click(function(){
		
		var DateFrom = $('#DateFrom').val();
		var DateTo = $('#DateTo').val();
		if(DateFrom != "" && DateTo == "")
		{
			showModal("Date to must be chosen",0);
		}else if(DateFrom != "" && DateTo != ""){
			var MonthFrom = getEditFormattedMonth(new Date($('#DateFrom').val()));
			var MonthTo = getEditFormattedMonth(new Date($('#DateTo').val()));
			var YearFrom = getEditFormattedYear(new Date($('#DateFrom').val()));
			var YearTo = getEditFormattedYear(new Date($('#DateTo').val()));
			if(MonthTo < MonthFrom || YearTo < YearFrom)
			{
				alert("Date to must be greater Date From");
				return false;
			}
		}
		if(DateFrom != ""){
			DateFrom = GetDateClosure(new Date($('#DateFrom').val()));
		}
		if(DateTo != ""){
			DateTo = GetDateClosure(new Date($('#DateTo').val()));
		}
		$('#divLoading').show();
		$('#tableProjectProgress').hide();
		var View = 'det';
		var FilterProjectProgressData = {
			ViewTable		: View,
			ProjectRegion	: $('#selectProjectRegion').val(),
			PositionType	: $('#selectPositionType').val(),
			ProjectStatus 	: $('#selectProjectStatus').val(),
			From			: DateFrom,
			To 				: DateTo,
	    	ContractStatus 	: $('#selectContractStatus').val(),
		}

		$.ajax({
			type 		: 'POST',
			url 		: '/FilterProjectProgress',
			data 		: FilterProjectProgressData,
			dataType 	: 'json',
			success:function(data){
				$('#tableProjectProgress').html(data);
				$('#divLoading').hide();
				$('#divLegend').show();
				$('#tableProjectProgress').show();
				$('#projectProgressTable').DataTable({
					dom: 'Bfrtip',
					lengthMenu: [
			            [ 10, 25, 50, -1 ],
			            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
			        ],
					
					buttons: [{extend:'pageLength',text: '<span>Show Page</span>'},	 {
			            extend 	: 'excelHtml5',
			            title 	: 'Project Progress ' + getEditFormattedDate(new Date()),
			            text 	: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
			            customize: function (xlsx) {
			                var sheet 	= xlsx.xl.worksheets['sheet1.xml'];
			                var numrows = 8;
			                var clR 	= $('row', sheet);

			                //update Row
			                clR.each(function () {
			                    var attr 	= $(this).attr('r');
			                    var ind 	= parseInt(attr);
			                    ind 		= ind + numrows;
			                    $(this).attr("r",ind);
			                });

			                // Create row before data
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
			                        msg		+='</c>';
			                    }
			                    msg += '</row>';
			                    return msg;
			                }
			                
			                var r1 = Addrow(1, [{ key: 'A', value: 'Project Progress' }]);
			                var r2 = Addrow(2, [{ key: 'A', value: 'As of ' + getEditFormattedDate(new Date())}]);
			                var r3 = Addrow(3, [{ key: 'A', value: ''}]);
			                var r4 = Addrow(4, [{ key: 'A', value: 'Project Region : ' + $('#selectProjectRegion').val() }]);
			                var r5 = Addrow(5, [{ key: 'A', value: 'Position Type : ' + $('#selectPositionType').val() }]);
			                var r6 = Addrow(6, [{ key: 'A', value: 'Project Status : ' + $('#selectProjectStatus').val() }]);
			                var r7 = Addrow(7, [{ key: 'A', value: 'Contract Status : ' + $('#selectContractStatus').val() }]);

			                sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + r4 + r5 + r6 + r7 + sheet.childNodes[0].childNodes[1].innerHTML;
			            }
			        } ]
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#divLoading').hide();
				$('#tableProjectProgress').show();
				$('#divLegend').show();
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return  day + '-' + month + '-' + year;
	}
	
	function refreshTableProjectProgress() {
		$('#divLoading').show();
		$('#tableProjectProgress').hide();
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableProjectProgressDetail',
			dataType 	: 'json',
			success:function(data){
				$('#divLoading').hide();
				$('#tableProjectProgress').html(data);
				$('#tableProjectProgress').show();
				$('#projectProgressTable').DataTable({
					dom: 'Bfrtip',
					buttons: [ {
			            extend 	: 'excelHtml5',
			            title 	: 'Project Progress ' + getEditFormattedDate(new Date()),
			            text 	: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
			            customize: function (xlsx) {
			                var sheet 	= xlsx.xl.worksheets['sheet1.xml'];
			                var numrows = 8;
			                var clR 	= $('row', sheet);

			                //update Row
			                clR.each(function () {
			                    var attr 	= $(this).attr('r');
			                    var ind 	= parseInt(attr);
			                    ind 		= ind + numrows;
			                    $(this).attr("r",ind);
			                });

			                // Create row before data
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
			                        msg		+='</c>';
			                    }
			                    msg += '</row>';
			                    return msg;
			                }
			                
			                var r1 = Addrow(1, [{ key: 'A', value: 'Project Progress' }]);
			                var r2 = Addrow(2, [{ key: 'A', value: 'As of ' + getEditFormattedDate(new Date())}]);
			                var r3 = Addrow(3, [{ key: 'A', value: ''}]);
			                var r4 = Addrow(4, [{ key: 'A', value: 'Project Region : All' }]);
			                var r5 = Addrow(5, [{ key: 'A', value: 'Position Type : All' }]);
			                var r6 = Addrow(6, [{ key: 'A', value: 'Project Status : All'}]);
			                var r7 = Addrow(7, [{ key: 'A', value: 'Contract Status : All'}]);

			                sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + r4 + r5 + r6 + r7 + sheet.childNodes[0].childNodes[1].innerHTML;
			            }
			        } ]
				});  
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#divLoading').hide();
				showModal("Whoops Something Wrong", 0);
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
});