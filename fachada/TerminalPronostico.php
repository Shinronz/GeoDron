<?php
require_once "modelo/EstacionTaf.php";

class TerminalPronostico
{
	private $xml;
	private $puntos;

	public function __construct($minLat, $minLong, $maxLat, $maxLong)
	{
		$this->puntos = array();
		$xmlStr = file_get_contents("http://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=tafs&requestType=retrieve&format=xml&minLat=" . $minLat . "&minLon=" . $minLong . "&maxLat=" . $maxLat . "&maxLon=" . $maxLong . "&hoursBeforeNow=1");

		if($xmlStr != null) {
			$this->xml = new SimpleXMLElement($xmlStr);
		}
	}

	// Calcula la distancia a cada estación y devuelve la más cercana
	public function getEstacionCercana($lat, $long)
	{
		$estacion = new EstacionTaf();
		$cant = count($this->xml->data->TAF);

		$aux = 0;
		for($i = 0;$i < $cant;$i++) {
			$punto = $this->xml->data->TAF[$i];

			$distancia = sqrt(
				pow(($punto->latitude - $lat), 2) +
				pow(($punto->longitude - $long), 2)
			);

			if($i == 0):
				$aux = $distancia;
			endif;

			if($distancia < $aux):
				$aux = $distancia;

				$estacion->setLatitud((float)$punto->latitude)
					->setLongitud((float)$punto->longitude);

				$cant_pronost = count($punto->forecast);
				for($j = 0;$j < $cant_pronost;$j++){
					if(isset($punto->forecast[$j]->turbulence_condition)):
						$estacion->setTurbulencia(true);
					else:
						$estacion->setTurbulencia(false);
					endif;

					if(isset($punto->forecast[$j]->icing_condition)):
						$estacion->setNevando(true);
					else:
						$estacion->setNevando(false);
					endif;
				}
			endif;
		}

		return $estacion;
	}

	public function getEstacion($lat, $long)
	{
		$estacion = new EstacionTaf();
		$cant = count($this->xml->data->TAF);

		$aux = 0;
		for($i = 0;$i < $cant;$i++) {
			$punto = $this->xml->data->TAF[$i];

			if((float)$punto->latitude == $lat && (float)$punto->longitude == $long) {
				$estacion->setLatitud((float)$punto->latitude)
					->setLongitud((float)$punto->longitude);

				$cant_pronost = count($punto->forecast);
				for($j = 0;$j < $cant_pronost;$j++){
					if(isset($punto->forecast[$j]->turbulence_condition)):
						$estacion->setTurbulencia(true);
					else:
						$estacion->setTurbulencia(false);
					endif;

					if(isset($punto->forecast[$j]->icing_condition)):
						$estacion->setNevando(true);
					else:
						$estacion->setNevando(false);
					endif;
				}
			}
		}

		return $estacion;
	}

	public function getPuntos()
	{
		$cant = count($this->xml->data->TAF);

		for($i = 0;$i < $cant;$i++) {
			$punto = $this->xml->data->TAF[$i];
			$estacion = new EstacionTaf();

			$estacion->setLatitud((float)$punto->latitude)
					->setLongitud((float)$punto->longitude);

			$cant_pronost = count($punto->forecast);
			for($j = 0;$j < $cant_pronost;$j++){
				if(isset($punto->forecast[$j]->turbulence_condition)):
					$estacion->setTurbulencia(true);
				else:
					$estacion->setTurbulencia(false);
				endif;

				if(isset($punto->forecast[$j]->icing_condition)):
					$estacion->setNevando(true);
				else:
					$estacion->setNevando(false);
				endif;
			}

			if($estacion->hasTurbulencia() || $estacion->isNevando()):
				$this->puntos[] = $estacion->getDatos();
			endif;
		}

		return $this->puntos;
	}
}
?>