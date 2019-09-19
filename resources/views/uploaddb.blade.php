	@include('library.head')
	<title>Upload Database</title>
	<script src="{{asset('js/UploadDB.js')}}"></script>
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
				    		<center><br /><i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:blue"></i> <br /> This may take a while. Sit back and relax<br /></center><br />
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
				<center><h1>Upload Database</h1></center>
				<div class="form-group row"></div>
				<div class="form-group row"></div>
				@if ($rolemenu->Role_I == "1")
					<div class="form-group row">
						<div class="col-md-10 col-md-offset-1" style="right:-8%">
							<div class="form-group row" style="width:80%; background-color:#E3F2FD" >
								<div class="col-md-12">
									<div class="form-group row">
										<div class="col-md-6" style="padding-top:20px">
											<label for="uploadOpar">OPAR</label>
											<input type="file" id="uploadOpar" name="uploadOpar" class="form-control">
										</div>
										<div class="col-md-2" style="padding-top:42px">
											<button id="submitOpar" class="btn btn-primary">Upload</button>
										</div>
										<div class="col-md-4" style="padding-top:50px">
											@foreach($OparDate as $Opar)
												<span>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($Opar->Tr_Date_I)) }}</b></span>
											@endforeach
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6" style="padding-top:20px">
											<label for="uploadTimesheetYearly">Timesheet Yearly</label>
											<input type="file" id="uploadTimesheetYearly" name="uploadTimesheetYearly" class="form-control">
										</div>
										<div class="col-md-2" style="padding-top:42px">
											<button id="submitTimesheetYearly" class="btn btn-primary">Upload</button>
										</div>
										<div class="col-md-4" style="padding-top:50px">
											@foreach($TimesheetDate as $Timesheet)
												<span>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($Timesheet->Tr_Date_I)) }}</b></span>
											@endforeach
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6" style="padding-top:20px">
											<label for="uploadProfitability">Profitability</label>
											<input type="file" id="uploadProfitability" name="uploadProfitability" class="form-control">
										</div>
										<div class="col-md-2" style="padding-top:42px">
											<button id="submitProfitability" class="btn btn-primary">Upload</button>
										</div>
										<div class="col-md-4" style="padding-top:50px">
											@foreach($ProfitabillityDate as $Profitabillity)
												<span>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($Profitabillity->LatestUpdate)) }}</b></span>
											@endforeach
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6" style="padding-top:20px">
											<label for="uploadProject">Project</label>
											<input type="file" id="uploadProject" name="uploadProject" class="form-control">
										</div>
										<div class="col-md-2" style="padding-top:42px">
											<button id="submitProject" class="btn btn-primary">Upload</button>
										</div>
										<div class="col-md-4" style="padding-top:50px">
											@foreach($ProjectDate as $Project)
												<span>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($Project->Tr_Date_I)) }}</b></span>
											@endforeach
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6" style="padding-top:20px">
											<label for="uploadClaim">Claim</label>
											<input type="file" id="uploadClaim" name="uploadClaim" class="form-control">
										</div>
										<div class="col-md-2" style="padding-top:42px">
											<button id="submitClaim" class="btn btn-primary">Upload</button>
										</div>
										<div class="col-md-4" style="padding-top:50px">
											@foreach($ClaimDate as $Claim)
												<span>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($Claim->LatestUpdate)) }}</b></span>
											@endforeach
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6" style="padding-top:20px">
											<label for="uploadAging">Aging</label>
											<input type="file" id="uploadAging" name="uploadAging" class="form-control">
										</div>
										<div class="col-md-2" style="padding-top:42px">
											<button id="submitAging" class="btn btn-primary">Upload</button>
										</div>
										<div class="col-md-4" style="padding-top:50px">
											@foreach($AgingDate as $Aging)
												<span>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($Aging->LatestUpdate)) }}</b></span>
											@endforeach
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
		@endif
	@endforeach
	@include('library.foot')