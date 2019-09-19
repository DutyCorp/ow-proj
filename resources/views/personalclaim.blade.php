	@include('library.head')
	<title>Personal Claim Report</title>
	<script src="{{asset('js/personalclaimreportcommands.js')}}"></script>
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
			<center><h1>Personal Claim Report</h1></center>
			<div class="form-group row"></div>
			<div class="form-group row"></div>
			@if ($Status == '0')
				<input type="hidden" id="selectClaimEmployee" value="{{ session()->get('EmployeeID') }}">
			@else
			<div class="form-group row">
				<div class="col-md-4 col-md-offset-4"> 
					<div class="form group row" style="background-color:#E3F2FD">
						<div class="col-md-12" style="padding-top: 30px">
							<div class="form-group row">
								<div class="col-md-12">Employee</div>
								<div class="col-md-12">
									<select id="selectClaimEmployee" class="form-control">
										@foreach($ListEmployee as $Employee)
											<option value="{{ $Employee->EmployeeID }}">{{ $Employee->EmployeeName }}</option>
										@endforeach
									</select>
								</div>
							</div>
							@endif
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
							<div class="form-group row" align="center">
								<button class="btn btn-primary" id="btnSubmitPersonalClaimReport" name="btnSubmitPersonalClaimReport">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="divLoading">
				<br /><center><i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:blue"></i></center>
			</div>
			<div id="tablePersonalClaimReport">
				
			</div>
		</div>
		@endif
	@endforeach
	@include('library.foot')