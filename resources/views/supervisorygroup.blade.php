    @include('library.head')
    <title>Supervisory Group</title>
    <script src="{{asset('js/Supervisorygroup.js')}}"></script>
    <div id="main" class="container">
        <div class="form-group row" style="text-align: center;">
            <h1>Supervisory Group</h1>
        </div>
        <br>
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
            <div class="col-md-2 col-md-offset-6">
                <button id="save" class="btn btn-success form-control">Save</button>
            </div>
        </div>
        <div class="form-group row">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group row" style="background-color:#E3F2FD; margin-left:40px; margin-right:40px">
                        <div class="col-md-12" style="padding-top: 10px">
                            <div class="form-group row">
                                <div class="col-md-3 col-md-offset-1">Team Lead</div>
                                <div class="col-md-7">
                                    <select id="selectPM" class="form-control">
                                        <option value="None">Select</option>
                                        @foreach($ListDM as $DM)
                                            <option value="{{ $DM->EmployeeID }}">{{ $DM->EmployeeName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 col-md-offset-1">Region</div>
                                <div class="col-md-7">
                                    <select disabled id="selectRegion" type="text" class="form-control">
                                        <option value="None"></option>
                                        @foreach($ListRegion as $Region)
                                            <option value="{{ $Region->RegionID }}">{{ $Region->RegionName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 col-md-offset-1">Group Manager 1</div>
                                <div class="col-md-7">
                                    <input disabled id="GRM_1" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 col-md-offset-1">Group Manager 2</div>
                                <div class="col-md-7">
                                    <input disabled id="GRM_2" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 col-md-offset-1">PMO</div>
                                <div class="col-md-7">
                                    <input disabled id="PMO" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
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
                        <div id="tableSG" class="col-md-12" style="bottom:8px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('library.foot')