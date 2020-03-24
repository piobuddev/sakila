<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Service;

use Sakila\Domain\Store\Entity\Transformer\StoreTransformerInterface;
use Sakila\Domain\Store\Repository\StoreRepositoryInterface;
use Sakila\Domain\Store\Service\Request\ShowStoresRequest;
use Sakila\Transformer\TransformerInterface;

class ShowStoresService
{
    /**
     * @var \Sakila\Domain\Store\Repository\StoreRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Store\Repository\StoreRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface                 $transformer
     */
    public function __construct(
        StoreRepositoryInterface $repository,
        TransformerInterface $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Store\Service\Request\ShowStoresRequest $showStoresRequest
     *
     * @return mixed
     */
    public function execute(ShowStoresRequest $showStoresRequest)
    {
        $page     = $showStoresRequest->getPage();
        $pageSize = $showStoresRequest->getPageSize();
        $stores   = $this->repository->all($page, $pageSize);
        $total    = $this->repository->count();

        return $this->transformer->collection(
            $stores,
            StoreTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
