<?php
  include("db/config.php") ;
  $link = mysqli_connect($server, $db_user, $db_pass) or die("Error " . mysqli_error($link)); 
  mysqli_select_db($link,$database);
  $poligonos = mysqli_query($link,"select * from restriccion AS r inner join poligono AS p on r.idpoligono=p.idpoligono inner join capa as c on c.idcapa=p.idcapa where p.idcapa>0 and p.nro_res>0 order by r.idpoligono, r.idrestriccion ") or die(mysqli_error($link));
  $capas = mysqli_query($link,"select * from capa order by idcapa ") or die(mysqli_error($link));
  $nrores= mysqli_num_rows($poligonos); 
  mysqli_close($link); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
 <title>Don't crash my drone</title>
  <meta name="description" content="Don't crash my drone">
  <meta name="author" content="LOSPIBE">

<link rel="shortcut icon" href="images/drone.png">
  <meta name="viewport" content="width=device-width,initial-scale=1">
<link href="css/base.css" rel="stylesheet">
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDtHKDeyiUpMgVSYXIGWfImz4ebvDeXWTA&sensor=true&language=es&libraries=geometry"></script>


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

  <div class="banner" style="opacity:0;">
  <div class="text-center container">
    <img class="imgbanner" src="images/geodronen.png">
    <h3 style="color:#efefef;">Don't Crash my Drone</h3>
 <a class=" but waves-attach " href="javascript:void(0);" onClick="iniciarGeoDron()"> Iniciar seguimiento</a>
  </div>
</div>
  <nav aria-hidden="true" class="menu" id="doc_menu" tabindex="-1">
    <div class="menu-scroll">
      <div class="menu-content">
        <a class="menu-logo" href="">Don't crash my drone</a>
        <ul class="nav">
          
          <li>
            <div class="container checks">
              <div class="checkbox switch">
                <label for="check">
                    <input class="access-hide" id="check" name="navegacion" type="checkbox" checked><span class="switch-toggle switch-toggle-orange"></span>Centrar mapa
                </label>
              </div>
            </div>
                   
          </li>
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
                <label for="bcelular">
                    <input class="access-hide" id="bcelular" name="bcelular" type="checkbox" checked><span class="switch-toggle switch-toggle-orange"></span>Smartphone - Nivel de bateria 
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
            <a class="collaosed waves-attach" data-toggle="collapse" href="#doc_menu_components">Configuracion</a>
            <ul class="menu-collapse collapse" id="doc_menu_components">
              <li>
                <div class="text-center" style="  padding: 10px;">
                   <form oninput="amount.value=ratio.value">
                          Radio de alerta: <output name="amount" for="ratio">50</output>mts.
                          <input id="ratio" type="range" placeholder="Radio de alerta" data-min="50" max="3000" step="10" value="50">
                    </form>
                </div>
              </li>
              
           <li>
            <a class="waves-attach" href="" onclick="iniciarCarga();" data-backdrop="static" data-toggle="modal" id="botonNueva">Agregar zona restringida</a>
          </li>              
          <li>
              <a class="waves-attach" href="#modalCapa" onclick="iniciarCapa();" data-backdrop="static" data-toggle="modal" id="botonCapa">Agregar capa</a>
          </li>
          <li>
            <div id="respuesta" style="min-height: 15px;"></div>
          </li>



                            
            </ul>
          </li>
          
         


          
        </ul>
      </div>
    </div>
  </nav>
    
   

<div id="map" ></div>




<a href="#" onclick="cerrarCarga();" id="botonTermina" style="display: none;"><div id="btntermina">Finalizar</div></a>

<div aria-hidden="true" class="modal modal-va-middle fade" id="modalCapa" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-heading">Crear nueva capa de restriccion</div>
            <div class="modal-inner"> 
                      <form name="crearCapa" id="crearCapa" action="db/nueva_capa.php" method="POST">
                        <div class="form-group form-group-label">
                            <label class="floating-label" for="nombrecapa"> Nombre </label>
                            <input type="text" class="form-control" name="nombrecapa" id="nombrecapa"  requiered="required">
                        </div>

                    

                        <input readonly="true"  type="text" name="colorcapa" id="colorcapa" onclick="showColorPicker(this,document.getElementById('colorcapa'));" placeholder="Seleccione el color" autocomplete="false"  requiered="required">
                        <input type="submit"  name="submitcapa" id="submitcapa" value="Crear">
                      </form>
             
            </div>
            
        </div>
    </div>
