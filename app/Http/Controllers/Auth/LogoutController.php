<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class LogoutController extends Controller
{
    public function Logout()
    {
    	if (session_status() == 1){
    		Session::flush();	
    	}

    	return response()->json();
    }
}
