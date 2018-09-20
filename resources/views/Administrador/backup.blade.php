@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection
@section('contenido')
	<div class="caja">
		<div class="row">
			<div class="col s12">
				<div class="card-panel">
					<table class="striped centered">
						<thead>
							<tr>
								<th>#</th>
								<th>Nombre</th>
								<th>Tamaño</th>
								<th>Fecha de creación</th>
								<th colspan="3">Opciones</th>
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
									<a href="#{{ $arrayBackups[$i]['file_name'] }}" class="btn-floating light-blue tooltipped RestoreBtn" data-tooltip="Restaurar" data-position="botton" data-delay="50"><i class="material-icons">refresh</i></a>
								</td>
								<td>
									<a href="{{ url('Administrador/Backup/download/'.$arrayBackups[$i]['file_name']) }}" class="btn-floating light-blue tooltipped" data-tooltip="Descargar" data-position="botton" data-delay="50"><i class="material-icons">file_download</i></a>
								</td>
								<td>
									<a href="#{{ $arrayBackups[$i]['file_name'] }}" class="btn-floating light-blue tooltipped DeleteBtn" data-tooltip="Eliminar" data-position="botton" data-delay="50"><i class="material-icons">delete</i></a>
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

<div class="modal" id="modal_delete" style="width: 40%">
	<div class="modal-content" style="padding-bottom: 0px">
		<h5 id="msgDelete"></h5>
	</div>
	<div class="modal-footer">
		<a class="btn-flat modal-action modal-close">No <i class="material-icons red-text right">cancel</i></a>
		<a id="dataDelete" href="#" class="btn-flat modal-action">Continuar <i class="material-icons light-green-text right">check_circle</i></a>
	</div>
</div>

<div class="modal" id="modal_restore" style="width: 40%">
	<div class="modal-content" style="padding-bottom: 0px">
		<h5 id="msgRestore"></h5>
	</div>
	<div class="modal-footer">
		<a class="btn-flat modal-action modal-close">No <i class="material-icons red-text right">cancel</i></a>
		<a id="dataRestore" href="#" class="btn-flat modal-action">Continuar <i class="material-icons light-green-text right">check_circle</i></a>
	</div>
</div>

<div class="modal" id="modal_wait" style="width: 40%">
	<div class="modal-content" style="padding-bottom: 0px">
		<h5>Restaurando</h5>
		<p>Por favor, espere...</p>
	</div>
</div>

@endsection

@section('scripts')
	<script>
		$(function() {
			$('.DeleteBtn').click(function(e) {
				var file = e.currentTarget.href.split('#')[1];
				$('#msgDelete').html('¿Está seguro(a) de eliminar esta copia de seguridad '+file+'?');
				$('#modal_delete').modal('open');
				$('#dataDelete').prop('href',"{{url('Administrador/Backup/delete/')}}"+"/"+file);
			});

			$('.RestoreBtn').click(function(e) {
				var file = e.currentTarget.href.split('#')[1];
				$('#msgRestore').html('¿Está seguro(a) de restaurar esta copia de seguridad: '+file+'?');
				$('#modal_restore').modal('open');
				$('#dataRestore').prop('href',"{{url('Administrador/Backup/restore/')}}"+"/"+file);
			});

			$('#dataRestore').click(function() {
				$('#modal_restore').modal('close');
				$('#modal_wait').modal({dismissible:false});
				$('#modal_wait').modal('open');
			});
		});
	</script>
@include('sweet::alert')
@endsection