<?php declare(strict_types=1);

namespace Sakila\Domain\Rental\Repository\Database;

use Sakila\Domain\Rental\Repository\RentalRepository as RentalRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class RentalRepository extends AbstractDatabaseRepository implements RentalRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'rental_id';
}
