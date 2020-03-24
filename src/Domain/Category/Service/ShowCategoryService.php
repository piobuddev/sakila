<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Service;

use Sakila\Domain\Category\Entity\Transformer\CategoryTransformerInterface;
use Sakila\Domain\Category\Repository\CategoryRepositoryInterface;
use Sakila\Domain\Category\Service\Request\ShowCategoryRequest;
use Sakila\Transformer\TransformerInterface;

class ShowCategoryService
{
    /**
     * @var \Sakila\Domain\Category\Repository\CategoryRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Category\Repository\CategoryRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface                       $transformer
     */
    public function __construct(CategoryRepositoryInterface $repository, TransformerInterface $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Category\Service\Request\ShowCategoryRequest $showCategoryRequest
     *
     * @return mixed
     */
    public function execute(ShowCategoryRequest $showCategoryRequest)
    {
        $category = $this->repository->get($showCategoryRequest->getCategoryId());

        return $this->transformer->item($category, CategoryTransformerInterface::class);
    }
}
