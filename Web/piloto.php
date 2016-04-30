<?php session_start();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true  )
    {

    }
    else
    {
      header("location: /joaquin/index.php");
      exit();
    
    }
    $now = time(); // checking the time now when home page starts

    if($now > $_SESSION['expire'])
    {
      session_destroy();
      header("location: /joaquin/index.php");
      exit();
      
    }
    ?>
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
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDtHKDeyiUpMgVSYXIGWfImz4ebvDeXWTA&sensor=true&language=es&libraries=geometry"></script>



<!-- ESTE STYLE CAMBIA EL FONDO DEL AUTOCOMPLETE A BLANCO -->
<!-- ECHO POR JUAN -->
<style type="text/css">
#botonTerminaMision{
  position: absolute;
  margin: 5px 48%;
  bottom: 5px;
}
  #btnterminamision{
  background: #333333;
  padding: 5px;
  color:#eeeeee;
  font-size: 18px;
}
</style>
</head>

<body class="page-brand" >
  <header class="header header-transparent header-waterfall">
    <ul class="nav nav-list pull-left">
      <li>
        <a data-toggle="menu" href="#doc_menu">
          <span class="icon icon-2x text-orange">menu</span>
        </a>
      </li>
     

    </ul>
      
   
    
  </header>

  <nav aria-hidden="true" class="menu" id="doc_menu" tabindex="-1">
    <div class="menu-scroll">
      <div class="menu-content">
        <a class="menu-logo" href="">Don't crash my drone</a>
        <ul class="nav">
          
         
          <li>
            <div class="container checks">
              <div class="checkbox switch">
                <label for="zr">
                    <input class="access-hide" id="zr" name="zonar" type="checkbox" checked><span class="switch-toggle switch-toggle-orange"></span>Zonas restringidas
                </label>
              </div>
            </div>
                   
          </li>
         
          <li>
            <div class="container checks">
              <div class="checkbox switch">
                <label for="satelite">
                    <input class="access-hide" id="satelite" name="satelite" type="checkbox" ><span class="switch-toggle switch-toggle-orange"></span>Vista satelital
                </label>
              </div>
            </div>
                   
          </li>
       



          <li>
            
              <li>
                <a class="waves-attach" href="#modalConfigUs" onclick=""  data-toggle="modal" id="">Informacion de usuario</a>
              </li>
              
           <li>
            <a class="waves-attach" href="" onclick="iniciarCarga();" data-backdrop="static" data-toggle="modal" id="botonNueva">Agregar zona restringida</a>
          </li>              
          <li>
              <a class="waves-attach" href="#modalCapa" onclick="iniciarCapa();" data-backdrop="static" data-toggle="modal" id="botonCapa">Agregar capa</a>
          </li>
          <li>
              <a class="waves-attach" href="#modalMision" onclick="iniciarMision();" data-backdrop="static" data-toggle="modal" id="botonMision">Nueva Misión</a>
          </li>
          <li >
              <a class="waves-attach" href="#" onclick="cancelarCarga();" style="display: none;" id="botonCancelaCarga">Cancelar carga</a>
          </li>
          <li >
              <a class="waves-attach" href="#" onclick="cancelarMision();" style="display: none;" id="botonCancelaMision" >Cancelar mision</a>
          </li>
          

           <li>
            <a class="waves-attach" href="/piloto.php"  id="botonNueva">Modo Experimental</a>
          </li> 

                            
            </ul>
          </li>
          
         


          
        </ul>
      </div>
    </div>
  </nav>
    
   

<div id="map" ></div>

<div class="card card-brand " id="card-iniciar-carga" style="display: none; opacity: 0.6; margin: 0 40%; text-align: center;">
    <div class="card-main">
        <div class="card-inner" id="card-carga-body" style="text-align: center;">Seleccione los puntos en el mapa.<br>Presione ESC para cancelar.</div>
    </div>
</div>




<a href="#" onclick="cerrarCarga();" id="botonTermina" style="display: none;"><div id="btntermina">Finalizar</div></a>
<a href="#" onclick="cerrarMision();" id="botonTerminaMision" style="display: none;"><div id="btnterminamision">Finalizar</div></a>



