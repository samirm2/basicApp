@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection
@section('contenido')
<div class="caja">
	<div class="row">
		<div class="col s12">
			<div class="card-panel">
				<div class="input-field col s3">
					<select name="filtro">
						<option>Tipo</option>
						<option>Casa</option>
						<option>Rol</option>
						<option>Remitente</option>
					</select>
					<label for="filtro">Filtrar</label>
				</div>
				<div class="input-field col s4">
					<input type="search" name="ca">
				</div>
				<table class="striped">
					<thead>
						<tr>
							<th>N°</th>
							<th>Tipo</th>
							<th>Asunto</th>
							<th>{{$bandeja == 'entrada'?'Remitente':'Destinatario'}}</th>
							<th>Rol</th>
							<th>Casa</th>
							<th>Fecha de Creacion</th>
							<th>Ultima Actividad</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						@foreach($listaPqrs as $pqrs)
							@if($bandeja == 'salida')
								@if($pqrs->remitente == auth()->user()->id)
									<tr>
										<td>{{$pqrs->id}}</td>
										<td><b>{{$pqrs->tipo}}</b></td>
										<td>{{$pqrs->asunto}}</td>
										<td>{{$pqrs->infoDestinatario->NombreCompleto}}</td>
										<td>{{$pqrs->infoDestinatario->usuario->rol}}</td>
										<td>
											@foreach ($pqrs->infoDestinatario->propietario->misCasas->pluck('nombre') as $casa)
												{{'['.$casa.']'}}
											@endforeach
										</td>
										<td>{{$pqrs->created_at->diffForHumans()}}</td>
										<td>{{$pqrs->mensajes->last()->created_at->diffForHumans()}}</td>
										<td>
											<span class="spanEstado {{$pqrs->estado != 'Activo'?'grey':'light-green'}}">{{$pqrs->estado}}</span>
										</td>
										<td>
											<a href="{{url('Administrador/pqrs/'.$pqrs->id)}}" class="btn-floating cyan tooltipped" data-tooltip="Responder" data-position="left"><i class="material-icons">chat_bubble</i></a>
											<button data-href="{{url('pqrs',$pqrs->id)}}" class="btn-floating cyan tooltipped btnCerrarPqrs" data-tooltip="Cerrar" data-position="left" {{$pqrs->estado == 'Activo'?'':'disabled="true"'}}><i class="material-icons">archive</i></button>
										</td>
									</tr>
								@endif
							@else
								@if($pqrs->destinatario == auth()->user()->id)
									<tr>
										<td>{{$pqrs->id}}</td>
										<td><b>{{$pqrs->tipo}}</b></td>
										<td>{{$pqrs->asunto}}</td>
										<td>{{$pqrs->infoRemitente->NombreCompleto}}</td>
										<td>{{$pqrs->infoRemitente->usuario->rol}}</td>
										<td>
											@if($pqrs->infoRemitente['usuario']['rol'] == 'Propietario')
												@foreach ($pqrs->infoRemitente->propietario->misCasas->pluck('nombre') as $casa)
													{{'['.$casa.']'}}
												@endforeach
											@else
													{{'['.$pqrs->infoRemitente->arrendatario->casaDatos()->first()['nombre'].']'}}
											@endif
										</td>
										<td>{{$pqrs->created_at->diffForHumans()}}</td>
										<td>{{$pqrs->mensajes->last()->created_at->diffForHumans()}}</td>
										<td>
											<span class="spanEstado {{$pqrs->estado != 'Activo'?'grey':'light-green'}}">{{$pqrs->estado}}</span>
										</td>
										<td>
											<a href="{{url('Administrador/pqrs/'.$pqrs->id)}}" class="btn-floating cyan"><i class="material-icons tooltipped" data-tooltip="Responder" data-position="left">chat_bubble</i></a>
										</td>
									</tr>
								@endif
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
	var contactos = "{";
	$(function(){
		$.ajax({
			url:'{{route('api.personas')}}',
			method: 'get',
			dataType: 'json',
			success: function(rta){
				if (rta.bandera == 0) {
					Materialize.toast('No hay Personas en el sistema');
				}else{
					contactos = convertiraJson(rta.contactos);
					// console.log(contactos);
					inicializarMaterialChip($('#inputDestinatario'),contactos);
					
					$('.chips').on('chip.add', function(e, chip){
			    	// Materialize.toast('agregaste un destinatario',3000);
			    	$('#inputDestinatario').children('input').remove();
			  	});
			  	$('.chips').on('chip.delete', function(e, chip){
			    	// Materialize.toast('Borriaste un chip',3000);
			    	inicializarMaterialChip($('#inputDestinatario'),contactos);
			  	});
				}
			}
		});
		
		$('#btnEnviarPqrs').click(function(){
			if (!validarCamposFormPqrs()) {
				$.ajax({
					url: '{{route('pqrs.guardar')}}',
					method:'post',
					data:{
						'_token': '{{csrf_token()}}',
						'destinatario': $('#inputDestinatario').material_chip('data')[0].tag,
						'asunto':$('[name=asunto]').val(),
						'tipoPqrs':$('[name=tipo]').val(),
						'mensaje':$('[name=mensaje]').val()
					},
					dataType: 'json',
					success: function(response){
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
		var getDestinatario = $('#inputDestinatario').material_chip('data');
		var salida = false, bandera = false;
		if (getDestinatario.length <= 0){
			Materialize.toast('El campo destinatario esta Vacio',3000,'red');
			salida = true;
		}else{
			for (persona in contactos){
				if(persona == getDestinatario[0].tag){
					bandera = true;
					break;
				}
			}
			if (!bandera) {
				Materialize.toast(getDestinatario[0].tag+' no es un contacto valido');
				salida = true;
			}
		}
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

	function convertiraJson(consulta){
		var json = '{';
		for (ob in consulta){
			json += '"'+consulta[ob] + '":' + null + ",";
		}
		json = json.split('');
		json[json.length-1]="}";
		json = json.join('');
		json = JSON.parse(json);
		return json;
	}

	function inicializarMaterialChip(id,listaJson){
		id.material_chip({
			autocompleteOptions:{
				data:listaJson,
				limit: 3,
				minLength: 3
			}			
		});
	}
</script>
@endsection