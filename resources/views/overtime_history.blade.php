	@include('library.head')
	<title>Overtime History</title>
	<script src="{{asset('js/TableOvertimeHistory.js')}}"></script>
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
						<h1>Overtime History</h1>
					</center>
				</div>		
				<!--<div class="form-group row" style="background-color:#E3F2FD; padding-top:12px">		
					<div class="form-group col-md-1" style="padding-top:7px;padding-right:0px;width:55px">
						<i class="fa fa-calendar fa-4x" style="color:#3579BD" aria-hidden="true"></i>
					</div>	
					<div class="form-group col-md-2">
						<label for="filterDateFrom">Date from</label>
						<input type='text' class='datepicker-here form-control' data-language='en' data-date-format="dd/mm/yyyy" id="filterDateFrom">
					</div>
					<div class="form-group col-md-2">
						<label for="filterDateTo">Date to</label>
						<input type='text' class='datepicker-here form-control' data-language='en' data-date-format="dd/mm/yyyy" id="filterDateTo">
					</div>
					<div class="form-group col-md-1">
						<br><button id="submitFilterDate" class="btn btn-primary">Submit</button>
					</div>
				</div>-->
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
				<div id="tableOvertimeHistory">
					
				</div>
			</div>
		@endif
	@endforeach
	@include('library.foot')