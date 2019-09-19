	@include('library.head')
	<title>Master Project</title>
	<script src="{{asset('js/MasterProject.js')}}"></script>
	<div id="main" class="container">
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
		<div class="modal fade" id="ModalAddProjectType" role="dialog">
		    <div class="modal-dialog">
		      	<div class="modal-content">
			        <div class="modal-header">
			          <center><h4 class="modal-title">New Project Type</h4></center>
			        </div>
			        <div class="modal-body">
			         	<div class="form-group row">
			         		<div class="col-md-3 col-md-offset-2">Project Type</div>
			      			<div class="col-md-4"><input type="text" id="AddProjectType" class="form-control"></div>
			      		</div>
			      		<div class="form-group row">
			         		<center id="Info_ProjectType" style="color:red">Total must be 100</center>
			      		</div>
			      		<div class="form-group row" align="center">
							<button class="btn btn-primary" id="buttonAddProjectType" >Submit</button>
						</div>
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        </div>
		      	</div>
		    </div>
  		</div>
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
		<div class="form-group row" style="text-align: center;">
			<h1>Master Project</h1>
		</div>
		<div class="form-group row">
			<div class="col-md-4 col-md-offset-4">
				<div class="form-group row" style="background-color:#E3F2FD">
					<div class="col-md-12" style="padding-top: 10px">
						<div class="form-group row">
							<div class="col-md-12">
								<label for="projectCode">Project Code</label>
								<input type="text" id="projectCode" name="projectCode" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label for="projectName">Project Name</label>
								<input type="text" id="projectName" name="projectName" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-9" id="PT">
								<label for="projectType">Project Type</label>
								<select id="projectType" class="form-control">
									<option value="None">Select</option>
									@foreach($ListProjectType as $ProjectType)
										<option value="{{ $ProjectType->ProjectType }}">{{ $ProjectType->ProjectType }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-9" id="newPT">
								<label for="newProjectType">Project Type</label>
								<input disabled id="newProjectType" class="form-control">
							</div>
							<div class="col-md-3" style="padding-top:22px">
								<button id="AddPTBtn" type="button" class="form-control btn-success btn" data-toggle="modal" data-target="#ModalAddProjectType">Add</button>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-9">
								<label for="projectRegion">Project Region</label>
								<select id="projectRegion" class="form-control">
									@foreach($ListRegion as $Region)
										<option value="{{ $Region->RegionID }}">{{ $Region->RegionName }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-3" style="padding-top:22px">
								<button id="addNewRegion" class="btn-success btn form-control" data-toggle="modal" data-target="#RegionModal" style="font-size:12px">Add</button>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-9">
								<label for="projectBA">Business Area</label>
								<select id="projectBA" class="form-control">
									@foreach($ListBusinessArea as $BA)
										<option value="{{ $BA->BusinessAreaID }}">{{ $BA->BusinessAreaName }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-3" style="padding-top:22px">
								<button id="AddBABtn" type="button" class="form-control btn-success btn" data-toggle="modal" data-target="#ModalAddBusinessArea">Add</button>
							</div>
						</div>
						<br>
						<div class="form-group row" align="center">
							<button class="btn btn-success" id="buttonUpdateMasterProject" name="buttonUpdateMasterProject">Update</button>
							<button class="btn btn-primary" id="buttonSubmitMasterProject" name="buttonSubmitMasterProject">Submit</button>
							<button class="btn btn-link" id="buttonClearMasterProject" name="buttonClearMasterProject">Clear</button>
							<button class="btn btn-default" id="buttonCancelMasterProject" name="buttonCancelMasterProject">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="tableMasterProject">
		</div>
	</div>
	@include('library.foot')