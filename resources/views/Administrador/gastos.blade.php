@extends('layout.app')
@section('sidenav')
 @include('layout.sideNav')
@endsection

@section('contenido')
<div class="caja">
		@include('layout._mostrarMensajeFlash')
	<div class="row">
		<div class="col s12">
			<div class="card-panel">
				<table class="striped">
					<thead>
						<tr>
							<th>id</th>
							<th>Concepto</th>
							<th>Valor Pagado</th>
							<th>Fecha Y Hora</th>
							<th>Evidencia</th>
							<th>Opcion</th>
						</tr>
					</thead>
					<tbody>
						@foreach($gastos as $gasto)
						<tr>
							<td>{{$gasto->id}}</td>
							<td><b>{{$gasto->concepto}}</b></td>
							<td>{{$gasto->valor}}</td>
							<td>{{$gasto->created_at->diffForHumans()}}</td>
							<td><img class="materialboxed" src="{{Storage::url($gasto->evidencia)}}" height="100"></td>
							<td><a href="#modal" class="btnExaminar btn-floating cyan modal-trigger" data-concepto="{{$gasto->concepto}}" data-valor="{{$gasto->valor}}" data-observacion="{{$gasto->observaciones}}" data-evidencia="{{$gasto->evidencia}}"><i class="material-icons">description</i></a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@include('layout._botonRojo')

<div id="modal" class="modal modal-fixed-footer" style="width: 40%">
	<form method="post" action="{{route('gasto.registrar')}}" enctype="multipart/form-data">
		{{csrf_field()}}
	<div class="modal-content">
		<h4>Registro de Gastos</h4>
		<div class="divider"></div>
			<div class="row">
				<div class="input-field col s6">
					<i class="material-icons prefix">book</i>
					<input type="text" name="concepto">
					<label for="concepto">Concepto</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">monetization_on</i>
					<input type="number" name="valor">
					<label for="valor">Valor</label>
				</div>
			</div>
			<div class="row">
				<div id="fileEvidencia" class="input-field col s6">
					<input type="file" class="dropify" name="imagen">
					<label for="imagen">Evidencia</label>
				</div>
				<div id="imgMostrarEvidencia" class="col s6 hide">
					<img class="responsive-img" src="{{asset('img/imgDefault.png')}}">
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">insert_comment</i>
					<textarea name="observaciones" class="materialize-textarea"></textarea>
					<label for="observaciones">Observaciones</label>
				</div>
			</div>	
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close btn-flat">Cerrar <i class="material-icons red-text right">cancel</i></a>
		<button id="btnRegistrar" class="btn-flat waves-effect waves-light">Registrar <i class="material-icons light-green-text right">check_circle</i></button>
	</div>
	</form>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
	$(function(){
		$('#botonRojo').click(function(){
			limpiarCampos();
			inputsDisabled(false);
			$('#imgMostrarEvidencia').addClass('hide');
			$('#fileEvidencia').removeClass('hide');
			$('#btnRegistrar').attr('disabled',false);
			Materialize.updateTextFields();
		});

		$(".btnExaminar").click(function(){
			inputsDisabled(true);	
			$('[name=concepto]').val($(this).data('concepto'));
			$('[name=valor]').val($(this).data('valor'));
			$('[name=observaciones]').val($(this).data('observacion'));
			$('#imgMostrarEvidencia').removeClass('hide');
			$('#imgMostrarEvidencia').children().attr('src',renderizarImagen($(this).data('evidencia')));
			$('#fileEvidencia').addClass('hide');
			Materialize.updateTextFields();
		});

		function renderizarImagen(url){
			var img = url;
			img = img.split('/');
			img[0] = '/storage';
			img = img.join('/');
			return img;
		}

		function limpiarCampos(){
			$('[name=concepto]').val('');
			$('[name=valor]').val('');
			$('[name=observaciones]').val('');
		}

		function inputsDisabled(bandera){
			if(bandera){
				$('[name=concepto]').attr('disabled',true);
				$('[name=valor]').attr('disabled',true);
				$('[name=observaciones]').attr('disabled',true);
				$('#btnRegistrar').attr('disabled',true);
			}else{
				$('[name=concepto]').attr('disabled',false);
				$('[name=valor]').attr('disabled',false);
				$('[name=observaciones]').attr('disabled',false);
				$('#btnRegistrar').attr('disabled',false);
			}
		}
	});
</script>
@endsection