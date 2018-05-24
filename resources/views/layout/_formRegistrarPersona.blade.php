<div id="modal" class="modal modal-fixed-footer" style="width: 50%">
	<form method="post" action="{{route('propietario.guardar')}}">
	{{csrf_field()}}
	{{-- {{method_field('PUT')}} --}}
	<div class="modal-content" style="padding-bottom: 0px">
		<h4>Registro de {{auth()->user()->rol == 'Administrador' ? "Propietarios": "Arrendatarios" }}</h4>
		<div class="divider"></div>
		<ul class="collapsible" data-collapsible="accordion">
			<li>
				<div class="collapsible-header active"><i class="material-icons">face</i> <b>Datos Personales</b></div>
				<div class="collapsible-body">
					<div class="row valign-wrapper">
						<div class="input-field col {{auth()->user()->rol=='Administrador'?'s5':'s12'}}">
							<i class="material-icons prefix">face</i>
							<input type="number" name="cedula" data-length='11' style="margin-bottom: 0px">
							<label for="cedula">Cedula*</label>
							<span id="spnMensajeCedula" class="inputMensaje"> </span>
						</div>
						<button type="button" id="btnBuscar" class="btn-floating blue waves-effect waves-light {{auth()->user()->rol!='Administrador'?'hide':''}}"><i class="material-icons">search</i></button>
						
						<input type="hidden" name="rol" value="{{auth()->user()->rol == 'Administrador'?'Propietario':'Arrendatario'}}">					
						<input type="hidden" name="casas">
						<input type="hidden" name="persona_id">

						@if(auth()->user()->rol == 'Administrador')
							<div class="input-field col s6">
								<i class="material-icons prefix">home</i>
								<div type="text" name="casa" class="chips chips-autocomplete" style="margin-bottom: 0px"></div>
								<label for="casa">Casa(s)*</label>
								<span id="spnMensajeCasa" class="inputMensaje"> </span>
							</div>
						@endif
					</div>
					<div class="row">
						<div class="input-field col s6">
							<i class="material-icons prefix">label_outline</i>
							<input type="text" name="nombres" style="margin-bottom: 0px">
							<label for="nombres">Nombres*</label>
							<span id="spnMensajeNombres" class="inputMensaje"> </span>
						</div>
						<div class="input-field col s6">
							<i class="material-icons prefix">label</i>
							<input type="text" name="apellidos" style="margin-bottom: 0px">
							<label for="apellidos">Apellidos*</label>
							<span id="spnMensajeApellidos" class="inputMensaje"> </span>
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
							<input type="number" name="telefono" data-length='10' style="margin-bottom: 0px">
							<label for="telefono">Telefono*</label>
							<span id="spnMensajeTelefono" class="inputMensaje"> </span>
						</div>
						<div class="input-field col s6">
							<i class="material-icons prefix">mail</i>
							<input type="email" name="email" style="margin-bottom: 0px">
							<label for="email">Correo Electronico*</label>
							<span id="spnMensajeEmail" class="inputMensaje"> </span>
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
							<label for="usuario">Usuario*</label>
							<span id="spnMensajeUsuario" class="inputMensaje"></span>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6">
							<i class="material-icons prefix">lock</i>
							<input type="password" name="password" value="ziruma1">
							<label for="password">Contraseña*</label>
							<span id="spnMensajePassword" class="inputMensaje"></span>
						</div>
						<div class="input-field col s6">
							<i class="material-icons prefix">lock_outline</i>
							<input type="password" name="repeat-password" value="ziruma1">
							<label for="repeat-password">Repetir Contraseña*</label>
						</div>
					</div>	
				</div>
			</li>
		</ul>
		<span class="inputMensaje" style="margin-left: 0px">los campos con "*" son obligatorios</span>
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close btn-flat waves-effect waves-light">Cancelar<i class="material-icons prefix right red-text">cancel</i></a>
		<button type="button" id="btnRegistro" class="btn-flat waves-effect waves-light"  data-opcion='registrar'>Registrar <i class="material-icons prefix right light-green-text">check_circle</i></button>
	</div>
	</form>
</div>