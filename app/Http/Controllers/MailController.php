<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Crypt;

class MailController extends Controller
{
    public function SendForgotPassword(Request $request){
    	$Email = $request->Email;
    	$this->Email = $Email;

    	$count = DB::table('user')->where('Email', '=', $Email)->count();
        
    	if ($count == 0) {
    		return response()->json($count);
    	} else {
    		$name = DB::table('user')->select('EmployeeName', 'EmployeeID')->where('Email', '=', $Email)->get();
    		$this->name = $name[0]->EmployeeName;
    		$EmployeeID = $name[0]->EmployeeID;
    		$date = date('Y-m-d H:i:s');
    		$url = '/resetpassword/'.Crypt::encrypt($EmployeeID).'/'.Crypt::encrypt($date).'';
            $data = array('name'=> $name[0]->EmployeeName, 'url' => $url, 'email' => $Email);

		    Mail::send('forgotpasswordemail', $data, function($message) {
		        $message->to($this->Email, $this->name)->subject('Forgot Password!');
		        $message->from('owasiaonline@gmail.com','Account Management Team');
		    });
	    	return response()->json($count);
    	}
    }

    public function SendTestEmail(){
        $data = [];
        $data[] = '1';
        Mail::send('testemail', $data, function($message) {
            $message->to('blankpoint88@gmail.com', 'Andika Rahman Hakim')->subject('Test Email');
            $message->from('aizawainori@gmail.com','Inori Aizawa');
        });
        return response()->json(1);
    }

    function generateRandomString($length) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

    public function SendEmailBlast(Request $request){
        $ListEmployeeIDTo = explode(',', $request->ListEmployeeIDTo);
        $ListEmployeeIDCc = explode(',', $request->ListEmployeeIDCc);
        $TotalFile = $request->TotalFile;
        $BodyEmail = $request->BodyEmail;
        $Subject = $request->Subject;

        for ($i = 0; $i < $TotalFile; $i++){
            ${'File'.$i} = $request->{'File'.$i};
            $this->{'File'.$i} = ${'File'.$i};
            $this->{'FileName'.$i} = ${'File'.$i}->getClientOriginalName();
        }

        $ListEmployeeToData = [];
        $ListEmployeeCcEmail = [];

        for ($i = 0; $i < sizeof($ListEmployeeIDTo); $i++){
            $EmployeeData = DB::select('call SP_GetEmployeeData("'.$ListEmployeeIDTo[$i].'")');
            if (sizeof($EmployeeData) != 0){
                $ListEmployeeData = [];
                $ListEmployeeData['EmployeeName'] = $EmployeeData[0]->EmployeeName;
                $ListEmployeeData['Email'] = $EmployeeData[0]->Email;
                $ListEmployeeToData[] = $ListEmployeeData;
            }
        }

        for ($i = 0; $i < sizeof($ListEmployeeIDCc); $i++){
            $EmployeeData = DB::select('call SP_GetEmployeeData("'.$ListEmployeeIDCc[$i].'")');
            if (sizeof($EmployeeData) != 0){
                $ListEmployeeCcEmail[] = $EmployeeData[0]->Email;
            }
        }

        $this->TotalFile = $TotalFile;
        $this->CC = $ListEmployeeCcEmail;
        $this->Subject = $Subject;

        for ($i = 0; $i < sizeof($ListEmployeeToData); $i++){
            $this->Email = $ListEmployeeToData[$i]['Email'];
            $this->EmployeeName = $ListEmployeeToData[$i]['EmployeeName'];
            $data = array('EmployeeName' => $ListEmployeeToData[$i]['EmployeeName'], 'BodyEmail' => $BodyEmail);
            //$data = array('EmployeeName' => $ListEmployeeToData[$i]['EmployeeName'], 'BodyEmail' => $BodyEmail, 'ListEmployeeTo' => $ListEmployeeToData, 'ListEmployeeCc' => $ListEmployeeCcEmail);
            Mail::send('emailblastemail', $data, function($message) {
                $message->from('owasiaonline@gmail.com','Project Management Team');
                //$message->to('blankpoint88@gmail.com', 'Andika Rahman Hakim')->subject($this->Subject);
                $message->to($this->Email, $this->EmployeeName)->subject($this->Subject);
                $message->cc($this->CC);

                for ($i = 0; $i < $this->TotalFile; $i++){
                    $message->attach($this->{'File'.$i},
                        [
                            'as' => $this->{'FileName'.$i},
                        ]
                    );
                }
            });
        }

        return response()->json('Email has been sent');
    }
}
