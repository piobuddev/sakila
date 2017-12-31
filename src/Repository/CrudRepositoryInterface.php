<?php declare(strict_types=1);

namespace Sakila\Repository;

interface CrudRepositoryInterface
{
    /**
     * @param mixed $entityId
     *
     * @return mixed
     */
    public function find($entityId);
}
