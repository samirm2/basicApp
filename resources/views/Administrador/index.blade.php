@extends('layout.app')
@section('sidenav')
 @include('layout.sideNav')
@endsection

@section('contenido')
	<div class="caja">
    <div class="row valign-wrapper">
      <div class="input-field">
        <i class="material-icons prefix">payment</i>
        <input type="number" name="cuota" value="50000" readonly="true">
        <label for="couta">Valor Administración</label>
      </div>
      <button id="btnCuota" class="btn-floating blue"><i class="material-icons">edit</i></button>
    </div>
		<div class="row">
			<div class="col s12 m6">
        <div class="card-panel" style="padding:10px">
            <canvas id="graficoBarras"></canvas>		
        </div>
				
			</div>
			<div class="col s12 m6">
        <div class="card-panel" style="padding:10px">
          <canvas id="graficoPie"></canvas>
        </div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script src="{{asset('js/chart.min.js')}}"></script>
<script type="text/javascript">
	$(function(){
    $("#btnCuota").click(function(){
      if($(this).text() == "edit"){
        $("[name=cuota]").removeAttr('readonly');
        $("[name=cuota]").focus();
        $(this).html('<i class="material-icons">save</i>');
      }else{
        Materialize.toast('Modificado correctamente',3000);
        $(this).html('<i class="material-icons">edit</i>');
        $("[name=cuota]").attr('readonly','true');
      }
    });
    
    $.ajax({
      url:'{{Route("api.chart.barras.trimensual")}}',
      type:'get',
      dataType:'json',
      success: function(rta){
        graficarBalanceTrimensual(rta);
      }
    });

    $.ajax({
      url:'{{Route("api.chart.pie")}}',
      type:'get',
      dataType:'json',
      success: function(rta){        
        graficarBalancePagos(rta);
      }
    });
  });

  function graficarBalanceTrimensual(arrayDatos){
    var grafica = new Chart($('#graficoBarras'),{
      type: 'bar',
      data: {
        labels: arrayDatos.mes,
        datasets: [{
          label: 'Ingresos',
          data: arrayDatos.totalIngresos,
          backgroundColor: [
            'rgba(76, 209, 55,0.2)',
            'rgba(76, 209, 55,0.2)',
            'rgba(76, 209, 55,0.2)'
          ],
          borderColor: [
            'rgba(76, 209, 55,1.0)',
            'rgba(76, 209, 55,1.0)',
            'rgba(76, 209, 55,1.0)'
          ],
          borderWidth: 1
        },
        {
          label: 'Gastos',
          data: arrayDatos.totalGastos,
          backgroundColor: [
            'rgba(231, 76, 60,0.4)',
            'rgba(231, 76, 60,0.4)',
            'rgba(231, 76, 60,0.4)'
          ],
          borderColor: [
            'rgba(231, 76, 60,1.0)',
            'rgba(231, 76, 60,1.0)',
            'rgba(231, 76, 60,1.0)'
          ],
          borderWidth: 1
        }
        ]
      },
      options: {
        title: {
          display: true,
          fontSize: 18,
          text: 'Balance Trimestral de Ingresos y Gastos'
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
          enabled: true,
          mode: 'single',
          callbacks: {
            label: function(tooltipItems, data) {
              return data.datasets[tooltipItems.datasetIndex].label + ": $ "+ tooltipItems.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            },
          }
        }
      }
    });
  }

  function graficarBalancePagos(arrayDatos){
    var grafica = new Chart($('#graficoPie'),{
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

</script>
@endsection