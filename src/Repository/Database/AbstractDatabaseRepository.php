<?php declare(strict_types=1);

namespace Sakila\Repository\Database;

use Sakila\Entity\EntityInterface;
use Sakila\Entity\Factory;
use Sakila\Repository\RepositoryInterface;

abstract class AbstractDatabaseRepository implements RepositoryInterface
{
    use TableAwareTrait;

    /**
     * @var \Sakila\Entity\Factory
     */
    private $entityFactory;

    /**
     * @var \Sakila\Repository\Database\ConnectionInterface
     */
    protected $connection;

    /**
     * @param \Sakila\Repository\Database\ConnectionInterface $connection
     * @param \Sakila\Entity\Factory                          $entityFactory
     */
    public function __construct(ConnectionInterface $connection, Factory $entityFactory)
    {
        $this->connection    = $connection;
        $this->entityFactory = $entityFactory;
    }

    /**
     * @param mixed $identifier
     * @param null  $default
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\InvalidArgumentException
     */
    public function get($identifier, $default = null): EntityInterface
    {
        $result = $this->connection->fetch($this->getTable(), $identifier);

        return $this->entityFactory->create($this->getTable()->getName(), $result);
    }
}
