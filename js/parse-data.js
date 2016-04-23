function getDatosMetar(lat, long, callback) {
	$.post('../db/metar.php', {'lat': lat, 'long': long}).done(function(data) {
		if(data) {
			callback(JSON.parse(data));
		} else {
			callback(JSON.parse("[]"));
		}
	});
}

function getDatosTaf(lat, long, callback) {
	$.post('../db/taf.php', {'lat': lat, 'long': long}).done(function(data) {
		if(data) {
			callback(JSON.parse(data));
		} else {
			callback(JSON.parse("[]"));
		}
	});
}

function getDatosSigmet(lat, long, callback) {
	$.post('../db/sigmet.php', {'lat': lat, 'long': long}).done(function(data) {
		if(data) {
			callback(JSON.parse(data));
		} else {
			callback(JSON.parse("[]"));
		}
	});
}
