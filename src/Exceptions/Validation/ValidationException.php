<?php declare(strict_types=1);

namespace Sakila\Exceptions;

use Exception;

class ValidationException extends Exception
{
    /**
     * @var array
     */
    private $messages;

    /**
     * @param array $messages
     */
    public function __construct(array $messages = [])
    {
        $this->messages = $messages;

        parent::__construct();
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
