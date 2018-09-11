@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection
@section('contenido')
	<div class="caja">
		<div class="row">
			<div class="col s12">
				<div class="card-panel">
					<!-- <a href="{{url('Administrador/Backup/create')}}" class="btn-floating light-blue tooltipped" data-tooltip="Crear copia" data-position="botton" data-delay="50"><i class="material-icons">class</i></a> -->

					<table class="striped centered">
						<thead>
							<tr>
								<th>#</th>
								<th>Nombre</th>
								<th>Tamaño</th>
								<th>Fecha de creación</th>
								<th colspan="2">Opciones</th>
							</tr>
						</thead>
						<tbody>
							@for ($i = 0; $i < count($arrayBackups); $i++)
							<tr>
								<td>{{$i+1}}</td>
								<td>{{$arrayBackups[$i]['file_name']}}</td>
								<td>{{number_format($arrayBackups[$i]['file_size'])}}KB</td>
								<td>{{date('d/m/Y - H:i:s',$arrayBackups[$i]['last_modified'])}}</td>
								<td>
									<a href="{{ url('Administrador/Backup/download/'.$arrayBackups[$i]['file_name']) }}" class="btn-floating light-blue tooltipped" data-tooltip="Descargar" data-position="botton" data-delay="50"><i class="material-icons">file_download</i></a>
								</td>
								<td>
									<a href="{{ url('Administrador/Backup/delete/'.$arrayBackups[$i]['file_name']) }}" class="btn-floating light-blue tooltipped" data-tooltip="Eliminar" data-position="botton" data-delay="50"><i class="material-icons">delete</i></a>
								</td>
							</tr>
							@endfor
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@include('layout._botonRojo')

<div class="modal" id="modal" style="width: 40%">
	<div class="modal-content" style="padding-bottom: 0px">
		<h5>¿Está seguro(a) de crear otra copia de seguridad?</h5>
	</div>
	<div class="modal-footer">
		<a class="btn-flat modal-action modal-close">No <i class="material-icons red-text right">cancel</i></a>
		<a href="{{url('Administrador/Backup/create')}}" class="btn-flat modal-action">Continuar <i class="material-icons light-green-text right">check_circle</i></a>
	</div>
</div>

@endsection

@section('scripts')

@include('sweet::alert')
@endsection