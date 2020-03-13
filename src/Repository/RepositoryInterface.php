<?php declare(strict_types=1);

namespace Sakila\Repository;

use Sakila\Entity\EntityInterface;

interface RepositoryInterface
{
    /**
     * @return mixed
     */
    public function getTable();

    /**
     * @param int $entityId
     *
     * @return \Sakila\Entity\EntityInterface
     */
    public function get(int $entityId): EntityInterface;

    /**
     * @param int|null $page
     * @param int|null $pageSize
     *
     * @return array
     */
    public function all(int $page = null, int $pageSize = null): array;

    /**
     * @param int   $entityId
     * @param array $value
     *
     * @return \Sakila\Entity\EntityInterface
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

    /**
     * @return int
     */
    public function count(): int;
}
