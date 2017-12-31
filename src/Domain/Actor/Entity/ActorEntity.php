<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Entity;

use Sakila\Entity\AbstractEntity;

class ActorEntity extends AbstractEntity
{
    public $actorId;

    public $firstName;

    public $lastName;
}
