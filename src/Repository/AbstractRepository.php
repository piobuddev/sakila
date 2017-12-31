<?php declare(strict_types=1);

namespace Sakila\Repository;

abstract class AbstractRepository
{
    /**
     * @var \Sakila\Repository\ConnectionInterface
     */
    private $connection;

    /**
     * @param \Sakila\Repository\ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return \Sakila\Repository\ConnectionInterface
     */
    protected function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }
}
