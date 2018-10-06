<?php declare(strict_types=1);

namespace Sakila\Domain\Category\Service;

use Sakila\Domain\Category\Entity\Transformer\CategoryTransformerInterface;
use Sakila\Domain\Category\Repository\CategoryRepository;
use Sakila\Domain\Category\Service\Request\ShowCategoriesRequest;
use Sakila\Transformer\Transformer;

class ShowCategoriesService
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
    public function __construct(
        CategoryRepository $repository,
        Transformer $transformer
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
