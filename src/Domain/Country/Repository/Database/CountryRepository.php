<?php declare(strict_types=1);

namespace Sakila\Domain\Country\Repository\Database;

use Sakila\Domain\Country\Repository\CountryRepository as CountryRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class CountryRepository extends AbstractDatabaseRepository implements CountryRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'country_id';
}
