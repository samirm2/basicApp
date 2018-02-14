@extends('layout.app')

@section('sidenav')
	@include('layout.sideNav')
@endsection

@section('contenido')
	<div class="caja">
		<div class="row">
			<div class="col s12">
				<div class="card-panel">
					<a href="{{(request()->is('Administrador/*'))?url('Administrador/pqrs'):url('Propietario/pqrs')}}" class="btn-floating cyan"><i class="material-icons">arrow_back</i></a>
					<div class="row"></div>				
					<div class="row">
						<span class="spanEstado blue">{{$datos['tipo']}}</span>
						<b>Asunto: {{$datos['asunto']}}</b>
						<span class="spanEstado right {{($datos['estado']=='Activo') ? 'light-green' : 'red'}}">{{$datos['estado']}}</span>
					</div>
					<div class="row" {{-- style="height: 210px; overflow-y: auto;" --}}>
						{{-- tarjeta para chat --}}
						<div class="col s10">
							<div class="card-panel">
								<div class="row valign-wrapper" style="margin-bottom: 0px">
									<div class="col s2">
										<img class="circle" src="{{asset('img/user.jpg')}}" height="70">	
									</div>
									<div class="col s10">
										<span>{{$datos['pqrs'].$datos['mensaje']}}</span>	
									</div>
								</div>
							</div>
						</div>

						<div class="col s10 offset-s2">
							<div class="card-panel">
								<div class="row valign-wrapper" style="margin-bottom: 0px">
									<div class="col s10">
										<span>{{$datos['pqrs'].$datos['mensaje']}}</span>	
									</div>
									<div class="col s2">
										<img class="circle" src="{{asset('img/user.jpg')}}" height="70">	
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row valign-wrapper">
						<div class="input-field col s12">
							<textarea name="mensaje" class="materialize-textarea" data-length="450" {{($datos['estado']=='Cerrado') ?'disabled="true"':''}}></textarea>
							<label for="mensaje">Mensaje</label>
						</div>
						<button class="btn-floating btn-large green" {{($datos['estado']=='Cerrado') ?'disabled="true"':''}}><i class="material-icons right">send</i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection