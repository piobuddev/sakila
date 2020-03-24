<?php

namespace Sakila\Test\Domain\Rental\Requests\Handlers;

use Sakila\Domain\Rental\Entity\Mapper\RentalMapper;
use Sakila\Domain\Rental\Entity\Transformer\RentalTransformerInterface;
use Sakila\Domain\Rental\Repository\RentalRepositoryInterface;
use Sakila\Domain\Rental\Service\AddRentalService;
use Sakila\Domain\Rental\Service\Request\AddRentalRequest;
use Sakila\Domain\Rental\Service\Request\UpdateRentalRequest;
use Sakila\Domain\Rental\Service\UpdateRentalService;
use Sakila\Domain\Rental\Validator\RentalValidatorInterface;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\TransformerInterface;

class RentalServiceTest extends AbstractIntegrationTestCase
{
    public function testAddRental()
    {
        $request = new AddRentalRequest(['foo' => 'bar']);

        $validator = $this->createMock(RentalValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(RentalMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(RentalRepositoryInterface::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, RentalTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddRentalService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdateRental()
    {
        $rentalId = 1;
        $request = new UpdateRentalRequest($rentalId, ['foo' => 'bar']);

        $attributes = array_merge(['rental_id' => $request->getRentalId()], $request->getAttributes());
        $validator  = $this->createMock(RentalValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(RentalMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(RentalRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getRentalId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, RentalTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdateRentalService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
