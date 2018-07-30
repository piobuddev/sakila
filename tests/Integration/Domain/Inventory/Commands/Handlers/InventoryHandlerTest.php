<?php

namespace Sakila\Test\Domain\Inventory\Commands\Handlers;

use Sakila\Domain\Inventory\Commands\AddInventoryCommand;
use Sakila\Domain\Inventory\Commands\Handlers\InventoryHandler;
use Sakila\Domain\Inventory\Commands\UpdateInventoryCommand;
use Sakila\Domain\Inventory\Entity\Mapper\InventoryMapper;
use Sakila\Domain\Inventory\Repository\InventoryRepository;
use Sakila\Domain\Inventory\Validator\InventoryValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class InventoryHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddInventory()
    {
        $command = new AddInventoryCommand(['foo' => 'bar']);

        $validator = $this->createMock(InventoryValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new InventoryMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(InventoryRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new InventoryHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddInventory($command));
    }

    public function testUpdateInventory()
    {
        $inventoryId = 1;
        $command     = new UpdateInventoryCommand($inventoryId, ['foo' => 'bar']);

        $attributes = array_merge(['inventory_id' => $command->getInventoryId()], $command->getAttributes());
        $validator  = $this->createMock(InventoryValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new InventoryMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(InventoryRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getInventoryId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new InventoryHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdateInventory($command));
    }
}
