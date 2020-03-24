<?php declare(strict_types=1);

namespace Sakila\Domain\Inventory\Service;

use Sakila\Domain\Inventory\Entity\Transformer\InventoryTransformerInterface;
use Sakila\Domain\Inventory\Repository\InventoryRepositoryInterface;
use Sakila\Domain\Inventory\Service\Request\ShowInventoryRequest;
use Sakila\Transformer\TransformerInterface;

class ShowInventoryService
{
    /**
     * @var \Sakila\Domain\Inventory\Repository\InventoryRepositoryInterface
     */
    private $repository;

    /**
     * @var \Sakila\Transformer\TransformerInterface
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Inventory\Repository\InventoryRepositoryInterface $repository
     * @param \Sakila\Transformer\TransformerInterface                         $transformer
     */
    public function __construct(InventoryRepositoryInterface $repository, TransformerInterface $transformer)
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
