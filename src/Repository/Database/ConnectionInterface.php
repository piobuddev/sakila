<?php declare(strict_types=1);

namespace Sakila\Repository\Database;

use Sakila\Repository\Database\Table\TableInterface;

interface ConnectionInterface
{
    /**
     * @param \Sakila\Repository\Database\Table\TableInterface $table
     * @param int                                              $entityId
     *
     * @return mixed
     */
    public function fetch(TableInterface $table, int $entityId);
}
