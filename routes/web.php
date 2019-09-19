<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Use App\AttendanceData;
Use App\Permission;
Use App\PermissionAttendance;
Use App\Department;
Use App\Region;
Use App\Role;
Use App\Position;
Use App\AssetClass;
Use App\User;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\ImageManagerStatic as Image;

Route::get('/', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC00")');
    $OparDate = DB::select('call SP_GetOparLatest');
    $modulemenus = DB::select('call SP_GetRoleMenuByMenuParentID("'.session()->get('RoleID').'", "MP01")');
    return view('welcome', compact('rolemenus', 'OparDate', 'modulemenus'));
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/profile', function () {
    $EmployeeData = DB::select('call SP_SelectEditEmployee("'.session()->get('EmployeeID').'")');
    return view('profile', compact('EmployeeData'));
});

Route::get('/attendance', function() {
    $regions = DB::select('call SP_All_Region');
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC01")');
    return view('attendancelist', compact('regions', 'rolemenus'));
});

Route::get('/attendance/permission/entry', function() {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC03")');
    $ListPermissionType = DB::select('call SP_All_PermissionType');
    $ListEmployee = DB::select('call SP_All_Employee("'.session()->get('EmployeeID').'")');
    return view('permissionattendance', compact('ListPermissionType', 'ListEmployee', 'rolemenus'));
});

Route::get('/attendance/permission/history', function() {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC19")');
    return view('permissionattendance_history', compact('rolemenus'));
});

Route::get('/attendance/permission/approval', function () {
    return view('permissionattendance_approval');
});

Route::get('/attendance/report', function() {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC02")');
    $regions = DB::select('call SP_All_Region');
	return view('attendancereport', compact('regions', 'rolemenus'));
});

Route::get('/asset', function() {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC04")');
    $ListAssetClass = DB::select('call SP_All_AssetClass');
    $ListAssetType = DB::select('call SP_All_Assettype');
    $ListRegion = DB::select('call SP_All_Region');
    $ListEmployee = DB::select('call SP_All_Employee("'.session()->get('EmployeeID').'")');
    return view('asset', compact('ListAssetClass', 'ListAssetType', 'ListRegion', 'ListEmployee', 'rolemenus'));
});

Route::get('/asset/history', function() {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC05")');
    $HistoryAssetNumber = Input::get('assetnumber');
    $ListAssetHistory = DB::select('call SP_All_AssetHistory("'.$HistoryAssetNumber.'", "'.session()->get('EmployeeID').'")');
    return view('table_assethistory', compact('ListAssetHistory', 'rolemenus'));
});

Route::get('/employee/setting/{encryptedemployeeid}', function ($encryptedemployeeid) {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC07")');
	$employeeid = Crypt::decrypt($encryptedemployeeid);
    $users = DB::select('call SP_GetEmployeeData("'.$employeeid.'")');
	$roles = DB::select('call SP_All_Role');
	$positions = DB::select('call SP_All_Position');
	$departments = DB::select('call SP_All_Department');
    $menus = DB::select('call SP_GetMenuList');
    $regions = DB::select('call SP_All_Region');
    $grades = DB::select('call SP_SelectGrade');
    return view('employeesetting', compact('departmentids', 'positionids', 'roles', 'departments', 'roleids', 'users', 'positions', 'regions', 'grades', 'menus', 'rolemenus'));
});

Route::get('/employee/list', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC07")');
    $ListEmployee = DB::select('call SP_EmployeeList("'.session()->get('EmployeeID').'")');
    return view('table_employee', compact('ListEmployee', 'rolemenus'));
});

Route::get('/employee/entry', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC08")');
    $EditEmployeeID = Input::get('employeeID');
    $ListDepartment = DB::select('call SP_All_Department');
    $ListRegion = DB::select('call SP_All_Region');
    $ListRole = DB::select('call SP_All_Role');
    $ListPosition = DB::select('call SP_All_Position');
    $ListGrade = DB::select('call SP_SelectGrade');
    return view('entryemployee', compact('ListDepartment','ListRegion','ListRole','ListPosition','ListGrade', 'rolemenus'));
});

