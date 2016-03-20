<?php namespace HotelsProviders\Expedia;

class MissingRequiredParameterException extends \Exception
{
	public function __construct($message)
	{
		parent::__construct($message);
	}

}
