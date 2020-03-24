<?php declare(strict_types=1);

namespace Sakila\Domain\Rental\Service\Request;

use Sakila\Command\CommandInterface;

class ShowRentalRequest implements CommandInterface
{
    /**
     * @var int
     */
    private $rentalId;

    /**
     * @param int $rentalId
     */
    public function __construct(int $rentalId)
    {
        $this->setRentalId($rentalId);
    }

    /**
     * @return int
     */
    public function getRentalId(): int
    {
        return $this->rentalId;
    }

    /**
     * @param int $rentalId
     */
    private function setRentalId(int $rentalId): void
    {
        $this->rentalId = $rentalId;
    }
}
