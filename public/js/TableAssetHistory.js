$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('#AssetHistoryTable tfoot th').each( function (i) {
        var title = $('#AssetHistoryTable thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" data-index="'+i+'" />' );
    } );

	var table = $('#AssetHistoryTable').DataTable( {        
		"columnDefs": [    
			{ "width": "5%", "targets": 5 },
			{ "width": "15%", "targets": 10 },
			{ "width": "15%", "targets": 1 },
			{ "width": "11%", "targets": 2 },
			{ "width": "3%", "targets": 3 },
			{ "width": "6%", "targets": 11 }
		] ,
		lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
						       
		scrollY 		: "500px",
        scrollX 		: true,
        scrollCollapse 	: true,
        paging 	 		: true,
        fixedColumns 	: true,
		dom: 'Bfrtip',
		buttons: [  {extend:'pageLength',text: '<span>Show Page</span>'},  {
	            extend 		: 'excelHtml5',
	            text 		: '<i class="fa fa-download" aria-hidden="true" style="color:white"></i>'
        	} 
        ]
		
	});

	$( table.table().container() ).on( 'keyup', 'tfoot input', function () {
        table
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );

});