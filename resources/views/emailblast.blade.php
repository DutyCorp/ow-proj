	@include('library.head')
	<title>Email Blast</title>
	<script src="{{asset('js/emailblastcommands.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_S == "0")
			<script>
				$(function(){
			    	window.location.replace("/");
			    });
			</script>
		@else
	<div id="main" class="container">
		<div class="modal fade bs-example-modal-sm" id="LoadingModal" tabindex="-1" role="dialog" aria-labelledby="LoadingModal">
		  	<div class="modal-dialog modal-sm" role="document">
			    <div class="modal-content">
			    	<center>
			    		<br />
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
						<br /><br /><br /><br /><br />
			    		<br /> This may take a while. Sit back and relax<br />
			    	</center>
			    	<br />
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
		<div class="modal fade" tabindex="-1" role="dialog" id="ModalTo">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="ModalToHeader">To</h4>
					</div>
					<div class="modal-body" id="ModalToContent" style="overflow-y: scroll; height:400px;">
						<table id="employeeTo" class="table table-bordered" style="font-size: 12px">
							<thead>
								<tr>
									<th>Check</th>
									<th>Employee Name</th>
								</tr>
							</thead>
							<tbody>
							@foreach($ListEmployee as $Employee)
							<tr>
								<td><input type="checkbox" class="cbxTo" value="{{ $Employee->EmployeeID }}"></td>
								<td><p>{{ $Employee->EmployeeName }}</p></td>
							</tr>
							@endforeach	
							</tbody>
						</table>
					</div>
					<div class="modal-footer" id="ModalToFooter">
						<button type="button" class="btn btn-primary" id="btnSaveTo">Save</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="ModalCc">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="ModalCcHeader">CC</h4>
					</div>
					<div class="modal-body" id="ModalCcContent" style="overflow-y: scroll; height:400px;">
						<table id="employeeCc" class="table table-bordered" style="font-size: 12px">
							<thead>
								<tr>
									<th>Check</th>
									<th>Employee Name</th>
								</tr>
							</thead>
							<tbody>
							@foreach($ListEmployee as $Employee)
							<tr>
								<td><input type="checkbox" class="cbxCc" value="{{ $Employee->EmployeeID }}"></td>
								<td><p>{{ $Employee->EmployeeName }}</p></td>
							</tr>
							@endforeach	
							</tbody>
						</table>
					</div>
					<div class="modal-footer" id="ModalCcFooter">
						<button type="button" class="btn btn-primary" id="btnSaveCc">Save</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade bs-example-modal-sm" id="LoadingModal" tabindex="-1" role="dialog" aria-labelledby="LoadingModal">
		  	<div class="modal-dialog modal-sm" role="document">
		    	<div class="modal-content">
		    		<center><br /><i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:blue"></i> <br /> This may take a few minutes. Sit back and relax<br /></center><br />
		    	</div>
		  	</div>
		</div>
		<div class="form-group row">
			<center>
				<h1>Email Blast</h1>
			</center>
		</div>
		<div class="form-group row">
			<div class="col-md-4 col-md-offset-4">
				<div class="form-group row" style="background-color:#E3F2FD" >
					<div class="col-md-12" style="padding-top: 10px">
						<div class="form-group row">
							<div class="col-md-12">
								<label for="selectRegion">Region</label>
								<select id="selectRegion" class="form-control">
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
							<div class="col-md-4">
								<label for="btnTo">To</label>
								<button id="btnTo" class="btn btn-primary form-control">Add</button>
							</div>
							<div class="col-md-8" style="padding-top:22px">
								<p class="form-control">(<b id="totalTo">0</b> selected)</p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label for="btnCC">Cc</label>
								<button id="btnCC" class="btn btn-primary form-control">Add</button>
							</div>
							<div class="col-md-8"  style="padding-top:22px">
								<p class="form-control">(<b id="totalCc">0</b> selected)</p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label for="txtSubject">Subject</label>
								<input type="text" id="txtSubject" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label for="txtBodyEmail">Body Email</label>
								<textarea id="txtBodyEmail" placeholder="(no need to put greeting text e.g. Dear Eli Suryani)" class="form-control" rows="10" cols="50"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label for="fileAttachment">Attachment (hold Ctrl and click to select multiple files)</label>
								<input id="fileAttachment" type="file" class="form-control" multiple>
							</div>
						</div>
						<div class="form-group row" align="center">
							<button id="btnSend" class="btn btn-primary">Send</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="table"></div>
	</div>
	@endif
	@endforeach
	@include('library.foot')