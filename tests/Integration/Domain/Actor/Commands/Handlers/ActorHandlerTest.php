<?php

namespace Sakila\Test\Domain\Actor\Commands\Handlers;

use Sakila\Domain\Actor\Commands\AddActorCommand;
use Sakila\Domain\Actor\Commands\Handlers\ActorHandler;
use Sakila\Domain\Actor\Commands\UpdateActorCommand;
use Sakila\Domain\Actor\Entity\Mapper\ActorMapper;
use Sakila\Domain\Actor\Repository\ActorRepository;
use Sakila\Domain\Actor\Validator\ActorValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class ActorHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddActor()
    {
        $command = new AddActorCommand(['foo' => 'bar']);

        $validator = $this->createMock(ActorValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new ActorMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(ActorRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new ActorHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddActor($command));
    }

    public function testUpdateActor()
    {
        $actorId = 1;
        $command = new UpdateActorCommand($actorId, ['foo' => 'bar']);

        $attributes = array_merge(['actor_id' => $command->getActorId()], $command->getAttributes());
        $validator  = $this->createMock(ActorValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new ActorMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(ActorRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getActorId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new ActorHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdateActor($command));
    }
}
