<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>{{env('app_name')}}</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/materialize.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/dropify.min.css')}}">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{asset('css/estilos.css')}}">
</head>
<body bgcolor="#fafafa">
	<nav class="white {{request()->is('/')?'hide':''}}">
		<div class="brand-logo right"><a href="{{url('/')}}"><img height="60" src="{{asset('img/logo.png')}}"></a>
		</div>
		<ul>
			<li><a class="button-collapse" data-activates='sideNav' href="#"><i class="material-icons indigo-text">menu</i></a></li>
		</ul>
	</nav>
	@yield('sidenav')
	@yield('contenido')
{{-- Scripts --}}
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/materialize.min.js')}}"></script>
<script src="{{asset('js/init.js')}}"></script>
<script src="{{asset('js/dropify.min.js')}}"></script>
<script src="{{asset('js/sweetAlert.min.js')}}"></script>
<script type="text/javascript">
	$(function(){
		@if(request()->is('/'))
			$(".button-collapse").sideNav({
	      menuWidth: 400,
	      edge: "right"
	    });
    @else
    	$(".button-collapse").sideNav();
    @endif
	});
</script>
@yield('scripts')
</body>
</html>