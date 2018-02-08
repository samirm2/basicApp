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
							<th>N°</th>
							<th>Tipo</th>
							<th>Asunto</th>
							<th>Casa</th>
							<th>Fecha de Creacion</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>Peticion</td>
							<td>Vecino Ruidoso</td>
							<td>Casa 2</td>
							<td>2018/01/12 </td>
							<td><span class="spanEstado light-green">Activo</span></td>
							<td><a href="{{url('Administrador/pqrs/1')}}" class="btn-floating cyan"><i class="material-icons">feedback</i></a></td>
						</tr>
						<tr>
							<td>2</td>
							<td>Sugerencia</td>
							<td>Venta de sopa mañana</td>
							<td>Casa 21</td>
							<td>2018/01/28 </td>
							<td><span class="spanEstado grey">Cerrado</span></td>
							<td><a href="{{url('Administrador/pqrs/2')}}" class="btn-floating cyan"><i class="material-icons">feedback</i></a></td>
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
