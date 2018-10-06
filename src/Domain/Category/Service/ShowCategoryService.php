<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Service;

use Sakila\Domain\Category\Entity\Transformer\CategoryTransformerInterface;
use Sakila\Domain\Category\Repository\CategoryRepository;
use Sakila\Domain\Category\Service\Request\ShowCategoryRequest;
use Sakila\Transformer\Transformer;

class ShowCategoryService
{
    /**
     * @var \Sakila\Domain\Category\Repository\CategoryRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Category\Repository\CategoryRepository $repository
     * @param \Sakila\Transformer\Transformer                       $transformer
     */
    public function __construct(CategoryRepository $repository, Transformer $transformer)
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
