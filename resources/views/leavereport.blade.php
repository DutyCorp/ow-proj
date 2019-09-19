	@include('library.head')
	<title>Leave Report</title>
	<script src="{{asset('js/LeaveReport.js')}}"></script>
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
				<h1>Leave Report</h1>
			</center>
		</div>
		<div class="form-group row" style="background-color:#E3F2FD; padding-top:12px">
			<div class="form-group col-md-2">
				<label for="LeaveRegion">Filter by Region</label>
				<select id="LeaveRegion" class="form-control">
					<option value="All">All</option>
					@foreach($ListRegion as $Region)
						@if($Region->RegionID != "AS")
							<option value="{{ $Region->RegionName }}">
								{{ $Region->RegionName }}
							</option>
						@endif
					@endforeach
				</select>
			</div>
			<div class="form-group col-md-1" style="padding-top: 8px; padding-right: 0%; padding-left: 0%; width: 40px;">
				<i class="fa fa-calendar fa-4x" style="color:#3579BD; text-align: right;" aria-hidden="true"></i>
			</div>	
			<div class="form-group col-md-2">
				<label for="LeaveDateFrom">Month From</label>
				<div><input type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy" id="LeaveDateFrom"/></div>
			</div>
			<div class="form-group col-md-2">
				<label for="LeaveDateTo">Month To</label>
				<div><input type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy" id="LeaveDateTo"/></div>
			</div>
			<div class="form-group col-md-1" style="margin-top: 1.2%;">
				<button class="btn btn-primary" id="LeaveSubmitFilter">Submit</button>
			</div>
		</div>
		@foreach($TimesheetDate as $Timesheet)
			<span id="LastUpdate">Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($Timesheet->Tr_Date_I)) }}</b></span>
		@endforeach
		<div id="tableLeave">
			<table id="leaveTable" class="table table-bordered">
				<thead style="background-color:#ECECEC;font-weight:bold">
					<tr>
						<th>Region</th>
						<th>Employee Name</th>
						<th>Annual Leave</th>
						<th>Absence</th>
						<th>Grand Total</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
	</div>
	@include('library.foot')