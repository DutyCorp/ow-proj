	@include('library.head')
	<title>Entry Employee</title>
	<script src="{{asset('js/EntryEmployee.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_S == "0")
			<script>
				$(function(){
			    	window.location.replace("/");
			    });
			</script>
		@endif
		<div id="main" class="container">
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
			<div class="form-group row" style="text-align: center;">
				<h1>Entry Employee</h1>
			</div>
			@if($rolemenu->Role_I == "1" && $rolemenu->Role_S == "1")
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
				<div class="modal fade" id="myModal" role="dialog">
				    <div class="modal-dialog">
				    	<div class="modal-content">
				       		<div class="modal-header">
				        		<button id="closePositionButton" name="closePositionButton" type="button" class="close" data-dismiss="modal">&times;</button>
				        		<center><h4 class="modal-title">New Position</h4></center>
				        	</div>
				        	<div class="modal-header">
					        	<div class="form-group row" style="background:#E3F2FD; margin-left:5px; margin-right:5px; padding-top:5px">
									<div class="col-md-6">
										<label for="positionID">Position ID</label>
										<label id="positionID" name="positionID" class="form-control"><b></b></label>
									</div>
									<div class="col-md-6">
										<label for="positionName">Position Name</label>
										<input id="positionName" name="positionName" type="text" class="form-control">
									</div>
								</div>
								<div class="form-group row">
				        			<center>
				        				<label id="PositionInfo">Success</label>
				        			</center>
				        		</div>
								<div class="form-group row" align="center">
									<div class="col-md-12">
										<button id="buttonSubmitPosition" name="buttonSubmitPosition" class="btn btn-primary">Submit</button>
										<button id="buttonUpdatePosition" name="buttonUpdatePosition" class="btn btn-success">Update</button>
										<button id="buttonCancelPosition" name="buttonCancelPosition" class="btn btn-default">Cancel</button>
									</div>
								</div>
				        	</div>
				        	<div class="modal-body-position">
				          		<div id="tablePosition">
								</div>
				        	</div>
				    	</div>
				    </div>
				</div>
				<div class="modal fade" id="DepartmentModal" role="dialog">
				    <div class="modal-dialog">
				    	<div class="modal-content">
				       		<div class="modal-header">
				        		<button id="closeDepartmentButton" name="closeDepartmentButton" type="button" class="close" data-dismiss="modal">&times;</button>
				        		<center><h4 class="modal-title">New Department</h4></center>
				        	</div>
				        	<div class="modal-header">
					        	<div class="form-group row" style="background:#E3F2FD; margin-left:5px; margin-right:5px; padding-top:5px">
									<div class="col-md-6">
										<label for="DepartmentID">Department ID</label>
										<label id="DepartmentID" name="DepartmentID" class="form-control"><b></b></label>
									</div>
									<div class="col-md-6">
										<label for="DepartmentName">Department Name</label>
										<input id="DepartmentName" type="text" class="form-control">
									</div>
								</div>
								<div class="form-group row">
				        			<center>
				        				<label id="DepartmentInfo">Success</label>
				        			</center>
				        		</div>
								<div class="form-group row" align="center">
									<div class="col-md-12">
										<button id="buttonSubmitDepartment" name="buttonSubmitDepartment" class="btn btn-primary">Submit</button>
										<button id="buttonUpdateDepartment" name="buttonUpdateDepartment" class="btn btn-success">Update</button>
										<button id="buttonCancelDepartment" name="buttonCancelDepartment" class="btn btn-default">Cancel</button>
									</div>
								</div>
				        	</div>
				        	<div class="modal-body">
				          		<div id="tableDepartment">
								</div>
				        	</div>
				    	</div>
				    </div>
				</div>
				<div class="modal fade" id="GradeModal" role="dialog">
				    <div class="modal-dialog">
				    	<div class="modal-content">
				       		<div class="modal-header">
				        		<button id="closeGradeButton" type="button" class="close" data-dismiss="modal">&times;</button>
				        		<center><h4 class="modal-title">New Grade</h4></center>
				        	</div>
				        	<div class="modal-header">
					        	<div class="form-group row" style="background:#E3F2FD; margin-left:5px; margin-right:5px; padding-top:5px">
									<div class="col-md-6">
										<label for="GradeID">Grade ID</label>
										<label id="GradeID" name="GradeID" class="form-control"><b></b></label>
									</div>
									<div class="col-md-6">
										<label for="GradeName">Grade Name</label>
										<input id="GradeName" type="text" class="form-control">
									</div>
								</div>
								<div class="form-group row">
				        			<center>
				        				<label id="GradeInfo">Success</label>
				        			</center>
				        		</div>
								<div class="form-group row" align="center">
									<div class="col-md-12">
										<button id="buttonSubmitGrade" name="buttonSubmitGrade" class="btn btn-primary">Submit</button>
										<button id="buttonUpdateGrade" class="btn btn-success">Update</button>
										<button id="buttonCancelGrade" name="buttonCancelGrade" class="btn btn-default">Cancel</button>
									</div>
								</div>
				        	</div>
				        	<div class="modal-body">
				          		<div id="tableGrade">
								</div>
				        	</div>
				    	</div>
				    </div>
				</div>
				<div class="form-group row">
					<div class="col-md-4" >
						<div class="form-group row" style="width:80%; background-color:#E3F2FD; margin-left:33px" >
							<div class="col-md-12" style="margin-top:10px">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryID">Employee ID</label>
										<input id="entryID" name="entryID" type="text" class="form-control" style="background:#FFF9C4">
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryName">Employee Name</label>
										<input id="entryName" name="entryName" type="text" class="form-control" style="background:#FFF9C4">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryEmail">Email</label>
										<input id="entryEmail" name="entryEmail" type="email" class="form-control" style="background:#FFF9C4">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="employeeUsername">Username</label>
										<label disabled align="left" id="employeeUsername" name="employeeUsername" class="form-control" style="background:#FFF9C4">-</label>
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryPassword">Password</label>
										<input id="entryPassword" name="entryPassword" type="password" class="form-control" style="background:#FFF9C4">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="retypePassword">Re-type Password</label>
										<input id="retypePassword" type="password" class="form-control" style="background:#FFF9C4">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-9">
										<label for="selectRegion">Region</label>
										<select id="selectRegion" name="selectRegion" class="form-control" style="background:#FFF9C4">
											<option value="None">Select</option>
											@foreach($ListRegion as $Region)
												<option value="{{ $Region->RegionID }}">{{ $Region->RegionName }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-3" style="padding-top:22px">
										<button id="addNewRegion" class="btn-success btn form-control" data-toggle="modal" data-target="#RegionModal" style="font-size:12px">Add</button>
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-9">
										<label for="selectRole">Role</label>
										<select id="selectRole" name="selectRole" class="form-control" style="background:#FFF9C4">
											<option value="None">Select</option>
											@foreach($ListRole as $Role)
												<option value="{{ $Role->RoleID }}">{{ $Role->RoleName }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-3" style="padding-top:22px">
										<button id="AddRole" class="btn-success btn form-control" style="font-size:12px">Add</button>
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-9">
										<label for="selectDepartment">Department</label>
										<select id="selectDepartment" name="selectDepartment" class="form-control" style="background:#FFF9C4">
											<option value="None">Select</option>
											@foreach($ListDepartment as $Department)
												<option value="{{ $Department->DepartmentID }}">{{ $Department->DepartmentName }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-3" style="padding-top:22px">
										
										<button id="addNewDepartment" class="btn-success btn form-control" data-toggle="modal" data-target="#DepartmentModal" style="font-size:12px">Add</button>
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row" style="margin-top:10px">
									<div class="col-md-9">
										<label for="selectPosition">Position</label>
										<select id="selectPosition" name="selectPosition" class="form-control" style="background:#FFF9C4">
											<option value="None">Select</option>
											@foreach($ListPosition as $Position)
												<option value="{{ $Position->PositionID }}">{{ $Position->PositionName }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-3" style="padding-top: 22px;">
										<button id="addNewPosition" class="btn btn-success form-control" data-toggle="modal" data-target="#myModal" style="font-size:12px">Add</button>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-9">
										<label for="selectGrade">Grade</label>
										<select id="selectGrade" name="selectGrade" class="form-control" style="background:#FFF9C4">
											<option value="None">Select</option>
											@foreach($ListGrade as $Grade)
												<option value="{{ $Grade->GradeID }}">{{ $Grade->GradeName }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-3" style="padding-top: 22px;">
										<button id="addNewGrade" class="btn btn-success form-control" data-toggle="modal" data-target="#GradeModal" style="font-size:12px">Add</button>
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="selectSWD">Start Working Date</label>
										<input id="selectSWD" type="text" class="datepicker-here form-control" data-language='en' data-date-format="d / MM / yyyy"/ style="background:#FFF9C4">
									</div>
								</div>	
							</div>
							<div class="col-md-12" style="margin-bottom:10px">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entrySkype">Skype ID</label>
										<input id="entrySkype" name="entrySkype" type="text" class="form-control" style="background:#FFF9C4">
									</div>
								</div>	
							</div>
						</div>
					</div>
					<div class="col-md-4" >
						<div class="form-group row" style="width:80%; background-color:#E3F2FD; margin-left:33px" >
							<div class="col-md-12" style="margin-top:10px">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryAddress">Address</label>
										<textarea class="form-control" id="entryAddress" style="background:#FFF9C4"></textarea>
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="selectDOB">Date of Birth</label>
										<input id="selectDOB" type="text" class="datepicker-here form-control" data-language='en' data-date-format="d / MM / yyyy"/ style="background:#FFF9C4">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-5">
										<label for="selectRegionCodeNumber">Mobile Phone</label>
										<input type="text" class="form-control" id="selectRegionCodeNumber" name="selectRegionCodeNumber" style="background:#FFF9C4"><span class="help-block">Ex +62</span>
									</div>
									<div class="col-md-7" style="padding-top:22px">
										<input id="entryPhone" name="entryPhone" type="text" class="form-control" style="background:#FFF9C4">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryEmergencyContactName">Emergency Contact Name</label>
										<input id="entryEmergencyContactName" name="entryEmergencyContactName" type="text" class="form-control">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryEmergencyContact">Emergency Contact</label>
										<input id="entryEmergencyContact" name="entryEmergencyContact" type="text" class="form-control">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryEmergencyContactRelationship">Emergency Contact Relationship</label>
										<input id="entryEmergencyContactRelationship" name="entryEmergencyContactRelationship" type="text" class="form-control">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryUSDBankName">USD Bank Name</label>
										<input id="entryUSDBankName" name="entryUSDBankName" type="text" class="form-control">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryEmergencyContactRelationship">USD Bank Account Number</label>
										<input id="entryUSDBankAccount" name="USDBankAccount" type="text" class="form-control">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryUSDName">USD Bank Account Name</label>
										<input id="entryUSDName" name="entryUSDName" type="text" class="form-control">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryLocalBankName">Local Bank Name</label>
										<input id="entryLocalBankName" name="entryLocalBankName" type="text" class="form-control">
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryLocalBankAccount">Local Bank Account Number</label>
										<input id="entryLocalBankAccount" name="entryLocalBankAccount" type="text" class="form-control">
									</div>
								</div>	
							</div>
							<div class="col-md-12" style="margin-bottom:45px">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="entryLocalName">Local Bank Account Name</label>
										<input id="entryLocalName" name="entryLocalName" type="text" class="form-control">
									</div>
								</div>	
							</div>	
						</div>
					</div>
					<div class="col-md-4" >
						<div class="form-group row" style="width:80%; background-color:#E3F2FD; margin-left:33px" >
							<div class="col-md-12" style="margin-top:10px">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="fileNationalId">National ID</label>
										<input id="fileNationalId" name="fileNationalId" type="file" class="form-control"/><span class="help-block">File extension .jpg / .png / .pdf</span>
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="filePassport">Passport</label>
										<input id="filePassport" name="filePassport" type="file" class="form-control"/><span class="help-block">File extension .jpg / .png / .pdf</span>
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="fileCV">Curriculum Vitae</label>
										<input id="fileCV" name="fileCV" type="file" class="form-control"/><span class="help-block">File extension .jpg / .png / .pdf</span>
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="fileTaxRegistrationId">Tax Registration ID</label>
										<input id="fileTaxRegistrationId" name="fileTaxRegistrationId" type="file" class="form-control" /><span class="help-block">File extension .jpg / .png / .pdf</span>
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="fileKK">Family Registration Card</label>
										<input id="fileKK" name="filePhoto" type="file" class="form-control"/><span class="help-block">File size min. 1MB, file extension .jpg / .png</span>
									</div>
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="filePhoto">Photo</label>
										<input id="filePhoto" name="filePhoto" type="file" class="form-control"/><span class="help-block">File size min. 1MB, file extension .jpg / .png</span>
									</div>
								</div>	
							</div>
							<div id="PhotoGAP" class="col-md-12" style="margin-bottom:184px">
								<div class="form-group row">
								</div>	
							</div>
							<div class="col-md-6 col-md-offset-3" style="margin-bottom:130px">	
								<img height="200" width="150" id="ShowImg" name="ShowImg" src="#" alt="your image" />
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row" align="center">
					<button id="buttonSubmit" name="buttonSubmit" class="btn btn-primary">Submit</button>
					<button id="buttonClear" name="buttonClear" class="btn btn-link">Clear</button>
				</div>
			@endif
		</div>
	@endforeach
	@include('library.foot')