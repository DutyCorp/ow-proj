<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function getTimestamp(){
    	return response()->json(date('H:i:s'));
    }

    public function getAttendanceReportData(Request $request){
    	$EmployeeID         = $request->EmployeeID;
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;

    	$Row = DB::select('call SP_Attendance_Report_Individual_Name_Date("'.$EmployeeID.'", "'.$DateFrom.'", "'.$DateTo.'")');
    	return response()->json($Row);
    }

    public function getModule(Request $request){
        $moduleid = $request->moduleid;

        if ($moduleid == 1){
            $RawData = DB::select('call SP_OWASalesAchievement("'.date('Y').'")');
            $Achievement = $RawData[0]->Achievement;
            $RawData = DB::select('call SP_OWASalesAmountExpected("'.date('Y').'")');
            $AmountExpected = $RawData[0]->AmountExpected;
            $RawData = DB::select('call SP_OWASalesAmountWon("'.date('Y').'")');
            $AmountWon = $RawData[0]->AmountWon;
            $RawData = DB::select('call SP_OWASalesPipeline("'.date('Y').'")');
            $Pipeline = $RawData[0]->Pipeline;
            $ListChartData = DB::select('call SP_OWASalesByRegion("'.date('Y').'")');
            $returnHTML = view('dashboard_modules/module'.$moduleid, compact('ListChartData', 'Achievement', 'AmountExpected', 'AmountWon', 'Pipeline'))->render();
        } else if ($moduleid == 2){
            $ListChartData = DB::select('call SP_SalesTrendLine');
            $returnHTML = view('dashboard_modules/module'.$moduleid, compact('ListChartData'))->render();
        } else if ($moduleid == 3){
            $RawData = DB::select('call SP_OWARevenueAchievement("'.date('Y').'")');
            $Achievement = $RawData[0]->Achievement;
            $RawData = DB::select('call SP_OWARevenueExpected("'.date('Y').'")');
            $AmountExpected = $RawData[0]->AmountExpected;
            $RawData = DB::select('call SP_OWARevenueAmountInvoiced("'.date('Y').'")');
            $AmountInvoice = $RawData[0]->AmountInvoice;
            $RawData = DB::select('call SP_OWARevenueOpenPosition("'.date('Y').'")');
            $OpenInvoiceCurrentYear = $RawData[0]->OpenPosition;
            $RawData = DB::select('call SP_OWAAllRevenueOpenPosition');
            $OpenInvoiceAll = $RawData[0]->OpenPosition;
            $ListChartData = DB::select('call SP_OWARevenueByRegion("'.date('Y').'")');
            $returnHTML = view('dashboard_modules/module'.$moduleid, compact('ListChartData', 'Achievement', 'AmountExpected', 'AmountInvoice', 'OpenInvoiceCurrentYear', 'OpenInvoiceAll'))->render();
        } else if ($moduleid == 4){
            $ListChartData = DB::select('call SP_Top5ClosedDeals("'.date('Y').'")');
            $returnHTML = view('dashboard_modules/module'.$moduleid, compact('ListChartData'))->render();
        } else if ($moduleid == 5){
            $ListChartData = DB::select('call SP_CriticalProject');
            $Query = DB::select('call SP_All_MDCost');
            $MDCost = $Query[0]->MDCost;
            $returnHTML = view('dashboard_modules/module'.$moduleid, compact('ListChartData', 'MDCost'))->render();
        } else if ($moduleid == 6){
            $ListChartData = DB::select('call SP_MilestoneThisMonth');
            $returnHTML = view('dashboard_modules/module'.$moduleid, compact('ListChartData'))->render();
        } else if ($moduleid == 7){
            $ListChartData = DB::select('call SP_StaffPerformance');
            $returnHTML = view('dashboard_modules/module'.$moduleid, compact('ListChartData'))->render();
        } else if ($moduleid == 8){
            $ListChartData = DB::select('call SP_NewProject');
            $returnHTML = view('dashboard_modules/module'.$moduleid, compact('ListChartData'))->render();
        } else if ($moduleid == 9){
            $ListChartData = DB::select('call SP_ClosedProject');
            $returnHTML = view('dashboard_modules/module'.$moduleid, compact('ListChartData'))->render();
        } else if ($moduleid == 10){
            $DateFrom = date('Y-01-01');
            $DateTo = date('Y-m-d');
            $ListChartData = DB::select('call SP_Attendance_Report_Region_All("'.$DateFrom.'", "'.$DateTo.'")');
            $DateFrom = date('d F Y', strtotime(date('Y-01-01')));
            $DateTo = date('d F Y');
            $returnHTML = view('dashboard_modules/module'.$moduleid, compact('ListChartData', 'DateFrom', 'DateTo'))->render();
        } else if ($moduleid == 11){
            $ListChartData = DB::select('call SP_Birthday("'.date('Y-m-d').'")');
            $returnHTML = view('dashboard_modules/module'.$moduleid, compact('ListChartData'))->render();
        } else if ($moduleid == 12){
            $ListChartAttendanceData = DB::select('call SP_Attendance_Report_Individual_Name_Date("'.session()->get('EmployeeID').'", "'.date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1)).'", "'.date("Y-m-d", mktime(0, 0, 0, date("m"), 0)).'")');
            $EmployeeData = DB::select('call SP_GetEmployeeData("'. session()->get('EmployeeID').'")');
            $RegionID = $EmployeeData[0]->RegionID;
            $ListChartOccupationData = DB::select('call SP_OccupationStatisticYTD("'. $RegionID.'","'. session()->get('EmployeeID').'", "'.date("Ym", mktime(0, 0, 0, date("m")-1, 1)).'")');
            $Month = date("F Y", mktime(0, 0, 0, date("m")-1, 1));
            $returnHTML = view('dashboard_modules/module'.$moduleid, compact('ListChartAttendanceData', 'ListChartOccupationData', 'Month'))->render();
        } else {
            $returnHTML = view('dashboard_modules/module'.$moduleid)->render();
        }
        return response()->json(array('returnHTML' => $returnHTML, 'moduleid' => $moduleid));
    }
}
