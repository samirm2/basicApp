<ul id="sideNav" class="side-nav fixed">
	<li>
		<div class="user-view">
			<a href="#miPerfil">
				<div class="background">
		     	<img class="responsive-img" src="{{asset('img/background.jpeg')}}">
		    </div>
	      <img class="circle" src="{{asset('img/user.jpg')}}">
	      <span class="white-text name">{{auth()->user()->persona->NombreCompleto}}</span>
	      <span class="white-text email">{{auth()->user()->rol}}</span>
	    </a>
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
	<li><a href="{{url('/logout')}}"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a></li>
</ul>