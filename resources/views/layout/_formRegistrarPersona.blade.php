<div id="modal" class="modal modal-fixed-footer" style="width: 50%">
	<div class="modal-content">
		<h4>Registro de {{(request()->is('Administrador/*')) ? "Propietarios": "Arrendatarios" }}</h4>
		<div class="divider"></div>
		<ul class="collapsible" data-collapsible="accordion">
			<li>
				<div class="collapsible-header active"><b>Datos Personales</b></div>
				<div class="collapsible-body">
					<div class="row">
						<div class="input-field col s6">
							<input type="number" name="cedula">
							<label for="cedula">Cedula</label>
						</div>
						
						@if(request()->is('Administrador/*'))
						<div class="input-field col s6">
							<i class="material-icons prefix">home</i>
							<input type="text" name="casa" class="autocomplete">
							<label for="casa">Casa</label>
						</div>
						@endif
					</div>
					<div class="row">
						<div class="input-field col s6">
							<input type="text" name="nombres">
							<label for="nombres">Nombres</label>
						</div>
						<div class="input-field col s6">
							<input type="text" name="apellidos">
							<label for="apellidos">Apellidos</label>
						</div>
						<div class="input-field col s6">
							<select name="sexo">
								<option>Masculino</option>
								<option>Femenino</option>
							</select>
							<label for="sexo">Sexo</label>
						</div>
						<div class="input-field col s6">
							<input type="date" name="birthday" class="datepicker">
							<label for="birthday">Fecha de Nacimiento</label>
						</div>
						<div class="input-field col s6">
							<input type="number" name="telefono">
							<label for="telefono">Telefono</label>
						</div>
						<div class="input-field col s6">
							<input type="email" name="email">
							<label for="email">Correo Electronico</label>
						</div>
					</div>
				</div>
			</li>
			<li>
				<div class="collapsible-header"><b>Datos de Acceso</b></div>
				<div class="collapsible-body">
					<div class="row">
						<div class="input-field col s6">
							<input type="text" name="usuario">
							<label for="usuario">Usuario</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6">
							<input type="password" name="password">
							<label for="password">Contraseña</label>
						</div>
						<div class="input-field col s6">
							<input type="password" name="repeat-password">
							<label for="repeat-password">Repetir Contraseña</label>
						</div>
					</div>	
				</div>
			</li>
		</ul>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn-flat">Registrar</a>
		<a class="modal-action modal-close btn-flat">Cerrar</a>
	</div>
</div>