<?php

namespace App\Http\Controllers;
use Excel;
use Illuminate\Http\Request;
use DB;
use DateTime;

class DocumentRegistrationController extends Controller
{
    public function refreshTableDocumentType(){
        $ListDocumentType = DB::select('call SP_All_DocumentType');
        $returnHTML = view('table_documenttype', compact('ListDocumentType'))->render();
        return response()->json($returnHTML);
    }

    public function FilterDocumentByDropdown(Request $request){
        $DocumentRegion = $request->DocumentRegion;
        $DocumentType   = $request->DocumentType;
        $ListDocument = DB::select('call SP_DropdownFilterDocumentNumber("'.$DocumentRegion.'","'.$DocumentType.'")');
        $returnHTML = view('table_document', compact('ListDocument'))->render();
        return response()->json($returnHTML);
    }

    public function refreshDropdownDocumentType(){
        $ListDocumentType = DB::select('call SP_All_DocumentType');
        return response()->json($ListDocumentType);
    }

    public function refreshTableDocument(){
        $ListDocument = DB::select('call SP_All_Document');
        $returnHTML = view('table_document', compact('ListDocument'))->render();
        return response()->json($returnHTML);
    }

    
    public function DeleteDocument(Request $request){
        $DocumentNumber        = $request->DocumentNumber;
        DB::select('call SP_DeleteDocument("'.$DocumentNumber.'")');
        return response()->json("Success Delete Document");
    }
    
    public function UpdateDocument(Request $request){
        $DocumentRegion = $request->DocumentRegion;
        $DocumentNumber = $request->DocumentNumber;
        $DocumentType   = $request->DocumentType;
        $DocumentOwner  = $request->DocumentOwner;
        $DocumentDate   = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $request->DocumentDate))->format('Y-m-d');
        $DocumentDestination = $request->DocumentDestination;
        $DocumentDescription = $request->DocumentDescription;
        $DocumentApprover = $request->DocumentApprover;

        DB::select('call SP_UpdateDocumentRegistration("'.$DocumentRegion.'","'.$DocumentDate.'","'.$DocumentDescription.'","'.$DocumentOwner.'","'.$DocumentDestination.'","'.$DocumentType.'","'.$DocumentApprover.'","'.session()->get('EmployeeName').'","'.$DocumentNumber.'")');
        return response()->json("Success Update Document");
    }

    public function EditDocument(Request $request){
        $DocumentNumber        = $request->DocumentNumber;
        $DocumentData = DB::select('call SP_CheckDocumentNumber("'.$DocumentNumber.'")');
        return response()->json($DocumentData);
    }


    public function CheckDocumentTypeName(Request $request){
        $DocumentTypeName = $request->DocumentTypeName;
        $CheckDocumentType = DB::select('call SP_CheckDocumentType("'.$DocumentTypeName.'")');
        if($CheckDocumentType == null){
            DB::select('call SP_InsertDocumentType("'.$DocumentTypeName.'")');
            return response()->json(1);
        }
        else
            return response()->json(0);
    }

    public function DeleteDocumentType(Request $request){
        $DocumentTypeID        = $request->DocumentTypeID;
        DB::select('call SP_DeleteDocumentType("'.$DocumentTypeID.'")');
        return response()->json("Success Delete Document Type");
    }
    
    public function EditDocumentType(Request $request){
        $DocumentTypeID        = $request->DocumentTypeID;
        $DocumentTypeData = DB::select('call SP_GetDocumentTypeData("'.$DocumentTypeID.'")');
        return response()->json($DocumentTypeData);
    }

    public function UpdateDocumentType(Request $request){
        $DocumentTypeID        = $request->DocumentTypeID;
        $DocumentTypeName        = $request->DocumentTypeName;
        DB::select('call SP_UpdateDocumentType("'.$DocumentTypeID.'","'.$DocumentTypeName.'")');
        return response()->json("Success Update Document Type");
    }

    public function EntryDocument(Request $request){
        $DocumentRegion = $request->DocumentRegion;
        $DocumentNumber = $request->DocumentNumber;
        $DocumentType = $request->DocumentType;
        $DocumentOwner = $request->DocumentOwner;
        $DocumentDate = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $request->DocumentDate))->format('Y-m-d');
        $DocumentDestination = $request->DocumentDestination;
        $DocumentDescription = $request->DocumentDescription;
        $DocumentApprover = $request->DocumentApprover;
        
        $CheckDocumentNumber = DB::select('call SP_CheckDocumentNumber("'.$DocumentNumber.'")');
        if($CheckDocumentNumber == null){
            DB::select('call SP_InsertDocument("'.$DocumentNumber.'","'.$DocumentRegion.'","'.$DocumentDate.'","'.$DocumentDescription.'","'.$DocumentOwner.'","'.$DocumentDestination.'","'.$DocumentType.'","'.$DocumentApprover.'","'.session()->get('EmployeeName').'")');
            return response()->json(1);
        }
        else
            return response()->json(0);
    }

    
    
}
