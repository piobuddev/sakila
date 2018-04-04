<?php declare(strict_types=1);

namespace Sakila\Repository\Database\Query;

interface BuilderInterface
{
    /**
     * @param array $columns
     *
     * @return \Sakila\Repository\Database\Query\BuilderInterface
     */
    public function select(array $columns): BuilderInterface;

    /**
     * @param string $table
     *
     * @return \Sakila\Repository\Database\Query\BuilderInterface
     */
    public function from(string $table): BuilderInterface;

    /**
     * @param array $where
     *
     * @return \Sakila\Repository\Database\Query\BuilderInterface
     */
    public function where(array $where): BuilderInterface;

    /**
     * @param array $order
     *
     * @return \Sakila\Repository\Database\Query\BuilderInterface
     */
    public function order(array $order): BuilderInterface;

    /**
     * @param int $limit
     *
     * @return \Sakila\Repository\Database\Query\BuilderInterface
     */
    public function limit(int $limit): BuilderInterface;

    /**
     * @return mixed
     */
    public function get(): array;
}
