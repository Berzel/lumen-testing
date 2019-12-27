<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    /**
     * UserNotFoundException is thrown when a user record is not found in database
     * 
     * @param string $message
     * @return void
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
