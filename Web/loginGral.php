<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
 <title>GeoDrone</title>
  <meta name="description" content="Don't crash my drone">
  <meta name="author" content="GeoDrone Inc.">
  <link rel="shortcut icon" href="images/drone.png"> 
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="css/base.css" rel="stylesheet">
<?php
require_once 'db/class.login.php';

session_start();

if(isset($_SESSION['id'])):
  header('location: index.php');
endif;

if(isset($_POST['login'])):
  $login = new Login(true, $_POST['us'], hash('sha512', strval($_POST['pas'])));
  $login->loguear();

  $errors = $login->getErrors();
  if(count($errors) == 0):
    header('location: index.php');
  endif;
else:
  $errors = array();
endif;

$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
?>
<!-- ESTE STYLE CAMBIA EL FONDO DEL AUTOCOMPLETE A BLANCO -->
<!-- ECHO POR JUAN -->

</head>

<body class="page-brand" >
  
  <div class="banner">
  <div class="text-center container ">
    <img class="imgbanner" src="images/geodronenb.png">
    <h3 style="color:#efefef;">Don't Crash my Drone</h3>
         <div  class="col-md-6 col-md-offset-3" >
          <div class="card">
              <div class="card-main">
                <nav class="tab-nav tab-nav-orange margin-top-no">
                  <ul class="nav nav-justified">
                    <li class="active">
                      <a class="waves-attach" data-toggle="tab" href="#tabpiloto">Modo Piloto</a>
                    </li>
                    <li>
                      <a class="waves-attach" data-toggle="tab" href="#tabexperimental">Modo Experimental</a>
                    </li>
                    
                  </ul>
                </nav>
                <div class="card-inner">
                    <div class="tab-content">
                      <p>
                      <?php
                        if(isset($errors['gral'])):
                          foreach($errors['gral'] as $error):
                            echo $error . '<br>';
                          endforeach;
                        endif;
                        ?>
                      </p>                    
                      <div class="tab-pane fade active in" id="tabpiloto">
                           <form action="loginGral.php" method="POST" autocomplete="on" class="form.-control">
                               <div class="form-group form-group-label">
                                    <label class="floating-label" for="usuarioP" style="color:#fff;">Usuario</label>
                                    <input type="text" class="form-control" maxlength="100" id="usuarioP"  style="color:#fff;border-color:#fff;" name="us" required="required">
                                     <div class="form-help help">
                                        <p class="text-red" id="helpE1">Ingrese su E-mail</p>
                                        <?php
                                          if(isset($errors['us'])):
                                            foreach($errors['us'] as $error):
                                              echo $error . '<br>';
                                            endforeach;
                                          endif;
                                        ?>
                                    </div>
                                </div>
                                 <div class="form-group form-group-label">
                                    <label class="floating-label" for="contraseñaP" style="color:#fff;"> Contraseña </label>
                                    <input type="password" name="pas" class="form-control" id="contraseñaP" maxlength="40" style="color:#fff;border-color:#fff;" required="required">
                                    <div class="form-help help">
                                      <p class="text-red" id="helpE2">Ingrese su contraseña</p>
                                      <?php
                                        if(isset($errors['pas'])):
                                          foreach($errors['pas'] as $error):
                                            echo $error . '<br>';
                                          endforeach;
                                        endif;
                                      ?>
                                    </div>
                                    <input type="hidden" name="token" value="<?php echo $token; ?>" />
                                    <input type="hidden" name="tipo" value="P" />
                                </div>

                                <!-- <a class=" but waves-attach " onClick="iniciarSesion('P')"> Iniciar sesión</a> -->
                                <input type="submit" value="Aceptar" name="login" />
                          </form>
                        </div>

                      <div class="tab-pane fade" id="tabexperimental">
                         <form action="loginGral.php" method="POST" autocomplete="on" class="form.-control">

                               <div class="form-group form-group-label">
                                    <label class="floating-label" for="usuarioE" style="color:#fff;"> Usuario </label>
                                    <input style="color:#fff;border-color:#fff;" type="text" class="form-control" name="us" id="usuarioE" maxlength="100" required="required">
                                     <div class="form-help help" >
                                      <p class="text-red" id="helpE1">Ingrese su E-mail</p>
                                      <?php
                                        if(isset($errors['us'])):
                                          foreach($errors['us'] as $error):
                                            echo $error . '<br>';
                                          endforeach;
                                        endif;
                                      ?>
                                    </div>
                                </div>
                                 <div class="form-group form-group-label">
                                    <label class="floating-label" for="contraseñaE" style="color:#fff;"> Contraseña </label>
                                    <input style="color:#fff;border-color:#fff;" type="password" class="form-control" maxlength="40" name="pas" required="required" id="contraseñaE">
                                     <div class="form-help help">
                                      <p class="text-red" id="helpE2" >Ingrese su contraseña</p>
                                      <?php
                                        if(isset($errors['pas'])):
                                          foreach($errors['pas'] as $error):
                                            echo $error . '<br>';
                                          endforeach;
                                        endif;
                                      ?>
                                    </div>
                                    <input type="hidden" name="token" value="<?php echo $token; ?>" />
                                    <input type="hidden" name="tipo" value="E" />
                                </div>
                                 <!-- <a class=" but waves-attach " onClick="iniciarSesion('E')"> Iniciar sesión</a> -->
                                 <input type="submit" value="Aceptar" name="login" />
                           </form>
                        </div>
                       
                    </div>
                    <div class="el-loading" id="sendingComent">
                      <div class="el-loading-indicator el-loading-indicator-linear">
                        <div class="progress progress-position-absolute-top">
                          <div class="progress-bar-indeterminate"></div>
                        </div>
                      </div>
                  </div>

                  </div>
                </div>
              </div>
            </div>
  </div>
