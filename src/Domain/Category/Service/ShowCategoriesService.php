<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Service;

use Sakila\Domain\Category\Entity\Transformer\CategoryTransformerInterface;
use Sakila\Domain\Category\Repository\CategoryRepositoryInterface;
use Sakila\Domain\Category\Service\Request\ShowCategoriesRequest;
use Sakila\Transformer\TransformerInterface;

class ShowCategoriesService
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
    public function __construct(
        CategoryRepositoryInterface $repository,
        TransformerInterface $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Category\Service\Request\ShowCategoriesRequest $showCategoriesRequest
     *
     * @return mixed
     */
    public function execute(ShowCategoriesRequest $showCategoriesRequest)
    {
        $page       = $showCategoriesRequest->getPage();
        $pageSize   = $showCategoriesRequest->getPageSize();
        $categories = $this->repository->all($page, $pageSize);
        $total      = $this->repository->count();

        return $this->transformer->collection(
            $categories,
            CategoryTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
