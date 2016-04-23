var listaMarkers = [];
var unirPuntos = [];
var evenlist;
var polyg;
var path;
var vecIw= new Array();
var vecNotif = new Array();
var vecNotifAux = new Array(); 
/*function updateMarkerPosition(latLng) {
 
  point= new google.maps.LatLng(latLng.lat(), latLng.lng());
}
*/

function mostrarRestricciones(){
      for (var i=0; i<vecvertices.length; i++){
        if(vecvertices[i][6]){
          vecvertices[i][6].setMap(map);
        }
      }
}
function ocultarRestricciones(){
      for (var i=0; i<vecvertices.length; i++){
          if(vecvertices[i][6]){
          vecvertices[i][6].setMap(null);
        }
      }
}

function showInfo(event) {
  var iw = new google.maps.InfoWindow();
   iw.close();//hide the infowindow
  iw.setContent(this.info);
  iw.setPosition(event.latLng);
  iw.open(this.map);

  vecIw.push(iw);
  if(vecIw.length-2>=0)
    vecIw[vecIw.length-2].close();
}
function crearPoligonos(latA, lngA){
   for (var i = 0; i < vecvertices.length; i++) {

       poligono = new google.maps.Polygon({
              paths: vecvertices[i][0],
              strokeColor: vecvertices[i][2],
              strokeOpacity: 0.4,
              strokeWeight: 2,
              fillColor: vecvertices[i][2],
              fillOpacity: 0.35,
              map: null,
              info: "<div><b>" + vecvertices[i][3] + "</b></div><div>" + vecvertices[i][4] + "</div>"
           });
      
         /*vecvertices[i][6]= poligono;
        poligono.setMap(map);

        google.maps.event.addListener(poligono,"click", showInfo);*/
      var tolerance= 8000*0.001 / 111.320;
      var pointt= new google.maps.LatLng(latA, lngA);
      //pointt= new google.maps.LatLng(-32.95145945018134, -60.63886007036132);

      var resul2 =  google.maps.geometry.poly.containsLocation(pointt, poligono);
      var rsul = google.maps.geometry.poly.isLocationOnEdge(pointt, poligono, tolerance);
      vecvertices[i][6]= poligono;
      
      if(rsul || resul2){
        
        poligono.setMap(map);

        google.maps.event.addListener(poligono,"click", showInfo);
      } else {
        
       vecvertices.splice(i,1)
       //delete vecvertices[3];
      }
       

  }
}
function initialize(pos_A) {
  
 $( "#calerta" ).addClass( "boxAlertaVerde" );
  
  var iw = null;
  
  var latA= pos_A.lat();
  var lngA= pos_A.lng();
   getDatosMetar(latA, lngA, function(data) {
        for(var i = 0;i < data.length;i++) {
              var lat= data[i]["lat"];
              var lon= data[i]["long"];
              var myLatLng = {lat: lat, lng: lon};
              var image = "images/nube.png";
              var markerZona = new google.maps.Marker({
                position: myLatLng,
                title: 'Point A',
                map: map,
                draggable: false,
                 icon: image
              });

              markerZona.setMap(map);

              poligono = new google.maps.Polygon({
                paths: [myLatLng],
                strokeColor: '#FF0000',
                strokeOpacity: 0.4,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                info: "Jajajaj"
              });
              var indice = vecmetar.length;
              vecmetar[indice] = new Array();
              vecmetar[indice][0] = poligono;
              vecmetar[indice][1] = data[i]['temperatura']; 
              vecmetar[indice][2] = data[i]['punto_rocio']; 
              vecmetar[indice][3] = data[i]['visibilidad']; 
              vecmetar[indice][4] = data[i]['velocidad_viento']; 
              vecmetar[indice][5] = data[i]['orientacion_viento']; 
              vecmetar[indice][6] = "metar"; 

              poligono.setMap(map);

        
          
        }
   });
   getDatosTaf(latA, lngA, function(data) {
        for(var i = 0;i < data.length;i++) {

              var lat= data[i]["lat"];
              var lon= data[i]["long"];
              var myLatLng = {lat: lat, lng: lon};
              var image =  'images/nube.png';
              var markerZona = new google.maps.Marker({
                position: myLatLng,
                title: 'Point A',
                map: map,
                draggable: false,
                icon: image
              });

              markerZona.setMap(map);

              poligono = new google.maps.Polygon({
                paths: [myLatLng],
                strokeColor: '#FF0000',
                strokeOpacity: 0.4,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                info: "Jajajaj"
              });
              var indice = vecmetar.length;
              vecmetar[indice] = new Array();
              vecmetar[indice][0] = poligono;
              vecmetar[indice][1] = data[i]['turbulencia']; 
              vecmetar[indice][2] = data[i]['nevando']; 
              vecmetar[indice][6] = "taf"; 


              poligono.setMap(map);

       
          
        }
   });
    
   getDatosSigmet(latA, lngA, function(data) {

    for(var i = 0;i < data.length;i++) {
      var puntospoligono = new Array(); 
        for(var j = 0;j < data[i]["area"].length;j++) {
            var vertice = new google.maps.LatLng(data[i]["area"][j]["lat"], data[i]["area"][j]["long"]);
            puntospoligono.push(vertice);
        }
        
        var indice = vecvertices.length;
        
        vecvertices[indice]= new Array();
        vecvertices[indice][0] = puntospoligono;
        vecvertices[indice][1] = "1";
        vecvertices[indice][2] = "#ff0000";
        vecvertices[indice][3] = data[i]["peligro"];
        vecvertices[indice][4] = "Zona sigmet";
        vecvertices[indice][5] = "4";
        
      }
      crearPoligonos(latA, lngA);
   });
  // crearPoligonos();
  
  // Agreamos los eventos de cuando se mueve el maker
  /*google.maps.event.addListener(marker, 'dragstart', function() {
   

    map.setCenter(marker.getPosition());
   
  });
  
  google.maps.event.addListener(marker, 'drag', function() {
 
    updateMarkerPosition(marker.getPosition());
    Circle.set("center",marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {*/
 
   

} //cciero inizialize

