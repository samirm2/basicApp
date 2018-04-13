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
								<th>Fecha Creación</th>
								<th>Ultima Actividad</th>
								<th>Estado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($listaPqrs as $pqrs)
								@if($pqrs->destinatario == auth()->user()->id)
									<tr>
										<td>{{$pqrs->id}}</td>
										<td><b>{{$pqrs->tipo}}</b></td>
										<td>{{$pqrs->asunto}}</td>
										<td>{{$pqrs->created_at->diffForHumans()}}</td>
										<td>{{$pqrs->mensajes->last()->created_at->diffForHumans()}}</td>
										<td><span class="spanEstado {{$pqrs->estado == 'Activo'?'light-green':'grey'}}">{{$pqrs->estado}}</span></td>
										<td>
											<a href="{{url('Propietario/pqrs/'.$pqrs->id)}}" class="btn-floating cyan"><i class="material-icons tooltipped" data-tooltip="Responder">chat_bubble</i></a>
											{{-- <a href="#" class="btn-floating cyan tooltipped" data-tooltip="Cerrar"><i class="material-icons">archive</i></a> --}}
										</td>
									</tr>
								@elseif($pqrs->remitente == auth()->user()->id)
									<tr>
										<td>{{$pqrs->id}}</td>
										<td><b>{{$pqrs->tipo}}</b></td>
										<td>{{$pqrs->asunto}}</td>
										<td>{{$pqrs->created_at->diffForHumans()}}</td>
										<td>{{$pqrs->mensajes->last()->created_at->diffForHumans()}}</td>
										<td><span class="spanEstado {{$pqrs->estado == 'Activo'?'light-green':'grey'}}">{{$pqrs->estado}}</span></td>
										<td>
											<a href="{{url('Propietario/pqrs/'.$pqrs->id)}}" class="btn-floating cyan"><i class="material-icons tooltipped" data-tooltip="Responder">chat_bubble</i></a>
											<button data-href="{{url('pqrs',$pqrs->id)}}" class="btn-floating cyan tooltipped btnCerrarPqrs" data-tooltip="Cerrar" {{$pqrs->estado == 'Activo'?'':'disabled="true"'}}><i class="material-icons">archive</i></button>
										</td>
									</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@include('layout._botonRojo')
	@include('layout._formPqrs')
@endsection
@section('scripts')
<script type="text/javascript">
	$(function(){
		$('#btnEnviarPqrs').click(function(){
			if (!validarCamposFormPqrs()) {
				$.ajax({
					url: '{{route('pqrs.guardar')}}',
					method:'post',
					data:{
						'_token': '{{csrf_token()}}',
						'asunto':$('[name=asunto]').val(),
						'tipoPqrs':$('[name=tipo]').val(),
						'mensaje':$('[name=mensaje]').val()
					},
					dataType: 'json',
					success: function(response){
						console.log(response);
						if (response.bandera == 1) {
							swal('¡Enhorabuena!', 'PQRS enviada satisfactoriamente', 'success').then(value =>{
								window.location.reload();
							});
						}
					},
					error: function(response){
						console.log(response);
					}
				});
			}	
		});

		$('.btnCerrarPqrs').click(function(){
			$.ajax({
				url:$(this).data('href'),
				method:'post',
				data:{'_token':'{{csrf_token()}}'},
				dataType: 'json',
				success: function(response){
					if (response.bandera == 1) {
						swal('¡Enhorabuena!', response.mensaje, 'success').then(value =>{
							window.location.reload();
						});
						}
				},
				error: function(response){
					console.log(response);
				}
			});
		});
	});

	function validarCamposFormPqrs(){
		var salida = false;
		if ($('[name=asunto]').val() == ''){
			Materialize.toast('El campo asunto esta Vacio',3000,'red');
			salida = true;
		}
		if ($('[name=mensaje]').val() == ''){
			Materialize.toast('El campo mensaje esta Vacio',3000,'red');	
			salida = true;
		}
		return salida;
	}
</script>
@endsection