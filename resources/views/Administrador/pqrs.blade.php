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
							<th>Remitente</th>
							<th>Rol</th>
							<th>Casa</th>
							<th>Fecha de Creacion</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td><b>Peticion</b></td>
							<td>Vecino Ruidoso</td>
							<td>Albero Sanabria</td>
							<td>Propietario</td>
							<td>Casa 2</td>
							<td>2018/01/12 </td>
							<td><span class="spanEstado light-green">Activo</span></td>
							<td><a href="{{url('Administrador/pqrs/1')}}" class="btn-floating cyan"><i class="material-icons">chat_bubble</i></a></td>
						</tr>
						<tr>
							<td>2</td>
							<td><b>Sugerencia</b></td>
							<td>Venta de sopa mañana</td>
							<td>rosa Maria Mendoza</td>
							<td>Arrendatario</td>
							<td>Casa 21</td>
							<td>2018/01/28 </td>
							<td><span class="spanEstado grey">Cerrado</span></td>
							<td><a href="{{url('Administrador/pqrs/2')}}" class="btn-floating cyan"><i class="material-icons">chat_bubble</i></a></td>
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
				console.log($('#inputDestinatario').material_chip('data')[0].tag);
				console.log($('[name=asunto]').val());
				console.log($('[name=tipo]').val());
				console.log($('[name=mensaje]').val());
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