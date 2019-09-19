	@include('library.head')
	<title>Role Setting</title>
	<script src="{{asset('js/rolecommands.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_S == "0")
			<script>
				$(function(){
			    	window.location.replace("/");
			    });
			</script>
		@else
	<div id="main" class="container">
		@if ($rolemenu->Role_I == "0")
			<script>
				$(function(){
			    	$('#insertRole').hide();
			    });
			</script>
		@endif
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
		<div class="modal fade" tabindex="-1" role="dialog" id="ModalDelete">
		  	<div class="modal-dialog" role="document">
		    	<div class="modal-content">
		      		<div class="modal-header">
		        		<h4 class="modal-title" id="ModalDeleteHeader">Delete Confirmation</h4>
		      		</div>
		      		<div class="modal-body" id="ModalDeleteContent">

		      		</div>
		      		<div class="modal-footer" id="ModalDeleteFooter">
		      			<center>
		      				<button type="button" class="btn btn-danger" id="YesDelete">Yes</button>
		      				<button type="button" class="btn btn-default" id="NoDelete">No</button>
		      			</center>
		      		</div>
		    	</div>
		  	</div>
		</div>
		
		<div class="form-group row" >
			<div class="form-group row" >
				<center>
					<h1>Role Setting</h1>
				</center>
			</div>
			<div class="col-md-6" id="insertRole">
				<div class="form-group row" style="background-color:#E3F2FD" >
					<div class="col-md-12">
						<input type="hidden" id="RoleI" value="{{ $rolemenu->Role_I }}">
						<div class="form-group row" style="padding-top:10px">
							<div class="col-md-2">Role ID</div>
							<div class="col-md-10"><b id="divRoleID">{{ $roleid }}</b></div>
						</div>
						<div class="form-group row">
							<div class="col-md-2">Role Name</div>
							<div class="col-md-10"><input type="text" class="form-control" id="txtRoleName"></div>
						</div>	
						<div class="form-group row">
							<div class="col-md-2">Role Access</div>
							<div class="col-md-10" id="divTableRoleAccess">
								<table id="tableRoleAccess" class="table table-bordered" style="font-size: 12px; background-color: #FFFFFF;">
									<thead>
										<tr>
											<td>Menu</td>
											<td>Sub Menu</td>
											<td>Menu Child</td>
											<td>Show</td>
											<td>Insert</td>
											<td>Update</td>
											<td>Delete</td>
										</tr>
									</thead>
									<tbody>
										@foreach($menus as $menu)	
										<tr id="{{ $menu->MenuChildID }}" value="{{ $menu->MenuChildID }}">
											<td>{{ $menu->MenuParentName }}</td>
											<td>{{ $menu->SubMenuName }}</td>
											<td>{{ $menu->MenuChildName }}</td>
											@if ($menu->Menu_S == 1)
											<td><input type="checkbox" id="s"></td>
											@else
											<td><input type="checkbox" disabled id="s"></td>
											@endif
											@if ($menu->Menu_I == 1)
											<td><input type="checkbox" id="i"></td>
											@else
											<td><input type="checkbox" disabled id="i"></td>
											@endif
											@if ($menu->Menu_U == 1)
											<td><input type="checkbox" id="u"></td>
											@else
											<td><input type="checkbox" disabled id="u"></td>
											@endif
											@if ($menu->Menu_D == 1)
											<td><input type="checkbox" id="d"></td>
											@else
											<td><input type="checkbox" disabled id="d"></td>
											@endif
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							<div class="col-md-6" id="divLoading">
								<p><i class="fa fa-circle-o-notch fa-spin" style="font-size:24px;color:blue"></i></p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-2">Region Visibility</div>
							<div class="col-md-10" id="RegionDiv">
								@foreach($regions as $region)
									@if($region->RegionID != "AS")
										<div>
											<input type="checkbox" class="cbxRegion" value="{{ $region->RegionID }}"> {{ $region->RegionName }}
										</div>
									@endif
								@endforeach			
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-2">Grade</div>
							<div class="col-md-10" id="GradeDiv">
								@foreach($grades as $grade)
									<div>
										<input type="checkbox" class="cbxGrade" value="{{ $grade->GradeID }}"> {{ $grade->GradeName }}
									</div>
								@endforeach			
							</div>
						</div>
						<div class="form-group row" align="center">
							<button class="btn btn-primary" id="btnSubmit">Submit</button>
							<button class="btn btn-success" id="btnUpdate">Update</button>
							<button class="btn btn-link" id="btnClear">Clear</button>
							<button class="btn btn-default" id="btnCancel">Cancel</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<div class="col-md-12" id="divRoleList">
						
					</div>
					<div class="col-md-12" id="divLoading2">
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
				</div>
			</div>
		</div>
	</div>
	@endif
	@endforeach
	@include('library.foot')