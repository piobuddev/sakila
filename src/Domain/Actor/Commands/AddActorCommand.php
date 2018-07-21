<?php declare(strict_types=1);

namespace Sakila\Domain\Actor\Commands;

use Sakila\Command\AbstractCommand;
use Sakila\Domain\Actor\Entity\ActorEntity;

class AddActorCommand extends AbstractCommand
{
    /**
     * @var array
     */
    private $attributes;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->setAttributes($this->filterAttributes($attributes, ActorEntity::class));
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }
}
