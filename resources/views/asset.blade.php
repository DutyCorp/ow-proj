	@include('library.head')
	<title>Asset Management</title>
	<script src="{{asset('js/EntryAsset.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_S == "0")
			<script>
				$(function(){
			    	window.location.replace("/");
			    });
			</script>
		@else
			<div id="main" class="container">
				<div class="modal fade" id="myModal" role="dialog">
				    <div class="modal-dialog modal-lg">
				    	<div class="modal-content">
				       		<div class="modal-header">
				        		<button id="closeATButton" name="closeATButton" type="button" class="close" data-dismiss="modal">&times;</button>
				        		<center><h4 class="modal-title">New Asset Type</h4></center>
				        	</div>
				        	<div class="modal-header">
					        	<div class="form-group row">
									<div class="col-md-2 col-md-offset-3" align="left">
										<label>Asset Type ID</label>
									</div>
									<div class="col-md-4" align="left">
										<input disabled id="assetTypeID" name="assetTypeID" type="text" class="form-control">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-2 col-md-offset-3" align="left">
										<label>Asset Type Name</label>
									</div>
									<div class="col-md-4" align="right" >
										<input id="assetTypeName" name="assetTypeName" type="text" class="form-control">
									</div>
								</div>
								<div class="form-group row">
				        			<center>
				        				<label id="ATInfo">Success</label>
				        			</center>
				        		</div>
								<div class="form-group row" align="center">
									<div class="col-md-12">
										<button id="buttonSubmitAssetType" name="buttonSubmitAssetType" class="btn btn-primary">Submit</button>
										<button id="buttonUpdateAssetType" name="buttonUpdateAssetType" class="btn btn-success">Update</button>
										<button id="buttonCancelAssetType" name="buttonCancelAssetType" class="btn btn-default">Cancel</button>
									</div>
								</div>
				        	</div>
				        	<div class="modal-body">
				          		<div id="tableAssetType">
				          			
								</div>
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
					      	<div class="modal-footer" id="ModalFooter">
					      		<center>
						      		<button type="button" class="btn btn-danger" id="YesDelete">Yes</button>
						      		<button type="button" class="btn btn-default" id="NoDelete">No</button>
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
				<div class="form-group row">
					<center><h1>Asset Management</h1></center>
				</div>
				@if ($rolemenu->Role_I == "0")
					<script>
						$(function(){
					    	$('#insertAsset').hide();
					    });
					</script>
				@endif
				<input type="hidden" id="RoleI" value="{{ $rolemenu->Role_I }}">
				<div id="insertAsset">
					<div class="form-group row">
						<div class="col-md-4 col-md-offset-1">
							<div class="form-group row" style="background-color:#E3F2FD" >
								<div class="col-md-12" style="padding-top: 20px">
									<div class="form-group row">
										<div class="col-md-12">
											<label for="assetNumber">Asset Number</label>
											<input type="text" id="assetNumber" name="assetNumber" class="form-control" disabled>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row" style="margin-bottom:0px">
										<div class="col-md-12">
											<div class="form-group row">
												<div class="col-md-4">
													<label for="assetClass">Asset Class</label>
													<select id="assetClass" name="assetClass" class="form-control">
															<option value="None">-</option>
														@foreach($ListAssetClass as $AssetClass)
															<option value="{{ $AssetClass -> AssetClassID }}">{{ $AssetClass -> AssetClassID }}</option>
														@endforeach
													</select>			
												</div>
												<div class="col-md-8" style="padding-top: 27px;">
													<label id="assetClassDescription" name="assetClassDescription">-</label>	
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row">
										<div class="col-md-12">
											<label for="assetLocation">Asset Location</label>
											<select id="assetLocation" name="assetLocation" class="form-control">
													<option value="None">Select</option>
													@foreach($ListRegion as $Region)
														@if($Region -> RegionID != "AS")
															<option value="{{ $Region -> RegionID }}">{{ $Region -> RegionName }}</option>
														@endif
													@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row">
										<div class="col-md-12">
											<label for="assetStatus">Asset Status</label>
											<select id="assetStatus" name="assetStatus" class="form-control">
												<option id="NS" name="NS" value="None">Select</option>
												<option id="AS" name="AS" value="Active">Active</option>
												<option id="BS" name="BS" value="BackUp">Back Up</option>
												<option id="IS" name="IS" value="InActive">InActive</option>
												<option id="MS" name="MS" value="Mutation">Mutation</option>
												<option id="SS" name="SS" value="Sold">Sold</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row">
										<div class="col-md-12">
											<label for="assetSerialNumber">Serial Number</label>
											<input type="text" id="assetSerialNumber" name="assetSerialNumber" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row">
										<div class="col-md-12">
											<label for="assetDescription">Asset Description</label>
											<textarea id="assetDescription" name="assetDescription" class="form-control" rows="5"></textarea>
										</div>
									</div>
								</div>
								<div class="col-md-12" style="padding-bottom:15px">
									<div class="form-group row">
										<div class="col-md-12">
											<label for="selectOwner">Owner</label>
											<select id="selectOwner" name="selectOwner" class="form-control">
													<option value="None">Select</option>
												@foreach($ListEmployee as $Employee)
													@if ($Employee->EmployeeID != "EM999")
														<option value="{{ $Employee -> EmployeeID }}">{{ $Employee -> EmployeeName }}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-md-offset-2">
							<div class="form-group row" style="background-color:#E3F2FD" >
								<div class="col-md-12" style="padding-top: 20px">
									<div class="form-group row">
										<div class="col-md-12">
											<label for="assetRoom">Asset Room</label>
											<input type="text" id="assetRoom" name="assetRoom" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row">
										<div class="col-md-12">
											<label for="assetAcquisitionDate">Acquisition Date</label>
											<input id="assetAcquisitionDate" type="text" class="datepicker-here form-control" data-language='en' data-date-format="dd/mm/yyyy">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row">
										<div class="col-md-12">
											<label for="assetGuaranteeDate">Guarantee Date</label>
											<input id="assetGuaranteeDate" type="text" class="datepicker-here form-control" data-language='en' data-date-format="dd/mm/yyyy">
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row">
										<div class="col-md-8">
											<label for="assetType">Asset Type</label>
											<select id="assetType" class="form-control">
												<option value="None">Select</option>
												@foreach($ListAssetType as $AssetType)
													<option value="{{ $AssetType -> AssetTypeID }}">{{ $AssetType -> AssetTypeName }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-md-4" style="padding-top:22px">
											<button id="addAssetType" name="addAssetType" class="btn btn-success form-control" data-toggle="modal" data-target="#myModal">Add</button>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row" style="margin-bottom:0px">
										<div class="col-md-12">
											<div class="form-group row">
												<div class="col-md-8">
													<label for="assetValue">Asset Value</label>
													<input type="text" id="assetValue" name="assetValue" class="form-control">
												</div>
												<div class="col-md-4" style="padding-top:22px">
													<select id="assetValueCurrency" name="assetValueCurrency" class="form-control">
														<option value="None">Select</option>
														<option value="IDR">IDR</option>
														<option value="VND">VND</option>
														<option value="MYR">MYR</option>
														<option value="USD">USD</option>
														<option value="THB">THB</option>
													</select>	
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row">
										<div class="col-md-12">
											<label for="assetNotes">Asset Notes</label>
											<textarea id="assetNotes" name="assetNotes" class="form-control" rows="5"></textarea>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group row">
										<div class="col-md-12">
											<div class="form-group row">
												<div class="col-md-8">
													<label for="assetSellingPrice">Selling Price</label>
													<input type="text" id="assetSellingPrice" name="assetSellingPrice" class="form-control">
												</div>
												<div class="col-md-4" style="padding-top:22px">
													<select id="assetSellingPriceCurrency" name="assetSellingPriceCurrency" class="form-control">
														<option value="None">Select</option>
														<option value="IDR">IDR</option>
														<option value="VND">VND</option>
														<option value="MYR">MYR</option>
														<option value="USD">USD</option>
														<option value="THB">THB</option>
													</select>	
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group row" align="center">
						<button class="btn btn-success" id="buttonUpdateAsset" name="buttonUpdateAsset">Update</button>
						<button class="btn btn-primary" id="buttonSubmitAsset" name="buttonSubmitAsset">Submit</button>
						<button class="btn btn-link" id="buttonClearAsset" name="buttonClearAsset">Clear</button>
						<button class="btn btn-default" id="buttonCancelAsset" name="buttonCancelAsset">Cancel</button>
					</div>
				</div>
				<div>
					<div style="width: 20px; height: 20px; border: 1px solid rgba(0, 0, 0, .2); background: #f44256;"></div><label>Notebook with lifetime > 3 years</label>
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
				<div id="tableAsset">
				</div>
			</div>
		@endif
	@endforeach
	@include('library.foot')