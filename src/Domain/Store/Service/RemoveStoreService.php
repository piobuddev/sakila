<?php declare(strict_types=1);

namespace Sakila\Domain\Store\Service;

use Sakila\Domain\Store\Repository\StoreRepositoryInterface;
use Sakila\Domain\Store\Service\Request\RemoveStoreRequest;

class RemoveStoreService
{
    /**
     * @var \Sakila\Domain\Store\Repository\StoreRepositoryInterface
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Store\Repository\StoreRepositoryInterface $repository
     */
    public function __construct(StoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Sakila\Domain\Store\Service\Request\RemoveStoreRequest $removeStoreRequest
     *
     * @return bool
     */
    public function execute(RemoveStoreRequest $removeStoreRequest): bool
    {
        return $this->repository->remove($removeStoreRequest->getStoreId());
    }
}
