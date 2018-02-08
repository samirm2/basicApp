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
						<select name="Miscasas">
							<option>Todo</option>
							<option>Casa 2</option>
							<option>Casa 12</option>
						</select>
						<label for="Miscasas">Mostrar</label>
					</div>
					<table class="striped">
						<thead>
							<tr>
								<th>Consecutivo</th>
								<th>Casa N°</th>
								<th>Mes</th>
								<th>Periodo</th>
								<th>Valor a Pagar</th>
								<th>Estado</th>
								<th>Fecha de Pago</th>
								<th>Accion</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>89712</td>
								<td>Casa 12</td>
								<td>Enero</td>
								<td>01/01/2018 - 31/01/2018</td>
								<td>55.000</td>
								<td><span class="light-green spanEstado">Pagado</span></td>
								<td>02/02/2018</td>
								<td>
									<a href="{{url('Propietario/pagos/89712')}}" target="_blank" class="btn-floating cyan verRecibo"><i class="material-icons">visibility</i></a>
								</td>
							</tr>
							<tr>
								<td>14523</td>
								<td>Casa 2</td>
								<td>Enero</td>
								<td>01/01/2018 - 31/01/2018</td>
								<td>55.000</td>
								<td><span class="red spanEstado">Pendiente</span></td>
								<td></td>
								<td>
									<a href="{{url('Propietario/pagos/14523')}}" target="_blank" class="btn-floating cyan verRecibo"><i class="material-icons">visibility</i></a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(function(){
		$('.verRecibo').click(function(){
			window.open($(this).attr('href'),'pago','height=500,width=750');
			return false;
		});
	});
</script>
@endsection
