<?php declare(strict_types=1);

namespace Sakila\Repository\Database\Table;

class Table implements TableInterface
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $primaryKey;

    /**
     * @param string $table
     * @param string $primaryKey
     */
    public function __construct(string $table, string $primaryKey = 'id')
    {
        $this->table      = $table;
        $this->primaryKey = $primaryKey;
    }

    /**
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->table;
    }
}
