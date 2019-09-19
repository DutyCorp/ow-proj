<?php

namespace App\Http\Controllers;
use Excel;
use Illuminate\Http\Request;
use DB;
use DateTime;

class ProfitabillityController extends Controller
{
	public function FilterTableProfitabillity(Request $request){
		$RegionID             = $request->RegionID;
		$ContractStatus       = $request->ContractStatus;
		$PageType             = $request->PageType;
		$PositionType         = $request->PositionType;
		
		$ListProfitabillity	  = DB::select('call SP_GetProjectProfitabilityDetail	("'.$RegionID.'","'.$ContractStatus.'","'.$PositionType.'")');

		$DateInsertProfitabillity   = DB::select('call SP_GetProfitabillityDateInsert');
		$LastsUpdate = DB::select('call SP_GetProfitabillityLatest()');
		if($PageType == "Summary") {
			$returnHTML = view('table_profitabillitysummary', compact('ListProfitabillity', 'ViewType', 'LastsUpdate'))->render();
		} else {
			$returnHTML = view('table_profitabillitydetail', compact('ListProfitabillity', 'ViewType', 'LastsUpdate'))->render();
		}
		
		return response()->json(array('returnHTML' => $returnHTML,'DateInsertProfitabillity' => $DateInsertProfitabillity));
	}
}