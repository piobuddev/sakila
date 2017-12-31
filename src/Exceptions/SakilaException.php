<?php declare(strict_types=1);

namespace Sakila\Exceptions;

use Exception;

class SakilaException extends Exception
{
    /**
     * @param string $message
     * @param mixed  $arguments
     */
    public function __construct(string $message = '', $arguments = null)
    {
        $message = sprintf($message, $arguments);

        parent::__construct($message);
    }
}
