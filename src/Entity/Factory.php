<?php declare(strict_types=1);

namespace Sakila\Entity;

use Sakila\Domain\Actor\Entity\ActorEntity;
use Sakila\Exceptions\InvalidArgumentException;

class Factory
{
    /**
     * @var \Sakila\Entity\Builder
     */
    private $builder;

    /**
     * @param \Sakila\Entity\Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param string $resource
     * @param array  $arguments
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\InvalidArgumentException
     */
    public function create(string $resource, array $arguments = []): EntityInterface
    {
        switch ($resource) {
            case 'actor':
                return $this->builder->build(ActorEntity::class, $arguments);
            default:
                throw new InvalidArgumentException('Invalid resource name `%s`', $resource);
        }
    }
}
