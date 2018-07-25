<?php

namespace Sakila\Test\Domain\Address\Commands\Handlers;

use Sakila\Domain\Address\Commands\AddAddressCommand;
use Sakila\Domain\Address\Commands\Handlers\AddressHandler;
use Sakila\Domain\Address\Commands\UpdateAddressCommand;
use Sakila\Domain\Address\Entity\Mapper\AddressMapper;
use Sakila\Domain\Address\Repository\AddressRepository;
use Sakila\Domain\Address\Validator\AddressValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class AddressHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddAddress()
    {
        $command = new AddAddressCommand(['foo' => 'bar']);

        $validator = $this->createMock(AddressValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new AddressMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(AddressRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new AddressHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddAddress($command));
    }

    public function testUpdateAddress()
    {
        $addressId = 1;
        $command   = new UpdateAddressCommand($addressId, ['foo' => 'bar']);

        $attributes = array_merge(['address_id' => $command->getAddressId()], $command->getAttributes());
        $validator  = $this->createMock(AddressValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new AddressMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(AddressRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getAddressId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new AddressHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdateAddress($command));
    }
}
