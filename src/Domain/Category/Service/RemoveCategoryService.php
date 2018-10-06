<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Service;

use Sakila\Domain\Category\Repository\CategoryRepository;
use Sakila\Domain\Category\Service\Request\RemoveCategoryRequest;

class RemoveCategoryService
{
    /**
     * @var \Sakila\Domain\Category\Repository\CategoryRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Category\Repository\CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RemoveCategoryRequest $removeCategoryRequest)
    {
        return $this->repository->remove($removeCategoryRequest->getCategoryId());
    }
}
