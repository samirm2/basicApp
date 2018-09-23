@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection

@section('contenido')
	<div class="caja">
		<div class="row">
			<div class="col s12">
				<div class="card-panel">
					<a href="{{url('Administrador/Empleo')}}" class="btn-floating light-blue"><i class="material-icons">arrow_back</i></a>
					<div class="row"></div>
					<span class="spanEstado {{($empleo->estado == 'Activo') ? 'light-green' : 'grey'}}">{{$empleo->estado}}</span>
					<h4>{{strtoupper($empleo->cargo)}}</h4>

					<table class="striped centered">
						<thead>
							<tr>
								<th>Cédula</th>
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Correo Electrónico</th>
								<th>Curriculum</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($empleo->aspirantes as $aspirante)
								<tr>
									<td>{{$aspirante->cc}}</td>
									<td>{{$aspirante->nombres}}</td>
									<td>{{$aspirante->apellidos}}</td>
									<td>{{$aspirante->email}}</td>
									<td>
										<a href="/Administrador/Empleo/Download/{{explode('/',$aspirante->hoja_vida)[2]}}" target="_blank">Descargar</a>
									</td>
									<td>
										<a href="/Administrador/Empleo/Contratar/{{$aspirante->id}}" class="btn-floating light-blue tooltipped" data-tooltip="contratar" data-position="bottom" data-delay="50"><i class="material-icons">assignment_turned_in</i></a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
@include('sweet::alert')
@endsection