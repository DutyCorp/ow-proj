<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class AssetController extends Controller
{
    public function refreshDropdownAssetType()
    {
        $ListAssetType = DB::select('call SP_All_Assettype');
        return response()->json($ListAssetType);
    }

	public function AssetTypeUpdate(Request $request)
    {
        $assetTypeID = $request->assetTypeID;
        $assetTypeName = $request->assetTypeName;
        DB::select('call SP_UpdateAssetType("'.$assetTypeName.'","'.$assetTypeID.'")');
        return response()->json('Success Updated Asset Type');
    }

	public function AssetTypeEdit(Request $request)
    {
        $AssetTypeID = $request->AssetTypeID;
        $EditData = DB::select('call SP_SelectEditAssetType("'.$AssetTypeID.'")');
        return response()->json($EditData);
    }

	public function AssetTypeDelete(Request $request)
    {
        $AssetTypeID = $request->AssetTypeID;
        DB::select('call SP_DeleteAssetType("'.$AssetTypeID.'")');
        return response()->json('Success Delete Asset Type');
     }

	public function AddAssetTypeID(Request $request)
    {
        $AssetTypeID = $request->assetTypeID;
        $AssetTypeName = $request->assetTypeName;
        DB::select('call SP_InsertAssetType("'.$AssetTypeID.'","'.$AssetTypeName.'")');
        return response()->json('Success Register Asset Type');
    }

	public function AssetTypeCheckID(){
        $RawAssetTypeID = DB::select('call SP_CheckAssetTypeID');
        $AssetTypeSplit = explode('AT', $RawAssetTypeID[0]->AssetTypeID);
        $Count = sprintf('%02d', $AssetTypeSplit[1]);
        return response()->json($Count);
    }

    public function refreshTableAssetType(Request $request)
 	{
    	$ListAssetType = DB::select('call SP_All_Assettype');
 		$returnHTML = view('table_assettype', compact('ListAssetType'))->render();
        return response()->json($returnHTML);
 	}

 	public function getAssetCount(Request $request)
 	{
 		$AssClass = $request->assClass;
 		$RawAssetNumber = DB::select('call SP_CountAssetClassID("'.$AssClass.'")');
 		if($RawAssetNumber == null)
 			$Count = 0;
 		else {
 			$AssetNumberSplit = explode('-', $RawAssetNumber[0]->AssetNumber);
            $Count = sprintf('%05d', $AssetNumberSplit[2]);	
 		}
        
    	return response()->json($Count);
 	}

 	public function showAssetData(Request $request)
    {
    	$AssetID = $request->assetID;
    	$EditData = DB::select('call SP_SelectEditAssetData("'.$AssetID.'")');
    	return response()->json($EditData);
    }

 	public function doEntryNewAsset(Request $request)
 	{
 		$AssetNumber               = $request->assetNumber;	 				
        $AssetClass                = $request->assetClass;
	    $AssetLocation             = $request->assetLocation;				
        $AssetStatus               = $request->assetStatus;
	   	$AssetSerialNumber         = $request->assetSerialNumber; 		
        $AssetDescription          = $request->assetDescription;	
	   	$assetOwner                = $request->assetOwner;						
        $AssetRoom                 = $request->assetRoom;
	    $AssetAcquisitionDate      = $request->assetAcquisitionDate;	
        $AssetGuaranteeDate        = $request->assetGuaranteeDate;
	    $AssetType                 = $request->assetType;						
        $AssetNotes                = $request->assetNotes;
	    $AssetValue                = $request->assetValue;						
        $AssetValueCurrency        = $request->assetValueCurrency;
	    $AssetSellingPrice         = $request->assetSellingPrice;		
        $AssetSellingPriceCurrency = $request->assetSellingPriceCurrency;
	    $AssetIsActive             = $request->assetIsActive;

        $AssetValueClear = preg_replace("/[^a-zA-Z0-9]/", "", $AssetValue);

	    if(($AssetSellingPrice == "" || $AssetSellingPrice == 0 )  && $AssetSellingPriceCurrency == "None") {
	    	$AssetSellingPrice = 0;
	    	$AssetSellingPriceCurrency = "";
	    } else {
            $AssetSellingPrice = preg_replace("/[^a-zA-Z0-9]/", "", $AssetSellingPrice);
        }
 		DB::select('call SP_InsertAsset("'.$AssetNumber.'","'.$AssetClass.'","'.$AssetType.'","'.$assetOwner.'","'.$AssetLocation.'","'.$AssetSerialNumber.'","'.$AssetDescription.'","'.$AssetNotes.'","'.$AssetStatus.'","'.$AssetRoom.'","'.$AssetAcquisitionDate.'","'.$AssetGuaranteeDate.'", "'.$AssetValueClear.'","'.$AssetValueCurrency.'", "'.$AssetSellingPrice.'","'.$AssetSellingPriceCurrency.'",'.$AssetIsActive.',"'.session()->get('EmployeeID').'")');
    	return response()->json('Success Entry Asset');
 	}

 	public function UpdateAssetData(Request $request)
 	{
    	$AssetLocation             = $request->assetLocation;
	    $AssetStatus               = $request->assetStatus;					
        $AssetSerialNumber         = $request->assetSerialNumber;
	    $AssetDescription          = $request->assetDescription;			
        $AssetRoom                 = $request->assetRoom;
	    $AssetAcquisitionDate      = $request->assetAcquisitionDate;	
        $AssetGuaranteeDate        = $request->assetGuaranteeDate;
		$AssetType                 = $request->assetType;
	    $AssetValue                = $request->assetValue;						
        $AssetValueCurrency        = $request->assetValueCurrency;
        $AssetNotes                = $request->assetNotes;
	    $AssetSellingPrice         = $request->assetSellingPrice;		
        $AssetSellingPriceCurrency = $request->assetSellingPriceCurrency;
	    $AssetIsActive             = $request->assetIsActive;				
        $AssetMainKey              = $request->assetMainKey;

        $AssetValueClear = preg_replace("/[^a-zA-Z0-9]/", "", $AssetValue);
        
	    if(($AssetSellingPrice == "" || $AssetSellingPrice == 0 )  && $AssetSellingPriceCurrency == "None") {
	    	$AssetSellingPrice = 0;
	    	$AssetSellingPriceCurrency = "";
	    } else {
            $AssetSellingPrice = preg_replace("/[^a-zA-Z0-9]/", "", $AssetSellingPrice);
        }
 		DB::select('call SP_UpdateAsset ("'.$AssetLocation.'","'.$AssetStatus.'","'.$AssetSerialNumber.'","'.$AssetDescription.'","'.$AssetRoom.'","'.$AssetAcquisitionDate.'","'.$AssetGuaranteeDate.'","'.$AssetType.'", "'.$AssetValueClear.'", "'.$AssetValueCurrency.'","'.$AssetNotes.'","'.$AssetSellingPrice.'","'.$AssetSellingPriceCurrency.'","'.session()->get('EmployeeID').'",'.$AssetIsActive.','.$AssetMainKey.')');
    	return response()->json('Success Update Asset');
 	}

 	public function refreshTableAsset()
    {
        $ListAsset  = DB::select('call SP_All_Asset("'.session()->get('EmployeeID').'")');
        $rolemenus  = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC04")');
        $returnHTML = view('table_asset', compact('ListAsset', 'rolemenus'))->render();
        return response()->json($returnHTML);
    }

 	public function DeleteAssetData(Request $request)
    {
    	$AssetID = $request->assetID;
    	DB::select('call SP_DeleteAsset("'.$AssetID.'", "'.session()->get('EmployeeID').'")');
    	return response()->json('Success Delete Asset');
    }

    
}
