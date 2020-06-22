<?php


namespace Adue\Mobbex\Exceptions;


use Throwable;

class InvalidDataException extends MobbexException
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}