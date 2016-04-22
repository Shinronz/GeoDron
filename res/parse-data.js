function getDatosMetar(lat, long, callback) {
	$.post('../modelo/metar.php', {'lat': lat, 'long': long}).done(function(data) {
		if(data) {
			callback(JSON.parse(data));
		} else {
			callback(JSON.parse("[]"));
		}
	});
}

function getDatosTaf(lat, long, callback) {
	$.post('../modelo/taf.php', {'lat': lat, 'long': long}).done(function(data) {
		if(data) {
			callback(JSON.parse(data));
		} else {
			callback(JSON.parse("[]"));
		}
	});
}

function getDatosSigmet(lat, long, callback) {
	$.post('../modelo/sigmet.php', {'lat': lat, 'long': long}).done(function(data) {
		if(data) {
			callback(JSON.parse(data));
		} else {
			callback(JSON.parse("[]"));
		}
	});
}
