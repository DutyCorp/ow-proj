<?php

namespace App\Http\Controllers;
use Excel;
use Illuminate\Http\Request;
use DB;
use Mail;
use DateTime;

class TimesheetController extends Controller
{
    public function refreshDropdownTC(Request $request) {
        $TCData = DB::select('call SP_All_DeliveryEmployee');
        return response()->json($TCData);
    }

    public function UploadTimeSheetData(Request $request){
        DB::select('call SP_Clear_Timesheet_Completion_Data');
        DB::select('call SP_GenerateTimesheetCompletion');
        $ListRegion         = $request->ListRegion;
        $ListRegion         = explode(',', $ListRegion);
        $Status             = 0;
        for($g = 0; $g < sizeof($ListRegion); $g++){
            ${"TWH".$ListRegion[$g]}    = $request->{$ListRegion[$g]};
        }
        $TimesheetExcelData = $request->file('TimesheetExcelData');
        $FileName           = $TimesheetExcelData->getClientOriginalName();
        $FileExtension      = \File::extension($FileName);
        if ($FileExtension == 'xls' || $FileExtension == 'xlsx') {
            $excel = [];
            $MissMatchEmployee = [];
            $path = $TimesheetExcelData->getRealPath();
            Excel::load($path, function($reader) use (&$excel) {
                $reader->formatDates(true);
                $objExcel       = $reader   ->getExcel();
                $sheet          = $objExcel ->getSheet(0);
                $highestRow     = $sheet    ->getHighestRow() - 1;
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
            $FileDate = $excel[0][12];
            for ($i = 2; $i < sizeof($excel); $i++){
                $EmployeeID = $excel[$i][7];
                $Hours      = $excel[$i][12];
                $CheckEmployee = DB::select('call SP_CheckEmployeeID("'.$EmployeeID.'")');
                if($CheckEmployee == null){
                    $Status             = 1;
                    $MissMatchEmployee[]  = $excel[$i][8];
                } else {
                    DB::select('call SP_UploadTimesheetCompletion("'.$EmployeeID.'","'.$Hours.'")');    
                }
            }
        } else {
            return response()->json('Wrong File Extension!');
        }
        for($g = 0; $g < sizeof($ListRegion); $g++){
            DB::select('call SP_UpdateAllEmployeeTWH("'.${"TWH".$ListRegion[$g]}.'","'.$ListRegion[$g].'")');
        }
        $MissMatchEmployee        = array_values(array_unique($MissMatchEmployee));
        return response()->json(array('MissMatchEmployee' => $MissMatchEmployee, 'FileDate' => $FileDate, 'Status' => $Status));
    }

    public function UpdateTWH(Request $request) {
        $EmployeeID     = $request->EmployeeID;
        $TWH            = $request->Hours;
        DB::select('call SP_UpdateTWH('.$TWH.',"'.$EmployeeID.'")');
        return response()->json('Success Update TWH!');
    }

    public function ShowTableTimesheet() {
        $ListTimesheet  = DB::select('call SP_ShowTableTimesheet');
        $returnHTML     = view('table_timesheet_completion',compact('ListTimesheet'))->render();
        return response()->json($returnHTML);
    }

    public function sendTimesheetApproval(Request $request){
        $TimesheetApprovalFile = $request->file('TimesheetApprovalFile');
        $FileName           = $TimesheetApprovalFile->getClientOriginalName();
        $FileExtension      = \File::extension($FileName);
        if ($FileExtension == 'xls' || $FileExtension == 'xlsx') {
            $excel = [];
            $path = $TimesheetApprovalFile->getRealPath();
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

            if ($excel[0][0] != 'Employee') {
                return response()->json('Please check your Excel file');
            }

            $Month = DateTime::createFromFormat('d-m-y', str_replace('/', '-', $excel[1][12]))->format('F Y');

            $UploadedMonth = DateTime::createFromFormat('d-m-y', str_replace('/', '-', $excel[1][12]))->format('Ym');

            $OldListEmployeeID = [];
            
            DB::select('call SP_DeleteTimesheetApproval("'.$UploadedMonth.'")');
            DB::select('call SP_DeleteTempTimesheetApproval("'.$UploadedMonth.'")');

            $resultraw = DB::select('call SP_CountTimesheetApproval');
            $result = $resultraw[0]->Result;
            $unknownprojects = [];
            $unknownusers = [];

            if ($result == 0){
                for ($i = 1; $i < sizeof($excel); $i++){
                    if ($excel[$i][5] != ""){
                        $ProjectData = DB::select('call SP_GetProjectName("'.$excel[$i][5].'")');
                        if (sizeof($ProjectData) == 0){
                            $unknownprojects[] = $excel[$i][5].' - '.$excel[$i][6];
                        }
                    }
                }

                if (sizeof($unknownprojects) > 0){
                    $unknownprojects = array_values(array_unique($unknownprojects));
                    $statement  = 'The list of the projects that are unavailable are : <br>';
                    for ($i = 0; $i < sizeof($unknownprojects); $i++){
                        if ($i + 1 == sizeof($unknownprojects)){
                            $statement .= '-'.$unknownprojects[$i].'<br>Process Aborted';
                        } else {
                            $statement .= '-'.$unknownprojects[$i].'<br>';
                        }
                    }
                    return response()->json($statement);
                }
                for ($i = 1; $i < sizeof($excel); $i++){
                    $EmployeeData = DB::select('call SP_GetEmployeeData("'.$excel[$i][0].'")');
                    if (sizeof($EmployeeData) == 0){
                        $unknownusers[] = $excel[$i][1];
                    } else {
                        $excel[$i][16] = str_replace('"', '', $excel[$i][16]);
                        $excel[$i][17] = str_replace('"', '', $excel[$i][17]);
                        DB::select('call SP_InsertEmptyTimesheetApproval("'.$excel[$i][0].'", "'.$excel[$i][5].'", "'.$excel[$i][11].'", "'.DateTime::createFromFormat('d-m-y', str_replace('/', '-', $excel[$i][12]))->format('Y-m-d').'", "'.$excel[$i][15].'", "'.$excel[$i][16].'", "'.$excel[$i][17].'")');
                        $OldListEmployeeID[$i] = $excel[$i][0];
                    }
                }
            } else {
                $PhaseRaw =  DB::select('call SP_GetMaxTempTimesheetApprovalPhase');
                $Phase = $PhaseRaw[0]->MaxPhase;
                for ($i = 1; $i < sizeof($excel); $i++){
                    $ProjectData = DB::select('call SP_GetProjectName("'.$excel[$i][5].'")');
                    if (sizeof($ProjectData) == 0){
                        if ($excel[$i][5] != ""){
                            $unknownprojects[] = $excel[$i][5].' - '.$excel[$i][6];
                        }
                    }
                }
                if (sizeof($unknownprojects) > 0){
                    $unknownprojects = array_unique($unknownprojects);
                    $statement  = 'The list of the projects that are unavailable are : <br>';
                    for ($i = 0; $i < sizeof($unknownprojects); $i++){
                        if ($i + 1 == sizeof($unknownprojects)){
                            $statement .= '-'.$unknownprojects[$i].'<br>Process Aborted';
                        } else {
                            $statement .= '-'.$unknownprojects[$i].'<br>';
                        }
                    }
                    return response()->json($statement);
                }
                for ($i = 1; $i < sizeof($excel); $i++){
                    $EmployeeData = DB::select('call SP_GetEmployeeData("'.$excel[$i][0].'")');
                    if (sizeof($EmployeeData) == 0){
                        $unknownusers[] = $excel[$i][1];
                    } else {
                        $excel[$i][16] = str_replace('"', '', $excel[$i][16]);
                        $excel[$i][17] = str_replace('"', '', $excel[$i][17]);
                        DB::select('call SP_InsertFilledTimesheetApproval("'.$excel[$i][0].'", "'.$excel[$i][5].'", "'.$excel[$i][11].'", "'.DateTime::createFromFormat('d-m-y', str_replace('/', '-', $excel[$i][12]))->format('Y-m-d').'", "'.$excel[$i][15].'", "'.$excel[$i][16].'", "'.$excel[$i][17].'", "'.$Phase.'")');
                        $OldListEmployeeID[$i] = $excel[$i][0];
                    }
                }
            }

            DB::select('call SP_MigrateFromViewIntoTimesheetApproval');

            $ListEmployeeID = array_unique($OldListEmployeeID, SORT_REGULAR);
            $ListEmployeeID = array_values($ListEmployeeID);

            $ListTimesheet = DB::select('call SP_ShowTimesheetApproval');
            $returnHTML = view('table_timesheet_approval', compact('ListTimesheet'))->render();

            return response()->json(array('lei' => $ListEmployeeID, 'mth' => $Month, 'uu' => $unknownusers, 'returnHTML' => $returnHTML));
        } else {
            return response()->json('Wrong File Extension!');
        }
    }

    function sendTimesheetApprovalEmail(Request $request){
        $ListEmployeeID = $request->lei;
        $Month = $request->mth;
        $unknownusers = $request->uu;
        $ListInsertedEmployeeName = [];

        for ($j = 0; $j < sizeof($ListEmployeeID); $j++){
            $RawPersonalProjectID = [];
            $RawGradeID = DB::select('call SP_GetGradeID("'.$ListEmployeeID[$j].'")');
            if (sizeof($RawGradeID) != 0){
                $GradeID = $RawGradeID[0]->GradeID;
                if ($GradeID != 'G01' && $GradeID != 'G02'){
                    $PMData = DB::select('call SP_GetPMData("'.$ListEmployeeID[$j].'")');
                    if (sizeof($PMData) != 0){
                        $ListTestedEmployeeName = [];
                        $EmployeeData = DB::select('call SP_GetEmployeeData("'.$ListEmployeeID[$j].'")');
                        $PersonalTimesheetData = DB::select('call SP_TimesheetApprovalDetail("'.$ListEmployeeID[$j].'")');
                        $ListProjectType = DB::select('call SP_TimesheetApprovalSummary("'.$ListEmployeeID[$j].'")');
                        for($k = 0; $k < sizeof($PersonalTimesheetData); $k++){
                            $RawPersonalProjectID[] = $PersonalTimesheetData[$k]->ProjectID;
                        }

                        $PersonalProjectID = array_unique($RawPersonalProjectID, SORT_REGULAR);
                        $PersonalProjectID = array_values($PersonalProjectID);

                        $EmployeeRegionID = $EmployeeData[0]->RegionID;
                        $ListInsertedEmployeeName[] = $EmployeeData[0]->EmployeeName;

                        $RegionData = DB::select('call SP_GetRegionDataID("'.$EmployeeRegionID.'")');
                        if (sizeof($RegionData) != 0){
                            $RawGRM1 = $RegionData[0]->GRM_1;
                            $RawGRM2 = $RegionData[0]->GRM_2;
                            $RawPMO = $RegionData[0]->PMO; 

                            $GRM1 = DB::select('call SP_GetEmployeeData("'.$RawGRM1.'")');
                            $GRM2 = DB::select('call SP_GetEmployeeData("'.$RawGRM2.'")');
                            $PMO = DB::select('call SP_GetEmployeeData("'.$RawPMO.'")');  
                        }

                        $this->PMData = $PMData;
                        $ProjectManagerData = [];
                        $this->EmployeeName = $EmployeeData[0]->EmployeeName;

                        for ($k = 0; $k < sizeof($PersonalProjectID); $k++){
                            $RawProjectManager = DB::select('call SP_GetProjectManager("'.$PersonalProjectID[$k].'")');
                            if (sizeof($RawProjectManager) != 0){
                                $RawProjectManagerName = $RawProjectManager[0]->ProjectManager;
                                $SplittedName = explode(",", $RawProjectManagerName);
                                if ($SplittedName[0] == "Nguyen"){
                                    $ProjectManager = $SplittedName[1];
                                } else {
                                    $ProjectManager = $SplittedName[0];
                                }
                                $RawProjectManagerData = DB::select('call SP_GetEmployeeDataFromNameLike("'.$ProjectManager.'")');
                                if (sizeof($RawProjectManagerData) != 0){
                                    $ProjectManagerData[$k]['EmployeeName'] = $RawProjectManagerData[0]->EmployeeName;
                                    $ProjectManagerData[$k]['Email'] = $RawProjectManagerData[0]->Email;
                                }   
                            }
                        }

                        $this->ProjectManagerData = array_values($ProjectManagerData);
                        $Emails = [];
                        if (sizeof($this->ProjectManagerData) != 0){
                            for ($m = 0; $m < sizeof($this->ProjectManagerData); $m++){
                                $Emails[] = $this->ProjectManagerData[$m]['Email'];
                                $ListTestedEmployeeName[] = $this->ProjectManagerData[$m]['EmployeeName'].' (PM)';
                            }  
                        }
                        if (sizeof($GRM1) != 0){
                            $ListTestedEmployeeName[] = $GRM1[0]->EmployeeName.' ['.$GRM1[0]->Email.'] (GRM1)';
                            $Emails[] = $GRM1[0]->Email;
                        }
                        if (sizeof($GRM2) != 0){
                            $ListTestedEmployeeName[] = $GRM2[0]->EmployeeName.' ['.$GRM2[0]->Email.'] (GRM2)';
                            $Emails[] = $GRM2[0]->Email;
                        }
                        if (sizeof($PMO) != 0){
                            $ListTestedEmployeeName[] = $PMO[0]->EmployeeName.' ['.$PMO[0]->Email.'] (PMO)';
                            $Emails[] = $PMO[0]->Email;
                        }

                        $ListTestedEmployeeName[] = $EmployeeData[0]->EmployeeName.' ['.$EmployeeData[0]->Email.'] (Employee)';
                        $Emails[] = $EmployeeData[0]->Email;

                        $this->Emails = $Emails;
                        $data = array('PMName' => $PMData[0]->EmployeeName, 'PMEmail' => $PMData[0]->Email, 'EmployeeName' => $EmployeeData[0]->EmployeeName, 'ListTimesheetData' => $PersonalTimesheetData, 'Month' => $Month, 'ListTimesheetSummary' => $ListProjectType, 'ListTestedEmployeeName' => $ListTestedEmployeeName, 'Emails' => $Emails);
                        Mail::send('timesheetapprovalemail', $data, function($message) {
                            $message->from('owasiaonline@gmail.com','Project Management Team');
                            //$message->to('esuryani@openwaygroup.com', 'Eli Suryani')->subject('Timesheet Approval for '.$this->EmployeeName);
                            $message->to('blankpoint88@gmail.com', 'Andika Rahman Hakim')->subject('Timesheet Approval for '.$this->EmployeeName);
                            //$message->to('dimas0maulana@gmail.com', 'Dimas Maulana')->subject('Timesheet Approval for '.$this->EmployeeName);
                            //$message->cc('blankpoint88@gmail.com', 'Andika Rahman Hakim');
                            //$message->to($this->PMData[0]->Email, $this->PMData[0]->EmployeeName)->subject('Timesheet Approval for '.$this->EmployeeName);
                            //$message->cc($this->Emails);
                        });
                    }
                }
            }
        }

        $this->sendSummaryByProject($Month);
        if (sizeof($ListInsertedEmployeeName) != 0){
            $statement  = 'The list of the employee whose email has been sent to their project manager are : <br>';
            for ($i = 0; $i < sizeof($ListInsertedEmployeeName); $i++){
                if ($i + 1 == sizeof($ListInsertedEmployeeName)){
                    $statement .= '-'.$ListInsertedEmployeeName[$i].'';
                } else {
                    $statement .= '-'.$ListInsertedEmployeeName[$i].'<br>';
                }
            }
            if (sizeof($unknownusers) > 0){
                $unknownusers = array_unique($unknownusers);
                $statement  .= '<br><br>The list of the employee that is unavailable in the database are : <br>';
                for ($i = 0; $i < sizeof($unknownusers); $i++){
                    if ($i + 1 == sizeof($unknownusers)){
                        $statement .= '-'.$unknownusers[$i].'';
                    } else {
                        $statement .= '-'.$unknownusers[$i].'<br>';
                    }
                }
            }
        } else {
            $statement = 'No email has been sent';
        }

        return response()->json($statement);

        //return $ListInsertedEmployeeName;
    }

    function sendSummaryByProject($Month){
        $OldListRegionID = [];
        $ListProjectID = [];
        $OldArrayGRM1 = [];
        $OldArrayGRM2 = [];
        $OldArrayPMO = [];
        $ToEmails = [];
        $CCEmails = [];
        $Names = [];

        $ListProject = DB::select('call SP_EmailSummaryByProject');
        $ListProjectType = DB::select('call SP_EmailSummaryByProjectType');
        for ($j = 0; $j < sizeof($ListProject); $j++){
            $ListProjectID[] = $ListProject[$j]->ProjectID;
        }

        for ($j = 0; $j < sizeof($ListProjectID); $j++){
            $RegionData = DB::select('call SP_GetProjectRegionData("'.$ListProjectID[$j].'")');
            if (sizeof($RegionData) != 0){
                $OldArrayGRM1[] = $RegionData[0]->GRM_1;
                $OldArrayGRM2[] = $RegionData[0]->GRM_2;
                $OldArrayPMO[] = $RegionData[0]->PMO;
                $OldListRegionID[] = $RegionData[0]->RegionID;
            }
        }

        $ArrayGRM1 = array_unique($OldArrayGRM1);
        $ArrayGRM1 = array_values($ArrayGRM1);
        for ($j = 0; $j < sizeof($ArrayGRM1); $j++){
            $EmployeeData = DB::select('call SP_GetEmployeeData("'.$ArrayGRM1[$j].'")');
            if (sizeof($EmployeeData) != 0){
                $ToEmails[] = $EmployeeData[0]->Email;
                $Names[] = $EmployeeData[0]->EmployeeName;
            }
        }
        $ArrayGRM2 = array_unique($OldArrayGRM2);
        $ArrayGRM2 = array_values($ArrayGRM2);
        for ($j = 0; $j < sizeof($ArrayGRM2); $j++){
            $EmployeeData = DB::select('call SP_GetEmployeeData("'.$ArrayGRM2[$j].'")');
            if (sizeof($EmployeeData) != 0){
                $ToEmails[] = $EmployeeData[0]->Email;
                $Names[] = $EmployeeData[0]->EmployeeName;
            }
        }
        $ArrayPMO = array_unique($OldArrayPMO);
        $ArrayPMO = array_values($ArrayPMO);
        for ($j = 0; $j < sizeof($ArrayPMO); $j++){
            $EmployeeData = DB::select('call SP_GetEmployeeData("'.$ArrayPMO[$j].'")');
            if (sizeof($EmployeeData) != 0){
                $CCEmails[] = $EmployeeData[0]->Email;
                $Names[] = $EmployeeData[0]->EmployeeName;
            }
        }
        $ListRegionID = array_unique($OldListRegionID);
        $ListRegionID = array_values($ListRegionID);

        for ($j = 0; $j < sizeof($ListRegionID); $j++){
            $ProjectLeadData = DB::select('call SP_GetProjectLeadDataFromRegion("'.$ListRegionID[$j].'")');
            if (sizeof ($ProjectLeadData) != 0){
                for ($k = 0; $k < sizeof($ProjectLeadData); $k++){
                    $ToEmails[] = $ProjectLeadData[$k]->Email;
                    $Names[] = $ProjectLeadData[$k]->EmployeeName;
                }    
            }
        }

        $this->ToEmails = array_unique($ToEmails);
        $this->ToEmails = array_values($this->ToEmails);
        $this->CCEmails = array_unique($CCEmails);
        $this->CCEmails = array_values($this->CCEmails);
        $this->Month = $Month;

        $emaildata = array('ListProjectTimesheetData' => $ListProject, 'Names' => $Names, 'ListTimesheetSummary' => $ListProjectType, 'Emails' => $ToEmails, 'CCEmails' => $CCEmails, 'CurrentMonth' => $Month);
        Mail::send('summarybyprojectemail', $emaildata, function($message) {
            $message->from('owasiaonline@gmail.com','Project Management Team');
            $message->to('blankpoint88@gmail.com', 'Andika Rahman Hakim')->subject('Summary by Project');
            //$message->to('esuryani@openwaygroup.com', 'Eli Suryani')->subject('Summary by Project as of '.$this->Month);
            //$message->cc('blankpoint88@gmail.com', 'Andika Rahman Hakim');
            //$message->to($this->ToEmails)->subject('Summary by Project as of '.$this->Month);
            //$message->to('blankpoint88@gmail.com', 'Andika Rahman Hakim')->subject('Summary by Project as of '.$this->Month);
            //$message->to('dimas0maulana@gmail.com', 'Dimas Maulana')->subject('Summary by Project as of '.$this->Month);
            //$message->cc($this->CCEmails);
        });

        return 'Done';
    }
}