Route::get('/role', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC09")');
	$menus = DB::select('call SP_GetMenuList');
    $rawroles = DB::select('call SP_GetLatestRoleID');
	$rolesplit = explode("R", $rawroles[0]->RoleID);
	$rolenumber = sprintf('%02d', $rolesplit[1]+1);
    $grades = DB::select('call SP_SelectGrade');

	$roleid = 'R'.$rolenumber;

	$regions = DB::select('call SP_All_Region');

    return view('role', compact('menus', 'roleid', 'regions', 'grades', 'rolemenus'));
});

Route::get('/employee/FTE', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC12")');
    return view('FTE_Employee', compact('rolemenus'));
});

Route::get('/OWNavbar', function() {
    $photos = DB::select('call SP_GetEmployeePhoto("'.session()->get('EmployeeID').'")');
    $menuparents = DB::select('call SP_GetMenuParentData("'.session()->get('RoleID').'")');
    $menuchilds = DB::select('call SP_GetMenuChildData("'.session()->get('RoleID').'")');
    $submenus = DB::select('call SP_GetSubMenuData("'.session()->get('RoleID').'")');
    return view('library.navbar', compact('menuparents', 'menuchilds', 'photos', 'submenus'));
});

Route::get('/OWFooter', function() {
    $ListRegionData = DB::select('call SP_All_Region');
    return view('library.footer', compact('ListRegionData'));
});

Route::get('/project/timesheet', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC10")');
    $ListRegion = DB::select('call SP_All_Region');
    $ListTimesheet = DB::select('call SP_ShowTableTimesheet');
    return view('timesheet_completion', compact('ListRegion','ListTimesheet', 'rolemenus'));
});

Route::get('/employee/utilization', function () {
    ///$ListRegion = DB::select('call SP_All_Region');
    return view('utilization', compact('ListRegion'));
});

Route::get('/attendance/overtime', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC17")');
    $ListOTType = DB::select('call SP_All_OvertimeType');
    $ListEmployee = DB::select('call SP_All_Employee("'.session()->get('EmployeeID').'")');
    $ListCoordinator = DB::select('call SP_ShowAllEmployee');
    return view('overtime', compact('ListEmployee','ListOTType','ListOvertime', 'rolemenus', 'ListCoordinator'));
});

Route::get('/attendance/approval_overtime', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC18")');
    return view('overtime_approval', compact('rolemenus'));
});

Route::get('/attendance/overtime_history', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC19")');
    return view('overtime_history', compact('rolemenus'));
});

Route::get('/project/uploaddb', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC13")');
    $OparDate = DB::select('call SP_GetOparLatest');
    $ProfitabillityDate = DB::select('call SP_GetProfitabillityLatest');
    $TimesheetDate = DB::select('call SP_GetTimesheetYearlyLatest');
    $ProjectDate = DB::select('call SP_GetProjectLatest');
    return view('uploaddb', compact('rolemenus','OparDate','ProfitabillityDate','TimesheetDate','ProjectDate'));
});

Route::get('/project/salescontract', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC14")');
    $ListRegion = DB::select('call SP_GetProjectRegion');
    $ListProjectStatus = DB::select('call SP_All_ProjectStatus');
    $ListContractStatus = DB::select('call SP_All_ContractStatus');
    $CustomerName = DB::select('call SP_All_SalesContract_CustomerName');
    return view('salescontract', compact('ListRegion', 'rolemenus', 'ListProjectStatus', 'ListContractStatus', 'CustomerName'));
});

Route::get('/project/progress/summary', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC23")');
    $ListProjectStatus = DB::select('call SP_All_ProjectStatus');
    $ListContractStatus = DB::select('call SP_All_ContractStatus');
    $ListPositionType = DB::select('call SP_All_PositionType');
    $ListRegion = DB::select('call SP_GetProjectRegion');
    return view('projectprogresssummary', compact('ListRegion', 'ListContractStatus', 'ListProjectStatus', 'ListPositionType', 'rolemenus'));
});

Route::get('/project/progress/detail', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC24")');
    $ListProjectStatus = DB::select('call SP_All_ProjectStatus');
    $ListContractStatus = DB::select('call SP_All_ContractStatus');
    $ListPositionType = DB::select('call SP_All_PositionType');
    $ListRegion = DB::select('call SP_GetProjectRegion');
    return view('projectprogressdetail', compact('ListRegion', 'ListContractStatus', 'ListProjectStatus', 'ListPositionType', 'rolemenus'));
});

