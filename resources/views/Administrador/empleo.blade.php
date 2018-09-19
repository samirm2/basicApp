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
								<th>Cargo</th>
								<th>Salario</th>
								<th>Tiempo de Contratación</th>
								<th>Fecha de Publicación</th>
								<th>Aspirantes</th>
								<th>Estado</th>
								<th colspan="2">Opciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($arrayEmpleos as $empleo)
							<tr>
								<td>{{$empleo->id}}</td>
								<td>{{$empleo->cargo}}</td>
								<td>{{$empleo->salario}}</td>
								<td>{{$empleo->duracion ." ". $empleo->tipo_duracion}}</td>
								<td>{{$empleo->created_at->diffForHumans()}}</td>
								<td><b>{{$empleo->aspirantes()->count()}}</b></td>
								<td><span class="spanEstado {{($empleo->estado == 'Activo') ? 'lime': 'grey'}}">{{$empleo->estado}}</span></td>
								<td>
									<a class="btn-floating light-blue tooltipped btnExaminar" data-tooltip="Examinar" data-position="botton" data-delay="50" data-empleo_id="{{$empleo->id}}" data-cargo="{{$empleo->cargo}}" data-descripcion="{{$empleo->descripcion}}" data-salario="{{$empleo->salario}}" data-tipo_salario="{{$empleo->tipo_salario}}" data-duracion="{{$empleo->duracion}}" data-tipo_duracion="{{$empleo->tipo_duracion}}" data-estado="{{$empleo->estado}}"><i class="material-icons">find_in_page</i></a>
									
									<a href="{{url('Administrador/Empleo/'.$empleo->id)}}" class="btn-floating light-blue tooltipped" data-tooltip="ver aspirantes" data-position="botton" data-delay="50"><i class="material-icons">class</i></a>
								</td>
								<td>
									<form method="post" action="{{route('empleo.eliminar',['id'=>$empleo->id])}}">
										{{csrf_field()}}
										{{method_field('DELETE')}}
										<button type="button" class="btnEliminar btn-floating light-blue tooltipped" data-tooltip="Eliminar" data-position="botton" data-delay="50"><i class="material-icons">delete</i></button>
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	@include('layout._botonRojo')
	
	<div class="modal  modal-fixed-footer" id="modal" style="width: 40%">
		<div class="modal-content" style="padding-bottom: 0px">
			<h4>Registrar Vacante</h4>
			<div class="divider"></div>
			<div class="row">
		<form id="formModal" method="post" action="{{route('empleo.guardar')}}">
			{{csrf_field()}}
			{{method_field('PUT')}}
			<input type="hidden" name="empleo_id">
				<div class="input-field col s6">
					<i class="material-icons prefix">work</i>
					<input type="text" name="cargo" value="{{old('cargo')}}">
					<label for="cargo">Cargo</label>
				</div>
				<div class="input-field col s6">
					<select name="estado">
						<option>Activo</option>
						<option>Inactivo</option>
					</select>
					<label for="estado">Estado</label>
				</div>
				<div class="input-field col s12">
					<i class="material-icons prefix">chat</i>
					<textarea name="descripcion" class="materialize-textarea">{{old('descripcion')}}</textarea>
					<label for="descripcion">Descripción</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">attach_money</i>
					<input type="number" name="salario" value="{{old('salario')}}">
					<label for="salario">Salario</label>
				</div>
				<div class="input-field col s6">
					<select name="tipo_salario">
						<option>Diario</option>
						<option>Semanal</option>
						<option>Mensual</option>
					</select>
					<label for="tipo_salario">tipo</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">update</i>
					<select name="duracion">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
					</select>
					<label for="duracion">Duración del Contrato</label>
				</div>
				<div class="input-field col s6">
					<select name="tipo_duracion">
						<option>Dia(s)</option>
						<option>Semana(s)</option>
						<option>Mes(es)</option>
						<option>Año(s)</option>
					</select>
					<label for="tipo_duracion">tipo</label>
				</div>
			</div>
			<span class="red-text nota"><b>Nota:</b> Los contratos celebrados son de prestación de servicio</span>
		</div>
		<div class="modal-footer">
			<a class="btn-flat modal-action modal-close">Cancelar <i class="material-icons red-text right">cancel</i></a>
			<button type="button" id="btnRegistro" class="btn-flat" data-opcion="registrar">Registrar <i class="material-icons light-green-text right">check_circle</i></button>
		</div>
	</form>
	</div>
@endsection

@section('scripts')
<script>
	$(function(){
		$('#botonRojo').click(function(){
			limpiarModal();
			Materialize.updateTextFields();
			$('#btnRegistro').html('Registrar <i class="material-icons light-green-text right">check_circle</i>');
			$('#btnRegistro').data('opcion','registrar');
		});

		$('#btnRegistro').click(function(){
			if ($(this).data('opcion') == 'registrar') {
				//registro un empleo
				if(validarCampos() == 0){
					$('[name=_method]').remove();
					$('#formModal').submit();
				}
			}else{
				//actualizo un empleo existente
				$('#formModal').attr('action','Empleo/'+$('[name=empleo_id]').val());
				if (validarCampos() == 0) {
					$('#formModal').submit();		
				}
			}
		});

		$('.btnEliminar').click(function(){
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
			// if(confirm('¿Esta seguro de eliminar este empleo?')){
			// 	$(this).parent().submit();
			// }
		});

		$('.btnExaminar').click(function(){
			$('[name=empleo_id]').val($(this).data('empleo_id'));
			$('[name=estado]').val($(this).data('estado'));
			$('[name=cargo]').val($(this).data('cargo'));
			$('[name=descripcion]').val($(this).data('descripcion'));
			$('[name=salario]').val($(this).data('salario'));
			$('[name=tipo_salario]').val($(this).data('tipo_salario'));
			$('[name=duracion]').val($(this).data('duracion'));
			$('[name=tipo_duracion]').val($(this).data('tipo_duracion'));
			Materialize.updateTextFields();
			$('select').material_select('update');
			$('#btnRegistro').html('Actualizar <i class="material-icons light-green-text right">autorenew</i>');
			$('#btnRegistro').data('opcion','actualizar');
			$('#modal').modal('open');
		});

		function limpiarModal(){
			$('[name=estado]').val('Activo');
			$('[name=empleo_id]').val('');
			$('[name=cargo]').val('');
			$('[name=descripcion]').val('');
			$('[name=salario]').val('');
			$('[name=tipo_salario]').val('Diario');
			$('[name=duracion]').val('1');
			$('[name=tipo_duracion]').val('Dia(s)');
			$('select').material_select('update');
		}
	});
	function validarCampos(){
		var bandera = 0;	
		if($('[name=cargo]').val() == ''){
			Materialize.toast('el campo Cargo esta vacio, verifique',3000);
			bandera++;
		}
		if ($('[name=descripcion]').val() == '') {
			Materialize.toast('el campo Descripción esta vacio, verifique',3000);
			bandera++;
		}
		if ($('[name=salario]').val() == '') {
			Materialize.toast('el campo Salario esta vacio, verifique',3000);
			bandera++;
		}
		return bandera;
	}
</script>
@include('sweet::alert')
@endsection