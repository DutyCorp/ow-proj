<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use DateTime;

class ResourceAllocationController extends Controller
{
    public function UpdatePP(Request $request)
    {
        $Year        = $request-> Year;
        $Code        = $request-> Code;
        $BA          = $request-> BA;
        $Name        = $request-> Name;
        $MDPlan      = $request-> MDPlan;
        $Opportunity = $request-> Opportunity;
        $StartDate   = $request-> StartDate;
        DB::select('call SP_Update_ProspectProject("'.$Name.'","'.$MDPlan.'","'.$Opportunity.'","'.$StartDate.'","'.$Code.'","'.$Year.'", "'.$BA.'" )');
        return response()->json("Success Update Prospect Project");
    }

    public function EditPP(Request $request)
    {
        $Code        = $request-> ID;
        $NewCode     = explode(",",$Code);
        $Data = DB::select('call SP_Edit_ProspectProject("'.$NewCode[0].'","'.$NewCode[1].'")');
        return response()->json($Data);
    }

    public function DeletePP(Request $request)
    {
        $Code        = $request-> ID;
        $NewCode     = explode(",",$Code);
        DB::select('call SP_Delete_ProspectProject("'.$NewCode[0].'","'.$NewCode[1].'")');
        DB::select('call SP_Delete_ProspectProject_Contribute("'.$NewCode[0].'","'.$NewCode[1].'")');
        return response()->json("Success Delete Prospect Project");
    }

    public function RefreshProspectProject()
    {
        $ListProspectProject = DB::select('call SP_All_ProspectProject');
        $returnHTML = view('table_list_prospectproject', compact('ListProspectProject'))->render();
        return response()->json($returnHTML);
    }

    public function UpdateNE(Request $request)
    {
        $SWD        = $request-> SWD;
        $Code        = $request-> ID;
        $Data = DB::select('call SP_Update_NewEmployee("'.$SWD.'","'.$Code.'")');
        return response()->json("Success Update New Employee");
    }

    public function EditNE(Request $request)
    {
        $Code        = $request-> ID;
        $Data = DB::select('call SP_Edit_NewEmployee("'.$Code.'")');
        return response()->json($Data);
    }

    public function DeleteNE(Request $request)
    {
        $Code        = $request-> ID;
        DB::select('call SP_Delete_NewEmployee("'.$Code.'")');
        return response()->json("Success Delete New Employee");
    }

    public function RefreshNewEmployee()
    {
        $ListNewEmployee = DB::select('call SP_All_NewEmployee');
        $returnHTML = view('table_list_newemployee', compact('ListNewEmployee'))->render();
        return response()->json($returnHTML);
    }

    public function CheckProspectProject(Request $request)
    {
        $Code        = $request-> Code;
        $Year        = $request-> Year;
        $Data = DB::select('call SP_Check_ResourceAllocation_ProspectProject("'.$Code.'","'.$Year.'")');
        return response()->json($Data);
    }

    public function CheckNewEmployee(Request $request)
    {
        $Code        = $request-> ID;
        $Year        = $request-> Year;
        $Data = DB::select('call SP_Check_ResourceAllocation_NewEmployee("'.$Code.'","'.$Year.'")');
        return response()->json($Data);
    }

    public function DeleteNEContributing(Request $request)
    {
        $Code        = $request-> Code;
        DB::select('call SP_Delete_ResourceAllocation_Contributing_NewEmployee("'.$Code.'")');
        return response()->json("Success Delete Contributing New Employee");
    }

    public function InsertNewEmployeeContributing(Request $request)
    {
        $Code        = $request-> Code;
        DB::select('call SP_Insert_ResourceAllocation_Contributing_NewEmployee("'.$Code.'")');
        return response()->json("Success Entry Contributing New Employee");
    }

    public function DeleteContributing(Request $request)
    {
        $Year        = $request-> Year;
        $Region      = $request-> Region;
        $Code        = $request-> Code;
        $NewCode     = explode(",",$Code);
        DB::select('call SP_Delete_ResourceAllocation_Contributing("'.$NewCode[0].'","'.$Region.'","'.$Year.'","'.$NewCode[1].'")');
        return response()->json("Success Delete Contributing Prospect Project");
    }

