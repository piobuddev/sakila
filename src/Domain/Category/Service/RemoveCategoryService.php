<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Service;

use Sakila\Domain\Category\Repository\CategoryRepositoryInterface;
use Sakila\Domain\Category\Service\Request\RemoveCategoryRequest;

class RemoveCategoryService
{
    /**
     * @var \Sakila\Domain\Category\Repository\CategoryRepositoryInterface
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Category\Repository\CategoryRepositoryInterface $repository
     */
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Sakila\Domain\Category\Service\Request\RemoveCategoryRequest $removeCategoryRequest
     *
     * @return bool
     */
    public function execute(RemoveCategoryRequest $removeCategoryRequest): bool
    {
        return $this->repository->remove($removeCategoryRequest->getCategoryId());
    }
}
