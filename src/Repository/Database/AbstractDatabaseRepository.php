<?php declare(strict_types=1);

namespace Sakila\Repository\Database;

use Sakila\Entity\EntityInterface;
use Sakila\Entity\Factory;
use Sakila\Exceptions\Database\NotFoundException;
use Sakila\Exceptions\Repository\RepositoryException;
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
     * @param int $entityId
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Database\NotFoundException
     * @throws \Sakila\Exceptions\InvalidArgumentException
     */
    public function get(int $entityId): EntityInterface
    {
        $table   = $this->getTableName();
        $results = $this->connection->query()->from($table)->where([$this->primaryKey => $entityId])->get();
        $result  = (array)array_pop($results);

        if (empty($result)) {
            throw new NotFoundException('Row (ID:%s) not found in `%s` table', [$entityId, $table]);
        }

        return $this->entityFactory->create($table, $result);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        $results = $this->connection->query()->from($this->getTableName())->get();

        return $this->entityFactory->hydrate($this->getTableName(), $results);
    }

    /**
     * @param int   $entityId
     * @param array $value
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Database\NotFoundException
     * @throws \Sakila\Exceptions\InvalidArgumentException
     */
    public function update(int $entityId, array $value): EntityInterface
    {
        $where = [$this->primaryKey => $entityId];
        $this->connection->update($this->getTableName(), $value, $where);

        return $this->get($entityId);
    }

    /**
     * @param array $value
     *
     * @return bool
     * @throws \Sakila\Exceptions\Repository\RepositoryException
     */
    public function add(array $value): bool
    {
        $insert = $this->connection->insert($this->getTableName(), $value);
        if (!$insert) {
            throw new RepositoryException('Error occurred while adding a data');
        }

        return $insert;
    }

    /**
     * @param $entityId
     *
     * @return bool
     */
    public function remove(int $entityId): bool
    {
        $where = [$this->primaryKey => $entityId];

        return $this->connection->delete($this->getTableName(), $where);
    }

    /**
     * @return int
     * @throws \Sakila\Exceptions\Repository\RepositoryException
     */
    public function lastInsertedId(): int
    {
        $lastInsertedId = $this->connection->lastInsertedId();
        if (!$lastInsertedId) {
            throw new RepositoryException('Could not fetch a last inserted ID');
        }

        return $lastInsertedId;
    }
}
