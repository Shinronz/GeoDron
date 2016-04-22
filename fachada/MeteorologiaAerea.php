<?php
require_once "modelo/EstacionMetar.php";

class MeteorologiaAerea
{
	private $xml;
	private $puntos;

	// Construcción de array a partir de datos en xml
	public function __construct($minLat, $minLong, $maxLat, $maxLong)
	{
		$this->puntos = array();
		$xmlStr = file_get_contents("http://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=metars&requestType=retrieve&format=xml&minLat=" . $minLat . "&minLon=" . $minLong . "&maxLat=" . $maxLat . "&maxLon=" . $maxLong . "&hoursBeforeNow=1");

		if($xmlStr != null) {
			$this->xml = new SimpleXMLElement($xmlStr);
		}
	}

	// Calcula la distancia a cada estación y devuelve la más cercana
	public function getEstacionCercana($lat, $long) {
		$estacion = new EstacionMetar();
		$cant = count($this->xml->data->METAR);

		$aux = 0;
		for($i = 0;$i < $cant;$i++) {
			$punto = $this->xml->data->METAR[$i];

			$distancia = sqrt(
				pow(($punto->latitude - $lat), 2) +
				pow(($punto->longitude - $long), 2)
			);

			if($i == 0):
				$aux = $distancia;
			endif;

			if($distancia < $aux):
				$aux = $distancia;

				# Se castean los tipos de datos ya que de lo contrario son objetos XML
				$estacion->setLatitud((float)$punto->latitude)
					->setLongitud((float)$punto->longitude)
					->setTemperatura((float)$punto->temp_c)
					->setPuntoRocio((float)$punto->dewpoint_c)
					->setVisibilidad((float)$punto->visibility_statute_mi)
					->setVelocidadViento((float)$punto->wind_speed_kt)
					->setOrientacionViento((float)$punto->wind_dir_degrees);
			endif;
		}

		return $estacion;
	}

	public function getEstacion($lat, $long)
	{
		$estacion = new EstacionMetar();

		$cant = count($this->xml->data->METAR);

		for($i = 0;$i < $cant;$i++) {
			$punto = $this->xml->data->METAR[$i];

			if((float)$punto->latitude == $lat && (float)$punto->longitude == $long) {
				$estacion->setLatitud((float)$punto->latitude)
					->setLongitud((float)$punto->longitude)
					->setTemperatura((float)$punto->temp_c)
					->setPuntoRocio((float)$punto->dewpoint_c)
					->setVisibilidad((float)$punto->visibility_statute_mi)
					->setVelocidadViento((float)$punto->wind_speed_kt)
					->setOrientacionViento((float)$punto->wind_dir_degrees);
				break;
			}
		}

		return $estacion;
	}

	// Arreglo de puntos cardinales de todas las estaciones cercanas
	public function getPuntos()
	{
		$cant = count($this->xml->data->METAR);

		for($i = 0;$i < $cant;$i++) {
			$punto = $this->xml->data->METAR[$i];
			$estacion = new EstacionMetar();

			$estacion->setLatitud((float)$punto->latitude)
					->setLongitud((float)$punto->longitude)
					->setTemperatura((float)$punto->temp_c)
					->setPuntoRocio((float)$punto->dewpoint_c)
					->setVisibilidad((float)$punto->visibility_statute_mi)
					->setVelocidadViento((float)$punto->wind_speed_kt)
					->setOrientacionViento((float)$punto->wind_dir_degrees);

			$this->puntos[] = $estacion->getDatos();
		}

		return $this->puntos;
	}
}
?>
