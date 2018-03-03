@extends('layout.app')
@section('sidenav')
 @include('layout.sideNav')
@endsection

@section('contenido')
<div class="caja">
	<div class="row">
		<div class="col s12">
			@include('layout._mostrarMensajeFlash')
			<div class="card-panel">
				<table class="striped">
					<thead>
						<tr>
							<th>Casa</th>
							<th>Cedula</th>
							<th>Nombres</th>
							<th>Apellidos</th>
							<th>Telefono</th>
							<th>Correo Electronico</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($listadoCasas as $casa)
							<tr>
								<td><b>{{$casa->nombre}}</b></td>
								@if(is_null($casa->miPropietario))
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>
										{{-- <a href="#modal" class="btnEditar modal-trigger btn-floating cyan" data-casa="{{$casa->nombre}}"><i class="material-icons">edit</i></a> --}}
										{{-- <a href="#" class="btn-floating"><i class="material-icons">delete</i></a> --}}
									</td>
								@else
									<td>{{$casa->miPropietario->persona->cedula}}</td>
									<td>{{$casa->miPropietario->persona->nombres}}</td>
									<td>{{$casa->miPropietario->persona->apellidos}}</td>
									<td>{{$casa->miPropietario->persona->telefono}}</td>
									<td>{{$casa->miPropietario->persona->email}}</td>
									<td>
										<a href="#modal" class="btnEditar modal-trigger btn-floating cyan" data-casa="{{$casa->nombre}}" data-cedula="{{$casa->miPropietario->persona->cedula}}" data-nombres="{{$casa->miPropietario->persona->nombres}}" data-apellidos="{{$casa->miPropietario->persona->apellidos}}" data-telefono="{{$casa->miPropietario->persona->telefono}}" data-email="{{$casa->miPropietario->persona->email}}" data-sexo="{{$casa->miPropietario->persona->sexo}}" data-nacimiento="{{$casa->miPropietario->persona->fecha_nacimiento}}" data-propietario_id="{{$casa->miPropietario->persona->id}}" data-usuario="{{$casa->miPropietario->persona->usuario->name}}"><i class="material-icons">edit</i></a>
										{{-- <a href="#" class="btn-floating"><i class="material-icons">delete</i></a> --}}
									</td>
								@endif
							</tr>
						@endforeach
					</tbody>
				</table>
				{{$listadoCasas->links()}}
			</div>
		</div>
	</div>	
</div>

@include('layout._botonRojo')

@include('layout._formRegistrarPersona')

@endsection

@section('scripts')
<script type="text/javascript">
	$(function(){
		$('#btnBuscar').click(function(){
			if ($('[name=cedula]').val() != ''){
				Materialize.toast('Buscando Persona',1500);
				$.ajax({
					url:'/api/personas/'+$('[name=cedula]').val(),
					// url: '/api/casas',
					type:'get',
					dataType: 'json',
					success: function(persona){
						console.log(persona);
					// 	if (persona.bandera == 0) {
					// 		Materialize.toast('Persona no encontrada',2000);
					// 		limpiarModal();
					// 	}else{
					// 		$('[name=nombres]').val(persona.datos.nombres);
					// 		$('[name=apellidos]').val(persona.datos.apellidos);
					// 		$('[name=telefono]').val(persona.datos.telefono);
					// 		$('[name=email]').val(persona.datos.email);
					// 		$('[name=birthday]').val(persona.datos.fecha_nacimiento);
					// 		$('[name=sexo]').val(persona.datos.sexo);
					// 		$('[name=sexo]').material_select('update');
					// 		Materialize.updateTextFields();
					// 	}
					}
				});
			}
		});

		$('#botonRojo').click(function(){
			$('#btnBuscar').show();
			limpiarModal();
			$('[name=casa]').material_chip({
				autocompleteOptions: {
		    	  data: casas,
		      	limit: 3,
		      	minLength: 1
		    	}
			});
			$("[name=password]").val('ziruma1');
			$("[name=repeat-password]").val('ziruma1');
			Materialize.updateTextFields();
			$("[name=sexo]").material_select('update');
			$('#btnRegistro').html('Registrar <i class="material-icons light-green-text right">check_circle</i>');
			$('#btnRegistro').data('opcion','registrar');
		});

		$('.btnEditar').click(function(){
			$('#btnBuscar').hide();
			$('[name=casa]').material_chip({
				data: [{tag: $(this).data('casa')}],
				// autocompleteOptions: {
	   //  	  data: casas,
	   //    	limit: 3,
	   //    	minLength: 1
	   //  	}
			});
			$('[name=casa]').children()[1].remove()
			$("[name=cedula]").val($(this).data('cedula'));
			$("[name=nombres]").val($(this).data('nombres'));
			$("[name=apellidos]").val($(this).data('apellidos'));
			$("[name=sexo]").val($(this).data('sexo'));
			$("[name=birthday]").val($(this).data('nacimiento'));
			$("[name=telefono]").val($(this).data('telefono'));
			$("[name=email]").val($(this).data('email'));
			$("[name=persona_id]").val($(this).data('propietario_id'));
			$("[name=usuario]").val($(this).data('usuario'));
			$("[name=password]").val('');
			$("[name=repeat-password]").val('');
			Materialize.updateTextFields();
			$("[name=sexo]").material_select('update');
			$('#btnRegistro').html('Actualizar <i class="material-icons light-green-text right">autorenew</i>');
			$('#btnRegistro').data('opcion','actualizar');
		});

		$('#btnRegistro').click(function(){
			var casasSubmit = [];
			if ($(this).data('opcion') == 'registrar') {
				//registara un propietario
				for (casa in $('[name=casa]').material_chip('data')){
					casasSubmit.push($('[name=casa]').material_chip('data')[casa].tag);
				}
				$("[name=casas]").val(casasSubmit);
				$('[name=_method]').remove();
				$('form').submit();
			}else{
				//actualizara un propietario
				for (casa in $('[name=casa]').material_chip('data')){
					casasSubmit.push($('[name=casa]').material_chip('data')[casa].tag);
				}
				$("[name=casas]").val(casasSubmit);
				Materialize.toast('Actulizando Propietario',3000);
				$('form').attr('action','Propietarios/'+$('[name=persona_id]').val());
				$('form').submit();
			}
		});

		var casas='{';
		for (i=0;i<60;i++){
			casas += '"Casa '+(i+1) + '":' + null + ",";
		}
		casas = casas.split('');
		casas[casas.length-1] = "}";
		casas = casas.join("");
		casas = JSON.parse(casas);		
		console.log('lista de casas local');
		console.log(casas);

		//estableciendo el username
		$('[name=apellidos]').change(function(){
			$('[name=usuario]').val($('[name=nombres]').val()[0]+$('[name=apellidos]').val().split(" ")[0]);
			Materialize.updateTextFields();
		});

		function limpiarModal(){
			$("[name=cedula]").val('');
			$("[name=nombres]").val('');
			$("[name=apellidos]").val('');
			$("[name=sexo]").val('Masculino');
			$("[name=birthday]").val('');
			$("[name=telefono]").val('');
			$("[name=email]").val('');
			$("[name=usuario]").val('');
		}
	});
</script>
@include('sweet::alert')
@endsection
