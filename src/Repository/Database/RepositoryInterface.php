<?php declare(strict_types=1);

namespace Sakila\Repository\Database;

use Sakila\Entity\EntityInterface;

interface RepositoryInterface
{
    /**
     * @param int $entityId
     *
     * @return \Sakila\Entity\EntityInterface
     */
    public function find(int $entityId): EntityInterface;
}
