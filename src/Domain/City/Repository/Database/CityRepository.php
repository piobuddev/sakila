<?php declare(strict_types=1);

namespace Sakila\Domain\City\Repository\Database;

use Sakila\Domain\City\Repository\CityRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class CityRepository extends AbstractDatabaseRepository implements CityRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'city_id';
}
