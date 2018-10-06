<?php declare(strict_types=1);

namespace Sakila\Domain\Inventory\Service;

use Sakila\Domain\Inventory\Entity\Transformer\InventoryTransformerInterface;
use Sakila\Domain\Inventory\Repository\InventoryRepository;
use Sakila\Domain\Inventory\Service\Request\ShowInventoryRequest;
use Sakila\Transformer\Transformer;

class ShowInventoryService
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
    public function __construct(InventoryRepository $repository, Transformer $transformer)
    {
        $this->repository  = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param \Sakila\Domain\Inventory\Service\Request\ShowInventoryRequest $showInventoryRequest
     *
     * @return mixed
     */
    public function execute(ShowInventoryRequest $showInventoryRequest)
    {
        $inventory = $this->repository->get($showInventoryRequest->getInventoryId());

        return $this->transformer->item($inventory, InventoryTransformerInterface::class);
    }
}
