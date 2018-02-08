@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection
@section('contenido')
	<div class="caja">
		<div class="row">
			<div class="col s12">
				<div class="card-panel">
					<table class="striped">
						<thead>
							<tr>
								<th>consecutivo</th>
								<th>tipo</th>
								<th>Asunto</th>
								<th>Fecha Creación</th>
								<th>Ultima Actividad</th>
								<th>Estado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>455</td>
								<td>Reclamo</td>
								<td>Agua Sucia en la puerta</td>
								<td>2018/01/10</td>
								<td>2018/01/15</td>
								<td><span class="spanEstado light-green">Activo</span></td>
								<td>
									<a href="{{url('Propietario/pqrs/455')}}" class="btn-floating cyan"><i class="material-icons">feedback</i></a>
									<a href="#" class="btn-floating cyan"><i class="material-icons">archive</i></a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@include('layout._botonRojo')
	@include('layout._formPqrs')
@endsection