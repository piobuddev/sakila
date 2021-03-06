<?php declare(strict_types=1);

namespace Sakila\Repository\Database;

use Sakila\Repository\Database\Query\BuilderInterface;

interface ConnectionInterface
{
    /**
     * @return \Sakila\Repository\Database\Query\BuilderInterface
     */
    public function query(): BuilderInterface;

    /**
     * @param string $table
     * @param array  $data
     *
     * @return bool
     */
    public function insert(string $table, array $data): bool;

    /**
     * @param string $table
     * @param array  $values
     * @param array  $where
     *
     * @return int
     */
    public function update(string $table, array $values, array $where): int;

    /**
     * @param string $table
     * @param array  $where
     *
     * @return bool
     */
    public function delete(string $table, array $where): bool;

    /**
     * @return int
     */
    public function lastInsertedId(): int;

    /**
     * @param string $table
     *
     * @return int
     */
    public function count(string $table): int;

    /**
     * @param \Closure $callback
     *
     * @return mixed
     */
    public function transaction(\Closure $callback);
}
