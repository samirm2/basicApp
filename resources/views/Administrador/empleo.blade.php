@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection
@section('contenido')
	<div class="caja">

		@include('layout._mostrarMensajeFlash')

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
								<th>Opciones</th>
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
									<a class="btn-floating light-blue tooltipped" data-tooltip="Examinar" data-position="botton" data-delay="50"><i class="material-icons">find_in_page</i></a>
									<a href="{{url('Administrador/Empleo/'.$empleo->id)}}" class="btn-floating light-blue tooltipped" data-tooltip="ver aspirantes" data-position="botton" data-delay="50"><i class="material-icons">class</i></a>
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
		<form method="post" action="{{route('empleo.guardar')}}">
			{{csrf_field()}}
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
						<option>Dias</option>
						<option>Semanas</option>
						<option>Meses</option>
						<option>Anos</option>
					</select>
					<label for="tipo_duracion">tipo</label>
				</div>
			</div>
			<span class="red-text" style="font-size: 0.9rem">Nota: Los contratos celebrados son de prestación de servicio</span>
		</div>
		<div class="modal-footer">
			<a class="btn-flat modal-action modal-close">Cancelar <i class="material-icons red-text right">cancel</i></a>
			<button class="btn-flat">Registrar <i class="material-icons light-green-text right">check_circle</i></button>
		</div>
	</form>
	</div>
@endsection

@section('scripts')
<script>
	$(function(){
		$('.btnEliminar').click(function(){
			if(confirm('¿Esta seguro de eliminar este empleo?')){
				$(this).parent().submit();
			}
		});
	});
</script>
@endsection