function alertar(point){

   // map.setCenter(marker.getPosition());
    var changeShadow = 0;
    for (var i = 0; i < vecvertices.length; i++) {
          var tolerancia= radioalerta*0.001 / 111.320;
          var banderaNotif= false;
          if(vecvertices[i][6]){
            var rsul = google.maps.geometry.poly.isLocationOnEdge(point, vecvertices[i][6], tolerancia);
            var resul2 =  google.maps.geometry.poly.containsLocation(point, vecvertices[i][6]);
            if(rsul || resul2){
              var tipomsj;
              var tipomsjOk="nulo";
              var hora= new Date();
              if(resul2){
                var mensaje = "<u>Alerta</u>: ingresó a "+vecvertices[i][3]+" a las "+hora.getHours()+":"+hora.getMinutes()+":"+hora.getSeconds()+" hs.<br>";
                changeShadow = 1;
                tipomsj = "a";
                //console.log(mensaje);
              } else{
                if(changeShadow==0){changeShadow = 2;}
               var mensaje = "<u>Precaucion</u>: aproximándose a "+vecvertices[i][3]+" a las "+hora.getHours()+":"+hora.getMinutes()+":"+hora.getSeconds()+" hs.<br>"; 
                tipomsj = "p";
              }
              console.log(vecNotif.length);
              for(var h=0; h<vecNotif.length; h++){
                if(vecNotif[h]==i+"a"){
                  tipomsjOk = "a";
                } else if (vecNotif[h]==i+"p"){
                  tipomsjOk = "p";
                }
              }
              if(tipomsjOk!="nulo"){ $('#alertas').append("msj"); vecNotif.push(i+tipomsj); console.log(i.toString()+tipomsj);}
              //$('#alertas').append(mensaje); 
              $('#calerta').animate({scrollTop: $('#alertas').prop("scrollHeight")}, 800);
            } 
        }

    
    } 



    var radioalertamarker=8000;
    for (var i = 0; i < vecmetar.length; i++) {
          var tolerancia= radioalertamarker*0.001 / 111.320;
          var rsul = google.maps.geometry.poly.isLocationOnEdge(point, vecmetar[i][0], tolerancia);
          if(rsul){
            if(changeShadow==0){changeShadow = 2;}
            /*vecmetar[indice][0] = poligono;
              vecmetar[indice][1] = data[i]['temperatura']; 
              vecmetar[indice][2] = data[i]['punto_rocio']; 
              vecmetar[indice][3] = data[i]['visibilidad']; 
              vecmetar[indice][4] = data[i]['velocidad_viento']; 
              vecmetar[indice][5] = data[i]['orientacion_viento']; */
           // cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 
           if (vecmetar[i][6]=="metar") {
            var mensaje = "<u>Atencion</u>: temperatura: "+vecmetar[i][1]+". Punto rocio: "+vecmetar[i][2]+". Visibilidad: "+vecmetar[i][3]+". Velocidad viento: "+vecmetar[i][4]+". Orientacion viento: "+vecmetar[i][5]+".<br>";
          } else{
            var mensaje = "<u>Atencion</u>: Turbulencia: "+vecmetar[i][1]+". Nevando: "+vecmetar[i][2]+".<br>";
          }
            $('#alertas').append(mensaje);
            $('#calerta').animate({scrollTop: $('#alertas').prop("scrollHeight")}, 800);
          } 
    
    } 

    $( "#calerta" ).removeClass( "boxAlertaRojo" );
     $( "#calerta" ).removeClass( "boxAlertaVerde" );
     $( "#calerta" ).removeClass( "boxAlertaAmarillo" );
     switch (changeShadow) {
                    case '0':
                       $( "#calerta" ).addClass( "boxAlertaVerde" );
                        break;
                    case '1':
                       $( "#calerta" ).addClass( "boxAlertaRojo" );
                        break;
                    case '2':
                       $( "#calerta" ).addClass( "boxAlertaAmarillo" );
                        break;
      }
    
  //});//cierro dragend
}
function iniciarCapa(){
  $("#modalCapa").modal('show');
  $( "#doc_menu" ).removeClass( "in" );
  //document.getElementById("crearCapa").style.display = 'inline-block';
  document.getElementById("botonNueva").style.display = 'none';
  document.getElementById("botonCapa").style.display = 'none';
  document.getElementById('respuesta').innerHTML = "Creando capa";
}

