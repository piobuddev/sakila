<?php

namespace Sakila\Test\Domain\Store\Commands\Handlers;

use Sakila\Domain\Store\Commands\AddStoreCommand;
use Sakila\Domain\Store\Commands\Handlers\StoreHandler;
use Sakila\Domain\Store\Commands\UpdateStoreCommand;
use Sakila\Domain\Store\Entity\Mapper\StoreMapper;
use Sakila\Domain\Store\Repository\StoreRepository;
use Sakila\Domain\Store\Validator\StoreValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class StoreHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddStore()
    {
        $command = new AddStoreCommand(['foo' => 'bar']);

        $validator = $this->createMock(StoreValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new StoreMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(StoreRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new StoreHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddStore($command));
    }

    public function testUpdateStore()
    {
        $storeId = 1;
        $command = new UpdateStoreCommand($storeId, ['foo' => 'bar']);

        $attributes = array_merge(['store_id' => $command->getStoreId()], $command->getAttributes());
        $validator  = $this->createMock(StoreValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new StoreMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(StoreRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getStoreId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new StoreHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdateStore($command));
    }
}
