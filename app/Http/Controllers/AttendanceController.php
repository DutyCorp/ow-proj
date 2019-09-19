<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Excel;
use DateTime;

class AttendanceController extends Controller
{
    public function UploadAttendanceData(Request $request){
    	$RegionID = $request->RegionID;
    	if ($request->hasFile('AttendanceExcelData')){
    		$AttendanceExcelData  = $request->file('AttendanceExcelData');
    		$FileName             = $AttendanceExcelData->getClientOriginalName();
            $FileExtension        = \File::extension($FileName);
    		if ($FileExtension == 'xls' || $FileExtension == 'xlsx'){
                $employeearray = [];
                $countemployee = null;
    			if ($RegionID == 'ID'){
                    $excel          = [];
                    $duplicatearray = [];
                    $count          = 0;
                    $path           = $AttendanceExcelData->getRealPath();
                    Excel::load($path, function($reader) use (&$excel) {
                        $reader->formatDates(true);
                        $objExcel       = $reader->getExcel();
                        $sheet          = $objExcel->getSheet(0);
                        $highestRow     = $sheet->getHighestRow();
                        $highestColumn  = $sheet->getHighestColumn();
                        for ($row = 2; $row <= $highestRow; $row++)
                        {
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE);
                            $excel[] = $rowData[0];
                        }
                    });
                    if ($excel[0][0] != 'ID NO'){
                        return response()->json(array('msg' => 'Please check your Excel file', 'notinsert' => ''));
                    }
                    $countemployee = 0;
                    for ($i = 1; $i < sizeof($excel); $i++){
                        if ($excel[$i][2] != null){
                            $EmployeeName = ''.$excel[$i][1].' '.$excel[$i][2].'';
                        } else {
                            $EmployeeName = ''.$excel[$i][1];
                        }
                        $Query = DB::select('call SP_GetEmployeeIDAttendance("'.$EmployeeName.'", "'.$RegionID.'")');
                        if (sizeof($Query) != 0){
                            $EmployeeID = $Query[0]->EmployeeID;
                        } else {
                            $EmployeeID = null;
                        }
                        if ($EmployeeID != null){
                            $TotalTime = '00:00:00';
                            $CheckAttendance = DB::table('attendance')->
                                                where('EmployeeID', '=', $EmployeeID)->
                                                where('Date', '=', date('Y-m-d', strtotime($excel[$i][3])))->
                                                where('IsActive', '=', 1)->count();
                            if ($CheckAttendance == 1){
                                if($excel[$i][4] != null || $excel[$i][5] != null){
                                    if($excel[$i][4] != null && $excel[$i][5] != null){
                                        $Time_In    = new DateTime($excel[$i][4]);
                                        $Time_Out   = new DateTime($excel[$i][5]);
                                        $TotalTime  = $Time_In->diff($Time_Out);
                                        $duplicate  = array(
                                            'EmployeeID'    => $EmployeeID, 
                                            'RegionID'      => $RegionID, 
                                            'Date'          => date('Y-m-d', strtotime($excel[$i][3])), 
                                            'Time_In'       => date('H:i:s', strtotime($excel[$i][4])), 
                                            'Time_Out'      => date('H:i:s', strtotime($excel[$i][5])), 
                                            'TotalTime'     => date('H:i:s', strtotime($TotalTime->format("%H:%I:%S"))), 
                                            'Tr_User_I'     => session()->get('EmployeeID'), 
                                            'Tr_Date_I'     => date('Y-m-d H:i:s'), 
                                            'IsActive'      => '1'
                                        );
                                    } else {
                                        $duplicate = array(
                                            'EmployeeID'    => $EmployeeID, 
                                            'RegionID'      => $RegionID, 
                                            'Date'          => date('Y-m-d', strtotime($excel[$i][3])), 
                                            'Time_In'       => date('H:i:s', strtotime($excel[$i][4])), 
                                            'Time_Out'      => date('H:i:s', strtotime($excel[$i][5])), 
                                            'TotalTime'     => date('H:i:s', strtotime($TotalTime)), 
                                            'Tr_User_I'     => session()->get('EmployeeID'), 
                                            'Tr_Date_I'     => date('Y-m-d H:i:s'), 
                                            'IsActive'      => '1'
                                        );
                                    }
                                    $duplicatearray[$count] = $duplicate;
                                    $count++;
                                }
                            } else {
                                if($excel[$i][4] != null || $excel[$i][5] != null){
                                    $RawAttendanceID = DB::select('call SP_getMaxAttendanceID');
                                    if (sizeof($RawAttendanceID) != 0){
                                        $AttendanceSplit = str_split($RawAttendanceID[0]->AttendanceID, 8);
                                        if ($AttendanceSplit[0] == date('Ymd')){
                                            $AttendanceNumber = sprintf('%05d', $AttendanceSplit[1]+1);
                                            $AttendanceID = date('Ymd').''.$AttendanceNumber;
                                        } else {
                                            $AttendanceID = date('Ymd').'00001';
                                        }
                                    } else {
                                        $AttendanceID = date('Ymd').'00001';
                                    }
                                    if($excel[$i][4] != null && $excel[$i][5] != null){
                                        $Time_In    = new DateTime($excel[$i][4]);
                                        $Time_Out   = new DateTime($excel[$i][5]);
                                        $TotalTime  = $Time_In->diff($Time_Out);
                                        DB::select('call SP_InsertAttendance("'.$AttendanceID.'", 
                                            "'.$EmployeeID.'", 
                                            "'.date('Y-m-d', strtotime($excel[$i][3])).'", 
                                            "'.$RegionID.'", 
                                            "'.date('H:i:s', strtotime($excel[$i][4])).'", 
                                            "'.date('H:i:s', strtotime($excel[$i][5])).'", 
                                            "'.date('H:i:s', strtotime($TotalTime->format("%H:%I:%S"))).'", 
                                            "'.session()->get('EmployeeID').'", 
                                            "'.date('Y-m-d H:i:s').'")'
                                        );
                                    } else {
                                        DB::select('call SP_InsertAttendance("'.$AttendanceID.'", 
                                            "'.$EmployeeID.'", 
                                            "'.date('Y-m-d', strtotime($excel[$i][3])).'", 
                                            "'.$RegionID.'", 
                                            "'.date('H:i:s', strtotime($excel[$i][4])).'", 
                                            "'.date('H:i:s', strtotime($excel[$i][5])).'", 
                                            "'.date('H:i:s', strtotime($TotalTime)).'", 
                                            "'.session()->get('EmployeeID').'", 
                                            "'.date('Y-m-d H:i:s').'")'
                                        );
                                    }
                                }
                            }
                        }
                        else {
                            $employeearray[$countemployee] = $EmployeeName;
                            $countemployee++;
                        }
                    }
                    if ($count > 0){
                        if ($countemployee == 0){
                            return response()->json(array('duplicatearray' => $duplicatearray, 'count' => $count, 'notinsert' => ''));
                        } else {
                            $niarray        = array_values(array_unique($employeearray));
                            $niarraylength  = sizeof($niarray);
                            $notinsert      = ', but there are several employees that are not inserted in our system. Such as : ';
                            for ($i = 0; $i < $niarraylength; $i++){
                                if ($i + 1 == $niarraylength){
                                    $notinsert .= ''.$niarray[$i].'.';
                                } else {
                                    $notinsert .= ''.$niarray[$i].', ';
                                }
                            }
                            return response()->json(array('duplicatearray' => $duplicatearray, 'count' => $count, 'notinsert' => $notinsert));
                        }
                    } else {
                       return response()->json(array('msg' => 'Success', 'notinsert' => ''));
                    }
    			} else if ($RegionID == 'MY'){
                    $excel          = [];
                    $path           = $AttendanceExcelData->getRealPath();
                    $duplicatearray = [];
                    $count          = 0;
                    Excel::load($path, function($reader) use (&$excel) {
                        $reader->formatDates(true);
                        $objExcel       = $reader->getExcel();
                        $sheet          = $objExcel->getSheet(0);
                        $highestRow     = $sheet->getHighestRow();
                        $highestColumn  = $sheet->getHighestColumn();
                        for ($row = 1; $row <= $highestRow; $row++)
                        {
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE);
                            $excel[] = $rowData[0];
                        }
                    });
                    if ($excel[0][0] != 'AC-No.'){
                        return response()->json(array('msg' => 'Please check your Excel file', 'notinsert' => ''));
                    }
                    $countemployee = 0;
                    for ($i = 1; $i < sizeof($excel); $i++){
                        $EmployeeName   = $excel[$i][1];
                        $Query          = DB::select('call SP_GetEmployeeIDAttendance("'.$EmployeeName.'", "'.$RegionID.'")');
                        if (sizeof($Query) != 0){
                            $EmployeeID = $Query[0]->EmployeeID;
                        } else { 
                            $EmployeeID = null;
                        }
                        if ($EmployeeID != null){
                            $date               = str_replace('/', '-', $excel[$i][2]);
                            $TotalTime          = '00:00:00';
                            $CheckAttendance    = DB::table('attendance')->
                                                    where('EmployeeID', '=', $EmployeeID)->
                                                    where('Date', '=', date('Y-m-d', strtotime($date)))->
                                                    where('IsActive', '=', 1)->count();
                            if ($CheckAttendance == 1){
                                 if ($excel[$i][8] != 'True'){
                                    if ($excel[$i][5] != null && $excel[$i][6] != null){
                                        $Time_In    = new DateTime($excel[$i][5]);
                                        $Time_Out   = new DateTime($excel[$i][6]);
                                        $TotalTime  = $Time_In->diff($Time_Out);
                                        $duplicate  = array(
                                            'EmployeeID'    => $EmployeeID, 
                                            'RegionID'      => $RegionID, 
                                            'Date'          => date('Y-m-d', strtotime($date)), 
                                            'Time_In'       => date('H:i:s', strtotime($excel[$i][5])), 
                                            'Time_Out'      => date('H:i:s', strtotime($excel[$i][6])), 
                                            'TotalTime'     => date('H:i:s', strtotime($TotalTime->format("%H:%I:%S"))), 
                                            'Tr_User_I'     => session()->get('EmployeeID'), 
                                            'Tr_Date_I'     => date('Y-m-d H:i:s'), 
                                            'IsActive'      => '1'
                                        );
                                    } else if ($excel[$i][5] != null || $excel[$i][6] != null) {
                                        $duplicate = array(
                                            'EmployeeID'    => $EmployeeID, 
                                            'RegionID'      => $RegionID, 
                                            'Date'          => date('Y-m-d', strtotime($date)), 
                                            'Time_In'       => date('H:i:s', strtotime($excel[$i][5])), 
                                            'Time_Out'      => date('H:i:s', strtotime($excel[$i][6])), 
                                            'TotalTime'     => date('H:i:s', strtotime($TotalTime)), 
                                            'Tr_User_I'     => session()->get('EmployeeID'), 
                                            'Tr_Date_I'     => date('Y-m-d H:i:s'), 
                                            'IsActive'      => '1'
                                        );
                                    }
                                }
                                $duplicatearray[$count] = $duplicate;
                                $count++;
                            } else {
                                $date       = str_replace('/', '-', $excel[$i][2]);
                                $TotalTime  = '00:00:00';
                                if ($excel[$i][8] != 'True'){
                                    $RawAttendanceID = DB::select('call SP_getMaxAttendanceID');
                                    if (sizeof($RawAttendanceID) != 0){
                                        $AttendanceSplit = str_split($RawAttendanceID[0]->AttendanceID, 8);
                                        if ($AttendanceSplit[0] == date('Ymd')){
                                            $AttendanceNumber   = sprintf('%05d', $AttendanceSplit[1]+1);
                                            $AttendanceID       = date('Ymd').''.$AttendanceNumber;
                                        } else {
                                            $AttendanceID = date('Ymd').'00001';
                                        }
                                    } else {
                                        $AttendanceID = date('Ymd').'00001';
                                    }
                                    if ($excel[$i][5] != null && $excel[$i][6] != null){
                                        $Time_In    = new DateTime($excel[$i][5]);
                                        $Time_Out   = new DateTime($excel[$i][6]);
                                        $TotalTime  = $Time_In->diff($Time_Out);
                                        DB::select('call SP_InsertAttendance("'.$AttendanceID.'", 
                                            "'.$EmployeeID.'", 
                                            "'.date('Y-m-d', strtotime($date)).'", 
                                            "'.$RegionID.'", 
                                            "'.date('H:i:s', strtotime($excel[$i][5])).'", 
                                            "'.date('H:i:s', strtotime($excel[$i][6])).'", 
                                            "'.date('H:i:s', strtotime($TotalTime->format("%H:%I:%S"))).'", 
                                            "'.session()->get('EmployeeID').'", 
                                            "'.date('Y-m-d H:i:s').'")'
                                        );
                                    } else if ($excel[$i][5] != null || $excel[$i][6] != null) {
                                        DB::select('call SP_InsertAttendance("'.$AttendanceID.'", 
                                            "'.$EmployeeID.'", 
                                            "'.date('Y-m-d', strtotime($date)).'", 
                                            "'.$RegionID.'", 
                                            "'.date('H:i:s', strtotime($excel[$i][5])).'", 
                                            "'.date('H:i:s', strtotime($excel[$i][6])).'", 
                                            "'.date('H:i:s', strtotime($TotalTime)).'", 
                                            "'.session()->get('EmployeeID').'", 
                                            "'.date('Y-m-d H:i:s').'")'
                                        );
                                    }
                                }
                            }
                        }
                        else {
                            $employeearray[$countemployee] = $EmployeeName;
                            $countemployee++;
                        }
                    }
                    if ($count > 0){
                        if ($countemployee == 0){
                            return response()->json(array('duplicatearray' => $duplicatearray, 'count' => $count, 'notinsert' => ''));
                        } else {
                            $niarray        = array_values(array_unique($employeearray));
                            $niarraylength  = sizeof($niarray);
                            $notinsert      = ', but there are several employees that are not inserted in our system. Such as : ';
                            for ($i = 0; $i < $niarraylength; $i++){
                                if ($i + 1 == $niarraylength){
                                    $notinsert .= ''.$niarray[$i].'.';
                                } else {
                                    $notinsert .= ''.$niarray[$i].', ';
                                }
                            }
                            return response()->json(array('duplicatearray' => $duplicatearray, 'count' => $count, 'notinsert' => $notinsert));
                        }
                    } else {
                       return response()->json(array('msg' => 'Success', 'notinsert' => ''));
                    }
    			} else if ($RegionID == 'VN'){
                    $duplicatearray = [];
                    $count          = 0;
                    $excel          = [];
                    $path           = $AttendanceExcelData->getRealPath();

                    Excel::load($path, function($reader) use (&$excel) {
                        $reader->formatDates(true);
                        $objExcel       = $reader->getExcel();
                        $sheet          = $objExcel->getSheet(0);
                        $highestRow     = $sheet->getHighestRow();
                        $highestColumn  = $sheet->getHighestColumn();

                        for ($row = 2; $row <= $highestRow; $row++)
                        {
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE);
                            $excel[] = $rowData[0];
                        }
                    });
                    if ($excel[0][0] != 'Ma NV'){
                        return response()->json(array('msg' => 'Please check your Excel file', 'notinsert' => ''));
                    }
                    $countemployee = 0;
                    for ($i = 1; $i < sizeof($excel); $i++){
                        $EmployeeName = $excel[$i][1];
                        $Query = DB::select('call SP_GetEmployeeIDAttendance("'.$EmployeeName.'", "'.$RegionID.'")');
                        if (sizeof($Query) != 0){
                           $EmployeeID = $Query[0]->EmployeeID;
                        } else {
                            $EmployeeID = null;
                        }

                        if ($EmployeeID != null){
                            $olddate    = str_replace('/', '-', $excel[$i][3]);
                            $date       = DateTime::createFromFormat('m-d-y', $olddate)->format('Y-m-d');
                            $TotalTime  = '00:00:00';
                            $CheckAttendance = DB::table('attendance')->
                                                where('EmployeeID', '=', $EmployeeID)->
                                                where('Date', '=', $date)->
                                                where('IsActive', '=', 1)->count();
                            if ($CheckAttendance == 1){
                                if ($excel[$i][4] != null || $excel[$i][14] != "0:00"){
                                    if ($excel[$i][14] != "0:00" && $excel[$i][4] != null){
                                        $Time_In    = new DateTime($excel[$i][4]);
                                        $Time_Out   = new DateTime($excel[$i][14]);
                                        $TotalTime  = $Time_In->diff($Time_Out);
                                        $duplicate  = array(
                                            'EmployeeID'    => $EmployeeID, 
                                            'RegionID'      => $RegionID, 
                                            'Date'          => $date, 
                                            'Time_In'       => date('H:i:s', strtotime($excel[$i][4])), 
                                            'Time_Out'      => date('H:i:s', strtotime($excel[$i][14])), 
                                            'TotalTime'     => date('H:i:s', strtotime($TotalTime->format("%H:%I:%S"))), 
                                            'Tr_User_I'     => session()->get('EmployeeID'), 
                                            'Tr_Date_I'     => date('Y-m-d H:i:s'), 
                                            'IsActive'      => '1'
                                        );
                                    } else {
                                        $duplicate = array(
                                            'EmployeeID'    => $EmployeeID, 
                                            'RegionID'      => $RegionID, 
                                            'Date'          => $date, 
                                            'Time_In'       => date('H:i:s', strtotime($excel[$i][4])), 
                                            'Time_Out'      => date('H:i:s', strtotime($excel[$i][14])), 
                                            'TotalTime'     => date('H:i:s', strtotime($TotalTime)), 
                                            'Tr_User_I'     => session()->get('EmployeeID'), 
                                            'Tr_Date_I'     => date('Y-m-d H:i:s'), 
                                            'IsActive'      => '1'
                                        );
                                    }
                                    $duplicatearray[$count] = $duplicate;
                                    $count++;
                                }
                            } else {
                                if ($excel[$i][4] != null || $excel[$i][14] != "0:00"){
                                    $RawAttendanceID = DB::select('call SP_getMaxAttendanceID');
                                    if (sizeof($RawAttendanceID) != 0){
                                        $AttendanceSplit = str_split($RawAttendanceID[0]->AttendanceID, 8);
                                        if ($AttendanceSplit[0] == date('Ymd')){
                                            $AttendanceNumber   = sprintf('%05d', $AttendanceSplit[1]+1);
                                            $AttendanceID       = date('Ymd').''.$AttendanceNumber;
                                        } else {
                                            $AttendanceID = date('Ymd').'00001';
                                        }
                                    } else {
                                        $AttendanceID = date('Ymd').'00001';
                                    }
                                    if ($excel[$i][14] != "0:00" && $excel[$i][4] != null){
                                        $Time_In    = new DateTime($excel[$i][4]);
                                        $Time_Out   = new DateTime($excel[$i][14]);
                                        $TotalTime  = $Time_In->diff($Time_Out);
                                        DB::select('call SP_InsertAttendance("'.$AttendanceID.'", 
                                            "'.$EmployeeID.'", 
                                            "'.$date.'", 
                                            "'.$RegionID.'", 
                                            "'.date('H:i:s', strtotime($excel[$i][4])).'", 
                                            "'.date('H:i:s', strtotime($excel[$i][14])).'", 
                                            "'.date('H:i:s', strtotime($TotalTime->format("%H:%I:%S"))).'", 
                                            "'.session()->get('EmployeeID').'", 
                                            "'.date('Y-m-d H:i:s').'")'
                                        );
                                    } else {
                                        DB::select('call SP_InsertAttendance("'.$AttendanceID.'", 
                                            "'.$EmployeeID.'", 
                                            "'.$date.'", 
                                            "'.$RegionID.'", 
                                            "'.date('H:i:s', strtotime($excel[$i][4])).'", 
                                            "'.date('H:i:s', strtotime($excel[$i][14])).'", 
                                            "'.date('H:i:s', strtotime($TotalTime->format("%H:%I:%S"))).'", 
                                            "'.session()->get('EmployeeID').'", 
                                            "'.date('Y-m-d H:i:s').'")'
                                        );
                                    }
                                }
                            }
                        }
                        else {
                            $employeearray[$countemployee] = $EmployeeName;
                            $countemployee++;
                        }
                    }
                    if ($count > 0){
                        if ($countemployee == 0){
                            return response()->json(array('duplicatearray' => $duplicatearray, 'count' => $count, 'notinsert' => ''));
                        } else {
                            $niarray        = array_values(array_unique($employeearray));
                            $niarraylength  = sizeof($niarray);
                            $notinsert      = ', but there are several employees that are not inserted in our system. Such as : ';
                            for ($i = 0; $i < $niarraylength; $i++){
                                if ($i + 1 == $niarraylength){
                                    $notinsert .= ''.$niarray[$i].'.';
                                } else {
                                    $notinsert .= ''.$niarray[$i].', ';
                                }
                            }
                            return response()->json(array('duplicatearray' => $duplicatearray, 'count' => $count, 'notinsert' => $notinsert));
                        }
                    } else {
                       return response()->json(array('msg' => 'Success', 'notinsert' => ''));
                    }
    			} else {
                    return response()->json('Region not supported'); 
                }
                if ($countemployee != null){
                    if ($countemployee == 0){
                        return response()->json(array('msg' => 'Success', 'notinsert' => '')); 
                    } else {
                        $niarray        = array_values(array_unique($employeearray));
                        $niarraylength  = sizeof($niarray);
                        $notinsert      = ', but there are several employees that are not inserted in our system. Such as : ';
                        for ($i = 0; $i < $niarraylength; $i++){
                            if ($i + 1 == $niarraylength){
                                $notinsert .= ''.$niarray[$i].'.';
                            } else {
                                $notinsert .= ''.$niarray[$i].', ';
                            }
                        }
                        return response()->json(array('msg' => 'Success', 'notinsert' => $notinsert));
                    }
                } 
    		} else {
    			return response()->json(array('msg' => 'Wrong File Extension!', 'notinsert' => ''));
    		}
    	} else {
    		return response()->json(array('msg' => 'No File Uploaded!', 'notinsert' => ''));
    	}  
    }

    public function ReplaceDuplicateData(Request $request){
        $lists = $request->data;
        foreach($lists as $list){
            $RawAttendanceID = DB::select('call SP_getMaxAttendanceID');
            $AttendanceSplit = str_split($RawAttendanceID[0]->AttendanceID, 8);
            if ($AttendanceSplit[0] == date('Ymd')){
                $AttendanceNumber   = sprintf('%05d', $AttendanceSplit[1]+1);
                $AttendanceID       = date('Ymd').''.$AttendanceNumber;
            } else {
                $AttendanceID = date('Ymd').'00001';
            }
            DB::select('call SP_ReplaceAttendanceData("'.$list['EmployeeID'].'", "'.date('Y-m-d', strtotime($list['Date'])).'", "'.session()->get('EmployeeID').'")');
            DB::select('call SP_InsertAttendance("'.$AttendanceID.'", 
                "'.$list['EmployeeID'].'", 
                "'.date('Y-m-d', strtotime($list['Date'])).'", 
                "'.$list['RegionID'].'", 
                "'.date('H:i:s', strtotime($list['Time_In'])).'", 
                "'.date('H:i:s', strtotime($list['Time_Out'])).'", 
                "'.date('H:i:s', strtotime($list['TotalTime'])).'", 
                "'.session()->get('EmployeeID').'", 
                "'.date('Y-m-d H:i:s').'")'
            );
        }
        $lists = null;
        return response()->json('Data successfully replaced');
    }

    public function getAttendanceData(Request $request){
        $Region     = $request->filterRegion;
        if ($request->filterDateFrom != "")
            $DateFrom   = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $request->filterDateFrom))->format('Y-m-d');
        else
            $DateFrom   = $request->filterDateFrom;

        if ($request->filterDateTo != "")
            $DateTo   = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $request->filterDateTo))->format('Y-m-d');
        else
            $DateTo   = $request->filterDateTo;

        if ($Region == "All" && ($DateFrom == "" && $DateTo == "")){
            $LastsUpdate = DB::select('call SP_GetAttendanceLatestUpdate()');
            $AttendanceList = DB::select('call SP_Attendance_List_All("'.session()->get('EmployeeID').'")');
        } else if ($Region != "All" && ($DateFrom == "" && $DateTo == "")){
            $LastsUpdate = DB::select('call SP_GetAttendanceLatestUpdateRegion("'.$Region.'")');
            $AttendanceList = DB::select('call SP_Attendance_List_Filter_Region("'.$Region.'", "'.session()->get('EmployeeID').'")');
        } else if ($Region == "All" && ($DateFrom != "" && $DateTo != "")){
            $LastsUpdate = DB::select('call SP_GetAttendanceLatestUpdate()');
            $AttendanceList = DB::select('call SP_Attendance_List_Filter_Date("'.$DateFrom.'", "'.$DateTo.'", "'.session()->get('EmployeeID').'")');
        } else if ($Region != "All" && ($DateFrom != "" && $DateTo != "")){
            $LastsUpdate = DB::select('call SP_GetAttendanceLatestUpdateRegion("'.$Region.'")');
            $AttendanceList = DB::select('call SP_Attendance_List_Filtered("'.$Region.'", "'.$DateFrom.'", "'.$DateTo.'", "'.session()->get('EmployeeID').'")');
        }

        $returnHTML = view('table_attendancelist', compact('AttendanceList', 'LastsUpdate'))->render();

        return response()->json($returnHTML);
    }

    public function getAttendanceReportColumnChart(Request $request){
        $RegionID           = $request->RegionID;
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
        if($RegionID == "All"){
            $Row    = DB::select('call SP_Attendance_Report_Region_All("'.$DateFrom.'", "'.$DateTo.'")');
        }else if($RegionID == "Asia"){
            $Row    = DB::select('call SP_Attendance_Report_Region_Asia("'.$DateFrom.'", "'.$DateTo.'")');
        }else{
            $Row    = DB::select('call SP_Attendance_Report_Region_Filtered("'.$RegionID.'", "'.$DateFrom.'", "'.$DateTo.'")');    
        }
        return response()->json($Row);
    }

    public function getAttendanceReportPieChart(Request $request){
        $EmployeeID         = $request->EmployeeID;
        $DateFrom           = $request->DateFrom;
        $DateTo             = $request->DateTo;
        
        $EmployeeData = DB::select('call SP_GetEmployeeData("'.$EmployeeID.'")');
        $Row = DB::select('call SP_Attendance_Report_Individual_Name_Date("'.$EmployeeID.'", "'.$DateFrom.'", "'.$DateTo.'")');
        return response()->json(array('EmployeeData' => $EmployeeData, 'Row' => $Row));
    }

    public function getEmployeeAttendanceReport(){
        $List = DB::select('call SP_GetEmployeeAttendanceReport("'.session()->get('EmployeeID').'")');
        return response()->json($List);
    }
}
