@extends("layout.app")

@section("contenido")

<ul id="sideNav" class="side-nav fixed valign">
 <form>
  <center><img style="margin-top: 50px" class="responsive-img" src="{{asset('img/user.jpg')}}" width="50%"></center>
  <div class="container">
    <div class="input-field">
      <i class="material-icons prefix">perm_identity</i>
      <input type="text" name="username" style="margin-bottom:0px">
      <label for="name">Usuario</label>
      <span class="inputMensaje spnMensajeUsuario"></span>
    </div>
    <div class="input-field">
    	<i class="material-icons prefix">vpn_key</i>
      <input type="password" name="password" style="margin-bottom:0px">
      <label for="password">Contraseña</label>
      <span class="inputMensaje spnMensajeClave"></span>
    </div>
    <div class="input-field">
      <center><button type="button" class="btn cyan waves-effect btnIngresar">Ingresar</button></center>
    </div>
  </div>
  <div class="row"></div>
    <center class="imgLoading hide">
      <img src="{{asset('img/loading.gif')}}">
    </center>
  <div class="row">
  	<div class="center">
  		<a href="#">Olvide mi contraseña?</a>
    	{{-- <a href="/register">Quiero Registrarme</a> --}}
  	</div>
  </div>
 </form> 
</ul>

<div class="container hide-on-large-only" style="margin-top: 30px"> <!--Login-->
  <div class="row">
    <div class="col s12 m8 l6 offset-m2 offset-l3">
      <div class="card-panel">
      <!-- <a class="btn-floating" href="#"><i class="material-icons">arrow_back</i></a> -->
      <center><img class="responsive-img" src="{{asset('img/user.jpg')}}" width="50%"></center>
      <div class="row">
       <form>
          <div class="container">
          	<div class="input-field">
            	<i class="material-icons prefix">perm_identity</i>
            	<input type="text" name="username" style="margin-bottom:0px">
           		<label for="name">Usuario</label>
              <span class="inputMensaje spnMensajeUsuario"></span>
          	</div>
          	<div class="input-field">
          		<i class="material-icons prefix">vpn_key</i>
            	<input type="password" name="password" style="margin-bottom:0px">
            	<label for="password">Contraseña</label>
              <span class="inputMensaje spnMensajeClave"></span>
          	</div>
          </div>
          <center class="imgLoading hide">
            <img src="{{asset('img/loading.gif')}}">
          </center>
          <div class="input-field">
            <center><button type="button" class="btn cyan waves-effect btnIngresar">Ingresar</button></center>
          </div>
         </form> 
        </div>
        <a href="#">Olvide mi contraseña?</a>
        {{-- <a href="/register">Quiero Registrarme</a> --}}
      </div>
    </div>
  </div>
</div>
@endsection
@section("scripts")
@if(session('mensajeLogout'))
  <script type="text/javascript">
    Materialize.toast('{{session('mensajeLogout')}}',3000,'green');
  </script>
@endif
<script type="text/javascript">
	$(function(){
    $('.btnIngresar').click(function(){
      var usuario = obtenerCampoConDatos($('[name=username]')),
          clave = obtenerCampoConDatos($('[name=password]'));
      if (validarFormularioLogin(usuario,clave)) {
        $.ajax({
          url: '/login',
          method: 'post',
          data: {
            '_token':'{{csrf_token()}}',
            'username': usuario,
            'password': clave
          },
          dataType: 'json',
          beforeSend: function(){
            $('.imgLoading').each(function(){
              $(this).removeClass('hide');
              setInputMessages($('.spnMensajeUsuario'),'');
            });
          },
          success: function(response){
            console.log(response);
            if (response.ban == 0) {
              setInputMessages($('.spnMensajeUsuario'),response.mensaje);
              $('[name=password]').val('');
            }else{
              //el usuario fue encontrado
              Materialize.toast('¡Bienvenido! '+response.mensaje,1000,'green');
              window.location.href = response.url;
            }
          },
          complete: function(){
            $('.imgLoading').each(function(){
              $(this).addClass('hide');
            });
          }
        });
      }
    });
	});
  
  function obtenerCampoConDatos(input){
    var valor;
    input.each(function(){
      if ($(this).val() != '') {
        valor = $(this).val();
      }
    });
    if (valor != '') {
      return valor;
    }
  }
  function validarFormularioLogin(usuario,clave){
    var bandera = 0;
    if (usuario == null) {
      setInputMessages($('.spnMensajeUsuario'),'El campo usuario es obligatorio');
      bandera = 1;
    }else{
      setInputMessages($('.spnMensajeUsuario'),'');
    }
    if (clave == null) {
      setInputMessages($('.spnMensajeClave'),'El campo contraseña es obligatorio');
      bandera = 1;
    }else{
      setInputMessages($('.spnMensajeClave'),'');
    }
    if (bandera == 0) {
      return true;
    }else{
      return false;
    }
  }
  function setInputMessages(span,mensaje){
    span.text(mensaje);
  }
</script>
@endsection