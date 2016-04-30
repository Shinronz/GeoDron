<?php
class Validador
{
	public function isNumber($data)
	{
		if(is_integer($data)):
			return true;
		endif;

		return false;
	}

	public function isFloat($data)
	{
		if(is_float($data)):
			return true;
		endif;

		return false;
	}

	public function isEmail($data)
	{
		if(filter_var($data, FILTER_VALIDATE_EMAIL)):
			return true;
		endif;

		return false;
	}

	public function isText($data)
	{
		if(preg_match('/^[a-zA-Z0-9]*$/', $data)):
			return true;
		endif;

		return false;
	}

	public function isEmpty($data)
	{
		if(empty($data)):
			return true;
		endif;

		return false;
	}

	public function hasMaxLength($data, $maxLength)
	{
		if(strlen(strval($data)) <= $maxLength):
			return true;
		endif;

		return false;
	}
}
?>