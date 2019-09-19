<?php

namespace App\Http\Controllers;
use Excel;
use Illuminate\Http\Request;
use DB;
use DateTime;

class OccupationController extends Controller
{

    public function ShowEmployee(Request $request) {
        $RegionID           = $request->RegionID;
        $ListEmployee         = DB::select('call SP_All_Employee_By_Region("'.$RegionID.'")');
        return response()->json($ListEmployee);
    }

    public function ShowColumnChart(Request $request) {
        $RegionID           = $request->Region;
        $Date               = $request->date;
        $ReportType         = $request->ReportType;
        $EmployeeID         = $request->EmployeeID;
        if($EmployeeID == "None")
            $EmployeeID         = "";
        if($ReportType == "Ytd")
            $ListOccupation = DB::select('call SP_OccupationStatisticYTD("'. $RegionID.'","'. $EmployeeID.'","'. $Date.'")');
        else if($ReportType == "Monthly")
            $ListOccupation = DB::select('call SP_OccupationStatisticMonthly("'. $RegionID.'","'. $EmployeeID.'","'. $Date.'")');
        else
            $ListOccupation = DB::select('call SP_OccupationStatisticQuarterly("'. $RegionID.'","'. $EmployeeID.'","'. $Date.'")');

        
        return response()->json($ListOccupation);
    }

    public function FilterTableOccupation(Request $request) {
        $Month           = $request->Month;
        $Year            = $request->Year;
        $ReportType		 = $request->ReportType;
        $TableType       = $request->TableType;
        if($ReportType == "Ytd"){
            $ListUtilization = DB::select('call SP_OccupationRateYTD("'.$Year.'")');
            $ListTotal = DB::select('call SP_OccupationRateTotalYTD("'.$Year.'")');
        }
        else if($ReportType == "Monthly"){
            $ListTotal = DB::select('call SP_OccupationRateTotalMonthly("'.$Year.'")');
            $ListUtilization = DB::select('call SP_OccupationRateMonthly("'.$Year.'")');
        }
        else {
            $ListTotal = DB::select('call SP_OccupationRateTotalQuarterly("'.$Year.'")');
            $ListUtilization = DB::select('call SP_OccupationRateQuarterly("'.$Year.'")');
        }
        $ListRegion = DB::select('call SP_All_Region_By_EmployeeList');
        $returnHTML = view('table_occupation_report', compact('TableType','ListUtilization','ListRegion','Month','ReportType','ListTotal'))->render();
        return response()->json(array('returnHTML' => $returnHTML, 'ListRegion' => $ListRegion));
    } 
}