<div aria-hidden="true" class="modal modal-va-middle fade" id="modalCapa" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-heading" style="text-align: center;"><h5>Crear nueva capa de restriccion</h5></div>
            <div class="modal-inner" style="text-align: center;"> 
                      <form name="crearCapa" id="crearCapa" action="db/nueva_capa.php" method="POST">
                        <div class="form-group form-group-label">
                            <label class="floating-label" for="nombrecapa"> Nombre </label>
                            <input type="text" class="form-control" name="nombrecapa" id="nombrecapa"  required="required">
                        </div>

                      <div class="form-group form-group-label">
                          <label class="floating-label" for="colorcapa"> Seleccione un color </label>
                           <input style="cursor:pointer;" value="#ff0000"  type="color" name="colorcapa" id="colorcapa" class="form-control"  required="required">
                        </div>

                       
                        <input type="submit"  name="submitcapa" id="submitcapa" value="Crear">
                        <a class="btn-cancel" data-dismiss="modal" onclick="cancelarCapa();">Cancelar</a>
                      </form>
             
            </div>
            
        </div>
    </div>
</div>
<div aria-hidden="true" class="modal modal-va-middle fade" id="modalConfirmar" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-heading" style="text-align: center;"><h5>Confirmar restriccion</h5></div>
            <div class="modal-inner" style="text-align: center;"> 
                      <form name="confirmar" id="confirmar" action="db/actualizar_restriccion.php" method="POST">
                        
                        <div class="form-group form-group-label">
                                                   
                            <select class="form-control" name="idcapa" id="iddelacapa" required="required">
                              <option value="" id="esoptn">Seleccione una capa </option>
                              
                           </select>
                        </div>

                        

                         <div class="form-group form-group-label">
                            <label class="floating-label" for="descripcion"> Ingrese la descripción </label>
                              <input   type="text" class="form-control" name="descripcion" id="descripcion" required="required">
                        </div>
                          
                       

                      
                        <input type="submit" name="submit" id="submit" value="Confimar restriccion" required="required">
                        <a class="btn-cancel" data-dismiss="modal" onclick="cancelarCarga();">Cancelar</a>
                    </form>
            </div>
            
        </div>
    </div>
</div>

<div aria-hidden="true" class="modal modal-va-middle fade" id="modalConfirmarMision" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-xs">
        <div class="modal-content" style="text-align: center;" >
            <div class="modal-heading" style="text-align: center;"><h5>Confirmar vuelo</h5></div>
            <div class="modal-inner"> 
                      <form name="confirmarMision" id="confirmarMision" action="db/actualizar_restriccion_vuelo.php" method="POST">
                        <div class="form-group form-group-label">
                                                   
                            <select class="form-control" name="idtipovuelo" id="iddelvuelo" required="required">
                              <option value="" id="esoptn2">Seleccione un tipo de vuelo</option>
                           
                           </select>
                        </div>
                        <div class="form-group form-group-label">
                                                   
                            <select class="form-control" name="iddron" id="iddron" required="required">
                              <option value="" id="esoptn3">Seleccione el equipo</option>
                              
                           </select>
                        </div>
                       
                          <div class="row">
                        
                               <div class="form-group form-group-label col-xs-6">
                                  <label class="floating-label" for="altura_min">Altitud mínima (mts.)</label>
                                  <input type="number" class="form-control"
                                  name="altura_min" id="altura_min" required="required">
                              </div>
                          

                          
                              <div class="form-group form-group-label col-xs-6">
                                <label class="floating-label" for="altura_max">Altitud máxima (mts.)</label> 
                                <input type="number" class="form-control"
                                 name="altura_max" id="altura_max" required="required"> 
                              </div>
                          
                          </div>
                       <div class="row">
                <!--       <input type="date" name="dia" />       -->
                          <div class="form-group form-group-label">
                              <label class="floating-label" for="almanaque">Fecha</label>
                               <input class="datepicker-adv form-control" name="dia" id="almanaque" required="required" type="text">
                          </div>
                        </div>
                        <div class="row">
                           <div class="form-group form-group-label">
                              <label class="floating-label" for="hora">Hora de inicio</label>
                               <input id="hora" name="hora" class="form-control" required="required"></input>
                          </div>
                       
                         </div>
                           <!--
                          <input style="max-width:100px;" type="number" class="form-control" name="horas" id="horas" required="required" >
                            
                        
                      
                          <input style="max-width:100px;" type="number" class="form-control" name="minutos" id="minutos" required="required"> 
                        -->
                       
                     <div class="row">
                       <div class="form-group form-group-label">
                            <label class="floating-label" for="baterias">Cantidad de baterias</label>
                              <input   type="number" class="form-control" name="baterias" id="baterias" value="1">
                        </div>
                            </div>
                        <input type="submit" name="submit" id="submit" value="Guardar" required="required">
                        <a class="btn-cancel" data-dismiss="modal">Cancelar</a>
                    </form>
            </div>
            
        </div>
    </div>
