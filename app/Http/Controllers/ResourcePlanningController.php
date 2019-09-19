<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Excel;
use DateTime;

class ResourcePlanningController extends Controller
{
    public function DownloadBVA(Request $request){
        $ContentData        = DB::select('call SP_All_ResourcePlanning_BudgetVersusActual');
        $NewContentData     = array();
        for($j = 0; $j< sizeof($ContentData); $j++){
            $TempContentData = [];
            array_push($TempContentData, $ContentData[$j]->Region);
            array_push($TempContentData, $ContentData[$j]->ProjectID);
            array_push($TempContentData, $ContentData[$j]->ProjectName);

            array_push($TempContentData, $ContentData[$j]->B_January);
            array_push($TempContentData, $ContentData[$j]->A_January);
            array_push($TempContentData, $ContentData[$j]->B_January - $ContentData[$j]->A_January);

            array_push($TempContentData, $ContentData[$j]->B_February);
            array_push($TempContentData, $ContentData[$j]->A_February);
            array_push($TempContentData, $ContentData[$j]->B_February - $ContentData[$j]->A_February);

            array_push($TempContentData, $ContentData[$j]->B_March);
            array_push($TempContentData, $ContentData[$j]->A_March);
            array_push($TempContentData, $ContentData[$j]->B_March - $ContentData[$j]->A_March);

            array_push($TempContentData, $ContentData[$j]->B_April);
            array_push($TempContentData, $ContentData[$j]->A_April);
            array_push($TempContentData, $ContentData[$j]->B_April - $ContentData[$j]->A_April);

            array_push($TempContentData, $ContentData[$j]->B_May);
            array_push($TempContentData, $ContentData[$j]->A_May);
            array_push($TempContentData, $ContentData[$j]->B_May - $ContentData[$j]->A_May);

            array_push($TempContentData, $ContentData[$j]->B_June);
            array_push($TempContentData, $ContentData[$j]->A_June);
            array_push($TempContentData, $ContentData[$j]->B_June - $ContentData[$j]->A_June);

            array_push($TempContentData, $ContentData[$j]->B_July);
            array_push($TempContentData, $ContentData[$j]->A_July);
            array_push($TempContentData, $ContentData[$j]->B_July - $ContentData[$j]->A_July);

            array_push($TempContentData, $ContentData[$j]->B_August);
            array_push($TempContentData, $ContentData[$j]->A_August);
            array_push($TempContentData, $ContentData[$j]->B_August - $ContentData[$j]->A_August);

            array_push($TempContentData, $ContentData[$j]->B_September);
            array_push($TempContentData, $ContentData[$j]->A_September);
            array_push($TempContentData, $ContentData[$j]->B_September - $ContentData[$j]->A_September);

            array_push($TempContentData, $ContentData[$j]->B_October);
            array_push($TempContentData, $ContentData[$j]->A_October);
            array_push($TempContentData, $ContentData[$j]->B_October - $ContentData[$j]->A_October);

            array_push($TempContentData, $ContentData[$j]->B_November);
            array_push($TempContentData, $ContentData[$j]->A_November);
            array_push($TempContentData, $ContentData[$j]->B_November - $ContentData[$j]->A_November);

            array_push($TempContentData, $ContentData[$j]->B_December);
            array_push($TempContentData, $ContentData[$j]->A_December);
            array_push($TempContentData, $ContentData[$j]->B_December - $ContentData[$j]->A_December);

            array_push($NewContentData, $TempContentData);
        }
        $Title1     = ["Budget vs Actual"];
        $Title2     = [""];
        $TopHeader = ["Region","ProjectID","ProjectName","January","","","February","","","March","","","April","","","May","","","June","","","July","","","August","","","September","","","October","","","November","","","December","",""];
        $BotHeader = ["","","","Budget","Actual","Different","Budget","Actual","Different","Budget","Actual","Different","Budget","Actual","Different","Budget","Actual","Different","Budget","Actual","Different","Budget","Actual","Different","Budget","Actual","Different","Budget","Actual","Different","Budget","Actual","Different","Budget","Actual","Different","Budget","Actual","Different"];
        $data = array($Title1,$Title2,$TopHeader,$BotHeader);
        for($k = 0; $k < sizeof($NewContentData); $k++){
            array_push($data,$NewContentData[$k]);
        }
        return Excel::create('Budget Versus Actual', function($excel) use ($data) {
            $excel->sheet('Budget Versus Actual', function($sheet) use ($data) {
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->mergeCells('D3:F3');
                $sheet->mergeCells('G3:I3');
                $sheet->mergeCells('J3:L3');
                $sheet->mergeCells('M3:O3');
                $sheet->mergeCells('P3:R3');
                $sheet->mergeCells('S3:U3');
                $sheet->mergeCells('V3:X3');
                $sheet->mergeCells('Y3:AA3');
                $sheet->mergeCells('AB3:AD3');
                $sheet->mergeCells('AE3:AG3');
                $sheet->mergeCells('AH3:AJ3');
                $sheet->mergeCells('AK3:AM3');
                $sheet->getStyle('D4:AM4')->getAlignment()->applyFromArray(
                    array('horizontal' => 'center')
                );
                $sheet->getStyle('D3:AM3')->getAlignment()->applyFromArray(
                    array('horizontal' => 'center')
                );
            });
        })->download('xlsx');
    }

