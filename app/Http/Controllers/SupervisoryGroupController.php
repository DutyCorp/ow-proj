<?php

namespace App\Http\Controllers;
use Excel;
use Illuminate\Http\Request;
use DB;
use DateTime;

class SupervisoryGroupController extends Controller
{   

	public function DeleteSubordinates(Request $request){
		$Sub_ID             	= $request->Sub_ID;
		DB::select('call SP_DeleteSubordinates("'.$Sub_ID.'")');
		return response()->json("Success Delete Subordinates");
	}
	
	public function SetSubordinates(Request $request){
		$EmployeeID             	= $request->EmployeeID;
		$PM_ID             			= $request->PM_ID;
		for($i = 0; $i < sizeof($EmployeeID); $i++ ){
			if($EmployeeID[$i] != ""){
				if($EmployeeID[$i] != $PM_ID){
					DB::select('call SP_InsertSubordinates("'.$PM_ID.'","'.$EmployeeID[$i].'")');	
				}
			}
		}
		return response()->json("Success Insert Subordinates");
	}

	public function GetTeamLeadRegion(Request $request){
		$PM_ID             		= $request->PM_ID;
		$TLRegion 				= DB::select('call SP_GetTeamLeadRegion("'.$PM_ID.'")');
		return response()->json($TLRegion);
	}

	public function GetDeliveryList(Request $request){
		$RegionID             		= $request->RegionID;
		$ListDelivery 				= DB::select('call SP_All_Delivery_By_Region("'.$RegionID.'")');
		$ListSupervisoryGroup 		= DB::select('call SP_GetAllSupervisoryGroup');
		$SubordinatesID = [];
		$SubordinatesName = [];
		$ProjectLeadID = [];
		$ProjectLeadName = [];
		$ListTable = [];
		for($i = 0; $i < sizeof($ListDelivery); $i++){
			$SubordinatesID[$i] = $ListDelivery[$i]->EmployeeID;
			$SubordinatesName[$i] = $ListDelivery[$i]->EmployeeName;
			$ProjectLeadID[$i] = "";
			for($j = 0; $j < sizeof($ListSupervisoryGroup); $j++){
				if($SubordinatesID[$i] == $ListSupervisoryGroup[$j]->Subordinates){
					$ProjectLeadID[$i] = $ListSupervisoryGroup[$j]->ProjectManager;
				}
			}
		}
		for($i = 0; $i<sizeof($ProjectLeadID); $i++){
			$ProjectLeadName[$i] = "";
			if($ProjectLeadID[$i] != ""){
				$GetData = DB::select('call SP_CheckEmployeeID("'.$ProjectLeadID[$i].'")');	
				$ProjectLeadName[$i] = $GetData[0]->EmployeeName;
			}
		}
		
		for($i = 0; $i<sizeof($SubordinatesID); $i++){
			$ListTable[$i]['SubordinatesID'] = $SubordinatesID[$i];
			$ListTable[$i]['SubordinatesName'] = $SubordinatesName[$i];
			$ListTable[$i]['ProjectLeadID'] = $ProjectLeadID[$i];
			$ListTable[$i]['ProjectLeadName'] = $ProjectLeadName[$i];
		}
		
		$returnHTML = view('table_supervisorygroup', compact('ListTable'))->render();
        return response()->json($returnHTML);
	}
}