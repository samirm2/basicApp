@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection
@section('contenido')
    <div class="caja">
		<div class="row">
			<div class="col s12">
				<div class="card-panel">
                <a href="{{route('reportes.imprimirCartera')}}" target="_blank" class="btn-floating cyan tooltipped right" data-tooltip="Imprimir Cartera" data-delay="50" data-position="left"><i class="material-icons">print</i></a>
                    <h4><i class="material-icons">assessment</i> Cartera <small class="right">Total Cartera: $ {{number_format($totalCartera)}}</small></h4>
                    <div class="divider"></div>
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
                            @foreach($casasPaginate as $casa)
                            <tr>
                                <td>{{$casa->nombre}}</td>
                                @if(is_null($casa->miPropietario->persona))
                                <td></td>
                                @else
                                <td>{{$casa->miPropietario->persona->nombreCompleto}}</td>
                                @endif
                                @if(!$casa->estadoCartera)
                                    <td><span class="spanEstado light-green">Al Dia</span></td>
                                @else
                                <td><span class="spanEstado red">Moroso</span></td>
                                @endif
                                <td>$ {{number_format($casa->valorCuantia)}}</td>
                                <td>
                                    <a class="btn-floating cyan buscarPagos modal-trigger" href="#modalPagos" data-casa='{{$casa->id}}' ><i class="material-icons">search</i></a>
                                    @if(!$casa->estadoCartera)
                                        <a href="{{Route('reportes.pazysalvo',['casaId'=>$casa->id])}}" class="btn-floating cyan tooltipped generarPazySalvo" data-tooltip="Generar Paz y Salvo" data-position="left" data-delay="50"><i class="material-icons">spellcheck</i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$casasPaginate->links()}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-fixed-footer" id="modalPagos" style="width:60%">
        <div class="modal-content">
            <h4><i class="material-icons">account_balance</i> Pagos de la Casa <span id="spanNCasa"></span> </h4>
            <div class="divider"></div>
            <table class="highlight bordered">
                <thead>
                    <tr>
                        <th>Factura N°</th>
                        <th>Mes</th>
                        <th>Valor a Pagar</th>
                        <th>Estado</th>
                        <th>Fecha de Pago</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableCasaPago"></tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button class="btn-flat modal-action modal-close">Cerrar <i class="material-icons right">close</i></button>
        </div>
        </div>

@endsection

@section('scripts')
<script>
    $(function(){
        $('.generarPazySalvo').click(function(){
			window.open($(this).attr('href'),'pago','height=600,width=750');
			return false;
        });
        $('body').on('click','.verFactura' ,function(){
			window.open($(this).attr('href'),'pago','height=500,width=750');
			return false;
		});
        $('.buscarPagos').click(function(){
            $('#spanNCasa').text($(this).data('casa'));
            $.ajax({
                url:'{{route("api.pagos.casas")}}',
                method:'get',
                data:{'casa': $(this).data('casa')},
                dataType:'json',
                success: function(rta){
                    $('#tableCasaPago').html('');
                    
                    for (casa in rta){
                        var color = 'green';
                        var disable = 'disabled';
                        if(rta[casa].fecha_pago == null){
                            rta[casa].fecha_pago = '';
                        }
                        if(rta[casa].estado == 'Pendiente'){
                            color = 'yellow darken-1';
                            disable = '';
                        }

                        $('#tableCasaPago').append(
                            '<tr><td>'+rta[casa].id+'</td>'+
                                '<td>'+rta[casa].mes_pago.nombre+'</td>'+
                                '<td> $ '+rta[casa].valor+'</td>'+
                                '<td><span class="spanEstado '+color+'">'+rta[casa].estado+'</span></td>'+
                                '<td>'+rta[casa].fecha_pago +'</td>'+
                                '<td><a href="./Pagos/'+rta[casa].id+'" class="btn-floating cyan verFactura"><i class="material-icons">visibility</i></a></td>'         
                        );
                    }
				}
			});
        });
    })
</script>
@endsection