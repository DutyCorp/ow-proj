<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RoleController extends Controller
{
    public function SubmitRole(Request $request){
    	$RoleID            = $request->RoleID;
    	$RoleName          = $request->RoleName;
    	$MenuChildID       = $request->MenuChildID;
    	$RoleAccess        = $request->RoleAccess;
    	$RegionVisibility  = $request->RegionVisibility;
    	$RegionID          = $request->RegionID;
        $Grade             = $request->Grade;
        $GradeID           = $request->GradeID;
        
    	DB::select('call SP_InsertRole("'.$RoleID.'", "'.$RoleName.'")');
        
    	for ($i = 0; $i < sizeof($MenuChildID); $i++){
    		$RawRoleMenuID    = DB::select('call SP_GetLatestRoleMenuID');
            $RoleMenuSplit    = explode('RM', $RawRoleMenuID[0]->RoleMenuID);
    		$RoleMenuNumber   = sprintf('%04d', $RoleMenuSplit[1]+1);
    		$RoleMenuID       = 'RM'.$RoleMenuNumber;
    		DB::select('call SP_InsertRoleMenu("'.$RoleMenuID.'", "'.$RoleID.'", "'.$MenuChildID[$i].'", '.$RoleAccess[$i][1].', '.$RoleAccess[$i][2].', '.$RoleAccess[$i][3].', '.$RoleAccess[$i][0].', "'.session()->get('EmployeeID').'")');
        }

    	for ($j = 0; $j < sizeof($RegionVisibility); $j++){
    		DB::select('call SP_InsertRegionVisibility("'.$RoleID.'", "'.$RegionID[$j].'", '.$RegionVisibility[$j].', "'.session()->get('EmployeeID').'")');
        }

        for ($k = 0; $k < sizeof($Grade); $k++){
            DB::select('call SP_InsertRoleGrade("'.$RoleID.'", "'.$GradeID[$k].'", '.$Grade[$k].', "'.session()->get('EmployeeID').'")');
        }

    	return response()->json($this->GenerateRoleID());
    }

    private function GenerateRoleID(){
        $rawroles       = DB::select('call SP_GetLatestRoleID');
    	$rolesplit      = explode("R", $rawroles[0]->RoleID);
		$rolenumber     = sprintf('%02d', $rolesplit[1]+1);

		$newroleid      = 'R'.$rolenumber;

    	return $newroleid;
    }

    public function GetRoleData(Request $request){
    	$RoleID             = $request->RoleID;
        $rolemenus          = DB::select('call SP_GetRoleMenu("'.$RoleID.'")');
    	$rolename           = DB::select('call SP_GetRoleName("'.$RoleID.'")');
    	$regionvisibility   = DB::select('call SP_GetRegionVisibilityData("'.$RoleID.'")');
        $grade              = DB::select('call SP_GetRoleGradeData("'.$RoleID.'")');

    	return response()->json(array('rolemenu' => $rolemenus, 'regionvisibility' => $regionvisibility, 'rolename' => $rolename, 'grade' => $grade));
    }

    public function UpdateRole(Request $request){
    	$RoleID            = $request->RoleID;
    	$RoleName          = $request->RoleName;
    	$MenuChildID       = $request->MenuChildID;
    	$RoleAccess        = $request->RoleAccess;
    	$RegionVisibility  = $request->RegionVisibility;
    	$RegionID          = $request->RegionID;
        $Grade             = $request->Grade;
        $GradeID           = $request->GradeID;

        DB::select('call SP_UpdateRole("'.$RoleID.'", "'.$RoleName.'")');

    	for ($i = 0; $i < sizeof($MenuChildID); $i++){
            $CountRoleMenu       = DB::select('call SP_CountRoleMenu("'.$RoleID.'", "'.$MenuChildID[$i].'")');
    		if ($CountRoleMenu[0]->Count == 1){
                DB::select('call SP_UpdateRoleMenu("'.$RoleID.'", "'.$MenuChildID[$i].'", '.$RoleAccess[$i][1].', '.$RoleAccess[$i][2].', '.$RoleAccess[$i][3].', '.$RoleAccess[$i][0].', "'.session()->get('EmployeeID').'")');
    		} else {
    			$RawRoleMenuID   = DB::select('call SP_GetLatestRoleMenuID');
    			$RoleMenuSplit   = explode('RM', $RawRoleMenuID[0]->RoleMenuID);
    			$RoleMenuNumber  = sprintf('%04d', $RoleMenuSplit[1]+1);
    			$RoleMenuID      = 'RM'.$RoleMenuNumber;
    			DB::select('call SP_InsertRoleMenu("'.$RoleMenuID.'", "'.$RoleID.'", "'.$MenuChildID[$i].'", '.$RoleAccess[$i][1].', '.$RoleAccess[$i][2].', '.$RoleAccess[$i][3].', '.$RoleAccess[$i][0].', "'.session()->get('EmployeeID').'")');
    		}
    	}

    	for ($j = 0; $j < sizeof($RegionVisibility); $j++){
    		$CountRegionVisibility = DB::select('call SP_CountRegionVisibility("'.$RoleID.'", "'.$RegionID[$j].'")');
    		if ($CountRegionVisibility[0]->Count == 1){
    			DB::select('call SP_UpdateRegionVisibility("'.$RoleID.'", "'.$RegionID[$j].'", '.$RegionVisibility[$j].', "'.session()->get('EmployeeID').'")');
            } else {
    			DB::select('call SP_InsertRegionVisibility("'.$RoleID.'", "'.$RegionID[$j].'", '.$RegionVisibility[$j].', "'.session()->get('EmployeeID').'")');
    		}
    	}

        for ($k = 0; $k < sizeof($Grade); $k++){
            $CountGrade = DB::select('call SP_CountRoleGrade("'.$RoleID.'", "'.$GradeID[$k].'")');
            if ($CountGrade[0]->Count == 1){
                DB::select('call SP_UpdateRoleGrade("'.$RoleID.'", "'.$GradeID[$k].'", '.$Grade[$k].', "'.session()->get('EmployeeID').'")');
            } else {
                DB::select('call SP_InsertRoleGrade("'.$RoleID.'", "'.$GradeID[$k].'", '.$Grade[$k].', "'.session()->get('EmployeeID').'")');
            }
        }

    	return response()->json($this->GenerateRoleID());
    }

    public function DeleteRole(Request $request){
    	$RoleID = $request->RoleID;

    	DB::select('call SP_DeleteRoleMenu("'.$RoleID.'")');
        DB::select('call SP_DeleteRegionVisibility("'.$RoleID.'")');
        DB::select('call SP_DeleteRoleGrade("'.$RoleID.'")');
        DB::select('call SP_DeleteRole("'.$RoleID.'")');

    	return response()->json($this->GenerateRoleID());
    }

    public function GetNewRole(){
    	return response()->json($this->GenerateRoleID());
    }

    public function RefreshRoleList(){
        $rolemenus  = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC09")');
    	$roles      = DB::select('call SP_GetAllRole');

    	$returnHTML = view('rolelist', compact('roles', 'rolemenus'))->render();
    	return response()->json($returnHTML);
    }
}
