<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Paz y Salvo</title>
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
        p{
            font-size: 1.2rem;
            text-align: justify;
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
			<th style="text-align: center;"><h3>PAZ Y SALVO</h3></th>
		</tr>
	</table>
    <br><br><br><br><br><br><br>
    
    <p>
        el conjunto cerrado altos de ziruma 1 se permite certificar que el señor(a) <b> {{$casa->miPropietario->persona->nombreCompleto}} </b>
        propietario de la <b>Casa {{$casa->id}}</b>, se encuentra a Paz y Salvo en el pago de la cuota de administracion hasta la fecha.
    </p>
    <br>
    <p>
        el presente certificado se expide a solicitud del interesado a los {{$hoy->day}} dias del mes
        de {{$mes}} del presente año.
    </p>
    <br><br><br>
    <p>
        Cordialmente, <br><br><br><br><br><br><br>



        ________________________ <br>
        <span>
                {{auth()->user()->persona->NombreCompleto}} <br>
                <small><b>Administrador del conjunto</b></small>
        </span>
    </p>
</body>
</html>