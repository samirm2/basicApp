<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Balance Casas</title>
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
			<th style="text-align: center;"><h3>Balance de Casas Mes de {{$nombreMes}}</h3></th>
		</tr>
	</table>
	<br><br>
	<table>
		<thead>
			<tr style="height: 30px; background-color: #fafafa; text-align: center">
				<th>Casa</th>
                <th>Propietario</th>
				<th>Estado</th>
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
                    @if($casa->pagos->where('mes_id',$mes)->first()->estado == 'Pendiente')
                        <td style="text-align:center;background: red">{{$casa->pagos->where('mes_id',$mes)->first()->estado}}</td>
                    @else
                    <td style="text-align:center;background: lightgreen">{{$casa->pagos->where('mes_id',$mes)->first()->estado}}</td>
                    @endif
                    @endif
                </tr>
                @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total Casas al Dia</th>
                <th style="text-align:center">{{$casaAlDia}}</th>
            </tr>
            <tr>
                <th colspan="2">Total Casas Pendientes de Pago</th>
                <th style="text-align:center">{{$casaPendiente}}</th>
            </tr>
        </tfoot>
	</table>
</body>
</html>