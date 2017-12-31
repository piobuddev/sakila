<?php declare(strict_types=1);

namespace Sakila\Repository\Database\Table;

interface TableInterface
{
    /**
     * @return string
     */
    public function getPrimaryKey(): string;

    /**
     * @return string
     */
    public function getName(): string;
}
