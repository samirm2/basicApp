@extends('layout.app')
@section('sidenav')
 @include('layout.sideNav')
@endsection

@section('contenido')
<script src="/js/html2canvas.min.js"></script>
<div class="caja">
	<div class="row">
		<div class="col s12">
			<div class="card-panel">
			<h5>Gastos<i class="material-icons left">account_balance_wallet</i></h5>
			<div class="divider"></div>
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
						@if($gastos->count() == 0)
						<tr>
							<td colspan="6" style="text-align:center"><h4 class="grey-text"> <i>No Existen Registros en el Sistema</i> </h4></td>
						</tr>
						@endif

						@foreach($gastos as $gasto)
						<tr>
							<td>{{$gasto->id}}</td>
							<td><b>{{$gasto->concepto}}</b></td>
							<td>$ {{number_format($gasto->valor)}}</td>
							<td>{{$gasto->created_at->diffForHumans()}}</td>
							@if( explode('.', $gasto->evidencia)[1] == 'pdf' )
								<td><a href="/uploads/{{$gasto->evidencia}}">Ver</a><td>
							@else
								<td><img class="materialboxed" src="/uploads/{{$gasto->evidencia}}" height="100"></td>
							@endif
							
							<td>
								<a href="/Administrador/Gastos/Recibo/Imprimir/{{explode('gastos/',$gasto->evidencia)[1]}}" target="_blank" class="btn-floating cyan modal-trigger">
									<i class="material-icons">print</i>
								</a>
								
								<a href="#modal" class="btnExaminar btn-floating cyan modal-trigger" data-concepto="{{$gasto->concepto}}" data-valor="{{$gasto->valor}}" data-observacion="{{$gasto->observaciones}}" data-evidencia="{{$gasto->evidencia}}"><i class="material-icons">description</i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div id="result" style="width: 850px;height: 610px;"></div>
</div>

@include('layout._botonRojo')

<div id="modal" class="modal modal-fixed-footer" style="width: 40%">
	<form method="post" action="{{route('gasto.registrar')}}" enctype="multipart/form-data">
		{{csrf_field()}}
	<div class="modal-content" style="padding-bottom: 0px">
		<h4>Registro de Gastos</h4>
		<div class="divider"></div>
			<div class="row">
				<div class="input-field col s6">
					<i class="material-icons prefix">label</i>
					<select name="tipo_gasto">
						<option value="Cotidiano">Cotidiano</option>
						<option value="Prestación de servicio">Prestación de servicio</option>
					</select>
					<label for="tipo_gasto">Tipo de Gasto</label>
				</div>
				<!-- <div class="col s6" id="filebox" style="display: none;margin-top: 25px;">
			      <input type="checkbox" class="filled-in" id="optImprimir" checked="checked" />
			      <label for="optImprimir">Imprimir</label>
				</div> -->
			</div>
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
				<div class="input-field col s12">
					<i class="material-icons prefix">insert_comment</i>
					<textarea name="observaciones" class="materialize-textarea"></textarea>
					<label for="observaciones">Observaciones</label>
				</div>
			</div>
			<div class="row" id="uploadbox">
				<div id="fileEvidencia" class="input-field col s6">
					<input type="file" class="dropify" name="imagen" data-allowed-file-extensions="jpg png gif jpeg">
					<label for="imagen">Evidencia</label>
				</div>
				<div id="imgMostrarEvidencia" class="col s6 hide">
					<img class="responsive-img" src="{{asset('img/imgDefault.png')}}">
				</div>
				<div class="col s6">
					<span class="nota"><b>Para tener en cuenta:</b> Una vez se registre el gasto en el sistema, no podra modificar su informacion. Solo son permitidos archivos tipo imagen para las evidencias.</span>
				</div>
			</div>

			<input type="text" id="paraEnviar" name="imagen_generada" value="" style="display: none;">
	</div>
	<div class="modal-footer" id="optModal">
		<a class="modal-action modal-close btn-flat">Cerrar <i class="material-icons red-text right">cancel</i></a>
		<button type="button" id="btnRegistrar" class="btn-flat waves-effect waves-light">Registrar <i class="material-icons light-green-text right">check_circle</i></button>
	</div>
	</form>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
	$(function(){
		$('#modal').modal({
			 dismissible: false
		});
		$("#optModal").css({"display":''});
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

		$('#btnRegistrar').click(function(){
			if ($('[name=tipo_gasto]').val() == 'Cotidiano') {
				$("#optModal").css({"display":'none'});
				enviar();
			}else{
				if (validarCampos('reg') == 0) {
					$("#optModal").css({"display":'none'});
					$.ajax({
						url:'Gastos/Recibo?'+$('form').serialize(),
						type:'get',
						success:function(argument) {
							$('#result').html(argument);
							captura();
						}
					});
				}
			}
			
		});


		function enviar() {
			if (validarCampos('reg') == 0) {
				$('form').submit();
			}
		}

		function captura() {
			html2canvas($("#result")[0]).then(function(canvas) {
			    $('[name=imagen_generada]').val(canvas.toDataURL());
			    $('form').submit();
			});
		}

		$('[name=tipo_gasto]').change(function(e) {
			if( $('[name=tipo_gasto]').val() == 'Cotidiano' ){
				$('#filebox').hide();
				$('#uploadbox').show();
			}else{
				$('#uploadbox').hide();
				$('#filebox').show();
			}
		});

	});

	function renderizarImagen(url){
		var img = url;
		img = img.split('/');
		img[0] = '/uploads/gastos';
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

	function validarCampos(ban){
		var bandera = 0;
		if ($('[name=concepto]').val() == '') {
			Materialize.toast('El campo Concepto esta vacio, verifique',3000,'red');
			bandera++;
		}
		if ($('[name=valor]').val() == '') {
			Materialize.toast('El campo Valor esta vacio, verifique',3000,'red');
			bandera++;
		}
		if ($('[name=observaciones]').val() == '') {
			Materialize.toast('El campo Observaciones esta vacio, verifique',3000,'red');
			bandera++;
		}
		if ($('[name=imagen]').val() == '' && ban == 'reg'  && $('[name=tipo_gasto]').val() == 'Cotidiano') {
			Materialize.toast('No hay ninguna evidencia adjuntada',3000,'red');
			bandera++;
		}
		return bandera;
	}
</script>
@include('sweet::alert')
@endsection