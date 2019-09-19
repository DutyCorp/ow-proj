<script src="{{asset('js/TableSupervisoryGroup.js')}}"></script>
<table id="SubordinateTable" class="table table-bordered" style="font-size:12px">
    <thead style="background-color:#ECECEC;font-weight:bold">
        <tr>
            <th></th>
            <th>Subordinates</th>
            <th>Team Lead</th>
        </tr>
    </thead>
    <tbody>
        @for($i = 0; $i < sizeof($ListTable); $i++)
        <tr>
            @if( $ListTable[$i]['ProjectLeadName']  != "")
                <th style="padding:0px; text-align: center;">
                    <input value="{{ $ListTable[$i]['SubordinatesID'] }}" class="cbxSubordinates" type="checkbox" checked>
                    <!--<button style="padding:0px 1px" value="{{ $ListTable[$i]['SubordinatesID'] }}" class="ChooseDeleteSG btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>-->
                </th>
            @else
                <th style="padding:0px; text-align: center;">
                    <input value="{{ $ListTable[$i]['SubordinatesID'] }}" class="cbxSubordinates" type="checkbox">
                    <!--<button disabled style="padding:0px 1px" value="" class="ChooseDeleteSG btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>-->
                </th>
            @endif
            
            <th style="padding:3px 10px 1px" class="SubName" value="{{ $ListTable[$i]['SubordinatesID'] }}">{{ $ListTable[$i]['SubordinatesName'] }}</th>
            <th style="padding:3px 10px 1px" class="PLName" >{{ $ListTable[$i]['ProjectLeadName'] }}</th>
        </tr>
        @endfor
    </tbody>
</table>