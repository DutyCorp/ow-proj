<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use DateTime;

class PermissionController extends Controller
{   
    public function ApprovalPermission(Request $request){
        $PermissionID = $request->PermissionID;        
        $ApprovalID = $request->ApprovalID;
        DB::select('call SP_UpdatePermissionApproval("'.$ApprovalID.'", "'.session()->get('EmployeeID').'", "'.$PermissionID.'")');
        return response()->json("Success Update Permission Approval");
    }

    public function refreshTableApprovalPermission()
    {
        $ListPermissionApproval = DB::select('call SP_All_PermissionAttendance_Approval');
        $returnHTML = view('table_permissionattendance_approval', compact('ListPermissionApproval'))->render();
        return response()->json($returnHTML);
    }

    public function GetAllPT()
    {
        $ListPermissionType = DB::select('call SP_All_PermissionType');
        return response()->json($ListPermissionType);
    }

    public function UpdatePermissionType(Request $request){
        $ID = $request->ID;        
        $Name = $request->Name;DB::select('call SP_UpdatePermissionType("'.$ID.'", "'.$Name.'")');
        return response()->json("Success Update Permission Type");
    } 

    public function EditPermissionType(Request $request){
        $ID = $request->ID;
        $PTData    = DB::select('call SP_GetPermissionTypeData("'.$ID.'")');
        return response()->json($PTData);
    } 

    public function DeletePermissionType(Request $request)
    {
        $ID = $request->ID;
        DB::select('call SP_DeletePermissionType("'.$ID.'")');  
        return response()->json('Success Delete Permission Type');
    }
    
    public function EntryPermissionType(Request $request)
    {
        $ID = $request->ID;        
        $Name = $request->Name;

        DB::select('call SP_EntryPermissionType("'.$ID.'", "'.$Name.'")');
        return response()->json('Success Entry Permission Type');
    }

    public function CheckPermissionTypeID(Request $request){
        $RawPermissionID    = DB::select('call SP_CheckPermissionTypeID');
        $PermissionIDSplit  = explode('P', $RawPermissionID[0]->PermissionID);
        $Count = sprintf('%02d', $PermissionIDSplit[1]);
        return response()->json($Count);
    }   

    public function RefreshTablePT()
    {
        $ListPermissionType = DB::select('call SP_All_PermissionType');
        $returnHTML = view('table_permissiontype', compact('ListPermissionType'))->render();
        return response()->json($returnHTML);
    }

    public function doEntryPermission(Request $request)
    {
        $PermitID = $request->permitID;        
        $PermitDate = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $request->permitDate))->format('Y-m-d');
        $PermitType = $request->permitType;    $PermitNotes = $request->permitNotes;
        $PermitEmployeeID = $request->permitEmployeeID;
        $coorID = $request->coorID;
        DB::select('call SP_InsertPermissionAttendance("'.$PermitID.'","'.$PermitEmployeeID.'","'.$PermitDate.'","'.$PermitType.'","'.$PermitNotes.'", "'.session()->get('EmployeeID').'","'.$coorID.'")');
        return response()->json('Success Entry Permission');
    }

    public function doRefreshTablePermission()
    {
        $ListPermissionAttendance = DB::select('call SP_ShowTablePermissionAttendance("'.session()->get('EmployeeID').'")');
        $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC03")');
        $returnHTML = view('table_permissionattendance', compact('ListPermissionAttendance', 'rolemenus'))->render();
        return response()->json($returnHTML);
    }

    public function refreshTablePermissionAttendanceHistory()
    {
        $ListPermissionAttendance = DB::select('call SP_All_PermissionAttendance');
        $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC16")');
        $returnHTML = view('table_permissionattendance_history', compact('ListPermissionAttendance', 'rolemenus'))->render();
        return response()->json($returnHTML);
    }

    public function CheckPermissionID(Request $request){
        $PermitID = $request->permitID;
        $Count = DB::select('call SP_CheckPermissionID("'.$PermitID.'")');
        return response()->json($Count[0]->Count);
    }

    public function showPermissionData(Request $request)
    {
        $PermitID = $request->permitID;
        $EditData = DB::select('call SP_SelectEditPermissionData("'.$PermitID.'")');
        return response()->json($EditData);
    }

    public function UpdatePermissionData(Request $request)
    {
        $PermitID = $request->permitID;
        $PermitDate = $request->permitDate;
        $PermitType = $request->permitType;        
        $PermitNotes = $request->permitNotes;
        $CoorID = $request->coorID;
        DB::select('call SP_UpdatePermissionAttendance("'.date('Y-m-d H:i:s').'","'.$PermitType.'","'.$PermitDate.'","'.$PermitNotes.'","'.$PermitID.'", "'.session()->get('EmployeeID').'","'.$CoorID.'")');
        return response()->json('Success Update Permission');
    }

    public function DeletePermissionData(Request $request)
    {

        $PermitID = $request->permitID;
        $getEmployeeID = DB::select('call SP_CheckPermissionDeleteData("'.$PermitID.'")');
        $TotalIsActive = DB::select('call SP_CheckPermissionData("'.$getEmployeeID[0]->EmployeeID.'","'.$getEmployeeID[0]->Date.'","'.$getEmployeeID[0]->PermissionID.'")');
        $TotalIsActive[0]->isActive += 1;
        DB::select('call SP_DeletePermissionAttendance("'.$TotalIsActive[0]->isActive.'","'.$PermitID.'", "'.session()->get('EmployeeID').'")');  
        return response()->json('Success Delete Permission');
    }

}
