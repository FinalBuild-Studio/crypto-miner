<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $exceptions = config('exceptions');
        $exceptions = $exceptions[get_called_class()] ?? [];
        $message    = $exceptions[$message] ?? '';

        parent::__construct($message, $code, $previous);
    }
}
