<?php

namespace App\Http\Controllers;
use Excel;
use Illuminate\Http\Request;
use DB;

class LeaveController extends Controller
{
    public function FilterLeaveReport(Request $request) {
        $Region = $request->Region;

        if ($Region == 'All'){
            $ListLeave  = DB::select('call SP_GetLeaveReportData');
        } else {
            $ListLeave  = DB::select('call SP_GetLeaveReportDataFilterRegion("'.$Region.'")');
        }
        return response()->json($ListLeave);
    }
}
