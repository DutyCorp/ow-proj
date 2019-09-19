	@include('library.head')
	<title>Overtime Approval</title>
	<script src="{{asset('js/OvertimeApproval.js')}}"></script>
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
		      	<button type="button" class="btn btn-primary" id="btnAlright">OK</button><button type="button" class="btn btn-primary" id="btnOK">OK</button>
		      </div>
		    </div>
		  </div>
		</div>
		
		<div class="form-group row" style="padding-left:70px; margin-bottom:0px">
			<center><h1>Overtime Approval</h1></center>
		</div>
		<div class="form-group row"></div>
		<div class="form-group row"></div>
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
		<div id="tableApprovalOvertime">
		</div>
	</div>
	@endif
	@endforeach
	@include('library.foot')