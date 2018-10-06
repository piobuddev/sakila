<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Service;

use Sakila\Domain\Store\Entity\Transformer\StoreTransformerInterface;
use Sakila\Domain\Store\Repository\StoreRepository;
use Sakila\Domain\Store\Service\Request\ShowStoresRequest;
use Sakila\Transformer\Transformer;

class ShowStoresService
{
    /**
     * @var \Sakila\Domain\Store\Repository\StoreRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Store\Repository\StoreRepository $repository
     * @param \Sakila\Transformer\Transformer                 $transformer
     */
    public function __construct(
        StoreRepository $repository,
        Transformer $transformer
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
