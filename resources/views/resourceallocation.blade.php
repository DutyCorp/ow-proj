	@include('library.head')
	<title>Resource Allocation</title>
	<script src="{{asset('js/ResourceAllocation.js')}}"></script>
	<div id="main" class="container">	
		<div class="modal fade" id="ModalAddBusinessArea" role="dialog">
		    <div class="modal-dialog">
		      	<div class="modal-content">
			        <div class="modal-header">
			        	<button id="closeAddBA" type="button" class="close" data-dismiss="modal">&times;</button>
			          	<center><h4 class="modal-title">New Business Area</h4></center>
			        </div>
			        <div class="modal-body">
			         	<div class="form-group row">
			         		<div class="col-md-3 col-md-offset-2">Business Area ID</div>
			      			<div class="col-md-4"><input type="text" id="AddBAID" class="form-control"></div>
			      		</div>
			      		<div class="form-group row">
			         		<div class="col-md-3 col-md-offset-2">Business Area Name</div>
			      			<div class="col-md-4"><input type="text" id="AddBAName" class="form-control"></div>
			      		</div>
			      		<div class="form-group row">
			         		<center id="Info_BA" style="color:red">Total must be 100</center>
			      		</div>
			      		<div class="form-group row" align="center">
							<button class="btn btn-primary" id="buttonAddBA" >Submit</button>
							<button id="buttonUpdateBA" class="btn btn-success">Update</button>
							<button id="buttonCancelBA" class="btn btn-default">Cancel</button>
						</div>
						<div class="form-group row">
							<div id="tableBA">
							</div>
						</div>
			        </div>
		      	</div>
		    </div>
  		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="Modal_Notification">
		  	<div class="modal-dialog" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
			        	<h4 class="modal-title" id="ModalHeaderNotification"></h4>
			      	</div>
			      	<div class="modal-body" id="ModalContentNotification">

			      	</div>
			      	<div class="modal-footer" id="ModalFooter">
			      		<center>
			      			<button type="button" class="btn btn-danger" id="YesDelete">Yes</button>
			      			<button type="button" class="btn btn-default" id="NoDelete">No</button>
			      		</center>
			      	</div>
			    </div>
		  	</div>
		</div>
		<div class="modal fade" id="RegionModal" role="dialog">
		    <div class="modal-dialog modal-lg" style="margin-top:5px">
		    	<div class="modal-content">
		       		<div class="modal-header" style="padding-top:5px; padding-bottom:5px">
		        		<button id="closeRegionButton" type="button" class="close" data-dismiss="modal">&times;</button>
		        		<center><h4 class="modal-title">Entry Region</h4></center>
		        	</div>
		        	<div class="modal-header" style="padding-top:10px">
						<div class="form-group row" style="margin-bottom:0px">
							<div class="col-md-6 col-md-offset-3">
								<div class="form-group row" style="background-color:#E3F2FD" >
									<div class="col-md-12">
										<div class="form-group row">
											<div class="col-md-12" style="padding-top:5px">
												<label for="RegionID">Region ID</label>
												<input id="RegionID" class="form-control" type="text">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-12">
												<label for="RegionName">Region Name</label>
												<input id="RegionName" type="text" class="form-control">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-12">
												<label for="RegionPhone">Phone Office</label>
												<input id="RegionPhone" type="text" class="form-control">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-12">
												<label for="RegionAddress">Address</label>
												<input id="RegionAddress" type="text" class="form-control">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-12">
												<label for="RegionFax">Fax</label>
												<input id="RegionFax" type="text" class="form-control">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
		        			<center>
		        				<label id="RegionInfo">Success</label>
		        			</center>
		        		</div>
						<div class="form-group row" align="center">
							<div class="col-md-12">
								<button id="buttonSubmitRegion" name="buttonSubmitRegion" class="btn btn-primary">Submit</button>
								<button id="buttonUpdateRegion" name="buttonUpdateRegion" class="btn btn-success">Update</button>
								<button id="buttonCancelRegion" name="buttonCancelRegion" class="btn btn-default">Cancel</button>
							</div>
						</div>
		        	</div>
		        	<div class="modal-body-region">
		          		<div id="tableRegion">
						</div>
		        	</div>
		    	</div>
		    </div>
		</div>			
		<div class="modal fade" tabindex="-1" role="dialog" id="Modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="ModalHeader"></h4>
					</div>
					<div class="modal-body" id="ModalContent">
					</div>
					<div class="modal-footer" id="ModalFooter">
						<button type="button" class="btn btn-primary" id="btnAlright">OK</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="WD_Modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="ModalHeader" align="center">Working Day</h4>
					</div>
					<div class="modal-body" id="ModalContent">
						<div id="WDBody">
							<div class="form-group row">
								<div class="col-md-2">January</div>
								<div class="col-md-3"><input id="Month_1" type="text" class="form-control"></div>
								<div class="col-md-2 col-md-offset-2">July</div>
								<div class="col-md-3"><input id="Month_7" type="text" class="form-control"></div>
							</div>
							<div class="form-group row">
								<div class="col-md-2">February</div>
								<div class="col-md-3"><input id="Month_2" type="text" class="form-control"></div>
								<div class="col-md-2 col-md-offset-2">August</div>
								<div class="col-md-3"><input id="Month_8" type="text" class="form-control"></div>
							</div>
							<div class="form-group row">
								<div class="col-md-2">March</div>
								<div class="col-md-3"><input id="Month_3" type="text" class="form-control"></div>
								<div class="col-md-2 col-md-offset-2">September</div>
								<div class="col-md-3"><input id="Month_9" type="text" class="form-control"></div>
							</div>
							<div class="form-group row">
								<div class="col-md-2">April</div>
								<div class="col-md-3"><input id="Month_4" type="text" class="form-control"></div>
								<div class="col-md-2 col-md-offset-2">October</div>
								<div class="col-md-3"><input id="Month_10" type="text" class="form-control"></div>
							</div>
							<div class="form-group row">
								<div class="col-md-2">May</div>
								<div class="col-md-3"><input id="Month_5" type="text" class="form-control"></div>
								<div class="col-md-2 col-md-offset-2">November</div>
								<div class="col-md-3"><input id="Month_11" type="text" class="form-control"></div>
							</div>
							<div class="form-group row">
								<div class="col-md-2">June</div>
								<div class="col-md-3"><input id="Month_6" type="text" class="form-control"></div>
								<div class="col-md-2 col-md-offset-2">December</div>
								<div class="col-md-3"><input id="Month_12" type="text" class="form-control"></div>
							</div>
							<div class="form-group row" >
								<div class="col-md-10 col-md-offset-1">
	                                <center id="InfoWD_Form" style="color:red; text-align:center" ><h4><b>Total must be 100</b></h4></center>
	                            </div>
							</div>
							<div class="form-group row" align="center">
								<button id="Save_WD" class="btn btn-info">Save</button>
								<button id="Clear_WD" class="btn btn-default">Clear</button>
							</div>
						</div>
						<div id="alertWDBody" align="center">Region and Year must be chosen</div>
					</div>
					<div class="modal-footer" id="ModalFooter">
						<button type="button" class="btn btn-primary" id="btnCloseWD">Close</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="PP_Modal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="ModalHeader" align="center">Prospect Project</h4>
					</div>
					<div class="modal-body" id="ModalContent">
						<div id="PPBody">
							<div class="form-group row">
								<div class="col-md-3">Year</div>
								<div class="col-md-3">
									<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="years" data-view="years"  data-date-format="yyyy" id="PP_Year"/>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3">
									<button id="btnAddPP" class="btn btn-success" data-toggle="modal" data-target="#PP_Form_Modal">Add Prospect Project</button>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12" id="TableProspectProject">
									
								</div>
							</div>
						</div>
						<div id="alertPPBody" align="center">Region and Year must be chosen</div>
					</div>
					<div class="modal-footer" id="ModalFooter">
						<button type="button" class="btn btn-primary" id="btnClosePP">Close</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="PP_Form_Modal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="ModalHeader" align="center">Add Prospect Project</h4>
					</div>
					<div class="modal-body modal-body-resourceallocation" id="ModalContent">
						<div class="form-group row">
							<div class="col-md-4 col-md-offset-4">
								<label for="PP_Form_Year">Year</label>
								<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="years" data-view="years"  data-date-format="yyyy" id="PP_Form_Year"/>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3 col-md-offset-4">
								<label for="PP_Form_Region">Region</label>
								<select id="PP_Form_Region" class="form-control">
									<option value="None">Select</option>
									@foreach($ListRegion as $Region)
										<option value="{{ $Region->RegionID }}">{{ $Region->RegionName }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-1" style="padding-top:22px">
								<button id="addNewRegion" class="btn-success btn form-control" data-toggle="modal" data-target="#RegionModal" style="font-size:11px">Add</button>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3 col-md-offset-4">
								<label for="projectBA">Business Area</label>
								<select id="projectBA" class="form-control">
								</select>
							</div>
							<div class="col-md-1" style="padding-top:22px">
								<button id="AddBABtn" type="button" class="form-control btn-success btn" data-toggle="modal" data-target="#ModalAddBusinessArea" style="font-size:11px">Add</button>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4 col-md-offset-4">
								<label for="PP_Form_Code">Project Code</label>
								<input id="PP_Form_Code" type="text" class="form-control"/>
							</div>
							<div class="col-md-3" style="padding-top:27px">
								<label id="ExamplePP"></label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4 col-md-offset-4">
								<label for="PP_Form_Name">Project Name</label>
								<input id="PP_Form_Name" type="text" class="form-control"/>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4 col-md-offset-4">
								<label for="PP_Form_MDPlan">MD Plan</label>
								<input id="PP_Form_MDPlan" type="text" class="form-control"/>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-2 col-md-offset-4">
								<label for="PP_Form_Opportunity">Opportunity ( % ) </label>
								<input id="PP_Form_Opportunity" type="text" class="form-control"/>
							</div>
							<div class="col-md-2">
								<label for="PP_Form_WeightedMD">Weighted MD</label>
								<input id="PP_Form_WeightedMD" disabled type="text" class="form-control"/>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4 col-md-offset-4">
								<label for="PP_Form_StartDate">Start Project</label>
								<input id="PP_Form_StartDate" type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy"/>
							</div>
						</div>
						<div class="form-group row" >
							<div class="col-md-4 col-md-offset-4">
                                <center id="InfoPP_Form" style="color:red; text-align:center"><h4><b>Total must be 100</b></h4></center>
                            </div>
						</div>
						<div class="form-group row">
							<div class="col-md-2 col-md-offset-4" align="right"><button id="Add_PP_Form" class="btn-info btn">Add</button></div>
							<div class="col-md-2"><button id="Clear_PP_Form" class="btn-default btn">Clear</button></div>
							<div class="col-md-2 col-md-offset-4" align="right"><button id="Update_PP_Form" class="btn-success btn">Update</button></div>
							<div class="col-md-2"><button id="Cancel_PP_Form" class="btn-default btn">Cancel</button></div>
						</div>
						<div id="prospectprojectTable">

						</div>
					</div>
					<div class="modal-footer" id="ModalFooter">
						<button type="button" class="btn btn-primary" id="btnClosePPForm">Close</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="NE_Modal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="ModalHeader" align="center">New Employee</h4>
					</div>
					<div class="modal-body" id="ModalContent">
						<div id="NEBody">
							<div class="form-group row">
								<div class="col-md-3">Year</div>
								<div class="col-md-3">
									<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="years" data-view="years"  data-date-format="yyyy" id="NE_Year"/>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3">
									<button id="btnAddNE" class="btn btn-success" data-toggle="modal" data-target="#NE_Form_Modal">Add New Employee</button>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12" id="TableNewEmployee">
								</div>
							</div>
						</div>
						<div id="alertNEBody" align="center">Region and Year must be chosen</div>
					</div>
					<div class="modal-footer" id="ModalFooter">
						<button type="button" class="btn btn-primary" id="btnCloseNE">Close</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="NE_Form_Modal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="ModalHeader" align="center">Add New Employee</h4>

					</div>
					<div class="modal-body modal-body-resourceallocation" id="ModalContent">
						<div class="form-group row">
							<div class="col-md-3">Region</div>
							<div class="col-md-4">
								<select id="NE_Form_Region" class="form-control">
									<option value="None">Select</option>
									@foreach($ListRegion as $Region)
										@if($Region->RegionID != "AS")
											<option value="{{ $Region->RegionID }}">{{ $Region->RegionName }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3">Employee ID</div>
							<div class="col-md-4">
								<input id="NE_Form_ID" type="text" class="form-control"/>
							</div>
							<div class="col-md-3">
								<label id="ExampleNE"></label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3">Employee Name</div>
							<div class="col-md-4">
								<input disabled id="NE_Form_Name" type="text" class="form-control"/>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3">Start Working Date</div>
							<div class="col-md-4">
								<input id="NE_Form_SWD" type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy"/>
							</div>
						</div>
						<div class="form-group row" >
							<div class="col-md-6 col-md-offset-3">
                                <center id="InfoNE_Form" style="color:red; text-align:center" ><h4><b>Total must be 100</b></h4></center>
                            </div>
						</div>
						<div class="form-group row">
							<div class="col-md-2 col-md-offset-4"><button id="Add_NE_Form" class="btn-info btn">Add</button></div>
							<div class="col-md-2"><button id="Clear_NE_Form" class="btn-default btn">Clear</button></div>
							<div class="col-md-2 col-md-offset-4"><button id="Update_NE_Form" class="btn-success btn">Update</button></div>
							<div class="col-md-2"><button id="Cancel_NE_Form" class="btn-default btn">Cancel</button></div>
						</div>
						<div id="TableListNewEmployee">
							
						</div>
					</div>
					<div class="modal-footer" id="ModalFooter">
						<button type="button" class="btn btn-primary" id="btnCloseNEForm">Close</button>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row" style="text-align: center;">
			<h1>Resource Allocation Setting</h1>
		</div>
		<div class="form-group row">
			<div class="col-md-4 col-md-offset-4">
				<div class="form-group row" style="background-color:#E3F2FD" >
					<div class="col-md-12">
						<div class="form-group row">
							<div class="col-md-9" style="padding-top:20px">
								<label for="RA_Region">Region</label>
								<select id="RA_Region" class="form-control">
									<option value="None">Select</option>
									@foreach($ListRegion as $Region)
										@if($Region->RegionID != "AS")
											<option value="{{ $Region->RegionID }}">{{ $Region->RegionName }}</option>
										@endif
									@endforeach
								</select>
							</div>
							<div class="col-md-3" style="padding-top:42px">
								<button id="addRegion" class="btn-success btn form-control" data-toggle="modal" data-target="#RegionModal" style="font-size:11px">Add</button>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-9">
								<label for="RA_Year">Year</label>
								<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="years" data-view="years"  data-date-format="yyyy" id="RA_Year"/>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-9">
								<label>Working Day</label>
							</div>
							<div class="col-md-3">
								<button id="btn_WD" class="btn btn-success form-control" data-toggle="modal" data-target="#WD_Modal">Set</button>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-9">
								<label>Prospect Project</label>
							</div>
							<div class="col-md-3">
								<button id="btn_PP" class="btn btn-success form-control" data-toggle="modal" data-target="#PP_Modal">Set</button>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-9">
								<label>New Employee</label>
							</div>
							<div class="col-md-3">
								<button id="btn_NE" class="btn btn-success form-control" data-toggle="modal" data-target="#NE_Modal">Set</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('library.foot')