<?php declare(strict_types=1);

namespace Sakila\Repository;

interface RepositoryInterface
{
    /**
     * @param mixed $identifier
     * @param null  $default
     *
     * @return mixed
     */
    public function get($identifier, $default = null);
}
