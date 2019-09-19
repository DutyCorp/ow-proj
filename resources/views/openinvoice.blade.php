	@include('library.head')
	<title>Open Invoice</title>
	<script src="{{asset('js/OpenInvoice.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_S == "0")
			<script>
				$(function(){
			    	window.location.replace("/");
			    });
			</script>
		@else
			<div id="main" class="container">
				<div class="modal fade" tabindex="-1" role="dialog" id="GraphDetail">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title"></h4>
				      		</div>
				      		<div class="modal-body modal-body-ip">
				      			<div class="form-group row" id="DetailG">
				      				<canvas id="myChartDetail">
				      					<div id="chartjs-tooltip">
				      					</div>
				      				</canvas>
				      			</div>
				      			<div id="DetailInfo"><h1 style="color:red"><center>No Data to display in Detail Graph</center></h1></div>
				      		</div>
				      		<div class="modal-footer">
				      			<button type="button" class="btn btn-primary" id="btnOKDetail">OK</button>
				      		</div>
				    	</div>
				  	</div>
				</div>
				<div class="modal fade" tabindex="-1" role="dialog" id="GraphRegion">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title"></h4>
				      		</div>
				      		<div class="modal-body modal-body-ip">
				      			<div class="form-group row" id="RegionG">
				      				<canvas id="myChartRegion">
				      					<div id="chartjs-tooltip">
				      					</div>
				      				</canvas>
				      			</div>
				      			<div id="RegionInfo"><h1 style="color:red"><center>No Data to display in Region Graph</center></h1></div>
				      		</div>
				      		<div class="modal-footer">
				      			<button type="button" class="btn btn-primary" id="btnOKRegion">OK</button>
				      		</div>
				    	</div>
				  	</div>
				</div>
				<div class="modal fade" tabindex="-1" role="dialog" id="GraphSummary">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title"></h4>
				      		</div>
				      		<div class="modal-body modal-body-ip">
				      			<div class="form-group row" id="SummaryG">
				      				<canvas id="myChartSummary">
				      				</canvas>
				      			</div>
				      			<div id="SummaryInfo"><h1 style="color:red"><center>No Data to display in Summary Graph</center></h1></div>
				      		</div>
				      		<div class="modal-footer">
				      			<button type="button" class="btn btn-primary" id="btnOKSummary">OK</button>
				      		</div>
				    	</div>
				  	</div>
				</div>
				<div class="modal fade" tabindex="-1" role="dialog" id="GraphCustomerSummary">
				  	<div class="modal-dialog modal-lg-lw" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title"></h4>
				      		</div>
					      	<div class="modal-body modal-body-ip">
					      		<div class="form-group row">
					      			<div class="col-md-8 col-md-offset-2">
					      				<div id="CSTInfo"><h1 style="color:red"><center>No Data to display in Year</center></h1></div>
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
					      			<div class="col-md-10 col-md-offset-1">
					      				<div id="CSMInfo"><h1 style="color:red"><center>No Data to display in Maintenance</center></h1></div>
					      				<canvas id="myChartCSM"></canvas>
					      			</div>
					      		</div>
				      		</div>
				      		<div class="modal-footer">
				      			<button type="button" class="btn btn-primary" id="btnOKCS">OK</button>
				      		</div>
				    	</div>
				  	</div>
				</div>
				<div class="modal fade" tabindex="-1" role="dialog" id="GraphCustomerDetail">
				  	<div class="modal-dialog modal-lg-lw" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title"></h4>
				      		</div>
				     	 	<div class="modal-body modal-body-ip">
					      		<div class="form-group row">
					      			<div class="col-md-8 col-md-offset-2">
					      				<div id="CDTInfo"><h1 style="color:red"><center>No Data to display in Year</center></h1></div>
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
					      			<div class="col-md-10 col-md-offset-1">
					      				<div id="CDMInfo"><h1 style="color:red"><center>No Data to display in Maintenance</center></h1></div>
					      				<canvas id="myChartCDM"></canvas>
					      			</div>
					      		</div>
				      		</div>
				      		<div class="modal-footer">
				      			<button type="button" class="btn btn-primary" id="btnOKCD">OK</button>
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
				<div class="modal fade" tabindex="-1" role="dialog" id="ModalCustomerName">
				  	<div class="modal-dialog modal-lg" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title"></h4>
				      		</div>
				      		<div class="modal-body modal-body-ip">
			      				<div class="form-group row">
			      					<div class="col-md-6">
										<select id="CustomerName" class="form-control">
											@foreach($CustomerName as $CN)
												<option value="{{ $CN -> CName }}">{{ $CN -> CName }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-6">
										<button class="btn btn-primary" id="CustomerDGraphIP">Submit</button>
									</div>
			      				</div>
				      		</div>
				      		<div class="modal-footer">
				      			<button type="button" class="btn btn-primary" id="btnOKMCN">OK</button>
				      		</div>
				    	</div>
				  	</div>
				</div>
				<div class="form-group row">
					<center>
						<h1>Open Invoice</h1>
					</center>
				</div>
				<div class="form-group row">
					<div class="col-md-4 col-md-offset-4">
						<div class="form-group row" style="background-color:#E3F2FD" >
							<div class="col-md-12" style="padding-top: 10px">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="selectInvoiceRegion">Region</label>
										<select id="selectInvoiceRegion" class="form-control">
											<option value="All">All</option>
											@foreach($ListRegion as $Region)
												@if($Region -> RegionID != "AS")
													<option value="{{ $Region->RegionName }}">{{ $Region -> RegionName }}</option>
												@endif
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-6">
										<label for="PeriodFrom">Period</label>
										<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy" id="PeriodFrom"/>
										<span>From</span>
									</div>
									<div class="col-md-6" style="padding-top:22px">
										<input type="text" class="datepicker-here form-control" data-language='en' data-min-view="months" data-view="months"  data-date-format="MM yyyy" id="PeriodTo"/>
										<span>To</span>
									</div>
								</div>
								<div class="form-group row" align="center">
									<button class="btn btn-primary" id="btnSubmitOpenInvoice" name="btnSubmitOpenInvoice">Data</button>
									<div class="dropdown">
										<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Graph
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
										    <li align="center" id="DetailGraphIP" data-toggle="modal" data-target="#GraphDetail"><button class="btn-warning btn form-control">Detail</button></li>
										    <li align="center" id="SummaryGraphIP" data-toggle="modal" data-target="#GraphSummary"><button style="color:black; background-color:#B2FF59" class="btn-success btn form-control">Summary</button></li>
										    <li align="center" id="RegionGraphIP" data-toggle="modal" data-target="#GraphRegion"><button class="btn form-control" style="background-color:#ffd1dc; color:black">Region</button></li>
										    <li align="center" id="CustomerSGraphIP" data-toggle="modal" data-target="#GraphCustomerSummary"><button class="btn form-control" style="background-color:#FFEB3B; color:black">Customer Summary</button></li>
										    <li align="center" data-toggle="modal" data-target="#ModalCustomerName"><button class="btn form-control" style="background-color:#D1C4E9; color:black">Customer Detail</button></li>
										</ul>
									</div>
								</div>
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
				<div id="tableOpenInvoice">
				</div>
			</div>
		@endif
	@endforeach
	@include('library.foot')