</div>


<div aria-hidden="true" class="modal modal-va-middle fade" id="modalConfigUs" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-xs">
        <div class="modal-content" style="text-align: center;" >
            <div class="modal-heading" style="text-align: center;"><h5>Perfil de usuario</h5></div>
            <div class="modal-inner"> 
                      <form name="" id="" action="" method="POST">
                       
                          <div class="row">
                        
                               <div class="form-group form-group-label ">
                                  <label class="floating-label" for="nombreusuario">Nombre de usuario</label>
                                  <input type="text" class="form-control"
                                  name="nombreusuario" id="nombreusuario" required="required">
                              </div>
                          
                          </div>
                          <div class="row">
                              <div class="form-group form-group-label ">
                                <label class="floating-label" for="telefono">Teléfono</label> 
                                <input type="text" class="form-control"
                                 name="telefono" id="telefono" required="required"> 
                              </div>
                          </div>
                          
                     
                       

                         <div class="row  "> 
                          <div class="col-xs-6">

                            <p>Dron1</p>
                            <p>Dron3</p>
                            <p>Dron2</p>

                          </div>  
                           <div class="tile-wrap col-xs-6">
                              <div class="tile tile-collapse ">
                                <div data-target="#ui_tile_example1" data-toggle="tile">
                                  <div class="tile-inner">
                                    <div class="text-overflow">Seleccionar modelo</div>


                                  </div>
                                </div>
                                <div class="tile-active-show collapse" id="ui_tile_example1" style="height: 0px;">
                                  <div class="tile-sub">
                                    
                                  </div>
                                 
                                </div>
                              </div>
                              <div class="tile tile-collapse ">
                                <div data-target="#ui_tile_example2" data-toggle="tile">
                                  <div class="tile-inner">
                                    <div class="text-overflow">Modelo personalizado</div>
                                     

                                  </div>
                                </div>
                                <div class="tile-active-show collapse" id="ui_tile_example2" style="height: 0px;">
                                  <div class="tile-sub">
                                     <div class="form-group form-group-label ">
                                        <label class="floating-label" for="nombremodelo">Identificador</label> 
                                        <input type="text" class="form-control"
                                         name="nombremodelo" id="nombremodelo" required="required"> 
                                      </div>
                                      <div class="form-group form-group-label ">
                                        <label class="floating-label" for="peso">Peso</label> 
                                        <input type="text" class="form-control"
                                         name="peso" id="peso" required="required"> 
                                      </div>
                                       <div class="form-group form-group-label ">
                                        <label class="floating-label" for="frecuencia">Frecuencia radial</label> 
                                        <input type="text" class="form-control"
                                         name="frecuencia" id="frecuencia" required="required"> 
                                      </div>
                                       <div class="form-group form-group-label ">
                                        <label class="floating-label" for="durbat">Duración de batería</label> 
                                        <input type="text" class="form-control"
                                         name="durbat" id="durbat" required="required"> 
                                      </div>
                                  </div>
                                  <div class="tile-footer">
                                    <div class="tile-footer-btn pull-left">
                                      <a class="btn btn-flat waves-attach waves-effect" href="">Crear</a>
                                      <a class="btn btn-flat waves-attach waves-effect" data-toggle="tile" href="#ui_tile_example_red">Cancelar</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                           </div>
                        <input type="submit" name="submit" id="submit" value="Confimar vuelo" required="required">
                        <a class="btn-cancel" data-dismiss="modal" onclick="cancelarMision();">Cancelar</a>
                    </form>
            </div>
            
        </div>
    </div>
