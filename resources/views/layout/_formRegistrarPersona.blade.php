<div id="modal" class="modal modal-fixed-footer" style="width: 50%">
	<form method="post" action="{{route('propietario.guardar')}}">
	{{csrf_field()}}
	<div class="modal-content">
		<h4>Registro de {{(request()->is('Administrador/*')) ? "Propietarios": "Arrendatarios" }}</h4>
		<div class="divider"></div>
		<ul class="collapsible" data-collapsible="accordion">
			<li>
				<div class="collapsible-header active"><i class="material-icons">face</i> <b>Datos Personales</b></div>
				<div class="collapsible-body">
					<div class="row">
						<div class="input-field col s6">
							<i class="material-icons prefix">face</i>
							<input type="number" name="cedula" data-length='11'>
							<label for="cedula">Cedula</label>
						</div>
						
						<input type="hidden" name="rol" value="{{(request()->is('Administrador/*')) ? "Propietario": "Arrendatario" }}">
						<input type="hidden" name="casas">

						@if(request()->is('Administrador/*'))
						<div class="input-field col s6">
							<i class="material-icons prefix">home</i>
							<div type="text" name="casa" class="chips chips-autocomplete"></div>
							<label for="casa">Casa</label>
						</div>
						@endif
					</div>
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
							<i class="material-icons prefix">group_work</i>
							<select name="sexo">
								<option>Masculino</option>
								<option>Femenino</option>
							</select>
							<label for="sexo">Sexo</label>
						</div>
						<div class="input-field col s6">
							<i class="material-icons prefix">today</i>
							<input type="date" name="birthday" class="datepicker">
							<label for="birthday">Fecha de Nacimiento</label>
						</div>
						<div class="input-field col s6">
							<i class="material-icons prefix">phone</i>
							<input type="number" name="telefono" data-length='10'>
							<label for="telefono">Telefono</label>
						</div>
						<div class="input-field col s6">
							<i class="material-icons prefix">mail</i>
							<input type="email" name="email">
							<label for="email">Correo Electronico</label>
						</div>
					</div>
				</div>
			</li>
			<li>
				<div class="collapsible-header"> <i class="material-icons">account_circle</i><b>Datos de Acceso</b></div>
				<div class="collapsible-body">
					<div class="row">
						<div class="input-field col s6">
							<i class="material-icons prefix">account_circle</i>
							<input type="text" name="usuario">
							<label for="usuario">Usuario</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6">
							<i class="material-icons prefix">lock</i>
							<input type="password" name="password" value="ziruma1">
							<label for="password">Contraseña</label>
						</div>
						<div class="input-field col s6">
							<i class="material-icons prefix">lock_outline</i>
							<input type="password" name="repeat-password" value="ziruma1">
							<label for="repeat-password">Repetir Contraseña</label>
						</div>
					</div>	
				</div>
			</li>
		</ul>
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close btn-flat waves-effect waves-light">Cancelar<i class="material-icons prefix right red-text">cancel</i></a>
		<button type="button" id="btnRegistro" class="btn-flat waves-effect waves-light"  data-opcion='registrar'>Registrar <i class="material-icons prefix right light-green-text">check_circle</i></button>
	</div>
	</form>
</div>