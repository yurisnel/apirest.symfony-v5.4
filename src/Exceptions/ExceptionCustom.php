<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ExceptionCustom extends \Exception
{
    protected $code;
    protected $message;
    protected $errors;

    public function __construct($message, $errors = [], $code =  Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }
    public function getErrors()
    {
        return $this->errors;
    }
}
