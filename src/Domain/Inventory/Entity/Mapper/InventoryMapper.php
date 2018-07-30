<?php declare(strict_types=1);

namespace Sakila\Domain\Inventory\Entity\Mapper;

use Sakila\Entity\Mapper\AbstractMapper;

class InventoryMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'inventoryId' => 'inventory_id',
            'filmId'      => 'film_id',
            'storeId'     => 'store_id',
        ];
    }
}
