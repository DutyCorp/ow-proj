<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class InvoiceController extends Controller
{
    
    public function CDGraphIP(Request $request){
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
        $ProjectRegion      = $request->ProjectRegion;
        $CustomerName       = $request->CustomerName;

        $GraphListLS = DB::select('call SP_OpenInvoice_GraphCustomerDetailLS("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$CustomerName.'")');
        $GraphListM = DB::select('call SP_OpenInvoice_GraphCustomerDetailM("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$CustomerName.'")');  
        $GraphListT = DB::select('call SP_OpenInvoice_GraphCustomerDetailTotal("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'","'.$CustomerName.'")');  

        return response()->json(array('GraphListLS' => $GraphListLS, 'GraphListM' => $GraphListM, 'GraphListT' => $GraphListT));
    }

    public function CSGraphIP(Request $request){
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
        $ProjectRegion      = $request->ProjectRegion;

        $GraphListLS = DB::select('call SP_OpenInvoice_GraphCustomerSummaryLS("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'")');
        $GraphListM = DB::select('call SP_OpenInvoice_GraphCustomerSummaryM("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'")');  
        $GraphListT = DB::select('call SP_OpenInvoice_GraphCustomerSummaryTotal("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'")');  

        return response()->json(array('GraphListLS' => $GraphListLS, 'GraphListM' => $GraphListM, 'GraphListT' => $GraphListT));
    }

    public function GetOpenInvoiceData(Request $request){
    	$Region = $request->Region;
        if ($request->PeriodFrom != ""){
        	$PeriodFrom = $request->PeriodFrom;
        } else {
            $PeriodFrom = "";
        }
        if ($request->PeriodTo != ""){
            $PeriodTo = $request->PeriodTo;
        } else {
            $PeriodTo = "";
        }

        $ListOpenInvoice = DB::select('call SP_OpenInvoice("'.$Region.'", "'.$PeriodFrom.'", "'.$PeriodTo.'")');
        $TotalOpenInvoice = DB::select('call SP_TotalOpenInvoice("'.$Region.'", "'.$PeriodFrom.'", "'.$PeriodTo.'")');
        $OparDate = DB::select('call SP_GetOparLatest');
        $returnHTML = view('table_openinvoice', compact('ListOpenInvoice','TotalOpenInvoice','OparDate'))->render();
        $RegionTotal = DB::select('call SP_OpenInvoice_GraphRegion("'.$Region.'", "'.$PeriodFrom.'", "'.$PeriodTo.'")');  
       	return response()->json(array('returnHTML' => $returnHTML, 'RegionTotal' => $RegionTotal));
    }

    public function DetailGraphIP(Request $request){
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
        $ProjectRegion      = $request->ProjectRegion;

        $GraphList = DB::select('call SP_OpenInvoice_GraphDetail("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'")');  
        return response()->json($GraphList);
    }

    public function RegionGraphIP(Request $request){
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
        $ProjectRegion      = $request->ProjectRegion;

        $GraphList = DB::select('call SP_OpenInvoice_GraphRegion("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'")');  
        return response()->json($GraphList);
    }

    public function SummaryGraphIP(Request $request){
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
        $ProjectRegion      = $request->ProjectRegion;

        $GraphList = DB::select('call SP_OpenInvoice_GraphSummary("'.$ProjectRegion.'", "'.$DateFrom.'", "'.$DateTo.'")');  
        return response()->json($GraphList);
    }

    
}
