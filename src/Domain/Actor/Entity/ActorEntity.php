<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Entity;

use Sakila\Entity\AbstractEntity;

class ActorEntity extends AbstractEntity
{
    /**
     * @var int
     */
    public $actorId;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;
}
