<?php declare(strict_types=1);

namespace Sakila\Domain\Staff\Repository\Database;

use Sakila\Domain\Staff\Repository\StaffRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class StaffRepository extends AbstractDatabaseRepository implements StaffRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'staff_id';
}
