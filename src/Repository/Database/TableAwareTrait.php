<?php declare(strict_types=1);

namespace Sakila\Repository\Database;

use ReflectionClass;

trait TableAwareTrait
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @return string
     */
    public function getTableName(): string
    {
         return $this->table ?: $this->resolveTableName();
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
