$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var currentTime = new Date();
	
	refreshTableEmployee();

	function refreshTableEmployee() {
		$('#divLoading').show();
		$('#EMPTable').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshTableEmployee',
			dataType: 'json',
			success:function(data){
				$('#divLoading').hide();
				$('#EMPTable').html(data);
				$('#employeeListTable').DataTable({
					dom: 'Bfrtip',
					lengthMenu: [
			            [ 10, 25, 50, -1 ],
			            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
			        ],
					
					buttons: [{extend:'pageLength',text: '<span>Show Page</span>'},	 {
			            extend: 'excelHtml5',
			            title: 'Employee List ',
			            text: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
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
			                var r1 = Addrow(1, [{ key: 'A', value: 'OWA Employee List' }]);
			                var r2 = Addrow(2, [{ key: 'A', value: 'Last Update : ' + getEditFormattedDate(currentTime) }]);

			                sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + sheet.childNodes[0].childNodes[1].innerHTML;
			            }
			        } ]
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

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		var day = date.getDate().toString();
		day = day.length > 1 ? day : '0' + day;
		return  day + '-' + month + '-' + year;
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