<?php declare(strict_types=1);

namespace Sakila\Repository;

use Sakila\Entity\EntityInterface;

interface RepositoryInterface
{
    /**
     * @param int $entityId
     *
     * @return \Sakila\Entity\EntityInterface
     */
    public function get(int $entityId): EntityInterface;

    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param int   $entityId
     * @param array $value
     *
     * @return mixed
     */
    public function update(int $entityId, array $value): EntityInterface;

    /**
     * @param array $value
     *
     * @return bool
     */
    public function add(array $value): bool;

    /**
     * @param int $entityId
     *
     * @return bool
     */
    public function remove(int $entityId): bool;

    /**
     * @return int
     */
    public function lastInsertedId(): int;
}