</div>
<div aria-hidden="true" class="modal modal-va-middle fade" id="modalConfirmar" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-heading">Confirmar restriccion</div>
            <div class="modal-inner"> 
                      <form name="confirmar" id="confirmar" action="db/actualizar_restriccion.php" method="POST">
                        
                        <div class="form-group form-group-label">
                                                   
                            <select class="form-control" name="idcapa" id="iddelacapa" required="required">
                              <option value="" id="esoptn">Seleccione una capa </option>
                              <?php  $cant=0; 
                              while($caps=mysqli_fetch_array($capas)) { ?>
                                    <option value=<?php echo $caps['idcapa']; ?> >
                                    <?php echo $caps['nombre'];?></option>
                              <?php }?>
                           </select>
                        </div>

                         <div class="form-group form-group-label">
                            <label class="floating-label" for="descripcion"> Ingrese la descripción </label>
                              <input   type="text" class="form-control" name="descripcion" id="descripcion" requiered="required">
                        </div>
                          
                       

                      
                        <input type="submit" name="submit" id="submit" value="Confimar restriccion" requiered="required">
                    </form>
            </div>
            
        </div>
    </div>
</div>



<div class="fbtn-container">
    <div class="fbtn-inner">
        <a class="fbtn" href="javascript:void(0);" onClick="centrar()" id="ccenter">
            <span  class="fbtn-ori icon icon-2x text-white-hint">my_location</span>
        </a>
         <a class="fbtn" href="javascript:void(0);" onClick="agrandar(this.id,'mainclima','ic')" id="cclima" >
             <span class="fbtn-ori icon icon-2x text-white-hint" id="ic">cloud</span>
             <div class="card-main" id="mainclima" style="display: none;">
          
               
                <div id="forecast" class="text-center">

                  <span id="location" style="color:#b8b8b8;"> </span>
                  <div class="col-md-3" id="imgdiv">
                    <img id="img" style="margin-top: 40px;" src=""/>
                  </div>
                  <div class="col-md-9">

                   
                     <p id="desc" style="margin:0;"> </p>
                     
                  </div>
                 </div>
            </div>
        </a>
        <a class="fbtn" href="javascript:void(0);" onClick="agrandar(this.id,'mains','is')"  id="cs">
          <span class="fbtn-ori icon icon-2x text-white-hint" id="is">signal_wifi_4_bar</span>
          <div class="card-main" id="mains" style="display: none;">
          
               
                 <canvas id="canvas"></canvas>
           
         </div>
          
        </a>
        <a class="fbtn" href="javascript:void(0);" onClick="agrandar(this.id,'maininfo','ii')" id="cinfo" >
          <span class="fbtn-ori icon icon-2x text-white-hint" id="ii">near_me</span>
            <div class="card-main" id="maininfo" style="display: none;">
              <div class="card-inner"> 
                
                <p class="textop">ID:<span id="idd"></span></p>
                <p class="textop">Latitud:<span id="lat"></span></p>
                <p class="textop">Longitud:<span id="lon"></span></p> 
                <p class="textop">Altitud:<span id="alt"></span></p>
                
                 <p><span id="time"></span><span id="reit"></span></p>
              </div>
             
            </div>
        </a>
       
        <a class="fbtn "      href="javascript:void(0);" onClick="agrandar(this.id,'mainalerta','ia')" id="calerta">
          <span class="fbtn-ori icon icon-2x text-white-hint" id="ia">report</span>
          <div class="card-main" id="mainalerta"  style="display: none;padding:0;">
            <div class="card-inner text-center" id="alertas" style="padding:10px;margin:0;height:120px;overflow-y: scroll;" class="alertas"> 
              Notificaciones de alerta:<br>
             
            </div>
           
        </div>
        </a>
      </div>
 
  </div>


<div id="battery" class="battery" ><div id="battery-level" class="battery-level"></div></div>

</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="js/base.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/alertas.js"></script>
<script src="js/parse-data.js"></script>
<script type="text/javascript" src="js/js_color_picker_v2.js"></script>
<script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel.js"></script>
<link rel="stylesheet" href="css/js_color_picker_v2.css" media="screen">
<script type="text/javascript" src="js/color_functions.js"></script>

<script type="text/javascript">
var vecvertices = new Array();
var vecmetar = new Array();
<?php
  //Declarando variables globales
  $band=0; $cont=0; $contv=0;

  while($pol=mysqli_fetch_array($poligonos)){
      if($band!=$pol['idpoligono']){ 
          if($cont>0){ echo "];";}
             echo "var poligono".$pol['idpoligono']."= [ "; $band= $pol['idpoligono'];  
             $cont++;  
             ?>
             
               <?php   }  ?>
               new google.maps.LatLng(<?php echo $pol['latitud'].", ".$pol['longitud']; ?>),
               <?php } if($nrores>0) {echo "];";}?>


               

