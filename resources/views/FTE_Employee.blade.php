	@include('library.head')
	<title>FTE Employee</title>
	<script src="{{asset('js/FTE_Employee.js')}}"></script>
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
						<h1>FTE Employee</h1>
					</center>
				</div>
				<div class="form-group row">
					<div class="col-md-4 col-md-offset-4">
						<div class="form-group row" style="background-color:#E3F2FD">
							<div class="col-md-12" style="padding-top: 30px">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="FTEYear">Year ( yyyy )</label>
										<input type="text" class="form-control" id="FTEYear">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-7">
										<label>View FTE</label>
									</div>
									<div class="col-md-5">
										<button class="btn btn-primary form-control" id="btnViewFTE" name="btnViewFTE">View</button>
									</div>
								</div>
								@if ($rolemenu->Role_I == "1")
									<div class="form-group row">
										<div class="col-md-7">
											<label>Generate FTE</label>
										</div>
										<div class="col-md-5">
											<button class="btn btn-primary form-control" id="btnGenerateFTE" name="btnGenerateFTE">Generate</button>
										</div>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-1 col-md-offset-11"><button id="buttonSaveAll" name="buttonSaveAll" class="btn btn-success form-control">Save All</button></div>
				</div>
				<div id="tableFTE" class="form-group row table-responsive">
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
			</div>
		@endif
	@endforeach
	@include('library.foot')