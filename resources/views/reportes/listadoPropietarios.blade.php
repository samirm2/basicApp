<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Listado de Propietarios</title>
	<style type="text/css">
		table{
			width: 100%;
			border-collapse: collapse;
		}
		th,td{
			border: 1px solid black;
		}
		h2{
			text-align: center;
		}
	</style>
</head>
<body>
	<table>
		<tr>
			<th rowspan="2" style="text-align: center;"><img src="{{asset('img/logo.png')}}" height="100"></th>
			<th style="text-align: center">
                <h3>
                    CONJUNTO CERRADO ALTOS DE ZIRUMA I <br>
                    <small>Transversal 27 N° 52 - 30</small> <br>
                    <small>Valledupar - Cesar</small>
                </h3>
            </th>
		</tr>
		<tr>
			<th style="text-align: center;"><h3>Listado de Propietarios</h3></th>
		</tr>
	</table>
	<br><br>
	<table>
		<thead>
			<tr style="height: 30px; background-color: #fafafa">
				<th>Casa</th>
				<th>Cedula</th>
				<th>Nombres</th>
				<th>Apellidos</th>
				<th>Telefono</th>
				<th>Correo Electronico</th>
			</tr>
		</thead>
		<tbody>
			@foreach($casas as $casa)
				<tr>
					<td><b>{{$casa->nombre}}</b></td>
					@if(is_null($casa->miPropietario))
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					@else
						<td>{{$casa->miPropietario->persona->cedula}}</td>
						<td>{{$casa->miPropietario->persona->nombres}}</td>
						<td>{{$casa->miPropietario->persona->apellidos}}</td>
						<td>{{$casa->miPropietario->persona->telefono}}</td>
						<td>{{$casa->miPropietario->persona->email}}</td>
					@endif
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>