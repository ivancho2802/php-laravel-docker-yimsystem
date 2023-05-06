<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    //
    public function __construct($message = "")
    {
        parent::__construct(__('appark.user.not_found'));
    }
}
