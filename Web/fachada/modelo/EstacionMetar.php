<?php
require_once 'Estacion.php';

// Estación Meteorología Aérea
class EstacionMetar extends Estacion
{
	private $temperatura;
	private $punto_rocio;
	private $visibilidad;
	private $velocidad_viento;
	private $orientacion_viento;

	public function setTemperatura($temperatura)
	{
		$this->temperatura = $temperatura;

		return $this;
	}

	public function getTemperatura()
	{
		return $this->temperatura . "&deg;C";
	}

	public function setPuntoRocio($punto_rocio)
	{
		$this->punto_rocio = $punto_rocio;

		return $this;
	}

	public function getPuntoRocio()
	{
		return $this->punto_rocio . "&deg;C";
	}

	public function setVisibilidad($visibilidad)
	{
		// 1 milla = 1609.344 metros
		$this->visibilidad = $visibilidad * 1609.344;

		return $this;
	}

	public function getVisibilidad()
	{
		return $this->visibilidad . "m";
	}

	public function setVelocidadViento($velocidad_viento)
	{
		// 1knot = 1.852 km/h
		$this->velocidad_viento = $velocidad_viento * 1.852;

		return $this;
	}

	public function getVelocidadViento()
	{
		return $this->velocidad_viento . "km/h";
	}

	public function setOrientacionViento($orientacion_viento)
	{
		$this->orientacion_viento = $orientacion_viento;

		return $this;
	}

	public function getOrientacionViento()
	{
		return $this->orientacion_viento . "&deg;";
	}

	public function getDatos()
	{
		return array(
			'lat' => $this->getLatitud(),
			'long' => $this->getLongitud(),
			'temperatura' => $this->getTemperatura(),
			'punto_rocio' => $this->getPuntoRocio(),
			'visibilidad' => $this->getVisibilidad(),
			'velocidad_viento' => $this->getVelocidadViento(),
			'orientacion_viento' => $this->getOrientacionViento()
		);
	}
}
?>