Route::get('/project/occupation/report', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC15")');
    $ListRegion = DB::select('call SP_All_Region');
    return view('occupation_report', compact('ListRegion', 'rolemenus'));
});

Route::get('/project/occupation/statistics', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC20")');
    $ListRegion = DB::select('call SP_All_Region');
    $ListEmployee = DB::select('call SP_ShowAllEmployee');
    return view('occupation_statistic', compact('ListRegion','ListEmployee', 'rolemenus'));
});

Route::get('/operation/resourceallocation/settings', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC32")');
    $ListRegion = DB::select('call SP_All_Region');
    return view('resourceallocation', compact('ListRegion', 'rolemenus'));
});

Route::get('/project/profitability/summary', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC21")');
    $ListRegion = DB::select('call SP_GetProjectRegion');
    $ListContractStatus = DB::select('call SP_All_ContractStatus');
    $Query = DB::select('call SP_All_MDCost');
    $MDCost = $Query[0]->MDCost;
    return view('profitabillitysummary', compact('ListRegion','ListContractStatus', 'MDCost'));
});

Route::get('/project/profitability/detail', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC22")');
    $ListRegion = DB::select('call SP_GetProjectRegion');
    $ListContractStatus = DB::select('call SP_All_ContractStatus');
    $Query = DB::select('call SP_All_MDCost');
    $MDCost = $Query[0]->MDCost;
    return view('profitabillitydetail', compact('ListRegion','ListContractStatus', 'MDCost'));});

Route::get('/project/openinvoice', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC20")');
    $ListRegion = DB::select('call SP_All_Region');
    $CustomerName = DB::select('call SP_All_OpenInvoice_CustomerName');
    return view('openinvoice', compact('ListRegion','rolemenus','CustomerName'));
});

Route::get('/attendance/leavereport', function () {
    $TimesheetDate = DB::select('call SP_GetTimesheetYearlyLatest');
    $ListRegion = DB::select('call SP_GetProjectRegion');
    return view('leavereport', compact('ListRegion','TimesheetDate'));
});

Route::get('/resetpassword/{encryptedemployeeid}/{encryptedtime}', function ($encryptedemployeeid, $encryptedtime) {
    $EmployeeID = Crypt::decrypt($encryptedemployeeid);
    $Time = new DateTime(Crypt::decrypt($encryptedtime));
    $User = DB::select('call SP_GetEmployeeData("'.$EmployeeID.'")');
    $LinkExpired = 0;
    $EmployeeName = $User[0]->Username;

    $CurrentTime = new DateTime(date('Y-m-d H:i:s'));
    $Diff = $Time->diff($CurrentTime);
    $M = $Diff->format('%I'); $H = $Diff->format('%H'); $D = $Diff->format('%D');

    if ($M >= 30) {
        $LinkExpired = 1;
    } else {
        if ($H > 0){
            $LinkExpired = 1;
        } else {
            if ($D > 0){
                $LinkExpired = 1;
            }
        }
    }
    
    return view('resetpassword', compact('EmployeeID','Time', 'LinkExpired', 'encryptedemployeeid', 'EmployeeName'));
});

Route::get('/project/master', function () {
    $ListRegion = DB::select('call SP_All_Region');
    $ListProjectType = DB::select('call SP_All_ProjectType');
    $ListProject = DB::select('call SP_All_Project');
    $ListBusinessArea = DB::select('call SP_All_BusinessArea');

    return view('masterproject', compact('ListRegion','ListProjectType','ListProject','ListBusinessArea'));
});

Route::get('/project/claimreport', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC27")');
    $ListRegion = DB::select('call SP_GetRegionClaim');
    return view('claimreport', compact('ListRegion','rolemenus'));
});

Route::get('/project/personalclaimreport', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC28")');
    $ListEmployee = DB::select('call SP_GetEmployeePersonalClaim');
    if (session()->get('Username') == 'admin'){
        $Status = 1;
    } else {
        $Status = 0;
    }
    return view('personalclaim', compact('ListEmployee','rolemenus', 'Status'));
});

