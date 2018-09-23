@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection
@section('contenido')
	<div class="caja">
		<div class="row">
			<div class="col s12">
				<div class="card-panel">
					<h5>Contratos Activos <i class="material-icons left">assignment_turned_in</i></h5>
					<div class="divider"></div>
					@if(count($arrayEmpleos) > 0)
						<ul class="collapsible popout" data-collapsible="accordion">
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
													Contratados
												</th>
											</tr>
											<tr>
												<th>Cédula</th>
												<th>Nombres</th>
												<th>Apellidos</th>
												<th>Correo Electrónico</th>
												<th>Fecha Inicio</th>
												<th>Curriculum</th>
												<th>Acciones</th>
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
														<td>
															<a href="/Administrador/Empleo/Download/{{explode('/',$aspirante->hoja_vida)[2]}}" target="_blank">Descargar</a>
														</td>
														<td>
															<a href="#{{$aspirante->id}}" class="btn-floating light-blue tooltipped DeleteBtn" data-tooltip="Finalizar contrato" data-position="bottom" data-delay="50"><i class="material-icons">beenhere</i></a>
														</td>
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

	<div class="modal" id="modal_delete" style="width: 40%">
		<div class="modal-content" style="padding-bottom: 0px">
			<h5>¿Está seguro(a) de finalizar el contrato?</h5>
		</div>
		<div class="modal-footer">
			<a class="btn-flat modal-action modal-close">No <i class="material-icons red-text right">cancel</i></a>
			<a id="dataDelete" href="#" class="btn-flat modal-action">Continuar <i class="material-icons light-green-text right">check_circle</i></a>
		</div>
	</div>
@endsection

@section('scripts')
<script>
	$(function() {
		$('.DeleteBtn').click(function(e) {
			var file = e.currentTarget.href.split('Activos#')[1];
			$('#modal_delete').modal('open');
			$('#dataDelete').prop('href',"{{url('Administrador/Contratos/Finalizar/')}}"+"/"+file);
		});
	});
</script>
@include('sweet::alert')
@endsection