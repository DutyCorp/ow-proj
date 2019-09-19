	@include('library.head')
	<title>Attendance Report</title>
	<script src="{{asset('js/AttendanceReport.js')}}"></script>
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
						<h1>Attendance Report</h1>
					</center>
				</div>
				<div class="form-group row" style="height:35px;">
					<div class="col-md-2" style="padding-left:0px">
						<h3>Region Chart</h3>
					</div>
				</div>
				<div class="form-group row" style="padding-top:12px; background-color:#E3F2FD">
					<div class="form-group col-md-3">
						<label for="selectRegion">Filter by Region</label>
						<select id="selectRegion" name="selectRegion" class="form-control">
							<option value="All">All Region</option>
							<option value="Asia">Asia</option>
							@foreach($regions as $region)
								@if ($region->RegionID != 'SG' && $region->RegionID != 'TH' && $region->RegionID != 'PH' && $region->RegionID != 'AS')
									<option value="{{ $region->RegionID }}">{{ $region->RegionName }}</option>
								@endif
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-1" style="padding-top: 8px; padding-right: 0%; padding-left: 0%; width: 40px;">
						<i class="fa fa-calendar fa-4x" style="color:#3579BD" aria-hidden="true"></i>
					</div>	
					<div class="form-group col-md-2">
						<label for="filterDatefrom">Date from</label>
						<input id="filterDatefrom" type="text" class="datepicker-here form-control" data-language='en' data-date-format="d/m/yyyy"/>
					</div>
					<div class="form-group col-md-2">
						<label for="filterDateto">Date to</label>
						<input id="filterDateto" type="text" class="datepicker-here form-control" data-language='en' data-date-format="d/m/yyyy"/>
					</div>
					<div class="form-group col-md-1" style="padding-top: 22px;">
						<button id="btnSubmitRegion" class="btn btn-primary">Submit</button>
					</div>
				</div>
				<div id="regionLoader" class="form-group row">
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
				<div class="form-group row">
					<p style="text-align: center;" id="regionError"></p>
					<div class="col-md-8 col-md-offset-2">
						<canvas id="RegionChart"><div id="chartjs-tooltip"></div></canvas>
					</div>
				</div>
				<div>
					<hr style="border-top: 5px double #8c8b8b;">
				</div>
				<div class="form-group row"></div>
				<div class="form-group row" style="height:35px;">
					<div class="col-md-3" style="padding-left:0px">
						<h3>Individual Chart</h3>
					</div>
				</div>
				<div class="form-group row" style="padding-top:12px; background-color:#E3F2FD">
					<div class="form-group col-md-3" id="divFilterName">
						<label for="filterName">Filter by Name</label>
						<select id="filterName" name="filterName" class="form-control">
							<option value="None">None</option>
						</select>
					</div>
					<div class="form-group col-md-2" id="divLoadingName">
							<br /><i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:blue"></i>
						</div>
					<div class="form-group col-md-1" style="padding-top: 8px; padding-right: 0%; padding-left: 0%; width: 40px;">
						<i class="fa fa-calendar fa-4x" style="color:#3579BD" aria-hidden="true"></i>
					</div>	
					<div class="form-group col-md-2">
						<label for="filterDatefromIndividual">Date from</label>
						<input id="filterDatefromIndividual" type="text" class="datepicker-here form-control" data-language='en' data-date-format="d/m/yyyy"/>
					</div>
					<div class="form-group col-md-2">
						<label for="filterDatetoIndividual">Date to</label>
						<input id="filterDatetoIndividual" type="text" class="datepicker-here form-control" data-language='en' data-date-format="d/m/yyyy"/>
					</div>
					<div class="form-group col-md-1" style="padding-top: 22px;">
						<button id="btnSubmitIndividual" class="btn btn-primary">Submit</button>
					</div>
				</div>
				<div id="individualLoader" class="form-group row">
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
				<div class="form-group row">
					<p style="text-align: center;" id="individualError"></p>
					<div class="col-md-8 col-md-offset-2">
						<canvas id="individualChart"><div id="chartjs-tooltip"></div></canvas>
					</div>
				</div>
			</div>
		@endif
	@endforeach
	@include('library.foot')