Route::get('/operation/documentregistration', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC29")');
    $DocumentLatestDate = DB::select('call SP_GetDocumentLatest');
    $ListRegion = DB::select('call SP_All_Region');
    $ListDocumentType = DB::select('call SP_All_DocumentType');
    $ListOwner = DB::select('call SP_ShowAllEmployee');
    return view('documentregistration', compact('ListRegion','ListDocumentType','ListOwner','DocumentLatestDate', 'rolemenus'));
});

Route::get('/employee/supervisorygroup', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC30")');
    $ListRegion = DB::select('call SP_All_Region');
    $ListPMO = DB::select('call SP_All_PMO');
    $ListDM = DB::select('call SP_All_DeliveryManager');
    $ListSubordinates = DB::select('call SP_All_DeliveryEmployee');
    
    return view('supervisorygroup', compact('ListRegion','ListPMO','ListDM','ListSubordinates', 'rolemenus'));
});

Route::get('project/timesheetapproval', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC31")');
    $ListEmployee = DB::select('call SP_ShowAllEmployee');
    return view('timesheetapproval', compact('rolemenus', 'ListEmployee'));
});

Route::get('/operation/regionsetting', function () {
    $ListRegions = DB::select('call SP_All_Region');
    $ListGRM = DB::select('call SP_All_GroupManager');
    $ListPMO = DB::select('call SP_All_PMO');
    $ListBA = DB::select('call SP_All_BusinessArea');

    return view('regionsetting', compact('ListRegions','ListGRM','ListPMO','ListDM','ListBA'));
});

Route::get('/operation/emailblast', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC20")');
    $ListEmployee = DB::select('call SP_ShowAllEmployee');
    $ListRegion = DB::select('call SP_All_Region');
    return view('emailblast', compact('rolemenus', 'ListEmployee', 'ListRegion'));
});

Route::get('/operation/resourceallocation/planning', function () {
    $rolemenus = DB::select('call SP_GetRoleMenuByID("'.session()->get('RoleID').'", "MC33")');
    return view('resourceplanning', compact('rolemenus'));
});

Route::get('/a/{encryptedfilename}', function($encryptedfilename){
    $decryptedfilename = Crypt::decrypt($encryptedfilename);
    $splittedfile = explode(".", $decryptedfilename);
    $fileextension = $splittedfile[1];
    $filepath = '/img/'.$decryptedfilename;

    return Image::make(public_path().$filepath)->response($fileextension);
});

Route::get('/f/{encryptedfilename}', function($encryptedfilename){
    $decryptedfilename = Crypt::decrypt($encryptedfilename);
    $splittedfile = explode(".", $decryptedfilename);
    $fileextension = $splittedfile[1];
    $filepath = '/uploads/'.$decryptedfilename;
    
    return Image::make(public_path().$filepath)->response($fileextension);
});

Route::get('/changepassword', function () {
    return view('changepassword');
});

Route::any('PermissionDelete', 'PermissionController@DeletePermissionData');
Route::any('PermissionUpdate', 'PermissionController@UpdatePermissionData');
Route::any('PermissionEdit', 'PermissionController@showPermissionData');
Route::any('PermissionAttendance', 'PermissionController@doEntryPermission');
Route::any('PermissionCheckID', 'PermissionController@CheckPermissionID');
Route::any('RefreshTablePermission', 'PermissionController@doRefreshTablePermission');
Route::any('RefreshTablePT', 'PermissionController@RefreshTablePT');
Route::any('CheckPermissionTypeID', 'PermissionController@CheckPermissionTypeID');
Route::any('EntryPermissionType', 'PermissionController@EntryPermissionType');
Route::any('DeletePermissionType', 'PermissionController@DeletePermissionType');
Route::any('EditPermissionType', 'PermissionController@EditPermissionType');
Route::any('UpdatePermissionType', 'PermissionController@UpdatePermissionType');
Route::any('GetAllPT', 'PermissionController@GetAllPT');
Route::any('refreshTableApprovalPermission', 'PermissionController@refreshTableApprovalPermission');
Route::any('ApprovalPermission', 'PermissionController@ApprovalPermission');

Route::any('EntryNewEmployee', 'EmployeeController@doEntryNewEmployee');

