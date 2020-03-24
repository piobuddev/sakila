<?php declare(strict_types=1);

namespace Sakila\Repository\Database\Table;

use Sakila\Repository\RepositoryInterface;

interface NameResolverInterface
{
    /**
     * @param \Sakila\Repository\RepositoryInterface $repository
     *
     * @return mixed
     */
    public function resolve(RepositoryInterface $repository);
}
