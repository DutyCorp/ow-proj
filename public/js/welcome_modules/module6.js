$(document).ready(function() {
	$('#tableMilestone').DataTable({
		"scrollY": "340px",
        "scrollCollapse": true,
        "paging": false,
        "bInfo": false,
        "bFilter": false,
        "bSort": false,
        "columnDefs": [     
			{ "width": "42,5%", "targets": 0 },
			{ "width": "15%", "targets": 1 },
			{ "width": "42,5%", "targets": 2 }
		]
	});
});