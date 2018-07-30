<?php

namespace Sakila\Test\Domain\Rental\Commands\Handlers;

use Sakila\Domain\Rental\Commands\AddRentalCommand;
use Sakila\Domain\Rental\Commands\Handlers\RentalHandler;
use Sakila\Domain\Rental\Commands\UpdateRentalCommand;
use Sakila\Domain\Rental\Entity\Mapper\RentalMapper;
use Sakila\Domain\Rental\Repository\RentalRepository;
use Sakila\Domain\Rental\Validator\RentalValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class RentalHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddRental()
    {
        $command = new AddRentalCommand(['foo' => 'bar']);

        $validator = $this->createMock(RentalValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new RentalMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(RentalRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new RentalHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddRental($command));
    }

    public function testUpdateRental()
    {
        $rentalId = 1;
        $command  = new UpdateRentalCommand($rentalId, ['foo' => 'bar']);

        $attributes = array_merge(['rental_id' => $command->getRentalId()], $command->getAttributes());
        $validator  = $this->createMock(RentalValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new RentalMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(RentalRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getRentalId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new RentalHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdateRental($command));
    }
}
