<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="{{asset('css/lib/bootstrap4.min.css')}}" >
	<link rel="stylesheet" href="{{asset('css/lib/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/Login.css')}}">

	<script src="{{asset('js/lib/jquery-3.1.1.min.js')}}"></script>
	<script src="{{asset('js/lib/bootstrap4.min.js')}}"></script>
	
	<script src="{{asset('js/logincommands.js')}}"></script>
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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="OWAsia Online is an applications to help employees find what they need.">
</head>
<body>
	<div id="content">
		<div id="divImg">
		<img src="/a/{{ Crypt::encrypt('OWLogo.png') }}" id="OWLogo"><img src="/a/{{ Crypt::encrypt('Face_Blue_128.png') }}" id="defaultProfilePicture"><img id="profilePicture">
		</div><br>
		<div id="divSpan">
			<span id="spanSignIn">Login</span><br>
			<span id="spanMenuPath">to <span id="menuPath"></span></span>
		</div>
		<div id="divLoading">
			<p class="text-center"><i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:#169BD5"></i></p>
		</div>
		<input type="text" id="username" name="username" placeholder="Username" class="form-control">		
		<input type="password" id="password" name="password" placeholder="Password" class="form-control">
		<input type="email" id="email" name="email" placeholder="Email" class="form-control">
		<button id="btnLogin" class="btn btn-success">Login</button>
		<button id="btnBack" class="btn btn-link">Back</button>
		<button id="btnForgotPassword" class="btn btn-danger">Forgot Password</button>
		<button id="btnSubmit" class="btn btn-success">Submit</button><br>
		<button id="btnBackForgot" class="btn btn-link">Back</button>
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
</body>
</html>