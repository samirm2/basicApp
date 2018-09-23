<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cartera</title>
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
        .spanEstado{
            color: white;
            padding: 5px 10px;
            border-radius: 2px;
            font-size: 0.9rem;
            font-weight: 300;
        }
        .red{
            background-color: red;
        }
        .light-green{
            background-color: #8bc34a;
        }
	</style>
</head>
<body>
	<table>
		<tr>
			<th rowspan="2" style="text-align: center;"><img src="img/logo.png" height="100"></th>
            <th style="text-align: center">
                <h3>
                    CONJUNTO CERRADO ALTOS DE ZIRUMA I <br>
                    <small>Transversal 27 N° 52 - 30</small> <br>
                    <small>Valledupar - Cesar</small>
                </h3>
            </th>
		</tr>
		<tr>
			<th style="text-align: center;"><h2>Cartera</h2></th>
		</tr>
	</table>
	<br><br>
	<table>
		<thead>
			<tr style="height: 30px; background-color: #fafafa; text-align: center">
				<th>Casa</th>
				<th>Propietario</th>
				<th>Estado</th>
				<th>Valor de la Deuda</th>
			</tr>
		</thead>
		<tbody>
                @foreach($casas as $casa)
                <tr>
                    <td>{{$casa->nombre}}</td>
                    @if(is_null($casa->miPropietario))
						<td></td>
					@else
                    	<td>{{$casa->miPropietario->persona->nombreCompleto}}</td>
					@endif
					
					@if(!$casa->estadoCartera)
						<td style='text-align:center' class="light-green">Al Dia</td>
					@else
						<td style='text-align:center' class="red">Moroso</td>
					@endif
					<td style="text-align:right">$ {{number_format($casa->valorCuantia)}}</td>
                </tr>
                @endforeach
		</tbody>
		<tfoot>
			<tr>
				<th colspan="3">Valor Total de la Cartera</th>
				<th style="text-align:right">$ {{number_format($totalCartera)}}</th>
			</tr>
		</tfoot>
	</table>
</body>
</html>