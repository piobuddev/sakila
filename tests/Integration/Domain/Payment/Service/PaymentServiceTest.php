<?php

namespace Sakila\Test\Domain\Payment\Requests\Handlers;

use Sakila\Domain\Payment\Entity\Mapper\PaymentMapper;
use Sakila\Domain\Payment\Entity\Transformer\PaymentTransformerInterface;
use Sakila\Domain\Payment\Repository\PaymentRepository;
use Sakila\Domain\Payment\Service\AddPaymentService;
use Sakila\Domain\Payment\Service\Request\AddPaymentRequest;
use Sakila\Domain\Payment\Service\Request\UpdatePaymentRequest;
use Sakila\Domain\Payment\Service\UpdatePaymentService;
use Sakila\Domain\Payment\Validator\PaymentValidator;
use Sakila\Entity\EntityInterface;
use Sakila\Test\AbstractIntegrationTestCase;
use Sakila\Transformer\Transformer;

class PaymentServiceTest extends AbstractIntegrationTestCase
{
    public function testAddPayment()
    {
        $request = new AddPaymentRequest(['foo' => 'bar']);

        $validator = $this->createMock(PaymentValidator::class);
        $validator->expects($this->once())->method('validate')->with($request->getAttributes());

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(PaymentMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(PaymentRepository::class);
        $repository->expects($this->once())->method('add')->with($mapped);
        $repository->expects($this->once())->method('lastInsertedId')->willReturn(1);
        $repository->expects($this->once())->method('get')->with(1)->willReturn($entity);

        $transformer = $this->createMock(Transformer::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, PaymentTransformerInterface::class)
            ->willReturn($entity);

        $service = new AddPaymentService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }

    public function testUpdatePayment()
    {
        $paymentId = 1;
        $request = new UpdatePaymentRequest($paymentId, ['foo' => 'bar']);

        $attributes = array_merge(['payment_id' => $request->getPaymentId()], $request->getAttributes());
        $validator  = $this->createMock(PaymentValidator::class);
        $validator->expects($this->once())->method('validate')->with($attributes);

        $entity = $this->createMock(EntityInterface::class);

        $mapped = ['mapped'];
        $mapper = $this->createMock(PaymentMapper::class);
        $mapper->expects($this->once())->method('map')->with($request->getAttributes())->willReturn($mapped);

        $repository = $this->createMock(PaymentRepository::class);
        $repository
            ->expects($this->once())
            ->method('update')
            ->with($request->getPaymentId(), $mapped)
            ->willReturn($entity);

        $transformer = $this->createMock(Transformer::class);
        $transformer
            ->expects($this->once())
            ->method('item')
            ->with($entity, PaymentTransformerInterface::class)
            ->willReturn($entity);

        $service = new UpdatePaymentService($validator, $repository, $mapper, $transformer);

        $this->assertEquals($entity, $service->execute($request));
    }
}
