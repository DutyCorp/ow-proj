<!DOCTYPE html>
<html>
<head>
	<title>Reset Password</title>
	<link rel="stylesheet" href="{{asset('css/lib/bootstrap4.min.css')}}" >
	<link rel="stylesheet" href="{{asset('css/lib/font-awesome.min.css')}}">
	<style type="text/css">
	#OWLogo {
		width: 15%;
		margin-top: 8%;
		margin-left: 40%;
		transition: 0.5s;
	}
	#password, #confirmpassword, #btnSubmit, #btnLogin {
		margin-top: .5%;
		width: 20%;
		margin-left: 40%;
	}
	#background {
		position: fixed;
	    top: 0%;
	    left: 36%;
	    width: 28%;
	    height: 100%;
	    background-color: #FFFFFF;
	    z-index: 1;
	}
	#content {
		position: relative;
    	z-index: 2;
    	margin-top: 7%;
	}
	#spanResetPassword {
		margin-top: 100px;
		width: 20%; 
		margin-left: 40%;
		font-size: 24px;
	}
	#spanUsername {
		width: 20%; 
		margin-left: 40%;
		font-size: 14px;
	}
	@media screen and (max-width: 1366px) {
		#content {
    		margin-top: 11%;
		}
	}
	@media screen and (max-width: 1080px) {
		#background {width: 100%; left: 0px; height: 100%; top: 0px;}
    	#OWLogo {width: 40%; margin-left: 20%;}
    	#confirmpassword, #password, #btnLogin, #btnSubmit {width: 60%; margin-left: 20%;}
    	#spanResetPassword {width: 60%; margin-left: 20%;}
		#spanUsername {width: 60%; margin-left: 20%;}
	}
	</style>

	<script src="{{asset('js/lib/jquery-3.1.1.min.js')}}"></script>
	<script src="{{asset('js/lib/bootstrap4.min.js')}}"></script>
	
	<script src="{{asset('js/resetpasswordcommands.js')}}"></script>
	<link rel="apple-touch-icon" sizes="57x57" href="{{asset('img/icons/apple-icon-57x57.png')}}">
	<link rel="apple-touch-icon" sizes="60x60" href="{{asset('img/icons/apple-icon-60x60.png')}}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{asset('img/icons/apple-icon-72x72.png')}}">
	<link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/icons/apple-icon-76x76.png')}}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{asset('img/icons/apple-icon-114x114.png')}}">
	<link rel="apple-touch-icon" sizes="120x120" href="{{asset('img/icons/apple-icon-120x120.png')}}">
	<link rel="apple-touch-icon" sizes="144x144" href="{{asset('img/icons/apple-icon-144x144.png')}}">
	<link rel="apple-touch-icon" sizes="152x152" href="{{asset('img/icons/apple-icon-152x152.png')}}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/icons/apple-icon-180x180.png')}}">
	<link rel="icon" type="image/png" sizes="192x192"  href="{{asset('img/icons/android-icon-192x192.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('img/icons/favicon-32x32.png')}}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{asset('img/icons/favicon-96x96.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/icons/favicon-16x16.png')}}">
	<link rel="manifest" href="{{asset('img/icons/manifest.json')}}">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="{{asset('img/icons/ms-icon-144x144.png')}}">
	<meta name="theme-color" content="#ffffff">
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	@if ($LinkExpired == 0)
	<input type="hidden" id="le" value="{{ $LinkExpired }}">
	<input type="hidden" id="empid" value="{{ $encryptedemployeeid }}">
	<div id="content">
		<div id="divImg">
		<img src="/a/{{ Crypt::encrypt('OWLogo.png') }}" id="OWLogo">
		</div><br>
		<div id="divSpan">
			<span id="spanResetPassword">Reset Password</span><br>
			<span id="spanUsername">for <b>{{ $EmployeeName }}</b></span>
		</div>
		<div id="divLoading">
			<p class="text-center"><i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:#169BD5"></i></p>
		</div>
		<!--<table id="spanProfileName" border="0" align="center">
			<tr>
				<td id="spanTdProfileName">Welcome, <b id="profileName">Stranger</b>!</td>
			</tr>
		</table>-->
		<!--<span id="spanProfileName" class="center">Welcome, </span>-->		
		<input type="password" id="password" name="password" placeholder="Password" class="form-control">
		<input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" class="form-control">
		<button id="btnSubmit" class="btn btn-success">Submit</button>
		<button id="btnLogin" class="btn btn-success">Back to Login</button><br>
	</div>	
	<div id="background"></div>
	<div class="modal fade" tabindex="-1" role="dialog" id="Modal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="ModalHeader"></h4>
				</div>
				<div class="modal-body" id="ModalContent">

				</div>
				<div class="modal-footer" id="ModalFooter">
					<button type="button" class="btn btn-primary" id="btnAlright">OK</button>
				</div>
			</div>
		</div>
	</div>
	@else 
	<div id="content">
		<div id="divImg">
			<img src="/a/{{ Crypt::encrypt('OWLogo.png') }}" id="OWLogo">
		</div><br>
		<div id="divSpan">
			<span id="spanResetPassword">Link Expired</span><br>
		</div>
		<div id="divLoading">
			<p class="text-center"><i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:#169BD5"></i></p>
		</div>
		<button id="btnLogin" class="btn btn-success">Back to Login</button><br>
	</div>
	<div id="background"></div>
	@endif
</body>
</html>