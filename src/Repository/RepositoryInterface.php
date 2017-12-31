<?php declare(strict_types=1);

namespace Sakila\Repository;

interface RepositoryInterface
{
    /**
     * @param mixed $identifier
     *
     * @return mixed
     */
    public function get($identifier);

    /**
     * @param mixed $identifier
     * @param mixed $value
     *
     * @return mixed
     */
    public function set($identifier, $value);

    /**
     * @param mixed $identifier
     *
     * @return bool
     */
    public function has($identifier): bool;
}
