<?php declare(strict_types=1);

namespace Sakila\Domain\Inventory\Commands\Handlers;

use Sakila\Domain\Inventory\Commands\AddInventoryCommand;
use Sakila\Domain\Inventory\Commands\UpdateInventoryCommand;
use Sakila\Domain\Inventory\Entity\Mapper\InventoryMapper;
use Sakila\Domain\Inventory\Repository\InventoryRepository;
use Sakila\Domain\Inventory\Validator\InventoryValidator;
use Sakila\Entity\EntityInterface;

class InventoryHandler
{
    /**
     * @var \Sakila\Domain\Inventory\Entity\Mapper\InventoryMapper
     */
    private $inventoryMapper;

    /**
     * @var \Sakila\Domain\Inventory\Repository\InventoryRepository
     */
    private $inventoryRepository;

    /**
     * @var \Sakila\Domain\Inventory\Validator\InventoryValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\Inventory\Entity\Mapper\InventoryMapper  $mapper
     * @param \Sakila\Domain\Inventory\Repository\InventoryRepository $repository
     * @param \Sakila\Domain\Inventory\Validator\InventoryValidator   $validator
     */
    public function __construct(InventoryMapper $mapper, InventoryRepository $repository, InventoryValidator $validator)
    {
        $this->inventoryMapper     = $mapper;
        $this->inventoryRepository = $repository;
        $this->validator           = $validator;
    }

    /**
     * @param \Sakila\Domain\Inventory\Commands\AddInventoryCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleAddInventory(AddInventoryCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->inventoryRepository->add($this->inventoryMapper->map($command->getAttributes()));

        $inventoryId = $this->inventoryRepository->lastInsertedId();
        $inventory   = $this->inventoryRepository->get($inventoryId);

        return $inventory;
    }


    /**
     * @param \Sakila\Domain\Inventory\Commands\UpdateInventoryCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleUpdateInventory(UpdateInventoryCommand $command): EntityInterface
    {
        $attributes = array_merge(['inventory_id' => $command->getInventoryId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->inventoryRepository->update(
            $command->getInventoryId(),
            $this->inventoryMapper->map($command->getAttributes())
        );
    }
}
