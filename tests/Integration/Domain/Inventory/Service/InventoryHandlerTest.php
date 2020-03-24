<?php

namespace Sakila\Test\Domain\Inventory\Requests\Handlers;

use Sakila\Domain\Inventory\Entity\Mapper\InventoryMapper;
use Sakila\Domain\Inventory\Entity\Transformer\InventoryTransformerInterface;
use Sakila\Domain\Inventory\Repository\InventoryRepositoryInterface;
use Sakila\Domain\Inventory\Service\AddInventoryService;
use Sakila\Domain\Inventory\Service\Request\AddInventoryRequest;
use Sakila\Domain\Inventory\Service\Request\UpdateInventoryRequest;
use Sakila\Domain\Inventory\Service\UpdateInventoryService;
use Sakila\Domain\Inventory\Validator\InventoryValidatorInterface;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\TransformerInterface;

class InventoryServiceTest extends AbstractIntegrationTestCase
{
    public function testAddInventory()
    {
        $request = new AddInventoryRequest(['foo' => 'bar']);

        $validator = $this->createMock(InventoryValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(InventoryMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(InventoryRepositoryInterface::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, InventoryTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddInventoryService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdateInventory()
    {
        $inventoryId = 1;
        $request = new UpdateInventoryRequest($inventoryId, ['foo' => 'bar']);

        $attributes = array_merge(['inventory_id' => $request->getInventoryId()], $request->getAttributes());
        $validator  = $this->createMock(InventoryValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(InventoryMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(InventoryRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getInventoryId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, InventoryTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdateInventoryService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
