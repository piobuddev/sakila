<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Commands;

use Sakila\Command\AbstractCommand;
use Sakila\Domain\Category\Entity\CategoryEntity;

class UpdateCategoryCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $categoryId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $categoryId
     * @param array $attributes
     */
    public function __construct(int $categoryId, array $attributes)
    {
        $this->categoryId    = $categoryId;
        $this->attributes = $this->filterAttributes($attributes, CategoryEntity::class);
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
