<div id="modal" class="modal modal-fixed-footer" style="width: 40%">
	<div class="modal-content">
		<h4>Crear PQRS</h4>
		<div class="divider"></div>
		<div class="row"></div>
		<div class="row">
			@if(request()->is('Administrador/*'))
			<div class="input-field col s12">
				<i class="material-icons prefix">contacts</i>
				<div name="para" class="chips-autocomplete"></div>
				<label for="para">Destinatario</label>
			</div>
			@endif
		</div>
		<div class="row">
			<div class="input-field col s6">
				<i class="material-icons prefix">label</i>
				<input type="text" name="asunto" data-length="30">
				<label for="asunto">Asunto</label>
			</div>
			<div class="input-field col s6">
				<i class="material-icons prefix">dashboard</i>
				<select name="tipo">
					@foreach($listaPqrs as $pqrs)
					<option>{{$pqrs}}</option>
					@endforeach
				</select>
				<label for="tipo">Tipo</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
				<i class="material-icons prefix">message</i>
				<textarea name="mensaje" class="materialize-textarea" data-length="450"></textarea>
				<label for="mensaje">Mensaje</label>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close btn-flat waves-effect waves-light">Cancelar <i class="material-icons red-text right">cancel</i></a>
		<a class="btn-flat waves-effect waves-light"><i class="material-icons right light-green-text">send</i>Enviar</a>
	</div>
</div>