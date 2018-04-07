@extends('layout.app')

@section('sidenav')
	@include('layout.sideNav')
@endsection

@section('contenido')
	<div class="caja">
		<div class="row">
			<div class="col s12">
				<div class="card-panel">
					<a href="{{(request()->is('Administrador/*'))?url('Administrador/pqrs'):url('Propietario/pqrs')}}" class="btn-floating cyan"><i class="material-icons">arrow_back</i></a>
					<div class="row"></div>				
					<div class="row">
						<span class="spanEstado blue">{{$pqrs->tipo}}</span>
						<b>Asunto: {{$pqrs->asunto}}</b>
						<span class="spanEstado right {{($pqrs->estado == 'Activo') ? 'light-green' : 'red'}}">{{$pqrs->estado}}</span>
					</div>

					<div class="row" style="height: 250px; overflow-y: auto;">
						{{-- tarjeta para chat --}}
						@foreach($pqrs->mensajes as $conversacion)
						@if($conversacion->autor != auth()->user()->id)
						<div class="col s10">
							<div class="card-panel blue-grey lighten-5">
								<div class="row valign-wrapper" style="margin-bottom: 0px">
									<div class="col s2">
										<img class="circle" src="{{asset('img/user.jpg')}}" height="70">	
									</div>
									<div class="col s10">
										<span>{{$conversacion->mensaje}}</span>	
									</div>
								</div>
							</div>
						</div>
						@else
						<div class="col s10 offset-s2">
							<div class="card-panel cyan lighten-5">
								<div class="row valign-wrapper" style="margin-bottom: 0px">
									<div class="col s10">
										<span>{{$conversacion->mensaje}}</span>	
									</div>
									<div class="col s2">
										<img class="circle" src="{{asset('img/user.jpg')}}" height="70">	
									</div>
								</div>
							</div>
						</div>
						@endif
						@endforeach
					</div>
					
					<div class="row valign-wrapper">
						<div class="input-field col s12">
							{{-- <input type="hidden" name="pqrs_id" value="{{$pqrs->id}}"> --}}
							<textarea name="mensaje" class="materialize-textarea" data-length="450" {{($pqrs->estado == 'Cerrado') ?'disabled="true"':''}} style="margin-bottom: 0px"></textarea>
							<label for="mensaje">Mensaje</label>
							<span id="spnMensajeValidate" class="inputMensaje" style="margin-left: 0px"></span>
						</div>
						<button id="btnEnviar" class="btn-floating btn-large green" {{($pqrs->estado == 'Cerrado') ?'disabled="true"':''}}><i class="material-icons right">send</i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(function(){
		$('#btnEnviar').click(function(){
			if ($('[name=mensaje]').val() == '') {
				$('#spnMensajeValidate').text('El campo mensaje es obligatorio');
			}else{
				$('#spnMensajeValidate').text('');
				$.ajax({
					url: window.location.href,
					method: 'post',
					data: {
						'_token' : '{{csrf_token()}}',
						'pqrs_id': $('[name=pqrs_id]').val(),
						'mensaje': $('[name=mensaje]').val()
					},
					dataType: 'json',
					success: function(response){
						if (response.bandera == 1) {
							swal('¡Enhorabuena!',response.mensaje,'success').then((value) => {
								window.location.reload();
							});
						}
					}
				})
			}
		});
	})
</script>
@endsection