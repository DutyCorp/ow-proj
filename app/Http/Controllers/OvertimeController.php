<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    
    public function CheckOvertimeID(Request $request)
    {
        $CheckingOvertimeID         = $request->CheckingOvertimeID;
        $CountID                    = DB::select('call SP_CheckOvertimeID("'.$CheckingOvertimeID.'")');
        if($CountID == null)
            return response()->json(0);
        else
            return response()->json($CountID);
    }

    public function GetEmployeeName(Request $request)
    {
        $EmployeeID         = $request->EmployeeID;
        $EmployeeName       = DB::select('call SP_GetEmployeeData("'.$EmployeeID.'")');
        return response()->json($EmployeeName);
    }

    public function EntryOvertime(Request $request)
 	{
        
        $OvertimeID     = $request->OvertimeID;
 		$Employee 		= $request->Employee;
 		$Manager 		= $request->Manager;
 		$OvertimeDate 	= $request->OvertimeDate;
 		$Type 			= $request->Type;
 		$Notes 			= $request->Notes;

        try { 
            DB::select('call SP_InsertOvertime("'.$Employee.'","'.$Manager.'",1,"'.$Type.'","'.$OvertimeDate.'","'.$Notes.'","'.session()->get('EmployeeID').'","'.$OvertimeID.'")');
        } catch(\Illuminate\Database\QueryException $ex){ 
            return response()->json(0);
        }

    	return response()->json("Success Entry Overtime!");
 	}

 	public function refreshTableOvertime()
 	{
 		$ListOvertime = DB::select('call SP_All_OvertimeEntry("'.session()->get('EmployeeID').'")');
        $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC17")');
 		$returnHTML = view('table_overtime', compact('ListOvertime', 'rolemenus'))->render();
        return response()->json($returnHTML);
 	}

 	public function DeleteOverTime(Request $request)
    {
    	$OvertimeID = $request->OvertimeID;
    	DB::select('call SP_DeleteOvertime("'.session()->get('EmployeeID').'","'.$OvertimeID.'")');
    	return response()->json('Success Delete Overtime');
    }

    public function ApprovalOvertime(Request $request)
    {
    	$OvertimeID = $request->OvertimeID;
    	$ApprovalID = $request->ApprovalID;
    	
    	DB::select('call SP_UpdateOvertimeApproval("'.$ApprovalID.'","'.session()->get('EmployeeID').'","'.$OvertimeID.'")');

    	return response()->json('Success Update Overtime');
    }

    public function refreshTableApprovalOvertime()
 	{
        $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC18")');
 		$ListOvertime = DB::select('call SP_All_OvertimeApproval("'.session()->get('EmployeeID').'")');
 		$returnHTML = view('table_overtime_approval', compact('ListOvertime', 'rolemenus'))->render();
        return response()->json($returnHTML);
 	}
 	
    public function EditOverTime(Request $request)
    {
        $OvertimeID = $request->OvertimeID;
        $OvertimeData = DB::select('call SP_SelectEditOvertimeData("'.$OvertimeID.'")');
        return response()->json($OvertimeData);
    }
    
    public function UpdateOvertime(Request $request)
    {
        $OvertimeID = $request->OvertimeID;
        $Manager = $request->Manager;
        $OvertimeDate = $request->OvertimeDate;
        $OvertimeType = $request->Type;
        $Notes = $request->Notes;
        try { 
            DB::select('call SP_UpdateOvertimeData("'.$Manager.'","'.$OvertimeType.'","'.$Notes.'","'.$OvertimeDate.'","'.session()->get('EmployeeID').'","'.$OvertimeID.'")');
        } catch(\Illuminate\Database\QueryException $ex){ 
            return response()->json(0);
        }
        return response()->json("Success Update Overtime");
    }

    public function refreshTableHistoryOvertime()
    {
        $ListOvertime = DB::select('call SP_All_Overtime_No_Filter');
        $returnHTML = view('table_overtime_history', compact('ListOvertime'))->render();
        return response()->json($returnHTML);
    }

    public function FilterDateHistoryOvertime(Request $request)
    {
        $DateFrom = $request->DateFrom;
        $DateTo = $request->DateTo;
        $ListOvertime = DB::select('call SP_All_Overtime_DateFilter("'.$DateFrom.'","'.$DateTo.'")');
        $returnHTML = view('table_overtime_history', compact('ListOvertime'))->render();
        return response()->json($returnHTML);
    }
}
