<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SalesContractController extends Controller
{
    public function CSGraphSC(Request $request){
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
        $ProjectStatus      = $request->ProjectStatus;
        $ContractStatus     = $request->ContractStatus;
        $ProjectRegion      = $request->ProjectRegion;
        $GraphListLS = DB::select('call SP_SalesContract_GraphCustomerSummaryLS("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$ProjectStatus.'","'.$ContractStatus.'")');  
        $GraphListM = DB::select('call SP_SalesContract_GraphCustomerSummaryM("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$ProjectStatus.'","'.$ContractStatus.'")');  
        $GraphListT = DB::select('call SP_SalesContract_GraphCustomerSummaryTotal("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$ProjectStatus.'","'.$ContractStatus.'")'); 
        return response()->json(array('GraphListLS' => $GraphListLS, 'GraphListM' => $GraphListM, 'GraphListT' => $GraphListT));
    }
    
    public function CDGraphSC(Request $request){
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
        $ProjectStatus      = $request->ProjectStatus;
        $ContractStatus     = $request->ContractStatus;
        $ProjectRegion      = $request->ProjectRegion;
        $CustomerName       = $request->CustomerName;
        $GraphListLS = DB::select('call SP_SalesContract_GraphCustomerDetailLS("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$ProjectStatus.'","'.$ContractStatus.'","'.$CustomerName.'")');  
        $GraphListM = DB::select('call SP_SalesContract_GraphCustomerDetailM("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$ProjectStatus.'","'.$ContractStatus.'","'.$CustomerName.'")');  
        $GraphListT = DB::select('call SP_SalesContract_GraphCustomerDetailTotal("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$ProjectStatus.'","'.$ContractStatus.'","'.$CustomerName.'")'); 
        return response()->json(array('GraphListLS' => $GraphListLS, 'GraphListM' => $GraphListM, 'GraphListT' => $GraphListT));
    }

    public function FilterSalesContract(Request $request){
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
    	$ProjectStatus      = $request->ProjectStatus;
        $ContractStatus     = $request->ContractStatus;
        $ProjectRegion      = $request->ProjectRegion;
        $ListSalesContract = DB::select('call SP_SalesContract_List_Filtered("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$ProjectStatus.'","'.$ContractStatus.'")');
        $LastsUpdate = DB::select('call SP_GetSalesContractLatestUpdate()');
    	$returnHTML = view('table_salescontract', compact('ListSalesContract', 'LastsUpdate'))->render();
        $TotalSalesContract = DB::select('call SP_TotalSalesContract_List("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$ProjectStatus.'","'.$ContractStatus.'")');
        $TotalRegionSalesContract = DB::select('call SP_SalesContract_List_Filtered_GraphRegion("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$ProjectStatus.'","'.$ContractStatus.'")');
        
        return response()->json(array('returnHTML' => $returnHTML, 'TotalSalesContract' => $TotalSalesContract, 'TotalRegionSalesContract' => $TotalRegionSalesContract));
    }

    public function refreshTableSalesContract(Request $request){
        $ListSalesContract = DB::select('call SP_SalesContract_List_Filtered("All", "", "","All","All")');
        $LastsUpdate = DB::select('call SP_GetSalesContractLatestUpdate()');
        $returnHTML = view('table_salescontract', compact('ListSalesContract', 'LastsUpdate'))->render();

        return response()->json($returnHTML);
    }

    public function DetailGraphSC(Request $request){
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
        $ProjectStatus      = $request->ProjectStatus;
        $ContractStatus     = $request->ContractStatus;
        $ProjectRegion      = $request->ProjectRegion;
        $GraphList = DB::select('call SP_SalesContract_List_Filtered_GraphDetail("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$ProjectStatus.'","'.$ContractStatus.'")');  
        return response()->json($GraphList);
    }

    public function SummaryGraphSC(Request $request){
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
        $ProjectStatus      = $request->ProjectStatus;
        $ContractStatus     = $request->ContractStatus;
        $ProjectRegion      = $request->ProjectRegion;
        $GraphList = DB::select('call SP_SalesContract_List_Filtered_GraphSummary("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$ProjectStatus.'","'.$ContractStatus.'")');  
        return response()->json($GraphList);
    }

    public function RegionGraphSC(Request $request){
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
        $ProjectStatus      = $request->ProjectStatus;
        $ContractStatus     = $request->ContractStatus;
        $ProjectRegion      = $request->ProjectRegion;
        $GraphList = DB::select('call SP_SalesContract_List_Filtered_GraphRegion("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$ProjectStatus.'","'.$ContractStatus.'")');  
        return response()->json($GraphList);
    }

    

}
