<?php declare(strict_types=1);

namespace Sakila\Domain\Rental\Service\Request;

use Sakila\Command\AbstractCommand;

class UpdateRentalRequest extends AbstractCommand
{
    /**
     * @var int
     */
    private $rentalId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $rentalId
     * @param array $attributes
     */
    public function __construct(int $rentalId, array $attributes)
    {
        $this->rentalId   = $rentalId;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getRentalId(): int
    {
        return $this->rentalId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
