<script src="{{asset('js/lib/jquery-3.1.1.min.js')}}"></script>
@if (session()->get('EmployeeID') == null)
<script>
	$(function(){
		$("#OWFooter").hide();
		if(typeof Storage !== "undefined")
		{
			localStorage.setItem("data", "Local Storage enabled!");
			localStorage.setItem("currentURL", window.location.pathname);
			localStorage.setItem("menuName", $(document).find("title").text());
		}
    	window.location.replace("{{ URL::to('login') }}");
    });
</script>
@endif
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/lib/dataTables.bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/lib/datepicker.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/lib/buttons.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/lib/fixedColumns.dataTables.min.css')}}">
	<link href="{{asset('css/FontList.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('css/lib/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/loader.css')}}">

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
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	
	<script src="{{asset('js/lib/serviceworker.js')}}"></script>
	<script src="{{asset('js/lib/bootstrap.min.js')}}"></script>
	<script src="{{asset('js/lib/Chart.min.js')}}"></script>
	<script src="{{asset('js/lib/easyNotify.js')}}"></script>
	<script src="{{asset('js/lib/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('js/lib/dataTables.bootstrap.min.js')}}"></script>
	<script src="{{asset('js/lib/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('js/lib/buttons.html5.min.js')}}"></script>
	<script src="{{asset('js/lib/jszip.min.js')}}"></script>
	<script src="{{asset('js/lib/datepicker.min.js')}}"></script>
	<script src="{{asset('js/lib/datepicker.en.js')}}"></script>
	<script src="{{asset('js/lib/jquery.masknumber.js')}}"></script>
	<script src="{{asset('js/lib/jquery.mobile.custom.min.js')}}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>
		$(function(){
	      	$("#OWNavbar").load("{{ URL::to('OWNavbar') }}");
	    });
	</script>
	<style>
		@media (min-width: 1200px) {
			.container{
			    width: 95%;
			}
		}
		.modal-lg-lw {
		  width: 99%;
		  margin: 5px 5px 5px 5px;
		}
		.modal-body-ip {
		    max-height: calc(100vh - 110px);
		    overflow-x: auto;
		}
		.modal-body-resourceallocation {
		    max-height: calc(100vh - 180px);
		    overflow-x: auto;
		}
		.dropdown {
			display: inline;
		}
		.modal-body-position {
		    max-height: calc(100vh - 280px);
		    overflow-x: auto;
		}
		.modal-body-region {
		    max-height: calc(100vh - 480px);
		    overflow-x: auto;
		}
		.modal-body-sc {
		    max-height: calc(100vh - 110px);
		    overflow-y: auto;
		}
		a.dt-button.buttons-excel.buttons-html5 {      
			padding-top: 10px;  
		}
	</style>
</head>
<body>
	<div id="OWNavbar"></div>