    public function UploadResourcePlanning(Request $request){
        DB::select('call SP_Clear_ResourcePlanning_Data');
        $RPExcelData        = $request->file('RPExcelData');
        $FileName           = $RPExcelData->getClientOriginalName();
        $FileExtension      = \File::extension($FileName);
        if($FileExtension == 'xls' || $FileExtension == 'xlsx'){
            $excel             = [];
            $path              = $RPExcelData->getRealPath();
            Excel::load($path, function($reader) use (&$excel) {
                $reader->formatDates(true);
                $objExcel       = $reader   ->getExcel();
                $sheet          = $objExcel ->getSheet(0);
                $highestRow     = $sheet    ->getHighestRow();
                $highestColumn  = $sheet    ->getHighestColumn();
                for ($row = 7; $row <= $highestRow; $row++) {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE);
                    $excel[] = $rowData[0];
                }
            });
            if ($excel[0][0] != 'Region') {
                return response()->json('Please check your Excel file');
            }
            for ($i = 1; $i < sizeof($excel); $i++) {
                $Region             = $excel[$i][0];
                $EmployeeID         = $excel[$i][1];
                $Type               = $excel[$i][3];
                $ProjectID          = $excel[$i][4];
                $ProjectName        = $excel[$i][5];
                if($excel[$i][6] == "")
                    $MDLeft         = 0;
                else
                    $MDLeft         = $excel[$i][6];

                if($excel[$i][7] == "")
                    $MDPlanned      = 0;
                else
                    $MDPlanned      = $excel[$i][7];

                if($excel[$i][8] == "")
                    $MDLeftByProject= 0;
                else
                    $MDLeftByProject= $excel[$i][8];

                if($excel[$i][9] == "")
                    $MDLastYear     = 0;
                else
                    $MDLastYear     = $excel[$i][9];

                if($excel[$i][10] == "")
                    $January        = 0;
                else
                    $January        = $excel[$i][10];

                if($excel[$i][11] == "")
                    $February       = 0;
                else
                    $February       = $excel[$i][11];

                if($excel[$i][12] == "")
                    $March          = 0;
                else
                    $March          = $excel[$i][12];

                if($excel[$i][13] == "")
                    $April          = 0;
                else
                    $April          = $excel[$i][13];

                if($excel[$i][14] == "")
                    $May            = 0;
                else
                    $May            = $excel[$i][14];

                if($excel[$i][15] == "")
                    $June           = 0;
                else
                    $June           = $excel[$i][15];

                if($excel[$i][16] == "")
                    $July           = 0;
                else
                    $July           = $excel[$i][16];

                if($excel[$i][17] == "")
                    $August         = 0;
                else
                    $August         = $excel[$i][17];

                if($excel[$i][18] == "")
                    $September      = 0;
                else
                    $September      = $excel[$i][18];

                if($excel[$i][19] == "")
                    $October        = 0;
                else
                    $October        = $excel[$i][19];

                if($excel[$i][20] == "")
                    $November       = 0;
                else
                    $November       = $excel[$i][20];

                if($excel[$i][21] == "")
                    $Desember       = 0;
                else
                    $Desember       = $excel[$i][21];

                if($excel[$i][22] == "")
                    $Delivery       = 0;
                else
                    $Delivery       = $excel[$i][22];

                if($excel[$i][23] == "")
                    $Support        = 0;
                else
                    $Support        = $excel[$i][23];

                if($excel[$i][24] == "")
                    $Sales          = 0;
                else
                    $Sales          = $excel[$i][24];

                if($excel[$i][25] == "")
                    $Internal       = 0;
                else
                    $Internal       = $excel[$i][25];

                if($excel[$i][26] == "")
                    $Chargeability  = 0;
                else
                    $Chargeability  = $excel[$i][26];
                
                DB::select('call SP_UploadResourcePlanning(     "'.$Region.'",
                                                                "'.$EmployeeID.'",
                                                                "'.$Type.'",
                                                                "'.$ProjectID.'",
                                                                "'.$ProjectName.'",
                                                                "'.$MDLeft.'",
                                                                "'.$MDPlanned.'",
                                                                "'.$MDLeftByProject.'",
                                                                "'.$MDLastYear.'",
                                                                "'.$January.'",
                                                                "'.$February.'",
                                                                "'.$March.'",
                                                                "'.$April.'",
                                                                "'.$May.'",
                                                                "'.$June.'",
                                                                "'.$July.'",
                                                                "'.$August.'",
                                                                "'.$September.'",
                                                                "'.$October.'",
                                                                "'.$November.'",
                                                                "'.$Desember.'",
                                                                "'.$Delivery.'",
                                                                "'.$Support.'",
                                                                "'.$Sales.'",
                                                                "'.$Internal.'",
                                                                "'.$Chargeability.'"
                                                        )');                     
            }  
        }else{
            return response()->json('Wrong File Extension!');
        }
        return response()->json("Success Upload Resource Planning");
    }

    function numToExcelAlpha($n) {
        $r = 'A';
        while ($n-- > 1) {
            $r++;
        }
        return $r;
    }

    public function DownloadTemplateRP($DateData,$IDWD,$MYWD,$THWD,$VNWD,$DateFrom,$DateTo)
    {
        $NewDateData        = explode(",", $DateData);
        $NewIDWD            = explode(",", $IDWD);
        $NewMYWD            = explode(",", $MYWD);
        $NewTHWD            = explode(",", $THWD);
        $NewVNWD            = explode(",", $VNWD);
        $HeaderWorkingDay   = ["OWA Resource Planning","","","","","","","","",""];
        $ContentData        = DB::select('call SP_All_ResourcePlanning("'.$DateFrom.'", "'.$DateTo.'")');
        $RegionCharge       = ["Period From ".$NewDateData[0].' - '.$NewDateData[sizeof($NewDateData)-1],"","","","","","","","","OWA Chargeability"];
        $TopID              = ["","","","","","","","","","ID"];
        $TopMY              = ["Notes","","","","","","","","","MY"];
        $TopTH              = ["Please Delete / Add unnecesarry ROW","","","","","","","","","TH"];
        $TopVN              = ["Please to see all active project in the Summary Report","","","","","","","","","VN"];
        $Header             = ["Region","Initials","Matchcode","Type","Initials","Project Name","MDLeft","MDPlanned by Project","MDLeft by Project","MD Last Year(Actual)"];
        $ContentDataSummary = DB::select('call SP_All_ResourcePlanning_Summary("'.$DateFrom.'", "'.$DateTo.'")');
        $Header_1_Sum       = ["Resource Plan Summary","","","","","","","","Type"];
        $HeaderSummary      = ["Region","Project ID","ProjectName","MDLeft","Type","Start New Project","%Opportunity","Number of Person","MDPlanned Total"];
        $Header_2_Sum       = ["Period From ".$NewDateData[0].' - '.$NewDateData[sizeof($NewDateData)-1],"","","","","","","","Delivery"];
        $Header_3_Sum       = ["","","","","","","","","Support"];
        $Header_4_Sum       = ["","","","","","","","","Sales"];
        $Header_5_Sum       = ["","","","","","","","","Internal"];
        $Header_6_Sum       = ["","","","","","","","","#Chargeable"];
        $Header_7_Sum       = ["","New Sales with chance of 'New Sales Status'  and estimated will start on 'Start New Project'","","","","","","","#Non Chargeable"];
        $Header_8_Sum       = ["","Estimated MDs Left to accomplish the project","","","","","","","Est. Occ. Rate %"];
        for($i = 0; $i < sizeof($NewDateData); $i++){
            array_push($HeaderWorkingDay,$NewDateData[$i]);
            array_push($Header,$NewDateData[$i]); 
            array_push($Header_1_Sum,$NewDateData[$i]);
            array_push($HeaderSummary,$NewDateData[$i]); 
            array_push($TopID,(int)$NewIDWD[$i]); 
            array_push($TopMY,(int)$NewMYWD[$i]); 
            array_push($TopTH,(int)$NewTHWD[$i]); 
            array_push($TopVN,(int)$NewVNWD[$i]); 
        }
        array_push($Header,"Total");
        array_push($Header,"Delivery");
        array_push($Header,"Support");
        array_push($Header,"Sales");
        array_push($Header,"Internal");
        array_push($Header,"%Chargeability(forecasted)");

        $NewContentData = array();
        for($j = 0; $j< sizeof($ContentData); $j++){
            $TempContentData = [];
            array_push($TempContentData, $ContentData[$j]->RegionName);
            array_push($TempContentData, $ContentData[$j]->EmployeeID);
            array_push($TempContentData, $ContentData[$j]->EmployeeName);
            array_push($TempContentData, $ContentData[$j]->ProjectType);
            array_push($TempContentData, $ContentData[$j]->ProjectID);
            array_push($TempContentData, $ContentData[$j]->ProjectName);
            
            if($ContentData[$j]->MDLeft != 0)
                array_push($TempContentData, (int)$ContentData[$j]->MDLeft);
            else
                array_push($TempContentData, 0);

            array_push($TempContentData, "");
            array_push($TempContentData, "");

            if($ContentData[$j]->MDYear != 0)
                array_push($TempContentData, (int)$ContentData[$j]->MDYear);
            else
                array_push($TempContentData, 0);

            array_push($NewContentData, $TempContentData);
        }
        $NewContentDataSummary = array();
        for($j = 0; $j< sizeof($ContentDataSummary); $j++){
            $TempContentDataSummary = [];
            array_push($TempContentDataSummary, $ContentDataSummary[$j]->RegionID);
            array_push($TempContentDataSummary, $ContentDataSummary[$j]->ProjectID);
            array_push($TempContentDataSummary, $ContentDataSummary[$j]->ProjectName);
            
            if($ContentDataSummary[$j]->MDLeft != 0)
                array_push($TempContentDataSummary, (int)$ContentDataSummary[$j]->MDLeft);
            else
                array_push($TempContentDataSummary, 0);

            array_push($TempContentDataSummary, $ContentDataSummary[$j]->ProjectType);
            array_push($TempContentDataSummary, $ContentDataSummary[$j]->StartNewProject);

            if($ContentDataSummary[$j]->Opportunity != 0)
                array_push($TempContentDataSummary, $ContentDataSummary[$j]->Opportunity."%");
            else
                array_push($TempContentDataSummary, 0);

            array_push($NewContentDataSummary, $TempContentDataSummary);
        }

        $indexOfProspect = [];
        for($x=0; $x<sizeof($NewContentData); $x++){
            if(strpos($NewContentData[$x][1], 'X') == true)
                array_push($indexOfProspect, $x+8);
        }
        $indexOfProspectSummary = [];
        for($y=0; $y<sizeof($NewContentDataSummary); $y++){
            if(strpos($NewContentDataSummary[$y][1], 'X') == true)
                array_push($indexOfProspectSummary, $y+10);
        }

        $data = array($HeaderWorkingDay, $RegionCharge, $TopID, $TopMY, $TopTH, $TopVN,$Header);
        for($k = 0; $k < sizeof($NewContentData); $k++){
            array_push($data,$NewContentData[$k]);
        }

        $dataSummary = array($Header_1_Sum, $Header_2_Sum, $Header_3_Sum, $Header_4_Sum, $Header_5_Sum, $Header_6_Sum,$Header_7_Sum,$Header_8_Sum,$HeaderSummary);
        for($l = 0; $l < sizeof($NewContentDataSummary); $l++){
            array_push($dataSummary,$NewContentDataSummary[$l]);
        }
        return Excel::create('OWA Resource Allocation ', function($excel) use ($data,$Header,$indexOfProspect,$indexOfProspectSummary,$dataSummary,$HeaderSummary) {
            $excel->sheet('Asia', function($sheet) use ($data,$Header,$indexOfProspect) {
                $sheet->fromArray($data, null, 'A1', false, false);
                $sheet->cells('K1:'.$this->numToExcelAlpha(sizeof($Header)-6).'1', function($cells) {
                    $cells->setBackground('#C5EFF7');
                });
                $sheet->cells('A1:A2', function($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A5:A6', function($cells) {
                    $cells->setFontColor('#D50000');
                });
                $sheet->cells('A7:H7', function($cells) {
                    $cells->setBackground('#D3D3D3');
                });
                $sheet->cells('I7', function($cells) {
                    $cells->setBackground('#FCE4EC');
                });
                $sheet->cells('J7', function($cells) {
                    $cells->setBackground('#87D37C');
                });
                $sheet->cells('K7:'.$this->numToExcelAlpha(sizeof($Header)-5).'7', function($cells) {
                    $cells->setBackground('#D3D3D3');
                });
                $sheet->cells($this->numToExcelAlpha(sizeof($Header)-4).'7:'.$this->numToExcelAlpha(sizeof($Header)).'7', function($cells) {
                    $cells->setBackground('#E67E22');
                });
                for($N = 0; $N <sizeof($indexOfProspect); $N++) {
                    $sheet->cells('E'.$indexOfProspect[$N] , function($cells) {
                        $cells->setBackground('#87D37C');
                    });
                }
                $sheet->cells($this->numToExcelAlpha(sizeof($Header)-4).'8:'.$this->numToExcelAlpha(sizeof($Header)-4).sizeof($data), function($cells) {
                    $cells->setBackground('#FCE4EC');
                });
                $sheet->cells($this->numToExcelAlpha(sizeof($Header)-3).'8:'.$this->numToExcelAlpha(sizeof($Header)-3).sizeof($data), function($cells) {
                    $cells->setBackground('#FCE4EC');
                });
                $sheet->cells($this->numToExcelAlpha(sizeof($Header)-2).'8:'.$this->numToExcelAlpha(sizeof($Header)-2).sizeof($data), function($cells) {
                    $cells->setBackground('#FCE4EC');
                });
                $sheet->cells($this->numToExcelAlpha(sizeof($Header)-1).'8:'.$this->numToExcelAlpha(sizeof($Header)-1).sizeof($data), function($cells) {
                    $cells->setBackground('#FCE4EC');
                });
                $sheet->cells($this->numToExcelAlpha(sizeof($Header)).'8:'.$this->numToExcelAlpha(sizeof($Header)).sizeof($data), function($cells) {
                    $cells->setBackground('#FCE4EC');
                });
                $sheet->cells('G8:G'.sizeof($data), function($cells) {
                    $cells->setBackground('#EEEEEE');
                });
                $sheet->cells('J8:J'.sizeof($data), function($cells) {
                    $cells->setBackground('#EEEEEE');
                });
            });
            $excel->sheet('Summary', function($sheet) use ($dataSummary,$HeaderSummary,$indexOfProspectSummary) {
                $sheet->fromArray($dataSummary, null, 'A1', false, false);
                $sheet->cells('A7', function($cells) {
                    $cells->setBackground('#87D37C');
                });
                $sheet->cells('A1:A2', function($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A8', function($cells) {
                    $cells->setBackground('#FCE4EC');
                });
                $sheet->cells('I8', function($cells) {
                    $cells->setBackground('#E67E22');
                });
                $sheet->cells('A9:I9', function($cells) {
                    $cells->setBackground('#ECEFF1');
                });
                $sheet->cells('I1:I7', function($cells) {
                    $cells->setBackground('#4CAF50');
                });
                $sheet->cells('D9', function($cells) {
                    $cells->setFontColor('#D50000');
                });
                
                $sheet->cells('J1:'.$this->numToExcelAlpha(sizeof($HeaderSummary)).'1', function($cells) {
                    $cells->setBackground('#4CAF50');
                });

                $sheet->cells('J9:'.$this->numToExcelAlpha(sizeof($HeaderSummary)).'9', function($cells) {
                    $cells->setBackground('#E0E0E0');
                });

                $sheet->cells('J2:'.$this->numToExcelAlpha(sizeof($HeaderSummary)).'5', function($cells) {
                    $cells->setBackground('#ECEFF1');
                });

                $sheet->cells('J6:'.$this->numToExcelAlpha(sizeof($HeaderSummary)).'7', function($cells) {
                    $cells->setBackground('#87D37C');
                });

                $sheet->cells('J8:'.$this->numToExcelAlpha(sizeof($HeaderSummary)).'8', function($cells) {
                    $cells->setBackground('#FFE0B2');
                });
                
                $sheet->cells('D10:D'.sizeof($dataSummary), function($cells) {
                    $cells->setBackground('#FCE4EC');
                });

                for($M = 0; $M <sizeof($indexOfProspectSummary); $M++){
                    $sheet->cells('B'.$indexOfProspectSummary[$M] , function($cells) {
                        $cells->setBackground('#87D37C');
                    });
                }
            });
        })->download('xlsx');
    }

    public function ResourceDateTemplate(Request $request)
    {
        $DateData = $request->DateData;
        $returnHTML = view('table_resourceplanning', compact('DateData'))->render();
        return response()->json($returnHTML);
    }
    
}
