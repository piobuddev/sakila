<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Service;

use Sakila\Domain\Store\Entity\Transformer\StoreTransformerInterface;
use Sakila\Domain\Store\Repository\StoreRepository;
use Sakila\Domain\Store\Service\Request\ShowStoreRequest;
use Sakila\Transformer\Transformer;

class ShowStoreService
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
    public function __construct(StoreRepository $repository, Transformer $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Store\Service\Request\ShowStoreRequest $showStoreRequest
     *
     * @return mixed
     */
    public function execute(ShowStoreRequest $showStoreRequest)
    {
        $store = $this->repository->get($showStoreRequest->getStoreId());

        return $this->transformer->item($store, StoreTransformerInterface::class);
    }
}
