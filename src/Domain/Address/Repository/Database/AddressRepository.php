<?php declare(strict_types=1);

namespace Sakila\Domain\Address\Repository\Database;

use Sakila\Domain\Address\Repository\AddressRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class AddressRepository extends AbstractDatabaseRepository implements AddressRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'address_id';
}
