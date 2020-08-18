<?php

namespace Amyisme13\UltraHelper\Exceptions;

use Exception;

class ValidationException extends Exception
{
    /**
     * @var array
     */
    public $errors;

    public function __construct(array $errors)
    {
        parent::__construct('Validation Error');

        $this->errors = $errors;
    }
}
