<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class RegionSettingController extends Controller
{   
    public function SetMDCost(Request $request)
    {
        $MDCost = $request->MDCost;   
        DB::select('call SP_UpdateMDCost("'.$MDCost.'")');
        return response()->json("Success");
    }

    public function RefreshMDCost(Request $request)
    { 
        $MDCost = DB::select('call SP_All_MDCost');
        return response()->json($MDCost);
    }
    
    public function SaveTarget(Request $request)
    {
        $Year            = $request-> Year;
        $Region          = $request-> Region;
        $Sales_L         = $request-> Sales_L;
        $Sales_M         = $request-> Sales_M;
        $Sales_S         = $request-> Sales_S;
        $Revenue_L       = $request-> Revenue_L;
        $Revenue_M       = $request-> Revenue_M;
        $Revenue_S       = $request-> Revenue_S;
        $Occupation_C    = $request-> Occupation_C;
        $Occupation_U    = $request-> Occupation_U;
        $TargetStatus    = $request-> TargetStatus;
        $Pipeline_L       = $request-> Pipeline_L;
        $Pipeline_M       = $request-> Pipeline_M;
        $Pipeline_S       = $request-> Pipeline_S;

        $Sales_L = preg_replace("/[^a-zA-Z0-9]/", "", $Sales_L);
        $Sales_M = preg_replace("/[^a-zA-Z0-9]/", "", $Sales_M);
        $Sales_S = preg_replace("/[^a-zA-Z0-9]/", "", $Sales_S);
        $Revenue_L = preg_replace("/[^a-zA-Z0-9]/", "", $Revenue_L);
        $Revenue_M = preg_replace("/[^a-zA-Z0-9]/", "", $Revenue_M);
        $Revenue_S = preg_replace("/[^a-zA-Z0-9]/", "", $Revenue_S);
        $Pipeline_L = preg_replace("/[^a-zA-Z0-9]/", "", $Pipeline_L);
        $Pipeline_M = preg_replace("/[^a-zA-Z0-9]/", "", $Pipeline_M);
        $Pipeline_S = preg_replace("/[^a-zA-Z0-9]/", "", $Pipeline_S);
        
        if($TargetStatus == "Entry"){
            DB::select('call SP_InsertTargetSetting("'.$Year.'","'.$Region.'","'.$Sales_M.'","'.$Sales_S.'","'.$Sales_L.'","'.$Revenue_M.'","'.$Revenue_S.'","'.$Revenue_L.'","'.$Occupation_C.'","'.$Occupation_U.'","'.session()->get('EmployeeName').'","'.$Pipeline_M.'","'.$Pipeline_S.'","'.$Pipeline_L.'")');
            return response()->json("Success Entry Target");
        } else {
            DB::select('call SP_UpdateTargetSetting("'.$Year.'","'.$Region.'","'.$Sales_M.'","'.$Sales_S.'","'.$Sales_L.'","'.$Revenue_M.'","'.$Revenue_S.'","'.$Revenue_L.'","'.$Occupation_C.'","'.$Occupation_U.'","'.session()->get('EmployeeName').'","'.$Pipeline_M.'","'.$Pipeline_S.'","'.$Pipeline_L.'")');
            return response()->json("Success Update Target");
        }
    }

    public function CheckTargetData(Request $request)
    {
        $RegionID   = $request->Region;
        $Year       = $request->Year;
        $TargetData = DB::select('call SP_CheckTarget("'.$Year.'","'.$RegionID.'")');
        return response()->json($TargetData);
    }

    public function refreshTableGS(Request $request)
 	{
    	$ListRegions = DB::select('call SP_All_Region');
 		$returnHTML = view('table_regionsetting', compact('ListRegions'))->render();
        return response()->json($returnHTML);
 	}

 	public function EditRegion(Request $request)
 	{
 		$RegionID = $request->RegionID;
    	$ListRegions = DB::select('call SP_GetRegionName("'.$RegionID.'")');
        return response()->json($ListRegions);
 	}
 	
 	public function UpdateRegion(Request $request)
 	{
 		$RegionID = $request->RegionID;
 		$GRM1 = $request->GRM1;
 		$GRM2 = $request->GRM2;
 		$PMO = $request->PMO;
    	DB::select('call SP_UpdateRegion("'.$RegionID.'","'.$GRM1.'","'.$GRM2.'","'.$PMO.'")');
        return response()->json("Success Update");
 	}

 	public function GetProjectLeadList(Request $request)
 	{
 		$RegionID = $request->RegionID;
    	$ListProjectLead = DB::select('call SP_All_ProjectLead_By_Region("'.$RegionID.'")');
 		$returnHTML = view('table_projectlead', compact('ListProjectLead'))->render();
        return response()->json($returnHTML);
 	}

 	public function AddProjectLead(Request $request)
 	{
 		$RegionID = $request->RegionID;
 		$PL_ID = $request->PL_ID;
    	DB::select('call SP_EntryProjectLead("'.$RegionID.'","'.$PL_ID.'")');
        return response()->json("Success Entry Project Lead");
 	}

 	public function DeleteProjectLead(Request $request)
 	{
 		$PL_ID = $request->PL_ID;
    	DB::select('call SP_DeleteProjectLead("'.$PL_ID.'")');
        return response()->json("Success Delete Project Lead");
 	}

 	public function CheckProjectLead(Request $request)
 	{
 		$PL_ID = $request->PL_ID;
    	$PL_Data = DB::select('call SP_GetProjectLeadData("'.$PL_ID.'")');
    	if($PL_Data != null)
    		return response()->json(1);
    	else
    		return response()->json(0);
 	}

 	public function GetListProjectLeadByRegion(Request $request)
 	{
 		$RegionID = $request->RegionID;
    	$ListProjectLead = DB::select('call SP_All_DeliveryManager_RegionSetting("'.$RegionID.'")');
        return response()->json($ListProjectLead);
 	}

}
