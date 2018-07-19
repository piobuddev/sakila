<?php declare(strict_types=1);

namespace Sakila\Entity;

use Sakila\Domain\Actor\Entity\ActorEntity;
use Sakila\Domain\Category\Entity\CategoryEntity;
use Sakila\Domain\Country\Entity\CountryEntity;
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
            case 'category':
                return $this->builder->build(CategoryEntity::class, $arguments);
            case 'country':
                return $this->builder->build(CountryEntity::class, $arguments);
            default:
                throw new InvalidArgumentException('Invalid resource name `%s`', $resource);
        }
    }

    /**
     * @param string $resource
     * @param array  $items
     *
     * @return array
     */
    public function hydrate(string $resource, array $items): array
    {
        return array_map(
            function ($item) use ($resource) {
                if ($item instanceof EntityInterface) {
                    return $item;
                }

                return $this->create($resource, (array) $item);
            },
            $items
        );
    }
}
