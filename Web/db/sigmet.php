<?php
require_once "../fachada/InfoSignificativa.php";

$lat = isset($_POST['lat'])? $_POST['lat'] : null;
$long = isset($_POST['long'])? $_POST['long'] : null;

// Obligación del ingreso de ambos datos
if($lat == null || $long == null):
	die('Por favor ingrese latitud y longitud');
endif;

// Validacion del tipo de dato de la latitud
if(!preg_match("/^(-)?\d{1,3}(\.\d+)?$/", $lat)):
	die('Latitud no valida');
endif;

// Validacion del tipo de dato de la longitud
if(!preg_match("/^(-)?\d{1,3}(\.\d+)?$/", $long)):
	die('Longitud no valida');
endif;

$minLat = $lat - 5;
$minLong = $long - 5;
$maxLat = $lat + 5;
$maxLong = $long + 5;

# Posible error de conexión o fin de tiempo de espera
try {
	$is = new InfoSignificativa($minLat, $minLong, $maxLat, $maxLong);
	$areas = $is->getAreas();
	if($areas):
		die(json_encode($areas));
	else:
		die(json_encode(array()));
	endif;
} catch(\Exception $e) {
	die(json_encode(array()));
}
?>
