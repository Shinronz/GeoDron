<?php
class Servidor {
	const SERVER = 'localhost';
	const DATABASE = 'bdnasa';
	const DB_USER = 'tuti';
	const DB_PASS = 'tuti123!';

	public static function getServer() {
		return self::SERVER;
	}

	public static function getDataBase() {
		return self::DATABASE;
	}

	public static function getUser() {
		return self::DB_USER;
	}

	public static function getPassword() {
		return self::DB_PASS;
	}
}
?>