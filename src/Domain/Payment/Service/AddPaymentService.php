<?php declare(strict_types=1);

namespace Sakila\Domain\Payment\Service;

use Sakila\Domain\Payment\Entity\Mapper\PaymentMapper;
use Sakila\Domain\Payment\Entity\Transformer\PaymentTransformerInterface;
use Sakila\Domain\Payment\Repository\PaymentRepository;
use Sakila\Domain\Payment\Service\Request\AddPaymentRequest;
use Sakila\Domain\Payment\Validator\PaymentValidator;
use Sakila\Transformer\Transformer;

class AddPaymentService
{
    /**
     * @var \Sakila\Domain\Payment\Validator\PaymentValidator
     */
    private $validator;

    /**
     * @var \Sakila\Domain\Payment\Repository\PaymentRepository
     */
    private $paymentRepository;

    /**
     * @var \Sakila\Domain\Payment\Entity\Mapper\PaymentMapper
     */
    private $paymentMapper;

    /**
     * @var \Sakila\Transformer\Transformer
     */
    private $transformer;

    /**
     * @param \Sakila\Domain\Payment\Validator\PaymentValidator   $validator
     * @param \Sakila\Domain\Payment\Repository\PaymentRepository $repository
     * @param \Sakila\Domain\Payment\Entity\Mapper\PaymentMapper  $paymentMapper
     * @param \Sakila\Transformer\Transformer                     $transformer
     */
    public function __construct(
        PaymentValidator $validator,
        PaymentRepository $repository,
        PaymentMapper $paymentMapper,
        Transformer $transformer
    ) {
        $this->validator         = $validator;
        $this->paymentRepository = $repository;
        $this->paymentMapper     = $paymentMapper;
        $this->transformer       = $transformer;
    }

    /**
     * @param \Sakila\Domain\Payment\Service\Request\AddPaymentRequest $addPaymentRequest
     *
     * @return mixed
     * @throws \Sakila\Exceptions\Validation\ValidationException
     */
    public function execute(AddPaymentRequest $addPaymentRequest)
    {
        $this->validator->validate($addPaymentRequest->getAttributes());
        $this->paymentRepository->add($this->paymentMapper->map($addPaymentRequest->getAttributes()));

        $paymentId = $this->paymentRepository->lastInsertedId();
        $payment   = $this->paymentRepository->get($paymentId);

        return $this->transformer->item($payment, PaymentTransformerInterface::class);
    }
}
