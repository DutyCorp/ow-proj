	@include('library.head')
	<title>Occupation Statistics</title>
	<script src="{{asset('js/OccupationStatistic.js')}}"></script>
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
				<h1>Occupation Statistics</h1>
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
								<label id="DefaultInfo" for="PeriodOccupationStatistic">Period</label>
								<label id="Info1" for="PeriodOccupationStatistic">Period ( yyyymm , ex = 201703 )</label>
								<label id="Info2" for="PeriodOccupationStatistic">Period ( yyyyQ(1-4) , ex = 2017Q1 )</label>
								<input type="text" id="PeriodOccupationStatistic" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-10 col-md-offset-1">
								<label for="OccupationStatisticRegion">Region</label>
								<select id="OccupationStatisticRegion" class="form-control">
									<option value="All">All Region</option>
									<option value="Asia">Asia</option>
									@foreach($ListRegion as $Region)
										@if($Region -> RegionID != "AS")
											<option value="{{ $Region -> RegionID }}">{{ $Region -> RegionName }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-7 col-md-offset-1">
								<label for="SelectEmployeeName">Employee</label>
								<select id="SelectEmployeeName" name="SelectEmployeeName" class="form-control">
									<option value="None">Select</option>
									@foreach($ListEmployee as $Employee)
										<option value="{{ $Employee->EmployeeID }}">{{ $Employee->EmployeeName }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-3" style="padding-top:22px">
								<input type="text" disabled id="EmployeeID" name="EmployeeID" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group row"></div>
					<div class="form-group row" align="center">
						<button class="btn btn-primary" id="buttonSubmitOccupationStatistic" name="buttonSubmitOccupationStatistic">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</div>
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
	<div class="form-group row" id="hehe">
		<div class="col-md-8 col-md-offset-2">
			<canvas id="MyChart"><div id="chartjs-tooltip"></div></canvas>
		</div>
	</div>
	@include('library.foot')