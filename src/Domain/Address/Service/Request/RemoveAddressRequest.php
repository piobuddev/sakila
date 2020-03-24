<?php declare(strict_types=1);

namespace Sakila\Domain\Address\Service\Request;

use Sakila\Command\CommandInterface;

class RemoveAddressRequest implements CommandInterface
{
    /**
     * @var int
     */
    private $addressId;

    /**
     * @param int $addressId
     */
    public function __construct(int $addressId)
    {
        $this->setAddressId($addressId);
    }

    /**
     * @return int
     */
    public function getAddressId(): int
    {
        return $this->addressId;
    }

    /**
     * @param int $addressId
     */
    private function setAddressId(int $addressId): void
    {
        $this->addressId = $addressId;
    }
}
