@extends('layout.app')
@section('sidenav')
 @include('layout.sideNav')
@endsection

@section('contenido')
	<div class="caja">
    <div class="row valign-wrapper">
      <div class="input-field">
        <i class="material-icons prefix">payment</i>
        <input type="number" name="cuota" value="55000" readonly="true">
        <label for="couta">Valor Administración</label>
      </div>
      <button id="btnCuota" class="btn-floating blue"><i class="material-icons">edit</i></button>
    </div>
		<div class="row">
			<div class="col s6">
				<canvas id="graficoBarras"></canvas>		
			</div>
			<div class="col s6">
				<canvas id="graficoPie"></canvas>
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

    var ctx =$('#graficoBarras');
    var ctxx =$('#graficoPie');
    var graficas = new Chart(ctx,{
      type: 'bar',
      data: {
        labels: ["Noviembre", "Diciembre", "Enero"],
        datasets: [{
          label: 'Ingresos',
          data: [1200000, 1600000, 2000000],
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
          data: [700000, 1000000, 1800000],
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
          text: 'Balance Mensual de Ingresos y Gastos'
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true
            }
          }]
        }
      }
    });
    
    $.ajax({
      url:'{{Route("api.chart.pie")}}',
      type:'get',
      dataType:'json',
      success: function(rta){
        console.log(rta);
        graficarBalancePagos(rta);
      }
    });

    function graficarBalancePagos(arrayDatos){
      var graficass = new Chart(ctxx,{
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


  });
</script>
@endsection