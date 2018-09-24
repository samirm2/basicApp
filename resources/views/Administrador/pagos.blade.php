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
					<button class="btn dropdown-button light-green right" data-activates='listaMeses'><i class="material-icons left">note_add</i> Generar Recibos <i class="material-icons right">arrow_drop_down</i></button>
					<a href='#modalCasas' class="btn light-green right modal-trigger">Pagos Casas <i class="material-icons left">home</i></a>
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
								<th>Valor Pagado</th>
								<th>Saldo</th>
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
								<td>$ {{number_format($pago->valor)}}</td>
								<td>$ {{number_format($pago->valorPagado)}}</td>
								<td>$ {{number_format($pago->saldo)}}</td>
								<td>{{$pago->created_at->diffForHumans()}}</td>
								@if($pago->estado == 'Pendiente')
									<td><span class="spanEstado yellow darken-2">{{$pago->estado}}</span></td>
								@else
									<td><span class="spanEstado green darken-1">{{$pago->estado}}</span></td>
								@endif
								
								<td>{{$pago->fecha_pago}}</td>
								<td>
									{{--  <a class="btn-floating"><i class="material-icons cyan">receipt</i></a>  --}}
									<a class="btn-floating verFactura" href="{{Route('pagos.examinar',['id'=>$pago->id])}}"><i class="material-icons cyan">visibility</i></a>
								</td>
							</tr>
						@endforeach
							
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
			</div>
			
		</div>
		<div class="modal-footer">
			<a class="btn-flat modal-action modal-close">Cancelar <i class="material-icons right red-text">cancel</i></a>
			<a class="btn-flat waves-effect" id="btnRegistrarPago">Registrar <i class="material-icons right light-green-text">check_circle</i></a>
		</div>
	</div>

	<div class="modal modal-fixed-footer" id="modalCasas" style="width: 70%">
		<div class="modal-content">
			<h3>Pagos de Casa </h3>
			<div class="divider"></div>
			<div class="valign-wrapper">
					<div class="input-field col s12">
						<i class="material-icons prefix">home</i>
						<input type="number" id="inputBuscarCasa" min="1" max="60" style="width: 100px">
						<label for="inputBuscarCasa">Casa</label>
					</div>
					<button class="btn-floating cyan" id="btnBuscarPagosCasa"><i class="material-icons">search</i></button>
			</div>
			<table class="highlight bordered">
				<thead>
					<tr>
						<th>Factura N°</th>
						<th>Mes</th>
						<th>Valor a Pagar</th>
						<th>Valor Abonado</th>
						<th>Saldo Pendiente</th>
						<th>Estado</th>
						<th>Fecha de Pago</th>
						<th colspan="2">Acciones</th>
					</tr>
				</thead>
				<tbody id="tableCasaPago"></tbody>
			</table>
		</div>
		<div class="modal-footer">
			<button class="btn-flat modal-action modal-close">Cerrar <i class="material-icons left">close</i></button>
		</div>
	</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(function(){
		$('#btnBuscarPagosCasa').click(function(){
			if($('#inputBuscarCasa').val() == ''){
				Materialize.toast('No hay nada que buscar',1500,'red');
			}else{
				if($('#inputBuscarCasa').val() > 60 || $('#inputBuscarCasa').val() <= 0){
					Materialize.toast('Numero de casa invalido','1500','red');
				}else{
					$.ajax({
						url:'{{route("api.pagos.casas")}}',
						method:'get',
						data:{'casa': $('#inputBuscarCasa').val()},
						dataType:'json',
						success: function(rta){
							$('#tableCasaPago').html('');
							
							for (casa in rta){
								var color = 'green';
								var disable = 'disabled';
								if(rta[casa].fecha_pago == null){
									rta[casa].fecha_pago = '';
								}
								if(rta[casa].estado == 'Pendiente'){
									color = 'yellow darken-1';
									disable = '';
								}

								$('#tableCasaPago').append(
									'<tr><td>'+rta[casa].id+'</td>'+
										'<td>'+rta[casa].mes_pago.nombre+'</td>'+
										'<td> $'+rta[casa].valor+'</td>'+
										'<td> $'+rta[casa].valorPagado+'</td>'+
										'<td> $'+rta[casa].saldo+'</td>'+
										'<td><span class="spanEstado '+color+'">'+rta[casa].estado+'</span></td>'+
										'<td>'+rta[casa].fecha_pago +'</td>'+
										'<td><a href="./Pagos/'+rta[casa].id+'" class="btn-floating cyan verFactura"><i class="material-icons">visibility</i></a></td>'+
										'<td><button class="btn-floating cyan btnPagarCasa '+disable+'" data-casaId="'+rta[casa].id+'"><i class="material-icons">monetization_on</i></button></td></tr>'
								);
							}
						}
					});
				}
			}
		});
		
		$('body').on('click','.btnPagarCasa' ,function(){
			$.ajax({
					url: '{{Route("pagos.pagar")}}',
					type: 'post',
					data: {'facturaId' : $(this).data('casaid'),'_token':'{{csrf_token()}}'},
					dataType: 'json',
					success: function(rta){
						if(rta.bandera == 1){
							swal({
								icon: 'success',
								title: 'Pago registrado correctamente'
							}).then(value => {
								window.location.reload();
							});
						}
					}
				});
		});

		$('.dropdown-button').dropdown();
		
		$('body').on('click','.verFactura' ,function(){
			window.open($(this).attr('href'),'pago','height=500,width=750');
			return false;
		});

		$('#botonRojo').click(function(){
			$('#btnRegistrarPago').addClass('disabled');
			$('[name=factura]').val(null);
			$('[name=casa]').val(null);
			$('[name=casa]').attr('disabled',false);
			$('[name=mes]').val(null);
			$('[name=mes]').attr('disabled',false);
			$('[name=valorPagar]').val(null);
			$('[name=valorPagar]').attr('disabled',false);
			$('[name=mes]').material_select('update');
			Materialize.updateTextFields();
			$('#spanEstado').text('');
			$('#spanEstado').removeClass('yellow darken-2 green');
		});
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
						if(rta.bandera == 1){
							swal({
								icon: 'success',
								title: 'Pago registrado correctamente'
							}).then(value => {
								window.location.reload();
							});
						}
					}
				});
			}
		});
	});
</script>
@include('sweet::alert')
@endsection
