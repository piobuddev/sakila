<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Repository\Database;

use Sakila\Domain\Store\Repository\StoreRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class StoreRepository extends AbstractDatabaseRepository implements StoreRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'store_id';
}
