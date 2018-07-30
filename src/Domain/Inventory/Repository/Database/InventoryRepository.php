<?php declare(strict_types=1);

namespace Sakila\Domain\Inventory\Repository\Database;

use Sakila\Domain\Inventory\Repository\InventoryRepository as InventoryRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class InventoryRepository extends AbstractDatabaseRepository implements InventoryRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'inventory_id';
}
