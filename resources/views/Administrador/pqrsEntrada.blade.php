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
							<th>Id</th>
							<th>Tipo</th>
							<th>Asunto</th>
							<th>Remitente</th>
							<th>Rol</th>
							<th>Casa</th>
							<th>Fecha de Creación</th>
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
									<td>Albero Sanabria</td>
									<td>Propietario</td>
									<td>Casa 2</td>
									<td>{{$pqrs->created_at->diffForHumans()}}</td>
									<td>
										<span class="spanEstado {{$pqrs->estado != 'Activo'?'grey':'light-green'}}">{{$pqrs->estado}}</span>
									</td>
									<td><a href="{{url('Administrador/pqrs/'.$pqrs->id)}}" class="btn-floating cyan"><i class="material-icons">chat_bubble</i></a></td>
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
						console.log(response);
					},
					error: function(response){
						console.log(response);
					}
				});
			}	
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