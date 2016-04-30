<?php
require_once 'orm/Mysql.php';
require_once 'validacion/Validador.php';

class Login
{
	private $mail;
	private $password;
	private $token;
	private $errors;
	private $chkToken;
	private $validador;

	public function __construct($chkToken, $us = null, $pas = null)
	{
		$this->mail = is_null($us)? $_SESSION['us'] : $us;
		$this->password = is_null($pas)? $_SESSION['pas'] : $pas;
		$this->token = isset($_POST['token'])? $_POST['token'] : '';
		$this->errors = array();
		$this->chkToken = $chkToken;

		$this->validador = new Validador();
	}

	public function loguear()
	{
		if($this->chkToken):
			if(!$this->isTokenValid()):
				$this->errors['gral'][] = 'Por favor, intente nuevamente';
			endif;
		endif;

		if(!$this->credentialsValid()):
			$this->errors['gral'][] = 'Credenciales no validas';
		endif;

		$this->dataValid();

		if(count($this->errors) == 0):
			$this->registerUser();
		endif;
	}

	public function dataValid()
	{
		if(!$this->validador->isEmail($this->mail)):
			$this->errors['us'][] = 'Por favor, ingrese un email valido';
		endif;

		if($this->validador->isEmpty($this->mail)):
			$this->errors['us'][] = 'El campo email es obligatorio';
		endif;

		if(!$this->validador->hasMaxLength($this->mail, 100)):
			$this->errors['us'][] = 'El campo email no puede tener mas de 100 caracteres';
		endif;

		if($this->validador->isEmpty($this->password)):
			$this->errors['pas'][] = 'El campo contraseña es obligatorio';
		endif;

		if(!$this->validador->hasMaxLength($this->password, 200)):
			$this->errors['pas'][] = 'El campo contraseña no puede tener mas de 200 caracteres';
		endif;
	}

	public function isTokenValid()
	{
		if(isset($_SESSION['token']) && ($this->token == $_SESSION['token'])):
			return true;
		endif;

		return false;
	}

	public function credentialsValid()
	{
		$mysql = (new Mysql())->getConexion();
		$query = $mysql->prepare("SELECT * FROM usuario WHERE mail = :mail AND pass= :pass");
		$query->execute(array('mail' => $this->mail, 'pass' => $this->password));

		$usuarios = $query->fetchAll();
		if(count($usuarios) > 0):
			$_SESSION['id'] = $usuarios[0]['id'];

			return true;
		endif;

		return false;
	}

	public function registerUser()
	{
		$hora_actual = time();

		$_SESSION['us'] = $this->mail;
		$_SESSION['pas'] = $this->password;
		$_SESSION['loggedin'] = true;
		$_SESSION['start'] = $hora_actual;
		$_SESSION['expire'] = $hora_actual + (20 * 60);
	}

	public function getErrors()
	{
		return $this->errors;
	}
}
?>