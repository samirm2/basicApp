<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Altos de Ziruma I</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/materialize.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/material-icons.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/dropify.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/estilos.css')}}">
	<link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
	<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/materialize.min.js')}}"></script>
<script src="{{asset('js/init.js')}}"></script>
<script src="{{asset('js/dropify.min.js')}}"></script>
<script src="{{asset('js/sweetAlert.min.js')}}"></script>
</head>
	<div class="row">
		<div class="col s12">
			<div class="card-panel" style="padding-bottom: 0">
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
					<span class="right">Factura N°: {{date('YmdHis')}}<b></b></span> <br>
					<div class="divider"></div>
					<center>
						<h4 style="margin-bottom: 0px">Recibo de Pago</h4>
						<h5 style="margin-top: 0px">Prestación de Servicios</h5>
					</center>
					<div class="divider"></div>
					<div class="row">
						<span><b>Generado el:</b> {{date('Y-m-d H:i:s')}}</span>
						<span class="right"><b>Valor: </b> $ {{number_format($valor)}}</span>
					</div>
					<div class="row">
						<span><b>Concepto:</b> {{$concepto}}</span> 
					</div>
					<div class="row">
						<span><b>Observaciones: </b> {{$observaciones}}</span>
					</div>

					<div class="row" style="margin-bottom: 0">
						<center><img src="/uploads/gastos/code.png"></center>
					</div>
				</div>
				
			</div>
		</div>
	</div>