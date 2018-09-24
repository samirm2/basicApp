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
                                @if(is_null($casa->miPropietario))
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
                                    <a class="btn-floating cyan buscarPagos modal-trigger" href="#modalPagos" data-casa="{{$casa->id}}" data-estado='{{$casa->estadoCartera}}'><i class="material-icons">search</i></a>
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

    <div class="modal modal-fixed-footer" id="modalPagos" style="width:75%">
        <div class="modal-content">
            <h5>
                <i class="material-icons">how_to_vote</i> Pagos de la <b>Casa <span id="spanNCasa"></span></b>
                <div id="switch" class="switch right">
                    <small>Abonar</small><br>
                    <label>
                    No
                    <input name="abonar" type="checkbox">
                    <span class="lever"></span>
                    Si
                    </label>
                </div>
            </h5>
            <div class="divider"></div>

            <div class="row">
                <div id="abonar" class="hide card-panel hoverable col s12 m8 l6" style="padding:10px;">
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">multiline_chart</i>
                            <input type="number" name="valorAbono">
                            <label for="valorAbono">Valor del Abono</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">monetization_on</i>
                            <input type="number" name="saldoTotal" readonly="true" value="0">
                            <label for="saldoTotal">Saldo Total</label>
                            </div>
                    </div>
                    <div class="row ">
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">money_off</i>
                            <input type="number" name="saldoPendiente" readonly="true" value="0">
                            <label for="saldoPendiente">Saldo Pendiente</label>
                        </div>
                        
                        <button style="margin-top:10%" class="btn cyan right" id="btnAbonar">Abonar <i class="material-icons right">done</i></button>
                        
                    </div>
                </div>
            </div>

            <table class="highlight bordered">
                <thead>
                    <tr style="text-align:center">
                        <th></th>
                        <th>N° Factura</th>
                        <th>Mes</th>
                        <th>Valor a Pagar</th>
                        <th>Valor Pagado</th>
                        <th>Saldo</th>
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
        var valorAcumulado = 0;
        $('#btnAbonar').click(function(){
            var abono          = parseFloat($('[name=valorAbono]').val()),
                saldoTotal     = parseFloat($('[name=saldoTotal]').val()),
                saldoPendiente = parseFloat($('[name=valorPendiente]').val());

            if(abono == 0){
                Materialize.toast('Error, No hay abono registrado',1500,'red darken-2');
            }else{
                if(saldoTotal == 0){
                    Materialize.toast('Error, No hay pagos seleccionados',1500,'red darken-2');
                }else{
                    if(abono > saldoTotal){
                    Materialize.toast('Advertencia, El abono es mayor que los pagos',1500,'amber'); 
                    }else{
                        var listaPagos = [];
                        $("[name=selectCasa]").each(function(){
                            listaPagos.push($(this).data('nfactura'));
                        });

                        $.ajax({
                            url:'{{route("pagos.abonar")}}',
                            method:'post',
                            data:{
                                '_token': "{{csrf_token()}}",
                                'facturasId': listaPagos,
                                'abono': $('[name=valorAbono]').val()
                                },
                            dataType:'json',
                            success: function(rta){
                                if(rta.bandera == 1){
                                    swal({
                                        icon: 'success',
                                        title: 'Abono Realizado Satisfactoriamente'
                                    }).then(value => {
                                        window.location.reload();
                                    });
                                }
                            }
                        });
                    }
                }
                
            }
            
		});

        $('[name=valorAbono]').change(function(){
            $('[name=saldoPendiente]').val(0);
            if(parseFloat($('[name=saldoTotal]').val()) != 0 && parseFloat($(this).val()) <= parseFloat($('[name=saldoTotal]').val())){
                var resta = parseFloat($('[name=saldoTotal]').val()) - parseFloat($(this).val());
                //valorAcumulado = valorAcumulado - $(this).val();
                $('[name=saldoPendiente]').val(resta);
            } 
		});

        $('#tableCasaPago').on('change','[name=selectCasa]',function(){
                if($(this).is(':checked')){
                    valorAcumulado += parseFloat($(this).data('valor'))*1000;
                }else{
                    valorAcumulado -= parseFloat($(this).data('valor'))*1000;
                    if(valorAcumulado < 0){
                        valorAcumulado = 0;
                    }
                }
                $('[name=saldoTotal]').val(valorAcumulado);
        });

        $('[name=abonar]').change(function(){
			if($(this).is(':checked')){
				$('#abonar').removeClass('hide');
			}else{
				$('#abonar').addClass('hide');
			}
		});

        $('.generarPazySalvo').click(function(){
			window.open($(this).attr('href'),'pago','height=600,width=750');
			return false;
        });
        
        $('body').on('click','.verFactura' ,function(){
			window.open($(this).attr('href'),'pago','height=500,width=750');
			return false;
		});
        
        $('.buscarPagos').click(function(){
            valorAcumulado = 0;
            $('#spanNCasa').text($(this).data('casa'));
            // console.log($(this).data('estado'));
            if(!$(this).data('estado')){
                $('#switch').addClass('hide');
            }else{
                $('#switch').removeClass('hide');
            }
            
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
                            '<tr><td> <input class="filled-in" type="checkbox" name="selectCasa" id="'+rta[casa].id+'" data-nFactura="'+rta[casa].id+'" data-valor="'+rta[casa].saldo+'"><label for="'+rta[casa].id+'"> </label></td>'+
                                '<td>'+rta[casa].id+'</td>'+
                                '<td>'+rta[casa].mes_pago.nombre+'</td>'+
                                '<td> $'+rta[casa].valor+'</td>'+
                                '<td> $'+rta[casa].valorPagado+'</td>'+
                                '<td> $'+rta[casa].saldo+'</td>'+
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