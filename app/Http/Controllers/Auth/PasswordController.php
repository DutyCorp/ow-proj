<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Crypt;

class PasswordController extends Controller
{
    public function ResetPassword(Request $request){
        $EncryptedEmployeeID = $request->EmployeeID;
        $Password = $request->Password;

        $EmployeeID = Crypt::decrypt($EncryptedEmployeeID);
        $encryptedpassword = Crypt::encrypt($Password);

        DB::select('call SP_ResetPassword("'.$encryptedpassword.'", "'.$EmployeeID.'")');

        return response()->json(1);
    }

    public function ChangePassword(Request $request){
        $OldPassword = $request->OldPassword;
        $NewPassword = $request->NewPassword;

        $newdata = DB::select('call SP_GetPassword("'.session()->get('Username').'")');
        $decryptedpassword = Crypt::decrypt($newdata[0]->Password);
        if ($decryptedpassword != $OldPassword){
            return response()->json('Old Password is invalid');
        }
        $encryptedpassword = Crypt::encrypt($NewPassword);

        DB::select('call SP_ResetPassword("'.$encryptedpassword.'", "'.session()->get('EmployeeID').'")');

        return response()->json('Success');
    }
}
