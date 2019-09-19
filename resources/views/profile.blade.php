	@include('library.head')
	<title>Profile</title>
	<script src="{{asset('js/EditProfileEmployee.js')}}"></script>
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
		@foreach($EmployeeData as $Employee)
			<input value="{{ $Employee->Password }}"  id="OldPass" type="hidden">
			<div class="form-group row" style="text-align: center;">
				<h1>Profile Employee</h1>
			</div>
			<div class="form-group row">
				<div class="col-md-3">
					<div class="form-group row" style="background-color:#E3F2FD" >
						<div class="col-md-12" style="margin-top:10px">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryID">Employee ID</label>
									<input disabled type="text" id="entryID" name="entryID" value="{{ $Employee->EmployeeID }}"class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryName">Employee Name</label>
									<input disabled value="{{ $Employee->EmployeeName }} "id="entryName" name="entryName" type="text" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryEmail">Email</label>
									<input disabled value="{{ $Employee->Email }}" id="entryEmail" name="entryEmail" type="email" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="employeeUsername">Username</label>
									<input disabled type="text" value="{{ $Employee->Username }}"  id="employeeUsername" name="employeeUsername" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="selectRegion">Region</label>
									<select disabled id="selectRegion" name="selectRegion" class="form-control">
										<option value="{{ $Employee->RegionID }}">{{ $Employee->RegionName }}</option>
									</select>
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="selectRole">Role</label>
									<select disabled id="selectRole" name="selectRole" class="form-control">
										<option value="{{ $Employee->RoleID }}">{{ $Employee->RoleName }}</option>
									</select>
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="selectDepartment">Department</label>
									<select disabled id="selectDepartment" name="selectDepartment" class="form-control">
										<option value="{{ $Employee->DepartmentID }}">{{ $Employee->DepartmentName }}</option>
									</select>
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row" style="margin-top:10px">
								<div class="col-md-12">
									<label for="selectPosition">Position</label>
									<select disabled id="selectPosition" name="selectPosition" class="form-control">
										<option value="{{ $Employee->PositionID }}">{{ $Employee->PositionName }}</option>		
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="selectGrade">Grade</label>
									<select disabled id="selectGrade" name="selectGrade" class="form-control">
										<option value="{{ $Employee->GradeID }}">{{ $Employee->GradeName }}</option>
									</select>
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="selectSWD">Start Working Date</label>
									<input disabled value="{{ $Employee->StartWorkingDate }}" id="selectSWD" name="selectSWD" type="date" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12" style="margin-bottom:125px">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entrySkype">Skype ID</label>
									<input value="{{ $Employee->SkypeID }}" id="entrySkype" name="entrySkype" type="text" class="form-control">
								</div>
							</div>	
						</div>
					</div>
				</div>
				<div class="col-md-4 col-md-offset-1">
					<div class="form-group row" style="background-color:#E3F2FD" >
						<div class="col-md-12" style="margin-top:10px">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryAddress">Address</label>
									<textarea class="form-control" id="entryAddress">{{ $Employee->NewAddress }}</textarea>
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="selectDOB">Date of Birth</label>
									<input disabled value="{{ $Employee->DateOfBirth }}"  id="selectDOB" name="selectDOB" type="date" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryPhone">Mobile Phone</label>
									<input value="{{ $Employee->NewMobilePhone }}" id="entryPhone" name="entryPhone" type="text" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryEmergencyContactName">Emergency Contact Name</label>
									<input id="entryEmergencyContactName" name="entryEmergencyContactName" value="{{ $Employee->NewEmergencyContactName }}" type="text" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryEmergencyContact">Emergency Contact</label>
									<input id="entryEmergencyContact" name="entryEmergencyContact" value="{{ $Employee->NewEmergencyContact }}" type="text" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryEmergencyContactRelationship">Emergency Contact Relationship</label>
									<input id="entryEmergencyContactRelationship" name="entryEmergencyContactRelationship" value="{{ $Employee->NewEmergencyContactRelationship }}" type="text" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryUSDBankName">USD Bank Name</label>
									<input id="entryUSDBankName" name="entryUSDBankName" value="{{ $Employee->USDBankName }}" type="text" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryUSDBankAccount">USD Bank Account Number</label>
									<input id="entryUSDBankAccount" name="USDBankAccount" value="{{ $Employee->USDBankAccount }}" type="text" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryUSDName">USD Bank Account Name</label>
									<input id="entryUSDName" name="entryUSDName" value="{{ $Employee->USDName }}" type="text" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryLocalBankName">Local Bank Name</label>
									<input id="entryLocalBankName" name="entryLocalBankName" value="{{ $Employee->LocalBankName }}" type="text" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryLocalBankAccount">Local Bank Account Number</label>
									<input id="entryLocalBankAccount" name="entryLocalBankAccount" value="{{ $Employee->LocalBankAccount }}" type="text" class="form-control">
								</div>
							</div>	
						</div>
						<div class="col-md-12" style="margin-bottom:45px">
							<div class="form-group row">
								<div class="col-md-12">
									<label for="entryLocalName">Local Bank Account Name</label>
									<input id="entryLocalName" name="entryLocalName" type="text" value="{{ $Employee->LocalName }}" class="form-control">
								</div>
							</div>	
						</div>	
					</div>
				</div>
				<div class="col-md-3 col-md-offset-1">
					<div class="form-group row" style="background-color:#E3F2FD" >
						<div class="col-md-12" style="margin-top:10px">
							<div class="form-group row">
								<div class="col-md-8">
									<label for="fileNationalId">National ID</label>
									<input id="fileNationalId" name="fileNationalId" type="file" class="form-control"/><span class="help-block">File extension .jpg / .png / .pdf</span>
								</div>
								@if($Employee->NationalID != "")
									<div class="col-md-4" style="padding-top:22px" align="right"><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->NationalID).'') }}"><button value="{{ $Employee->NationalID }}" class="btnNationalID btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></div>
								@else
									<div class="col-md-4" style="padding-top:22px" align="right"><button class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="No file uploaded"><i class="fa fa-times fa-1x" aria-hidden="true"></i></button></div>
								@endif
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-8">
									<label for="filePassport">Passport</label>
									<input id="filePassport" name="filePassport" type="file" class="form-control"/><span class="help-block">File extension .jpg / .png / .pdf</span>
								</div>
								@if($Employee->Passport != "")
									<div class="col-md-4" style="padding-top:22px" align="right"><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->Passport).'') }}"><button value="{{ $Employee->Passport }}" class="btnPassport btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></div>
								@else
									<div class="col-md-4" style="padding-top:22px" align="right"><button class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="No file uploaded"><i class="fa fa-times fa-1x" aria-hidden="true"></i></button></div>
								@endif
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-8">
									<label for="fileCV">Curriculum Vitae</label>
									<input id="fileCV" name="fileCV" type="file" class="form-control"/><span class="help-block">File extension .jpg / .png / .pdf</span>
								</div>
								@if($Employee->CV != "")
									<div class="col-md-4" style="padding-top:22px" align="right"><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->CV).'') }}"><button value="{{ $Employee->CV }}" class="btnCV btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></div>
								@else
									<div class="col-md-4" style="padding-top:22px" align="right"><button class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="No file uploaded"><i class="fa fa-times fa-1x" aria-hidden="true"></i></button></div>
								@endif
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-8">
									<label for="fileTaxRegistrationId">Tax Registration ID</label>
									<input id="fileTaxRegistrationId" name="fileTaxRegistrationId" type="file" class="form-control" /><span class="help-block">File extension .jpg / .png / .pdf</span>
								</div>
								@if($Employee->TaxID != "")
									<div class="col-md-4" style="padding-top:22px" align="right"><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->TaxID).'') }}"><button value="{{ $Employee->TaxID }}" class="btnTaxID btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></div>
								@else
									<div class="col-md-4" style="padding-top:22px" align="right"><button class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="No file uploaded"><i class="fa fa-times fa-1x" aria-hidden="true"></i></button></div>
								@endif
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-8">
									<label for="fileKK">Family Registration Card</label>
									<input id="fileKK" name="filePhoto" type="file" class="form-control"/><span class="help-block">File size min. 1MB, file extension .jpg / .png</span>
								</div>
								@if($Employee->FamilyRegistrationCard != "")
									<div class="col-md-4" style="padding-top:22px" align="right"><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->FamilyRegistrationCard).'') }}"><button value="{{ $Employee->FamilyRegistrationCard }}" class="btnFamilyRegistrationCard btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></div>
								@else
									<div class="col-md-4" style="padding-top:22px" align="right"><button class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="No file uploaded"><i class="fa fa-times fa-1x" aria-hidden="true"></i></button></div>
								@endif
							</div>	
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-8">
									<label for="filePhoto">Photo</label>
									<input id="filePhoto" name="filePhoto" type="file" class="form-control"/><span class="help-block">File size min. 1MB, file extension .jpg / .png</span>
								</div>
								@if($Employee->Photo != "")
									<div class="col-md-4" style="padding-top:22px" align="right"><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->Photo).'') }}"><button value="{{ $Employee->Photo }}" class="btnPhoto btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></div>
								@else
									<div class="col-md-4" style="padding-top:22px" align="right"><button class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="No file uploaded"><i class="fa fa-times fa-1x" aria-hidden="true"></i></button></div>
								@endif
							</div>	
						</div>
						<div id="PhotoGAP" class="col-md-12" style="margin-bottom:200px">
							<div class="form-group row">
							</div>
						<div class="col-md-6 col-md-offset-3" style="margin-bottom:50px">	
							<img height="200" width="150" id="ShowImg" name="ShowImg" src="#" alt="your image" />
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row" align="center">
				<button id="buttonSubmit" name="buttonSubmit" class="btn btn-primary">Submit</button>
			</div>
		</div>
		@endforeach
	</div>
	@include('library.foot')