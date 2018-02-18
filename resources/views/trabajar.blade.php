@extends('layout.app')
@section('contenido')
	<div class="navbar-fixed">
		<nav class="white">		
			<span class="brand-logo">
				<a href="http://altosdeziruma.000webhostapp.com"><img src="{{asset('img/logo.png')}}" height="60"></a>
			</span>
		</nav>
	</div>

	@include('layout._mostrarMensajeFlash')

	<div class="container">
		<div class="row" style="margin-top: 20px">
			<i class="material-icons left medium">work</i> <h2>Ofertas de Empleo</h2>
			<div class="col s12">
				@foreach($arrayEmpleos as $empleo)
					@if($empleo->estado == 'Activo')
						<div class="card-panel">
							<h5>{{$empleo->cargo}}</h5>
							<p>{{$empleo->descripcion}}. <b>Salario: </b>{{$empleo->salario}} pesos {{$empleo->tipo_salario}}
							<b>Tiempo del contrato: </b>{{$empleo->duracion ." ". $empleo->tipo_duracion}}.</p>
							<button class="btn-flat right btnPostularme" data-empleoid='{{$empleo->id}}'><i class="material-icons left">spellcheck</i>Postularme</button>
							<br>
						</div>
					@endif
				@endforeach
			</div>
		</div>
	</div>
	<div id="modal" class="modal" style="width: 40%">
		<div class="modal-content" style="padding-bottom: 0px">
			<h4>Datos del Postulante</h4>
			<div class="divider"></div>
			<div class="row">
			<form method="post" action="{{url('/postularme')}}" enctype="multipart/form-data">
				{{csrf_field()}}
				<input type="hidden" name="empleo">
				<div class="input-field col s6">
					<i class="material-icons prefix red-text">label_outline</i>
					<input type="text" name="nombres">
					<label for="nombres">Nombres</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix red-text">label</i>
					<input type="text" name="apellidos">
					<label for="apellidos">Apellidos</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix red-text">mail</i>
					<input type="text" name="email">
					<label for="email">Correo Electronico</label>
				</div>
				<div class="input-field col s6">
					<input type="file" name="archivo" class="dropify" data-allowed-file-extensions="pdf docx">
					<label for="Hoja de vida">Hoja de Vida</label>
				</div>
				
				<span class="red-text" style="font-size: 0.9rem"><b>Recuerde: </b>Los Campos que tienen el icono en color rojo, son campos obligatorios. Debe adjuntar su hoja de vida en el campo indicado. el tipo de archivo aceptado será .pdf o .docx.</span>
				
			</div>
		</div>
		<div class="modal-footer">
			<a class="btn-flat modal-action modal-close">Cancelar <i class="material-icons right red-text">cancel</i></a>
			<button type="button" id="btnEnviar" class="btn-flat">Enviar <i class="material-icons right light-green-text">check_circle</i></button>
		</div>
		</form>
	</div>
@endsection
@section('scripts')
<script>
	$(function(){
		$('.btnPostularme').click(function(){
			$('[name=empleo]').val($(this).data('empleoid'));
			$('#modal').modal('open');
		});

		$('#btnEnviar').click(function(){
			if( $('[name=nombres]').val() == '' || $('[name=apellidos]').val() == '' || $('[name=email]').val() == '' || $('[name=archivo]').val() == '' ){
				Materialize.toast('Error, Faltan campos por llenar',3000);
			}else{
				$('form').submit();
			}
		});
	});
</script>
@endsection