<?php 
$contv=0;
$band=0;
 mysqli_data_seek($poligonos,0); while($pol=mysqli_fetch_array($poligonos)){ 
          if($band!=$pol['idpoligono']){ $band= $pol['idpoligono'];  ?>

              vecvertices[<?php echo $contv;?>]=new Array();
              vecvertices[<?php echo $contv;?>][0] = <?php echo "poligono".$pol['idpoligono'];?>;
              vecvertices[<?php echo $contv;?>][1] = "<?php echo $pol['idpoligono']; ?>";
              vecvertices[<?php echo $contv;?>][2] = "<?php echo $pol['color']; ?>";
              vecvertices[<?php echo $contv;?>][3] = "<?php echo $pol['nombre']; ?>";
              vecvertices[<?php echo $contv;?>][4] = "<?php echo $pol['descripcion']; ?>";
              vecvertices[<?php echo $contv;?>][5] = "<?php echo $pol['idcapa']; ?>"; 

             <?php $contv++;}}?>


var marker;
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



var canvas = document.getElementById("canvas");
var contexto = canvas.getContext("2d");
contexto.lineWidth = 8;
contexto.strokeStyle = '#99CC33';
 
var imd = null;
imd = contexto.getImageData(0, 0, 300, 300);

var d=parseFloat(0.0005);
$('#ratio').mousemove( function() { 
          
       radioalerta=$('#ratio').val();

});

//card desplazables
/*
window.onkeydown = function (e) {
    var code = e.keyCode ? e.keyCode : e.which;
    if (code === 38) { //up key
        marker.animateTo(xx2,yy2);

    } 
    if (code === 37) { //up key
        point=new google.maps.LatLng(xx1,yy1)
       // marker.animateTo(xx2,yy2);
        marker.setPosition(point);
        Circle.set("center",point);
        banim=true;
       // marker.animateTo(xx1,yy1);
    } 
};
var xx1=parseFloat(-32.930076);
var xx2=parseFloat(-32.930306);
var yy1=parseFloat(-60.651437);
var yy2=parseFloat(-60.650883);




      
*/
 
 $(document).ready(function(){ 

    window.onload=carga; 

    function carga(){
    posicion=0;
     setTimeout(function(){
     
    $(".banner").css("opacity", "1");
    }, 1000);

     $("#battery").css("opacity","0");
      $("#map").css("opacity","1");
    // IE
    if(navigator.userAgent.indexOf("MSIE")>=0) navegador=0;
    // Otros
    else navegador=1;
  }
});




function agrandar(id,disp,ic){
  if($("#"+id).css("border-radius")=="50%"){
   
      
       
        $("#"+id).css("border-radius","0");
        
         $("#"+ic).css("opacity","0");

        if(id=="calerta"){
            $("#"+id).css("height",120+"px");
             $("#"+id).css("width",400+"px");
        }else{
           $("#"+id).css("height",130+"px");
           $("#"+id).css("width",250+"px");
        }
        setTimeout(function(){
          $("#"+disp).css("display","block");
        },800); 

  }else{
    $("#"+id).css("height",40+"px");
    $("#"+id).css("width",40+"px");
    $("#"+id).css("border-radius","50%");
    $("#"+disp).css("display","none");
     $("#"+ic).css("opacity","1");
  }
}
function centrar(){

  map.setCenter(marker.getPosition());
}
function iniciarGeoDron(){
      
      $("#battery").css("opacity","0.5");
      $(".floatcard").css("opacity","0.7");
      $(".banner").css("opacity", "0");
      
   setTimeout(function(){
      
     $(".banner").remove();
    },450);
    WebSocketTest();
}
//checks

$('#check').change(function() {
        if($(this).is(":checked")) {
              seguir=true;
        }else{
          seguir=false;
        }
            
    });



$('#bcelular').change(function() {
        if($(this).is(":checked")) {
             $("#battery").css("opacity","0.7");
      
            
        }else{
            $("#battery").css("opacity","0");
           
        }
            
    });

$('#satelite').change(function() {
        if($(this).is(":checked")) {         
             map.setMapTypeId(google.maps.MapTypeId.HYBRID);
           
            
        }else{
         
            map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
           
        }
          
    });




      
    
