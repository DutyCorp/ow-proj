<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class FTEController extends Controller
{
    public function GetFTEData(Request $request){
    	$Year = $request->filterYear;

    	$ListFTE = DB::select('call SP_GetFTEData('.$Year.')');
    	$returnHTML = view('FTETable', compact('ListFTE'))->render();

    	return response()->json($returnHTML);
    }

    public function GenerateFTE(Request $request){
    	$Year = $request->filterYear;

    	DB::select('call SP_ReplaceFTE('.$Year.', "'.session()->get('EmployeeID').'")');
    	DB::select('call SP_GenerateFTE('.$Year.', "'.session()->get('EmployeeID').'")');

    	$ListFTE = DB::select('call SP_GetFTEData('.$Year.')');
    	$returnHTML = view('FTETable', compact('ListFTE'))->render();

    	return response()->json($returnHTML);
    }

    public function SaveAllFTE(Request $request){
        $Year = $request->Year;
        $EmployeeID = $request->EmployeeID;
        $FTE = $request->FTE;

        //return response()->json((float)$FTE[3][0]);

        for ($i = 0; $i < sizeof($EmployeeID); $i++){
            DB::select('call SP_UpdateFTEData('.(float)$FTE[$i][0].', '.(float)$FTE[$i][1].', '.(float)$FTE[$i][2].', '.(float)$FTE[$i][3].', '.(float)$FTE[$i][4].', '.(float)$FTE[$i][5].', '.(float)$FTE[$i][6].', '.(float)$FTE[$i][7].', '.(float)$FTE[$i][8].', '.(float)$FTE[$i][9].', '.(float)$FTE[$i][10].', '.(float)$FTE[$i][11].', "'.$EmployeeID[$i].'", "'.$Year[$i].'")');
        }

        return response()->json('FTE Saved!');
    }
}
