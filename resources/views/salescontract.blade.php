	@include('library.head')
	<title>Sales Contract</title>
	<script src="{{asset('js/SalesContract.js')}}"></script>
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
					      	<div class="modal-body modal-body-sc" id="ModalContent">
					      	</div>
					      	<div class="modal-footer" id="ModalFooter">
						      	<button type="button" class="btn btn-primary" id="btnAlright">OK</button>
					      	</div>
				    	</div>
				  	</div>
				</div>
				<div class="modal fade" tabindex="-1" role="dialog" id="GraphDetail">
				  	<div class="modal-dialog modal-lg" role="document">
					    <div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title" id="ModalHeader"></h4>
				      		</div>
				      		<div class="modal-body modal-body-sc" id="ModalContent">
				      			<div id="DetailInfo"><h1 style="color:red"><center>No Data for Detail Graph</center></h1></div>
				      			<div class="form-group row" id="hehe">
				      				<canvas id="myChartDetail">
				      					<div id="chartjs-tooltip">
				      					</div>
				      				</canvas>
				      			</div>
				      		</div>
				      		<div class="modal-footer" id="ModalFooter">
				      			<button type="button" class="btn btn-primary" id="btnOKDetail">OK</button>
				      		</div>
				    	</div>
				  	</div>
				</div>
				<div class="modal fade" tabindex="-1" role="dialog" id="GraphSummary">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title" id="ModalHeader"></h4>
				      		</div>
					      	<div class="modal-body modal-body-sc" id="ModalContent">
					      		<div id="SummaryInfo"><h1 style="color:red"><center>No Data for Summary Graph</center></h1></div>
					      		<div class="form-group row" id="hehe">
					      			<canvas id="myChartSummary"></canvas>
					      		</div>
					      	</div>
					      	<div class="modal-footer" id="ModalFooter">
						      	<button type="button" class="btn btn-primary" id="btnOKSummary">OK</button>
					      	</div>
				    	</div>
				  	</div>
				</div>
				<div class="modal fade" tabindex="-1" role="dialog" id="GraphRegion">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title" id="ModalHeader"></h4>
				      		</div>
				      		<div class="modal-body modal-body-sc" id="ModalContent">
					      		<div id="RegionInfo">
					      			<center>
					      				<h1 style="color:red">
					      					No Data
					      				</h1>
					      			</center>
					      		</div>
					      		<div class="form-group row" id="hehe">
					      			<canvas id="myChartRegion"></canvas>
					      		</div>
						    </div>
				      		<div class="modal-footer" id="ModalFooter">
				      			<button type="button" class="btn btn-primary" id="btnOKRegion">OK</button>
				      		</div>
				    	</div>
				  	</div>
				</div>
				<div class="modal fade" tabindex="-1" role="dialog" id="GraphCustomerSummary">
				  	<div class="modal-dialog modal-lg-lw" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title" id="ModalHeader"></h4>
				      		</div>
					      	<div class="modal-body modal-body-sc" id="ModalContent">
					      		<div class="form-group row">
					      			<div class="col-md-8 col-md-offset-2">
					      				<div id="CSTInfo"><h1 style="color:red"><center>No Data to display in Total Year</center></h1></div>
					      				<canvas id="myChartCST"></canvas>
					      			</div>
					      		</div>
					      		<div class="form-group row">
					      			<div class="col-md-10 col-md-offset-1">
					      				<div id="CSLSInfo"><h1 style="color:red"><center>No Data to display in Licenses & Service</center></h1></div>
					      				<canvas id="myChartCSLS"></canvas>
					      			</div>
					      		</div>
					      		<div class="form-group row">
					      			<div class="col-md-8 col-md-offset-2">
					      				<div id="CSMInfo"><h1 style="color:red"><center>No Data to display in Maintenance</center></h1></div>
					      				<canvas id="myChartCSM"></canvas>
					      			</div>
					      		</div>
					      	</div>
				      		<div class="modal-footer" id="ModalFooter">
				      			<button type="button" class="btn btn-primary" id="btnOKCS">OK</button>
				      		</div>
				    	</div>
				  	</div>
				</div>
				<div class="modal fade" tabindex="-1" role="dialog" id="GraphCustomerDetail">
				  	<div class="modal-dialog modal-lg-lw" role="document">
					    <div class="modal-content">
					      	<div class="modal-header">
					        	<h4 class="modal-title" id="ModalHeader"></h4>
					      	</div>
					      	<div class="modal-body modal-body-sc" id="ModalContent">
					      		<div class="form-group row">
					      			<div class="col-md-8 col-md-offset-2">
					      				<div id="CDTInfo"><h1 style="color:red"><center>No Data to display in Total Year</center></h1></div>
					      				<canvas id="myChartCDT"></canvas>
					      			</div>
					      		</div>
					      		<div class="form-group row">
					      			<div class="col-md-10 col-md-offset-1">
					      				<div id="CDLSInfo"><h1 style="color:red"><center>No Data to display in Licenses & Service</center></h1></div>
					      				<canvas id="myChartCDLS"></canvas>
					      			</div>
					      		</div>
					      		<div class="form-group row">
					      			<div class="col-md-8 col-md-offset-2">
					      				<div id="CDMInfo"><h1 style="color:red"><center>No Data to display in Maintenance</center></h1></div>
					      				<canvas id="myChartCDM"></canvas>
					      			</div>
					      		</div>
					      	</div>
						    <div class="modal-footer" id="ModalFooter">
						      	<button type="button" class="btn btn-primary" id="btnOKCD">OK</button>
						    </div>
					    </div>
				  	</div>
				</div>
				<div class="modal fade" tabindex="-1" role="dialog" id="ModalCustomerName">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title" id="ModalHeader"></h4>
				      		</div>
				      		<div class="modal-body modal-body-sc" id="ModalContent">
			      				<div class="form-group row">
			      					<div class="col-md-6">
										<select id="CustomerName" class="form-control">
											@foreach($CustomerName as $CN)
												<option value="{{ $CN -> CustomerName }}">{{ $CN -> CustomerName }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-6">
										<button class="btn btn-primary" id="CustomerDGraphSC">Submit</button>
									</div>
			      				</div>
				      		</div>
				      		<div class="modal-footer" id="ModalFooter">
				      			<button type="button" class="btn btn-primary" id="btnOKMCN">OK</button>
				      		</div>
				    	</div>
				  	</div>
				</div>	
				<div class="form-group row">
					<center>
						<h1>Sales Contract</h1>
					</center>
				</div>
				<div class="form-group row">
					<div class="col-md-4 col-md-offset-4">
						<div class="form-group row" style="background-color:#E3F2FD">
							<div class="col-md-12" style="padding-top: 30px">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="projectRegion">Region</label>
										<select id="projectRegion" class="form-control">
											<option value="All">All</option>
											@foreach($ListRegion as $Region)
													<option value="{{ $Region -> RegionID }}">{{ $Region->RegionName }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-6">
										<label for="DateFrom">Contract Date</label>
										<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy" id="DateFrom"/>
										<span>From</span>
									</div>
									<div class="col-md-6" style="padding-top:22px">
										<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy" id="DateTo"/>
										<span>To</span>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label for="projectStatus">Project Status</label>
										<select id="projectStatus" class="form-control">
											<option value="All">All</option>
											@foreach($ListProjectStatus as $ProjectStatus)
												<option value="{{ $ProjectStatus->ProjectStatus }}">{{ $ProjectStatus->ProjectStatus }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label for="contractStatus">Contract Status</label>
										<select id="contractStatus" class="form-control">
											<option value="All">All</option>
											@foreach($ListContractStatus as $ContractStatus)
												<option value="{{ $ContractStatus->ContractStatus }}">{{ $ContractStatus->ContractStatus }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row"></div>
								<div class="form-group row" align="center">
									<button class="btn btn-primary" id="buttonSubmitSalesContract" name="buttonSubmitSalesContract">Data</button>
									<div class="dropdown">
										<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Graph
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
										    <li align="center" id="DetailGraphSC" data-toggle="modal" data-target="#GraphDetail"><button style="color:black" class="btn-warning btn form-control">Detail</button></li>
										    <li align="center" id="SummaryGraphSC" data-toggle="modal" data-target="#GraphSummary"><button style="color:black; background-color:#B2FF59" class="btn-success btn form-control">Summary</button></li>
										    <li align="center" id="RegionGraphSC" data-toggle="modal" data-target="#GraphRegion"><button class="btn form-control" style="background-color:#FFD1DC; color:black">Region</button></li>
										    <li align="center" id="CustomerSGraphSC" data-toggle="modal" data-target="#GraphCustomerSummary"><button class="btn form-control" style="background-color:#FFEB3B; color:black">Customer Summary</button></li>
										    <li align="center" data-toggle="modal" data-target="#ModalCustomerName"><button class="btn form-control" style="background-color:#D1C4E9; color:black">Customer Detail</button></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
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
				<div id="tableSalesContract">	
				</div>
			</div>
		@endif
	@endforeach
	@include('library.foot')