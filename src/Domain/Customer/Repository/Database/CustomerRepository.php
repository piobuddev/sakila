<?php declare(strict_types=1);

namespace Sakila\Domain\Customer\Repository\Database;

use Sakila\Domain\Customer\Repository\CustomerRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class CustomerRepository extends AbstractDatabaseRepository implements CustomerRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'customer_id';
}
