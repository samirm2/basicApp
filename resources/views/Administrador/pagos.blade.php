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
							<option>Todo</option>
						</select>
						<label for="filtro">Mostar</label>
					</div>
					<table>
						<thead>
							<tr>
								<th>N° de Factura</th>
								<th>Casa</th>
								<th>Mes</th>
								<th>Periodo</th>
								<th>Valor a Pagar</th>
								<th>Estado</th>
								<th>Fecha de Pago</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<td>23143</td>
								<td>Casa 1</td>
								<td>Enero</td>
								<td>01/01/2018 - 31/01/2018</td>
								<td>55.000</td>
								<td><span class="spanEstado yellow darken-2">Pendiente</span></td>
								<td>05/02/2018</td>
								<td>
									<a class="btn-floating"><i class="material-icons cyan">receipt</i></a>
									<a class="btn-floating"><i class="material-icons cyan">visibility</i></a>
								</td>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	@include('layout._botonRojo')

	<div id="modal" class="modal modal-fixed-footer" style="width: 35%">
		<div class="modal-content" style="padding-bottom: 0">
			<h4>Registrar Pago</h4>
			<div class="divider"></div>
			<div class="row"></div>
			<div class="row">
				<div class="input-field col s6">
					<i class="material-icons prefix">dns</i>
					<input type="text" name="factura">
					<label for="factura">N° Factura</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">home</i>
					<input type="text" name="casa">
					<label for="casa">Casa</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">date_range</i>
					<input type="text" name="casa">
					<label for="casa">Mes a Liquidar</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">attach_money</i>
					<input type="text" name="casa">
					<label for="casa">Valor a Pagar</label>
				</div>
				<div class="row"></div>
					<div class="switch col s6">
						<span>Abonar</span><br>
				    <label>
				      No
				      <input name="abonar" type="checkbox">
				      <span class="lever"></span>
				      Si
				    </label>
				  </div>
				  <div id="abonar" class="hide">
				  <div class="input-field col s6">
				  	<i class="material-icons prefix">multiline_chart</i>
						<input type="text" name="casa">
						<label for="casa">Valor del Abono</label>
				  </div>
				  <div class="input-field col s6">
				  	<i class="material-icons prefix">monetization_on</i>
						<input type="text" name="casa">
						<label for="casa">Saldo Pendiente</label>
				  </div>
				  </div>
			</div>
		</div>
		<div class="modal-footer">
			<a class="btn-flat">Registrar</a>
			<a class="btn-flat modal-action modal-close">Cancelar</a>
		</div>
	</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(function(){
		$('[name=abonar]').change(function(){
			if($(this).is(':checked')){
				$('#abonar').removeClass('hide');
			}else{
				$('#abonar').addClass('hide');
			}
		});
	});
</script>
@endsection