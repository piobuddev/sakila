<?php

namespace Sakila\Test\Domain\Payment\Commands\Handlers;

use Sakila\Domain\Payment\Commands\AddPaymentCommand;
use Sakila\Domain\Payment\Commands\Handlers\PaymentHandler;
use Sakila\Domain\Payment\Commands\UpdatePaymentCommand;
use Sakila\Domain\Payment\Entity\Mapper\PaymentMapper;
use Sakila\Domain\Payment\Repository\PaymentRepository;
use Sakila\Domain\Payment\Validator\PaymentValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;

class PaymentHandlerTest extends AbstractIntegrationTestCase
{
    public function testAddPayment()
    {
        $command = new AddPaymentCommand(['foo' => 'bar']);

        $validator = $this->createMock(PaymentValidator::class);
        $validator->expects($this->once())->method('validate')->with($command->getAttributes());

        $mapper = new PaymentMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(PaymentRepository::class);
        $repository->expects($this->once())->method('add')->with($mapper->map($command->getAttributes()));
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $handler = new PaymentHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleAddPayment($command));
    }

    public function testUpdatePayment()
    {
        $paymentId = 1;
        $command   = new UpdatePaymentCommand($paymentId, ['foo' => 'bar']);

        $attributes = array_merge(['payment_id' => $command->getPaymentId()], $command->getAttributes());
        $validator  = $this->createMock(PaymentValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $mapper = new PaymentMapper();
        $entity = $this->createMock(EntityInterface::class);

        $repository = $this->createMock(PaymentRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($command->getPaymentId(), $mapper->map($command->getAttributes()))
            ->willReturn($entity);

        $handler = new PaymentHandler($mapper, $repository, $validator);

        $this->assertEquals($entity, $handler->handleUpdatePayment($command));
    }
}