function cerrarCarga () {
  document.getElementById("botonTermina").style.display = 'none';
  $("#modalConfirmar").modal('show');

  //document.getElementById("confirmar").style.display = 'inline-block';
}
function finalizarCarga(col, nom, desc){
  mostrarRestricciones();
  google.maps.event.removeListener(evenlist);
  for (var i = 0; i < listaMarkers.length; i++) {
      listaMarkers[i].setVisible(false);
  }
  nuevoPol = new google.maps.Polygon({
      paths: [  unirPuntos  ],
      strokeColor: col,
      strokeOpacity: 0.4,
      strokeWeight: 2,
      fillColor: col,
      fillOpacity: 0.35
  });
  
  var nvt = vecvertices.length;
  vecvertices[nvt] = new Array();
  vecvertices[nvt][6] = nuevoPol;
  vecvertices[nvt][3] = nom;
  vecvertices[nvt][4] = desc;

  var dataString= "<div><b>"+nom+"</b></div><div>"+desc+"</div>"+"";
  var nuevaiw = new google.maps.InfoWindow({
      content: dataString
  });
  google.maps.event.addListener(nuevoPol,"click",function(event){
      nuevaiw.setPosition(event.latLng);
      nuevaiw.open(map, nuevoPol);
  }); 
  vecIw.push(nuevaiw);
  if(vecIw.length-2>=0)
    vecIw[vecIw.length-2].close();

  while(unirPuntos.length > 0) {
      unirPuntos.pop();
  }
  /*for(var i=0; i<vecvertices.length;i++){
    vecvertices[i][6].setMap(map);
  }*/
  vecvertices[nvt][6].setMap(map);
  listaMarkers = [];
  polyg.setMap(null);
$('#esoptn').prop('selected', true);
}//cciero el finalizar carga

