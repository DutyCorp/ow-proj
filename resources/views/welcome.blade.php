	@include('library.head')
	<title>Home</title>
	<link rel="stylesheet" href="{{asset('css/welcome.css')}}">
	<script src="{{asset('js/commands.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_S == "1")
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
		<div id="notification"></div>
		<div class="container">
			<br>
			@foreach($OparDate as $Opar)
				<span>Last Update : <b>{{ date('d-M-Y', strtotime($Opar->Tr_Date_I)) }}</b> (weekly update)</span>
			@endforeach
			<div class="form-group row">
			@foreach($modulemenus as $modulemenu)
				@if ($modulemenu->MenuPath != "")
					@if ($modulemenu->Role_S == 1)
					<div class="col-md-6 box" id="{{ $modulemenu->MenuPath }}" style="display: none !important;"> 
						<div id="divLoading{{ $modulemenu->MenuPath }}">
							<br /><center><i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:blue"></i></center>
						</div>
					</div>
					@endif
				@endif
			@endforeach
			</div>
			<!--<button class="btn btn-success" id="btnTestEmail">Send Test Email</button>-->
		</div>
		@endif
	@endforeach
	@include('library.foot')