@if(session('mensaje_exitoso'))
<div class="row">
	<div class="col s4 offset-s4">
		<div class="card-panel light-green lighten-4" style="padding: 10px">
			<center><span class="green-text">{{session('mensaje_exitoso')}}</span></center>
		</div>
	</div>
</div>
@endif