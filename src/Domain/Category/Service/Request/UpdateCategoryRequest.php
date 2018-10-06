<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Service\Request;

use Sakila\Command\AbstractCommand;

class UpdateCategoryRequest extends AbstractCommand
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
        $this->categoryId = $categoryId;
        $this->attributes = $attributes;
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
