	@include('library.head')
	<title>User Update</title>
	<script src="{{asset('js/employeesettingcommands.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_U == "0")
			<script>
				$(function(){
			    	window.location.replace("/");
			    });
			</script>
		@else
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
				<div class="form-group row">
					<center>
						<h1>User Update</h1>
					</center>
				</div>
				@foreach($users as $user)
					<div class="form-group row">
						<div class="col-md-7">
							<div class="form-group row" style="background-color:#E3F2FD" >
								<div class="col-md-12" style="padding-top: 10px">
									<div class="form-group row">
										<div class="col-md-3">Employee ID</div>
										<div class="col-md-9"><b id="divEmployeeID" value="{{ $user->EmployeeID }}">{{ $user->EmployeeID }}</b></div>
									</div>
									<div class="form-group row">
										<div class="col-md-3">Employee Name</div>
										<div class="col-md-9"><b>{{ $user->EmployeeName }}</b></div>
									</div>
									<div class="form-group row">
										<div class="col-md-3">Role</div>
										<div class="col-md-9">
											<select id="role" name="Role" class="form-control">
												@foreach ($roles as $role)
												<option value="{{ $role->RoleID }}">{{ $role->RoleName }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<input type="hidden" id="gradeid" value="{{ $user->GradeID }}">
									<input type="hidden" id="roleid" value="{{ $user->RoleID }}">
									<input type="hidden" id="departmentid" value="{{ $user->DepartmentID }}">
									<input type="hidden" id="positionid" value="{{ $user->PositionID }}">
									<input type="hidden" id="regionid" value="{{ $user->RegionID }}">
									<div class="form-group row">
										<div class="col-md-3">
											Role Access
										</div>
										<div class="col-md-9" id="roleAccessTableDiv" >
											<table id="tableRoleAccess" class="table table-bordered" style="font-size: 12px; background-color: #FFFFFF;">
												<thead>
													<tr>
														<td>Menu</td>
														<td>Sub Menu</td>
														<td>Menu Child</td>
														<td>Show</td>
														<td>Insert</td>
														<td>Update</td>
														<td>Delete</td>
													</tr>
												</thead>
												<tbody>
													@foreach($menus as $menu)	
													<tr id="{{ $menu->MenuChildID }}" value="{{ $menu->MenuChildID }}">
														<td>{{ $menu->MenuParentName }}</td>
														<td>{{ $menu->SubMenuName }}</td>
														<td>{{ $menu->MenuChildName }}</td>
														<td><input type="checkbox" disabled id="s"></td>
														<td><input type="checkbox" disabled id="i"></td>
														<td><input type="checkbox" disabled id="u"></td>
														<td><input type="checkbox" disabled id="d"></td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
										<div class="col-md-6" id="divLoading">
											<div class="loader">
												<div class="loader-inner">
													<div class="loader-line-wrap">
														<div class="loader-line"></div>
													</div>
													<div class="loader-line-wrap">
														<div class="loader-line"></div>
													</div>
													<div class="loader-line-wrap">
														<div class="loader-line"></div>
													</div>
													<div class="loader-line-wrap">
														<div class="loader-line"></div>
													</div>
													<div class="loader-line-wrap">
														<div class="loader-line"></div>
													</div>
													<div class="loader-line-wrap">
														<div class="loader-line"></div>
													</div>
													<div class="loader-line-wrap">
														<div class="loader-line"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-md-offset-1">
							<div class="form-group row" style="background-color:#E3F2FD" >
								<div class="col-md-12" style="padding-top: 10px; margin-bottom:98px">
									<div class="form-group row">
										<div class="col-md-4">Region Visibility</div>
										<div class="col-md-8">
											@foreach($regions as $region)
												<div>
													<input type="checkbox" class="cbxRegion" value="{{ $region->RegionID }}" disabled> {{ $region->RegionName }}
												</div>
											@endforeach			
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Grade</div>
										<div class="col-md-8">
											<select id="selectGrade" name="selectGrade" class="form-control">
												@foreach ($grades as $grade)
													<option value="{{ $grade->GradeID }}">{{ $grade->GradeName }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Email</div>
										<div class="col-md-8"><input type="text" class="form-control" id="txtEmail" value="{{ $user->Email }}"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Username</div>
										<div class="col-md-8"><input type="text" class="form-control" id="txtUsername" value="{{ $user->Username }}"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Department</div>
										<div class="col-md-8">
											<select id="selectDepartment" name="selectDepartment" class="form-control">
												@foreach ($departments as $department)
													<option value="{{ $department->DepartmentID }}">{{ $department->DepartmentName }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Region</div>
										<div class="col-md-8">
											<select id="selectRegion" name="selectRegion" class="form-control">
												@foreach ($regions as $region)
													@if ($region->RegionID != 'AS')
														<option value="{{ $region->RegionID }}">{{ $region->RegionName }}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Start Working Date</div>
										<div class="col-md-8"><input type='text' class='datepicker-here form-control' data-language='en' data-date-format="dd/mm/yyyy" id="dtStart" name="dtStart" value="{{ date('d/m/Y', strtotime($user->StartWorkingDate)) }}"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Date of Birth</div>
										<div class="col-md-8"><input type='text' class='datepicker-here form-control' data-language='en' data-date-format="dd/mm/yyyy" id="dtDOB" name="dtDOB" value="{{ date('d/m/Y', strtotime($user->DateOfBirth)) }}"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Position</div>
										<div class="col-md-8">
											<select id="selectPosition" name="selectPosition" class="form-control">
												@foreach ($positions as $position)
													<option value="{{ $position->PositionID }}">{{ $position->PositionName }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Mobile Phone</div>
										<div class="col-md-8"><input type="text" class="form-control" value="{{ $user->MobilePhone }}" id="txtMobilePhone"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Skype ID</div>
										<div class="col-md-8"><input type="text" class="form-control" id="txtSkypeID" value="{{ $user->SkypeID }}"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">National ID</div>
										<div class="col-md-8"><input type="file" class="form-control" id="fileNationalId" name="fileNationalId"/><span class="help-block">File extension .jpg, .png, .pdf</span></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Tax Registration ID</div>
										<div class="col-md-8"><input type="file" class="form-control" id="fileTaxRegistrationId" name="fileTaxRegistrationId"/><span class="help-block">File extension .jpg, .png, .pdf</span></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Passport</div>
										<div class="col-md-8"><input type="file" class="form-control" id="filePassport" name="filePassport"/><span class="help-block">File extension .jpg, .png, .pdf</span></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Photo</div>
										<div class="col-md-8"><input type="file" class="form-control" id="filePhoto" name="filePhoto"/><span class="help-block">File size min. 1MB, file extension .jpg</span></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Curriculum Vitae</div>
										<div class="col-md-8"><input type="file" class="form-control" id="fileCV" name="fileCV"/><span class="help-block">File extension .jpg, .png, .pdf</span></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Family Registration Card</div>
										<div class="col-md-8"><input type="file" class="form-control" id="fileKK" name="fileKK"/><span class="help-block">File extension .jpg, .png, .pdf</span></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Termination Date</div>
										<div class="col-md-8"><input type='text' class='datepicker-here form-control' data-language='en' data-date-format="dd/mm/yyyy" id="dtTermination" name="dtTermination" value="{{ date('d/m/Y', strtotime($user->TerminationDate)) }}"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Address</div>
										<div class="col-md-8"><textarea class="form-control" id="txtAddress">{{ $user->Address }}</textarea></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Emergency Contact</div>
										<div class="col-md-8"><input type="text" class="form-control" value="{{ $user->EmergencyContact }}" id="txtEmergencyContact"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Emergency Contact Name</div>
										<div class="col-md-8"><input type="text" class="form-control" value="{{ $user->EmergencyContactName }}" id="txtEmergencyContactName"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Emergency Contact Relationship</div>
										<div class="col-md-8"><input type="text" class="form-control" value="{{ $user->EmergencyContactRelationship }}" id="txtEmergencyContactRelationship"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">USD Bank Name</div>
										<div class="col-md-8"><input type="text" class="form-control" value="{{ $user->USDBankName }}" id="txtUSDBankName"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">USD Bank Account Number</div>
										<div class="col-md-8"><input type="text" class="form-control" value="{{ $user->USDBankAccount }}" id="txtUSDBankAccount"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">USD Bank Account Name</div>
										<div class="col-md-8"><input type="text" class="form-control" value="{{ $user->USDName }}" id="txtUSDName"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Local Bank Name</div>
										<div class="col-md-8"><input type="text" class="form-control" value="{{ $user->LocalBankName }}" id="txtLocalBankName"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Local Bank Account Number</div>
										<div class="col-md-8"><input type="text" class="form-control" value="{{ $user->LocalBankAccount }}" id="txtLocalBankAccount"></div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">Local Bank Account Name</div>
										<div class="col-md-8"><input type="text" class="form-control" value="{{ $user->LocalName }}" id="txtLocalName"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
				<div class="form-group row" align="center">
					<button class="btn btn-success" id="btnSubmit">Submit</button>
					<button class="btn btn-danger" id="btnCancel">Cancel</button>
				</div>
			</div>
		@endif
	@endforeach
	@include('library.foot')