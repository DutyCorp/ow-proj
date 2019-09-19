	@include('library.head')
	<title>Occupation Report</title>
	<script src="{{asset('js/OccupationReport.js')}}"></script>
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
						<h1>Occupation Report</h1>
					</center>
				</div>
				<div class="form-group row">
					<div class="col-md-4 col-md-offset-4">
						<div class="form-group row" style="background-color:#E3F2FD">
							<div class="col-md-12">
								<div class="form-group row"></div>
								<div class="form-group row">
									<div class="col-md-4 col-md-offset-1" style="padding-right:0px;"><label>Report Type</label></div>
									<div class="col-md-4" style="padding-left:0px">
										<input type="radio" class="rButton" name="reportType" value="Monthly"><label>Monthly</label>
									</div>
									<div class="col-md-4 col-md-offset-5" style="padding-left:0px">
										<input type="radio" class="rButton" name="reportType" value="Quarterly"><label>Quarterly</label>
									</div>
									<div class="col-md-4 col-md-offset-5" style="padding-left:0px">
										<input type="radio" class="rButton" name="reportType" value="Ytd"><label>Year To Date</label>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-10 col-md-offset-1">
										<label id="DefaultInfo" for="PeriodUtilization">Period</label>
										<label id="Info1" for="PeriodUtilization">Period ( yyyymm , ex = 201703 )</label>
										<label id="Info2" for="PeriodUtilization">Period ( yyyyQ(1-4) , ex = 2017Q1 )</label>
										<input type="text" id="PeriodUtilization" class="form-control">
									</div>
								</div> 
								<div class="form-group row">
									<div class="col-md-4 col-md-offset-1" style="padding-right:0px;"><label>Table Type</label></div>
									<div class="col-md-4" style="padding-left:0px">
										<input type="radio" class="rButton" name="TableType" value="Detail"><label>Detail</label>
									</div>
									<div class="col-md-4 col-md-offset-5" style="padding-left:0px">
										<input type="radio" class="rButton" name="TableType" value="Summary"><label>Summary</label>
									</div>
								</div>
								<div class="form-group row" align="center">
									<button class="btn btn-primary" id="buttonSubmitFilterOccupation" >Submit</button>
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
				<div id="tableUtilization" style="font-size=5px">
				</div>
			</div>
		@endif
	@endforeach
	@include('library.foot')