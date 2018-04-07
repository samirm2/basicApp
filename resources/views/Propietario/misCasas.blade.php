@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection
@section('contenido')
	<div class="caja">
		<div class="row">
			@foreach($listaCasas as $casa)
				<div class="col s4">
						<div class="card">
							<div class="card-content">
								<span class="card-title"><i class="material-icons large left">home</i>{{$casa->nombre}}</span>
								<div class="row"></div>
								<p>
									Cedula: <br>
									Nombres: <br>
									Apellidos: <br>
									Telefono: <br>
									Correo Electronico: <br> <br>
									Deuda: $ 0
								</p>
							</div>
							<div class="card-action">
								<a href="#modal" class="black-text modal-trigger">Arrendar</a>
								<a href="#" class="black-text right">Liberar</a>
							</div>
						</div>
				</div>
			@endforeach
		</div>
	</div>

@include('layout._formRegistrarPersona')	

@endsection