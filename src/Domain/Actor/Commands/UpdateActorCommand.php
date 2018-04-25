<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Commands;

use Sakila\Command\AbstractCommand;
use Sakila\Domain\Actor\Entity\ActorEntity;

class UpdateActorCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $actorId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $actorId
     * @param array $attributes
     */
    public function __construct(int $actorId, array $attributes)
    {
        $this->actorId    = $actorId;
        $this->attributes = $this->filterAttributes($attributes, ActorEntity::class);
    }

    /**
     * @return int
     */
    public function getActorId(): int
    {
        return $this->actorId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
