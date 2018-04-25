<?php declare(strict_types=1);

namespace Sakila\Command;

class AbstractCommand implements Command
{
    /**
     * @param array  $attributes
     * @param string $entity
     *
     * @return array
     */
    public function filterAttributes(array $attributes, string $entity): array
    {
        return array_intersect_key($attributes, get_class_vars($entity));
    }
}
