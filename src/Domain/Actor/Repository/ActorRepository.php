<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Repository;

use Sakila\Repository\Database\AbstractDatabaseRepository;

class ActorRepository extends AbstractDatabaseRepository implements ActorRepositoryInterface
{
    protected $primaryKey = 'actor_id';
}
