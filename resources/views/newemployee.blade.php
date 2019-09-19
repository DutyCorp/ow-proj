	@include('library.head')
	<div id="main" class="container">
		<center><h1>Add Employee</h1></center><br><br>
		<div class="form-group row">
			<div class="col-md-2 col-md-offset-1">Employee ID</div>
			<div class="col-md-3"><input type="text" class="form-control"></div>
			<div class="col-md-2">Position</div>
			<div class="col-md-3"><input type="text" class="form-control"></div>
		</div>
		<div class="form-group row">
			<div class="col-md-2 col-md-offset-1">Employee Name</div>
			<div class="col-md-3"><input type="text" class="form-control"></div>
			<div class="col-md-2">Mobile Phone</div>
			<div class="col-md-3"><input type="text" class="form-control"></div>
		</div>
		<div class="form-group row">
			<div class="col-md-2 col-md-offset-1">Email</div>
			<div class="col-md-3"><input type="text" class="form-control"></div>
			<div class="col-md-2">Skype ID</div>
			<div class="col-md-3"><input type="text" class="form-control"></div>
		</div>
		<div class="form-group row">
			<div class="col-md-2 col-md-offset-1">Username</div>
			<div class="col-md-3">Auto Generated</div>
			<div class="col-md-2">National ID</div>
			<div class="col-md-3"><input type="file" class="form-control" id="fileNationalId" name="fileNationalId"/><span class="help-block">File size min. 1MB, file extension .jpg</span></div>
		</div>
		<div class="form-group row">
			<div class="col-md-2 col-md-offset-1">Password</div>
			<div class="col-md-3"><input type="password" class="form-control"></div>
			<div class="col-md-2">Tax Registration ID</div>
			<div class="col-md-3"><input type="file" class="form-control" id="fileTaxRegistrationId" name="fileTaxRegistrationId"/><span class="help-block">File size min. 1MB, file extension .jpg</span></div>
		</div>
		<div class="form-group row">
			<div class="col-md-2 col-md-offset-1">Role</div>
			<div class="col-md-3">
				<select id="role" name="selectRole" class="form-control">
					<option value="R00">Admin</option>
					<option value="R01">Group Manager</option>
					<option value="R02">Manager</option>
					<option value="R03">Consultant</option>
					<option value="R04">Backoffice</option>
					<option value="R05">Sales</option>
				</select>
			</div>
			<div class="col-md-2">Passport</div>
			<div class="col-md-3"><input type="file" class="form-control" id="filePassport" name="filePassport"/><span class="help-block">File size min. 1MB, file extension .jpg</span></div>
		</div>
		<div class="form-group row">
			<div class="col-md-2 col-md-offset-1">Region</div>
			<div class="col-md-3">
				<select id="role" name="selectRegion" class="form-control">
					<option value="ID">Indonesia</option>
					<option value="VN">Vietnam</option>
					<option value="MY">Malaysia</option>
					<option value="SG">Singapore</option>
				</select>
			</div>
			<div class="col-md-2">Photo</div>
			<div class="col-md-3"><input type="file" class="form-control" id="filePhoto" name="filePhoto"/><span class="help-block">File size min. 1MB, file extension .jpg</span></div>
		</div>
		<div class="form-group row">
			<div class="col-md-2 col-md-offset-1">Department</div>
			<div class="col-md-3">
				<select id="role" name="selectDepartment" class="form-control">
					<option value="D01">Management</option>
					<option value="D02">Business Development</option>
					<option value="D03">HR & Operation</option>
					<option value="D04">Delivery</option>
					<option value="D05">Finance & Legal</option>
				</select>
			</div>
			<div class="col-md-2">Curriculum Vitae</div>
			<div class="col-md-3"><input type="file" class="form-control" id="fileCV" name="fileCV"/><span class="help-block">File size min. 1MB, file extension .jpg</span></div>
		</div>
		<div class="form-group row">
			<div class="col-md-2 col-md-offset-1">Start Working Date</div>
			<div class="col-md-3"><input type="date" class="form-control" id="dtStart"></div>
		</div>
		<div class="form-group row"></div>
		<div class="form-group row" align="center">
			<button class="btn btn-primary">Submit</button> <button class="btn btn-default">Cancel</button> <button class="btn btn-link">Reset</button>
		</div>
		<div class="form-group row"></div>
	</div>
</body>
</html>