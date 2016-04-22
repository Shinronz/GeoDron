<?php
require_once "Estacion.php";

class EstacionTaf extends Estacion
{
	private $turbulencia;
	private $nevando;

	public function setTurbulencia($turbulencia)
	{
		$this->turbulencia = $turbulencia;

		return $this;
	}

	public function hasTurbulencia()
	{
		return $this->turbulencia;
	}

	public function setNevando($nevando)
	{
		$this->nevando = $nevando;

		return $this;
	}

	public function isNevando()
	{
		return $this->nevando;
	}

	public function getDatos() 
	{
		return array(
			'lat' => $this->getLatitud(),
			'long' => $this->getLongitud(),
			'turbulencia' => $this->hasTurbulencia(),
			'nevando' => $this->isNevando()
		);
	}
}
?>
