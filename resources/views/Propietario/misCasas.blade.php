@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection
@section('contenido')
	<div class="caja">
		<div class="row">
			@foreach($listaCasas as $casa)
				<div class="col l5 m6 s10 offset-s1">
						<div class="card">
							<div class="card-content">
								<span class="card-title"><i class="material-icons medium left">home</i>{{$casa->nombre}}</span>
								<div class="row"></div>
								@if( $casa->arrendatario )
									<p>
										Cedula: {{$casa->arrendatario['cedula']}}<br>
										Nombres: {{$casa->arrendatario['nombres']}}<br>
										Apellidos: {{$casa->arrendatario['apellidos']}}<br>
										Telefono: {{$casa->arrendatario['telefono']}}<br>
										Correo Electronico: {{$casa->arrendatario['email']}}<br> <br>
									</p>
								@else
									<p>
										<i>No hay arrendatario</i><br> <br>
									</p>
								@endif
								<p>
									Deuda: $ {{ number_format($casa->valorCuantia) }}
								</p>
							</div>
							<div class="card-action">
								@if( $casa->arrendatario )
									<a href="#modal_delete" class="blue-text modal-trigger" onclick="setIdCasaLibre('{{$casa->id}}')">Liberar</a>
								@else
									<a href="#modal" class="blue-text modal-trigger" onclick="setIdCasa('{{$casa->id}}')">Arrendar</a>
								@endif
							</div>
						</div>
				</div>
			@endforeach
		</div>
	</div>

	<div class="modal" id="modal_delete" style="width: 40%">
		<div class="modal-content" style="padding-bottom: 0px">
			<h5 id="msgDelete">Está seguro(a) que desea liberar esta casa?</h5>
		</div>
		<div class="modal-footer">
			<a class="btn-flat modal-action modal-close">No <i class="material-icons red-text right">cancel</i></a>
			<a id="dataDelete" href="#" class="btn-flat modal-action">Continuar <i class="material-icons light-green-text right">check_circle</i></a>
		</div>
	</div>

@include('layout._formRegistrarPersona')	

@endsection

@section('scripts')
@include('sweet::alert')
<script>

	function setIdCasa(value){
		$('form').attr('action','/Propietario/Arrendar/'+value);
	}

	function setIdCasaLibre(value){
		$('#dataDelete').attr('href','/Propietario/Liberar/'+value);
	}

	$(function() {
		
		$('#btnRegistro').click(function() {
			if (!validarCampos()) {
				$('form').submit();
			}
		});

		function validarCampos() {
			if ( $('[name=cedula]').val() == '' ||
				 $('[name=nombres]').val() == '' || 
				 $('[name=apellidos]').val() == '' ||
				 $('[name=telefono]').val() == '' ||
				 $('[name=email]').val() == '' ||
				 $('[name=usuario]').val() == '' ||
				 $('[name=password]').val() == '' ||
				 $('[name=repeat-password]').val() == '' ||
				 $('[name=sexo]').val() == '' ||
				 $('[name=birthday]').val() == '' ) {
				Materialize.toast('Tiene campos vacíos, verifique',3000,'red');
				return true;
			} else if($('[name=password]').val() != $('[name=repeat-password]').val() ){
				Materialize.toast('Las contraseñas no son iguales, verifique',3000,'red');
				return true;
			}

			return false;
		}
	});
</script>
@endsection