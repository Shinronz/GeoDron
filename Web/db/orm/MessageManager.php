<?php
class MessageManager {
	private static $CLAVE = "ClavePriv";

	public static function encode($codigo) {
		$clave = str_split(self::$CLAVE);
		$clave_len = count($clave);
		$codif = "";

		$palabra_split = str_split($codigo);
		for($i = 0;$i < count($palabra_split);$i++) {
			$letra = $palabra_split[$i];
			$c = ord($letra) ^ ord($clave[$i % $clave_len]);

			$codif .= chr($c);
		}

		return base64_encode($codif);
	}

	public static function decode($codigo) {
		$clave = str_split(self::$CLAVE);
		$clave_len = count($clave);
		$decod = "";

		$codigo_split = str_split(base64_decode($codigo));
		for($i = 0;$i < count($codigo_split);$i++) {
			$letra = $codigo_split[$i];
			$c = ord($letra) ^ ord($clave[$i % $clave_len]);

			$decod .= chr($c);
		}
		
		return $decod;
	}
}
