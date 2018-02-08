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
					<div class="col s8">
						<span class="center">
							<h4 style="margin: 0">Altos de Ziruma I</h4><h5 style="margin: 0">Conjunto Cerrado</h5><h6 style="margin: 0">Transversal 27 N° 52 - 30</h6>
						</span>
					</div>
				</div>
				<div class="row flow-text">
					<span class="right">Factura N°: <b>{{$pago}}</b></span> <br>
					<h4 class="center">Recibo de Pago de Administración</h4>
					<div class="row"></div>
					<span><b>Fecha:</b> 2018/10/21</span> 
					<span class="right"><b>Estado:</b> Pendiente</span><br>
					<span class="right"><b>Mes:</b> Diciembre</span> 
					<span><b>Casa:</b> Casa 21</span> <br>
					<span><b>Propietario: </b> Maria Paula Romero Lopez</span>
					<span class="right"><b>Valor a Pagar:</b> $55.000</span>
				</div>
				<div class="row" style="margin-bottom: 0">
					<center><img src="http://barcode.tec-it.com/barcode.ashx?data={{$pago}}&code=Code128&dpi=75">	</center>
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