    public function refreshTableProspectProject(Request $request)
    {
        $Region                 = $request-> Region;
        $Year                   = $request-> Year;
        $ListProspectProject    = DB::select('call SP_All_ResourceAllocation_ProspectProject("'.$Year.'","'.$Region.'")');
        $returnHTML = view('table_prospectproject', compact('ListProspectProject', 'Region', 'Year'))->render();
        return response()->json($returnHTML);
    }

    public function InsertProspectProjectContributing(Request $request)
    {
        $Year        = $request-> Year;
        $Region      = $request-> Region;
        $Code        = $request-> Code;
        $NewCode     = explode(",",$Code);
        DB::select('call SP_Insert_ResourceAllocation_ProspectProject_Contributing("'.$NewCode[0].'","'.$Region.'","'.$Year.'","'.$NewCode[1].'")');
        return response()->json("Success Entry Contributing Prospect Project");
    }   

    public function InsertProspectProject(Request $request)
    {
        $Year        = $request-> Year;
        $Region      = $request-> Region;
        $BA          = $request-> BA;
        $Code        = $request-> Code;
        $Name        = $request-> Name;
        $MDPlan      = $request-> MDPlan;
        $Opportunity = $request-> Opportunity;
        $StartDate   = $request-> StartDate;
        DB::select('call SP_Insert_ResourceAllocation_ProspectProject("'.$Code.'", "'.$Name.'", "'.$Region.'", "'.$Year.'", "'.$MDPlan.'", "'.$Opportunity.'", "'.$StartDate.'", "'.session()->get('EmployeeID').'", "'.$BA.'")');
        DB::select('call SP_Insert_ResourceAllocation_ProspectProject_Contributing("'.$Code.'",NULL,NULL,"'.$Year.'")');
        return response()->json("Success Entry Prospect Project");
    }   

    public function CheckWorkingDay(Request $request)
    {
        $Year    = $request-> Year;
        $Region  = $request-> Region;
        $ListWorkingDay = DB::select('call SP_CheckWorkingDay("'.$Region.'", "'.$Year.'")');
        return response()->json($ListWorkingDay);
    }

    public function SaveWorkingDay(Request $request)
    {
        $Year    = $request-> Year;
        $Region  = $request-> Region;
        $M1      = $request-> M1;
        $M2      = $request-> M2;
        $M3      = $request-> M3;
        $M4      = $request-> M4;
        $M5      = $request-> M5;
        $M6      = $request-> M6;
        $M7      = $request-> M7;
        $M8      = $request-> M8;
        $M9      = $request-> M9;
        $M10     = $request-> M10;
        $M11     = $request-> M11;
        $M12     = $request-> M12;
        $WD_status = $request-> WD_status;

        if($WD_status == "Entry"){
            DB::select('call SP_Insert_ResourceAllocation_WorkingDay("'.$Region.'", "'.$Year.'", "'.$M1.'", "'.$M2.'","'.$M3.'","'.$M4.'","'.$M5.'","'.$M6.'","'.$M7.'","'.$M8.'","'.$M9.'","'.$M10.'","'.$M11.'","'.$M12.'")');
            return response()->json("Succes Entry Working Day");
        }else{
            DB::select('call SP_Update_ResourceAllocation_WorkingDay("'.$Region.'", "'.$Year.'", "'.$M1.'", "'.$M2.'","'.$M3.'","'.$M4.'","'.$M5.'","'.$M6.'","'.$M7.'","'.$M8.'","'.$M9.'","'.$M10.'","'.$M11.'","'.$M12.'")');    
            return response()->json("Succes Update Working Day");
        }
            
    }

    public function refreshTableNewEmployee(Request $request)
    {
        $Year    = $request-> Year;
        $Region  = $request-> Region;
        $ListNewEmployee = DB::select('call SP_ALL_ResourceAllocation_Employee("'.$Region.'","'.$Year.'")');
        $returnHTML = view('table_newemployee', compact('ListNewEmployee'))->render();
        return response()->json($returnHTML);
    }

    public function InsertNewEmployee(Request $request) {
        $Year    = $request-> Year;
        $Region  = $request-> Region;
        $ID      = $request-> ID;
        $Name    = $request-> Name;
        $SWD     = $request-> SWD;
        DB::select('call SP_Insert_ResourceAllocation_Employee("'.$ID.'","'.$Name.'","'.$Year.'","'.$Region.'","'.$SWD.'","'.session()->get('EmployeeID').'")');
        return response()->json("Success Entry New Employee");
    }
    
}
