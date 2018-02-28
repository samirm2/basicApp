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
	@yield('sidenav')
	@yield('contenido')
{{-- Scripts --}}
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/materialize.min.js')}}"></script>
<script src="{{asset('js/init.js')}}"></script>
<script src="{{asset('js/dropify.min.js')}}"></script>
<script src="{{asset('js/sweetAlert.min.js')}}"></script>
@yield('scripts')
</body>
</html>