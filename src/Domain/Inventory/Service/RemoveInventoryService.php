<?php declare(strict_types=1);

namespace Sakila\Domain\Inventory\Service;

use Sakila\Domain\Inventory\Repository\InventoryRepository;
use Sakila\Domain\Inventory\Service\Request\RemoveInventoryRequest;

class RemoveInventoryService
{
    /**
     * @var \Sakila\Domain\Inventory\Repository\InventoryRepository
     */
    private $repository;

    /**
     * @param \Sakila\Domain\Inventory\Repository\InventoryRepository $repository
     */
    public function __construct(InventoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Sakila\Domain\Inventory\Service\Request\RemoveInventoryRequest $removeInventoryRequest
     *
     * @return bool
     */
    public function execute(RemoveInventoryRequest $removeInventoryRequest): bool
    {
        return $this->repository->remove($removeInventoryRequest->getInventoryId());
    }
}