Route::any('DepartmentEdit', 'EmployeeController@showDepartmentData');
Route::any('DepartmentDelete', 'EmployeeController@DeleteDepartmentData');
Route::any('DepartmentUpdate', 'EmployeeController@UpdateDepartmentData');
Route::any('DepartmentCheckID', 'EmployeeController@DepartmentCheckID');
Route::any('EntryDepartment', 'EmployeeController@EntryDepartment');
Route::any('refreshTableDepartment', 'EmployeeController@refreshTableDepartment');
Route::any('refreshDropdownDepartment', 'EmployeeController@refreshDropdownDepartment');

Route::any('PositionEdit', 'EmployeeController@showPositionData');
Route::any('PositionUpdate', 'EmployeeController@UpdatePositionData');
Route::any('PositionDelete', 'EmployeeController@DeletePositionData');
Route::any('PositionCheckID', 'EmployeeController@CheckPositionID');
Route::any('Position', 'EmployeeController@doEntryPosition');
Route::any('refreshTablePosition', 'EmployeeController@refreshTablePosition');
Route::any('refreshDropdownPosition', 'EmployeeController@refreshDropdownPosition');

Route::any('EntryRegion', 'EmployeeController@EntryRegion');
Route::any('refreshTableRegion', 'EmployeeController@refreshTableRegion');
Route::any('RegionDelete', 'EmployeeController@DeleteRegionData');
/*Route::any('RegionEdit', 'EmployeeController@showRegionData');*/
Route::any('CheckRegionID', 'EmployeeController@CheckRegionID');
Route::any('RegionUpdate', 'EmployeeController@UpdateRegionData');
Route::any('refreshDropdownRegion', 'EmployeeController@refreshDropdownRegion');

Route::any('refreshTableGrade', 'EmployeeController@refreshTableGrade');
Route::any('GradeCheckID', 'EmployeeController@GradeCheckID');
Route::any('EntryGrade', 'EmployeeController@EntryGrade');
Route::any('GradeEdit', 'EmployeeController@showGradeData');
Route::any('GradeDelete', 'EmployeeController@DeleteGradeData');
Route::any('refreshDropdownGrade', 'EmployeeController@refreshDropdownGrade');
Route::any('GradeUpdate', 'EmployeeController@UpdateGradeData');

Route::any('refreshTableEmployee', 'EmployeeController@refreshTableEmployee');

Route::any('CheckAssetNumber', 'AssetController@getAssetCount');
Route::any('EntryNewAsset', 'AssetController@doEntryNewAsset');
Route::any('AssetDelete', 'AssetController@DeleteAssetData');
Route::any('refreshTableAsset', 'AssetController@refreshTableAsset');
Route::any('AssetEdit', 'AssetController@showAssetData');
Route::any('AssetUpdate', 'AssetController@UpdateAssetData');

Route::post('importAttendanceData', 'ExcelController@importAttendanceData');
Route::post('GetRoleAccess', 'EmployeeController@GetRoleAccess');
Route::post('SubmitEmployeeUpdate', 'EmployeeController@SubmitEmployeeUpdate');

Route::post('SubmitRole', 'RoleController@SubmitRole');
Route::post('GetRoleData', 'RoleController@GetRoleData');
Route::post('UpdateRole', 'RoleController@UpdateRole');
Route::post('GetNewRole', 'RoleController@GetNewRole');
Route::post('DeleteRole', 'RoleController@DeleteRole');
Route::post('RefreshRoleList', 'RoleController@RefreshRoleList');

Route::post('CheckUsername', 'Auth\LoginController@CheckUsername');
Route::post('UserLogin', 'Auth\LoginController@UserLogin');
Route::post('ForgotPassword', 'Auth\LoginController@ForgotPassword');

Route::post('Logout', 'Auth\LogoutController@Logout');

Route::post('UploadAttendanceData', 'AttendanceController@UploadAttendanceData');
Route::post('ReplaceDuplicateData', 'AttendanceController@ReplaceDuplicateData');
Route::post('getAttendanceData', 'AttendanceController@getAttendanceData');

Route::get('dl/{encryptedfilename}', 'DownloadController@downloadFile');
Route::get('downloadExcel/{Region}', 'DownloadController@downloadExcelRegion');
Route::get('downloadExcel/{DateFrom}/{DateTo}', 'DownloadController@downloadExcelDate');
Route::get('downloadExcel/{Region}/{DateFrom}/{DateTo}', 'DownloadController@downloadExcelFilter');

