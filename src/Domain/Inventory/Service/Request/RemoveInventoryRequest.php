<?php declare(strict_types=1);

namespace Sakila\Domain\Inventory\Service\Request;

use Sakila\Command\Command;

class RemoveInventoryRequest implements Command
{
    /**
     * @var int
     */
    private $inventoryId;

    /**
     * @param int $inventoryId
     */
    public function __construct(int $inventoryId)
    {
        $this->setInventoryId($inventoryId);
    }

    /**
     * @return int
     */
    public function getInventoryId(): int
    {
        return $this->inventoryId;
    }

    /**
     * @param int $inventoryId
     */
    private function setInventoryId(int $inventoryId): void
    {
        $this->inventoryId = $inventoryId;
    }
}
