	@include('library.head')
	<title>Project Profitabillity Summary</title>
	<script src="{{asset('js/Profitabillity.js')}}"></script>
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
				<h1>Project Profitabillity Summary</h1>
			</center>
		</div>
		<div class="form-group row">
			<div class="col-md-4 col-md-offset-4">
				<div class="form-group row" style="background-color:#E3F2FD" >
					<div class="col-md-12">
						<div class="form-group row">
							<div class="col-md-12" style="padding-top:10px">
								<label for="profitabillityRegion">Region</label>
								<select id="profitabillityRegion" class="form-control">
									<option value="All">All</option>
									@foreach($ListRegion as $Region)
										@if($Region->RegionID != "AS")
											<option value="{{ $Region->RegionID }}">
												{{ $Region->RegionName }}
											</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12" style="padding-top:20px">
								<label for="profitabillityContractStatus">Contract Status</label>
								<select id="profitabillityContractStatus" class="form-control">
									<option>All</option>
									@foreach($ListContractStatus as $ContractStatus)
										<option value="{{ $ContractStatus->ContractStatus }}">
											{{ $ContractStatus->ContractStatus }}
										</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12" style="padding-top:20px">
								<label for="profitabillityPositionType">Position Type</label>
								<select id="profitabillityPositionType" class="form-control">
									<option value="All">All</option>
									<option value="Licenses">Licenses</option>
									<option value="Service">Service</option>
									<option value="Maintenance">Maintenance</option>
								</select>
							</div>
						</div>
						<input type="hidden" id="PageType" value="Summary">
						<div class="form-group row" align="center">
							<button class="btn btn-primary" id="buttonSubmitFilterProfitabillity" >Submit</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="Legend">
			<div class="form-group row">
				<div class="col-md-1" style="width: 20px; height: 20px; border: 1px solid rgba(0, 0, 0, .2); background: #f44256;"></div>
				<div class="col-md-2"><label>>= 100%</label></div>
			</div>
			<div class="form-group row">
				<div class="col-md-1" style="width: 20px; height: 20px; border: 1px solid rgba(0, 0, 0, .2); background: #f1f441;"></div>
				<div class="col-md-2"><label>>= 75%</label></div>
			</div>
			<div class="form-group row">
				1. *) Travel cost is actual claim from hotel, flight, per-diem, entertainment, transport<br>
				2. Other cost is actual Royalty, 3rd Party and Tax<br>
				3. MDCost is MDPosted x USD {{ $MDCost }} (default)
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
		<div id="tableProfitabillity" style="font-size=5px">
		</div>
	</div>
	@include('library.foot')