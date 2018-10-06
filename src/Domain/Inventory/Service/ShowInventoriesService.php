<?php declare(strict_types=1);

namespace Sakila\Domain\Inventory\Service;

use Sakila\Domain\Inventory\Entity\Transformer\InventoryTransformerInterface;
use Sakila\Domain\Inventory\Repository\InventoryRepository;
use Sakila\Domain\Inventory\Service\Request\ShowInventoriesRequest;
use Sakila\Transformer\Transformer;

class ShowInventoriesService
{
    /**
     * @var \Sakila\Domain\Inventory\Repository\InventoryRepository
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Inventory\Repository\InventoryRepository $repository
     * @param \Sakila\Transformer\Transformer                         $transformer
     */
    public function __construct(
        InventoryRepository $repository,
        Transformer $transformer
    ) {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Inventory\Service\Request\ShowInventoriesRequest $showInventoriesRequest
     *
     * @return mixed
     */
    public function execute(ShowInventoriesRequest $showInventoriesRequest)
    {
        $page        = $showInventoriesRequest->getPage();
        $pageSize    = $showInventoriesRequest->getPageSize();
        $inventories = $this->repository->all($page, $pageSize);
        $total       = $this->repository->count();

        return $this->transformer->collection(
            $inventories,
            InventoryTransformerInterface::class,
            $page,
            $pageSize,
            $total
        );
    }
}
