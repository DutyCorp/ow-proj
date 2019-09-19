$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('#InfoNE_Form').hide();
	$('#InfoWD_Form').hide();
	$('#InfoPP_Form').hide();
	var WD_status;
	$('#Update_NE_Form').hide();
	$('#Cancel_NE_Form').hide();
	$('#Update_PP_Form').hide();
	$('#Cancel_PP_Form').hide();

	//////NEW EMPLOYEE//////
	
	$('#Cancel_NE_Form').click(function(){
		clearNE();
		$('#Update_NE_Form').hide();
		$('#Cancel_NE_Form').hide();
		$('#Add_NE_Form').show();
		$('#Clear_NE_Form').show();
		$('#NE_Form_Region').removeAttr("disabled");
		$('#NE_Form_ID').removeAttr("disabled");
	});

	$('#Update_NE_Form').click(function(){
		var Region = $('#NE_Form_Region').val();
		var ID = $('#NE_Form_ID').val();
		var Name = $('#NE_Form_Name').val();

		if($('#NE_Form_SWD').val() == "")
			var SWD = $('#NE_Form_SWD').val();
		else{
			var SWD = getEditFormattedDate(new Date($('#NE_Form_SWD').val()));
			var Year = SWD[0]+SWD[1]+SWD[2]+SWD[3];
		}
		
		if(SWD == ""){
			ModalAlert("InfoNE_Form","Start Working Day must be chosen","green");
			return false;
		}else {
			var NewEmployeeData = {
		    	Year 	: Year,
				Region 	: Region,
				ID 		: ID,
				Name 	: Name,
				SWD 	: SWD,
			}
			$.ajax({
				type: 'POST',
				url: '/UpdateNE',
				data: NewEmployeeData,
				dataType: 'json',
				success:function(data){
					ModalAlert("InfoNE_Form",data,"green");
					clearNE();
					refreshListNewEmployee();
					$('#NE_Form_Region').removeAttr("disabled");
					$('#NE_Form_ID').removeAttr("disabled");
					$('#Update_NE_Form').hide();
					$('#Cancel_NE_Form').hide();
					$('#Add_NE_Form').show();
					$('#Clear_NE_Form').show();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#NE_Form_Modal').modal('hide');
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	           		console.log(thrownError);
	       		}
			});
		}
	});

	$('#NE_Form_Region').change(function(){
		var value = $(this).val();
		$('#ExampleNE').text("Ex. " + value + "X01");
	});

	$("#NE_Form_ID").focusout(function(){
		var temp = $("#NE_Form_ID").val();
        $('#NE_Form_Name').val("FTE" + temp[0] + temp[1] + temp[3] + temp[4]);
    });

	$('#Add_NE_Form').click(function(){
		var Region = $('#NE_Form_Region').val();
		var ID = $('#NE_Form_ID').val();
		var Name = $('#NE_Form_Name').val();

		if($('#NE_Form_SWD').val() == "")
			var SWD = $('#NE_Form_SWD').val();
		else{
			var SWD = getEditFormattedDate(new Date($('#NE_Form_SWD').val()));
			var Year = SWD[0]+SWD[1]+SWD[2]+SWD[3];
		}
		if(Region == "None"){
			ModalAlert("InfoNE_Form","Region must be chosen","red");
			return false;
		}else if(ID == ""){
			ModalAlert("InfoNE_Form","Employee ID must be filled","red");
			return false;
		}else if( isNaN(ID[3]) || isNaN(ID[4]) || ID[2] != "X" ){
			ModalAlert("InfoNE_Form","Wrong Employee ID Format","red");
			return false;
		}else if( ID[0] != Region[0] || ID[1] != Region[1] ){
			ModalAlert("InfoNE_Form","Employee ID must contains " + Region,"red");
			return false;
		}else if(Name == ""){
			ModalAlert("InfoNE_Form","Employee Name must be filled","red");
			return false;
		}else if(SWD == ""){
			ModalAlert("InfoNE_Form","Start Working Day must be chosen","red");
			return false;
		}else {
			var CheckData = {
		    	Year 	: Year,
				ID 		: ID
			}
			$.ajax({
				type: 'POST',
				url: '/CheckNewEmployee',
				data: CheckData,
				dataType: 'json',
				success:function(data){
					if(data != ""){
						ModalAlert("InfoNE_Form","Employee ID already exist","red");
						return false;
					}else{
						var NewEmployeeData = {
					    	Year 	: Year,
							Region 	: Region,
							ID 		: ID,
							Name 	: Name,
							SWD 	: SWD,
						}
						$.ajax({
							type: 'POST',
							url: '/InsertNewEmployee',
							data: NewEmployeeData,
							dataType: 'json',
							success:function(data){
								ModalAlert("InfoNE_Form",data,"green");
								clearNE();
								refreshListNewEmployee();
							},
							error: function (xhr, ajaxOptions, thrownError) {
								$('#NE_Form_Modal').modal('hide');
				          		showModal("Whoops! Something wrong", 0);
				          		console.log(xhr.status);
				          		console.log(xhr.responseText);
				           		console.log(thrownError);
				       		}
						});
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#NE_Form_Modal').modal('hide');
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	           		console.log(thrownError);
	       		}
			});
						
		}
	});

	$('#NE_Year').focusout(function(){
		var NewEmployeeData = {
			Region : $('#RA_Region').val(),
			Year   : $('#NE_Year').val(),
		}
		$.ajax({
			type: 'POST',
			url: '/refreshTableNewEmployee',
			data: NewEmployeeData,
			dataType: 'json',
			success:function(data){
				$('#TableNewEmployee').html(data);
				$('#NE_Table').DataTable();
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
	});

	$('#btn_NE').click(function(){
		if($('#RA_Region').val() == "None" || $('#RA_Year').val() == ""){
			$('#alertNEBody').show();
			$('#NEBody').hide();
		}else{
			$('#alertNEBody').hide();
			$('#NEBody').show();
			refreshTableNewEmployee();
			$('#NE_Year').val($('#RA_Year').val());
		}
	});

	$('#Clear_NE_Form').click(function(){
		clearNE();
	});

	$('#btnCloseNEForm').click(function(){
		$('#NE_Form_Modal').modal('hide');
		$('#NE_Modal').modal('show');
		refreshTableNewEmployee();
		clearNE();
		$('#Update_NE_Form').hide();
		$('#Cancel_NE_Form').hide();
		$('#Add_NE_Form').show();
		$('#Clear_NE_Form').show();
		$('#NE_Form_Region').removeAttr("disabled");
		$('#NE_Form_ID').removeAttr("disabled");
	});

	$('#btnCloseNE').click(function(){
		$('#NE_Modal').modal('hide');
	});

	$('#btnAddNE').click(function(){
		$('#NE_Form_Region').val($('#RA_Region').val());
		$('#ExampleNE').text("Ex. " + $('#NE_Form_Region').val() + "X01");
		refreshListNewEmployee();
		$('#NE_Modal').modal('hide');
		$('#InfoNE_Form').hide();
	});

	function refreshListNewEmployee(){
		$.ajax({
			type: 'POST',
			url: '/RefreshNewEmployee',
			dataType: 'json',
			success:function(data){
				$('#TableListNewEmployee').html(data);
				$('#NE_List_Table').DataTable();
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
	}

	function clearNE(){
		$('#NE_Form_Region').val("None");
		$('#NE_Form_ID').val("");
		$('#NE_Form_Name').val("");
		$('#NE_Form_SWD').val("");
		$('#ExampleNE').text("");
	}

	function refreshTableNewEmployee(){
		var NewEmployeeData = {
			Region : $('#RA_Region').val(),
			Year   : $('#RA_Year').val(),
		}
		$.ajax({
			type: 'POST',
			url: '/refreshTableNewEmployee',
			data: NewEmployeeData,
			dataType: 'json',
			success:function(data){
				$('#TableNewEmployee').html(data);
				$('#NE_Table').DataTable();
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
	}

	//////PROSPECT PROJECT//////

	$('#Update_PP_Form').click(function(){
		var Year 		= $('#PP_Form_Year').val();
		var BA 	 		= $('#projectBA').val();
		var Code 		= $('#PP_Form_Code').val();
		var Name 		= $('#PP_Form_Name').val();
		var MDPlan 		= $('#PP_Form_MDPlan').val();
		var Opportunity = $('#PP_Form_Opportunity').val();
		var StartDate 	= $('#PP_Form_StartDate').val();
		if($('#PP_Form_StartDate').val() == "")
			var StartDate = $('#PP_Form_StartDate').val();
		else
			var StartDate = getEditFormattedDate(new Date($('#PP_Form_StartDate').val()));

		if(Name == ""){
			ModalAlert("InfoPP_Form","Project Name must be filled","red");
			return false;
		}else if(MDPlan == ""){
			ModalAlert("InfoPP_Form","MD Plan must be filled","red");
			return false;
		}else if(Opportunity == ""){
			ModalAlert("InfoPP_Form","Opportunity must be filled","red");
			return false;
		}else if(StartDate == ""){
			ModalAlert("InfoPP_Form","Start Date must be chosen","red");
			return false;
		}else{
			var ProspectProjectData = {
		    	Year 		: Year,
		    	BA 			: BA,
				Code 		: Code,
				Name 		: Name,
				MDPlan 		: MDPlan,
				Opportunity	: Opportunity,
				StartDate 	: StartDate,
			}
			$.ajax({
				type: 'POST',
				url: '/UpdatePP',
				data: ProspectProjectData,
				dataType: 'json',
				success:function(data){
					ModalAlert("InfoPP_Form",data,"green");
					clearPP();
					$('#PP_Form_Region').removeAttr("disabled");
					$('#PP_Form_Year').removeAttr("disabled");
					$('#PP_Form_Code').removeAttr("disabled");
					$('#Update_PP_Form').hide();
					$('#Cancel_PP_Form').hide();
					$('#Add_PP_Form').show();
					$('#Clear_PP_Form').show();
					refreshListProspectProject();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#PP_Form_Modal').modal('hide');
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	           		console.log(thrownError);
	       		}
			});					
		}	
	});

	$('#Cancel_PP_Form').click(function(){
		clearPP();
		$('#Update_PP_Form').hide();
		$('#Cancel_PP_Form').hide();
		$('#Add_PP_Form').show();
		$('#Clear_PP_Form').show();
		$('#PP_Form_Region').removeAttr("disabled");
		$('#PP_Form_Code').removeAttr("disabled");
	});

	$('#PP_Form_Region').change(function(){
		var value = $(this).val();
		$('#ExamplePP').text("Ex. P1" + value + "X01");
	});

	$('#Add_PP_Form').click(function(){
		var Region 		= $('#PP_Form_Region').val();
		var BA 	 		= $('#projectBA').val();
		var Year 		= $('#PP_Form_Year').val();
		var Code 		= $('#PP_Form_Code').val();
		var Name 		= $('#PP_Form_Name').val();
		var MDPlan 		= $('#PP_Form_MDPlan').val();
		var Opportunity = $('#PP_Form_Opportunity').val();
		var StartDate 	= $('#PP_Form_StartDate').val();
		if($('#PP_Form_StartDate').val() == "")
			var StartDate = $('#PP_Form_StartDate').val();
		else
			var StartDate = getEditFormattedDate(new Date($('#PP_Form_StartDate').val()));

		if(Year == ""){
			ModalAlert("InfoPP_Form","Year must be chosen","red");
			return false;
		}else if(Region == "None"){
			ModalAlert("InfoPP_Form","Region must be chosen","red");
			return false;
		}else if(Code == ""){
			ModalAlert("InfoPP_Form","Project Code must be filled","red");
			return false;
		}else if(Code[0] != "P" || Code[4] != "X" || isNaN(Code[5]) || isNaN(Code[6]) ){
			ModalAlert("InfoPP_Form","Wrong Project Code Format","red");
			return false;
		}else if(Code[2] != Region[0] || Code[3] != Region[1]){
			ModalAlert("InfoPP_Form","Project Code must be contains " + Region,"red");
			return false;
		}else if(Name == ""){
			ModalAlert("InfoPP_Form","Project Name must be filled","red");
			return false;
		}else if(MDPlan == ""){
			ModalAlert("InfoPP_Form","MD Plan must be filled","red");
			return false;
		}else if(Opportunity == "" || Opportunity == 0 || Opportunity > 100){
			ModalAlert("InfoPP_Form","Opportunity must be filled and can't greater than 100","red");
			return false;
		}else if(StartDate == ""){
			ModalAlert("InfoPP_Form","Start Date must be chosen","red");
			return false;
		}else{
			var CheckData = {
		    	Year 		: Year,
				Code 		: Code,
			}
			$.ajax({
				type: 'POST',
				url: '/CheckProspectProject',
				data: CheckData,
				dataType: 'json',
				success:function(data){
					if(data != ""){
						ModalAlert("InfoPP_Form","Project Code already exist","red");
						return false;
					}else{
						var ProspectProjectData = {
					    	Year 		: Year,
							Region 		: Region,
							BA 			: BA,
							Code 		: Code,
							Name 		: Name,
							MDPlan 		: MDPlan,
							Opportunity	: Opportunity,
							StartDate 	: StartDate,
						}
						$.ajax({
							type: 'POST',
							url: '/InsertProspectProject',
							data: ProspectProjectData,
							dataType: 'json',
							success:function(data){
								refreshListProspectProject();
								ModalAlert("InfoPP_Form",data,"green");
								clearPP();
							},
							error: function (xhr, ajaxOptions, thrownError) {
								$('#PP_Form_Modal').modal('hide');
				          		showModal("Whoops! Something wrong", 0);
				          		console.log(xhr.status);
				          		console.log(xhr.responseText);
				           		console.log(thrownError);
				       		}
						});
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#PP_Form_Modal').modal('hide');
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	           		console.log(thrownError);
	       		}
			});					
		}	
	});

	$("#PP_Form_Opportunity").focusout(function(){
		if( $('#PP_Form_MDPlan').val() != "" && $('#PP_Form_Opportunity').val() != "" )
        	$('#PP_Form_WeightedMD').val( (($('#PP_Form_MDPlan').val()) * ($('#PP_Form_Opportunity').val())) / 100 );
    });

    $("#PP_Form_MDPlan").focusout(function(){
    	if( $('#PP_Form_MDPlan').val() != "" && $('#PP_Form_Opportunity').val() != "" )
        	$('#PP_Form_WeightedMD').val( (($('#PP_Form_MDPlan').val()) * ($('#PP_Form_Opportunity').val())) / 100 );
    });

    $('#PP_Year').focusout(function(){
		var ProspectProjectData = {
			Region : $('#RA_Region').val(),
			Year   : $('#PP_Year').val(),
		}
		$.ajax({
			type: 'POST',
			url: '/refreshTableProspectProject',
			data: ProspectProjectData,
			dataType: 'json',
			success:function(data){
				$('#TableProspectProject').html(data);
				$('#PP_Table').DataTable();
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
	});

	$('#btn_PP').click(function(){
		if($('#RA_Region').val() == "None" || $('#RA_Year').val() == ""){
			$('#PPBody').hide();
			$('#alertPPBody').show();
		}else{
			$('#alertPPBody').hide();
			$('#PPBody').show();
			if($('#RA_Year').val() != "")
				$('#PP_Year').val($('#RA_Year').val());
			else
				$('#PP_Year').val("");
			refreshTableProspectProject();
			$('#PP_Form_Region').val($('#RA_Region').val());
			$('#PP_Form_Year').val($('#RA_Year').val());
		}	
	});

	$('#Clear_PP_Form').click(function(){
		clearPP();
	});

	$('#btnAddPP').click(function(){
		$('#PP_Form_Year').val($('#RA_Year').val());
		$('#PP_Form_Region').val($('#RA_Region').val());
		$('#PP_Modal').modal('hide');
		$('#ExamplePP').text("Ex. P1" + $('#PP_Form_Region').val() + "X01");
		refreshListProspectProject();
		refreshDropdownBA();
		$('#InfoPP_Form').hide();
	});

	$('#btnClosePP').click(function() {
		$('#PP_Modal').modal('hide');
	});

	$('#btnClosePPForm').click(function() {
		$('#PP_Form_Modal').modal('hide');
		$('#PP_Modal').modal('show');
		clearPP();
		$('#Update_PP_Form').hide();
		$('#Cancel_PP_Form').hide();
		$('#Add_PP_Form').show();
		$('#Clear_PP_Form').show();
		$('#PP_Form_Region').removeAttr("disabled");
		$('#PP_Form_Code').removeAttr("disabled");
		refreshTableProspectProject();
	});
	
	function refreshListProspectProject(){
		$.ajax({
			type: 'POST',
			url: '/RefreshProspectProject',
			dataType: 'json',
			success:function(data){
				$('#prospectprojectTable').html(data);
				$('#PP_List_Table').DataTable();
			},
			error: function (xhr, ajaxOptions, thrownError) {
          		showModal("Whoops! Something wrong", 0);
          		console.log(xhr.status);
          		console.log(xhr.responseText);
           		console.log(thrownError);
       		}
		});
	}

	function clearPP(){
		$('#PP_Form_Region').val("None");
		$('#PP_Form_Year').val("");
		$('#PP_Form_Code').val("");
		$('#PP_Form_Name').val("");
		$('#PP_Form_MDPlan').val("");
		$('#PP_Form_Opportunity').val("");
		$('#PP_Form_StartDate').val("");
		$('#PP_Form_WeightedMD').val("");
		$('#ExamplePP').text("");
	}

	function refreshTableProspectProject(){
		var ProspectProjectData = {
			Region : $('#RA_Region').val(),
			Year   : $('#RA_Year').val(),
		}
		$.ajax({
			type: 'POST',
			url: '/refreshTableProspectProject',
			data: ProspectProjectData,
			dataType: 'json',
			success:function(data){
				$('#TableProspectProject').html(data);
				$('#PP_Table').DataTable({
					"order": [[8, 'desc']]
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

	//////WORKING DAY//////

	$('#Save_WD').click(function(){
		var M1 = $('#Month_1').val();
		var M2 = $('#Month_2').val();
		var M3 = $('#Month_3').val();
		var M4 = $('#Month_4').val();
		var M5 = $('#Month_5').val();
		var M6 = $('#Month_6').val();
		var M7 = $('#Month_7').val();
		var M8 = $('#Month_8').val();
		var M9 = $('#Month_9').val();
		var M10 = $('#Month_10').val();
		var M11 = $('#Month_11').val();
		var M12 = $('#Month_12').val();

		if(M1 == "" || M1 == 0 || M1 > 25){
			ModalAlert("InfoWD_Form","January must be filled and can't be zero and greater than 25","red");
			return false;
		}else if(M2 == "" || M2 == 0 || M2 > 25){
			ModalAlert("InfoWD_Form","February must be filled and can't be zero and greater than 25","red");
			return false;
		}else if(M3 == "" || M3 == 0 || M3 > 25){
			ModalAlert("InfoWD_Form","March must be filled and can't be zero and greater than 25","red");
			return false;
		}else if(M4 == "" || M4 == 0 || M4 > 25){
			ModalAlert("InfoWD_Form","April must be filled and can't be zero and greater than 25","red");
			return false;
		}else if(M5 == "" || M5 == 0 || M5 > 25){
			ModalAlert("InfoWD_Form","May must be filled and can't be zero and greater than 25","red");
			return false;
		}else if(M6 == "" || M6 == 0 || M6 > 25){
			ModalAlert("InfoWD_Form","June must be filled and can't be zero and greater than 25","red");
			return false;
		}else if(M7 == "" || M7 == 0 || M7 > 25){
			ModalAlert("InfoWD_Form","July must be filled and can't be zero and greater than 25","red");
			return false;
		}else if(M8 == "" || M8 == 0 || M8 > 25){
			ModalAlert("InfoWD_Form","August must be filled and can't be zero and greater than 25","red");
			return false;
		}else if(M9 == "" || M9 == 0 || M9 > 25){
			ModalAlert("InfoWD_Form","September must be filled and can't be zero and greater than 25","red");
			return false;
		}else if(M10 == "" || M10 == 0 || M10 > 25){
			ModalAlert("InfoWD_Form","October must be filled and can't be zero and greater than 25","red");
			return false;
		}else if(M11 == "" || M11 == 0 || M11 > 25){
			ModalAlert("InfoWD_Form","November must be filled and can't be zero and greater than 25","red");
			return false;
		}else if(M12 == "" || M12 == 0 || M12 > 25){
			ModalAlert("InfoWD_Form","December must be filled and can't be zero and greater than 25","red");
			return false;
		}else{
			var WorkingDayData = {
				Year 		: $('#RA_Year').val(),
				Region 		: $('#RA_Region').val(),
				WD_status 	: WD_status,
		    	M1 			: M1,
		    	M2 			: M2,
		    	M3 			: M3,
		    	M4 			: M4,
		    	M5 			: M5,
		    	M6 			: M6,
		    	M7 			: M7,
		    	M8 			: M8,
		    	M9 			: M9,
		    	M10 		: M10,
		    	M11 		: M11,
		    	M12 		: M12,
			}
			$.ajax({
				type: 'POST',
				url: '/SaveWorkingDay',
				data: WorkingDayData,
				dataType: 'json',
				success:function(data){
					ModalAlert("InfoWD_Form",data,"green");
					clearWD();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#WD_Modal').modal('hide');
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	           		console.log(thrownError);
	       		}
			});
		}
	});

	$('#btn_WD').click(function(){
		if($('#RA_Region').val() == "None" || $('#RA_Year').val() == ""){
			$('#alertWDBody').show();
			$('#WDBody').hide();
			$('#InfoWD_Form').hide();
		}else{
			$('#alertWDBody').hide();
			$('#WDBody').show();
			$('#InfoWD_Form').hide();
			var WorkingDayData = {
				Year 	: $('#RA_Year').val(),
				Region 	: $('#RA_Region').val(),
			}
			$.ajax({
				type: 'POST',
				url: '/CheckWorkingDay',
				data: WorkingDayData,
				dataType: 'json',
				success:function(data){
					if(data == ""){
						WD_status = "Entry";
						$('#Month_1').val(0);
						$('#Month_2').val(0);
						$('#Month_3').val(0);
						$('#Month_4').val(0);
						$('#Month_5').val(0);
						$('#Month_6').val(0);
						$('#Month_7').val(0);
						$('#Month_8').val(0);
						$('#Month_9').val(0);
						$('#Month_10').val(0);
						$('#Month_11').val(0);
						$('#Month_12').val(0);
					}else{
						WD_status = "Update";
						$('#Month_1').val(data[0].January);
						$('#Month_2').val(data[0].February);
						$('#Month_3').val(data[0].May);
						$('#Month_4').val(data[0].April);
						$('#Month_5').val(data[0].May);
						$('#Month_6').val(data[0].June);
						$('#Month_7').val(data[0].July);
						$('#Month_8').val(data[0].August);
						$('#Month_9').val(data[0].September);
						$('#Month_10').val(data[0].October);
						$('#Month_11').val(data[0].November);
						$('#Month_12').val(data[0].December);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#WD_Modal').modal('hide');
	          		showModal("Whoops! Something wrong", 0);
	          		console.log(xhr.status);
	          		console.log(xhr.responseText);
	           		console.log(thrownError);
	       		}
			});
		}	
	});

	$('#Clear_WD').click(function(){
		clearWD();
	});

	function clearWD(){
		$('#Month_1').val("");
		$('#Month_2').val("");
		$('#Month_3').val("");
		$('#Month_4').val("");
		$('#Month_5').val("");
		$('#Month_6').val("");
		$('#Month_7').val("");
		$('#Month_8').val("");
		$('#Month_9').val("");
		$('#Month_10').val("");
		$('#Month_11').val("");
		$('#Month_12').val("");
	}

	$('#btnCloseWD').click(function() {
		$('#WD_Modal').modal('hide');
	});

	/////REGION/////

	$('#addRegion').click(function() {
		ClearRegion();
		$('#PP_Form_Modal').modal('hide');
	});

	$('#addNewRegion').click(function() {
		ClearRegion();
		$('#PP_Form_Modal').modal('hide');
	});

	$('#buttonSubmitRegion').click(function() {
		var EntryRegionID = $('#RegionID').val();
		var EntryRegionName = $('#RegionName').val();
		var EntryRegionPhone = $('#RegionPhone').val();
		var EntryRegionAddress = $('#RegionAddress').val();
		var EntryRegionFax = $('#RegionFax').val();
	    if (EntryRegionID == ""){
	        ModalAlert("RegionInfo","Region ID must be filled","red");
	        return false;
	    }
	    else if (EntryRegionName == ""){
	        ModalAlert("RegionInfo","Region Name must be filled","red");
	        return false;
	    }
	    else{	
	    	var CheckRegionData = {
	    		RegionID 		: EntryRegionID,
	    	}
	    	$.ajax({
				type: 'POST',
				url: '/CheckRegionID',
				data: CheckRegionData,
				dataType: 'json',
				success:function(data){
					if(data != "")
					{
						ModalAlert("RegionInfo","Region ID already exist","red");
				        return false;
					}
					else
					{
						var EntryRegionData = {
				    		RegionID 		: EntryRegionID,
				    		RegionName 		: EntryRegionName,
				    		RegionPhone 	: EntryRegionPhone,
				    		RegionAddress 	: EntryRegionAddress,
				    		RegionFax 		: EntryRegionFax
						}
				    	$.ajax({
							type: 'POST',
							url: '/EntryRegion',
							data: EntryRegionData,
							dataType: 'json',
							success:function(data){
								ClearRegion();
								ModalAlert("RegionInfo","Success Entry Region","green");
							},
							error: function (xhr, ajaxOptions, thrownError) {
			           			showModal("Whoops! Something wrong", 0);
			           			console.log(xhr.status);
			           			console.log(xhr.responseText);
			           			console.log(thrownError);
			       			}
						});
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

	$('#closeRegionButton').click(function() {
		refreshDropdownRegion();
	});

	$('#RegionModal').on('hidden.bs.modal', function (e) {
        refreshDropdownRegion();
    });

	$('#buttonUpdateRegion').click(function() {
		var UpdateRegionName 	= $('#RegionName').val();
		var UpdateRegionPhone 	= $('#RegionPhone').val();
		var UpdateRegionAddress = $('#RegionAddress').val();
		var UpdateRegionFax 	= $('#RegionFax').val();
	    if (UpdateRegionName == "") {
	    	ModalAlert("RegionInfo","Region Name must be filled","red");
	        return false;
	    } else {
	    	var UpdateRegionData = {
		    	RegionID 		: $('#RegionID').val(),
		    	RegionName  	: UpdateRegionName,
		    	RegionAddress 	: UpdateRegionAddress,
		    	RegionPhone 	: UpdateRegionPhone,
		    	RegionFax 		: UpdateRegionFax
		    }
		    $.ajax({
		    	type 		: 'POST',
		    	url 		: '/RegionUpdate',
		    	data 		: UpdateRegionData,
		    	dataType 	: 'json',
		    	success:function(data){
		    		ClearRegion();
					ModalAlert("RegionInfo","Success Update Region","green");
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

	$('#buttonCancelRegion').click(function(){
		ClearRegion();
	});

	function refreshDropdownRegion(){
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownRegion',
			dataType: 'json',
			success:function(data){
				$('#PP_Form_Region').html("");
				$('#RA_Region').html("");
				$('#PP_Form_Region').append('<option value="None">Select</option>');
				$('#RA_Region').append('<option value="None">Select</option>');
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#PP_Form_Region').append('<option value="'+data[i]['RegionID']+'">'+data[i]['RegionName']+'</option>');
					$('#RA_Region').append('<option value="'+data[i]['RegionID']+'">'+data[i]['RegionName']+'</option>');
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

	function refreshTableRegion() {
		$('#tableRegion').html("");
		$.ajax({
			type 		: 'POST',
			url 		: '/refreshTableRegion',
			dataType 	: 'json',
			success:function(data) {
				$('#tableRegion').html(data);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	function ClearRegion(){
		$('#buttonUpdateRegion').hide();
		$('#buttonCancelRegion').hide();
		$('#buttonSubmitRegion').show();
		$('#RegionID').removeAttr("disabled");
		$('#RegionID').val("");
		$('#RegionName').val("");
		$('#RegionPhone').val("");
		$('#RegionAddress').val("");
		$('#RegionFax').val("");
		$('#RegionInfo').hide();
		refreshTableRegion();
	}

	//////BUSINESS AREA//////

	$('#AddBABtn').click(function(){
		ClearBA();
		$('#PP_Form_Modal').modal('hide');
	});

	function ClearBA(){
		$('#AddBAID').removeAttr("disabled");
		$('#AddBAID').val("");
		$('#AddBAName').val("");
		$('#buttonUpdateBA').hide(); 
		$('#buttonCancelBA').hide(); 
		$('#buttonAddBA').show();
		$('#Info_BA').hide();
		refreshTableBusinessArea();
	}

	function refreshDropdownBA(){
		$.ajax({
			type: 'POST',
			url: '/refreshDropdownBA',
			dataType: 'json',
			success:function(data){
				$('#projectBA').html("");
				var j = data.length;
				for (var i = 0; i < j; i++){
					$('#projectBA').append('<option value="'+data[i]['BusinessAreaID']+'">'+data[i]['BusinessAreaName']+'</option>');
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

	$('#ModalAddBusinessArea').on('hidden.bs.modal', function (e) {
        refreshDropdownBA();
        $('#PP_Form_Modal').modal('show');
    });

    $('#closeAddBA').click(function(){
		refreshDropdownBA();
		$('#PP_Form_Modal').modal('show');
	});
	
	$('#buttonAddBA').click(function(){
		var BAID	= $('#AddBAID').val();
		var BAName 	= $('#AddBAName').val();
		if( BAID == "" ){
			ModalAlert("Info_BA","Business Area ID must be filled","red");
			return false;
		} else if( BAID.length != 2 ){
			ModalAlert("Info_BA","Business Area can't more than 2 character","red");
			return false;
		} else if( BAName == "" ){
			ModalAlert("Info_BA","Business Area Name must be filled","red");
			return false;
		} else {
			var BAData = {
		    	BAID 	: BAID,
		    	BAName 	: BAName
		    }
			$.ajax({
		    	type: 'POST',
		    	url: '/EntryBusinessArea',
		    	data: BAData,
		    	dataType: 'json',
		    	success:function(data){
		    		if(data == 1){
		    			ClearBA();
		    			ModalAlert("Info_BA","Success Entry Business Area","green");
		    		} else {
		    			ModalAlert("Info_BA","Business Area ID already registered","red");
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

	$('#buttonUpdateBA').click(function(){
		var BAID	= $('#AddBAID').val();
		var BAName 	= $('#AddBAName').val();
		if( BAName == "" ){
			ModalAlert("Info_BA","Business Area Name must be filled","red");
			return false;
		} else {
			var BAData = {
		    	BAID 	: BAID,
		    	BAName 	: BAName
		    }
			$.ajax({
		    	type: 'POST',
		    	url: '/BAUpdate',
		    	data: BAData,
		    	dataType: 'json',
		    	success:function(data){
	    			ClearBA();
	    			ModalAlert("Info_BA","Success Update Business Area","green");
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

	$('#buttonCancelBA').click(function(){
		ClearBA();
	});

	function refreshTableBusinessArea() {
		$('#tableBA').html("");
		$.ajax({
			type: 'POST',
			url: '/refreshTableBusinessArea',
			dataType: 'json',
			success:function(data){
				$('#tableBA').html(data);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				showModal("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	}

	//////OTHER//////

	function getEditFormattedDate(date) {
		var year = date.getFullYear();
		var month = (1 + date.getMonth()).toString();
		month = month.length > 1 ? month : '0' + month;
		return year + '-' + month + '-01';
	}

	$('#btnAlright').click(function() {
		$('#Modal').modal('hide');
	});

	function showModal(data, status){
		$('#btnOK').hide();
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

	function ModalAlert(Info,Alert,Color){
    	$('#'+Info).show();
        $('#'+Info).text(Alert);
		document.getElementById(Info).style.color = Color;
		document.getElementById(Info).style.fontSize = "14px";
    }

});