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
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

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
              
           
          



                            
            </ul>
          </li>
          
           <li>
            <a class="waves-attach" href="/joaquin/piloto.php"  id="botonNueva">Modo Piloto</a>
          </li> 


          
        </ul>
      </div>
    </div>
  </nav>
    
   

<div id="map" ></div>







<div class="fbtn-container">
    <div class="fbtn-inner">
        <a class="fbtn" href="javascript:void(0);" onClick="centrar()" id="ccenter">
            <span class="fbtn-ori icon icon-2x text-white-hint">my_location</span>
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
            <div class="card-inner text-center" id="alertas" style="padding:0px;margin:0;height:120px;overflow-y: scroll;" class="alertas"> 
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

<script src="js/alertas.js"></script>
<script src="js/parse-data.js"></script>
<script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel.js"></script>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha512.js"></script>
<script type="text/javascript">

$('#almanaque').datepicker();
//no se porque pero con esto hace que anden los click de las burbujas
document.getElementById("cclima").style.borderRadius="20px";
document.getElementById("cinfo").style.borderRadius="20px";
document.getElementById("cs").style.borderRadius="20px";
document.getElementById("calerta").style.borderRadius="20px";
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

    

var canvas = document.getElementById("canvas");
var contexto = canvas.getContext("2d");
contexto.lineWidth = 8;
contexto.strokeStyle = '#99CC33';
 
var imd = null;
imd = contexto.getImageData(0, 0, 300, 300);


var dispositivos=new Array();



var d=parseFloat(0.0005);
$('#ratio').mousemove( function() { 
          
       radioalerta=$('#ratio').val();

});

//card desplazables
/*

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
 iniciarGeoDron();
             $("#idd").html("<?php echo $_SESSION['id']; ?>");

              iddispositivo=""+parseInt("<?php echo $_SESSION['id']; ?>");
function iniciarSesion(){

     var parametros = {
                    
                  "us": $("#usuario").val(),
                  "pas":$("#contraseña").val()

            };
       $.ajax({
          type:'POST',
          url:'db/login.php',
          data:parametros,
          success:function(respuesta){
             
          if (respuesta!=0) { 
            
           } 
          }
        })
 };

   


function agrandar(id,disp,ic){
  //alert(document.getElementById(id).style.borderRadius)
  
  if( document.getElementById(id).style.borderRadius!="20px"){
         
          $("#"+id).css("height","40px");
      $("#"+id).css("width","40px");
      $("#"+id).css("border-radius","20px");
       $("#"+disp).css("display","none")

       $("#"+ic).css("opacity","1");
        

  }else{
   


       $("#"+ic).css("opacity","0");
       
        $("#"+id).css("border-radius","0px");
        
         

        if(id=="calerta"){
            $("#"+id).css("height","120px");
             $("#"+id).css("width","400px");
        }else{
           $("#"+id).css("height","130px");
           $("#"+id).css("width","250px");
        }
        setTimeout(function(){
          $("#"+disp).css("display","block");
        },500); 
  }
}
function centrar(){

  map.setCenter(marker[iddispositivo].getPosition());
}

window.onkeydown = function (e) {
    var code = e.keyCode ? e.keyCode : e.which;
    if (code === 13) { //up key
      iniciarSesion();
    } 
    
};
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

$('#check').change(function() {
        if($(this).is(":checked")) {
              seguir=true;
        }else{
          seguir=false;
        }
       alert(dispositivos);     
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



function updateBatteryDisplay(battery) {
  var level = battery;
  var batteryLevel = jQuery('.battery .battery-level');
  batteryLevel.css('width', parseInt(level) + '%');
  batteryLevel.text(parseInt(level) + '%');
  if (level > 50) {  
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
