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
							<th>id</th>
							<th>Concepto</th>
							<th>Valor Pagado</th>
							<th>Fecha Y Hora</th>
							<th>Evidencia</th>
							<th>Opcion</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>Arreglo del porton</td>
							<td>125.000</td>
							<td>2018/01/12 15:21:01</td>
							<td>Evidencia</td>
							<td><a href="#" class="btn-floating cyan"><i class="material-icons">description</i></a></td>
						</tr>
						<tr>
							<td>2</td>
							<td>utencilios de oficina</td>
							<td>25.000</td>
							<td>2018/01/16 09:20:10</td>
							<td>Evidencia</td>
							<td><a href="#" class="btn-floating cyan"><i class="material-icons">description</i></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@include('layout._botonRojo')

<div id="modal" class="modal modal-fixed-footer" style="width: 40%">
	<div class="modal-content">
		<h4>Registro de Gastos</h4>
		<div class="divider"></div>
			<div class="row">
				<div class="input-field col s6">
					<i class="material-icons prefix">book</i>
					<input type="text" name="concepto">
					<label for="concepto">Concepto</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">monetization_on</i>
					<input type="number" name="valor">
					<label for="valor">Valor</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6">
					<input type="file" class="dropify" name="imagen">
					<label for="imagen">Evidencia</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">insert_comment</i>
					<textarea name="observaciones" class="materialize-textarea"></textarea>
					<label for="observaciones">Observaciones</label>
				</div>
			</div>	
	</div>
	<div class="modal-footer">
		<a href="#" class="btn-flat">Registrar</a>
		<a class="modal-action modal-close btn-flat">Cerrar</a>
	</div>
</div>

@endsection