	@include('library.head')
	<title>Change Password</title>
	<script src="{{asset('js/ChangePassword.js')}}"></script>
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
			<div class="col-md-4 col-md-offset-4 box" style="margin-top: 5%; background-color:#E3F2FD;">
				<div class="col-md-10 col-md-offset-1" style="text-align: center; border: none; font-size:20px; padding-top: 5%;">
					<label>Change Password</label>
				</div>
				<div class="col-md-10 col-md-offset-1" style="padding-top: 2%;">
					<input type="password" id="OldPass" placeholder="Old Password" class="form-control">
				</div>
				<div class="col-md-10 col-md-offset-1" style="padding-top: 2%;">
					<input type="password" id="NewPass" placeholder="New Password" class="form-control">
				</div>
				<div class="col-md-10 col-md-offset-1" style="padding-top: 2%;">
					<input type="password" id="ConPass" placeholder="Confirm Password" class="form-control">
				</div>
				<div class="col-md-10 col-md-offset-1" style="padding-top: 2%; padding-bottom: 5%;">
					<button id="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
				</div>
			</div>
		</div>
	</div>
	@include('library.foot')