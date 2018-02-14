@extends('layout.app')
@section('contenido')
	<div class="navbar-fixed">
	<nav class="white">		
		<span class="brand-logo">
			<a href="http://altosdeziruma.000webhostapp.com"><img src="{{asset('img/logo.png')}}" height="60"></a>
		</span>
	</nav>
	</div>
	<div class="container">
		<div class="row" style="margin-top: 20px">
			<i class="material-icons left medium">work</i> <h2>Ofertas de Empleo</h2>
			<div class="col s12">
				<div class="card-panel">
					<h5>Pintor</h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. <b>Salario: </b>Ut enim ad minim veniam,
					<b>Tiempo del contrato: </b>quis nostrud exercitation.</p>
					<a href="#modal" class="btn-flat modal-trigger right"><i class="material-icons left">spellcheck</i>Postularme</a>
					<br>
				</div>
				<div class="card-panel">
					<h5>Cerrajero</h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. <b>Salario: </b>Ut enim ad minim veniam,
					<b>Tiempo del contrato: </b>quis nostrud exercitation.</p>
					<a href="#modal" class="btn-flat modal-trigger right"><i class="material-icons left">spellcheck</i>Postularme</a>
					<br>
				</div>
				<div class="card-panel">
					<h5>Utilero</h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. <b>Salario: </b>Ut enim ad minim veniam,
					<b>Tiempo del contrato: </b>quis nostrud exercitation.</p>
					<a href="#modal" class="btn-flat modal-trigger right"><i class="material-icons left">spellcheck</i>Postularme</a>
					<br>
				</div>
				<div class="card-panel">
					<h5>Electricista</h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. <b>Salario: </b>Ut enim ad minim veniam,
					<b>Tiempo del contrato: </b>quis nostrud exercitation.</p>
					<a href="#modal" class="btn-flat modal-trigger right"><i class="material-icons left">spellcheck</i>Postularme</a>
					<br>
				</div>
				<div class="card-panel">
					<h5>Tecnico en telecomunicaciones</h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. <b>Salario: </b>Ut enim ad minim veniam,
					<b>Tiempo del contrato: </b>quis nostrud exercitation.</p>
					<a href="#modal" class="btn-flat modal-trigger right"><i class="material-icons left">spellcheck</i>Postularme</a>
					<br>
				</div>
			</div>
		</div>
	</div>
	<div id="modal" class="modal" style="width: 40%">
		<div class="modal-content" style="padding-bottom: 0px">
			<h4>Datos del Postulante</h4>
			<div class="divider"></div>
			<div class="row">
				<div class="input-field col s6">
					<i class="material-icons prefix">label_outline</i>
					<input type="text" name="nombres">
					<label for="nombres">Nombres</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">label</i>
					<input type="text" name="apellidos">
					<label for="apellidos">Apellidos</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">mail</i>
					<input type="text" name="email">
					<label for="email">Correo Electronico</label>
				</div>
				<div class="input-field col s6">
					<input type="file" name="archivo" class="dropify" data-allowed-file-extensions="pdf docx">
					<label for="Hoja de vida">Hoja de Vida</label>
				</div>
				
				<span class="red-text" style="font-size: 0.9rem"><b>Recuerde:</b> Debe adjuntar su hoja de vida en el campo indicado. el tipo de archivo aceptado será .pdf o .docx. Si adjunta un archivo con una extensión distinta a las ya mencionadas <b>NO</b> se tendra en cuenta la postulación</span>
				
			</div>
		</div>
		<div class="modal-footer">
			<a class="btn-flat modal-action modal-close">Cancelar <i class="material-icons right red-text">cancel</i></a>
			<a class="btn-flat">Enviar <i class="material-icons right light-green-text">check_circle</i></a>
		</div>
	</div>
@endsection