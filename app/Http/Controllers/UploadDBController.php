<?php

namespace App\Http\Controllers;
use Excel;
use Illuminate\Http\Request;
use DB;
use DateTime;

class UploadDBController extends Controller
{
    public function UploadClaimData(Request $request){   
        $Time               = $request->currentTime;
        $ClaimExcelData     = $request->file('ClaimExcelData');
        $FileName           = $ClaimExcelData->getClientOriginalName();
        $FileExtension      = \File::extension($FileName);

        if ($FileExtension == 'xls' || $FileExtension == 'xlsx') {
            $MissMatchProjectID = [];
            $excel = [];
            $path = $ClaimExcelData->getRealPath();
            Excel::load($path, function($reader) use (&$excel) {
                $reader->formatDates(true);
                $objExcel       = $reader   ->getExcel();
                $sheet          = $objExcel ->getSheet(0);
                $highestRow     = $sheet    ->getHighestRow();
                $highestColumn  = $sheet    ->getHighestColumn();
                for ($row = 6; $row <= $highestRow; $row++)
                {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE);
                    $excel[] = $rowData[0];
                }
            });
            if ($excel[0][0] != 'Customer') {
                return response()->json('Please check your Excel file');
            }
            $TempAccDate = [];
            $MaxDate;
            $MinDate;
            for($i = 1; $i<sizeof($excel)-1; $i++){
                if ($excel[$i][22] != null){
                    $d = DateTime::createFromFormat('d-m-y', str_replace('/', '-', $excel[$i][22]))->format('Y-m-d');    
                }
                $TempAccDate[$i-1] = $d;
            }
            $MinDate = date('Y-m-d', min(array_map('strtotime', $TempAccDate)));
            $MaxDate = date('Y-m-d', max(array_map('strtotime', $TempAccDate)));

            DB::select('call SP_Clear_Claim_Data("'.$MinDate.'","'.$MaxDate.'")');
            for ($i = 1; $i < sizeof($excel)-1; $i++){
                if ($excel[$i][21] != null){
                    $ProjectID              = $excel[$i][2];
                    $PhaseID                = $excel[$i][4];
                    $PhaseName              = $excel[$i][5];
                    $EmployeeID             = $excel[$i][6];
                    $EmployeeLocation       = $excel[$i][9];
                    $TECode                 = $excel[$i][10];
                    $TEName                 = $excel[$i][11];
                    $PaymentType            = $excel[$i][12];
                    $LineMemo               = $excel[$i][14];
                    $DocumentDate           = DateTime::createFromFormat('d-m-y', str_replace('/', '-', $excel[$i][15]))->format('Y-m-d');
                    $AmountTEC              = str_replace(',', '', $excel[$i][19]);
                    $AccountingID           = $excel[$i][21];
                    $AccountingDate         = DateTime::createFromFormat('d-m-y', str_replace('/', '-', $excel[$i][22]))->format('Y-m-d');
                    $TransferDate           = $excel[$i][23];
                    if($TransferDate == ""){
                        $TransferDate           = '1970-01-01';
                    } else {
                         $TransferDate           = DateTime::createFromFormat('d-m-y', str_replace('/', '-', $excel[$i][23]))->format('Y-m-d');
                    }
                    if($ProjectID != null){
                        $CheckProjectID = DB::select('call SP_CheckProjectID("'.$ProjectID.'")');
                        if($CheckProjectID == null){
                            $MissMatchProjectID[] = $ProjectID;
                        }
                        else {
                            DB::select('call SP_UploadClaim("'.$ProjectID.'","'.$PhaseID.'","'.$PhaseName.'","'.$EmployeeID.'","'.$TECode.'","'.$TEName.'","'.$LineMemo.'","'.$AmountTEC.'","'.$AccountingDate.'","'.session()->get('EmployeeID').'","'.$EmployeeLocation.'","'.$DocumentDate.'","'.$AccountingID.'","'.$TransferDate.'","'.$PaymentType.'")');   
                        }
                    }   
                }
            }
        } else {
            return response()->json('Wrong File Extension!');
        }
        $MissMatchProjectID        = array_values(array_unique($MissMatchProjectID));
        return response()->json($MissMatchProjectID);
    }

    public function UploadProfitabilityData(Request $request){
        $Time                    = $request->currentTime;
        $ProfitabilityExcelData  = $request->file('ProfitabilityExcelData');
        $FileName                = $ProfitabilityExcelData->getClientOriginalName();
        $FileExtension           = \File::extension($FileName);
        if ($FileExtension == 'xls' || $FileExtension == 'xlsx') {
             $excel = [];
             $MissMatchProjectID = [];
             $path = $ProfitabilityExcelData->getRealPath();
             Excel::load($path, function($reader) use (&$excel) {
                $reader->formatDates(true);
                $objExcel       = $reader   ->getExcel();
                $sheet          = $objExcel ->getSheet(0);
                $highestRow     = $sheet    ->getHighestRow();
                $highestColumn  = $sheet    ->getHighestColumn();
                for ($row = 6; $row <= $highestRow; $row++)
                {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE);
                    $excel[] = $rowData[0];
                }
            });
            if ($excel[0][0] != 'Customer') {
                return response()->json('Please check your Excel file');
            }
            DB::select('call SP_Clear_Profitability_Data');
            for ($i = 1; $i < sizeof($excel); $i++){
                $Customer               = $excel[$i][0];
                $CustomerName           = $excel[$i][1];
                $Project                = $excel[$i][2];
                $ProjectStatus          = $excel[$i][4];
                $Contract               = $excel[$i][5];
                $ContractName           = $excel[$i][7];
                $ContractStatus         = $excel[$i][9];
                $PositionType           = $excel[$i][10];
                $MDPhaseBudget          = str_replace(',', '', $excel[$i][11]);
                $MDPositionBudget       = str_replace(',', '', $excel[$i][12]);
                $MDPosted               = str_replace(',', '', $excel[$i][13]);
                $MDCost                 = str_replace(',', '', $excel[$i][14]);
                $PositionPrice          = str_replace(',', '', $excel[$i][15]);
                $TravelsPM              = str_replace(',', '', $excel[$i][17]);
                $TravelsSAP             = str_replace(',', '', $excel[$i][18]);
                $RoyaltiesLF            = str_replace(',', '', $excel[$i][19]);
                $RoyaltiesMF            = str_replace(',', '', $excel[$i][20]);
                $PartCost3d             = str_replace(',', '', $excel[$i][21]);
                $WHT                    = str_replace(',', '', $excel[$i][22]);
                $Flight                 = str_replace(',', '', $excel[$i][24]);
                $Hotel                  = str_replace(',', '', $excel[$i][25]);
                $PerDiem                = str_replace(',', '', $excel[$i][26]);
                $OtherExp               = str_replace(',', '', $excel[$i][27]);
                $Entertaiment           = str_replace(',', '', $excel[$i][28]);
                $Taxi                   = str_replace(',', '', $excel[$i][29]);
                if($MDPosted == "")
                    $MDPosted = 0;
                if($MDCost == "")
                    $MDCost = 0;
                if($Taxi == "")
                    $Taxi = 0;

                $CheckProjectID = DB::select('call SP_CheckProjectID("'.$Project.'")');
                if($CheckProjectID == null)
                    $MissMatchProjectID[] = $Project;
                else
                DB::select('call SP_UploadProfitability("'.$Customer.'","'.$CustomerName.'","'.$Project.'","'.$ProjectStatus.'","'.$Contract.'","'.$ContractName.'","'.$ContractStatus.'","'.$PositionType.'","'.$MDPhaseBudget.'","'.$MDPositionBudget.'","'.$MDPosted.'","'.$MDCost.'","'.$PositionPrice.'","'.$TravelsPM.'","'.$TravelsSAP.'","'.$RoyaltiesLF.'","'.$RoyaltiesMF.'","'.$PartCost3d.'","'.$WHT.'","'.$Flight.'","'.$Hotel.'","'.$PerDiem.'","'.$OtherExp.'","'.$Entertaiment.'","'.$Taxi.'","'.session()->get('EmployeeID').'")');
            }    
        } else {
        return response()->json('Wrong File Extension!');
        }

        $MissMatchProjectID        = array_values(array_unique($MissMatchProjectID));
        return response()->json($MissMatchProjectID);
    }

    public function UploadTSData(Request $request){

        $Time               = $request->currentTime;
        $TSYearlyExcelData  = $request->file('TSYearlyExcelData');
        $FileName           = $TSYearlyExcelData->getClientOriginalName();
        $FileExtension      = \File::extension($FileName);

        if ($FileExtension == 'xls' || $FileExtension == 'xlsx') {
            $excel = [];
            $MissMatchEmployeeID = [];
            $MissMatchProjectID = [];
            $path = $TSYearlyExcelData->getRealPath();

            Excel::load($path, function($reader) use (&$excel) {
                $reader->formatDates(true);
                $objExcel       = $reader   ->getExcel();
                $sheet          = $objExcel ->getSheet(0);
                $highestRow     = $sheet    ->getHighestRow();
                $highestColumn  = $sheet    ->getHighestColumn();
                for ($row = 6; $row <= $highestRow; $row++)
                {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE);
                    $excel[] = $rowData[0];
                }
            });

            if ($excel[0][0] != 'Type') {
                return response()->json('Please check your Excel file');
            }

            $YearSplit  = explode('Jan ', $excel[0][12]);
            $Year       = $YearSplit[1];
            $CheckYear  = DB::select('call SP_CheckTimesheetYear("'.$Year.'")');

            if($CheckYear == null) {
                for ($i = 2; $i < sizeof($excel); $i++) {
                    $EmployeeID             = $excel[$i][7];
                    
                    $ProjectID              = $excel[$i][10];
                    $January                = $excel[$i][12];
                    $February               = $excel[$i][13];
                    $March                  = $excel[$i][14];
                    $April                  = $excel[$i][15];
                    $May                    = $excel[$i][16];
                    $June                   = $excel[$i][17];
                    $July                   = $excel[$i][18];
                    $August                 = $excel[$i][19];
                    $September              = $excel[$i][20];
                    $October                = $excel[$i][21];
                    $November               = $excel[$i][22];
                    $Desember               = $excel[$i][23];
                    
                    $CheckEmployeeID = DB::select('call SP_CheckEmployeeID("'.$EmployeeID.'")');
                    $CheckProjectID = DB::select('call SP_CheckProjectID("'.$ProjectID.'")');
                    if($CheckEmployeeID == null)
                        $MissMatchEmployeeID[] = $EmployeeID." - ".$excel[$i][8];
                    else if($CheckProjectID == null)
                        $MissMatchProjectID[] = $ProjectID;
                    else
                        DB::select('call SP_UploadTimesheetYearly("'.$EmployeeID.'","'.$ProjectID.'","'.$Year.'","'.$January.'","'.$February.'","'.$March.'","'.$April.'","'.$May.'","'.$June.'","'.$July.'","'.$August.'","'.$September.'","'.$October.'","'.$November.'","'.$Desember.'","'.session()->get('EmployeeID').'")');
                }

                $MissMatchEmployeeID        = array_values(array_unique($MissMatchEmployeeID));
                $MissMatchProjectID         = array_values(array_unique($MissMatchProjectID));
                return response()->json(array('year' => $Year, 'EmployeeID' => $MissMatchEmployeeID, 'ProjectID' => $MissMatchProjectID));

            } else {
                DB::select('call SP_Clear_Timesheet_Yearly_Data("'.$Year.'")');
                for ($i = 2; $i < sizeof($excel); $i++){
                    $EmployeeID             = $excel[$i][7];
                    
                    $ProjectID              = $excel[$i][10];
                    $January                = $excel[$i][12];
                    $February               = $excel[$i][13];
                    $March                  = $excel[$i][14];
                    $April                  = $excel[$i][15];
                    $May                    = $excel[$i][16];
                    $June                   = $excel[$i][17];
                    $July                   = $excel[$i][18];
                    $August                 = $excel[$i][19];
                    $September              = $excel[$i][20];
                    $October                = $excel[$i][21];
                    $November               = $excel[$i][22];
                    $Desember               = $excel[$i][23];

                    $CheckEmployeeID = DB::select('call SP_CheckEmployeeID("'.$EmployeeID.'")');
                    $CheckProjectID = DB::select('call SP_CheckProjectID("'.$ProjectID.'")');
                    if($CheckEmployeeID == null) 
                        $MissMatchEmployeeID[] = $EmployeeID." - ".$excel[$i][8];
                    else if($CheckProjectID == null)
                        $MissMatchProjectID[] = $ProjectID;
                    else
                        DB::select('call SP_UploadTimesheetYearly("'.$EmployeeID.'","'.$ProjectID.'","'.$Year.'","'.$January.'","'.$February.'","'.$March.'","'.$April.'","'.$May.'","'.$June.'","'.$July.'","'.$August.'","'.$September.'","'.$October.'","'.$November.'","'.$Desember.'","'.session()->get('EmployeeID').'")');
                }
                $MissMatchEmployeeID        = array_values(array_unique($MissMatchEmployeeID));
                $MissMatchProjectID         = array_values(array_unique($MissMatchProjectID));
                if(sizeof($MissMatchEmployeeID) == 0 && sizeof($MissMatchProjectID) == 0)
                    return response()->json("");
                else    
                    return response()->json(array('year' => $Year, 'EmployeeID' => $MissMatchEmployeeID, 'ProjectID' => $MissMatchProjectID));
            }    
        } else {
            return response()->json('Wrong File Extension!');
        }
    } 

    public function UploadOparData(Request $request){   
        $Time               = $request->currentTime;
    	$OparExcelData      = $request->file('OparExcelData');
    	$FileName           = $OparExcelData->getClientOriginalName();
        $FileExtension      = \File::extension($FileName);

    	if ($FileExtension == 'xls' || $FileExtension == 'xlsx') {
            $MissMatchProjectID = [];
    		$excel = [];
    		$path = $OparExcelData->getRealPath();
    		Excel::load($path, function($reader) use (&$excel) {
                $reader->formatDates(true);
                $objExcel       = $reader   ->getExcel();
                $sheet          = $objExcel ->getSheet(0);
                $highestRow     = $sheet    ->getHighestRow();
                $highestColumn  = $sheet    ->getHighestColumn();
                for ($row = 6; $row <= $highestRow; $row++)
                {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE);
                    $excel[] = $rowData[0];
                }
            });
    		if ($excel[0][0] != 'CustomerName') {
                return response()->json('Please check your Excel file');
            }
            DB::select('call SP_Clear_Opar_Data');
            for ($i = 1; $i < sizeof($excel)-1; $i++){
                $CustomerName           = $excel[$i][0];
                $ProjectID              = $excel[$i][1];
                $ProjectType            = $excel[$i][3];
                $ProjectStatus          = $excel[$i][4];

                if ($excel[$i][5] != ""){
                    $arr = explode("/", $excel[$i][5]);
                    if (strlen($arr[2]) == 2){
                        $ClosureDate = DateTime::createFromFormat('d-m-y', str_replace('/', '-', $excel[$i][5]))->format('Y-m-d');
                    } else {
                        $ClosureDate = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $excel[$i][5]))->format('Y-m-d');
                    }
                } else {
                    $ClosureDate = '1970-01-01';
                }

                $ContractID             = $excel[$i][6];
                $ContractName           = $excel[$i][7];
                $ContractStatus         = $excel[$i][8];
                $BU                     = $excel[$i][9];
           		$BusinessArea           = $excel[$i][10];
           		$PositionType           = $excel[$i][11];
                $PositionPrice          = str_replace(',', '', $excel[$i][13]);
                $PositionPriceType      = str_replace(',', '', $excel[$i][14]);  
                $MDBudget               = str_replace(',', '', $excel[$i][18]);  
                $PositionBudget         = str_replace(',', '', $excel[$i][19]); 
                $PositionBudgetPerType  = str_replace(',', '', $excel[$i][20]); 
                $MDSpent                = str_replace(',', '', $excel[$i][21]); 
                $MDPerType              = str_replace(',', '', $excel[$i][22]);
                $AmountToBeInvoice      = str_replace(',', '', $excel[$i][28]);
                $AccountingDescription  = $excel[$i][24];
                if (strpos($AccountingDescription, '"')){
                    $AccountingDescription = str_replace('"', '', $AccountingDescription);
                }
                $Percentage = (float)$excel[$i][27];
                if ($excel[$i][25] != "") {
                    $InvoicePlannedDate = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $excel[$i][25]))->format('Y-m-d');
                } else {
                    $InvoicePlannedDate = '1970-01-01';
                }
                if($AmountToBeInvoice == "")
                    $AmountToBeInvoice = 0;
                $AccountingStatus       = $excel[$i][31];
                if ($excel[$i][33] != ""){
                    $DocumentDate = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $excel[$i][33]))->format('Y-m-d');
                } else {
                    $DocumentDate = '1970-01-01';
                }
                if ($excel[$i][37] != ""){
                    $ContractDate = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $excel[$i][37]))->format('Y-m-d');
                } else {
                    $ContractDate = '1970-01-01';
                }
                $ProjectManager         = $excel[$i][40];
                $ConditionID            = $excel[$i][46];
                $CheckProjectID = DB::select('call SP_CheckProjectID("'.$ProjectID.'")');
                if ($CheckProjectID == null){
                    if ($ProjectID != null){
                        if (!in_array($ProjectID, $MissMatchProjectID)){
                            $MissMatchProjectID[] = $ProjectID;
                        }
                    }
                } else {
                    DB::select('call SP_UploadOpar("'.$CustomerName.'","'.$ProjectID.'","'.$ProjectStatus.'","'.$ContractID.'","'.$ContractName.'","'.$ContractStatus.'","'.$BU.'","'.$BusinessArea.'","'.$PositionType.'","'.$PositionPrice.'","'.$PositionPriceType.'","'.$MDBudget.'","'.$PositionBudget.'","'.$PositionBudgetPerType.'","'.$MDSpent.'","'.$MDPerType.'","'.$AmountToBeInvoice.'","'.$AccountingStatus.'","'.$ContractDate.'","'.session()->get('EmployeeID').'","'.$ProjectManager.'","'.$ConditionID.'", "'.$AccountingDescription.'", "'.$InvoicePlannedDate.'", '.$Percentage.', "'.$ProjectType.'","'.$ClosureDate.'", "'.$DocumentDate.'")');
                }
       		}
    	} else {
    		return response()->json('Wrong File Extension!');
    	}
    	return response()->json($MissMatchProjectID);
    }

    public function UploadProjectData(Request $request){
        $Time               = $request->currentTime;
        $ProjectExcelData   = $request->file('ProjectExcelData');
        $FileName           = $ProjectExcelData->getClientOriginalName();
        $FileExtension      = \File::extension($FileName);
        if ($FileExtension == 'xls' || $FileExtension == 'xlsx') {
             $excel = [];
             $UpdateProjectCode = [];
             $path = $ProjectExcelData->getRealPath();
             Excel::load($path, function($reader) use (&$excel) {
                $reader->formatDates(true);
                $objExcel       = $reader   ->getExcel();
                $sheet          = $objExcel ->getSheet(0);
                $highestRow     = $sheet    ->getHighestRow();
                $highestColumn  = $sheet    ->getHighestColumn();
                for ($row = 1; $row <= $highestRow; $row++)
                {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE);
                    $excel[] = $rowData[0];
                }
            });
            if ($excel[0][0] != 'Project') {
                return response()->json('Please check your Excel file');
            }
                for ($i = 1; $i < sizeof($excel); $i++){
                    $ProjectCode           = $excel[$i][0];
                    $ProjectName           = $excel[$i][1];
                    $ProjectType           = $excel[$i][2];
                    $Location              = $excel[$i][3];
                    if($Location == "ASIA" || $Location == "OWA")
                        $Location          = "AS";
                    $CheckProjectID = DB::select('call SP_CheckProjectID("'.$ProjectCode.'")');
                    if($CheckProjectID == null){
                        $UpdateProjectCode[] = $ProjectCode;
                        DB::select('call SP_UploadProject("'.$ProjectCode.'","'.$ProjectName.'","'.$ProjectType.'","'.$Location.'","'.session()->get('EmployeeID').'")'); 
                    }                      
                }    
            } else {
            return response()->json('Wrong File Extension!');
        }
        return response()->json($UpdateProjectCode);
    }

    public function UploadAgingData(Request $request){
        $Time                    = $request->currentTime;
        $AgingExcelData          = $request->file('AgingExcelData');
        $FileName                = $AgingExcelData->getClientOriginalName();
        $FileExtension           = \File::extension($FileName);
        if ($FileExtension == 'xls' || $FileExtension == 'xlsx') {
             $excel = [];
             $MissMatchProjectID = [];
             $path = $AgingExcelData->getRealPath();
             Excel::load($path, function($reader) use (&$excel) {
                $reader->formatDates(true);
                $objExcel       = $reader   ->getExcel();
                $sheet          = $objExcel ->getSheet(0);
                $highestRow     = $sheet    ->getHighestRow();
                $highestColumn  = $sheet    ->getHighestColumn();
                for ($row = 2; $row <= $highestRow; $row++)
                {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE);
                    $excel[] = $rowData[0];
                }
            });
            if ($excel[0][0] != 'Inv.No') {
                return response()->json('Please check your Excel file');
            }
            //DB::select('call SP_Clear_Profitability_Data');
            for ($i = 1; $i < sizeof($excel)-1; $i++){
                $ContractID             = $excel[$i][3];
                $FeeType                = $excel[$i][7];
                $InvoiceDate            = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $excel[$i][1]))->format('Y-m-d');
                $Usd                    = str_replace(',', '', $excel[$i][13]);
                $PaymentDate            = $excel[$i][16];
                if($PaymentDate == ""){
                    $PaymentDate        = '1970-01-01';
                } else {
                    $PaymentDate        = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $excel[$i][16]))->format('Y-m-d');
                }
                $PaymentUsd             = str_replace(',', '', $excel[$i][17]);
                $DueDate                = DateTime::createFromFormat('n-j-Y', str_replace('/', '-', $excel[$i][14]))->format('y-m-d');
                $PaymentStatus          = $excel[$i][15];
                if($excel[$i][4] != "CANCELLED" && $excel[$i][3] != "")
                    DB::select('call SP_UploadInvoice("'.$ContractID.'","'.$FeeType.'","'.$InvoiceDate.'","'.$Usd.'","'.$PaymentDate.'","'.$PaymentUsd.'","'.$DueDate.'","'.$PaymentStatus.'","'.session()->get('EmployeeID').'")');
            }    
        } else {
            return response()->json('Wrong File Extension!');
        }
        return response()->json("");
    }
    
}