</div>




</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="js/base.js"></script>

<script src="js/alertas.js"></script>
<script src="js/parse-data.js"></script>
<script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel.js"></script>
<script src="js/lolliclock.js"></script>
<link href="css/lolliclock.css" rel="stylesheet">

<script type="text/javascript">

$('#almanaque').datepicker();
$('#hora').lolliclock({autoclose:true,hour24:true, format: 'You selecte!d: yyyy,mm,dd',formatSubmit: 'yyyy/mm/dd'});

/*$(function() {
    $( ".fbtn" ).draggable();
});


*/
var marker=new Array();
var iddispositivo;
var map;
var Circle;
var infoWindows = [];
var seguir=true;
var ilt,ilg,ila;
var path = new Array();     // ruta
var poliLinea;
var radioalerta=100;
var a=0;
var p=0;
var dsc=true;
var level ;
var batteryLevel = jQuery('.battery .battery-level');


var banim=false;
  var twq=0;
var first=true;
var lastl="",lastg="",lasta="";
var c=0;



var pos_A=new google.maps.LatLng(-32.95448707,-60.63181159);
      var options = {
        zoom: 15,
        center: pos_A,
         mapTypeId: google.maps.MapTypeId.ROADMAP ,
        panControl: false,
          zoomControl: false,
          mapTypeControl: false,
          scaleControl: false,
          streetViewControl: false,
          disableDefaultUI: true,
          overviewMapControl: false
      };
      
      map = new google.maps.Map(document.getElementById('map'), options);

    

var dispositivos=new Array();

//card desplazables
/*

var xx1=parseFloat(-32.930076);
var xx2=parseFloat(-32.930306);
var yy1=parseFloat(-60.651437);
var yy2=parseFloat(-60.650883);




      
*/

 //   iniciarGeoDron();
           
 $("#map").css("opacity","1");
   // iddispositivo=""+parseInt(respuesta);


function iniciarGeoDron(){
      
      $("#battery").css("opacity","0");
      $(".floatcard").css("opacity","0.7");
      $(".banner").css("opacity", "0");
      
     setTimeout(function(){
        
       $(".banner").remove();
      },450);
       WebSocketTest();
}
//checks


$('#satelite').change(function() {
        if($(this).is(":checked")) {         
             map.setMapTypeId(google.maps.MapTypeId.HYBRID);
           
            
        }else{
         
            map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
           
        }
          
    });




setInterval(function() {
  c++;
  if(c>=40){

            banim=false;
            $("#lat").html("Desconectado");
            $("#lon").html("Desconectado");
            $("#alt").html("Desconectado");
            $("#idd").html("Desconectado");
            $("#sensor1").html("Desconectado");
            $("#battery").css("opacity","0");
              dsc=true;
        }
  $("#reit").html("("+c+")");
}, 1000);

  
//  $.getJSON('position.json', function(data) {

 function WebSocketTest(){
            if ("WebSocket" in window)  {
             
            var ws = new WebSocket('ws://spaceappsros.cloudapp.net:6789');

            ws.onopen = function () {
              var msg = {
                source: "js",
                userid:   iddispositivo,
                date: Date.now()
              };
              ws.send(JSON.stringify(msg));
             console.log(JSON.stringify(msg));
  
            };
        
            ws.onmessage = function (evt)  { 
               //  console.log(evt.data);
               //  actualizardata(JSON.parse(evt.data));
             
               actualizardata(JSON.parse(evt.data));
               //  console.log(JSON.parse(evt.data));
             };
        
            ws.onclose = function() { 
                  // websocket is closed.
                 console.log("Connection is closed..."); 
                            
            }
            
            }else
            {
               // The browser doesn't support WebSocket
               console.log("WebSocket NOT supported by your Browser!");
            }
        

}





function animate(){
              
      
      if(a<100){

        a++;

        if(a>p){
          contexto.strokeStyle = '#ff3333';
        }else{
          contexto.strokeStyle = '#99CC33';
        }

      } else{
       a=0;
        contexto.putImageData(imd, 0, 0);
      }        
     
       contexto.beginPath();
      contexto.arc(canvas.width/2, canvas.height, a, Math.PI, 0, false);
      contexto.stroke();
      setTimeout(animate,10);
      
    }
