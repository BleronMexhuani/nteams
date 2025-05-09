<?php

namespace App\Exceptions;

use Exception;

class BookCoverException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  \Exception|null  $previous
     * @return void
     */
    public function __construct($message = "Error while getting the book", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
