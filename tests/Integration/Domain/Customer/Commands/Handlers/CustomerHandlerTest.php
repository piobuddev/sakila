<?php

namespace Sakila\Test\Domain\Customer\Commands\Handlers;

use Sakila\Domain\Customer\Commands\AddCustomerCommand;
use Sakila\Domain\Customer\Commands\Handlers\CustomerHandler;
use Sakila\Domain\Customer\Commands\UpdateCustomerCommand;
use Sakila\Domain\Customer\Entity\Mapper\CustomerMapper;
use Sakila\Domain\Customer\Repository\CustomerRepository;
use Sakila\Domain\Customer\Validator\CustomerValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class CustomerHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddCustomer()
    {
        $command = new AddCustomerCommand(['foo' => 'bar']);

        $validator = $this->createMock(CustomerValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new CustomerMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(CustomerRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new CustomerHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddCustomer($command));
    }

    public function testUpdateCustomer()
    {
        $customerId = 1;
        $command    = new UpdateCustomerCommand($customerId, ['foo' => 'bar']);

        $attributes = array_merge(['customer_id' => $command->getCustomerId()], $command->getAttributes());
        $validator  = $this->createMock(CustomerValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new CustomerMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(CustomerRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getCustomerId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new CustomerHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdateCustomer($command));
    }
}
