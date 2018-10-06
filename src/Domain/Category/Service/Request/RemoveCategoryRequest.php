<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Service\Request;

use Sakila\Command\Command;

class RemoveCategoryRequest implements Command
{
    /**
     * @var int
     */
    private $categoryId;

    /**
     * @param int $categoryId
     */
    public function __construct(int $categoryId)
    {
        $this->setCategoryId($categoryId);
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    private function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }
}
