	@include('library.head')
	<title>Permission Approval</title>
	<script src="{{asset('js/PermissionAttendanceApproval.js')}}"></script>
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
		<div class="form-group row">
			<center>
				<h1>Permission Approval</h1>
			</center>
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
		<div id="tableApprovalPermission">
		</div>
	</div>
	@include('library.foot')