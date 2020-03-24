<?php

namespace Sakila\Test\Domain\Store\Requests\Handlers;

use Sakila\Domain\Store\Entity\Mapper\StoreMapper;
use Sakila\Domain\Store\Entity\Transformer\StoreTransformerInterface;
use Sakila\Domain\Store\Repository\StoreRepositoryInterface;
use Sakila\Domain\Store\Service\AddStoreService;
use Sakila\Domain\Store\Service\Request\AddStoreRequest;
use Sakila\Domain\Store\Service\Request\UpdateStoreRequest;
use Sakila\Domain\Store\Service\UpdateStoreService;
use Sakila\Domain\Store\Validator\StoreValidatorInterface;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\TransformerInterface;

class StoreServiceTest extends AbstractIntegrationTestCase
{
    public function testAddStore()
    {
        $request = new AddStoreRequest(['foo' => 'bar']);

        $validator = $this->createMock(StoreValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(StoreMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(StoreRepositoryInterface::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, StoreTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddStoreService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdateStore()
    {
        $storeId = 1;
        $request = new UpdateStoreRequest($storeId, ['foo' => 'bar']);

        $attributes = array_merge(['store_id' => $request->getStoreId()], $request->getAttributes());
        $validator  = $this->createMock(StoreValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(StoreMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(StoreRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getStoreId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, StoreTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdateStoreService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
