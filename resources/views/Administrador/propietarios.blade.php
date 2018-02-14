@extends('layout.app')
@section('sidenav')
 @include('layout.sideNav')
@endsection

@section('contenido')
<div class="caja">
	<div class="row">
		<div class="col s12">
			<div class="card-panel">
				<table class="striped">
					<thead>
						<tr>
							<th>Casa</th>
							<th>Cedula</th>
							<th>Nombres</th>
							<th>Apellidos</th>
							<th>Telefono</th>
							<th>Correo Electronico</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>Casa 1</b></td>
							<td>1111111111</td>
							<td>Ana Maria</td>
							<td>Acosta Melendez</td>
							<td>12738121234</td>
							<td>ejemplo@ejemplo.com</td>
							<td>
								<a href="#" class="btn-floating cyan"><i class="material-icons">edit</i></a>
								{{-- <a href="#" class="btn-floating"><i class="material-icons">delete</i></a> --}}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>	
</div>

@include('layout._botonRojo')

@include('layout._formRegistrarPersona')

@endsection

@section('scripts')
<script type="text/javascript">
	$(function(){
		$('[name=casa]').material_chip({
			autocompleteOptions: {
	    	  data: {
		        'Casa 1':null,'Casa 2':null,'Casa 3':null,'Casa 4':null,'Casa 5':null
	      	},
	      	limit: 3,
	      	minLength: 1
	    	}
		});
	});
</script>
@endsection