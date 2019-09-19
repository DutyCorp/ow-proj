<script src="{{asset('js/TableProjectLead.js')}}"></script>
<table id="TableRegionProjectLead" class="table table-bordered" style="font-size:12px">
    <thead style="background-color:#ECECEC;font-weight:bold">
        <tr>
            <th style="text-align:center">Region</th>
            <th style="text-align:center">Project Lead</th>
            <th style="text-align:center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ListProjectLead as $PL)
            <tr>
                <td style="padding:3px 10px 1px">{{ $PL->Region }}</td>
                <td style="padding:3px 10px 1px">{{ $PL->ProjectLead }}</td>
                <td align="center" style="padding:0px">
                    <button style="padding:0px 1px" value="{{ $PL->ProjectLeadID }}" class="ChooseDeletePL btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>