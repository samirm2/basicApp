@extends('layout.app')
@section('sidenav')
 @include('layout.sideNav')
@endsection

@section('contenido')
<div class="caja">
	<div class="row">
		<div class="col s12">
			<div class="card-panel">
				<h5>Historial de Arrendatarios<i class="material-icons left">assignment</i></h5>
				<div class="divider"></div>
					@if(count($listadoCasas) > 0)
						<ul class="collapsible popout" data-collapsible="accordion">
							@foreach($listadoCasas as $casa)
								<li>
							      <div class="collapsible-header">
							      	<b>#{{$casa->id}} - {{$casa->casa}} | Fecha Inicio: {{$casa->fecha_inicio}} - Fecha Fin: {{$casa->fecha_fin}}</b></div>
							      <div class="collapsible-body">
							      	<p><b>Cédula:</b> {{$casa->arrendado['cedula']}}</p>
							      	<p><b>Nombres y Apellidos:</b> {{$casa->arrendado['nombres']}} {{$casa->arrendado['apellidos']}}</p>
							      	<p><b>Sexo:</b> {{$casa->arrendado['sexo']}}, <b>Teléfono:</b> {{$casa->arrendado['telefono']}}</p>
							      </div>
							    </li>
							@endforeach
						</ul>
					@else
						<h3 class="center grey-text"><i>NO HAY DATOS<i></h3>
					@endif
			</div>
		</div>
	</div>
</div>

@endsection