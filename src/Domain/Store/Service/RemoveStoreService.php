<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Service;

use Sakila\Domain\Store\Repository\StoreRepository;
use Sakila\Domain\Store\Service\Request\RemoveStoreRequest;

class RemoveStoreService
{
    /**
     * @var \Sakila\Domain\Store\Repository\StoreRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Store\Repository\StoreRepository $repository
     */
    public function __construct(StoreRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RemoveStoreRequest $removeStoreRequest)
    {
        return $this->repository->remove($removeStoreRequest->getStoreId());
    }
}
