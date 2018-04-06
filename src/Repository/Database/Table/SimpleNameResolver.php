<?php declare(strict_types=1);

namespace Sakila\Repository\Database\Table;

use Sakila\Repository\RepositoryInterface;

class SimpleNameResolver implements NameResolver
{
    /**
     * @param \Sakila\Repository\RepositoryInterface $repository
     *
     * @return string
     */
    public function resolve(RepositoryInterface $repository): string
    {
        return $this->resolveTableName($repository);
    }

    /**
     * @param \Sakila\Repository\RepositoryInterface $repository
     *
     * @return string
     */
    protected function resolveTableName(RepositoryInterface $repository): string
    {
        $className = (new \ReflectionClass(get_class($repository)))->getShortName();

        return strtolower(str_replace('Repository', '', $className));
    }
}
