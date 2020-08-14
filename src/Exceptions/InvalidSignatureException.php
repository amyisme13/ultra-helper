<?php

namespace Amyisme13\UltraHelper\Exceptions;

use Exception;

class InvalidSignatureException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid signature, recheck your signature key');
    }
}
