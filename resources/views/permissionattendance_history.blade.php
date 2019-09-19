	@include('library.head')
	<title>Permission History</title>
	<script src="{{asset('js/PermissionAttendanceHistory.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_S == "0")
			<script>
				$(function(){
					window.location.replace("/");
				});
			</script>
		@else
			<div id="main" class="container">
				<div class="form-group row">
					<center>
						<h1>Permission History</h1>
					</center>
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
				<div class="modal fade" tabindex="-1" role="dialog" id="Modal_Notification">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="ModalHeaderNotification"></h4>
							</div>
							<div class="modal-body" id="ModalContentNotification">

							</div>
							<div class="modal-footer" id="ModalFooterNotification">
								<center>
									<button type="button" class="btn btn-success" id="YesDelete">Yes</button>
									<button type="button" class="btn btn-danger" id="NoDelete">No</button>
								</center>
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
				<div id="tablePermissionAttendanceHistory" class="form-group row" style="font-size:12px">
				</div>
			</div>
		@endif
	@endforeach
	@include('library.foot')
