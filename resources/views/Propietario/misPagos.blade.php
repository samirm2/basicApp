@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection

@section('contenido')
	<div class="caja">
		<div class="row">
			<div class="col s12">
				<div class="card-panel">
					@if($casas->count() > 1)
					<div class="input-field col s3">
						<select name="misCasas">
							<option value="null">Todo</option>
							@foreach($casas as $casa)
							<option value="{{$casa->id}}" >{{$casa->nombre}}</option>
							@endforeach
						</select>
						<label for="Miscasas">Mostrar</label>
					</div>
					@endif
					<table class="striped">
						<thead>
							<tr>
								<th>Consecutivo</th>
								<th>Casa N°</th>
								<th>Mes</th>
								<th>Valor a Pagar</th>
								<th>Estado</th>
								<th>Fecha de Pago</th>
								<th>Accion</th>
							</tr>
						</thead>
						<tbody>
							@foreach($pagos as $pago)
							<tr>
								<td>{{$pago->id}}</td>
								<td><b>{{$pago->casa->nombre}}</b></td>
								<td>{{$pago->mesPago->nombre}}</td>
								<td> $ {{ number_format($pago->valor)}}</td>
								@if($pago->estado == 'Pendiente')
									<td><span class="spanEstado yellow darken-2">{{$pago->estado}}</span></td>
								@else
									<td><span class="spanEstado green darken-1">{{$pago->estado}}</span></td>
								@endif
								<td>{{$pago->fecha_pago}}</td>
								<td>
									<a href="{{url('Propietario/Pagos',['id'=>$pago->id])}}" target="_blank" class="btn-floating cyan verRecibo"><i class="material-icons">visibility</i></a>
								</td>
							</tr>
							@endforeach
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
		$('[name=misCasas]').change(function(){
			alert($(this).val());
		});
		
		$('.verRecibo').click(function(){
			window.open($(this).attr('href'),'pago','height=500,width=750');
			return false;
		});
	});
</script>
@endsection