function actualizardata(data){
     d+=parseFloat(0.00008);
    latl=new google.maps.LatLng(parseFloat(data.lat),parseFloat(data.long));
      if(first){
       
       
        dispositivos[data.id]=latl;
          marker[data.id] =  new MarkerWithLabel({
          position: latl,
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 0, //tamaño 0
          },
          map: map,
          draggable: false,
          labelAnchor: new google.maps.Point(8,8 ),
          labelClass: "labelmarker", // the CSS class for the label
        });

       Circle = new google.maps.Circle({
              strokeColor: '#FDAF3E',
              strokeOpacity: 0.9,
              strokeWeight: 1,
              fillColor: '#FDAF3E',
              fillOpacity: 0.1,
              map: map,
            
              center: marker[data.id].getPosition(),
              radius: 100
        });
        poliLinea = new google.maps.Polyline({ //polilinea
        path: path,
        strokeColor: '#FDAF3E',
        strokeOpacity: 0.2,
        strokeWeight: 6
     });
     poliLinea.setMap(map);
      setInterval(function() {
           
            
          Circle.setRadius(twq);
          if(banim){
           
            twq+=parseInt(radioalerta/30);
          }
          else{
              
             twq=0;
          }
            if(twq>=radioalerta){
              twq=0;
            }
        }, 60);
        initialize(latl );
        

        var Weather = "http://api.wunderground.com/api/32b1434308e07127/forecast/conditions/lang:SP/q/" + data.lat + "," + data.long+ ".json";
        $.ajax({
          url : Weather,
          dataType : "jsonp",
          success : function(data) {
           var Forcast = data['forecast']['txt_forecast']['forecastday'];

          var location=data['current_observation']['display_location']['full'];
          //
          animate();
          banim=true;
          var img = Forcast[1]['icon_url'];
          var desc =Forcast[1]['fcttext_metric'];
          $('#location').html(location);

          $('#desc').html(desc);

          //filling the image src attribute with the image url
          $('#img').attr('src', img);

          }
        });

               alertar(latl);
           $("#calerta").css("border-radius","0");
            
           $("#ia").css("opacity","0");

            
           $("#calerta").css("height",120+"px");
           $("#calerta").css("width",350+"px");
           
           setTimeout(function(){
              $("#mainalerta").css("display","block");

             
              
            },800); 
      
        first=false;
      }
      if(data.id==iddispositivo){
          
          dispositivos[data.id]=latl;
          updateBatteryDisplay(data.batery);
          
          $("#lat").html(" "+data.lat);
          $("#lon").html(" "+data.long);
          $("#alt").html(" "+(data.alt*0.3048).toFixed(2)+"mts.");
          $("#idd").html(" "+data.id);

             

             marker[data.id].setPosition(latl);
             Circle.set("center",latl);
             alertar(latl);
              //agrego el punto al array de la ruta
              path.push(latl);
            //cargo la nueva ruta en la polilinea
             poliLinea.setPath(path);

             p=data.sensor1;
            if(p<100){
              $("#sensor1").html(" "+data.sensor1+"cm.");
            }else{
              $("#sensor1").html("Libre");
            }
            
             
            $("#time").html(" "+data.time);
           
            $("#cs").css("opacity",.9);
           
              dsc=false;
            c=0;

        banim=true;
      }else{
        if(marker[data.id]==null){
          marker[data.id] =  new MarkerWithLabel({
          position: latl,
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 0, //tamaño 0
          },
          map: map,
          draggable: false,
          labelAnchor: new google.maps.Point(8,8 ),
          labelClass: "labelmarker2", // the CSS class for the label
        });
        }else{
          marker[data.id].setPosition(latl);
        }
        


      }
      //point=new google.maps.LatLng(parseFloat(data.lat)+d,parseFloat(data.long)-d);
         /*
        if(seguir){map.panTo(point);}
              //agrego el punto al array de la ruta
        path.push(point);
        //cargo la nueva ruta en la polilinea
        poliLinea.setPath(path);*/
        
        
        
 
}

</script>
