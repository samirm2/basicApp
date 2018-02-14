<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>{{env('app_name')}}</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/materialize.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/dropify.min.css')}}">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<style type="text/css">
		body::-webkit-scrollbar {
			width: 10px;			
		}
		body::-webkit-scrollbar-thumb {
			background: #1976d2;
			border-radius: 3px;
		}

		.caja{
			padding-left: 305px;
			margin-top: 20px;
		}

		@media only screen and (max-width : 992px) {
     		 .caja {
        		padding-left: 0;
      		}
    	}

		.modal{
			background: white;
			max-height: 80%;
		}
		.modal.modal-fixed-footer{
			height: 80%;
		}
		.modal-content::-webkit-scrollbar {
			width: 8px;			
		}
		.modal-content::-webkit-scrollbar-thumb {
			background: black;
			border-radius: 5px;
		}
		.spanEstado{
			color: white;
			padding: 3px 6px;
			border-radius: 2px;
			font-size: 0.8rem;
			font-weight: 300;
		}
		
		.collapsible-body{
			padding: 1rem;
		}
		.switch label input[type=checkbox]:checked+.lever:after {
 		   background-color: #03a9f4;
		}
		.switch label input[type=checkbox]:checked+.lever {
 		   background-color: #b3e5fc;
		}
	</style>
</head>
<body bgcolor="#fafafa">
	@yield('sidenav')
	@yield('contenido')
{{-- Scripts --}}
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/materialize.min.js')}}"></script>
<script src="{{asset('js/init.js')}}"></script>
<script src="{{asset('js/dropify.min.js')}}"></script>
@yield('scripts')
</body>
</html>