</div>
  
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="js/base.js"></script>
<script type="text/javascript">
var type;
//verifica todos los campos, muestra las alertas y manda el post
function iniciarSesion(tipo){
  /*
      var b=true;
      $(".help").css("display","none");
      $("#sendingComent").css('opacity','1');
    
      if(!validarEmail($("#usuarioP").val())){
        b=false;
        $("#helpP1").css("display","block");
        $("#sendingComent").css('opacity','0');
      }
      if(!validarEmail($("#usuarioE").val())){
        b=false;
        $("#helpE1").css("display","block");
        $("#sendingComent").css('opacity','0');
      }

        if($("#contraseñaE").val()==""){
        b=false;
        $("#helpE2").css("display","block");
        $("#sendingComent").css('opacity','0');
      }
      if($("#contraseñaP").val()==""){
        b=false;
        $("#helpP2").css("display","block");
        $("#sendingComent").css('opacity','0');
      }

      if(b==true){
*/
        //iniciar(tipo);
    
    //  }
    

 };
  function validarEmail( email ) {
        expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return expr.test(email);
        
    }
 function iniciar(tipo){
      var parametros = {
                    
                  "us": $("#usuario"+tipo).val(),
                  "pas":$("#contraseña"+tipo).val()

      };
      $.ajax({
          type:'POST',
          url:'db/login.php',
          data:parametros,
          success:function(respuesta){
             
          if (respuesta!=0) { 
            
                window.location.href = "/joaquin/index.php?idusuario="+parseInt(respuesta);
           
          } else{
            
          }
          }
        });
       }
window.onkeydown = function (e) {
    var code = e.keyCode ? e.keyCode : e.which;
    if (code === 13) { //up key
      iniciarSesion(type);
    } 
    
};

      
  
$('.tab-nav a').on('shown.bs.tab', function(event){
    var x = $(event.target).text();         // active tab
    
    if(x="Modo Piloto"){
       type="P";
    }else{
       type="E";
    }
});
   </script>