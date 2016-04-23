function controlarAltura(lat, lng, orientacion) {
    // 8km = 0.08602150538°
    // 100mts = 0,000900901°
    var hip = 0,000900901;
    var ady = Math.cos(orientacion) * hip;
    var op = Math.sin(orientacion) * hip;

    var path = [
        {'lat': lat, 'lng': lng},
        {'lat': lat + ady, 'lng': lng + op},
    ];

    var elevator = new google.maps.ElevationService;

    elevator.getElevationAlongPath({
      'path': path,
      'samples': 256
    }, plotElevation);
}

function plotElevation(elevations, status) {
  //var chartDiv = document.getElementById('elevation_chart');
  if (status !== google.maps.ElevationStatus.OK) {
    return;
  }

  var altura = $('.altura_actual').val();
  for (var i = 0; i < elevations.length; i++) {
      if(altura < elevations[i].elevation) {
          $('#alertas').append('Cuidado se esta por chocar algo!!<br>');
      }
  }
}
