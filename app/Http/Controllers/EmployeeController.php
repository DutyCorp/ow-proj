<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use DB;
use DateTime;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;


class EmployeeController extends Controller
{
    public function GetRoleAccess(Request $request){
        $RoleID             = $request->RoleID;
        $rolemenus          = DB::select('call SP_GetRoleMenu("'.$RoleID.'")');
        $rolename           = DB::select('call SP_GetRoleName("'.$RoleID.'")');
        $regionvisibility   = DB::select('call SP_GetRegionVisibilityData("'.$RoleID.'")');
        return response()->json(array('rolemenu' => $rolemenus, 'regionvisibility' => $regionvisibility, 'rolename' => $rolename));
    }

    public function SubmitEmployeeUpdate(Request $request){
    	$EmployeeID                     = $request->EmployeeID;
    	$RoleID                         = $request->RoleID;
    	$DepartmentID                   = $request->DepartmentID;
        $GradeID                        = $request->GradeID;
        $Email                          = $request->Email;
        $Username                       = $request->Username;
    	$Position                       = $request->Position;
    	$MobilePhone                    = $request->MobilePhone;
    	$SkypeID                        = $request->SkypeID;
        $Region                         = $request->Region;
        $Address                        = $request->Address;
        $EmergencyContact               = $request->EmergencyContact;
        $EmergencyContactName           = $request->EmergencyContactName;
        $EmergencyContactRelationship   = $request->EmergencyContactRelationship;
        $USDBankName                    = $request->USDBankName;
        $USDBankAccount                 = $request->USDBankAccount;
        $USDName                        = $request->USDName;
        $LocalBankName                  = $request->LocalBankName;
        $LocalBankAccount               = $request->LocalBankAccount;
        $LocalName                      = $request->LocalName;
        if ($request->TerminationDate == "01/01/1970"){
            $TerminationDate = NULL;
        } else if ($request->TerminationDate != ""){
            $TerminationDate = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $request->TerminationDate))->format('Y-m-d');
        } else {
            $TerminationDate = NULL;
        }
        if ($request->StartWorkingDate == "01/01/1970"){
            $StartWorkingDate = NULL;
        } else if ($request->StartWorkingDate != ""){
            $StartWorkingDate = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $request->StartWorkingDate))->format('Y-m-d');
        }  else {
            $StartWorkingDate = NULL;
        }
        if ($request->DateOfBirth == "01/01/1970"){
            $DateOfBirth = NULL;
        } else if ($request->DateOfBirth != ""){
            $DateOfBirth = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $request->DateOfBirth))->format('Y-m-d');
        }  else {
            $DateOfBirth = NULL;
        }

    	$User              = DB::select('call SP_GetUserData("'.$EmployeeID.'")');
   		$EmployeeName      = $User[0]->EmployeeName;
    	$NationalID        = $User[0]->NationalID;
    	$NationalIDCount   = "";

    	if ($NationalID != ""){
    		$NIDArray = explode("_", $NationalID);
    		$NIDSplit = explode(".", $NIDArray[2]); 
    		$NationalIDCount = sprintf('%03d', $NIDSplit[0]+1);
    	}
    	$TaxRegistrationID = $User[0]->TaxID;
    	$TaxRegistrationIDCount = "";
    	if ($TaxRegistrationID != ""){
    		$TRIDArray = explode("_", $TaxRegistrationID);
    		$TRIDSplit = explode(".", $TRIDArray[2]);
    		$TaxRegistrationIDCount = sprintf('%03d', $TRIDSplit[0]+1);
    	}
    	$Passport = $User[0]->Passport;
    	$PassportCount = "";
    	if ($Passport != ""){
    		$PSArray = explode("_", $Passport);
    		$PSSplit = explode(".", $PSArray[2]);
    		$PassportCount = sprintf('%03d', $PSSplit[0]+1);
    	}
    	$Photo = $User[0]->Photo;
    	$PhotoCount = "";
    	if ($Photo != ""){
    		$PHArray = explode("_", $Photo);
    		$PHSplit = explode(".", $PHArray[2]);
    		$PhotoCount = sprintf('%03d', $PHSplit[0]+1);
    	}
    	$CV = $User[0]->CV;
    	$CVCount = "";
    	if ($CV != ""){
    		$CVArray = explode("_", $CV);
    		$CVSplit = explode(".", $CVArray[2]);
    		$CVCount = sprintf('%03d', $CVSplit[0]+1);
    	}
        $KK = $User[0]->FamilyRegistrationCard;
        $KKCount = "";
        if ($KK != ""){
            $KKArray = explode("_", $KK);
            $KKSplit = explode(".", $KKArray[2]);
            $KKCount = sprintf('%03d', $KKSplit[0]+1);
        }

    	if ($request->hasFile('NationalID')){
    		$NationalIDFile   = $request->file('NationalID');
    		$NIDSplit         = \File::extension($NationalIDFile->getClientOriginalName());
    		if ($this->getResult($NIDSplit) == 0){
    			return response()->json('The National ID file must be jpg/png/pdf!');
    		}
    		if ($NationalIDCount == ""){
    			$NationalIDCount = sprintf('%03d','1');
    		}
    		$NationalIDNew    = ''.$EmployeeName.'_National ID_'.$NationalIDCount.'.'.$NIDSplit;
    		$NationalID       = $NationalIDNew;
    	}
    	if ($request->hasFile('TaxRegistrationID')){
    		$TaxRegistrationIDFile    = $request->file('TaxRegistrationID');
    		$TRIDSplit                = \File::extension($TaxRegistrationIDFile->getClientOriginalName());
    		if ($this->getResult($TRIDSplit) == 0){
    			return response()->json('The Tax Registration ID file must be jpg/png/pdf!');
    		}
    		if ($TaxRegistrationIDCount == ""){
    			$TaxRegistrationIDCount = sprintf('%03d','1');
    		}
    		$TaxRegistrationIDNew = ''.$EmployeeName.'_Tax Registration ID_'.$TaxRegistrationIDCount.'.'.$TRIDSplit;
    		$TaxRegistrationID    = $TaxRegistrationIDNew;
    	}
    	if ($request->hasFile('Passport')){
    		$PassportFile = $request->file('Passport');
    		$PSSplit      = \File::extension($PassportFile->getClientOriginalName());
    		if ($this->getResult($PSSplit) == 0){
    			return response()->json('The Passport file must be jpg/png/pdf!');
    		}
    		if ($PassportCount == ""){
    			$PassportCount = sprintf('%03d','1');
    		}
    		$PassportNew = ''.$EmployeeName.'_Passport_'.$PassportCount.'.'.$PSSplit;
    		$Passport = $PassportNew;
    	}
   		if ($request->hasFile('Photo')){
   			$PhotoFile    = $request->file('Photo');
   			$PHSplit      = \File::extension($PhotoFile->getClientOriginalName());
            if (strcmp($PHSplit, 'jpg') != 0 && strcmp($PHSplit, 'png') != 0) {
                return response()->json('The Photo file must be either jpg or png!');
            }
            if (\File::size($PhotoFile) < 1048576){
                return response()->json('The Photo file must be at least 1MB in size!');
            }
    		if ($PhotoCount == ""){
    			$PhotoCount = sprintf('%03d','1');
    		}
    		$PhotoNew = ''.$EmployeeName.'_Photo_'.$PhotoCount.'.'.$PHSplit;
    		$Photo    = $PhotoNew;
   		}
    	if ($request->hasFile('CV')){
    		$CVFile   = $request->file('CV');
    		$CVSplit  = \File::extension($CVFile->getClientOriginalName());
    		if ($this->getResult($CVSplit) == 0){
    			return response()->json('The CV file must be jpg/png/pdf!');
    		}
    		if ($CVCount == ""){
    			$CVCount = sprintf('%03d','1');
    		}
    		$CVNew    = ''.$EmployeeName.'_CV_'.$CVCount.'.'.$CVSplit;
    		$CV       = $CVNew;
    	}
        if ($request->hasFile('KK')){
            $KKFile     = $request->file('KK');
            $KKSplit    = \File::extension($KKFile->getClientOriginalName());
            if ($this->getResult($KKSplit) == 0){
                return response()->json('The KK file must be jpg/png/pdf!');
            }
            if ($KKCount == ""){
                $KKCount = sprintf('%03d','1');
            }
            $KKNew  = ''.$EmployeeName.'_KK_'.$KKCount.'.'.$KKSplit;
            $KK     = $KKNew;
        }

        if (is_null($TerminationDate)){
            $TerminationDate = '1900-01-01';
        } else if (is_null($StartWorkingDate)){
            $StartWorkingDate = '1900-01-01';
        } else if (is_null($DateOfBirth)){
            $DateOfBirth = '1900-01-01';
        }

		DB::select('call SP_UpdateEmployeeData("'.$RoleID.'", "'.$DepartmentID.'", "'.$Position.'", "'.$MobilePhone.'", "'.$SkypeID.'", "'.$GradeID.'", "'.$NationalID.'", "'.$TaxRegistrationID.'", "'.$Passport.'", "'.$Photo.'", "'.$CV.'", "'.$TerminationDate.'", "'.$EmployeeID.'", "'.session()->get('EmployeeID').'", "'.$Username.'", "'.$Email.'", "'.$StartWorkingDate.'", "'.$Region.'", "'.$DateOfBirth.'","'.$KK.'", "'.$Address.'", "'.$EmergencyContact.'", "'.$EmergencyContactName.'", "'.$EmergencyContactRelationship.'", "'.$USDBankName.'", "'.$USDBankAccount.'", "'.$USDName.'", "'.$LocalBankName.'", "'.$LocalBankAccount.'", "'.$LocalName.'")');
        
		if ($request->hasFile('NationalID')){
			$NationalIDFile->move(public_path("/uploads"), $NationalID);
		}
		if ($request->hasFile('TaxRegistrationID')){
            $TaxRegistrationIDFile->move(public_path("/uploads"), $TaxRegistrationID);
		}
		if ($request->hasFile('Passport')){
            $PassportFile->move(public_path("/uploads"), $Passport);
		}
		if ($request->hasFile('Photo')){
            $PhotoFile->move(public_path("/uploads"), $Photo);
		}
		if ($request->hasFile('CV')){
            $CVFile->move(public_path("/uploads"), $CV);
		}
        if ($request->hasFile('KK')){
            $KKFile->move(public_path("/uploads"), $KK);
        }

    	return response()->json('Success');
    }

    private function getResult($data){
        if (strcmp($data, 'jpg') == 0) {
            return 1;
        } else if (strcmp($data, 'png') == 0){
            return 1;
        } else if (strcmp($data, 'pdf') == 0){
            return 1;
        } else {
            return 0;
        }
    }

    public function EditEmployeeData(Request $request){ 
        $EmployeeID                           = $request->EmployeeID;
        $EmployeePassword                     = $request->EmployeePassword;
        $EmployeePhone                        = $request->EmployeePhone;
        $EmployeeSkype                        = $request->EmployeeSkype;
        $EmployeeAddress                      = $request->EmployeeAddress;
        $EmployeeEmergencyContact             = $request->EmployeeEmergencyContact;
        $EmployeeEmergencyContactName         = $request->EmployeeEmergencyContactName;
        $EmployeeEmergencyContactRelationship = $request->EmployeeEmergencyContactRelationship;
        $EmployeeUSDBankName                  = $request->EmployeeUSDBankName;
        $EmployeeUSDBankAccount               = $request->EmployeeUSDBankAccount;
        $EmployeeUSDName                      = $request->EmployeeUSDName;
        $EmployeeLocalBankName                = $request->EmployeeLocalBankName;
        $EmployeeLocalBankAccount             = $request->EmployeeLocalBankAccount;
        $EmployeeLocalName                    = $request->EmployeeLocalName;

        $User = DB::select('call SP_GetUserData("'.$EmployeeID.'")');
        $EmployeeName       = $User[0]->EmployeeName;
        $NationalID         = $User[0]->NationalID;
        $NationalIDCount = "";
        if ($NationalID != ""){
            $NIDArray           = explode("_", $NationalID);
            $NIDSplit           = explode(".", $NIDArray[2]); 
            $NationalIDCount    = sprintf('%03d', $NIDSplit[0]+1);
        }
        $TaxRegistrationID = $User[0]->TaxID;
        $TaxRegistrationIDCount = "";
        if ($TaxRegistrationID != ""){
            $TRIDArray              = explode("_", $TaxRegistrationID);
            $TRIDSplit              = explode(".", $TRIDArray[2]);
            $TaxRegistrationIDCount = sprintf('%03d', $TRIDSplit[0]+1);
        }
        $Passport = $User[0]->Passport;
        $PassportCount = "";
        if ($Passport != ""){
            $PSArray        = explode("_", $Passport);
            $PSSplit        = explode(".", $PSArray[2]);
            $PassportCount  = sprintf('%03d', $PSSplit[0]+1);
        }
        $Photo = $User[0]->Photo;
        $PhotoCount = "";
        if ($Photo != ""){
            $PHArray        = explode("_", $Photo);
            $PHSplit        = explode(".", $PHArray[2]);
            $PhotoCount     = sprintf('%03d', $PHSplit[0]+1);
        }
        $CV = $User[0]->CV;
        $CVCount = "";
        if ($CV != ""){
            $CVArray = explode("_", $CV);
            $CVSplit = explode(".", $CVArray[2]);
            $CVCount = sprintf('%03d', $CVSplit[0]+1);
        }
        $KK = $User[0]->FamilyRegistrationCard;
        $KKCount = "";
        if ($KK != ""){
            $KKArray = explode("_", $KK);
            $KKSplit = explode(".", $KKArray[2]);
            $KKCount = sprintf('%03d', $KKSplit[0]+1);
        }

        if ($request->hasFile('NationalID')){
            $NationalIDFile = $request->file('NationalID');
            $NIDSplit       = \File::extension($NationalIDFile->getClientOriginalName());
            if ($this->getResult($NIDSplit) == 0){
                return response()->json('The National ID file must be jpg/png/pdf!');
            }
            if ($NationalIDCount == ""){
                $NationalIDCount = sprintf('%03d','1');
            }
            $NationalIDNew  = ''.$EmployeeName.'_National ID_'.$NationalIDCount.'.'.$NIDSplit;
            $NationalID     = $NationalIDNew;
        }
        if ($request->hasFile('TaxRegistrationID')){
            $TaxRegistrationIDFile  = $request->file('TaxRegistrationID');
            $TRIDSplit              = \File::extension($TaxRegistrationIDFile->getClientOriginalName());
            if ($this->getResult($TRIDSplit) == 0){
                return response()->json('The Tax Registration ID file must be jpg/png/pdf!');
            }
            if ($TaxRegistrationIDCount == ""){
                $TaxRegistrationIDCount = sprintf('%03d','1');
            }
            $TaxRegistrationIDNew   = ''.$EmployeeName.'_Tax Registration ID_'.$TaxRegistrationIDCount.'.'.$TRIDSplit;
            $TaxRegistrationID      = $TaxRegistrationIDNew;
        }
        if ($request->hasFile('Passport')){
            $PassportFile   = $request->file('Passport');
            $PSSplit        = \File::extension($PassportFile->getClientOriginalName());
            if ($this->getResult($PSSplit) == 0){
                return response()->json('The Passport file must be jpg/png/pdf!');
            }
            if ($PassportCount == ""){
                $PassportCount = sprintf('%03d','1');
            }
            $PassportNew    = ''.$EmployeeName.'_Passport_'.$PassportCount.'.'.$PSSplit;
            $Passport       = $PassportNew;
        }
        if ($request->hasFile('Photo')){
            $PhotoFile  = $request->file('Photo');
            $PHSplit    = \File::extension($PhotoFile->getClientOriginalName());
            if (strcmp($PHSplit, 'jpg') != 0 && strcmp($PHSplit, 'png') != 0) {
                return response()->json('The Photo file must be either jpg or png!');
            }
            if (\File::size($PhotoFile) < 1048576){
                return response()->json('The Photo file must be at least 1MB in size!');
            }
            if ($PhotoCount == ""){
                $PhotoCount = sprintf('%03d','1');
            }
            $PhotoNew   = ''.$EmployeeName.'_Photo_'.$PhotoCount.'.'.$PHSplit;
            $Photo      = $PhotoNew;
        }
        if ($request->hasFile('CV')){
            $CVFile     = $request->file('CV');
            $CVSplit    = \File::extension($CVFile->getClientOriginalName());
            if ($this->getResult($CVSplit) == 0){
                return response()->json('The CV file must be jpg/png/pdf!');
            }
            if ($CVCount == ""){
                $CVCount = sprintf('%03d','1');
            }
            $CVNew  = ''.$EmployeeName.'_CV_'.$CVCount.'.'.$CVSplit;
            $CV     = $CVNew;
        }
        if ($request->hasFile('KK')){
            $KKFile     = $request->file('KK');
            $KKSplit    = \File::extension($KKFile->getClientOriginalName());
            if ($this->getResult($KKSplit) == 0){
                return response()->json('The KK file must be jpg/png/pdf!');
            }
            if ($KKCount == ""){
                $KKCount = sprintf('%03d','1');
            }
            $KKNew  = ''.$EmployeeName.'_KK_'.$KKCount.'.'.$KKSplit;
            $KK     = $KKNew;
        }
        $EmployeePassword = Crypt::encrypt($EmployeePassword);

        DB::select('call SP_UpdateProfile("'.$EmployeePassword.'","'.$EmployeePhone.'","'.$EmployeeSkype.'","'.$NationalID.'","'.$TaxRegistrationID.'","'.$Passport.'","'.$Photo.'","'.$CV.'","'.$EmployeeID.'", "'.session()->get('EmployeeID').'","'.$KK.'", "'.$EmployeeAddress.'", "'.$EmployeeEmergencyContact.'", "'.$EmployeeEmergencyContactName.'", "'.$EmployeeEmergencyContactRelationship.'", "'.$EmployeeUSDBankName.'", "'.$EmployeeUSDBankAccount.'", "'.$EmployeeUSDName.'", "'.$EmployeeLocalBankName.'", "'.$EmployeeLocalBankAccount.'", "'.$EmployeeLocalName.'")');

        if ($request->hasFile('NationalID')){
            $NationalIDFile->move(public_path("/uploads"), $NationalID);
        }
        if ($request->hasFile('TaxRegistrationID')){
            $TaxRegistrationIDFile->move(public_path("/uploads"), $TaxRegistrationID);
        }
        if ($request->hasFile('Passport')){
            $PassportFile->move(public_path("/uploads"), $Passport);
        }
        if ($request->hasFile('Photo')){
            $PhotoFile->move(public_path("/uploads"), $Photo);
        }
        if ($request->hasFile('CV')){
            $CVFile->move(public_path("/uploads"), $CV);
        }
        if ($request->hasFile('KK')){
            $KKFile->move(public_path("/uploads"), $KK);
        }

        session()->put('Photo', $Photo);
        
        return response()->json('Success');
    }

    public function GetEmployeeData(Request $request){
        $RegionID = $request->RegionID;

        if ($RegionID == 'None'){
            $EmployeeData = DB::select('call SP_ShowAllEmployee');
        } else {
            $EmployeeData = DB::select('call SP_All_Employee_By_Region("'.$RegionID.'")');
        }

        return response()->json($EmployeeData);
    }

    public function DeleteEmployeeData(Request $request)
    {
        $EmployeeID         = $request->employeeID;
        DB::select('call SP_DeleteEmployee("'.$EmployeeID.'", "'.session()->get('EmployeeID').'")');
        return response()->json('Success Delete Employee');
    }

    public function refreshTableEmployee()
    {
        $ListEmployee       = DB::select('call SP_EmployeeList("'.session()->get('EmployeeID').'")');
        $rolemenus          = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC07")');
        $returnHTML         = view('table_employeelist', compact('ListEmployee', 'rolemenus'))->render();
        return response()->json($returnHTML);
    }

    public function doEntryNewEmployee(Request $request)
    {
        $EmployeeID                           = $request->EmployeeID;                    
        $EmployeeName                         = $request->EmployeeName;
        $EmployeeEmail                        = $request->EmployeeEmail;              
        $EmployeeUsername                     = $request->EmployeeUsername;
        $EmployeePassword                     = $request->EmployeePassword;        
        $EmployeeRole                         = $request->EmployeeRole;
        $EmployeeDOB                          = $request->EmployeeDOB;                  
        $EmployeeRegion                       = $request->EmployeeRegion;
        $EmployeeDepartment                   = $request->EmployeeDepartment;    
        $EmployeeSWD                          = $request->EmployeeSWD;
        $EmployeePosition                     = $request->EmployeePosition;       
        $EmployeePhone                        = $request->EmployeePhone;
        $EmployeeSkype                        = $request->EmployeeSkype;             
        $EmployeeGrade                        = $request->EmployeeGrade;
        $EmployeeAddress                      = $request->EmployeeAddress;
        $EmployeeEmergencyContact             = $request->EmployeeEmergencyContact;
        $EmployeeEmergencyContactName         = $request->EmployeeEmergencyContactName;
        $EmployeeEmergencyContactRelationship = $request->EmployeeEmergencyContactRelationship;
        $EmployeeUSDBankName                  = $request->EmployeeUSDBankName;
        $EmployeeUSDBankAccount               = $request->EmployeeUSDBankAccount;
        $EmployeeUSDName                      = $request->EmployeeUSDName;
        $EmployeeLocalBankName                = $request->EmployeeLocalBankName;
        $EmployeeLocalBankAccount             = $request->EmployeeLocalBankAccount;
        $EmployeeLocalName                    = $request->EmployeeLocalName;
        if ($request->hasFile('EmployeeNationalID')){
            $EmployeeNationalID = $request->EmployeeNationalID;
            $FileExtension      = \File::extension($EmployeeNationalID->getClientOriginalName());
            if ($this->getResult($FileExtension) == 0){
                return response()->json('National ID must be .jpg/.png/.pdf!');
            } else {
                $NationalID = ''.$EmployeeName.'_National ID_001.'.$FileExtension;
            }
        } else {
            $NationalID = '';
        }
        if ($request->hasFile('EmployeeTaxRegID')){
            $EmployeeTaxRegID   = $request->EmployeeTaxRegID;
            $FileExtension      = \File::extension($EmployeeTaxRegID->getClientOriginalName());
            if ($this->getResult($FileExtension) == 0){
                return response()->json('Tax Registration ID must be .jpg/.png/.pdf!');
            } else {
                $TaxRegistrationID = ''.$EmployeeName.'_Tax Registration ID_001.'.$FileExtension;
            }
        } else {
            $TaxRegistrationID = '';
        }
        if ($request->hasFile('EmployeePassport')){
            $EmployeePassport   = $request->EmployeePassport;
            $FileExtension      = \File::extension($EmployeePassport->getClientOriginalName());
            if ($this->getResult($FileExtension) == 0){
                return response()->json('Passport must be .jpg/.png/.pdf!');
            } else {
                $Passport = ''.$EmployeeName.'_Passport_001.'.$FileExtension;
            }
        } else {
            $Passport = '';
        }
        if ($request->hasFile('EmployeePhoto')){
            $EmployeePhoto      = $request->EmployeePhoto;
            $FileExtension      = \File::extension($EmployeePhoto->getClientOriginalName());
            if ($this->getResult($FileExtension) == 0){
                return response()->json('Photo must be .jpg/.png!');
            } else {
                $Photo = ''.$EmployeeName.'_Photo_001.'.$FileExtension;
            }
        } else {
            $Photo = '';
        }
        if ($request->hasFile('EmployeeCV')){
            $EmployeeCV         = $request->EmployeeCV;
            $FileExtension      = \File::extension($EmployeeCV->getClientOriginalName());
            if ($this->getResult($FileExtension) == 0){
                return response()->json('CV must be .jpg/.png/.pdf!');
            } else {
                $CV = ''.$EmployeeName.'_CV_001.'.$FileExtension;
            }
        } else {
            $CV = '';
        }
        if ($request->hasFile('EmployeeKK')){
            $EmployeeKK         = $request->EmployeeKK;
            $FileExtension      = \File::extension($EmployeeKK->getClientOriginalName());
            if ($this->getResult($FileExtension) == 0){
                return response()->json('KK must be .jpg/.png/.pdf!');
            } else {
                $KK = ''.$EmployeeName.'_KK_001.'.$FileExtension;
            }
        } else {
            $KK = '';
        }
        $EmployeePassword = Crypt::encrypt($EmployeePassword);
        DB::select('call SP_InsertEmployee("'.$EmployeeID.'", "'.$EmployeeName.'", "'.$EmployeeEmail.'", "'.$EmployeeUsername.'", "'.$EmployeePassword.'", "'.$EmployeeRole.'", "'.$EmployeeRegion.'","'.$EmployeeDepartment.'","'.$EmployeeSWD.'","'.$EmployeePosition.'","'.$EmployeePhone.'","'.$EmployeeSkype.'","'.$NationalID.'", "'.$TaxRegistrationID.'", "'.$Passport.'", "'.$Photo.'", "'.$CV.'", "'.$EmployeeDOB.'", "'.$EmployeeGrade.'", "'.session()->get('EmployeeID').'", "'.$KK.'", "'.$EmployeeAddress.'", "'.$EmployeeEmergencyContact.'", "'.$EmployeeEmergencyContactName.'", "'.$EmployeeEmergencyContactRelationship.'", "'.$EmployeeUSDBankName.'", "'.$EmployeeUSDBankAccount.'", "'.$EmployeeUSDName.'", "'.$EmployeeLocalBankName.'", "'.$EmployeeLocalBankAccount.'", "'.$EmployeeLocalName.'")');
        if ($request->hasFile('EmployeeNationalID')){
            $EmployeeNationalID->move(public_path("/uploads"), $NationalID);
        }
        if ($request->hasFile('EmployeeTaxRegID')){
            $EmployeeTaxRegID->move(public_path("/uploads"), $TaxRegistrationID);
        }
        if ($request->hasFile('EmployeePassport')){
            $EmployeePassport->move(public_path("/uploads"), $Passport);
        }
        if ($request->hasFile('EmployeePhoto')){
            $EmployeePhoto->move(public_path("/uploads"), $Photo);
        }
        if ($request->hasFile('EmployeeCV')){
            $EmployeeCV->move(public_path("/uploads"), $CV);
        }
        if ($request->hasFile('EmployeeKK')){
            $EmployeeKK->move(public_path("/uploads"), $KK);
        }
        return response()->json('Success');
    }

    public function refreshTableRegion()
    {
        $ListRegion   = DB::select('call SP_All_Region');
        $returnHTML     = view('table_region', compact('ListRegion'))->render();
        return response()->json($returnHTML);
    }

    public function EntryRegion(Request $request)
    {
        $RegionID     = $request->RegionID;
        $RegionName   = $request->RegionName;
        $RegionPhone   = $request->RegionPhone;
        $RegionFax   = $request->RegionFax;
        $RegionAddress   = $request->RegionAddress;
        DB::select('call SP_InsertRegion("'.$RegionID.'","'.$RegionName.'","'.$RegionPhone.'","'.$RegionAddress.'","'.$RegionFax.'")');
        return response()->json('Success Entry Region');
    }

    public function DeleteRegionData(Request $request)
    {
        $RegionID     = $request->RegionID;
        DB::select('call SP_DeleteRegion("'.$RegionID.'")');
        return response()->json('Success Delete Region');
    }

    /*public function showRegionData(Request $request)
    {
        $RegionID     = $request->RegionID;
        $EditData     = DB::select('call SP_SelectEditRegion("'.$RegionID.'")');
        return response()->json($EditData);
    }*/

    public function refreshDropdownRegion()
    {
        $ListRegion   = DB::select('call SP_All_Region');
        return response()->json($ListRegion);
    }

    public function CheckRegionID(Request $request){
        $RegionID           = $request->RegionID;
        $RegionData         = DB::select('call SP_SelectEditRegion("'.$RegionID.'")');
        return response()->json($RegionData);
    }

    public function UpdateRegionData(Request $request)
    {
        $RegionID       = $request->RegionID;
        $RegionName     = $request->RegionName;
        $RegionPhone    = $request->RegionPhone;
        $RegionFax      = $request->RegionFax;
        $RegionAddress  = $request->RegionAddress;
        DB::select('call SP_UpdateRegionTable("'.$RegionName.'","'.$RegionPhone.'","'.$RegionAddress.'","'.$RegionFax.'","'.$RegionID.'")');
        return response()->json('Success Update Region');
    }

    public function refreshTablePosition()
    {
        $ListPosition   = DB::select('call SP_All_Position');
        $returnHTML     = view('table_position', compact('ListPosition'))->render();
        return response()->json($returnHTML);
    }

    public function refreshDropdownPosition()
    {
        $ListPosition   = DB::select('call SP_All_Position');
        return response()->json($ListPosition);
    }

    public function showPositionData(Request $request)
    {
        $PositionID     = $request->positionID;
        $EditData       = DB::select('call SP_SelectEditPosition("'.$PositionID.'")');
        return response()->json($EditData);
    }

    public function UpdatePositionData(Request $request)
    {
        $PositionID     = $request->positionID;
        $PositionName   = $request->positionName;
        DB::select('call SP_UpdatePosition("'.$PositionName.'","'.$PositionID.'")');
        return response()->json('Success Update Position');
    }

    public function DeletePositionData(Request $request)
    {
        $PositionID     = $request->positionID;
        DB::select('call SP_DeletePosition("'.$PositionID.'")');
        return response()->json('Success Delete Position');
    }

    public function CheckPositionID(Request $request){
        $RawPositionID      = DB::select('call SP_CheckPositionID');
        $PositionIDSplit    = explode('PS', $RawPositionID[0]->PositionID);
        $Count = sprintf('%02d', $PositionIDSplit[1]);
        return response()->json($Count);
    } 
    
    public function doEntryPosition(Request $request)
    {
        $PositionID     = $request->positionID;
        $PositionName   = $request->positionName;
        DB::select('call SP_InsertPosition("'.$PositionID.'","'.$PositionName.'")');
        return response()->json('Success Entry Position');
    }

    public function refreshTableDepartment()
    {
        $ListDepartment   = DB::select('call SP_All_Department');
        $returnHTML     = view('table_department', compact('ListDepartment'))->render();
        return response()->json($returnHTML);
    }

    public function refreshDropdownDepartment()
    {
        $ListDepartment   = DB::select('call SP_All_Department');
        return response()->json($ListDepartment);
    }

    public function showDepartmentData(Request $request)
    {
        $DepartmentID     = $request->DepartmentID;
        $EditData       = DB::select('call SP_SelectEditDepartment("'.$DepartmentID.'")');
        return response()->json($EditData);
    }

    public function UpdateDepartmentData(Request $request)
    {
        $DepartmentID     = $request->DepartmentID;
        $DepartmentName   = $request->DepartmentName;
        DB::select('call SP_UpdateDepartment("'.$DepartmentName.'","'.$DepartmentID.'")');
        return response()->json('Success Update Department');
    }

    public function DepartmentCheckID(Request $request){
        $RawDepartmentID      = DB::select('call SP_CheckDepartmentID');
        $DepartmentIDSplit    = explode('D', $RawDepartmentID[0]->DepartmentID);
        $Count = sprintf('%02d', $DepartmentIDSplit[1]);
        return response()->json($Count);
    }

    public function EntryDepartment(Request $request)
    {
        $DepartmentID     = $request->DepartmentID;
        $DepartmentName   = $request->DepartmentName;
        DB::select('call SP_InsertDepartment("'.$DepartmentID.'","'.$DepartmentName.'")');
        return response()->json('Success Entry Department');
    }

    public function DeleteDepartmentData(Request $request)
    {
        $DepartmentID     = $request->DepartmentID;
        DB::select('call SP_DeleteDepartment("'.$DepartmentID.'")');
        return response()->json('Success Delete Department');
    }

    public function refreshTableGrade()
    {
        $ListGrade      = DB::select('call SP_SelectGrade');
        $returnHTML     = view('table_grade', compact('ListGrade'))->render();
        return response()->json($returnHTML);
    }

    public function GradeCheckID(Request $request){
        $RawGradeID             = DB::select('call SP_CheckGradeID');
        $GradeIDSplit           = explode('G', $RawGradeID[0]->GradeID);
        $Count                  = sprintf('%02d', $GradeIDSplit[1]);
        return response()->json($Count);
    }

    public function EntryGrade(Request $request)
    {
        $GradeID     = $request->GradeID;
        $GradeName   = $request->GradeName;
        DB::select('call SP_InsertGrade("'.$GradeID.'","'.$GradeName.'")');
        return response()->json('Success Entry Grade');
    }

    public function showGradeData(Request $request)
    {
        $GradeID        = $request->GradeID;
        $EditData       = DB::select('call SP_SelectEditGrade("'.$GradeID.'")');
        return response()->json($EditData);
    }

    public function DeleteGradeData(Request $request)
    {
        $GradeID     = $request->GradeID;
        DB::select('call SP_DeleteGrade("'.$GradeID.'")');
        return response()->json('Success Delete Grade');
    }

    public function refreshDropdownGrade()
    {
        $ListGrade   = DB::select('call SP_SelectGrade');
        return response()->json($ListGrade);
    }

    public function UpdateGradeData(Request $request)
    {
        $GradeID     = $request->GradeID;
        $GradeName   = $request->GradeName;
        DB::select('call SP_UpdateGrade("'.$GradeName.'","'.$GradeID.'")');
        return response()->json('Success Update Grade');
    }
}
