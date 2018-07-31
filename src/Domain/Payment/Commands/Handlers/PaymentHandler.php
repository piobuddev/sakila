<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Commands\Handlers;

use Sakila\Domain\Payment\Commands\AddPaymentCommand;
use Sakila\Domain\Payment\Commands\UpdatePaymentCommand;
use Sakila\Domain\Payment\Entity\Mapper\PaymentMapper;
use Sakila\Domain\Payment\Repository\PaymentRepository;
use Sakila\Domain\Payment\Validator\PaymentValidator;
use Sakila\Entity\EntityInterface;

class PaymentHandler
{
    /**
     * @var \Sakila\Domain\Payment\Entity\Mapper\PaymentMapper
     */
    private $paymentMapper;

    /**
     * @var \Sakila\Domain\Payment\Repository\PaymentRepository
     */
    private $paymentRepository;

    /**
     * @var \Sakila\Domain\Payment\Validator\PaymentValidator
     */
    private $validator;

    /**
     * @param \Sakila\Domain\Payment\Entity\Mapper\PaymentMapper  $mapper
     * @param \Sakila\Domain\Payment\Repository\PaymentRepository $repository
     * @param \Sakila\Domain\Payment\Validator\PaymentValidator   $validator
     */
    public function __construct(PaymentMapper $mapper, PaymentRepository $repository, PaymentValidator $validator)
    {
        $this->paymentMapper     = $mapper;
        $this->paymentRepository = $repository;
        $this->validator         = $validator;
    }

    /**
     * @param \Sakila\Domain\Payment\Commands\AddPaymentCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleAddPayment(AddPaymentCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->paymentRepository->add($this->paymentMapper->map($command->getAttributes()));

        $paymentId = $this->paymentRepository->lastInsertedId();
        $payment   = $this->paymentRepository->get($paymentId);

        return $payment;
    }


    /**
     * @param \Sakila\Domain\Payment\Commands\UpdatePaymentCommand $command
     *
     * @return \Sakila\Entity\EntityInterface
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function handleUpdatePayment(UpdatePaymentCommand $command): EntityInterface
    {
        $attributes = array_merge(['payment_id' => $command->getPaymentId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->paymentRepository->update(
            $command->getPaymentId(),
            $this->paymentMapper->map($command->getAttributes())
        );
    }
}
