@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection

@section('contenido')
	<div class="caja">
		<div class="row">
			<div class="col s12">
				<div class="card-panel">
					<span class="spanEstado {{(1==2) ? 'light-green' : 'grey'}}">Activo</span> <br>
					<h4>{{$id}}Algo</h4>
					<table class="striped centered">
						<thead>
							<tr>
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Correo Electrónico</th>
								<th>Curriculum</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Sara Yisel</td>
								<td>Montero Lopez</td>
								<td>saralosa@outlook.com</td>
								<td><a href="http://www.unal.edu.co/dnp/Archivos_base/Formato_Unico_de_Hoja_de_Vida-Persona_natural-DAFP.pdf">Ver</a></td>
								<td>
									<a class="btn-floating light-blue"><i class="material-icons">assignment_turned_in</i></a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection