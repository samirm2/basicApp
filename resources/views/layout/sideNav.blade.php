<nav class="white">
	<div class="brand-logo right"><a href="{{url('/Administrador')}}"><img height="60" src="{{asset('img/logo.png')}}"></a></div>
</nav>

<ul class="side-nav fixed">
	<li>
		<div class="user-view">
			<div class="background">
	        	<img class="responsive-img" src="{{asset('img/background.jpeg')}}">
	      	</div>
	      <a href="#!user"><img class="circle" src="{{asset('img/user.jpg')}}"></a>
	      <a href="#!name"><span class="white-text name">Samir Miranda</span></a>
	      <a href="#!email"><span class="white-text email">Administrador</span></a>
		</div>
	</li>
	
	@if (request()->is('Administrador/*') or request()->is('Administrador'))
		@include('layout.sideNav-options-admin')
	@elseif(request()->is('Propietario/*') or request()->is('Propietario'))
		@include('layout.sideNav-options-propietario')
	@else
		@include('layout.sideNav-options-arrendatario')
	@endif
	
	<li class="divider"></li>
	<li><a href="{{url('/')}}"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a></li>
</ul>