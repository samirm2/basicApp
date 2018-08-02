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
					<!-- <a href='{{Route("pagos.generar",['mes'=>1])}}' class="btn light-green right">Generar Recibos <i class="material-icons left">note_add</i></a> -->
					<button class="btn dropdown-button light-green right" data-activates='listaMeses'><i class="material-icons left">note_add</i> Generar Recibos <i class="material-icons right">arrow_drop_down</i></button>
					<ul id="listaMeses" class="dropdown-content">
						@foreach($meses  as $mes)
							@if($mes->id == $mesActual)
							<li><a href="{{Route('pagos.generar',['mes'=>$mes->id])}}">{{$mes->nombre}}</a></li>
							@endif
						@endforeach
					</ul>


					<table class="striped">
						<thead>
							<tr>
								<th>N° de Factura</th>
								<th>Casa</th>
								<th>Mes</th>
								{{--  <th>Periodo</th>  --}}
								<th>Valor a Pagar</th>
								<th>Se Generó</th>
								<th>Estado</th>
								<th>Fecha de Pago</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
						@foreach($pagos as $pago)
							<tr>
							<td><b>{{$pago->id}}</b></td>
								<td>{{$pago->casa->nombre}}</td>
								<td>{{$pago->mesPago->nombre}}</td>
								{{--  <td>01/01/2018 - 31/01/2018</td>  --}}
								<td>{{$pago->valor}}</td>
								<td>{{$pago->created_at->diffForHumans()}}</td>
								@if($pago->estado == 'Pendiente')
									<td><span class="spanEstado yellow darken-2">{{$pago->estado}}</span></td>
								@else
									<td><span class="spanEstado green darken-1">{{$pago->estado}}</span></td>
								@endif
								
								<td>{{$pago->fecha_pago}}</td>
								<td>
									<a class="btn-floating"><i class="material-icons cyan">receipt</i></a>
									<a class="btn-floating"><i class="material-icons cyan">visibility</i></a>
								</td>
							</tr>
						@endforeach
							{{--  <td><b>23143</b></td>
								<td>Casa 1</td>
								<td>Enero</td>
								<td>01/01/2018 - 31/01/2018</td>
								<td>55.000</td>
								<td><span class="spanEstado yellow darken-2">Pendiente</span></td>
								<td>05/02/2018</td>
								<td>
									<a class="btn-floating"><i class="material-icons cyan">receipt</i></a>
									<a class="btn-floating"><i class="material-icons cyan">visibility</i></a>
								</td>  --}}
						</tbody>
					</table>
					{{$pagos->links()}}
				</div>
			</div>
		</div>
	</div>

	@include('layout._botonRojo')

	<div id="modal" class="modal modal-fixed-footer" style="width: 50%">
		<div class="modal-content" style="padding-bottom: 0">
			<h4>Registrar Pago</h4>
			<div class="divider"></div>
			<div class="row"></div>
			<span class="spanEstado right" id="spanEstado"></span>
			<div class="row valign-wrapper">
				<div class="input-field">
					<i class="material-icons prefix">dns</i>
					<input type="number" name="factura">
					<label for="factura">N° Factura</label>
				</div>
				<button id="btnBuscarFactura" class="btn-flat waves-effect" style="padding: 0px 5px"><i class="material-icons">search</i></button>
				</div>
				<div class="row">
				<div class="input-field col s6">
					<i class="material-icons prefix">home</i>
					<input type="text" name="casa">
					<label for="casa">Casa</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">date_range</i>
					<select name="mes">
						<option value='' selected disabled>Seleccione una opcion</option>
						@foreach($meses as $mes)
						<option value="{{$mes->id}}">{{$mes->nombre}}</option>
						@endforeach
					</select>
					<label for="mes">Mes a Liquidar</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">attach_money</i>
					<input type="text" name="valorPagar">
					<label for="valorPagar">Valor a Pagar</label>
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
			<a class="btn-flat modal-action modal-close">Cancelar <i class="material-icons right red-text">cancel</i></a>
			<a class="btn-flat waves-effect" id="btnRegistrarPago">Registrar <i class="material-icons right light-green-text">check_circle</i></a>
		</div>
	</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(function(){
		$('.dropdown-button').dropdown();
		$('#btnBuscarFactura').click(function(){
			if($('[name=factura]').val() == ''){
				Materialize.toast('Error, el campo esta vacio',2000,'red');
			}else{
				//alert('buscando');
				$.ajax({
					url:'/api/pagos/'+$('[name=factura]').val(),
					type:'get',
					dataType:'json',
					data:{'facturaId':$('[name=factura]').val()},
					success: function(rta){
						//console.log(rta);
						if(rta.pago == null){
							Materialize.toast('Factura no encontrada',2000,'red darken-1');
						}else{
							//$('[name=factura]').val(rta.pago.id);
							$('#spanEstado').text(rta.pago.estado);
							if(rta.pago.estado == 'Pendiente'){
								$('#spanEstado').addClass('yellow darken-1');
								$('#btnRegistrarPago').removeClass('disabled');
							}else{
								$('#spanEstado').addClass('green');
								$('#btnRegistrarPago').addClass('disabled');
							}
							$('[name=casa]').val(rta.casa.nombre);
							$('[name=casa]').attr('disabled',true);
							$('[name=valorPagar]').val(rta.pago.valor);
							$('[name=valorPagar]').attr('disabled',true);
							$('[name=mes]').val(rta.pago.mes_id);
							$('[name=mes]').attr('disabled',true);
							Materialize.updateTextFields();
							$('[name=mes]').material_select('update');
						}
					}
				});
			}
		});

		$('#btnRegistrarPago').click(function(){
			if($('[name=factura]').val() == ''){
				Materialize.toast('Error, No hay nada que facturar',2000,'red');
			}else{
				$.ajax({
					url: '{{Route("pagos.pagar")}}',
					type: 'post',
					data: {'facturaId' : $('[name=factura]').val(),'_token':'{{csrf_token()}}'},
					dataType: 'json',
					beforeSend:function(){
						$('#btnRegistrarPago').addClass('disabled');
					},
					success: function(rta){
						console.log(rta);
					},
					complete: function(){
						$('#btnRegistrarPago').removeClass('disabled');
					}
				});
			}
		});

		$('[name=abonar]').change(function(){
			if($(this).is(':checked')){
				$('#abonar').removeClass('hide');
			}else{
				$('#abonar').addClass('hide');
			}
		});
	});
</script>
@include('sweet::alert')
@endsection