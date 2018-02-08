@extends("layout.app")

@section("contenido")

<nav class="hide">
  <ul><li><a class="button-collapse" data-activates="sideNav" href="#"><i class="material-icons">menu</i></a></li></ul>
</nav>

<ul id="sideNav" class="side-nav fixed valign">
 <form>
  <center><img style="margin-top: 50px" class="responsive-img" src="{{asset('img/user.jpg')}}" width="50%"></center>
  <div class="container">
    <div class="input-field">
      <i class="material-icons prefix">perm_identity</i>
      <input type="text" name="name">
      <label for="name">Usuario</label>
    </div>
    <div class="input-field">
    	<i class="material-icons prefix">vpn_key</i>
      <input type="password" name="password">
      <label for="password">Contraseña</label>
    </div>
    <div class="input-field">
      <center><button type="submit" class="btn cyan waves-effect">Ingresar</button></center>
    </div>
  </div>
  <div class="row"></div>
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
            	<input type="text" name="name">
           		<label for="name">Usuario</label>
          	</div>
          	<div class="input-field">
          		<i class="material-icons prefix">vpn_key</i>
            	<input type="password" name="password">
            	<label for="password">Contraseña</label>
          	</div>
          </div>
          <div class="input-field">
            <center><button type="submit" class="btn cyan waves-effect">Ingresar</button></center>
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
<script type="text/javascript">
	$(function(){
		$(".button-collapse").sideNav({
			menuWidth: 400,
			edge: "right"
		});
	});
</script>
@endsection

