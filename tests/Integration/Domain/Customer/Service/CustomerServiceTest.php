<?php

namespace Sakila\Test\Domain\Customer\Requests\Handlers;

use Sakila\Domain\Customer\Entity\Mapper\CustomerMapper;
use Sakila\Domain\Customer\Entity\Transformer\CustomerTransformerInterface;
use Sakila\Domain\Customer\Repository\CustomerRepositoryInterface;
use Sakila\Domain\Customer\Service\AddCustomerService;
use Sakila\Domain\Customer\Service\Request\AddCustomerRequest;
use Sakila\Domain\Customer\Service\Request\UpdateCustomerRequest;
use Sakila\Domain\Customer\Service\UpdateCustomerService;
use Sakila\Domain\Customer\Validator\CustomerValidatorInterface;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\TransformerInterface;

class CustomerServiceTest extends AbstractIntegrationTestCase
{
    public function testAddCustomer()
    {
        $request = new AddCustomerRequest(['foo' => 'bar']);

        $validator = $this->createMock(CustomerValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(CustomerMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(CustomerRepositoryInterface::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, CustomerTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddCustomerService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdateCustomer()
    {
        $customerId = 1;
        $request = new UpdateCustomerRequest($customerId, ['foo' => 'bar']);

        $attributes = array_merge(['customer_id' => $request->getCustomerId()], $request->getAttributes());
        $validator  = $this->createMock(CustomerValidatorInterface::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(CustomerMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(CustomerRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getCustomerId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(TransformerInterface::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, CustomerTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdateCustomerService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
