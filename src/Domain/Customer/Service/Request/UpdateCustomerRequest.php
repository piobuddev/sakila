<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Service\Request;

use Sakila\Command\AbstractCommand;

class UpdateCustomerRequest extends AbstractCommand
{
    /**
     * @var int
     */
    private $customerId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $customerId
     * @param array $attributes
     */
    public function __construct(int $customerId, array $attributes)
    {
        $this->customerId = $customerId;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
