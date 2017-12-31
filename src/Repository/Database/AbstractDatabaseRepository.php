<?php declare(strict_types=1);

namespace Sakila\Repository\Database;

use ReflectionClass;
use Sakila\Entity\EntityInterface;
use Sakila\Entity\Factory;
use Sakila\Repository\AbstractRepository;
use Sakila\Repository\ConnectionInterface;

abstract class AbstractDatabaseRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var \Sakila\Entity\Factory
     */
    private $entityFactory;

    /**
     * @param \Sakila\Repository\ConnectionInterface $connection
     * @param \Sakila\Entity\Factory                 $entityFactory
     */
    public function __construct(ConnectionInterface $connection, Factory $entityFactory)
    {
        parent::__construct($connection);

        $this->table         = $this->resolveTableName();
        $this->entityFactory = $entityFactory;
    }

    /**
     * @param int $entityId
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\InvalidArgumentException
     */
    public function find(int $entityId): EntityInterface
    {
        //** todo: handle response */
        $data = $this->getConnection()->get($this->table, $entityId);

        return $this->entityFactory->create($this->table, $data);
    }

    /**
     * @return string
     */
    protected function resolveTableName(): string
    {
        $className = (new ReflectionClass(get_class($this)))->getShortName();

        return strtolower(str_replace('Repository', '', $className));
    }
}
