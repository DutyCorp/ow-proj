	@include('library.head')
	<title>Timesheet Approval</title>
	<script src="{{asset('js/timesheetapprovalcommands.js')}}"></script>
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
		<div class="modal fade bs-example-modal-sm" id="LoadingModal" tabindex="-1" role="dialog" aria-labelledby="LoadingModal">
		  <div class="modal-dialog modal-sm" role="document">
		    <div class="modal-content">
		    	<center><br /><i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:blue"></i> <br /> This may take a few minutes. Sit back and relax<br /></center><br />
		    </div>
		  </div>
		</div>
		<center><h1>Timesheet Approval</h1></center><br><br>
		<div class="form-group row">
			@if ($rolemenu->Role_I == "1")
			<div class="col-md-3 col-md-offset-4 col-sm-4 col-sm-offset-3 col-xs-8"><input id="fileUpload" type="file" class="form-control"></div>
			<div class="col-md-2 col-sm-3 col-xs-4"><button id="btnSubmit" class="btn btn-primary">Submit</button></div>
			@endif
		</div>
		<div class="form-group row">
			<button id="btnBroadcastEmail" class="btn btn-primary col-md-2 col-md-offset-5 col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3">Broadcast Email</button>
			<div id="tableTimesheetApproval"></div>
		</div>
	</div>
	@endif
	@endforeach
	@include('library.foot')