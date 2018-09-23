<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Altos de Ziruma I</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/materialize.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/material-icons.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/dropify.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/estilos.css')}}">
	<link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
</head>
<body bgcolor="#fafafa">

	@if(!request()->is('Administrador/Pagos/*') && !request()->is('Propietario/Pagos/*') && !request()->is('Administrador/Gastos/*') )
	<nav class="white {{request()->is('/')?'hide':''}}">
		<div class="brand-logo right"><a href="{{url('/')}}"><img height="60" src="{{asset('img/logo.png')}}"></a>
		</div>
		<ul>
			<li><a class="button-collapse" data-activates='sideNav' href="#"><i class="material-icons indigo-text">menu</i></a></li>
		</ul>
	</nav>
	@endif
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