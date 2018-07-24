<?php declare(strict_types=1);

namespace Sakila\Exceptions\Validation;

use Sakila\Exceptions\SakilaException;

class ValidationException extends SakilaException
{
    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
