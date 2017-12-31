<?php declare(strict_types=1);

namespace Sakila\Repository\Database;

use ReflectionClass;
use Sakila\Repository\Database\Table\Table;
use Sakila\Repository\Database\Table\TableInterface;

trait TableAwareTrait
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $primaryKey;

    /**
     * @return TableInterface
     */
    public function getTable(): TableInterface
    {
        $pk    = $this->primaryKey ?: 'id';
        $table = $this->table ?: $this->resolveTableName();

        return new Table($table, $pk);
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
