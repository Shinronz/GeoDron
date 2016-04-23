<?php
require_once "modelo/AreaSignificativa.php";

// AIR/SIGMET
class InfoSignificativa
{
	private $xml;
	private $areas;

	// Construcción de array a partir de datos en xml
	public function __construct($minLat, $minLong, $maxLat, $maxLong)
	{
		$this->areas = array();
		$xmlStr = file_get_contents("http://www.aviationweather.gov/adds/dataserver_current/httpparam?dataSource=airsigmets&requestType=retrieve&format=xml&minLat=" . $minLat . "&minLon=" . $minLong . "&maxLat=" . $maxLat . "&maxLon=" . $maxLong . "&hoursBeforeNow=1");

		if($xmlStr != null) {
			$this->xml = new SimpleXMLElement($xmlStr);
		}
	}

	public function getAreas()
	{
		$cant = count($this->xml->data->AIRSIGMET);

		for($i = 0;$i < $cant;$i++)
		{
			$punto = $this->xml->data->AIRSIGMET[$i];
			
			$area = new AreaSignificativa();
			$area->setPeligro((string)$punto->hazard['type']);
			$cant_pun = count($punto->area->point);
			for($j = 0;$j < $cant_pun;$j++) {
				$area->addPunto(
					(float)$punto->area->point[$j]->latitude,
					(float)$punto->area->point[$j]->longitude
				);
			}

			$this->areas[] = $area->getDatos();
		}

		return $this->areas;
	}
}
?>
