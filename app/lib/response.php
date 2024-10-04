<?php
namespace App\Lib;

class Response
{
	public $data     = null;
	public $success   = false;
	public $code   = 500;
	public $message    = 'Ocurrio un error inesperado.';
	
	public function SetResponse($success, $c = 500, $m = '')
	{
		$this->success = $success;
		$this->message = $m;
		$this->code = $c;

		if(!$success && $m = '') $this->success = 'Ocurrio un error inesperado';
	}
}