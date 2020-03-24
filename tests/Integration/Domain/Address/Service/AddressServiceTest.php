<?php

namespace Sakila\Test\Domain\Address\Commands\Handlers;

use Sakila\Domain\Address\Entity\Mapper\AddressMapper;
use Sakila\Domain\Address\Entity\Transformer\AddressTransformerInterface;
use Sakila\Domain\Address\Repository\AddressRepositoryInterface;
use Sakila\Domain\Address\Service\AddAddressService;
use Sakila\Domain\Address\Service\Request\AddAddressRequest;
use Sakila\Domain\Address\Service\Request\UpdateAddressRequest;
use Sakila\Domain\Address\Service\UpdateAddressService;
use Sakila\Domain\Address\Validator\AddressValidatorInterface;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\TransformerInterface;

class AddressServiceTest extends AbstractIntegrationTestCase
{
    public function testAddAddress()
    {
        $request = new AddAddressRequest(['foo' => 'bar']);

        $validator = $this->createMock(AddressValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(AddressMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(AddressRepositoryInterface::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, AddressTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddAddressService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdateAddress()
    {
        $addressId = 1;
        $request   = new UpdateAddressRequest($addressId, ['foo' => 'bar']);

        $attributes = array_merge(['address_id' => $request->getAddressId()], $request->getAttributes());
        $validator  = $this->createMock(AddressValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(AddressMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(AddressRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getAddressId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, AddressTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdateAddressService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
