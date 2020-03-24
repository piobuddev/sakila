<?php

namespace Sakila\Test\Domain\Actor\Requests\Handlers;

use Sakila\Domain\Actor\Entity\Mapper\ActorMapper;
use Sakila\Domain\Actor\Entity\Transformer\ActorTransformerInterface;
use Sakila\Domain\Actor\Repository\ActorRepositoryInterface;
use Sakila\Domain\Actor\Service\AddActorService;
use Sakila\Domain\Actor\Service\Request\AddActorRequest;
use Sakila\Domain\Actor\Service\Request\UpdateActorRequest;
use Sakila\Domain\Actor\Service\UpdateActorService;
use Sakila\Domain\Actor\Validator\ActorValidatorInterface;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\TransformerInterface;

class ActorServiceTest extends AbstractIntegrationTestCase
{
    public function testAddActor()
    {
        $request = new AddActorRequest(['foo' => 'bar']);

        $validator = $this->createMock(ActorValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(ActorMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(ActorRepositoryInterface::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, ActorTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddActorService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdateActor()
    {
        $actorId = 1;
        $request = new UpdateActorRequest($actorId, ['foo' => 'bar']);

        $attributes = array_merge(['actor_id' => $request->getActorId()], $request->getAttributes());
        $validator  = $this->createMock(ActorValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(ActorMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(ActorRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getActorId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, ActorTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdateActorService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
