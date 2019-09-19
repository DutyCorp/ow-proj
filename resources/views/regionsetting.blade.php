    @include('library.head')
    <title>Region Setting</title>
    <script src="{{asset('js/RegionSetting.js')}}"></script>
    <div id="main" class="container">
        <div class="form-group row">
            <h1>
                <center>Region Setting</center>
            </h1>
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
                        <button type="button" class="btn btn-primary" id="btnAlright">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="ProjectLeadSetting">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="ModalHeader" align="center"><b>Project Lead Setting</b></h3>
                    </div>
                    <div class="modal-body" id="ModalContent">
                        <div class="form-group row">
                            <div class="col-md-8  col-md-offset-2">
                                <div id="divRegion" class="form-group row">
                                    <div class="col-md-2">Region</div>
                                    <div class="col-md-5">
                                        <select id="RegionProjectLead" class="form-control">
                                            <option value="None">Select</option>
                                                @foreach($ListRegions as $Region)
                                                    @if($Region->RegionID != "AS")
                                                        <option value="{{ $Region->RegionID }}">{{ $Region->RegionName }}</option>
                                                    @endif
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="divProjectLead" class="form-group row">
                                    <div class="col-md-3">Project Lead</div>
                                    <div class="col-md-5">
                                        <select id="SelectProjectLead" class="form-control">
                                            <option value="None">Select</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2"><button id="addProjectLead" class="btn-success btn">Add</button></div>
                                    <div class="col-md-2"><button id="backProjectLead" class="btn-default btn">Back</button></div>
                                </div>
                                <div class="form-group row">
                                    <div id="ProjectLeadTable" class="col-md-12">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <center id="InfoProjectLead" style="color: red;"><h4><b>Total must be 100</b></h4></center>
                        </div>
                    </div>
                    <div class="modal-footer" id="ModalFooter">
                        <button type="button" class="btn btn-primary" id="btnOKProjectLead">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="ManagerialSetting">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="ModalHeader" align="center"><b>Managerial Setting</b></h3>
                    </div>
                    <div class="modal-body" id="ModalContent">
                        <div id="formGS" class="form-group row">
                            <div class="form-group row">
                                <div class="col-md-2 col-md-offset-3">Region</div>
                                <div class="col-md-4">
                                    <select id="selectRegion" class="form-control">
                                        <option value="None">Select</option>
                                        @foreach($ListRegions as $Region)
                                            @if($Region->RegionID != "AS")
                                                <option value="{{ $Region->RegionID }}">{{ $Region->RegionName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 col-md-offset-3">Group Manager 1</div>
                                <div class="col-md-4">
                                    <select id="selectGRM1" class="form-control">
                                        <option value="None">Select</option>
                                        @foreach($ListGRM as $GRM)
                                            <option value="{{ $GRM->EmployeeID }}">{{ $GRM->EmployeeName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 col-md-offset-3">Group Manager 2</div>
                                <div class="col-md-4">
                                    <select id="selectGRM2" class="form-control">
                                        <option value="None">Select</option>
                                        @foreach($ListGRM as $GRM)
                                            <option value="{{ $GRM->EmployeeID }}">{{ $GRM->EmployeeName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 col-md-offset-3">PMO</div>
                                <div class="col-md-4">
                                    <select id="selectPMO" class="form-control">
                                        <option value="None">Select</option>
                                        @foreach($ListPMO as $PMO)
                                            <option value="{{ $PMO->EmployeeID }}">{{ $PMO->EmployeeName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" align="center">
                                <div class="col-md-12">
                                    <button id="buttonSubmit" class="btn btn-primary">Save</button>
                                    <button id="buttonCancel" class="btn btn-default">Cancel</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div id="tableGS" class="col-md-10 col-md-offset-2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <center id="InfoManagerial" style="color:red"><h4><b>Total must be 100</b></h4></center>
                        </div>
                    </div>
                    <div class="modal-footer" id="ModalFooter">
                        <button type="button" class="btn btn-primary" id="btnOKManagerial">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="TargetSetting">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="ModalHeader" align="center"><b>Target Setting</b></h3>
                    </div>
                    <div class="modal-body" id="ModalContent">
                        <div class="form-group row">
                            <div class="col-md-1">Year</div>
                            <div class="col-md-2">
                                <input type="text" class="datepicker-here form-control" style="z-index:-10000" data-language='en' data-min-view="years" data-view="years"  data-date-format="yyyy" id="TargetYear"/>
                            </div>
                            <div class="col-md-2">Business Area</div>
                            <div class="col-md-3">
                                <select id="TargetRegion" class="form-control">
                                    <option value="None">Select</option>
                                    @foreach($ListBA as $BA)
                                        <option value="{{ $BA->BusinessAreaID }}">{{ $BA->BusinessAreaName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button id="CheckTarget" class="btn btn-success">Check</button>
                            </div>
                            <div class="col-md-3">
                                <center id="InfoCheckTarget" style="color:red"><h4><b>Total must be 100</b></h4></center>
                            </div>
                        </div>
                        <div id="TargetForm">
                            <div class="form-group row">
                                <div class="col-md-2"><b>Sales Target ( USD )</b></div>
                                <div class="col-md-3 col-md-offset-4"><b>Revenue Target ( USD )</b></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 col-md-offset-1">Maintenance</div>
                                <div class="col-md-3">
                                    <input id="Sales_M" type="text" class="form-control">
                                </div>
                                <div class="col-md-2 col-md-offset-1">Maintenance</div>
                                <div class="col-md-3">
                                    <input id="Revenue_M" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 col-md-offset-1">Service</div>
                                <div class="col-md-3">
                                    <input id="Sales_S" type="text" class="form-control">
                                </div>
                                <div class="col-md-2 col-md-offset-1">Service</div>
                                <div class="col-md-3">
                                    <input id="Revenue_S" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 col-md-offset-1">Licenses</div>
                                <div class="col-md-3">
                                    <input id="Sales_L"type="text" class="form-control">
                                </div>
                                <div class="col-md-2 col-md-offset-1">Licenses</div>
                                <div class="col-md-3">
                                    <input id="Revenue_L" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3"><b>Occupation Target ( % )</b></div>
                                <div class="col-md-3 col-md-offset-3"><b>Pipeline Target ( USD )</b></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 col-md-offset-1">Chargeability</div>
                                <div class="col-md-3">
                                    <input id="Occupation_C" type="text" class="form-control">
                                </div>
                                <div class="col-md-2 col-md-offset-1">Maintenance</div>
                                <div class="col-md-3">
                                    <input id="Pipeline_M" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 col-md-offset-1">Utilization</div>
                                <div class="col-md-3">
                                    <input id="Occupation_U" type="text" class="form-control">
                                </div>
                                <div class="col-md-2 col-md-offset-1">Service</div>
                                <div class="col-md-3">
                                    <input id="Pipeline_S" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 col-md-offset-7">Licenses</div>
                                <div class="col-md-3">
                                    <input id="Pipeline_L" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <center id="InfoTarget" style="color:red"><h4><b>Total must be 100</b></h4></center>
                            </div>
                            <div class="form-group row" align="center">
                                <button id="SaveTarget" class="btn btn-info">Save</button>
                                <button id="BackTarget" class="btn btn-danger">Back</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="ModalFooter">
                        <button type="button" class="btn btn-primary" id="btnOKTarget">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="ValueSetting">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="ModalHeader" align="center"><b>Mandays Cost</b></h3>
                    </div>
                    <div class="modal-body" id="ModalContent">
                        <div class="form-group row">
                            <div class="col-md-2 col-md-offset-2">
                                <label>
                                    MDCost
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input id="MDCostValue" type="text" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <button class="btn-success btn form-control" id="setMDCostButton">Set</button>
                                <button class="btn-primary btn form-control" id="SubmitMDCostButton">Submit</button>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <center id="InfoValue" style="color:red"><h4><b>Total must be 100</b></h4></center>
                        </div>
                    </div>
                    <div class="modal-footer" id="ModalFooter">
                        <button type="button" class="btn btn-primary" id="btnOKValue">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4 col-md-offset-1" align="center">
                <div class="form-group row">
                    <img height="150" width="150" id="ShowImg" name="ShowImg" src="/a/{{ Crypt::encrypt('manager.png') }}" alt="your image" />
                </div>
                <div class="form-group row">
                    <div class="col-md-8 col-md-offset-2" align="center">
                        <button class="btn btn-info form-control" data-toggle="modal" data-target="#ManagerialSetting" style="font-size:16px">MANAGERIAL SETTING</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-2" align="center">
                <div class="form-group row">
                    <img height="150" width="150" id="ShowImg" name="ShowImg" src="/a/{{ Crypt::encrypt('leadership.jpg') }}" alt="your image" />
                </div>
                <div class="form-group row">
                    <div class="col-md-8 col-md-offset-2" align="center">
                        <button class="btn btn-info form-control" data-toggle="modal" data-target="#ProjectLeadSetting" style="font-size:16px">PROJECT LEAD SETTING</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-1" align="center">
                <div class="form-group row">
                    <img height="150" width="150" id="ShowImg" name="ShowImg" src="/a/{{ Crypt::encrypt('target.jpg') }}" alt="your image" />
                </div>
                <div class="form-group row">
                    <div class="col-md-8 col-md-offset-2" align="center">
                        <button id="TargetSettingBTN" class="btn btn-info form-control" data-toggle="modal" data-target="#TargetSetting" style="font-size:16px">TARGET SETTING</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-2" align="center">
                <div class="form-group row">
                    <img height="150" width="150" id="ShowImg" name="ShowImg" src="/a/{{ Crypt::encrypt('setting.png') }}" alt="your image" />
                </div>
                <div class="form-group row">
                    <div class="col-md-8 col-md-offset-2" align="center">
                        <button id="ValueSettingBTN" class="btn btn-info form-control" data-toggle="modal" data-target="#ValueSetting" style="font-size:16px">MANDAYS COST</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('library.foot')