Route::any('EmployeeDelete', 'EmployeeController@DeleteEmployeeData');

Route::any('SubmitEditEmployeeData', 'EmployeeController@EditEmployeeData');

Route::post('getAttendanceReportColumnChart', 'AttendanceController@getAttendanceReportColumnChart');
Route::post('getAttendanceReportPieChart', 'AttendanceController@getAttendanceReportPieChart');
Route::post('getEmployeeAttendanceReport', 'AttendanceController@getEmployeeAttendanceReport');

Route::post('UploadTimeSheetData', 'TimesheetController@UploadTimeSheetData');
Route::post('UpdateTWH', 'TimesheetController@UpdateTWH');
Route::post('ShowTableTimesheet', 'TimesheetController@ShowTableTimesheet');
Route::post('refreshDropdownTC', 'TimesheetController@refreshDropdownTC');

Route::any('refreshTableAssetType', 'AssetController@refreshTableAssetType');
Route::any('AssetTypeCheckID', 'AssetController@AssetTypeCheckID');
Route::any('AddAssetTypeID', 'AssetController@AddAssetTypeID');
Route::any('AssetTypeDelete', 'AssetController@AssetTypeDelete');
Route::any('AssetTypeEdit', 'AssetController@AssetTypeEdit');

Route::any('AssetTypeUpdate', 'AssetController@AssetTypeUpdate');
Route::any('refreshDropdownAssetType', 'AssetController@refreshDropdownAssetType');

Route::post('GetFTEData', 'FTEController@GetFTEData');
Route::post('GenerateFTE', 'FTEController@GenerateFTE');
Route::post('SaveAllFTE', 'FTEController@SaveAllFTE');

Route::any('EntryOvertime', 'OvertimeController@EntryOvertime');
Route::any('refreshTableOvertime', 'OvertimeController@refreshTableOvertime');
Route::any('DeleteOverTime', 'OvertimeController@DeleteOverTime');
Route::any('EditOverTime', 'OvertimeController@EditOverTime');
Route::any('UpdateOvertime', 'OvertimeController@UpdateOvertime');
Route::any('ApprovalOvertime', 'OvertimeController@ApprovalOvertime');
Route::any('refreshTableApprovalOvertime', 'OvertimeController@refreshTableApprovalOvertime');
Route::any('refreshTableHistoryOvertime', 'OvertimeController@refreshTableHistoryOvertime');
Route::any('FilterDateHistoryOvertime', 'OvertimeController@FilterDateHistoryOvertime');
Route::any('GetEmployeeName', 'OvertimeController@GetEmployeeName');
Route::any('CheckOvertimeID', 'OvertimeController@CheckOvertimeID');

Route::any('refreshTablePermissionAttendanceHistory', 'PermissionController@refreshTablePermissionAttendanceHistory');

Route::any('UploadOparData', 'UploadDBController@UploadOparData');
Route::any('UploadProjectData', 'UploadDBController@UploadProjectData');
Route::any('UploadClaimData', 'UploadDBController@UploadClaimData');
Route::any('UploadTSData', 'UploadDBController@UploadTSData');
Route::any('UploadProfitabilityData', 'UploadDBController@UploadProfitabilityData');
Route::any('UploadInvoiceData', 'UploadDBController@UploadInvoiceData');

Route::any('FilterSalesContract', 'SalesContractController@FilterSalesContract');
Route::any('DetailGraphSC', 'SalesContractController@DetailGraphSC');
Route::any('SummaryGraphSC', 'SalesContractController@SummaryGraphSC');
Route::any('RegionGraphSC', 'SalesContractController@RegionGraphSC');
Route::any('CDGraphSC', 'SalesContractController@CDGraphSC');
Route::any('CSGraphSC', 'SalesContractController@CSGraphSC');
Route::any('refreshTableSalesContract', 'SalesContractController@refreshTableSalesContract');

Route::any('FilterProjectProgress', 'ProjectController@FilterProjectProgress');
Route::any('refreshTableProjectProgress', 'ProjectController@refreshTableProjectProgress');
Route::any('refreshTableProjectProgressDetail', 'ProjectController@refreshTableProjectProgressDetail');

