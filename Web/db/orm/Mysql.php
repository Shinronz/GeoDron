<?php
require 'Servidor.php';

class Mysql {
	private $mbd;

	public function __construct() {
		try {
		    $this->mbd = new PDO('mysql:host=' . Servidor::getServer() . ';dbname=' . Servidor::getDataBase(), Servidor::getUser(), Servidor::getPassword());
		} catch(PDOException $e) {
			print "¡Error en constructor de Mysql!: " . $e->getMessage() . "<br/>";
    		die();
		}
	}

	public function getConexion() {
		return $this->mbd;
	}
}
?>