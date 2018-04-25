<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Entity;

use Sakila\Entity\AbstractEntity;

class CategoryEntity extends AbstractEntity
{
    /**
     * @var int
     */
    public $categoryId;

    /**
     * @var string
     */
    public $name;
}
