@extends('layout.app')
@section('sidenav')
	@include('layout.sideNav')
@endsection
@section('contenido')
	<div class="caja">
		<div class="row">
			<div class="col s12">
				<div class="card-panel">
                    <h4><i class="material-icons">pie_chart</i> Reportes</h4>
                    <div class="divider"></div>
                    <div class="input-field col s5">
                        <i class="material-icons prefix">calendar_today</i>
                        <select name="mes">
                            <option value="" selected disabled>Seleccione una Opción</option>
                            @foreach($meses as $mes)
                            <option value="{{$mes->id}}">{{$mes->nombre}}</option>
                            @endforeach
                        </select>
                        <label>Mes a Consultar</label>
                    </div>
                    <div class="input-field col s5">
                        <i class="material-icons prefix">trip_origin</i>
                        <select name="ano">
                            <option value="2018">2018</option>
                        </select>
                        <label>Año</label>
                    </div>
                    <div class="input-field col s2">
                        <button id="btnConsultar" class="btn cyan">Consultar</button>
                    </div>
                    <ul class="tabs">
                        <li class="tab col s6"><a href="#tab1">Balance de Pagos Mes a Mes</a></li>
                        <li class="tab col s6"><a href="#tab2">Balance de Ingresos y Gastos</a></li>
                    </ul>
                        
                    <div id="tab1" class="row">
                        <div class="row"></div>
                        <button class="btn cyan right" id="btnImprimirReportePie"> Imprimir<i class="material-icons right">print</i></button>
                        <div id="contenedorPie">
                            <canvas id="graficoPie"></canvas>
                        </div>
                    </div>
    
                    <div id="tab2" class="row">
                        <div id="contenedorBarras">
                            <canvas id="graficoBarras"></canvas>
                        </div>
                    </div>
				</div>
			</div>
        </div>
    </div>
    
@endsection

@section('scripts')
<script src="{{asset('js/chart.min.js')}}"></script>
<script>
    $(function() {
        //Calcula el Mes Actual
        $.ajax({
            url:'{{Route("api.chart.pie")}}',
            type:'get',
            dataType:'json',
            success: function(rta){
            //console.log(rta);
            graficarBalancePagos(rta);
            }
        });

        $.ajax({
            url:'{{Route("api.chart.barras")}}',
            type:'get',
            dataType:'json',
            success: function(rta){
            graficarIngresosGastos(rta);
            }
        });


        $('#btnConsultar').click(function(){
            if(!$('[name=mes]').val() || !$('[name=ano]').val()){
                Materialize.toast('Error, el Campo Mes a Consultar es Obligatorio','2000','red');
            }else{
                $.ajax({
                    url:'{{route("api.chart.pie.consulta")}}',
                    type:'get',
                    dataType:'json',
                    data: {mes:$('[name=mes]').val(),ano:$('[name=ano]').val()},
                    success: function(rta){
                        //console.log(rta);
                        if(rta.casasAlDia == 0 && rta.casasMorosas == 0){
                            Materialize.toast('No Existen Datos para Esta Solicitud','2000','indigo');
                        }
                        graficarBalancePagos(rta);
                    }
                });

                $.ajax({
                    url:'{{route("api.chart.barras.consulta")}}',
                    type:'get',
                    dataType:'json',
                    data: {mes:$('[name=mes]').val(),ano:$('[name=ano]').val()},
                    success: function(rta){
                        // console.log(rta);
                        console.log(rta.totalIngresos + rta.totalGastos);
                        if(rta.totalIngresos == 0 && rta.totalGastos == 0){
                            Materialize.toast('No Existen Datos para Esta Solicitud','2000','purple');
                        }
                        graficarIngresosGastos(rta);
                    }
                });
            }
        });

        $('#btnImprimirReportePie').click(function(){
            var url = "Reportes/balance-casas/"+$('[name=mes]').val();
            window.open(url,'Balance de Casas','height=600,width=750');
        });

    });

function graficarBalancePagos(arrayDatos){
    $('#contenedorPie').html('<canvas id="graficoPie"></canvas>');
    var graficass = new Chart($('#graficoPie'),{
    type: 'pie',
    data: {
        labels: ["Casas al Dia", "Casas Deudoras"],
        datasets: [{
        //data: [54, 38],
        data: [arrayDatos.casasAlDia, arrayDatos.casasMorosas],
        backgroundColor: [
            'rgba(76, 209, 55,1.0)',
            'rgba(72, 126, 176,1.0)'
        ],
        borderColor: [
            'rgba(76, 209, 55,1.0)',
            'rgba(72, 126, 176,1.0)'
        ],
        borderWidth: 1
        }]
    },
    options: {
        title: {
            display: true,
            fontSize: 18,
            text: 'Balance de Pagos mes '+arrayDatos.mes +" "+arrayDatos.año
        }
    }   
    });
}

function graficarIngresosGastos(arrayDatos){
    $('#contenedorBarras').html('<canvas id="graficoBarras"></canvas>');
    var graficas = new Chart($('#graficoBarras'),{
      type: 'bar',
      data: {
        labels: arrayDatos.mes,
        datasets: [{
          label: 'Ingresos',
          data: arrayDatos.totalIngresos,
          backgroundColor: [
            'rgba(76, 209, 55,0.2)'
          ],
          borderColor: [
            'rgba(76, 209, 55,1.0)'
          ],
          borderWidth: 1
        },
        {
          label: 'Gastos',
          data: arrayDatos.totalGastos,
          backgroundColor: [
            'rgba(231, 76, 60,0.4)',
          ],
          borderColor: [
            'rgba(231, 76, 60,1.0)',
          ],
          borderWidth: 1,
          
        }
        ]
      },
      options: {
        title: {
          display: true,
          fontSize: 18,
          text: 'Balance Mensual de Ingresos y Gastos - '+ arrayDatos.mes[0] + ' ' + arrayDatos.año
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true,
              callback: function(value, index, values) { 
                return '$ ' + number_format(value); 
              }
            }
          }]
        },
        tooltips: {
            mode: "index",
            label: "myLabel",
            callbacks: {
                label: function(tooltipItem, data) {
                    return data.datasets[tooltipItem.datasetIndex].label + ": "+ tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
            }
        }
      }
    });
}

</script>
@include('sweet::alert')
@endsection