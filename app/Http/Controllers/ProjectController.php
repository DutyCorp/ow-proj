<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    
    public function EntryProject(Request $request) {
        $ProjectCode        = $request->ProjectCode;
 		$ProjectName 		= $request->ProjectName;
 		$ProjectType 		= $request->ProjectType;
 		$ProjectRegion   	= $request->ProjectRegion;
        $ProjectBA          = $request->ProjectBA;
        $CheckProjectCode = DB::select('call SP_CheckProjectID("'.$ProjectCode.'")');
        if($CheckProjectCode == null) {
            DB::select('call SP_InsertProject("'.$ProjectCode.'","'.$ProjectName.'","'.$ProjectType.'","'.$ProjectRegion.'","'.session()->get('EmployeeID').'","'.$ProjectBA.'")');
            return response()->json(1);
        } else {
            return response()->json(0);
        }
 	}

    public function refreshTableProject(){
        $ListProject = DB::select('call SP_All_Project()');
        $ProjectDate = DB::select('call SP_GetProjectLatest');
        $returnHTML = view('table_masterproject', compact('ListProject'))->render();
        return response()->json(array('returnHTML' => $returnHTML, 'ProjectDate' => $ProjectDate));
    }

    public function CheckProjectType(Request $request){
        $ProjectType        = $request->ProjectType;
        $CheckProjectType   = DB::select('call SP_CheckProjectType("'.$ProjectType.'")');
        if($CheckProjectType == null) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }

    public function refreshProjectType(){
        $ListProjectType = DB::select('call SP_All_ProjectType');
        return response()->json($ListProjectType);
    }

    public function DeleteProject(Request $request){
        $ProjectCode        = $request->ProjectID;
        DB::select('call SP_DeleteProject("'.$ProjectCode.'","'.session()->get('EmployeeID').'")');
        return response()->json("Success Delete Project");
    }

    public function EditProject(Request $request){
        $ProjectCode        = $request->ProjectID;
        $ProjectData = DB::select('call SP_CheckProjectID("'.$ProjectCode.'")');
        return response()->json($ProjectData);
    }

    public function UpdateProject(Request $request){
        $ProjectCode        = $request->ProjectCode;
        $ProjectName        = $request->ProjectName;
        $ProjectType        = $request->ProjectType;
        $ProjectRegion      = $request->ProjectRegion;
        $ProjectBA          = $request->ProjectBA;
        DB::select('call SP_UpdateProject("'.$ProjectCode.'","'.$ProjectName.'","'.$ProjectType.'","'.$ProjectRegion.'","'.session()->get('EmployeeID').'","'.$ProjectBA.'")');
        return response()->json("Success Update Project");
    }

    public function EntryBusinessArea(Request $request) {
        $BAID          = $request->BAID;
        $BAName        = $request->BAName;
        $CheckBA = DB::select('call SP_SelectEditBusinessArea("'.$BAID.'")');
        if($CheckBA == null) {
            DB::select('call SP_InsertBusinessArea("'.$BAID.'","'.$BAName.'")');
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }

    public function refreshDropdownBA() {
        $ListBA   = DB::select('call SP_All_BusinessArea');
        return response()->json($ListBA);
    }

    public function BAEdit(Request $request) {
        $BAID        = $request->BAID;
        $BAData      = DB::select('call SP_SelectEditBusinessArea("'.$BAID.'")');
        return response()->json($BAData);
    }

    public function BAUpdate(Request $request) {
        $BAID          = $request->BAID;
        $BAName        = $request->BAName;
        DB::select('call SP_UpdateBusinessArea("'.$BAName.'","'.$BAID.'")');
        return response()->json("");
    }

    public function refreshTableBusinessArea(){
        $ListBA = DB::select('call SP_All_BusinessArea()');
        $returnHTML = view('table_businessarea', compact('ListBA'))->render();
        return response()->json($returnHTML);
    }

    public function BADelete(Request $request){
        $BAID        = $request->BAID;
        DB::select('call SP_DeleteBusinessArea("'.$BAID.'")');
        return response()->json("Success Delete Business Area");
    }

    public function FilterProjectProgress(Request $request){
        $ViewTable          = $request->ViewTable;
        $ProjectRegion      = $request->ProjectRegion;
        $PositionType        = $request->PositionType;
        $ProjectStatus      = $request->ProjectStatus;
        $From               = $request->From;
        $To               = $request->To;
        $ContractStatus     = $request->ContractStatus;

        $ListProjectProgress = DB::select('call SP_GetListProjectProgress("'.$ProjectRegion.'","'.$PositionType.'","'.$ProjectStatus.'","'.$From.'","'.$To.'","'.$ContractStatus.'")');  

        $LastsUpdate = DB::select('call SP_GetProjectProgressLatestUpdate()');
        if ($ViewTable == 'det'){
            $returnHTML = view('table_projectprogress_detail', compact('ListProjectProgress', 'LastsUpdate'))->render();
        } else {
            $returnHTML = view('table_projectprogress_summary', compact('ListProjectProgress', 'LastsUpdate'))->render();
        }
        return response()->json($returnHTML);
    }

    public function refreshTableProjectProgress(Request $request){
        $ListProjectProgress = DB::select('call SP_GetListProjectProgress("All","All","All","All")');
        $LastsUpdate = DB::select('call SP_GetProjectProgressLatestUpdate()'); 
        $returnHTML = view('table_projectprogress_summary', compact('ListProjectProgress', 'LastsUpdate'))->render();

        return response()->json($returnHTML);
    }

     public function refreshTableProjectProgressDetail(Request $request){
        $ListProjectProgress = DB::select('call SP_GetListProjectProgress("All","All","All","All")');
        $LastsUpdate = DB::select('call SP_GetProjectProgressLatestUpdate()'); 
        $returnHTML = view('table_projectprogress_detail', compact('ListProjectProgress', 'LastsUpdate'))->render();

        return response()->json($returnHTML);
    }
}
