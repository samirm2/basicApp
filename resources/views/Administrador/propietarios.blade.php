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
				<h3 class="center"><i class="material-icons small">face</i> Propietarios de Altos de Ziruma I</h3>
				<div class="divider"></div>
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
									<td></td>
								@else
									<td>{{$casa->miPropietario->persona->cedula}}</td>
									<td>{{$casa->miPropietario->persona->nombres}}</td>
									<td>{{$casa->miPropietario->persona->apellidos}}</td>
									<td>{{$casa->miPropietario->persona->telefono}}</td>
									<td>{{$casa->miPropietario->persona->email}}</td>
									<td>
										<a href="#modal" class="btnEditar modal-trigger btn-floating cyan" data-casa="{{$casa->nombre}}" data-cedula="{{$casa->miPropietario->persona->cedula}}" data-nombres="{{$casa->miPropietario->persona->nombres}}" data-apellidos="{{$casa->miPropietario->persona->apellidos}}" data-telefono="{{$casa->miPropietario->persona->telefono}}" data-email="{{$casa->miPropietario->persona->email}}" data-sexo="{{$casa->miPropietario->persona->sexo}}" data-nacimiento="{{$casa->miPropietario->persona->fecha_nacimiento}}" data-propietario_id="{{$casa->miPropietario->persona->id}}" data-usuario="{{$casa->miPropietario->persona->usuario->name}}"><i class="material-icons">edit</i></a>
									</td>
									<td>
										<form method="post" action="{{route('liberar.casa',$casa->id)}}">
											{{csrf_field()}}
										<button type="button" data-url="{{route('liberar.casa',$casa->id)}}" class="btnLiberar btn-floating lime"><i class="material-icons">compare_arrows</i></button>
										</form>
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
	@if($errors->any())
	 <ul class="hide" id="listadoErrores">
	 @foreach($errors->all() as $error)
	 	<li>{{$error}}</li>
	 @endforeach
	</ul>
	<script type="text/javascript">
		swal('Se produjeron los siguientes errores',$('#listadoErrores').text(),'error');
	</script>
	@endif

