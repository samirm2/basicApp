<li>
	<ul class="collapsible" style="padding-left: 16px">
		<li>
			<a class="collapsible-header" href="{{url('/Administrador/Propietarios')}}"><i class="material-icons">home</i>Propietarios</a>
		</li>
		<li>
			<a class="collapsible-header" href="{{url('/Administrador/Pagos')}}"><i class="material-icons">receipt</i>Pagos</a>
		</li>
		<li>
			<a class="collapsible-header" href="{{url('/Administrador/Cartera')}}"><i class="material-icons">assessment</i>Cartera</a>
		</li>
		<li>
			<a class="collapsible-header" href="{{url('/Administrador/Gastos')}}"><i class="material-icons">account_balance_wallet</i>Gastos</a>
		</li>
		<li>
			<a class="collapsible-header"><i class="material-icons">assignment_ind</i>Contratos</a>
			<div class="collapsible-body">
				<ul>
					<li><a href="{{url('/Administrador/Contratos/Activos')}}">Activos <i class="material-icons">assignment_turned_in</i></a></li>
					<li><a href="{{url('/Administrador/Contratos/Historial')}}">Historial <i class="material-icons">assignment</i></a></li>
				</ul>
			</div>
		</li>
		<li>
			<a class="collapsible-header" href="{{url('/Administrador/Empleo')}}"><i class="material-icons">work</i>Ofertas de Empleo</a>
		</li>
		<li>
			<a class="collapsible-header" href="{{url('/Administrador/Reportes')}}"><i class="material-icons">pie_chart</i>Reportes</a>
		</li>		
		<li>
			<a class="collapsible-header"><i class="material-icons">live_help</i>PQRS</a>
			<div class="collapsible-body">
				<ul>
					<li><a href="{{url('/Administrador/pqrs/entrada')}}">Bandeja de Entrada <i class="material-icons">archive</i></a></li>
					<li><a href="{{url('/Administrador/pqrs/salida')}}">Bandeja de Salida <i class="material-icons">unarchive</i></a></li>
				</ul>
			</div>
		</li>
		<li>
			<a class="collapsible-header" href="{{url('/Administrador/Backup')}}"><i class="material-icons">backup</i>Copias de seguridad</a>
		</li>
	</ul>
</li>