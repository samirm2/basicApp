@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection
@section('contenido')
	<div class="caja">
		<div class="row">
			<div class="col s12">
				<div class="card-panel">
					@if(count($arrayEmpleos) > 0)
						<ul class="collapsible" data-collapsible="accordion">
							@foreach($arrayEmpleos as $empleo)
								<li>
							      <div class="collapsible-header">
							      	<b>#{{$empleo->id}} - {{$empleo->cargo}}</b></div>
							      <div class="collapsible-body">
							      	<p><b>Descripción:</b> {{$empleo->descripcion}}</p>
							      	<p><b>Salario:</b> {{number_format($empleo->salario)}} {{$empleo->tipo_salario}}</p>
							      	<p><b>Duración:</b> {{$empleo->duracion}} {{$empleo->tipo_duracion}}, <b>Estado:</b> {{$empleo->estado}}</p>

							      	<table class="striped centered">
										<thead>
											<tr>
												<th colspan="6">
													Historial
												</th>
											</tr>
											<tr>
												<th>Cédula</th>
												<th>Nombres</th>
												<th>Apellidos</th>
												<th>Correo Electrónico</th>
												<th>Fecha Inicio</th>
												<th>Fecha Final</th>
											</tr>
										</thead>
										<tbody>
											@if(count($empleo->contratados)>0)
												@foreach($empleo->contratados as $aspirante)
													<tr>
														<td>{{$aspirante->cc}}</td>
														<td>{{$aspirante->nombres}}</td>
														<td>{{$aspirante->apellidos}}</td>
														<td>{{$aspirante->email}}</td>
														<td>{{$aspirante->fecha_inicio}}</td>
														<td>{{$aspirante->fecha_terminacion}}</td>				
													</tr>
												@endforeach
											@else
												<tr>
													<td colspan="6">
														<i>No hay datos</i>
													</td>
												</tr>
											@endif
										</tbody>
									</table>
							      </div>
							    </li>
							@endforeach
						</ul>
					@else
						<h3 class="center grey-text"><i>NO HAY DATOS<i></h3>
					@endif
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
@include('sweet::alert')
@endsection