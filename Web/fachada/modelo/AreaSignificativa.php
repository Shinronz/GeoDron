<?php
class AreaSignificativa
{
	private $peligro;
	private $area;

	public function setPeligro($peligro)
	{
		$this->peligro = $peligro;

		return $this;
	}

	public function getPeligro()
	{
		$peligro = "";

		switch($this->peligro) {
			case "MTN OBSCN": $peligro = "Obstaculo montañoso";
				break;
			case "IFR": $peligro = "IFR";
				break;
			case "TURB": $peligro = "Turbulencia";
				break;
			case "ICE": $peligro = "Heladas";
				break;
			case "CONVECTIVE": $peligro = "Zona tormentosa";
				break;
			case "ASH": $peligro = "Ceniza";
				break;
		}

		return $peligro;
	}

	public function addPunto($lat, $long)
	{
		$this->area[] = array(
			"lat" => $lat,
			"long" => $long
		);

		return $this;
	}

	public function getArea()
	{
		return $this->area;
	}

	public function getDatos()
	{
		return array(
				"peligro" => $this->getPeligro(),
				"area" => $this->getArea()
			);
	}
}
?>
