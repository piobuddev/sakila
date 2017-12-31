<?php declare(strict_types=1);

namespace Sakila\Repository;

interface ConnectionInterface
{
    /**
     * @param mixed $resource
     * @param mixed $identifier
     *
     * @return mixed
     */
    public function get($resource, $identifier);
}
