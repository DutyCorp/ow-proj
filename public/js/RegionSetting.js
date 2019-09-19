$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	

	$('#Sales_L').maskNumber();
	$('#Sales_M').maskNumber();
	$('#Sales_S').maskNumber();
	$('#Revenue_L').maskNumber();
	$('#Revenue_M').maskNumber();
	$('#Revenue_S').maskNumber();
	$('#Pipeline_L').maskNumber();
	$('#Pipeline_M').maskNumber();
	$('#Pipeline_S').maskNumber();

	$('#InfoManagerial').hide();
	$('#InfoProjectLead').hide();
	$('#InfoTarget').hide();
	$('#InfoCheckTarget').hide();
	$('#TargetForm').hide();
	refreshTableGS();
	$('#divProjectLead').hide();
	$('#formGS').hide();
	var TargetStatus;

	function RefreshMDCost(){
		$.ajax({
			type: 'POST',
			url: '/RefreshMDCost',
			dataType: 'json',
			success:function(data){
				console.log(data);
				$('#MDCostValue').val(data[0]['MDCost']);
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
	}

	$('#ValueSettingBTN').click(function(){
		$('#InfoValue').hide();
		$('#MDCostValue').attr("disabled","disabled");
		$('#SubmitMDCostButton').hide();
		RefreshMDCost();
	});

	$('#setMDCostButton').click(function(){
		$('#MDCostValue').removeAttr("disabled");
		$('#SubmitMDCostButton').show();
		$('#setMDCostButton').hide();
	});
	
	$('#SubmitMDCostButton').click(function(){
		var MDCost = $('#MDCostValue').val();
		if(MDCost == ""){
			document.getElementById("InfoValue").style.color = "red";
			document.getElementById("InfoValue").style.fontSize = "14px";
			$('#InfoValue').text("MDCost must be filled");
			$('#InfoValue').show();
			return false;
		}else {
			var ValueData = {
		    	MDCost 	: MDCost
			}
			$.ajax({
				type: 'POST',
				url: '/SetMDCost',
				data: ValueData,
				dataType: 'json',
				success:function(data){
					document.getElementById("InfoValue").style.color = "green";
					document.getElementById("InfoValue").style.fontSize = "14px";
					$('#InfoValue').text("Success Update MDCost");
					$('#InfoValue').show();
					RefreshMDCost();
					$('#MDCostValue').attr("disabled","disabled");
					$('#SubmitMDCostButton').hide();
					$('#setMDCostButton').show();
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

	$('#BackTarget').click(function(){
		$('#TargetForm').hide();
		$('#CheckTarget').show();
		$("#TargetYear").removeAttr("disabled");
		$("#TargetRegion").removeAttr("disabled");
	});

	$('#TargetSettingBTN').click(function(){
		$('#TargetForm').hide();
		$('#InfoCheckTarget').hide();
		$("#TargetYear").val("");
		$("#TargetRegion").val("None");
		$('#CheckTarget').show();
		$("#TargetYear").removeAttr("disabled");
		$("#TargetRegion").removeAttr("disabled");
	});

	$('#SaveTarget').click(function(){
		var Sales_L = $('#Sales_L').val();
		var Sales_M = $('#Sales_M').val();
		var Sales_S = $('#Sales_S').val();
		var Pipeline_L = $('#Pipeline_L').val();
		var Pipeline_M = $('#Pipeline_M').val();
		var Pipeline_S = $('#Pipeline_S').val();
		var Revenue_L = $('#Revenue_L').val();
		var Revenue_M = $('#Revenue_M').val();
		var Revenue_S = $('#Revenue_S').val();
		var Occupation_C = $('#Occupation_C').val();
		var Occupation_U = $('#Occupation_U').val();
		if(Sales_M == "" || Sales_M < 0){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Sales Maintenance must be filled and can't be zero");
			$('#InfoTarget').show();
			return false;
		} else if(Sales_S == "" || Sales_S < 0){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Sales Service must be filled and can't be zero");
			$('#InfoTarget').show();
			return false;
		} else if(Sales_L == "" || Sales_L < 0){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Sales License must be filled and can't be zero");
			$('#InfoTarget').show();
			return false;
		} else if(Revenue_M == "" || Revenue_M < 0){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Revenue Maintenance must be filled and can't be zero");
			$('#InfoTarget').show();
			return false;
		} else if(Revenue_S == "" || Revenue_S < 0){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Revenue Service must be filled and can't be zero");
			$('#InfoTarget').show();
			return false;
		} else if(Revenue_L == "" || Revenue_L < 0){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Revenue License must be filled and can't be zero");
			$('#InfoTarget').show();
			return false;
		} else if(Occupation_C == ""  || Occupation_C < 0){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Occupation Chargeability must be filled and can't be zero");
			$('#InfoTarget').show();
			return false;
		} else if(Occupation_C > 100){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Occupation Chargeability cant be greater than 100");
			$('#InfoTarget').show();
			return false;
		} else if(Occupation_U == "" || Occupation_U < 0){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Occupation Utilization must be filled and can't be zero");
			$('#InfoTarget').show();
			return false;
		} else if(Occupation_U > 100){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Occupation Utilization cant be greater than 100");
			$('#InfoTarget').show();
			return false;
		} else if(Pipeline_M == "" || Pipeline_M < 0){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Pipeline Maintenance must be filled and can't be zero");
			$('#InfoTarget').show();
			return false;
		} else if(Pipeline_S == "" || Pipeline_S < 0){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Pipeline Service must be filled and can't be zero");
			$('#InfoTarget').show();
			return false;
		} else if(Pipeline_L == "" || Pipeline_L < 0){
			document.getElementById("InfoTarget").style.color = "red";
			document.getElementById("InfoTarget").style.fontSize = "14px";
			$('#InfoTarget').text("Pipeline Licenses must be filled and can't be zero");
			$('#InfoTarget').show();
			return false;
		} else {
			var TargetData = {
		    	Year 			: $('#TargetYear').val(),
		    	Region 			: $('#TargetRegion').val(),
		    	Sales_L 		: Sales_L,
				Sales_M 		: Sales_M,
				Sales_S 		: Sales_S,
				Revenue_L 		: Revenue_L,
				Revenue_M 		: Revenue_M,
				Revenue_S 		: Revenue_S,
				Occupation_C 	: Occupation_C,
				Occupation_U 	: Occupation_U,
				TargetStatus	: TargetStatus,
				Pipeline_L 		: Pipeline_L,
				Pipeline_M 		: Pipeline_M,
				Pipeline_S 		: Pipeline_S,
			}
			$.ajax({
				type: 'POST',
				url: '/SaveTarget',
				data: TargetData,
				dataType: 'json',
				success:function(data){
					document.getElementById("InfoTarget").style.color = "green";
					document.getElementById("InfoTarget").style.fontSize = "14px";
					$('#InfoTarget').text(data);
					$('#InfoTarget').show();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#TargetSetting').modal('hide');
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	           		console.log(thrownError);
	       		}
			});
		}
	});

	function addCommas(nStr) {
	    nStr += '';
	    var x = nStr.split('.');
	    var x1 = x[0];
	    var x2 = x.length > 1 ? '.' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + ',' + '$2');
	    }
	    return x1 + x2;
	}

	$('#CheckTarget').click(function(){
		$('#InfoTarget').hide();
		var Year = $("#TargetYear").val();
		var Region = $("#TargetRegion").val();
		if(Year == ""){
			document.getElementById("InfoCheckTarget").style.color = "red";
			document.getElementById("InfoCheckTarget").style.fontSize = "14px";
			$('#InfoCheckTarget').text("Year must be filled");
			$('#InfoCheckTarget').show();
			return false;
		} else if(Year.length < 4 || Year[0] != "2"){
			document.getElementById("InfoCheckTarget").style.color = "red";
			document.getElementById("InfoCheckTarget").style.fontSize = "14px";
			$('#InfoCheckTarget').text("Wrong Year Format");
			$('#InfoCheckTarget').show();
			return false;
		}else if(Region == "None"){
			document.getElementById("InfoCheckTarget").style.color = "red";
			document.getElementById("InfoCheckTarget").style.fontSize = "14px";
			$('#InfoCheckTarget').text("Region must be filled");
			$('#InfoCheckTarget').show();
			return false;
		}else{
			var TargetData = {
		    	Year 		: Year,
		    	Region 		: Region
			}
			$.ajax({
				type: 'POST',
				url: '/CheckTargetData',
				data: TargetData,
				dataType: 'json',
				success:function(data){
					$('#InfoCheckTarget').hide();
					$('#CheckTarget').hide();
					$("#TargetYear").attr("disabled","disabled");
					$("#TargetRegion").attr("disabled","disabled");
					if(data == ""){
						TargetStatus = "Entry";
						$('#TargetForm').show();
						$('#Sales_L').val("0");
						$('#Sales_M').val("0");
						$('#Sales_S').val("0");
						$('#Revenue_L').val("0");
						$('#Revenue_M').val("0");
						$('#Revenue_S').val("0");
						$('#Occupation_C').val("0");
						$('#Occupation_U').val("0");
						$('#Pipeline_L').val("0");
						$('#Pipeline_M').val("0");
						$('#Pipeline_S').val("0");
					} else {
						$('#TargetForm').show();
						TargetStatus = "Update";
						$('#Sales_L').val(addCommas(data[0].SalesLicenses));
						$('#Sales_M').val(addCommas(data[0].SalesMaintenance));
						$('#Sales_S').val(addCommas(data[0].SalesService));
						$('#Revenue_L').val(addCommas(data[0].RevenueLicenses));
						$('#Revenue_M').val(addCommas(data[0].RevenueMaintenance));
						$('#Revenue_S').val(addCommas(data[0].RevenueService));
						$('#Occupation_C').val(data[0].OccupationChargeability);
						$('#Occupation_U').val(data[0].OccupationUtilization);
						$('#Pipeline_L').val(addCommas(data[0].PipelineLicenses));
						$('#Pipeline_M').val(addCommas(data[0].PipelineMaintenance));
						$('#Pipeline_S').val(addCommas(data[0].PipelineService));
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#ManagerialSetting').modal('hide');
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	           		console.log(thrownError);
	       		}
			});
		}
	});

	$('#addProjectLead').click(function(){
		if($('#SelectProjectLead').val() == "None"){
			document.getElementById("InfoProjectLead").style.color = "red";
			$('#InfoProjectLead').text("Project Lead must be chosen");
			$('#InfoProjectLead').show();
		} else {
			var CheckData = {
		    	PL_ID 	: $('#SelectProjectLead').val()
			}
			$.ajax({
				type: 'POST',
				url: '/CheckProjectLead',
				data: CheckData,
				dataType: 'json',
				success:function(data){
					if(data == 0){
						var ProjectLeadData = {
					    	PL_ID 	: $('#SelectProjectLead').val(),
					    	RegionID 	: $('#RegionProjectLead').val(),
						}
						$.ajax({
							type: 'POST',
							url: '/AddProjectLead',
							data: ProjectLeadData,
							dataType: 'json',
							success:function(data){
								document.getElementById("InfoProjectLead").style.color = "green";
								$('#InfoProjectLead').text("Success Add Project Lead");
								$('#InfoProjectLead').show();
								refreshTableProjectLead();
							},
							error: function (xhr, ajaxOptions, thrownError) {
								$('#ProjectLeadSetting').modal('hide');
				          		showModal("Whoops! Something wrong", 0);
				          		console.log(xhr.status);
				          		console.log(xhr.responseText);
				           		console.log(thrownError);
				       		}
						});
					}else{
						document.getElementById("InfoProjectLead").style.color = "red";
						$('#InfoProjectLead').text("Project Lead already exist");
						$('#InfoProjectLead').show();
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

	function refreshTableProjectLead(){
		var RegionData = {
	    	RegionID 	: $('#RegionProjectLead').val()
		}
		$.ajax({
			type: 'POST',
			url: '/GetProjectLeadList',
			data: RegionData,
			dataType: 'json',
			success:function(data){
				$('#ProjectLeadTable').html(data);
				$('#TableRegionProjectLead').DataTable({
					"columnDefs": [    
						{ "width": "10%", "targets": 0 },
						{ "width": "80%", "targets": 1 },
						{ "width": "10%", "targets": 2 },
					],
					"bPaginate": false,
					"info":     false,
					"bFilter": false,
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

	$('#RegionProjectLead').change(function(){
		if($(this).val() != "None"){
			$('#divRegion').hide();	
			$('#divProjectLead').show();
			refreshTableProjectLead();
			$('#ProjectLeadTable').show();

			var RegionData = {
		    	RegionID 	: $('#RegionProjectLead').val(),
			}
			$.ajax({
				type: 'POST',
				url: '/GetListProjectLeadByRegion',
				data: RegionData,
				dataType: 'json',
				success:function(data){
					$('#SelectProjectLead').html("");
					$('#SelectProjectLead').append('<option value="None">Select</option>');
					var j = data.length;
					for (var i = 0; i < j; i++){
						$('#SelectProjectLead').append('<option value="'+data[i]['EmployeeID']+'">'+data[i]['EmployeeName']+'</option>');
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

	$('#backProjectLead').click(function(){
		$('#RegionProjectLead').val("None");
		$('#divRegion').show();
		$('#divProjectLead').hide();
		$('#ProjectLeadTable').hide();
	});

	function cancel(){
		$('#selectRegion').val("None");
		$('#selectGRM1').val("None");
		$('#selectGRM2').val("None");
		$('#selectPMO').val("None");
		$('#formGS').hide();
	}

	$('#buttonCancel').click(function(){
		cancel();
	});

	$('#buttonSubmit').click(function(){
		var RegionID = $('#selectRegion').val();
		var GRM1 = $('#selectGRM1').val();
		var GRM2  = $('#selectGRM2').val();
		var PMO = $('#selectPMO').val();
		if(GRM1 == "None")
		{
			showModal("Group Manager 1 must be chosen",0);
			return false;
		}
		else if(GRM2 == GRM1)
		{
			showModal("Group Manager 2 cant be same with Group Manager 1", 0);
			$('#selectGRM2').val("None")
			return false;
		}
		else if(PMO == "None")
		{
			showModal("Project Management Officer must be chosen", 0);
			return false;
		}
		else
		{
			var RegionData = {
		    	RegionID 	: RegionID,
		    	GRM1 		: GRM1,
		    	GRM2 		: GRM2,
		    	PMO 		: PMO
			}
			$.ajax({
				type: 'POST',
				url: '/UpdateRegion',
				data: RegionData,
				dataType: 'json',
				success:function(data){
					document.getElementById("InfoManagerial").style.color = "green";
					$('#InfoManagerial').text("Success Update");
					$('#InfoManagerial').show();
					refreshTableGS();
					cancel();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#ManagerialSetting').modal('hide');
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	           		console.log(thrownError);
	       		}
			});
		}
	});

	function refreshTableGS(){
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableGS',
			dataType 	: 'json',
			success:function(data){
				$('#tableGS').html(data);
				$('#GSTable').DataTable({
					"bPaginate": false,
					"info":     false,
					"bFilter": false,
					"columnDefs": [    
						{ "width": "23%", "targets": 0 },
						{ "width": "23%", "targets": 1 },
						{ "width": "23%", "targets": 2 },
						{ "width": "23%", "targets": 3 },
						{ "width": "8%", "targets": 4 }
					]
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops Something Wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	$('#btnOKManagerial').click(function() {
		$('#InfoManagerial').text("");
		$('#ManagerialSetting').modal('hide');
	});

	$('#btnOKValue').click(function() {
		$('#ValueSetting').modal('hide');
	});

	$('#btnOKTarget').click(function() {
		//$('#InfoManagerial').text("");
		$('#TargetSetting').modal('hide');
	});

	$('#btnOKProjectLead').click(function() {
		$('#InfoProjectLead').text("");
		$('#ProjectLeadSetting').modal('hide');
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