$.getJSON('position.json', function(data) {
	    	 
   		 	 
    ilt=data.lat;
    ilg=data.long;
  	ila=data.alt;
  
    var pos_A = new google.maps.LatLng(parseFloat(data.lat),parseFloat(data.long));
    //initialize( pos_A);
      var options = {
        zoom: 16,
        center: new google.maps.LatLng(parseFloat(data.lat),parseFloat(data.long)),
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

			marker =  new MarkerWithLabel({
			    position: pos_A,
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
            
              center: marker.getPosition(),
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

  
//	$.getJSON('position.json', function(data) {

 function WebSocketTest(){
            if ("WebSocket" in window)  {
             
            var ws = new WebSocket('ws://spaceappsros.cloudapp.net:6789');

            ws.onopen = function () {
           
             
  
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



function updateBatteryDisplay(battery) {
  var level = battery;
  var batteryLevel = jQuery('.battery .battery-level');
  batteryLevel.css('width', parseInt(level) + '%');
  batteryLevel.text(parseInt(level) + '%');
  if (battery.charging) {
      batteryLevel.addClass('charging');
      batteryLevel.removeClass('high');  
      batteryLevel.removeClass('medium');  
      batteryLevel.removeClass('low');  
  } else if (level > 50) {  
      batteryLevel.addClass('high');  
      batteryLevel.removeClass('charging');
      batteryLevel.removeClass('medium');  
      batteryLevel.removeClass('low');  
  } else if (level >= 25 ) {  
      batteryLevel.addClass('medium');  
      batteryLevel.removeClass('charging');
      batteryLevel.removeClass('high');  
      batteryLevel.removeClass('low');  
  } else {  
      batteryLevel.addClass('low');  
      batteryLevel.removeClass('charging');
      batteryLevel.removeClass('high');  
      batteryLevel.removeClass('medium');  
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
      if(first){

        initialize( new google.maps.LatLng(parseFloat(data.lat),parseFloat(data.long)));
        
        var Weather = "http://api.wunderground.com/api/32b1434308e07127/forecast/conditions/lang:SP/q/" + ilt + "," + ilg+ ".json";
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

           $("#calerta").css("border-radius","0");
            
           $("#ia").css("opacity","0");

            
           $("#calerta").css("height",120+"px");
           $("#calerta").css("width",350+"px");
           
           setTimeout(function(){
              $("#mainalerta").css("display","block");

             
              
            },800); 
      
        first=false;
      }

             
          updateBatteryDisplay(data.batery);
          
	    		$("#lat").html(" "+data.lat);
	    		$("#lon").html(" "+data.long);
	    		$("#alt").html(" "+(data.alt*0.3048).toFixed(2)+"mts.");
          $("#idd").html(" "+data.id);

             latl=new google.maps.LatLng(parseFloat(data.lat),parseFloat(data.long));

              marker.setPosition(latl);
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
      //point=new google.maps.LatLng(parseFloat(data.lat)+d,parseFloat(data.long)-d);
         /*
        if(seguir){map.panTo(point);}
              //agrego el punto al array de la ruta
        path.push(point);
        //cargo la nueva ruta en la polilinea
        poliLinea.setPath(path);*/
        
        
        
 
}


//card desplazables
/*
function carga(){
    posicion=0;
    setTimeout(function(){
      
      WebSocketTest();
      $(".floatcard").css("opacity","0.7");}, 1500);
    $("#map").css("opacity","1");
    // IE
    if(navigator.userAgent.indexOf("MSIE")>=0) navegador=0;
    // Otros
    else navegador=1;
}

 var tt=(($(window).height() - $( "#calerta" ).height())-$( "#calerta" ).offset().bottom);
 var rr=(($(window).width() - $( "#calerta" ).width()) - $( "#calerta" ).offset().left);

function evitaEventos(event){
    // Funcion que evita que se ejecuten eventos adicionales
    if(navegador==0)
    {
        window.event.cancelBubble=true;
        window.event.returnValue=false;
    }
    if(navegador==1) event.preventDefault();
}
 
function comienzoMovimiento(event, id){
    elMovimiento=document.getElementById(id);
   
     // Obtengo la posicion del cursor
    if(navegador==0)
     {
        cursorComienzoX=-window.event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft;
        cursorComienzoY=-window.event.clientY+document.documentElement.scrollTop+document.body.scrollTop;
 
        document.attachEvent("onmousemove", enMovimiento);
        document.attachEvent("onmouseup", finMovimiento);
    }
    if(navegador==1)
    {   
        cursorComienzoX=-event.clientX+window.scrollX;
        cursorComienzoY=-event.clientY+window.scrollY;
       
        document.addEventListener("mousemove", enMovimiento, true);
        document.addEventListener("mouseup", finMovimiento, true);
    }
   

    elComienzoX=parseInt(rr);
    elComienzoY=parseInt(bb);
    // Actualizo el posicion del elemento
    elMovimiento.style.zIndex=++posicion;
   
    evitaEventos(event);
}
 
function enMovimiento(event){ 
    var xActual, yActual;
    if(navegador==0)
    {   
        xActual=-window.event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft;
        yActual=-window.event.clientY+document.documentElement.scrollTop+document.body.scrollTop;
    } 
    if(navegador==1)
    {
        xActual=-event.clientX+window.scrollX;
        yActual=-event.clientY+window.scrollY;
    }
   
    elMovimiento.style.right=(elComienzoX+xActual-cursorComienzoX)+"px";
    elMovimiento.style.bottom=(elComienzoY+yActual-cursorComienzoY)+"px";
 
    evitaEventos(event);
}
 
function finMovimiento(event){
    if(navegador==0)
    {   
        document.detachEvent("onmousemove", enMovimiento);
        document.detachEvent("onmouseup", finMovimiento);
    }
    if(navegador==1)
    {
        document.removeEventListener("mousemove", enMovimiento, true);
        document.removeEventListener("mouseup", finMovimiento, true);
    }
}
 */
/*
google.maps.Marker.prototype.animateTo = function(nuelat,nuelon, options) {
	var newPosition = {lat: nuelat, lng: nuelon};
        
  defaultOptions = {
    duration: 13000,
    easing: 'linear',
    complete: null
  }
  options = options || {};

  // complete missing options
  for (key in defaultOptions) {
    options[key] = options[key] || defaultOptions[key];
  }

  // throw exception if easing function doesn't exist
  if (options.easing != 'linear') {            
    if (typeof jQuery == 'undefined' || !jQuery.easing[options.easing]) {
      throw '"' + options.easing + '" easing function doesn\'t exist. Include jQuery and/or the jQuery easing plugin and use the right function name.';
      return;
    }
  }
  
  window.requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
  window.cancelAnimationFrame = window.cancelAnimationFrame || window.mozCancelAnimationFrame;

  // save current position. prefixed to avoid name collisions. separate for lat/lng to avoid calling lat()/lng() in every frame
  this.AT_startPosition_lat = this.getPosition().lat();
  this.AT_startPosition_lng = this.getPosition().lng();
  var newPosition_lat =nuelat;
  var newPosition_lng = nuelon;
  
  // crossing the 180° meridian and going the long way around the earth?
  if (Math.abs(newPosition_lng - this.AT_startPosition_lng) > 180) {
    if (newPosition_lng > this.AT_startPosition_lng) {      
      newPosition_lng -= 360;      
    } else {
      newPosition_lng += 360;
    }
  }

  var animateStep = function(marker, startTime) {            
    var ellapsedTime = (new Date()).getTime() - startTime;
    var durationRatio = ellapsedTime / options.duration; // 0 - 1
    var easingDurationRatio = durationRatio;

    // use jQuery easing if it's not linear
    if (options.easing !== 'linear') {
      easingDurationRatio = jQuery.easing[options.easing](durationRatio, ellapsedTime, 0, 1, options.duration);
    }
    
    if (durationRatio < 1) {
      var deltaPosition = new google.maps.LatLng( marker.AT_startPosition_lat + (newPosition_lat - marker.AT_startPosition_lat)*easingDurationRatio,
                                                  marker.AT_startPosition_lng + (newPosition_lng - marker.AT_startPosition_lng)*easingDurationRatio);
      

      marker.setPosition(deltaPosition);
      alertar(point);
      Circle.set("center",deltaPosition);
        path.push(deltaPosition);
        //cargo la nueva ruta en la polilinea
        poliLinea.setPath(deltaPosition);
      if(seguir){map.panTo(deltaPosition);}
      // use requestAnimationFrame if it exists on this browser. If not, use setTimeout with ~60 fps
      if (window.requestAnimationFrame) {
        marker.AT_animationHandler = window.requestAnimationFrame(function() {animateStep(marker, startTime)});                
      } else {
        marker.AT_animationHandler = setTimeout(function() {animateStep(marker, startTime)}, 17); 
      }

    } else {
      
      marker.setPosition(newPosition);
      Circle.set("center",newPosition);
        path.push(newPosition);
        //cargo la nueva ruta en la polilinea
        poliLinea.setPath(path);
     if(seguir){ map.panTo(newPosition);}
      if (typeof options.complete === 'function') {
        options.complete();
      }

    }            
  }

  // stop possibly running animation
  if (window.cancelAnimationFrame) {
    window.cancelAnimationFrame(this.AT_animationHandler);
  } else {
    clearTimeout(this.AT_animationHandler); 
  }
  
  animateStep(this, (new Date()).getTime());
}
*/

</script>
