<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;
use Excel;
use Illuminate\Support\Facades\Crypt;
use DateTime;

class DownloadController extends Controller
{
    public function downloadExcelDate($DateFrom, $DateTo){
        $AttendanceLists = DB::select('call SP_Attendance_List_Filter_Date("'.$DateFrom.'", "'.$DateTo.'")');
        
        $data = array();
        foreach($AttendanceLists as $AttendanceList){
            $data[] = (array)$AttendanceList;
        }

        return Excel::create('Attendance '.date('Ymd', strtotime($DateFrom)).'-'.date('Ymd', strtotime($DateTo)).'', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download('xlsx');
    }

    public function downloadExcelRegion($Region){
        if ($Region == "All"){
            $AttendanceLists = DB::select('call SP_Attendance_List_All("'.session()->get('EmployeeID').'")');
        } else {
            $AttendanceLists = DB::select('call SP_Attendance_List_Filter_Region("'.$Region.'", "'.session()->get('EmployeeID').'")');
        }
        $data = array();
        foreach($AttendanceLists as $AttendanceList){
            $data[] = (array)$AttendanceList;
        }
        return Excel::create('Attendance '.$Region.'', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
                $sheet->cells('A1:J1', function($cells) {
                $cells->setBackground('#81CFE0');
                });
            });
        })->download('xlsx');
    }

    public function downloadExcelFilter($Region, $DateFrom, $DateTo)
    {
        $DateFrom =  DateTime::createFromFormat('d-m-Y', $DateFrom)->format('Y-m-d');
        $DateTo =  DateTime::createFromFormat('d-m-Y', $DateTo)->format('Y-m-d');
        if ($Region == "All"){
            $AttendanceLists = DB::select('call SP_Attendance_List_Filter_Date("'.$DateFrom.'", "'.$DateTo.'", "'.session()->get('EmployeeID').'")');
        } else {
            $AttendanceLists = DB::select('call SP_Attendance_List_Filtered("'.$Region.'", "'.$DateFrom.'", "'.$DateTo.'", "'.session()->get('EmployeeID').'")');
        }
        $data = array();
        foreach($AttendanceLists as $AttendanceList){
            $data[] = (array)$AttendanceList;
        }



        return Excel::create('Attendance '.$Region.' '.date('Ymd', strtotime($DateFrom)).' '.date('Ymd', strtotime($DateTo)).'', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
                $sheet->cells('A1:J1', function($cells) {
                $cells->setBackground('#81CFE0');
                });
            });
        })->download('xlsx');
    }

    public function downloadFile($encryptedfilename)
    {
    	$decryptedfilename = Crypt::decrypt($encryptedfilename);
        $file = public_path().'/uploads/'.$decryptedfilename.'';

    	return response()->download($file);
    }
}
