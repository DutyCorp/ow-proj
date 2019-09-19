	@include('library.head')
	<title>Attendance List</title>
	<script src="{{asset('js/AttendanceList.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_S == "0")
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
				      			<button type="button" class="btn btn-primary" id="btnAlright">OK</button><button type="button" class="btn btn-primary" id="btnOK">OK</button>
				    		</div>
						</div>
				  	</div>
				</div>
				<div class="modal fade bs-example-modal-sm" id="LoadingModal" tabindex="-1" role="dialog" aria-labelledby="LoadingModal">
				  	<div class="modal-dialog modal-sm" role="document">
				    	<div class="modal-content">
				    		<div class="form-group row">
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
					    	<br><br><br><br><br>
					    	<div class="form-group row">
					    		<center>This may take a while. Sit back and relax</center>
					    	</div>
				    	</div>
				  	</div>
				</div>
				<div class="form-group row">
					<center>
						<h1>Attendance List</h1>
					</center>
				</div>
				@if ($rolemenu->Role_I == "1" && $rolemenu->Role_S == "1")
					<div class="form-group row" style="background-color:#E3F2FD; padding-top:12px; margin-bottom:0px; padding-left:15px">
						<div class="form-group row">
							<div class="form-group col-md-4">
								<label for="fileUpload">Upload File</label>
								<input type="file" id="fileUpload" name="fileUpload" class="form-control">
							</div>
							<div class="form-group col-md-1" style="padding-top: 8px; padding-right: 0%; padding-left: 0%; width: 35px;">
							
							</div>
							<div class="form-group col-md-2">
								<label for="selectRegion">Region</label>
								<select id="selectRegion" name="selectRegion" class="form-control">
									@foreach($regions as $region)
										@if ($region->RegionID != 'SG' && $region->RegionID != 'TH' && $region->RegionID != 'PH' && $region->RegionID != 'AS')
											<option value="{{ $region->RegionID }}">{{ $region->RegionName }}</option>
										@endif
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-1" style="padding-top: 22px; margin-left: 5px;">
								<button class="btn btn-primary" style="width: 70px; height: 35px;" id="btnUpload"><i class="fa fa-upload fa-1x" aria-hidden="true"></i></button>
							</div>
							<div class="form-group col-md-1" style="padding-top: 22px; padding-right: 0%; padding-left: 0%; width: 40px;" id="divLoading">
								<i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:blue"></i>
							</div>
						</div>
					</div>
				@endif
				@if($rolemenu->Role_S == "1")
					<div class="form-group row" style="background-color:#E3F2FD;">		
						@if ($rolemenu->Role_U == "1")
							<div class="form-group col-md-2">
								<label for="filterRegion">Filter by Region</label>
								<select id="filterRegion" name="filterRegion" class="form-control">
									<option value="All">All Region</option>
										@foreach($regions as $region)
											@if ($region->RegionID != 'SG' && $region->RegionID != 'TH' && $region->RegionID != 'PH' && $region->RegionID != 'AS')
												<option value="{{ $region->RegionID }}">{{ $region->RegionName }}</option>
											@endif
										@endforeach
								</select>
							</div>
						@endif
						<div class="form-group col-md-1" style="padding-top: 8px; padding-right: 0%; padding-left: 0%; width: 40px;">
							<i class="fa fa-calendar fa-4x" style="color:#3579BD; text-align: right;" aria-hidden="true"></i>
						</div>	
						<div class="form-group col-md-2">
							<label for="filterDateFrom">Date from</label>
							<input type='text' class='datepicker-here form-control' data-language='en' data-date-format="dd/mm/yyyy" id="filterDateFrom" name="filterDateFrom">
						</div>
						<div class="form-group col-md-2">
							<label for="filterDateTo">Date to</label>
							<input type='text' class='datepicker-here form-control' data-language='en' data-date-format="dd/mm/yyyy" id="filterDateTo" name="filterDateTo">
						</div>
						<div class="form-group col-md-1" style="padding-top: 22px; margin-left: 7px;">
							<button id="submitFilter" class="btn btn-primary">Submit</button>
						</div>
					</div>
					<div id="table">
					</div>
					<br><br>
				@endif
				<!--<div class="form-group row">
					<div class="col-md-12" align="right">
						<button id="download" class="btn btn-primary"><i class="fa fa-download fa-1x" aria-hidden="true"></i></button></a>
					</div>
				</div>-->
			</div>
		@endif
	@endforeach
	@include('library.foot')