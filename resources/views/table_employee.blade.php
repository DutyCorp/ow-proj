	@include('library.head')
	<title>Employee List</title>
	<script src="{{asset('js/TableEmployee.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_S == "0")
			<script>
				$(function(){
			    	window.location.replace("/");
			    });
			</script>
		@else
	<div id="main" class="container my-custom-container">
		<center><h1>Employee List</h1></center><br><br>
		<div class="modal fade" tabindex="-1" role="dialog" id="Modal_Notification">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h4 class="modal-title" id="ModalHeaderNotification"></h4>
		      </div>
		      <div class="modal-body" id="ModalContentNotification">

		      </div>
		      <div class="modal-footer" id="ModalFooter">
		      	<center>
		      		<button type="button" class="btn btn-success" id="YesDelete">Yes</button>
		      		<button type="button" class="btn btn-danger" id="NoDelete">No</button>
		      	</center>
		      </div>
		    </div>
		  </div>
		</div>
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
		<div id="divLoading">
			<br /><center><i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:blue"></i></center>
		</div>
		<div id="EMPTable" class="form-group row table-responsive">          
  		</div>
	</div>
	@endif
	@endforeach
	@include('library.foot')