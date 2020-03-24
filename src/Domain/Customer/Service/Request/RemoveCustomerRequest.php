<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Service\Request;

use Sakila\Command\CommandInterface;

class RemoveCustomerRequest implements CommandInterface
{
    /**
     * @var int
     */
    private $customerId;

    /**
     * @param int $customerId
     */
    public function __construct(int $customerId)
    {
        $this->setCustomerId($customerId);
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     */
    private function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }
}
