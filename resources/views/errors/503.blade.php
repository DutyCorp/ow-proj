<!DOCTYPE html>
<html>
<head>
	<title>Maintenance</title>
	<link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}" >
	<link rel="stylesheet" href="{{asset('css/lib/font-awesome.min.css')}}">
	<link href="{{asset('css/FontList.css')}}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{asset('css/OWNavbar.css')}}">
	<style type="text/css">
		#Home:hover, #Home:active {
			text-decoration: none;
		}
		h1 {
			font-size: 100px;
		}
	</style>

	<script src="{{asset('js/lib/jquery-3.1.1.min.js')}}"></script>
	<script src="{{asset('js/lib/bootstrap.min.js')}}"></script>
	
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
</head>
<body>	
	<div id="main" class="container">
		<a href="/" id="Home"><p id="Logo" style="margin-top: 10%;">owasia online</p></a>
		<h1>503</h1>
		<h2>Service Unavailable</h2>
		<h4>Be right back. We'll be up soon!</h4>
		<!--<h6>Time to fix : Shorter than Forever</h6>-->
		<img src="/img/OWLogo.png" style="width: 200px; margin-top: 40%;">
	</div>
</body>
</html>