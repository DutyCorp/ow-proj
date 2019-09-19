<link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('css/lib/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('css/lib/datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('css/lib/buttons.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('css/lib/fixedColumns.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('css/loader.css')}}">
<script src="{{asset('js/lib/Chart.min.js')}}"></script>
<script src="{{asset('js/lib/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('js/lib/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/lib/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('js/lib/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('js/lib/buttons.html5.min.js')}}"></script>
<script src="{{asset('js/lib/jszip.min.js')}}"></script>
<script src="{{asset('js/lib/datepicker.min.js')}}"></script>
<script src="{{asset('js/lib/datepicker.en.js')}}"></script>
<script src="{{asset('js/lib/jquery.masknumber.js')}}"></script>
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
</style>


