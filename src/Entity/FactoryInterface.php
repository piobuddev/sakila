<?php declare(strict_types=1);

namespace Sakila\Entity;

interface FactoryInterface
{
    /**
     * @param string $resource
     * @param array  $arguments
     *
     * @return \Sakila\Entity\EntityInterface
     */
    public function create(string $resource, array $arguments = []): EntityInterface;

    /**
     * @param string $resource
     * @param array  $items
     *
     * @return array
     */
    public function hydrate(string $resource, array $items): array;
}