<script type="text/javascript">
	$(function(){
		$('#btnBuscar').click(function(){
			if ($('[name=cedula]').val() != ''){
				Materialize.toast('Buscando Persona',1500);
				$.ajax({
					url:'/api/personas/'+$('[name=cedula]').val(),
					type:'get',
					dataType: 'json',
					success: function(busqueda){
						// console.log(busqueda);
						if (busqueda.bandera == 0) {
							Materialize.toast('Persona no encontrada',3000,"red");
							limpiarModalNoCedula();
							$('#btnRegistro').html('Registrar <i class="material-icons light-green-text right">check_circle</i>');
							$('#btnRegistro').data('opcion','registrar');
						}else{
							Materialize.toast('¡Persona encontrada!',3000,"green");
							$('[name=cedula]').attr('readonly',true);
							$('#btnRegistro').html('Actualizar <i class="material-icons light-green-text right">autorenew</i>');
							$('#btnRegistro').data('opcion','actualizar');
							$("[name=persona_id]").val(busqueda.persona.id);
							$('[name=nombres]').val(busqueda.persona.nombres);
							$('[name=apellidos]').val(busqueda.persona.apellidos);
							$('[name=telefono]').val(busqueda.persona.telefono);
							$('[name=email]').val(busqueda.persona.email);
							$('[name=birthday]').val(busqueda.persona.fecha_nacimiento);
							$('[name=sexo]').val(busqueda.persona.sexo);
							$('[name=sexo]').material_select('update');
							$('[name=usuario]').val(busqueda.usuario.name);
							$('[name=password]').val('');
							$('[name=repeat-password]').val('');
							Materialize.updateTextFields();
							var array = [];
							for (casa in busqueda.casas){
								array.push({tag: busqueda.casas[casa].nombre});
							}
							$('[name=casa]').material_chip({
								data: array,
								autocompleteOptions: {
					   				data: casas,
					   		   limit: 3,
					   		   minLength: 1
					   		}
							});
							$('.chip').children('i').remove();
						}
					}
				});
			}else{
				Materialize.toast('No hay Nada que Buscar',3000,'red');
			}
		});

		$('#botonRojo').click(function(){
			$('#btnBuscar').show();
			limpiarModal();
			$("[name=password]").val('ziruma1');
			$("[name=repeat-password]").val('ziruma1');
			$("[name=cedula]").attr('readonly',false);
			Materialize.updateTextFields();
			$("[name=sexo]").material_select('update');
			$('#btnRegistro').html('Registrar <i class="material-icons light-green-text right">check_circle</i>');
			$('#btnRegistro').data('opcion','registrar');
		});

		$('.btnEditar').click(function(){
			$('#btnBuscar').hide();
			$('[name=casa]').material_chip({
				data: [{tag: $(this).data('casa')}],
			});
			$('.chip').children('i').remove();
			$('[name=casa]').children()[1].remove();
			$("[name=cedula]").val($(this).data('cedula'));
			$("[name=cedula]").attr('readonly',true);
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

		$('.btnLiberar').click(function(){
			swal({
				title: '¿Está Seguro?',
				text: 'una vez confirmada la opcion no podrá recuperar la información',
				icon: 'warning',
				buttons:['Cancelar','Eliminar'],
				dangerMode: true
			}).then((valor)=>{
				if(valor){
					$(this).parent().submit();
				}
			});
		});

		$('#btnRegistro').click(function(){
			var casasSubmit = [];
			if ($(this).data('opcion') == 'registrar') {
				//registara un propietario
				for (casa in $('[name=casa]').material_chip('data')){
					casasSubmit.push($('[name=casa]').material_chip('data')[casa].tag);
				}
				$("[name=casas]").val(casasSubmit);
				//se envia una peticion ajax
				$.ajax({
					method:'post',
					url:'Propietarios',
					data:{
						'_token':'{{csrf_token()}}',
						'cedula':$('[name=cedula]').val(),
						'nombres':$('[name=nombres]').val(),
						'apellidos':$('[name=apellidos]').val(),
						'sexo':$('[name=sexo]').val(),
						'birthday':$('[name=birthday]').val(),
						'telefono':$('[name=telefono]').val(),
						'email':$('[name=email]').val(),
						'usuario':$('[name=usuario]').val(),
						'password':$('[name=password]').val(),
						'password_confirmation':$('[name=repeat-password]').val(),
						'rol':$('[name=rol]').val(),
						'casas':$('[name=casas]').val()
					},
					dataType:'json',
					success:function(rta){
						// console.log(rta);
						if (rta.bandera == 0) {
							swal({
								icon: 'success',
								title: '¡Enhorabuena!',
								text: rta.mensaje
							}).then((value)=> {
								if (rta.casas.length > 0) {
									swal({
										icon: 'warning',
										title: '¡Atención!',
										text: rta.casas.toString()+", por lo tanto no se realizo la asociación de estas casas con este propietario"
									}).then((value)=> {
										window.location.reload();
									});	
								}else{
									window.location.reload();
								}
							});
						}else{
							swal({
								icon: 'error',
								title: rta.mensaje,
								text: rta.casas.toString()
							});
						}
					},
					error:function(rta){
						if (rta.status == 422) {
							var errores = rta.responseJSON.errors;
							// console.log(rta.responseJSON.errors);
							for (ob in errores){
								console.log(errores[ob][0]);
								Materialize.toast(errores[ob][0],3000);	
							}
						}
					}
				});
			}else{
				//actualizara un propietario
				for (casa in $('[name=casa]').material_chip('data')){
					casasSubmit.push($('[name=casa]').material_chip('data')[casa].tag);
				}
				$("[name=casas]").val(casasSubmit);
				Materialize.toast('Actulizando Propietario',3000);
				$.ajax({
					method:'post',
					url:'Propietarios/'+$('[name=persona_id]').val(),
					data:{
						'_token':'{{csrf_token()}}',
						'_method':'PUT',
						'cedula':$('[name=cedula]').val(),
						'nombres':$('[name=nombres]').val(),
						'apellidos':$('[name=apellidos]').val(),
						'sexo':$('[name=sexo]').val(),
						'birthday':$('[name=birthday]').val(),
						'telefono':$('[name=telefono]').val(),
						'email':$('[name=email]').val(),
						'usuario':$('[name=usuario]').val(),
						'password':$('[name=password]').val(),
						'password_confirmation':$('[name=repeat-password]').val(),
						'casas':$('[name=casas]').val()
					},
					dataType:'json',
					success:function(rta){
						console.log(rta);
					},
					error:function(rta){
						console.log(rta);
						// if (rta.status == 422) {
						// 	var errores = rta.responseJSON.errors;
						// 	console.log(rta.responseJSON.errors);
						// 	for (ob in errores){
						// 		console.log(errores[ob][0]);
						// 		Materialize.toast(errores[ob][0],3000);	
						// 	}
						// }
					}
				});
				// $('form').attr('action','Propietarios/'+$('[name=persona_id]').val());
				// $('form').submit();
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
		// console.log('lista de casas local');
		// console.log(casas);

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
			$('[name=casa]').material_chip({
				autocompleteOptions: {
	    	  data: casas,
	      	limit: 3,
	      	minLength: 1
		    }
			});
		}
		function limpiarModalNoCedula(){
			$("[name=nombres]").val('');
			$("[name=apellidos]").val('');
			$("[name=sexo]").val('Masculino');
			$("[name=birthday]").val('');
			$("[name=telefono]").val('');
			$("[name=email]").val('');
			$("[name=usuario]").val('');
			$('[name=casa]').material_chip({
				autocompleteOptions: {
	   			data: casas,
	   		  limit: 3,
	   		  minLength: 1
	   		}
			});
		}
	});
</script>
@include('sweet::alert')
@endsection