Route::any('FilterTableOccupation', 'OccupationReportController@FilterTableOccupation');

Route::any('FilterTableOccupation', 'OccupationController@FilterTableOccupation');

Route::any('ShowColumnChart', 'OccupationController@ShowColumnChart');
Route::any('ShowEmployee', 'OccupationController@ShowEmployee');

Route::any('FilterTableProfitabillity', 'ProfitabillityController@FilterTableProfitabillity');

Route::any('FilterLeaveReport', 'LeaveController@FilterLeaveReport');

Route::post('GetOpenInvoiceData', 'InvoiceController@GetOpenInvoiceData');
Route::post('DetailGraphIP', 'InvoiceController@DetailGraphIP');
Route::post('SummaryGraphIP', 'InvoiceController@SummaryGraphIP');
Route::post('RegionGraphIP', 'InvoiceController@RegionGraphIP');
Route::post('CSGraphIP', 'InvoiceController@CSGraphIP');
Route::post('CDGraphIP', 'InvoiceController@CDGraphIP');

Route::post('SendForgotPassword', 'MailController@SendForgotPassword');

Route::post('ResetPassword', 'Auth\PasswordController@ResetPassword');
Route::post('ChangePassword', 'Auth\PasswordController@ChangePassword');

Route::any('EntryProject', 'ProjectController@EntryProject');
Route::any('refreshTableProject', 'ProjectController@refreshTableProject');
Route::any('CheckProjectType', 'ProjectController@CheckProjectType');
Route::any('refreshProjectType', 'ProjectController@refreshProjectType');
Route::any('DeleteProject', 'ProjectController@DeleteProject');
Route::any('EditProject', 'ProjectController@EditProject');
Route::any('UpdateProject', 'ProjectController@UpdateProject');
Route::any('EntryBusinessArea', 'ProjectController@EntryBusinessArea');
Route::any('refreshTableBusinessArea', 'ProjectController@refreshTableBusinessArea');
Route::any('BADelete', 'ProjectController@BADelete');
Route::any('BAEdit', 'ProjectController@BAEdit');
Route::any('BAUpdate', 'ProjectController@BAUpdate');
Route::any('refreshDropdownBA', 'ProjectController@refreshDropdownBA');

Route::post('GetClaimReportData', 'ClaimReportController@GetClaimReportData');
Route::post('GetPersonalClaimReportData', 'ClaimReportController@GetPersonalClaimReportData');

Route::any('refreshTableDocumentType', 'DocumentRegistrationController@refreshTableDocumentType');
Route::any('CheckDocumentTypeName', 'DocumentRegistrationController@CheckDocumentTypeName');
Route::any('DeleteDocumentType', 'DocumentRegistrationController@DeleteDocumentType');
Route::any('EditDocumentType', 'DocumentRegistrationController@EditDocumentType');
Route::any('UpdateDocumentType', 'DocumentRegistrationController@UpdateDocumentType');
Route::any('EntryDocument', 'DocumentRegistrationController@EntryDocument');
Route::any('refreshTableDocument', 'DocumentRegistrationController@refreshTableDocument');
Route::any('DeleteDocument', 'DocumentRegistrationController@DeleteDocument');
Route::any('EditDocument', 'DocumentRegistrationController@EditDocument');
Route::any('UpdateDocument', 'DocumentRegistrationController@UpdateDocument');
Route::any('refreshDropdownDocumentType', 'DocumentRegistrationController@refreshDropdownDocumentType');
Route::any('FilterDocumentByDropdown', 'DocumentRegistrationController@FilterDocumentByDropdown');

Route::any('refreshTableSG', 'SupervisoryGroupController@refreshTableSG');
Route::any('AddSubordinates', 'SupervisoryGroupController@AddSubordinates');
Route::any('DeleteSubordinates', 'SupervisoryGroupController@DeleteSubordinates');
Route::any('SetSubordinates', 'SupervisoryGroupController@SetSubordinates');
Route::any('GetTeamLeadRegion', 'SupervisoryGroupController@GetTeamLeadRegion');

Route::any('GetDeliveryList', 'SupervisoryGroupController@GetDeliveryList');

