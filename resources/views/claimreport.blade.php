	@include('library.head')
	<title>Claim Report</title>
	<script src="{{asset('js/claimreportcommands.js')}}"></script>
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
				      			<button type="button" class="btn btn-primary" id="btnAlright">OK</button>
				      		</div>
				    	</div>
				  	</div>
				</div>
				<div class="form-group row">
					<center>
						<h1>Claim Report</h1>
					</center>
				</div>
				<div class="form-group row">
					<div class="col-md-4 col-md-offset-4">
						<div class="form-group row" style="background-color:#E3F2FD" >
							<div class="col-md-12" style="padding-top: 30px">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="selectClaimRegion">Region</label>
										<select id="selectClaimRegion" class="form-control">
											<option value="All">All</option>
											@foreach($ListRegion as $Region)
												@if($Region -> RegionID != "AS")
													<option value="{{ $Region->RegionID }}">{{ $Region -> RegionName }}</option>
												@endif
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-6">
										<label for="SubmissionPeriodFrom">Submission Period<p style="color: red; font-size: 9px;">(Processed by Travel Coordinator)</p></label>
										<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy" id="SubmissionPeriodFrom"/>
										<span>From</span>
									</div>
									<div class="col-md-6" style="padding-top:44px">
										<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy" id="SubmissionPeriodTo"/>
										<span>To</span>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-6">
										<label for="SubmissionPeriodFrom">Approval Period<p style="color: red; font-size: 9px;">(Processed by Finance Accounting)</p></label>
										<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy" id="ApprovalPeriodFrom"/>
										<span>From</span>
									</div>
									<div class="col-md-6" style="padding-top:44px">
										<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy" id="ApprovalPeriodTo"/>
										<span>To</span>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-6">
										<label>View By</label>
									</div>
									<div class="col-md-6">
										<input type="radio" name="ViewType" value="Project">Project<br>
									</div>
									<div class="col-md-6 col-md-offset-6">
										<input type="radio" name="ViewType" value="Employee">Employee<br>
									</div>
									<div class="col-md-6 col-md-offset-6">
										<input type="radio" name="ViewType" value="TEType">Expense Type<br>
									</div>
									<div class="col-md-6 col-md-offset-6">
										<input type="radio" name="ViewType" value="Department">Department
									</div>
								</div>
								<div class="form-group row" align="center">
									<button class="btn btn-primary" id="btnSubmitClaimReport" name="btnSubmitClaimReport">Submit</button>
								</div>
							</div>
						</div>
					</div>
				</div>		
				<div id="divLoading">
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
				<div id="tableClaimReport">
				</div>
			</div>
		@endif
	@endforeach
	@include('library.foot')