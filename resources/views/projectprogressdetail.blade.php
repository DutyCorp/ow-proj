	@include('library.head')
	<title>Project Progress Detail</title>
	<script src="{{asset('js/projectprogressdetailcommands.js')}}"></script>
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
						<h1>Project Progress Detail</h1>
					</center>
				</div>
				<div class="form-group row">
					<div class="col-md-4 col-md-offset-4">
						<div class="form-group row" style="background-color:#E3F2FD" >
							<div class="col-md-12">
								<div class="form-group row" style="padding-top:10px">
									<div class="col-md-12">
										<label for="selectProjectRegion">Project Region</label>
										<select id="selectProjectRegion" class="form-control">
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
									<div class="col-md-12">
										<label for="selectPositionType">Position Type</label>
										<select id="selectPositionType" class="form-control">
											<option value="All">All</option>
											@foreach($ListPositionType as $PositionType)
												@if($PositionType->PositionType != "")
													<option value="{{ $PositionType->PositionType }}">{{ $PositionType->PositionType }}</option>
												@endif 
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label for="selectProjectStatus">Project Status</label>
										<select id="selectProjectStatus" class="form-control">
											<option value="All">All</option>
											@foreach($ListProjectStatus as $ProjectStatus)
												@if($ProjectStatus->ProjectStatus != "")
													<option value="{{ $ProjectStatus->ProjectStatus }}">{{ $ProjectStatus->ProjectStatus }}</option>
												@endif
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-6">
										<label for="LeaveDateFrom">Project Closure</label>
										<div>
											<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy" id="DateFrom"/>
										</div>
										<label for="LeaveDateFrom">From</label>
									</div>
									<div class="col-md-6" style="padding-top:22px">
										<div>
											<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy" id="DateTo"/>
										</div>
										<label for="LeaveDateTo">To</label>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label for="selectContractStatus">Contract Status</label>
										<select id="selectContractStatus" class="form-control">
											<option value="All">All</option>
											@foreach($ListContractStatus as $ContractStatus)
												@if($ContractStatus->ContractStatus != "")
													<option value="{{ $ContractStatus->ContractStatus }}">{{ $ContractStatus->ContractStatus }}</option>
												@endif
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row" align="center">
									<button class="btn btn-primary" id="buttonSubmitProjectProgress">Submit</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="divLegend">
					<span>Legend : </span>
					<div>
						<span>MDLeft (%) : </span>
						<div style="width: 20px; height: 20px; border: 1px solid rgba(0, 0, 0, .2); background: #f44256; display: inline-block;"></div> <label> < 0 Md</label>
					</div>
					<div>
						<span>MDSpent (%) : </span>
						<div style="width: 20px; height: 20px; border: 1px solid rgba(0, 0, 0, .2); background: #F4D03F; display: inline-block;"></div> <label> >= 75%</label>
						<div style="width: 20px; height: 20px; border: 1px solid rgba(0, 0, 0, .2); background: #f44256; display: inline-block;"></div> <label> > 100%</label>
					</div>
					<div>
						<span>Invoiced (%) : </span>
						<div style="width: 20px; height: 20px; border: 1px solid rgba(0, 0, 0, .2); background: #f44256; display: inline-block;"></div> <label> < 100%</label>
					</div>
				</div>
				<div id="divLoading">
					<br /><center><i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:blue"></i></center>
				</div>
				<div class="form-group row">
					<div id="tableProjectProgress">
					</div>
				</div>
			</div>
		@endif
	@endforeach
	@include('library.foot')