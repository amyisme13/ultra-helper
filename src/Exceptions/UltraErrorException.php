<?php

namespace Amyisme13\UltraHelper\Exceptions;

use Exception;

class UltraErrorException extends Exception
{
    public function __construct()
    {
        parent::__construct('Ultra Server Error');
    }
}
