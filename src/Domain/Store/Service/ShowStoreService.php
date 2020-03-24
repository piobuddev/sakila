<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Service;

use Sakila\Domain\Store\Entity\Transformer\StoreTransformerInterface;
use Sakila\Domain\Store\Repository\StoreRepositoryInterface;
use Sakila\Domain\Store\Service\Request\ShowStoreRequest;
use Sakila\Transformer\TransformerInterface;

class ShowStoreService
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
    public function __construct(StoreRepositoryInterface $repository, TransformerInterface $transformer)
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
