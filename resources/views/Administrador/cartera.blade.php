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
                                <th>Propietario</th>
                                <th>Estado</th>
                                <th>valor de la deuda</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($casas as $casa)
                            <tr>
                                <td>{{$casa->nombre}}</td>
                                <td>{{$casa->miPropietario->persona->nombreCompleto}}</td>
                                @if($casa->estadoCartera == 'Al Dia')
                                    <td><span class="spanEstado light-green">{{$casa->estadoCartera}}</span></td>
                                @else
                                <td><span class="spanEstado red">{{$casa->estadoCartera}}</span></td>
                                @endif
                                <td>$ {{$casa->valorCuantia}}</td>
                                <td>
                                    <button class="btn-floating cyan"><i class="material-icons">search</i></button>
                                    <button class="btn-floating cyan"><i class="material-icons">launch</i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$casas->links()}}
                </div>
            </div>
        </div>
    </div>

    @include('layout._botonRojo')

@endsection

@section('scripts')
@endsection