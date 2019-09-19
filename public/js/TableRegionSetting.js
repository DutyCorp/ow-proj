$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#tableGS tbody').on('click', '.ChooseEdit', function (e) {
        var RegionID = $(this).val();
		$('#formGS').show();
		$('#selectRegion').attr("disabled","disabled");
		var RegionData = {
	    	RegionID : RegionID
		}
		$.ajax({
			type: 'POST',
			url: '/EditRegion',
			data: RegionData,
			dataType: 'json',
			success:function(data){
				$('#selectRegion').val(data[0].RegionID);
				if(data[0].GRM_1 == null){
					$('#selectGRM1').val("None");
				}else{
					$('#selectGRM1').val(data[0].GRM_1);
				}
				if(data[0].GRM_2 == null){
					$('#selectGRM2').val("None");
				}else{
					$('#selectGRM2').val(data[0].GRM_2);
				}
				if(data[0].GRM_2 == null){
					$('#selectPMO').val("None");
				}else{
					$('#selectPMO').val(data[0].PMO);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		alert("Whoops! Something wrong");
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
    });

});