@extends('layout.app')
@section('contenido')
	<div class="row">
		<div class="col s12">
			<div class="card-panel" style="padding-bottom: 0">
				<button id="btnImprimir" class="btn-floating cyan waves-effect right"><i class="material-icons">print</i></button>
				<div class="row valign-wrapper">
					<div class="col s3">
						<img class="responsive-img" src="{{asset('img/logo.png')}}">
					</div>
					<div class="col s9">
						<span class="center">
							<h4 style="margin: 0">Altos de Ziruma I</h4><h5 style="margin: 0">Conjunto Cerrado</h5><h6 style="margin: 0">Transversal 27 N° 52 - 30</h6>
						</span>
					</div>
				</div>
				<div class="row flow-text">
					<span class="right">Factura N°: <b>{{$pago->id}}</b></span> <br>
					<div class="divider"></div>
					<center>
						<h4 style="margin-bottom: 0px">Recibo de Pago</h4>
						<h5 style="margin-top: 0px">Couta de Administración</h5>
					</center>
					<div class="divider"></div>
					
					<span><b>Generado el:</b> {{explode(' ',$pago->created_at)[0]}}</span> 
					<span class="right"><b>Mes Facturado:</b> {{$pago->mesPago->nombre}}</span> <br>
					
					<span><b>Casa:</b> {{$pago->casa->nombre}}</span> 
					<span class="right"><b>Valor a Pagar: </b> ${{$pago->valor}}</span> <br>
					
					
					<span><b>Propietario: </b> {{$pago->casa->miPropietario->persona->nombreCompleto}}</span>
					<span class="right"><b>Estado:</b> {{$pago->estado}}</span> <br>
					
				</div>
				<div class="row" style="margin-bottom: 0">
					<center><img src="http://barcode.tec-it.com/barcode.ashx?data={{$pago->id}}&code=Code128&dpi=75">	</center>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(function(){
		$('#btnImprimir').click(function(){
			window.print();
		});
	});
</script>
@endsection