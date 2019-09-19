$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('#profitabillityTable').DataTable();
	$('#Legend, #divLoading').hide();

	$('#buttonSubmitFilterProfitabillity').click(function(){
		var PageType = $('#PageType').val();
		var RegionID = $('#profitabillityRegion').val();
		var ContractStatus = $('#profitabillityContractStatus').val();
		var PositionType = $('#profitabillityPositionType').val();
		$('#tableProfitabillity').hide();
		$('#divLoading').show();
		var FilterProfitabillityData = {
			RegionID		: RegionID,
			ContractStatus	: ContractStatus,
			PageType		: PageType,
			PositionType 	: PositionType
		};
		$.ajax({
			type: 'POST',
			url: '/FilterTableProfitabillity',
			data: FilterProfitabillityData,
			dataType: 'json',
			success:function(data){
				$('#Legend').show();
				var ProfitabillityDateInsert = data['DateInsertProfitabillity'][0].Tr_Date_I;
				$('#tableProfitabillity').html(data['returnHTML']);
				$('#divLoading').hide();
				$('#tableProfitabillity').show();
				$('#profitabillityTable').DataTable({
					dom: 'Bfrtip',
					scrollY 		: "500px",
			        scrollX 		: true,
			        scrollCollapse 	: true,
			        paging 	 		: true,
			        fixedColumns 	: true,
					lengthMenu: [
			            [ 10, 25, 50, -1 ],
			            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
			        ],
					
					buttons: [{extend:'pageLength',text: '<span>Show Page</span>'},	 {
			            extend 	: 'excelHtml5',
			            title 	: 'Project Profitabillity ' + PageType,
			            text 	: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>',
			            customize: function (xlsx) {
			                var sheet 	= xlsx.xl.worksheets['sheet1.xml'];
			                var numrows = 5;
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
			                var r1 = Addrow(1, [{ key: 'A', value: 'Project Profitabillity ' + PageType }]);
			                var r2 = Addrow(2, [{ key: 'A', value: 'Last Update '+ ProfitabillityDateInsert }]);
			                var r3 = Addrow(3, [{ key: 'A', value: 'Red = MDSpent >= 100%' }, { key: 'C', value: 'Yellow = MDSpent >= 75%' }]);
			                var r4 = Addrow(4, [{ key: 'A', value: '*TravelCost is part of MD Cost' }]);
			                var r5 = Addrow(5, [{ key: 'H', value: 'Project Expense' } , { key: 'L', value: '% Project Expense and Against Budget' } , { key: 'P', value: 'Mandays' }]);
			                sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + r4 + r5 + sheet.childNodes[0].childNodes[1].innerHTML;
			            }
			        } ]

				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#divLoading').hide();
				$('#tableProfitabillity').show();
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});

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