Route::post('sendTimesheetApproval', 'TimesheetController@sendTimesheetApproval');
Route::post('sendTimesheetApprovalEmail', 'TimesheetController@sendTimesheetApprovalEmail');

Route::any('refreshTableGS', 'RegionSettingController@refreshTableGS');
Route::any('EditRegion', 'RegionSettingController@EditRegion');
Route::any('UpdateRegion', 'RegionSettingController@UpdateRegion');
Route::any('GetProjectLeadList', 'RegionSettingController@GetProjectLeadList');
Route::any('AddProjectLead', 'RegionSettingController@AddProjectLead');
Route::any('DeleteProjectLead', 'RegionSettingController@DeleteProjectLead');
Route::any('CheckProjectLead', 'RegionSettingController@CheckProjectLead');
Route::any('GetListProjectLeadByRegion', 'RegionSettingController@GetListProjectLeadByRegion');
Route::any('CheckTargetData', 'RegionSettingController@CheckTargetData');
Route::any('SaveTarget', 'RegionSettingController@SaveTarget');
Route::any('SetMDCost', 'RegionSettingController@SetMDCost');
Route::any('RefreshMDCost', 'RegionSettingController@RefreshMDCost');

Route::post('GetEmployeeData', 'EmployeeController@GetEmployeeData');
Route::post('SendEmailBlast', 'MailController@SendEmailBlast');

Route::any('EntryProspectProject', 'ResourceAllocationController@EntryProspectProject');
Route::any('refreshTableProspectProject', 'ResourceAllocationController@refreshTableProspectProject');
Route::any('EntryResourceAllocation', 'ResourceAllocationController@EntryResourceAllocation');
Route::post('InsertNewEmployee', 'ResourceAllocationController@InsertNewEmployee');
Route::post('refreshTableNewEmployee', 'ResourceAllocationController@refreshTableNewEmployee');
Route::post('SaveWorkingDay', 'ResourceAllocationController@SaveWorkingDay');
Route::post('CheckWorkingDay', 'ResourceAllocationController@CheckWorkingDay');
Route::post('InsertProspectProject', 'ResourceAllocationController@InsertProspectProject');
Route::post('refreshTableProspectProject', 'ResourceAllocationController@refreshTableProspectProject');
Route::post('InsertProspectProjectContributing', 'ResourceAllocationController@InsertProspectProjectContributing');
Route::post('DeleteContributing', 'ResourceAllocationController@DeleteContributing');
Route::post('InsertNewEmployeeContributing', 'ResourceAllocationController@InsertNewEmployeeContributing');
Route::post('DeleteNEContributing', 'ResourceAllocationController@DeleteNEContributing');
Route::post('CheckNewEmployee', 'ResourceAllocationController@CheckNewEmployee');
Route::post('CheckProspectProject', 'ResourceAllocationController@CheckProspectProject');
Route::post('RefreshNewEmployee', 'ResourceAllocationController@RefreshNewEmployee');
Route::post('DeleteNE', 'ResourceAllocationController@DeleteNE');
Route::post('EditNE', 'ResourceAllocationController@EditNE');
Route::post('UpdateNE', 'ResourceAllocationController@UpdateNE');
Route::post('RefreshProspectProject', 'ResourceAllocationController@RefreshProspectProject');
Route::post('DeletePP', 'ResourceAllocationController@DeletePP');
Route::post('EditPP', 'ResourceAllocationController@EditPP');
Route::post('UpdatePP', 'ResourceAllocationController@UpdatePP');

Route::any('ResourceDateTemplate', 'ResourcePlanningController@ResourceDateTemplate');
Route::get('DownloadTemplateRP/{DateData}/{IDWD}/{MYWD}/{THWD}/{VNWD}/{DateFrom}/{DateTo}', 'ResourcePlanningController@DownloadTemplateRP');
Route::any('UploadResourcePlanning', 'ResourcePlanningController@UploadResourcePlanning');
Route::any('BVATemplate', 'ResourcePlanningController@DownloadBVA');

Route::any('getTimestamp', 'DashboardController@getTimestamp');
Route::any('getAttendanceReportData', 'DashboardController@getAttendanceReportData');
Route::any('getModule', 'DashboardController@getModule');