function iniciarCarga(){
   $( "#doc_menu" ).removeClass( "in" );
   ocultarRestricciones();
  
    
    document.getElementById('respuesta').innerHTML = "Seleccione los puntos en el mapa, luego presione finalizar";
    polyg = new google.maps.Polyline({
    strokeColor: '#333333',
    strokeOpacity: 0.9,
    strokeWeight: 2
    });
    polyg.setMap(map);

    // Add a listener for the click event
    map.addListener('click', addLatLng);

    $.ajax({
      type: "POST",
      url: "db/nuevo_poligono.php",
      data: {ok: ""},
      cache: false,
      success: function(data){
        contadorPts= 0;
        if(data>0){
          document.getElementById("botonNueva").style.display = 'none';
          document.getElementById("botonCapa").style.display = 'none';
          evenlist=  google.maps.event.addListener(map, 'click', function(e) {
            contadorPts++;
              var lat = e.latLng.lat();
              var lon = e.latLng.lng();
              var nro= data;
              var myLatLng = {lat: lat, lng: lon};
              unirPuntos.push(myLatLng);
              $.ajax({
                type: "POST",
                url: "db/nueva_restriccion.php",
                data: {lat: lat, lon: lon, nrores: nro},
                cache: false,
                success: function(data){

                    if(data=="OK"){
                      document.getElementById('respuesta').innerHTML = "Cargando puntos de restricciones";
                      document.getElementById("botonTermina").style.display = 'inline-block';
                      var image =  'images/punto.png';
                      var mkr = new google.maps.Marker({
                        position: myLatLng,
                        title: 'Restriccion',
                        map: map,
                        animation: google.maps.Animation.DROP,
                        draggable: false,
                        icon: image
                      });
                      if(contadorPts==1){
                          google.maps.event.addListener(mkr,"click", cerrarCarga);
                      }//cierro el addlistener si es uno
                      listaMarkers.push(mkr);
                    }//cierro el if del succes 2
                }//cierro el success 2
              });//cierra el  ajax 2
          });//cierro funcion
        }//cierro el if del succes
      }//cierro el succes
    });//cierra el  ajax 
}//cierro el iniciaCarga

function addLatLng(event) {
  var path = polyg.getPath();
  path.push(event.latLng);
}
$(document).ready(function() {
      $('#confirmar').submit(function() {
    
         $.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
              document.getElementById("botonNueva").style.display = 'inline-block';
              //document.getElementById("confirmar").style.display = 'none';
              $("#modalConfirmar").modal('hide');
              document.getElementById('respuesta').innerHTML = "Se cargo la restriccio con exito";
              document.getElementById("descripcion").value="";
              document.getElementById("botonCapa").style.display = 'inline-block';
             

              finalizarCarga(data.color, data.nombre, data.descripcion);
            }//cierro el succes
        })   //cierro el ajax     
        return false;
      });//cierro el formulario de confirmar restriccion
      $('#crearCapa').submit(function() {

         $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(html) {
                $('#iddelacapa').append(html);
                document.getElementById('respuesta').innerHTML = "Se cargo la restriccio con exito";
                document.getElementById("nombrecapa").value="";
                document.getElementById("colorcapa").value="";
                //document.getElementById("crearCapa").style.display = 'none';
                $("#modalCapa").modal('hide');
                document.getElementById("botonNueva").style.display = 'inline-block';
                document.getElementById("botonCapa").style.display = 'inline-block';
            }//cierro el succes
          }) //cierro el ajax    
        return false;
      });//cierro el formu crear capa

      $('#zr').change(function() {
         if(!$(this).is(":checked")) {
            ocultarRestricciones();
          } else {
            mostrarRestricciones();
          } 
    });
  })//cierro el document ready