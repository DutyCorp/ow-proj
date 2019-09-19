<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ClaimReportController extends Controller
{
    public function GetClaimReportData(Request $request){
    	$Region = $request->Region;
        $SubmissionDateFrom = $request->SubmissionDateFrom;
        $SubmissionDateTo = $request->SubmissionDateTo;
        $ApprovalDateFrom = $request->ApprovalDateFrom;
        $ApprovalDateTo = $request->ApprovalDateTo;
    	$ViewType = $request->ViewType;

        if ($ViewType == "Project"){
            $ListClaimReport = DB::select('call SP_ClaimReportViewByProject("'.session()->get('EmployeeID').'", "'.$Region.'", "'.$SubmissionDateFrom.'", "'.$SubmissionDateTo.'", "'.$ApprovalDateFrom.'", "'.$ApprovalDateTo.'")');
            $TECodes = DB::select('call SP_GetTECode("'.session()->get('EmployeeID').'", "'.$Region.'", "'.$SubmissionDateFrom.'", "'.$SubmissionDateTo.'", "'.$ApprovalDateFrom.'", "'.$ApprovalDateTo.'")');
            if (empty($TECodes)){
                $CountTable = 0;
            } else {
                $CountTable = sizeof($TECodes);
            }
            $LastsUpdate = DB::select('call SP_GetClaimLatestUpdate');
            $returnHTML = view('table_claimreportproject', compact('ListClaimReport', 'CountTable', 'TECodes', 'LastsUpdate'))->render();
            return response()->json($returnHTML);
        } else if ($ViewType == "Employee") {
            $ListClaimReport = DB::select('call SP_ClaimReportViewByEmployee("'.session()->get('EmployeeID').'", "'.$Region.'", "'.$SubmissionDateFrom.'", "'.$SubmissionDateTo.'", "'.$ApprovalDateFrom.'", "'.$ApprovalDateTo.'")');
            $TECodes = DB::select('call SP_GetTECode("'.session()->get('EmployeeID').'", "'.$Region.'", "'.$SubmissionDateFrom.'", "'.$SubmissionDateTo.'", "'.$ApprovalDateFrom.'", "'.$ApprovalDateTo.'")');
            if (empty($TECodes)){
                $CountTable = 0;
            } else {
                $CountTable = sizeof($TECodes);
            }
            $LastsUpdate = DB::select('call SP_GetClaimLatestUpdate');
            $returnHTML = view('table_claimreportemployee', compact('ListClaimReport', 'CountTable', 'TECodes', 'LastsUpdate'))->render();
            return response()->json($returnHTML);
        } else if ($ViewType == "TEType"){
            $ListClaimReport = DB::select('call SP_ClaimReportViewByTEType("'.session()->get('EmployeeID').'", "'.$Region.'", "'.$SubmissionDateFrom.'", "'.$SubmissionDateTo.'", "'.$ApprovalDateFrom.'", "'.$ApprovalDateTo.'")');
            $LastsUpdate = DB::select('call SP_GetClaimLatestUpdate');
            $returnHTML = view('table_claimreportte', compact('ListClaimReport', 'LastsUpdate'))->render();
            return response()->json($returnHTML);
        } else if ($ViewType == "Department"){
            try {
                $ListClaimReport = DB::select('call SP_ClaimReportViewByDepartment("'.session()->get('EmployeeID').'", "'.$Region.'", "'.$SubmissionDateFrom.'", "'.$SubmissionDateTo.'", "'.$ApprovalDateFrom.'", "'.$ApprovalDateTo.'")');
            } catch (\Illuminate\Database\QueryException $e) {
                $LastsUpdate = DB::select('call SP_GetClaimLatestUpdate');
                $returnHTML = view('table_claimreportnotavailable', compact('LastsUpdate'))->render();
                return response()->json($returnHTML);
            }
            $LastsUpdate = DB::select('call SP_GetClaimLatestUpdate');
            $ProjectNames = DB::select('call SP_GetProjectClaimDepartment("'.session()->get('EmployeeID').'", "'.$Region.'", "'.$SubmissionDateFrom.'", "'.$SubmissionDateTo.'", "'.$ApprovalDateFrom.'", "'.$ApprovalDateTo.'")');
            if (empty($ProjectNames)){
                $CountTable = 0;
            } else {
                $CountTable = sizeof($ProjectNames);
            }
            $returnHTML = view('table_claimreportdepartment', compact('ListClaimReport', 'CountTable', 'ProjectNames', 'LastsUpdate'))->render();
            return response()->json($returnHTML);
        }    	
    }

    public function GetPersonalClaimReportData(Request $request){
        $EmployeeID = $request->EmployeeID;
        $SubmissionDateFrom = $request->SubmissionDateFrom;
        $SubmissionDateTo = $request->SubmissionDateTo;
        $ApprovalDateFrom = $request->ApprovalDateFrom;
        $ApprovalDateTo = $request->ApprovalDateTo;

        $ListClaimReport = DB::select('call SP_PersonalClaim("'.$EmployeeID.'", "'.$SubmissionDateFrom.'", "'.$SubmissionDateTo.'", "'.$ApprovalDateFrom.'", "'.$ApprovalDateTo.'")');
        $returnHTML = view('table_personalclaimreport', compact('ListClaimReport'))->render();
        return response()->json($returnHTML);
    }
}
