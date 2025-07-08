<?php

namespace OpenModule\PhpCalendar\Exceptions;

use Exception;
use Throwable;

class DatetimeInvalidException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message='invalid_time';
        parent::__construct($message, $code, $previous);
    }
}
