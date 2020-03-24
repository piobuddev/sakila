<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Repository\Database;

use Sakila\Domain\Actor\Repository\ActorRepositoryInterface;
use Sakila\Repository\Database\AbstractDatabaseRepository;

class ActorRepository extends AbstractDatabaseRepository implements ActorRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'actor_id';
}
