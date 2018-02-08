@extends('layout.app')
@section('sidenav')
 @include('layout.sideNav')
@endsection

@section('contenido')
	<div class="caja">
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
	var ctx =$('#graficoBarras');
	var ctxx =$('#graficoPie');
	var graficas = new Chart(ctx,{
		type: 'bar',
		data: {
			labels: ["Noviembre", "Diciembre", "Enero"],
			datasets: [{
        label: 'Ingresos',
        data: [12, 16, 20],
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
        data: [7, 10, 18],
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
	var graficass = new Chart(ctxx,{
		type: 'pie',
		data: {
			labels: ["Casas al Dia", "Casas Deudoras"],
			datasets: [{
        data: [18, 38],
        backgroundColor: [
          'rgba(241, 196, 15,1)',
          'rgba(0, 209, 55,1)'
      	],
        borderColor: [
          'rgba(241, 196, 15,1)',
          'rgba(76, 209, 55,1.0)'
        ],
        borderWidth: 1
      }]
		},
	options: {
	    title: {
	      display: true,
	      fontSize: 18,
        text: 'Balance de Pagos mes Enero 2018'
      }
  }   
});
</script>
@endsection