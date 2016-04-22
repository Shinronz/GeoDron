<?php
class Estacion
{
	private $latitud;
	private $longitud;
	
	public function setLatitud($latitud)
	{
		$this->latitud = $latitud;

		return $this;
	}

	public function getLatitud()
	{
		return $this->latitud;
	}

	public function setLongitud($longitud)
	{
		$this->longitud = $longitud;

		return $this;
	}

	public function getLongitud()
	{
		return $this->longitud;
	}
}
?>
