	@include('library.head')
	<title>Resource Allocation</title>
    <script src="{{asset('js/ResourcePlanning.js')}}"></script>
	<div id="main" class="container">
		<div class="form-group row">
			<center>
				<h1>Resource Planning</h1>
			</center>
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
		<div class="modal fade" tabindex="-1" role="dialog" id="RP_Modal">
		  	<div class="modal-dialog" role="document">
		    	<div class="modal-content">
			      	<div class="modal-header">
			        	<h4 class="modal-title">Upload Resource Planning</h4>
			      	</div>
			      	<div class="modal-body" id="ModalContent">
			      		<div class="form-group row">
			      			<div class="col-md-8">
				      			<input type="file" class="form-control" id="file">
				      		</div>
				      		<div class="col-md-4" >
								<button class="btn btn-primary form-control" id="Upload">Upload</button>
							</div>
			      		</div>
			      		<div class="form-group row">
			      			<center>
			      				<label id="RP_Info"></label>
			      			</center>
			      		</div>
			      		<div class="form-group row" id="Loader">
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
							<br>
				      		<br>
				      		<br>
				      		<br>
				      		<br>
			      		</div>
			      	</div>
			      	<div class="modal-footer" id="ModalFooter">
			      		<button type="button" class="btn btn-primary" id="btnCloseRP">Close</button>
			      	</div>
		    	</div>
		  	</div>
		</div>
		<div class="form-group row">
			<div class="col-md-4 col-md-offset-4">
				<div class="form-group row" style="background-color:#E3F2FD">
					<div class="col-md-12">
						<div class="form-group row" >
							<div class="col-md-6" style="padding-top:10px">
								<label for="DateFrom">Period</label>
								<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="years" data-view="years"  data-date-format="yyyy" id="DateFrom"/>
								<span></span>
							</div>
							<div class="col-md-3" style="padding-top:32px">
								<button class="btn btn-success form-control" id="Set" style="color:black; font-size:12px">Set</button>
							</div>
							<div class="col-md-3" style="padding-top:32px"> 
								<button class="btn btn-default form-control" id="Reset" style="font-size:12px">Reset</button>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<label for="Download">Template</label>
								<button class="btn btn-primary form-control" id="Download" style="color:black">Download</button>
							</div>
							<div class="col-md-6" style="padding-top:22px">
								<button class="btn btn-primary form-control" id="UploadBTN" data-toggle="modal" data-target="#RP_Modal">Upload</button>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<button class="btn btn-primary form-control" id="Versus" data-toggle="modal" data-target="">Budget Versus Actual</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
		
		<div class="form-group row">
			<div class="col-md-12" align="center" id="ResourcePlanningTable">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-12" align="center" id="TableBTN">
				<button id="SaveBTN" class="btn-info btn">Save</button>
				<button id="CancelBTN" class="btn btn-default">Cancel</button>
			</div>
		</div>
	</div>
	@include('library.foot')