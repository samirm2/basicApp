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
								<th>Opciones</th>
							</tr>
						</thead>
						<tbody>
							<td>0001</td>
							<td>Pintor</td>
							<td>120.000</td>
							<td>5 dias</td>
							<td>08/02/2018</td>
							<td><b>4</b></td>
							<td><span class="spanEstado lime">Activo</span></td>
							<td>
								<a class="btn-floating light-blue"><i class="material-icons">find_in_page</i></a>
								<a href="{{url('Administrador/Empleo/1')}}" class="btn-floating light-blue"><i class="material-icons">class</i></a>
								<a class="btn-floating light-blue"><i class="material-icons">delete</i></a>
							</td>
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
				<div class="input-field col s6">
					<i class="material-icons prefix">work</i>
					<input type="text" name="a">
					<label for="a">Cargo</label>
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
					<textarea name="b" class="materialize-textarea"></textarea>
					<label for="b">Descripción</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">attach_money</i>
					<input type="number" name="a">
					<label for="a">Salario</label>
				</div>
				<div class="input-field col s6">
					<select name="aa">
						<option>Semanal</option>
						<option>Mensual</option>
					</select>
					<label for="aa">tipo</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">update</i>
					<select name="c">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
					</select>
					<label for="c">Duración del Contrato</label>
				</div>
				<div class="input-field col s6">
					<select name="aa">
						<option>Días</option>
						<option>Semanas</option>
						<option>Meses</option>
						<option>Años</option>
					</select>
					<label for="aa">tipo</label>
				</div>
			</div>
			<span class="red-text" style="font-size: 0.9rem">Nota: Los contratos celebrados son de prestación de servicio</span>
		</div>
		<div class="modal-footer">
			<a class="btn-flat modal-action modal-close">Cancelar <i class="material-icons red-text right">cancel</i></a>
			<a class="btn-flat">Registrar <i class="material-icons light-green-text right">check_circle</i></a>
		</div>
	</div>
@endsection