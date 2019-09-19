<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use DB;

class LoginController extends Controller
{
    public function CheckUsername(Request $request){
        $Username = $request->Username;
        $UserArray = "";

        $UA = DB::select('call SP_GetEmployeeIdentity("'.$Username.'")');
        
        if (sizeof($UA) == 0){
            return response()->json('Username not found');
        }

        $EmployeeName = $UA[0]->EmployeeName;

        if ($UA[0]->Photo == ""){
            $ImageName = "Face_Blue_128.png";
            $UserArray = array('/a/'.Crypt::encrypt($ImageName), $EmployeeName);
        } else {
            $ImageName = $UA[0]->Photo;
            $UserArray = array('/f/'.Crypt::encrypt($ImageName), $EmployeeName);
        }

        return response()->json($UserArray);
    }

    public function UserLogin(Request $request){
        $Username = $request->Username;
        $Password = $request->Password;

        $newdata = DB::select('call SP_GetPassword("'.$Username.'")');

        if (sizeof($newdata) == 0){
           return response()->json(0); 
        }
        
        $decrypted = Crypt::decrypt($newdata[0]->Password);

        if ($Password == $decrypted){
            $User = DB::select('call SP_GetEmployeeIdentity("'.$Username.'")');
            $EmployeeID = $User[0]->EmployeeID;
            $RoleID = $User[0]->RoleID;
            $EmployeeName = $User[0]->EmployeeName;
            if ($User[0]->Photo == ""){
                $Photo = "Face_Blue_128.png";
                session()->put('Photo', '/a/'.Crypt::encrypt($Photo));
            } else {
                $Photo = $User[0]->Photo;
                session()->put('Photo', '/f/'.Crypt::encrypt($Photo));
            }
            
            session()->put('Username', $Username);
            session()->put('EmployeeID', $EmployeeID);
            session()->put('RoleID', $RoleID);
            session()->put('EmployeeName', $EmployeeName);
            session()->put('OWLogo', '/a/'.Crypt::encrypt('OWLogo.png'));
            return response()->json(1);
        }
        else {
            return response()->json(0); 
        }
    }

    /*public function ForgotPassword(Request $request){
        $Email = $request->Email;

        $count = DB::table('user')->where('Email', '=', $Email)->count();
        return response()->json($count);
    }*/
}
